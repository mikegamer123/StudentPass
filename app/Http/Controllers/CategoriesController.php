<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class CategoriesController extends Controller
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
    public function getCategories($id = 0,Request $request){
        if(!$this->declareAdmin($request)){
            return "Unathorized";
        }

        if($id == 0){
            $category = Category::all();
            return $category;
        }
        else{
            $category = Category::where('id', $id)->firstOrFail();
            return $category;
        }
    }

    public function putCategories($id,Request $request){
        if(!$this->declareAdmin($request)){
            return "Unathorized";
        }

        $category = Category::where('id',$id)->first();

        if($request->name){
            $category->name = $request->name;
        }

        $category->updated_at = now()->toDateTimeString();
        $category->save();
        return "Category ".$category->name. " updated successfully";
    }

    public function addCategories(Request $request){
        if(!$this->declareAdmin($request)){
            return "Unathorized";
        }

        $category = Category::create([
            'name' => $request->name,
        ]);

        return $category;
    }

    public function deleteCategories($id,Request $request){
        if(!$this->declareAdmin($request)){
            return "Unathorized";
        }

        $category = Category::where('id',$id)->first();
        $category->delete();
        return "Deleted category ".$category->name." by id of ".$id;
    }
}
