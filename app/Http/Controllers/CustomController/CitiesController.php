<?php

namespace App\Http\Controllers\CustomController;

use App\Models\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CitiesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');

    }

    /**
     * Paginate list
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index()
    {

        return City::with('departament')->paginate(5);
    }


}
