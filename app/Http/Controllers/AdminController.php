<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        return User::with('getAdmin')->where('role', 'admin')->latest()->get();
    }

    //stores data into the database
    public function store(Request $request)
    {
        //validation for storing admin's data
        $request->validate([
            'user_id' => 'required',
            'full_name' => 'required|max:100',
            'phone_number' => 'required',
            'role' => 'required|in:admin,patient,doctor,pharmacist',
            'email' => 'required|email',
            'password' => 'required|min:8',
            'address' => 'required',
            'dob' => 'required',
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

        //storing the admin data 
        $adminData = new Admin;
        $adminData->user_id = $request->user_id;
        $adminData->created_by = $request->created_by;
        $adminData->modified_by = $request->modified_by;

        //saving the data
        $userData->save();
        $userData->getPatient()->save($adminData);

        return "data saved successfully";
    }

    //search the data as per the full_name
    public function show($name)
    {
        return Admin::where("full_name", "like", "%" . $name . "%")->get();
    }

    public function edit($id)
    {
        return User::with('getAdmin')->where('role', 'admin')->whereId($id)->get()->first();
    }


    //responsible for editing and updating data
    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required',
            'full_name' => 'required|max:100',
            'phone_number' => 'required',
            'role' => 'required|in:admin,patient,doctor,pharmacist',
            'email' => 'required|email',
            'password' => 'required|min:8',
            'address' => 'required',
            'dob' => 'required',
        ]);

        //searching for user data in database
        $userData = User::find($id);
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

        //searching and finding the admin data in database
        $adminData = User::find($id)->getAdmin;
        $adminData->user_id = $request->user_id;

        //saving the updated data
        $userData->save();
        $userData->getPharmacist()->save($adminData);
        return "Data saved!";
    }

    //responsible for deletion of data from database
    public function destroy($id)
    {
        $data = User::where('role', 'admin')->find($id);
        $data->delete();
        return "data deleted!!";
    }
}
