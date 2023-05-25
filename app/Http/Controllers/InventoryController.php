<?php

namespace App\Http\Controllers;

use App\Models\InventoryItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return InventoryItems::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'item_name' => 'required',
            'item_type' => 'required',
            'manufactured_date' => 'required',
            'expiry_date' => 'required'
        ]);

        $inventory = new InventoryItems;

        //managing profile photo
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photo_unique = uniqid() . '.' . $photo->extension();
            $photo->storeAs('public/item_pics', $photo_unique);
            $inventory->photo = env('APP_URL') . '/storage/item_pics/' . $photo_unique;
        }


        $inventory->item_name = $request->item_name;
        $inventory->item_type = $request->item_type;
        $inventory->manufactured_date = $request->manufactured_date;
        $inventory->expiry_date = $request->expiry_date;
        $inventory->created_by = $request->created_by;
        $inventory->modified_by = $request->modified_by;

        $inventory->photo = env('APP_URL') . Storage::url('public/images/item_pics/' . $photo_unique);

        $inventory->save();

        return 'Inventory data saved!';
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return InventoryItems::whereId($id)->get()->first();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return InventoryItems::whereId($id)->get()->first();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'item_name' => 'required',
            'item_type' => 'required',
            'manufactured_date' => 'required',
            'expiry_date' => 'required'
        ]);

        $inventory = InventoryItems::find($id);
        $inventory->item_name = $request->item_name;
        $inventory->item_type = $request->item_type;
        $inventory->manufactured_date = $request->manufactured_date;
        $inventory->expiry_date = $request->expiry_date;
        $inventory->created_by = $request->created_by;
        $inventory->modified_by = $request->modified_by;
        $inventory->cost = $request->cost;
        //managing profile photo
        if ($request->hasFile('photo')) {
            $photo = $request->file('profile_photo');
            $photo_unique = uniqid() . '.' . $photo->extension();
            $photo->storeAs('public/profile_pics', $photo_unique);
            $inventory->profile_photo = env('APP_URL') . '/storage/profile_pics/' . $photo_unique;
        }
        $inventory->photo = env('APP_URL') . Storage::url('public/images/profile_pics/' . $photo_unique);

        $inventory->save();

        return 'Inventory data Updated!';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = InventoryItems::find($id);
        $data->delete();
        return 'data deleted!';
    }

    //search the data as per the full_name
    public function search($name)
    {
        if (is_numeric($name)) {
            $data = InventoryItems::whereId($name)->get()->first();
        } else {
            $data = InventoryItems::where("item_name", "like", "%" . $name . "%")->get();
        }
        if ($data) {
            return $data;
        }
    }
}
