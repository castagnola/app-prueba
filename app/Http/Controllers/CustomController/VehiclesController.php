<?php

namespace App\Http\Controllers\CustomController;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VehiclesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');

    }
    /**
     * Paginate list
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index(){
        return Vehicle::with('owner','tipeVehicle')->paginate(5);
    }


}
