<?php

namespace App\Http\Controllers\ResourceController;

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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Driver::where('status','=',1);
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
            'identification_number' => 'required|string|max:10',
            'first_name' => 'required|string|max:50',
            'second_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'address' => 'required|string|max:50',
            'phone_number' => 'required|max:10',
            'city_id' => 'required',
        ]);
        try {
            $driver = new Driver();
            $driver->identification_number = $request->identification_number;
            $driver->first_name = $request->first_name;
            $driver->second_name = $request->second_name;
            $driver->last_name = $request->last_name;
            $driver->address = $request->address;
            $driver->phone_number = $request->phone_number;
            $driver->city_id = $request->city_id;
            $driver->status = 1;
            $driver->save();

            return response()->json(['message' => 'Driver: ' . $driver->first_name . ' ' . $driver->last_name . ', Created in successfully.'], 200);

        } catch (\Exception $e) {
            return response()->json(['code'=>0001,'message' => 'There was something wronge.','description'=>$e->getMessage()], 500);


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
        return Driver::with('city')->find($id);
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

            $driver = Driver::with('city')->find($id);
            $driver->status = 1;
            $driver->update();

            return response()->json(['message' => 'Driver: ' . $driver->first_name . ' ' . $driver->last_name . ', has been actived.', 'data' => $driver], 200);

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
            'identification_number' => 'required|max:10',
            'first_name' => 'required|string|max:50',
            'second_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'address' => 'required|string|max:50',
            'phone_number' => 'required|max:10',
            'city_id' => 'required'
        ]);
        try {
            $driver = Driver::find($id);
            $driver->identification_number = $request->identification_number;
            $driver->first_name = $request->first_name;
            $driver->second_name = $request->second_name;
            $driver->last_name = $request->last_name;
            $driver->address = $request->address;
            $driver->phone_number = $request->phone_number;
            $driver->city_id = $request->city_id;
            $driver->update();

            $data = Driver::with('city')->find($id);
            return response()->json(['message' => 'Driver: ' . $driver->first_name . ' ' . $driver->last_name . ', has been updated.', 'data' => $data], 200);


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

            $driver = Driver::with('city')->find($id);
            $driver->status = 0;
            $driver->update();

            return response()->json(['message' => 'City has been deleted.', 'data' => $driver], 200);

        } catch (\Exception $e) {
            return response()->json(['code'=>'0001','message' => 'There was something wronge.','description'=>$e->getMessage()], 500);
        }

    }
}
