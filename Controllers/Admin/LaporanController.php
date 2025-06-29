<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TransactionModel;
use App\Libraries\Dompdf;

class LaporanController extends BaseController
{
    public function laporanGlobal()
    {
        $model = new TransactionModel();
        $data['penjualan'] = $model->findAll();
        return view('admin/v_laporan_global', $data);
    }

    public function exportGlobalPdf()
    {
        $model = new TransactionModel();
        $data['penjualan'] = $model->findAll();

        $dompdf = new Dompdf();
        $html = view('admin/pdf_laporan_global', $data); // buat view ini juga nanti
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream("laporan_penjualan_global.pdf", ["Attachment" => false]);
    }

    public function exportGlobalExcel()
{
    $model = new TransactionModel();
    $penjualan = $model->findAll();

    // Set header untuk Excel
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=laporan_penjualan_global.xls");
    header("Cache-Control: max-age=0");

    // Tampilkan view sebagai isi file Excel
    echo view('admin/excel_laporan_global', ['penjualan' => $penjualan]);

    // Hentikan eksekusi agar tidak ada output tambahan
    exit(); // ✅ INI PENTING
}

}
