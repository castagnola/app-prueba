<?php

namespace App\Http\Controllers\CustomController;

use App\Models\Owner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OwnersController extends Controller
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
        return Owner::with('city')->paginate(5);
    }

    }
