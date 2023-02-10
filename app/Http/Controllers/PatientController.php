<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PatientController extends Controller
{
    public function index()
    {
        return User::with('getPatient')->where('role', 'patient')->latest()->get();
    }

    //stores data into the database
    public function store(Request $request)
    {
        //validation for storing patient's data
        $request->validate([
            'blood_group' => 'required',
            'full_name' => 'required|max:100',
            'phone_number' => 'required',
            'role' => 'in:admin,patient,doctor,pharmacist',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'address' => 'required',
            'dob' => 'required',
        ]);

        //posting user data
        $userData = new User;
        $userData->full_name = $request->full_name;
        $userData->profile_photo = $request->file('photo')?->store('profile_photos');
        $userData->phone_number = $request->phone_number;
        $userData->email = $request->email;
        $userData->password = Hash::make($request->password);
        $userData->address = $request->address;
        $userData->dob = $request->dob;
        $userData->created_by = $request->created_by;
        $userData->modified_by = $request->modified_by;

        //posting patient data
        $patientData = new Patient;
        $patientData->chronic_disease = $request->chronic_disease;
        $patientData->blood_group = $request->blood_group;
        $patientData->created_by = $request->created_by;
        $patientData->modified_by = $request->modified_by;
        $patientData->user_id = $request->user_id;

        //saving the data
        $userData->save();
        $userData->getPatient()->save($patientData);

        return "data saved successfully";
    }

    //search the data as per the full_name
    public function show($id)
    {
        $user = User::with('getPatient')->whereId($id)->get()->first();
        return $user;
    }

    //search the data as per the full_name
    public function search($name)
    {
        // return Patient::where("full_name", "like", "%" . $name . "%")->get();
        $patient = Patient::find($name);
        $user = User::find($patient->user_id);
        return [$patient, $user];
    }

    public function edit($id)
    {
        return User::with('getPatient')->where('role', 'patient')->whereId($id)->get()->first();
    }


    //responsible for editing and updating data
    public function update(Request $request, $id)
    {
        //validation for updating patient's data
        $request->validate([
            'blood_group' => 'required',
            'full_name' => 'required|max:100',
            'phone_number' => 'required',
            'role' => 'in:admin,patient,doctor,pharmacist',
            'email' => 'required|email',
            'address' => 'required',
            'dob' => 'required',
        ]);

        //searching for user data in database
        $userData = User::find($id);
        $userData->full_name = $request->full_name;
        $userData->profile_photo = $request->file('photo')?->store('profile_photos');
        $userData->phone_number = $request->phone_number;
        $userData->email = $request->email;
        $userData->address = $request->address;
        $userData->dob = $request->dob;
        $userData->created_by = $request->created_by;
        $userData->modified_by = $request->modified_by;

        //searching for patient data in database
        $patientData = User::find($id)->getPatient;
        $patientData->chronic_disease = $request->chronic_disease;
        $patientData->blood_group = $request->blood_group;
        $patientData->created_by = $request->created_by;
        $patientData->modified_by = $request->modified_by;
        $patientData->user_id = $request->user_id;

        //saving the data
        $userData->save();
        $userData->getPatient()->save($patientData);
        return "Data updated!";
    }

    //responsible for deletion of data but not permanently - softdelete
    public function destroy($id)
    {
        $data = User::where('role', 'patient')->find($id);
        $data->delete();
        return "data deleted!!";
    }

    //fetches deleted data only
    public function trashedData()
    {
        User::onlyTrashed()->get();
        return 'done';
    }
}
