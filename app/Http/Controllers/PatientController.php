<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PatientController extends Controller
{
    public function index()
    {
        $data = User::with('getPatient')->where('role', 'patient')->get();
        return response()->json($data, 200);
    }

    //stores data into the database
    public function store(Request $request)
    {
        //validation for storing patient's data
        $request->validate([
            'blood_group' => 'required',
            'full_name' => 'required|max:100',
            'phone_number' => 'required|regex:/9[6-8]{1}[0-9]{8}/',
            'role' => 'in:admin,patient,doctor,pharmacist',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'address' => 'required',
            'dob' => 'required',
            'profile_photo'
        ]);



        //posting user data
        $userData = new User;
        //managing profile photo
        if ($request->hasFile('profile_photo')) {
            $profile_photo = $request->file('profile_photo');
            $profile_photo_unique = uniqid() . '.' . $profile_photo->extension();
            $profile_photo->storeAs('public/images/profile_pics', $profile_photo_unique);
            $userData->profile_photo = env('APP_URL') . Storage::url('public/images/profile_pics/' . $profile_photo_unique);
        }
        $userData->full_name = $request->full_name;
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
            'phone_number' => 'required|regex:/9[6-8]{1}[0-9]{8}/',
            'role' => 'in:admin,patient,doctor,pharmacist',
            'email' => 'required|email',
            'address' => 'required',
            'dob' => 'required',
            // 'profile_photo'
        ]);

        //searching for user data in database
        $userData = User::find($id);
        $userData->full_name = $request->full_name;
        //managing profile photo
        if ($request->hasFile('profile_photo')) {
            $profile_photo = $request->file('profile_photo');
            $profile_photo_unique = uniqid() . '.' . $profile_photo->extension();
            $profile_photo->storeAs('public/profile_pics', $profile_photo_unique);
            $userData->profile_photo = env('APP_URL') . '/storage/profile_pics/' . $profile_photo_unique;
        }

        // $userData->profile_photo = env('APP_URL') . Storage::url('public/images/profile_pics/' . $profile_photo_unique);
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

    public function login(Request $request)
    {
        $user = User::with('getPatient')->where('email', $request->email)->where('role', 'patient')->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return ["error" => "The credential does not matched!!"];
        }
        return $user;
    }

    public function changePassword(Request $req, $id)
    {
        $userData = User::find($id);
        if (Hash::check($req->confirm_password, $userData->password)) {
            return 'Password cannot be similar to old!';
        }
        $userData->password = Hash::make($req->password);
        $userData->save();
        return 'Password changed!';
    }
}
