<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DoctorController extends Controller
{
    public function index()
    {
        return User::with('getDoctor')->where('role', 'doctor')->latest()->get();
    }

    //stores data into the database
    public function store(Request $request)
    {
        //validation for storing doctor's data
        $request->validate([
            'full_name' => 'required|max:100',
            'phone_number' => 'required|regex:/9[6-8]{1}[0-9]{8}/',
            'email' => 'required|email',
            'role' => 'required|in:admin,patient,doctor,pharmacist',
            'password' => 'required|min:8',
            'address' => 'required',
            'dob' => 'required',
            'speciality' => 'required',
            'qualification' => 'required',
            'availability_time' => 'required',
            'fees' => 'required|integer',
        ]);

        //managing profile photo
        if ($request->hasFile('profile_photo')) {
            $profile_photo = $request->file('profile_photo');
            $profile_photo_unique = uniqid() . '.' . $profile_photo->extension();
            $profile_photo->storeAs('public/images/profile_pics', $profile_photo_unique);
        }

        //posting user data
        $userData = new User;
        $userData->full_name = $request->full_name;
        $userData->profile_photo = $request->file('photo')?->store('profile_photos');
        $userData->phone_number = $request->phone_number;
        $userData->email = $request->email;
        $userData->password = Hash::make($request->password);
        $userData->address = $request->address;
        $userData->role = $request->role;
        $userData->dob = $request->dob;
        $userData->created_by = $request->created_by;
        $userData->modified_by = $request->modified_by;

        //posting doctor data
        $doctorData = new Doctor;
        $doctorData->speciality = $request->speciality;
        $doctorData->qualification = $request->qualification;
        $doctorData->availability_time = $request->availability_time;
        $doctorData->fees = $request->fees;
        $doctorData->created_by = $request->created_by;
        $doctorData->modified_by = $request->modified_by;
        $doctorData->user_id = $request->user_id;

        //saving the data
        $userData->save();
        $userData->getDoctor()->save($doctorData);
        return "Data saved!";
    }

    //search the data as per the full_name
    public function show($id)
    {
        $user = User::with('getDoctor')->whereId($id)->get()->first();
        return $user;
    }

    public function edit($id)
    {
        return User::with('getDoctor')->where('role', 'doctor')->whereId($id)->get()->first();
    }


    //responsible for editing and updating data
    public function update(Request $request, $id)
    {
        //validation for updating doctor's data
        $request->validate([
            'full_name' => 'required|max:100',
            'phone_number' => 'required|regex:/9[6-8]{1}[0-9]{8}/',
            'email' => 'required|email',
            'role' => 'required|in:admin,patient,doctor,pharmacist',
            'address' => 'required',
            'dob' => 'required',
            'speciality' => 'required',
            'qualification' => 'required',
            'availability_time' => 'required',
            'fees' => 'required|integer',
            'profile_photo'
        ]);

        //managing profile photo
        if ($request->hasFile('profile_photo')) {
            $profile_photo = $request->file('profile_photo');
            $profile_photo_unique = uniqid() . '.' . $profile_photo->extension();
            $profile_photo->storeAs('public/images/profile_pics', $profile_photo_unique);
        }

        //searching for user data in database
        $userData = User::find($id);
        $userData->full_name = $request->full_name;
        // $userData->profile_photo = env('APP_URL') . Storage::url('public/images/profile_pics/' . $profile_photo_unique);
        $userData->phone_number = $request->phone_number;
        $userData->role = $request->role;
        $userData->email = $request->email;
        $userData->password = Hash::make($request->password);
        $userData->address = $request->address;
        $userData->dob = $request->dob;
        $userData->created_by = $request->created_by;
        $userData->modified_by = $request->modified_by;

        //updating the doctor data in database
        $doctorData = User::find($id)->getDoctor;
        $doctorData->speciality = $request->speciality;
        $doctorData->qualification = $request->qualification;
        $doctorData->availability_time = $request->availability_time;
        $doctorData->fees = $request->fees;
        $doctorData->user_id = $request->user_id;

        //saving the updated data in database
        $userData->save();
        $userData->getDoctor()->save($doctorData);
        return "Data updated!";
    }

    //responsible for deletion of data from database
    public function destroy($id)
    {
        $data = User::where('role', 'doctor')->find($id);
        $data->delete();
        return "data deleted!!";
    }

    //search the data as per the full_name
    public function search($name)
    {
        $data = User::with('getDoctor')->where('role', 'doctor')->where("full_name", "like", "%" . $name . "%")->get();
        if ($data) {
            return $data;
        }
    }
}
