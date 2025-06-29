<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TransactionModel;
use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LaporanPendapatanPdfController extends BaseController
{
    public function pendapatanPdf()
    {
        $awal = $this->request->getGet('awal');
        $akhir = $this->request->getGet('akhir');

        $model = new TransactionModel();
        $detailModel = new \App\Models\TransactionDetailModel(); // Tambahkan ini

        $data['data'] = $model
            ->select('*, DATE(created_at) as tanggal')
            ->where('status_bayar', 'lunas')
            ->where('created_at >=', $awal)
            ->where('created_at <=', $akhir)
            ->findAll();

        // Hitung laba
        $laba = 0;
        foreach ($data['data'] as $trx) {
            $details = $detailModel
                ->select('transaction_detail.*, product.harga, product.modal')
                ->join('product', 'product.id = transaction_detail.product_id')
                ->where('transaction_id', $trx['id'])
                ->findAll();
            foreach ($details as $detail) {
                $laba += ($detail['harga'] - $detail['modal']) * $detail['jumlah'];
            }
        }
        $data['laba'] = $laba;

        $html = view('admin/v_laporan_pendapatan_pdf', $data);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream('laporan_pendapatan.pdf', false);
    }


    public function pendapatanExcel()
    {
        $awal = $this->request->getGet('awal');
        $akhir = $this->request->getGet('akhir');

        $transactionModel = new \App\Models\TransactionModel();
        $detailModel = new \App\Models\TransactionDetailModel();

        $data = $transactionModel
            ->where('status_bayar', 'lunas')
            ->where('created_at >=', $awal)
            ->where('created_at <=', $akhir)
            ->findAll();

        // Hitung laba
        $laba = 0;
        foreach ($data as $trx) {
            $details = $detailModel
                ->select('transaction_detail.*, product.harga, product.modal')
                ->join('product', 'product.id = transaction_detail.product_id')
                ->where('transaction_id', $trx['id'])
                ->findAll();

            foreach ($details as $detail) {
                $laba += ($detail['harga'] - $detail['modal']) * $detail['jumlah'];
            }
        }

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Laporan Pendapatan');

        // Header kolom
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Tanggal');
        $sheet->setCellValue('C1', 'Username');
        $sheet->setCellValue('D1', 'Total Harga');

        // Isi data
        $rowNum = 2;
        $no = 1;
        $total = 0;
        foreach ($data as $row) {
            $sheet->setCellValue('A' . $rowNum, $no++);
            $sheet->setCellValue('B' . $rowNum, $row['created_at']);
            $sheet->setCellValue('C' . $rowNum, $row['username']);
            $sheet->setCellValue('D' . $rowNum, $row['total_harga']);
            $total += $row['total_harga'];
            $rowNum++;
        }

        // Total Pendapatan
        $sheet->setCellValue('C' . $rowNum, 'Total Pendapatan');
        $sheet->setCellValue('D' . $rowNum, $total);
        $rowNum++;

        // Total Laba
        $sheet->setCellValue('C' . $rowNum, 'Total Laba');
        $sheet->setCellValue('D' . $rowNum, $laba);

        // Export
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename = 'laporan_pendapatan_' . date('YmdHis') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit();
    }
}
