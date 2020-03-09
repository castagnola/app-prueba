<?php

namespace App\Http\Controllers\PdfController;

use App\Models\Driver;
use App\Models\Owner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DowloadPdfController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }

    public function driverPdfDowload()
    {
        $query = Driver::with('city')->get();
        $pdf = \PDF::LoadView('pdf.driverPdf',compact('query'));
        return $pdf->download();
    }

    public function ownerPdfDowload()
    {
        $query = Owner::with('city','vehicle')->get();
        $pdf = \PDF::LoadView('pdf.ownerPdf',compact('query'));
        return $pdf->download();
    }
}
