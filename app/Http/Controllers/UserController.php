<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    //fetch data from database
    public function index()
    {
        return User::all();
    }

    //stores data into the database
    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|max:100',
            'phone_number' => 'required',
            // 'role' => 'required|in:admin,patient,doctor,phrmacist',
            'email' => 'required|email',
            'password' => 'required|min:8',
            'address' => 'required',
            'dob' => 'required',
        ]);

        $data = new User;
        $data->full_name = $request->full_name;
        $data->profile_photo = $request->file('photo')->store('profile_photos');
        $data->phone_number = $request->phone_number;
        $data->role = $request->role;
        $data->email = $request->email;
        $data->password = Hash::make($request->password);
        $data->address = $request->address;
        $data->dob = $request->dob;
        $data->created_by = $request->created_by;
        $data->modified_by = $request->modified_by;
        return $data->save();
    }

    //search the data as per the full_name
    public function show($name)
    {
        return User::where("full_name", "like", "%" . $name . "%")->get();
    }


    //responsible for editing and updating data
    public function update(Request $request, $id)
    {
        $data = User::find($id);
        $data->full_name = $request->full_name;
        $data->phone_number = $request->phone_number;
        $data->role = $request->role;
        $data->email = $request->email;
        $data->password = $request->password;
        $data->address = $request->address;
        $data->dob = $request->dob;
        return $data->save();
    }

    //responsible for deletion of data from database
    public function destroy($id)
    {
        $data = User::find($id);
        $data->delete();
    }
}
