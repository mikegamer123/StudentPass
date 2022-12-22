<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\College;
use Illuminate\Http\Request;

class CollegeController extends Controller
{
    public function declareAdmin(Request $request){

        $token = $request->bearerToken();
        $user = User::where('api_token', $token)->firstOrFail();
        if($user->userType == 'Admin'){
            return true;
        }
        else{
            return false;
        }
    }
    public function getCollege($id = 0,Request $request){
        if(!$this->declareAdmin($request)){
            return "Unathorized";
        }

        if($id == 0){
            $college = College::all();
            return $college;
        }
        else{
            $college = College::where('id', $id)->firstOrFail();
            return $college;
        }
    }

    public function putCollege($id,Request $request){
        if(!$this->declareAdmin($request)){
            return "Unathorized";
        }

        $college = College::where('id',$id)->first();

        if($request->name){
            $college->name = $request->name;
        }
        if($request->info){
            $college->info = $request->info;
        }
        if($request->location){
            $college->location = $request->location;
        }
        if($request->email){
            $college->email = $request->email;
        }
        if($request->phone) {
            $college->phone = $request->phone;
        }


        $college->updated_at = now()->toDateTimeString();
        $college->save();
        return "College ".$college->name. " updated successfully";
    }

    public function addCollege(Request $request){
        if(!$this->declareAdmin($request)){
            return "Unathorized";
        }

        $college = College::create([
            'name' => $request->name,
            'location' => $request->location,
            'info' => $request->info,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return $college;
    }

    public function deleteCollege($id,Request $request){
        if(!$this->declareAdmin($request)){
            return "Unathorized";
        }

        $college = College::where('id',$id)->first();
        $college->delete();
        return "Deleted college ".$college->name." by id of ".$id;
    }
}
