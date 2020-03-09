<?php

namespace App\Http\Controllers\CustomController;

use App\Models\Driver;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DriversController extends Controller
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

        return Driver::with('city')->paginate(5);
    }
}
