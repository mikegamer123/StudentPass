<?php

namespace App\Http\Controllers;

use App\Models\Post_Category;
use App\Models\Post;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class PostCategoriesController extends Controller
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
    public function getPostCategories($id = 0,Request $request){
        if(!$this->declareAdmin($request)){
            return "Unathorized";
        }

        if($id == 0){
            $postCategory = Post_Category::all();
            $allModels = [];
            $i = 0;
            foreach ($postCategory as $model){
                $allModels[$i]["category"] = Category::where("id",$model->category_id)->first();
                $allModels[$i]["post"] = Post::where("id",$model->post_id)->first();
                $i++;
            }
            return $allModels;
        }
        else{
            $postCategory = Post_Category::where('id', $id)->firstOrFail();
            $allModels = [];
            $i = 0;
            foreach ($postCategory as $model){
            $allModels[$i]["category"] = Category::where("id",$model->category_id)->first();
            $allModels[$i]["post"] = Post::where("id",$model->post_id)->first();
            $i++;
        }
            return $allModels;
        }
    }

    public function putPostCategories($id,Request $request){
        if(!$this->declareAdmin($request)){
            return "Unathorized";
        }

        $postCategory = Post_Category::where('id',$id)->first();

        if($request->category_id){
            $postCategory->category_id = $request->category_id;
        }
        if($request->post_id){
            $postCategory->post_id = $request->post_id;
        }

        $postCategory->updated_at = now()->toDateTimeString();
        $postCategory->save();

        $category = Category::where('id',$postCategory->category_id)->first();
        $post = Post::where('id',$postCategory->post_id)->first();

        return "Post ".$post->title." added to category: ".$category->name;
    }

    public function addPostCategories(Request $request){
        if(!$this->declareAdmin($request)){
            return "Unathorized";
        }

        $postCategory = Post_Category::create([
            'category_id' => $request->category_id,
            'post_id' => $request->post_id,
        ]);

        return $postCategory;
    }

    public function deletePostCategories($id,Request $request){
        if(!$this->declareAdmin($request)){
            return "Unathorized";
        }

        $postCategory = Post_Category::where('id',$id)->first();
        $postCategory->delete();

        return "Deleted Post_Category by id of ".$id;
    }
}
