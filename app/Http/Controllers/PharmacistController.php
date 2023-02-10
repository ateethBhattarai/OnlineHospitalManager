<?php

namespace App\Http\Controllers;

use App\Models\Pharmacist;
use App\Models\Pharmacy;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PharmacistController extends Controller
{
    public function index()
    {
        return User::with('getPharmacist')->where('role', 'pharmacist')->latest()->get();
    }

    //stores data into the database
    public function store(Request $request)
    {
        //validation for storing pharmacist's data
        $request->validate([
            'full_name' => 'required|max:100',
            'phone_number' => 'required',
            'role' => 'required|in:admin,patient,doctor,pharmacist',
            'email' => 'required|email',
            'password' => 'required|min:8',
            'address' => 'required',
            'dob' => 'required',
            'qualification' => 'required',
        ]);

        //posting user data
        $userData = new User;
        $userData->full_name = $request->full_name;
        $userData->profile_photo = $request->file('photo')?->store('profile_photos');
        $userData->phone_number = $request->phone_number;
        $userData->role = $request->role;
        $userData->email = $request->email;
        $userData->password = Hash::make($request->password);
        $userData->address = $request->address;
        $userData->dob = $request->dob;
        $userData->created_by = $request->created_by;
        $userData->modified_by = $request->modified_by;

        $pharmacistData = new Pharmacist;
        $pharmacistData->qualification = $request->qualification;
        $pharmacistData->created_by = $request->created_by;
        $pharmacistData->modified_by = $request->modified_by;
        $pharmacistData->user_id = $request->user_id;
        $pharmacistData->pharmacy_id = $request->pharmacy_id;

        //saving the data
        $userData->save();
        $userData->getPatient()->save($pharmacistData);

        return "data saved successfully";
    }

    //search the data as per the full_name
    public function show($name)
    {
        // return Pharmacist::where("full_name", "like", "%" . $name . "%")->get();
        $pharmacist = Pharmacist::find($name);
        $user = User::find($pharmacist->user_id);
        $pharmacy = Pharmacy::find($pharmacist->pharmacy_id);
        return [$pharmacist, $user, $pharmacy];
    }


    //responsible for editing and updating data
    public function update(Request $request, $id)
    {
        //validation for updating pharmacist's data
        $request->validate([
            'full_name' => 'required|max:100',
            'phone_number' => 'required',
            'role' => 'required|in:admin,patient,doctor,pharmacist',
            'email' => 'required|email',
            'address' => 'required',
            'dob' => 'required',
            'qualification' => 'required',
        ]);

        //searching for user data in database
        $userData = User::find($id);
        $userData->full_name = $request->full_name;
        $userData->profile_photo = $request->file('photo')?->store('profile_photos');
        $userData->phone_number = $request->phone_number;
        $userData->role = $request->role;
        $userData->email = $request->email;
        $userData->address = $request->address;
        $userData->dob = $request->dob;
        $userData->created_by = $request->created_by;
        $userData->modified_by = $request->modified_by;

        $pharmacistData = Pharmacist::find($id);
        $pharmacistData->qualification = $request->qualification;
        $pharmacistData->user_id = $request->user_id;
        $pharmacistData->pharmacy_id = $request->pharmacy_id;

        //storing the updated data in database
        $userData->save();
        $userData->getPharmacist()->save($pharmacistData);
        return "Data saved!";
    }

    //responsible for deletion of data from database
    public function destroy($id)
    {
        $data = User::where('role', 'pharmacist')->find($id);
        $data->delete();
        return "data deleted!!";
    }
}