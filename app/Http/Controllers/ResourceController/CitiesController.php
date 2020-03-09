<?php

namespace App\Http\Controllers\ResourceController;

use App\Models\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CitiesController extends Controller
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
        return City::where('status', '=', 1)
            ->with('departament')
            ->get();
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
            'city_name' => 'required|string',
            'departament_id' => 'required',
        ]);
        try {
            $city = new City();
            $city->city_name = $request->city_name;
            $city->departament_id = $request->departament_id;
            $city->status = 1;
            $city->save();

            return response()->json(['message' => 'City: ' . $city->city_name . ' Created in successfully.'], 201);

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
        $city = City::with('departament')->find($id);
        $city->status = 1;
        $city->update();

        return response()->json(['message' => 'City: ' . $city->city_name.', has been actived.', 'data' => $city], 200);

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
            'city_name' => 'required|string',
            'departament_id' => 'required',
        ]);

        try {

            $city = City::with('departament')->find($id);
            $city->city_name = $request->city_name;
            $city->departament_id = $request->departament_id;
            $city->status = 1;
            $city->update();


            return response()->json(['message' => 'City: ' . $city->city_name . ', has been updated.', 'data' => $city], 200);

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

            $city = City::with('departament','owner')->find($id);
            if(count($city->owner)>0){
                return response()->json(['code'=>'0002','message' => 'Can´t delete, because have associated records ','description'=>'Table owners and drivers have city associated '], 422);
            }

            $city->status = 0;
            $city->update();

            return response()->json(['message' => 'City has been deleted.','data'=>$city], 200);

        } catch (\Exception $e) {
            return response()->json(['code'=>'0001','message' => 'There was something wronge.','description'=>$e->getMessage()], 500);

        }

    }
}
