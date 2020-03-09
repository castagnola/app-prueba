<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    function imprimir(){
        $query = Vehicle::with('driver','owner')->get();
        $pdf = \PDF::loadView('pdf',compact('query'));
        return $pdf->download('pdf.pdf');
    }
}
