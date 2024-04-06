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
}
