<?php

namespace App\Http\Controllers;

use App\Models\College;
use App\Models\Study_Program;
use App\Models\User_College;
use App\Models\User;
use Illuminate\Http\Request;

class UserCollegeController extends Controller
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
    public function getUserCollege($id = 0,Request $request){
//        if(!$this->declareAdmin($request)){
//            return "Unathorized";
//        }

        if($id == 0){
            $userCollege = User_College::all();
            $i = 0;
            foreach ($userCollege as $model){
                $allModels[$i]["user_id"] = User::where("id",$model->user_id)->first();
                $allModels[$i]["college_id"] = College::where("id",$model->college_id)->first();
                $allModels[$i]["studyProgramId"] = Study_Program::where("id",$model->studyProgramId)->first();
                $allModels[$i]["educationStartYear"] = $model->educationStartYear;
                $i++;
            }
            return $allModels;
        }
        else{
            $model = User_College::where('user_id', $id)->firstOrFail();

                $allModels["college"] = College::where("id",$model->college_id)->first();
                $allModels["studyProgramId"] = Study_Program::where("id",$model->studyProgramId)->first();
                $allModels["educationStartYear"] = $model->educationStartYear;

            return $allModels;
        }
    }

    public function putUserCollege($id,Request $request){
        if(!$this->declareAdmin($request)){
            return "Unathorized";
        }

        $userCollege = User_College::where('id',$id)->first();

        if($request->user_id){
            $userCollege->user_id = $request->user_id;
        }
        if($request->college_id){
            $userCollege->college_id = $request->college_id;
        }
        if($request->educationStartYear){
            $userCollege->educationStartYear = $request->educationStartYear;
        }
        if($request->studyProgramId){
            $userCollege->studyProgramId = $request->studyProgramId;
        }

        $userCollege->updated_at = now()->toDateTimeString();
        $userCollege->save();

        $college = College::where('id',$userCollege->college_id)->first();
        $user = User::where('id',$userCollege->user_id)->first();

        return "User ".$user->fname." ".$user->lname." added to College: ".$college->name;
    }

    public function addUserCollege(Request $request){
        if(!$this->declareAdmin($request)){
            return "Unathorized";
        }

        $userCollege = User_College::create([
            'user_id' => $request->user_id,
            'college_id' => $request->college_id,
            'educationStartYear' => $request->educationStartYear,
            'studyProgramId' => $request->studyProgramId,
        ]);

        return $userCollege;
    }

    public function deleteUserCollege($id,Request $request){
        if(!$this->declareAdmin($request)){
            return "Unathorized";
        }

        $userCollege = User_College::where('id',$id)->first();
        $college = College::where('id',$userCollege->college_id)->first();
        $user = User::where('id',$userCollege->user_id)->first();
        $userCollege->delete();
        return "User ".$user->fname." ".$user->lname." removed from College: ".$college->name;
    }
}
