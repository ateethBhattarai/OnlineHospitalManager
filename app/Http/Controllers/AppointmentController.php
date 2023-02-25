<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        $patient = Appointment::with('getPatientData')->latest()->get();
        $doctor = Appointment::with('getDoctorData')->latest()->get();
        return compact('doctor', 'patient');
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
    public function show($id)
    {
        // return Appointment::where("full_name", "like", "%" . $name . "%")->get();
        $doctor = Doctor::with('getAppointmentDetails')->whereId($id)->latest()->get();
        $patient = Patient::with('getPatientAppointmentDetails')->whereId($id)->latest()->get();
        return compact('doctor', 'patient');
    }


    //responsible for editing and updating data
    public function update(Request $request, $id)
    {
        $request->validate([
            'visit_date_and_time' => 'required',
            'validation_status' => 'required|in:approved,declined,pending,cancel,completed',
        ]);

        $data = Appointment::find($id);
        $data->visit_date_and_time = $data->visit_date_and_time;
        $data->patient_id = $data->patient_id;
        $data->doctor_id = $data->doctor_id;
        $data->validation_status = $request->validation_status;
        return $data->save();
    }

    //responsible for deletion of data from database
    public function destroy($id)
    {
        $data = Appointment::find($id);
        $data->delete();
    }
}
