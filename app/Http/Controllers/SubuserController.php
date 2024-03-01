<?php

namespace App\Http\Controllers;

use App\Models\subuser;
use App\Models\Hobbies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SubuserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $subuser = subuser::get();
        return view('subuser.index', compact('subuser'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $contry = DB::table('countries')->get();
        $hobbie = Hobbies::get();

        return view('subuser.create', compact('contry', 'hobbie'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $sValidationRules = [
            'name' => 'required|max:100',
            'email' => 'required',
            'contact_number' => 'required',
            'hobbie' => 'required',
            'country' => 'required',
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'state' => 'required',
            'city' => 'required',
        ];

        $validator = Validator::make($request->all(), $sValidationRules);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json(['errors' => $errors], 422);
        }
        $imageName = time() . '.' . $request->profile_photo->extension();
        $request->profile_photo->move(public_path('profile_photo'), $imageName);

        DB::beginTransaction();

        try {
            $emp = new subuser;
            $emp->name = $request->name;
            $emp->email = $request->email;
            $emp->contact_number = $request->contact_number;
            $emp->gender = $request->gender;
            $emp->honnies = json_encode($request->hobbie);
            $emp->country = $request->country;
            $emp->profile_photo = $imageName;
            $emp->state = $request->state;
            $emp->city = $request->city;
            $emp->save();
            DB::commit(); // Commit the transaction if all operations are successful
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback the transaction if any operation fails
            return response()->json(['messsage' => 'error are in saved.', 'url' => '/sub-user'], 200);
        }

        return response()->json(['messsage' => 'data stored.', 'url' => '/sub-user'], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\subuser  $subuser
     * @return \Illuminate\Http\Response
     */
    public function edit(subuser $subuser, $id)
    {
        //
        $subuser = subuser::where('id', $id)->first();

        if ($subuser) {
            $contry = DB::table('countries')->get();
            $states = DB::table('states')->where('country_id', $subuser->country)->get();
            $cities = DB::table('cities')->where('state_id', $subuser->state)->get();
            $hobbie = Hobbies::get();

            return view('subuser.show', compact('subuser', 'contry', 'states', 'cities', 'hobbie'));
        }

        return abort('404');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\subuser  $subuser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, subuser $subuser)
    {

        $sValidationRules = [
            'name' => 'required|max:100',
            'email' => 'required',
            'contact_number' => 'required',
            'hobbie' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
        ];

        $validator = Validator::make($request->all(), $sValidationRules);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json(['errors' => $errors], 422);
        }

        $imageName = $request->profile_photo;
        if ($request->hasFile('profile_photo')) {
            $imageName = time() . '.' . $request->profile_photo->extension();
            $request->profile_photo->move(public_path('profile_photo'), $imageName);
        }


        $emp = subuser::where('id', $request->id)->first();
        $emp->name = $request->name;
        $emp->email = $request->email;
        $emp->contact_number = $request->contact_number;
        $emp->gender = $request->gender;
        $emp->honnies = json_encode($request->hobbie);
        $emp->country = $request->country;
        $emp->profile_photo = $imageName;
        $emp->state = $request->state;
        $emp->city = $request->city;
        $emp->save();

        return response()->json(['messsage' => 'data stored.', 'url' => '/sub-user'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\subuser  $subuser
     * @return \Illuminate\Http\Response
     */
    public function destroy(subuser $subuser, Request $request, $id)
    {
        subuser::destroy($id);
        return response()->json(['message' => 'Sub User deleted successfully'], 200);
    }
}
