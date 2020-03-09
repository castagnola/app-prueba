<?php

namespace App\Http\Controllers\ResourceController;

use App\Models\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoutesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'starting_city_id' => 'required',
            'destination_city_id' => 'required',
            'tipe_route' => 'required',
        ]);
        try {
            $route = new Route();
            $route->starting_city_id = $request->starting_city_id;
            $route->destination_city_id = $request->destination_city_id;
            $route->tipe_route = $request->tipe_route;
            $route->save();
            return response()->json(['message' => 'Route: ' . $route->startingCity->city_name . ' to ' . $route->destinationCity->city_name . ', Created in successfully.'], 200);

        } catch (\Exception $e) {
            return response()->json(['code'=>0001,'message' => 'There was something wronge.','description'=>$e->getMessage()], 500);

        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'starting_city_id' => 'required',
            'destination_city_id' => 'required',
            'tipe_route' => 'required',
        ]);
        try {
            $route = Route::find($id);
            $route->starting_city_id = $request->starting_city_id;
            $route->destination_city_id = $request->destination_city_id;
            $route->tipe_route = $request->tipe_route;
            $route->update();
            $data = Route::with('startingCity','destinationCity')->find($id);
            return response()->json(['message' => 'Route: ' . $route->startingCity->city_name . ' to ' . $route->destinationCity->city_name . ', has been updated', 'data' => $data], 200);

        } catch (\Exception $e) {
            return response()->json(['code'=>0001,'message' => 'There was something wronge.','description'=>$e->getMessage()], 500);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
