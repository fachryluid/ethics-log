<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Violation;

class DownloadController extends Controller
{
    public function surat_panggilan(Violation $violation)
    {
        $Pdf = Pdf::loadView('exports.surat.panggilan', compact('violation'));

        return $Pdf->stream();
        // return $Pdf->download('Surat-Panggilan-' . $violation->uuid . '.pdf');
    }

    public function surat_permohonan_maaf(Violation $violation)
    {
        $Pdf = Pdf::loadView('exports.surat.permohonan-maaf', compact('violation'));

        return $Pdf->stream();
    }

    public function surat_penyesalan(Violation $violation)
    {
        $Pdf = Pdf::loadView('exports.surat.penyesalan', compact('violation'));

        return $Pdf->stream();
    }
}
