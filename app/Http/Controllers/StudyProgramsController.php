<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Study_Program;

class StudyProgramsController extends Controller
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
    public function getStudyProgram($id = 0,Request $request){
        if(!$this->declareAdmin($request)){
            return "Unathorized";
        }

        if($id == 0){
            $studyProgram = Study_Program::all();
            return $studyProgram;
        }
        else{
            $studyProgram = Study_Program::where('id', $id)->firstOrFail();
            return $studyProgram;
        }
    }

    public function putStudyProgram($id,Request $request){
        if(!$this->declareAdmin($request)){
            return "Unathorized";
        }

        $studyProgram = Study_Program::where('id',$id)->first();

        if($request->name){
            $studyProgram->name = $request->name;
        }
        if($request->duration){
            $studyProgram->duration = $request->duration;
        }
        if($request->college_id){
            $studyProgram->college_id = $request->college_id;
        }
        if($request->description){
            $studyProgram->description = $request->description;
        }

        $studyProgram->updated_at = now()->toDateTimeString();
        $studyProgram->save();
        return "Study program  ".$studyProgram->name. " updated successfully";
    }

    public function addStudyProgram(Request $request){
        if(!$this->declareAdmin($request)){
            return "Unathorized";
        }

        $studyProgram = Study_Program::create([
            'name' => $request->name,
            'duration' => $request->duration,
            'college_id' => $request->college_id,
            'description' => $request->description,
        ]);

        return $studyProgram;
    }

    public function deleteStudyProgram($id,Request $request){
        if(!$this->declareAdmin($request)){
            return "Unathorized";
        }

        $studyProgram = Study_Program::where('id',$id)->first();
        $studyProgram->delete();
        return "Deleted study program ".$studyProgram->name." by id of ".$id;
    }
}
