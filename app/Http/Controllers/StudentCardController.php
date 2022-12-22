<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\StudentCard;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class StudentCardController extends Controller
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
    public function getStudentCards($id = 0,Request $request){
//        if(!$this->declareAdmin($request)){
//            return "Unathorized";
//        }

        if($id == 0){
            $card = StudentCard::all();
            return $card;
        }
        else{
           $allInfo["card"] = $card = StudentCard::where('id', $id)->firstOrFail();
           $allInfo["image"] = Image::where("id",$card->image_id)->first();
            return $allInfo;
        }
    }

    public function getUserByCode($code,Request $request){
//        if(!$this->declareAdmin($request)){
//            return "Unathorized";
//        }
            $allValues=[];
        $allValues["student_card"]= $card = StudentCard::where('code', $code)->firstOrFail();
        $allValues["user"] =  User::where("id",$card->id)->firstOrFail();
        $allValues["image"] =  Image::where("id",$card->image_id)->firstOrFail();
            return $allValues;

    }

    public function putStudentCard($id,Request $request){
//        if(!$this->declareAdmin($request)){
//            return "Unathorized";
//        }

        $card = StudentCard::where('id',$id)->first();

        if($request->id){
            $card->id = $request->id;
        }
        if($request->code){
            $card->code = $request->code;
        }
        if($request->image_id){
            $card->image_id = $request->image_id;
        }
        if($request->created_by){
            $card->created_by = $request->created_by;
        }

        $card->updated_at = now()->toDateTimeString();
        $card->save();
        return "Review ".$card->id. " updated successfully";
    }

    public function addStudentCard(Request $request){
//        if(!$this->declareAdmin($request)){
//            return "Unathorized";
//        }

        $card = StudentCard::create([
            'id' => $request->id,
            'code' => $request->code,
            'created_by' => $request->created_by,
        ]);

        $user = User::where("id",$request->id)->first();
        $nameTo = $user->fname." ".$user->lname;
        Mail::to($user->email)->queue(new \App\Mail\StudentCardMail($nameTo));

        $card->id = $request->id;

        return $card;
    }

    public function deleteStudentCard($id,Request $request){
//        if(!$this->declareAdmin($request)){
//            return "Unathorized";
//        }

        $card = StudentCard::where('id',$id)->first();
        $card->delete();
        return "Deleted review ".$card->id;
    }
}
