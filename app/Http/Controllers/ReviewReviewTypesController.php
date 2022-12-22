<?php

namespace App\Http\Controllers;

use App\Models\Review_Type;
use App\Models\Review;
use App\Models\Review_Review_Type;
use App\Models\User;
use Illuminate\Http\Request;

class ReviewReviewTypesController extends Controller
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
    public function getReviewReviewTypes($id = 0,Request $request){
        if(!$this->declareAdmin($request)){
            return "Unathorized";
        }

        if($id == 0){
            $reviewReviewType = Review_Review_Type::all();
            $allModels = [];
            $i = 0;
            foreach ($reviewReviewType as $model){
                $allModels[$i]["review"] = Review::where("id",$model->review_id)->first();
                $allModels[$i]["reviewType"] = Review_Type::where("id",$model->reviewType_id)->first();
                $i++;
            }
            return $allModels;
        }
        else{
            $reviewReviewType = Review_Review_Type::where('id', $id)->firstOrFail();
            $allModels = [];
            $i = 0;
            foreach ($reviewReviewType as $model){
                $allModels[$i]["review"] = Review::where("id",$model->review_id)->first();
                $allModels[$i]["reviewType"] = Review_Type::where("id",$model->reviewType_id)->first();
                $i++;
            }
            return $allModels;
        }
    }

    public function putReviewReviewTypes($id,Request $request){
        if(!$this->declareAdmin($request)){
            return "Unathorized";
        }

        $reviewReviewType = Review_Review_Type::where('id',$id)->first();

        if($request->reviewType_id){
            $reviewReviewType->reviewType_id = $request->reviewType_id;
        }
        if($request->review_id){
            $reviewReviewType->review_id = $request->review_id;
        }

        $reviewReviewType->updated_at = now()->toDateTimeString();
        $reviewReviewType->save();

        $review = Review::where('id',$reviewReviewType->review_id)->first();
        $reviewType = Review_Type::where('id',$reviewReviewType->reviewType_id)->first();

        return "Review type ".$reviewType->name." added to review of id: ".$review->id;
    }

    public function addReviewReviewTypes(Request $request){
        if(!$this->declareAdmin($request)){
            return "Unathorized";
        }

        $reviewReviewType = Review_Review_Type::create([
            'review_id' => $request->review_id,
            'reviewType_id' => $request->reviewType_id,
        ]);

        return $reviewReviewType;
    }

    public function deleteReviewReviewTypes($id,Request $request){
        if(!$this->declareAdmin($request)){
            return "Unathorized";
        }

        $reviewReviewType = Review_Review_Type::where('id',$id)->first();
        $reviewReviewType->delete();

        return "Deleted Review to Review Type  by id of ".$id;
    }
}
