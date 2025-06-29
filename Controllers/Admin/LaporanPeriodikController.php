<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;
use App\Models\LaporanModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


use Dompdf\Dompdf;

class LaporanPeriodikController extends BaseController
{
    protected $transaksiModel;
    protected $detailModel;

    public function __construct()
    {
        $this->transaksiModel = new TransactionModel();
        $this->detailModel = new TransactionDetailModel();
    }

    public function index()
    {
        return view('admin/v_laporan_periodik', [
            'laporan' => [], // Kosongkan dulu
            'tanggal_awal' => '',
            'tanggal_akhir' => ''
        ]);
    }

    public function filter()
    {
        $tanggal_awal = $this->request->getPost('tanggal_awal');
        $tanggal_akhir = $this->request->getPost('tanggal_akhir');

        // Validasi tanggal kosong
        if (!$tanggal_awal || !$tanggal_akhir) {
            return redirect()->back()->with('error', 'Tanggal awal dan akhir wajib diisi.');
        }

        $data = $this->transaksiModel
            ->where('created_at >=', $tanggal_awal)
            ->where('created_at <=', $tanggal_akhir)
            ->findAll();

        return view('admin/v_laporan_periodik', [
            'laporan' => $data,
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir
        ]);
    }

    public function export_pdf()
    {
        $awal = $this->request->getGet('tanggal_awal');
        $akhir = $this->request->getGet('tanggal_akhir');

        $data = $this->transaksiModel
            ->where('created_at >=', $awal)
            ->where('created_at <=', $akhir)
            ->findAll();

        foreach ($data as &$row) {
            $jumlah = $this->detailModel
                ->where('transaction_id', $row['id']) // pastikan ini kolom foreign key di detail
                ->selectSum('jumlah')
                ->first();

            $row['jumlah_barang'] = $jumlah['jumlah'] ?? 0;
        }

        $html = view('admin/v_laporan_periodik_pdf', [
            'laporan' => $data,
            'awal' => $awal,
            'akhir' => $akhir
        ]);

        // Cetak PDF
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->render();
        $dompdf->stream('laporan_periodik.pdf', ['Attachment' => false]);
    }


    public function export_excel()
    {
        $awal = $this->request->getGet('tanggal_awal');
        $akhir = $this->request->getGet('tanggal_akhir');

        $data = $this->transaksiModel
            ->select('*')
            ->where('created_at >=', $awal)
            ->where('created_at <=', $akhir)
            ->findAll();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header kolom
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Tanggal');
        $sheet->setCellValue('C1', 'Konsumen');
        $sheet->setCellValue('D1', 'Jumlah Barang'); // Tambahkan kolom
        $sheet->setCellValue('E1', 'Total');
        $sheet->setCellValue('F1', 'Status');


        // Mulai dari baris 2
        $row = 2;
        $no = 1;

        foreach ($data as $d) {
            $jumlah = $this->detailModel
                ->where('transaction_id', $d['id'])
                ->selectSum('jumlah')
                ->first();

            $d['jumlah_barang'] = $jumlah['jumlah'] ?? 0;

            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $d['created_at']);
            $sheet->setCellValue('C' . $row, $d['username']);
            $sheet->setCellValue('D' . $row, $d['jumlah_barang']); // Tambahkan ini
            $sheet->setCellValue('E' . $row, $d['total_harga']);


            // Status dinamis
            $status = 'Menunggu Pembayaran';
            if ($d['status_bayar'] === 'lunas' && $d['status_kirim'] === 'sampai') {
                $status = 'Selesai';
            } elseif ($d['status_bayar'] === 'lunas') {
                $status = 'Diproses';
            } elseif ($d['status_kirim'] === 'sampai') {
                $status = 'Dikirim (Belum Dibayar)';
            }

            $sheet->setCellValue('F' . $row, $status);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Laporan_Penjualan_Periodik.xlsx';

        // Output Excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit();
    }
}
