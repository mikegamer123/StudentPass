<?php

namespace App\Http\Controllers;

use App\Models\Review_Type;
use App\Models\User;
use Illuminate\Http\Request;

class ReviewTypesController extends Controller
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
    public function getReviewTypes($id = 0,Request $request){
        if(!$this->declareAdmin($request)){
            return "Unathorized";
        }

        if($id == 0){
            $reviewType = Review_Type::all();
            return $reviewType;
        }
        else{
            $reviewType = Review_Type::where('id', $id)->firstOrFail();
            return $reviewType;
        }
    }

    public function putReviewTypes($id,Request $request){
        if(!$this->declareAdmin($request)){
            return "Unathorized";
        }

        $reviewType = Review_Type::where('id',$id)->first();

        if($request->name){
            $reviewType->name = $request->name;
        }
        if($request->category_id){
            $reviewType->category_id = $request->category_id;
        }

        $reviewType->updated_at = now()->toDateTimeString();
        $reviewType->save();
        return "Review type ".$reviewType->name. " updated successfully";
    }

    public function addReviewTypes(Request $request){
        if(!$this->declareAdmin($request)){
            return "Unathorized";
        }

        $reviewType = Review_Type::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
        ]);

        return $reviewType;
    }

    public function deleteReviewTypes($id,Request $request){
        if(!$this->declareAdmin($request)){
            return "Unathorized";
        }

        $reviewType = Review_Type::where('id',$id)->first();
        $reviewType->delete();
        return "Deleted Review type ".$reviewType->name." by id of ".$id;
    }
}
