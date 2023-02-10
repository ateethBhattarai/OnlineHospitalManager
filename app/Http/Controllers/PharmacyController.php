<?php

namespace App\Http\Controllers;

use App\Models\Pharmacy;
use Illuminate\Http\Request;

class PharmacyController extends Controller
{
    public function index()
    {
        return Pharmacy::all();
    }

    //stores data into the database
    public function store(Request $request)
    {
        $request->validate([
            'sector' => 'required|integer',
            'opening_time' => 'required|',
            'closing_time' => 'required|after:time_start',
        ]);

        $data = new Pharmacy;
        $data->sector = $request->sector;
        $data->opening_time = $request->opening_time;
        $data->closing_time = $request->closing_time;
        $data->created_by = $request->created_by;
        $data->modified_by = $request->modified_by;
        return $data->save();
    }

    //search the data as per the full_name
    public function show($id)
    {
        return Pharmacy::where("sector", "like", "%" . $id . "%")->get();
    }


    //responsible for editing and updating data
    public function update(Request $request, $id)
    {
        $data = Pharmacy::find($id);
        $data->sector = $request->sector;
        $data->opening_time = $request->opening_time;
        $data->closing_time = $request->closing_time;
        return $data->save();
    }

    //responsible for deletion of data from database
    public function destroy($id)
    {
        $data = Pharmacy::find($id);
        $data->delete();
    }
}
