<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Image;
use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostsController extends Controller
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

    public function getPosts($id = 0){
//        if(!$this->declareAdmin($request)){
//            return "Unathorized";
//        }

        if($id == 0){
            $models = Post::all();
            $allModels = [];
            $i = 0;
            foreach ($models as $model){
                $allModels[$i]["admin"] = User::where("id",$model->user_id)->first();
                $allModels[$i]["company"] = Company::where("id",$model->company_id)->first();
                $allModels[$i]["image"] = Image::where("id",$model->image_id)->first();
                $allModels[$i]["post"] = $model;
                $i++;
            }
            return $allModels;
        }
        else{
            $model = Post::where('id', $id)->firstOrFail();
            $allModels = [];
                $allModels["admin"] = User::where("id",$model->user_id)->first();
                $allModels["company"] = Company::where("id",$model->company_id)->first();
                $allModels["image"] = Image::where("id",$model->image_id)->first();
                $allModels["post"] = $model;
            return $allModels;
        }
    }

    public function putPosts($id,Request $request){
        if(!$this->declareAdmin($request)){
            return "Unathorized";
        }

        $post = Post::where('id',$id)->first();

        if($request->title){
            $post->title = $request->title;
        }
        if($request->description){
            $post->description = $request->description;
        }
        if($request->location){
            $post->location = $request->location;
        }
        if($request->discountedPrice){
            $post->discountedPrice = $request->discountedPrice;
        }
        if($request->originalPrice){
            $post->originalPrice = $request->originalPrice;
        }
        if($request->startDate){
            $post->startDate = $request->startDate;
        }
        if($request->endDate){
            $post->endDate = $request->endDate;
        }
        if($request->admin_id){
            $post->admin_id = $request->admin_id;
        }
        if($request->company_id){
            $post->company_id = $request->company_id;
        }

        $post->updated_at = now()->toDateTimeString();
        $post->save();
        return "Post ".$post->title. " updated successfully";
    }

    public function deletePosts($id,Request $request){
        if(!$this->declareAdmin($request)){
            return "Unathorized";
        }

        $post = Post::where('id',$id)->first();
        $post->delete();
        return "Deleted post ".$post->title." by id of ".$id;
    }

    public function addPosts(Request $request){

        if(!$this->declareAdmin($request)){
            return "Unathorized";
        }

        $validator = Validator::make($request->all(),[
            'title' => 'required|string|max:255|unique:posts',
            'description' => 'required|string',
            'admin_id'=> 'required|integer',
            'company_id'=> 'required|integer',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $filePath = "";

        $post = Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'discountedPrice' => $request->discountedPrice,
            'originalPrice' => $request->originalPrice,
            'image_id'=> null,
            'startDate' => $request->startDate,
            'endDate' => $request->endDate,
            'admin_id' => $request->admin_id,
            'company_id' => $request->company_id,
        ]);

        return $post;
    }
}
