<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use PDO;

class AppointmentController extends Controller
{
    public function index()
    {
        $patient = Appointment::with('getPatientData')->latest()->get();
        $doctor = Appointment::with('getDoctorData')->latest()->get();
        return compact('doctor', 'patient');
    }

    public function patientRequest($id)
    {
        $data = Appointment::where('validation_status', 'pending')->where('patient_id', $id)->get();
        return $data;
    }

    // for patient usage
    public function getUpcomingAppointments($patientId)
    {
        $today = date('Y-m-d H:i');
        $appointments = Appointment::where('patient_id', $patientId)
            ->where('validation_status', 'approved')
            ->where('visit_date_and_time', '>=', $today)
            ->orderBy('visit_date_and_time', 'asc')
            ->get();
        return response()->json($appointments);
    }

    // for patient usage
    public function getPreviousAppointments($patientId)
    {
        $today = date('Y-m-d H:i');
        $appointments = Appointment::where('patient_id', $patientId)
            ->where('validation_status', 'approved')
            ->where('visit_date_and_time', '<=', $today)
            ->orderBy('visit_date_and_time', 'asc')
            ->get();
        return response()->json($appointments);
    }

    // for doctor usage
    public function getUpcomingPendingAppointments($id)
    {
        $today = date('Y-m-d H:i');
        $appointments = Appointment::where('doctor_id', $id)
            ->where('validation_status', 'pending')
            ->where('visit_date_and_time', '>=', $today)
            ->orderBy('visit_date_and_time', 'asc')
            ->get();
        return response()->json($appointments);
    }

    public function getUpcomingApprovedAppointments($id)
    {
        $today = date('Y-m-d H:i');
        $appointments = Appointment::where('doctor_id', $id)
            ->where('validation_status', 'approved')
            ->where('visit_date_and_time', '>=', $today)
            ->orderBy('visit_date_and_time', 'asc')
            ->get();
        return response()->json($appointments);
    }

    //stores data into the database
    public function store(Request $request)
    {
        $request->validate([
            'visit_date_and_time' => 'required',
            'symptoms' => 'required',
            'created_by',
            'validation_status' => 'in:approved,declined,pending,cancel,completed',
        ]);

        $data = new Appointment;
        $data->visit_date_and_time = $request->visit_date_and_time;
        $data->patient_id = $request->patient_id;
        // $data->validation_status = $request->validation_status;
        $data->doctor_id = $request->doctor_id;
        $data->symptoms = $request->symptoms;
        $data->created_by = $request->created_by;
        $data->modified_by = $request->modified_by;
        $data->save();
        return "Data added Successfully!!";
    }

    //search the data as per the full_name
    public function show($id)
    {
        // return Appointment::where("full_name", "like", "%" . $name . "%")->get();
        // $doctor = Doctor::with('getAppointmentDetails')->whereId($id)->latest()->get();
        // $patient = Patient::with('getPatientAppointmentDetails')->whereId($id)->latest()->get();
        // return compact('doctor', 'patient');

        $data = Appointment::where('id', $id)->get();
        return $data;
    }



    //responsible for editing and updating data
    public function update(Request $request, $id)
    {
        $request->validate([
            'visit_date_and_time' => 'required',
            'created_by',
            'validation_status' => 'required|in:approved,declined,pending,cancel,completed',
        ]);

        $data = Appointment::find($id);
        $data->visit_date_and_time = $data->visit_date_and_time;
        $data->patient_id = $data->patient_id;
        $data->doctor_id = $data->doctor_id;
        $data->validation_status = $request->validation_status;
        $data->created_by = $request->created_by;
        $data->modified_by = $request->modified_by;
        $data->save();
        return "Data updated successfully!!";
    }

    //responsible for deletion of data from database
    public function destroy($id)
    {
        $data = Appointment::find($id);
        $data->delete();
    }
}
