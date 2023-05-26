<?php

namespace App\Http\Controllers;

use App\Models\Pharmacist;
use App\Models\Pharmacy;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PharmacistController extends Controller
{
    public function index()
    {
        $data = User::with('getPharmacist')->where('role', 'pharmacist')->get();
        return response()->json($data, 200);
    }

    public function edit($id)
    {
        return User::with('getPharmacist')->where('role', 'pharmacist')->whereId($id)->get()->first();
    }

    //stores data into the database
    public function store(Request $request)
    {
        //validation for storing pharmacist's data
        $request->validate([
            'full_name' => 'required|max:100',
            'phone_number' => 'required|regex:/9[6-8]{1}[0-9]{8}/',
            'role' => 'required|in:admin,patient,doctor,pharmacist',
            'email' => 'required|email',
            'password' => 'required|min:8',
            'address' => 'required',
            'dob' => 'required',
            'qualification' => 'required',
            'profile_photo'
        ]);


        $userData = new User;

        //managing profile photo
        if ($request->hasFile('profile_photo')) {
            $profile_photo = $request->file('profile_photo');
            $profile_photo_unique = uniqid() . '.' . $profile_photo->extension();
            $profile_photo->storeAs('public/profile_pics', $profile_photo_unique);
            $userData->profile_photo = env('APP_URL') . '/storage/profile_pics/' . $profile_photo_unique;
        }

        //posting user data
        $userData->full_name = $request->full_name;
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

        //saving the data
        $userData->save();
        $userData->getPharmacist()->save($pharmacistData);

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
            'phone_number' => 'required|regex:/9[6-8]{1}[0-9]{8}/',
            'role' => 'required|in:admin,patient,doctor,pharmacist',
            'email' => 'required|email',
            'address' => 'required',
            'dob' => 'required',
            'qualification' => 'required',
        ]);


        $userData = User::find($id);
        //managing profile photo
        // if ($request->hasFile('profile_photo')) {
        //     $profile_photo = $request->file('profile_photo');
        //     $profile_photo_unique = uniqid() . '.' . $profile_photo->extension();
        //     $profile_photo->storeAs('public/images/profile_pics', $profile_photo_unique);
        // }

        //searching for user data in database
        $userData->full_name = $request->full_name;
        // $userData->profile_photo = env('APP_URL') . Storage::url('public/images/profile_pics/' . $profile_photo_unique);
        $userData->phone_number = $request->phone_number;
        $userData->role = $request->role;
        $userData->email = $request->email;
        $userData->address = $request->address;
        $userData->dob = $request->dob;
        $userData->created_by = $request->created_by;
        $userData->modified_by = $request->modified_by;

        $pharmacistData = User::find($id)->getPharmacist;
        $pharmacistData->qualification = $request->qualification;
        $pharmacistData->user_id = $request->user_id;

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
