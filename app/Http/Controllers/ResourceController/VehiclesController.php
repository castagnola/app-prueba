<?php

namespace App\Http\Controllers\ResourceController;

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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Vehicle::all();
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'color' => 'required',
            'placa' => 'required',
            'tipe_id' => 'required',
            'owner_id' => 'required',
            'brand' => 'required',
        ]);
        try {
            $vehicle = new Vehicle();
            $vehicle->color = $request->color;
            $vehicle->placa = $request->placa;
            $vehicle->tipe_id = $request->tipe_id;
            $vehicle->brand = $request->brand;
            $vehicle->owner_id = $request->owner_id;
            $vehicle->save();

            return response()->json(['message' => 'Vehicle: ' . $vehicle->placa . ', Created in successfully.'], 201);

        } catch (\Exception $e) {
            return response()->json(['code'=>'0001','message' => 'There was something wronge.','description'=>$e->getMessage()], 500);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $vehicle = Vehicle::with('owner', 'tipeVehicle')->find($id);
            $vehicle->status = 1;
            $vehicle->update();

            return response()->json(['message' => 'Vehicle: ' . $vehicle->placa . ', Created in successfully.', 'data' => $vehicle], 200);

        } catch (\Exception $e) {
            return response()->json(['code'=>'0001','message' => 'There was something wronge.','description'=>$e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'color' => 'required',
            'placa' => 'required',
            'tipe_id' => 'required',
            'owner_id' => 'required',
            'brand' => 'required',
        ]);

        try {

            $vehicle = Vehicle::find($id);
            $vehicle->color = $request->color;
            $vehicle->placa = $request->placa;
            $vehicle->tipe_id = $request->tipe_id;
            $vehicle->brand = $request->brand;
            $vehicle->owner_id = $request->owner_id;
            $vehicle->update();
            $data = Vehicle::with('owner','tipeVehicle')->find($id);
            return response()->json(['message' => 'Vehicle: ' . $vehicle->placa . ', has been updated.', 'data' => $data], 200);

        } catch (\Exception $e) {
            return response()->json(['code'=>'0001','message' => 'There was something wronge.','description'=>$e->getMessage()], 500);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $vehicle = Vehicle::with('owner','tipeVehicle')->find($id);
            // delete soft
            $vehicle->status = 0;
            $vehicle->update();
            return response()->json(['message' => 'Vehicle has been deleted.', 'data' => $vehicle], 200);

        } catch (\Exception $e) {
            return response()->json(['code'=>'0001','message' => 'There was something wronge.','description'=>$e->getMessage()], 500);

        }
    }
}
