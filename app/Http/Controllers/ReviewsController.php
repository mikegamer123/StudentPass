<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;

class ReviewsController extends Controller
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
    public function getReviews($id = 0){
//        if(!$this->declareAdmin($request)){
//            return "Unathorized";
//        }

        if($id == 0){
            $models = Review::all();
            $allModels = [];
            $i = 0;
            foreach ($models as $model){
                $allModels[$i]["user"] = User::where("id",$model->user_id)->first();
                $allModels[$i]["review"] = $model;
                $i++;
            }
            return $allModels;
        }
        else{
            $model["review"] = Review::where('id', $id)->firstOrFail();
            $model["user"] = User::where('id',$model["review"]->user_id)->first();
            return $model;
        }
    }

    public function getReviewsByPostId($id){
//        if(!$this->declareAdmin($request)){
//            return "Unathorized";
//        }
        $model = Review::where('post_id', $id)->get();
        return $model;
    }

    public function putReviews($id,Request $request){
        if(!$this->declareAdmin($request)){
            return "Unathorized";
        }

        $review = Review::where('id',$id)->first();

        if($request->user_id){
            $review->user_id = $request->user_id;
        }
        if($request->post_id){
            $review->post_id = $request->post_id;
        }
        if($request->rating){
            $review->rating = $request->rating;
        }
        if($request->writtenReview){
            $review->writtenReview = $request->writtenReview;
        }

        $review->updated_at = now()->toDateTimeString();
        $review->save();
        return "Review ".$review->name. " updated successfully";
    }

    public function addReviews(Request $request){
//        if(!$this->declareAdmin($request)){
//            return "Unathorized";
//        }

        $review = Review::create([
            'user_id' => $request->user_id,
            'post_id' => $request->post_id,
            'rating' => $request->rating,
            'writtenReview' => $request->writtenReview,
        ]);

        return $review;
    }

    public function deleteReviews($id,Request $request){
        if(!$this->declareAdmin($request)){
            return "Unathorized";
        }

        $review = Review::where('id',$id)->first();
        $review->delete();
        return "Deleted review ".$review->name." by id of ".$id;
    }
}
