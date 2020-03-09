<?php

namespace App\Http\Controllers\CustomController;

use App\Models\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoutesController extends Controller
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
        return Route::with('startingCity','destinationCity')->paginate(5);
    }
}
