<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        return Appointment::all();
    }

    //stores data into the database
    public function store(Request $request)
    {
        $request->validate([
            'visit_date_and_time' => 'required',
            'validation_status' => 'required|in:approved,declined,pending,cancel,completed',
        ]);

        $data = new Appointment;
        $data->visit_date_and_time = $request->visit_date_and_time;
        $data->patient_id = $request->patient_id;
        $data->validation_status = $request->validation_status;
        $data->doctor_id = $request->doctor_id;
        return $data->save();
    }

    //search the data as per the full_name
    public function show($name)
    {
        return Appointment::where("full_name", "like", "%" . $name . "%")->get();
    }


    //responsible for editing and updating data
    public function update(Request $request, $id)
    {
        $request->validate([
            'visit_date_and_time' => 'required',
            'validation_status' => 'required|in:approved,declined,pending,cancel,completed',
        ]);

        $data = Appointment::find($id);
        $data->visit_date_and_time = $request->visit_date_and_time;
        $data->patient_id = $request->patient_id;
        $data->doctor_id = $request->doctor_id;
        return $data->save();
    }

    //responsible for deletion of data from database
    public function destroy($id)
    {
        $data = Appointment::find($id);
        $data->delete();
    }
}
