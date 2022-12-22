<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NewsController extends Controller
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

    public function getNews($id = 0,Request $request){
        if(!$this->declareAdmin($request)){
            return "Unathorized";
        }

        if($id == 0){
            $news = News::all();
            return $news;
        }
        else{
            $news = News::where('id', $id)->firstOrFail();
            return $news;
        }
    }

    public function putNews($id,Request $request){
        if(!$this->declareAdmin($request)){
            return "Unathorized";
        }

        $news = News::where('id',$id)->first();

        if($request->contentNews){
            $news->contentNews = $request->contentNews;
        }
        if($request->title){
            $news->title = $request->title;
        }
        if($request->startDate){
            $news->startDate = $request->startDate;
        }
        if($request->endDate){
            $news->endDate = $request->endDate;
        }
        if($request->admin_id){
            $news->admin_id = $request->admin_id;
        }
        $news->updated_at = now()->toDateTimeString();
        $news->save();
        return "News ".$news->title. " updated successfully";
    }

    public function deleteNews($id,Request $request){
        if(!$this->declareAdmin($request)){
            return "Unathorized";
        }

        $news = News::where('id',$id)->first();
        $news->delete();
        return "Deleted news ".$news->title." by id of ".$id;
    }

    public function addNews(Request $request){

        if(!$this->declareAdmin($request)){
            return "Unathorized";
        }

        $validator = Validator::make($request->all(),[
            'contentNews' => 'required|string|max:255',
            'title' => 'required|string|max:255|unique:news',
            'startDate'=> 'required|date',
            'endDate'=> 'required|date',
            'admin_id'=> 'required|integer|size:1',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $filePath = "";

        $news = News::create([
            'title' => $request->title,
            'contentNews' => $request->contentNews,
            'image_id'=> null,
            'startDate' => $request->startDate,
            'endDate' => $request->endDate,
            'admin_id' => $request->admin_id,
        ]);

        return $news;
    }
}
