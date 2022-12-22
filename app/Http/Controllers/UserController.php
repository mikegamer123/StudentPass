<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Str;

class UserController extends Controller
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

    public function getUsers($id = 0,Request $request){
//        if(!$this->declareAdmin($request)){
//            return "Unathorized";
//        }

        if($id == 0){
            $models = User::all();
            $allModels = [];
            $i = 0;
            foreach ($models as $model){
                $allModels[$i]["image"] = Image::where("id",$model->image_id)->first();
                $allModels[$i]["user"] = $model;
                $i++;
            }
            return $allModels;
        }
        else{
            $user["user"] = User::where('id', $id)->firstOrFail();
            $user["image"] = Image::where('id',$user["user"]->image_id)->first();
            return $user;
        }
    }

    public function putUsers($id,Request $request){
//        if(!$this->declareAdmin($request)){
//            return "Unathorized";
//        }

        $user = User::where('id',$id)->first();

        if($request->fname){
            $user->fname = $request->fname;
        }
        if($request->lname){
            $user->lname = $request->lname;
        }
        if($request->dateOfBirth){
            $user->dateOfBirth = $request->dateOfBirth;
        }
        if($request->index){
            $user->index = $request->index;
        }
        if($request->email){
            $user->email = $request->email;
        }
        if($request->isActive){
            $user->isActive = $request->isActive;
        }


        $user->updated_at = now()->toDateTimeString();
        $user->save();
        return response()->json(["User ".$user->email. " updated successfully"]);
    }

    public function deleteUsers($id,Request $request){
        if(!$this->declareAdmin($request)){
            return "Unathorized";
        }

        $user = User::where('id',$id)->first();
        $user->delete();
        return "Deleted user ".$user->email." by id of ".$id;
    }
}
