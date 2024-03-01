<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DropdownController extends Controller
{
    //
    public function fetchState(Request $request)
    {

        $data['states'] = DB::table('states')->where("country_id", $request->country_id)->get(["state", "id_state"]);
        return response()->json($data);
    }
    public function fetchCity(Request $request)
    {
        $data['cities'] = DB::table('cities')->where("state_id", $request->state_id)->get(["name", "id"]);
        return response()->json($data);
    }
}
