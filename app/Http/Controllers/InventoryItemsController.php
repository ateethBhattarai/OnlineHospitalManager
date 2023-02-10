<?php

namespace App\Http\Controllers;

use App\Models\InventoryItems;
use Illuminate\Http\Request;

class InventoryItemsController extends Controller
{
    public function index()
    {
        return InventoryItems::all();
    }

    //stores data into the database
    public function store(Request $request)
    {
        $request->validate([
            'speciality' => 'required',
            'qualification' => 'required',
            'availibility_time' => 'required',
            'fees' => 'required|integer',
        ]);

        $data = new InventoryItems;
        $data->speciality = $request->speciality;
        $data->qualification = $request->qualification;
        $data->availibility_time = $request->availibility_time;
        $data->fees = $request->fees;
        $data->created_by = $request->created_by;
        $data->modified_by = $request->modified_by;
        $data->user_id = $request->user_id;
        return $data->save();
    }

    //search the data as per the full_name
    public function show($name)
    {
        return InventoryItems::where("full_name", "like", "%" . $name . "%")->get();
    }


    //responsible for editing and updating data
    public function update(Request $request, $id)
    {
        $data = InventoryItems::find($id);
        $data->speciality = $request->speciality;
        $data->qualification = $request->qualification;
        $data->availibility_time = $request->availibility_time;
        $data->fees = $request->fees;
        $data->user_id = $request->user_id;
        return $data->save();
    }

    //responsible for deletion of data from database
    public function destroy($id)
    {
        $data = InventoryItems::find($id);
        $data->delete();
    }
}
