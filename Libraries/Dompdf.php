<?php

namespace App\Libraries;

use Dompdf\Dompdf as DompdfCore;
use Dompdf\Options;

class Dompdf
{
    protected $dompdf;

    public function __construct()
    {
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true); // jika butuh ambil gambar dari url
        $this->dompdf = new DompdfCore($options);
    }

    public function loadHtml($html)
    {
        $this->dompdf->loadHtml($html);
    }

    public function setPaper($size = 'A4', $orientation = 'portrait')
    {
        $this->dompdf->setPaper($size, $orientation);
    }

    public function render()
    {
        $this->dompdf->render();
    }

    public function stream($filename = 'document.pdf', $attachment = true)
    {
        $this->dompdf->stream($filename, ["Attachment" => $attachment]);
    }

    public function output()
    {
        return $this->dompdf->output();
    }
}
