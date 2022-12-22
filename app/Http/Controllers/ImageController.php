<?php

namespace App\Http\Controllers;

use App\Models\College;
use App\Models\Image;
use App\Models\Post;
use App\Models\Company;
use App\Models\News;
use App\Models\StudentCard;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ImageController extends Controller
{
    public function imageUser($id,Request $request){

        if(isset($request->image_upload) || get_class($request->image_upload) == "Illuminate\Http\UploadedFile"){
            $allowedMimeTypes = ['image/jpeg','image/gif','image/png'];
            $contentType = $request->image_upload->getClientMimeType();

            if(! in_array($contentType, $allowedMimeTypes) ){
                return response()->json('Nije slika, molim vas izaberite sliku validnog formata!',400);
            }
            $validator = Validator::make($request->all(), [
                'file' => 'max:2000',
            ]);
            if($validator->fails()){
                return response()->json("Slika je prevelika, maksimalna veličina slike je 2MB !",400);
            }
            $token = $request->bearerToken();
            $user = User::where('api_token', $token)->firstOrFail();
            $path = Storage::disk('local')->put('/public', $request->image_upload);
            $split_path = explode("/",$path);
            $image = Image::create([
                'path' => "storage/".$split_path[1],
                'user_id'=>$user->id,
            ]);
            $imgModel = User::where('id',$id)->first();
            $imgModel->image_id = $image->id;
            $imgModel->save();
            return $image;
        }
        else
        if ($request->hasFile('image_upload')) {
            $allowedMimeTypes = ['image/jpeg','image/gif','image/png'];
            $contentType = $request->image_upload->getClientMimeType();

            if(! in_array($contentType, $allowedMimeTypes) ){
                return response()->json('Nije slika, molim vas izaberite sliku validnog formata!',400);
            }
            $validator = Validator::make($request->all(), [
                'file' => 'max:500000',
            ]);
            if($validator->fails()){
                return response()->json("Slika je prevelika, maksimalna veličina slike je 2MB !",400);
            }
            $token = $request->bearerToken();
            $user = User::where('api_token', $token)->firstOrFail();
            $path = Storage::disk('local')->put('/public', $request->file("image_upload"));
            $split_path = explode("/",$path);
            $image = Image::create([
                'path' => "storage/".$split_path[1],
                'user_id'=>$user->id,
            ]);
            $userImg = User::where('id',$id)->first();
            $userImg->image_id = $image->id;
            $userImg->save();
            return $image;
        }
        return "no file";
    }

    public function imagePost($id,Request $request){
        if(isset($request->image_upload) || get_class($request->image_upload) == "Illuminate\Http\UploadedFile"){
            $allowedMimeTypes = ['image/jpeg','image/gif','image/png'];
            $contentType = $request->image_upload->getClientMimeType();

            if(! in_array($contentType, $allowedMimeTypes) ){
                return response()->json('Nije slika, molim vas izaberite sliku validnog formata!',400);
            }
            $validator = Validator::make($request->all(), [
                'file' => 'max:500000',
            ]);
            if($validator->fails()){
                return response()->json("Slika je prevelika, maksimalna veličina slike je 2MB !",400);
            }
            $token = $request->bearerToken();
            $user = User::where('api_token', $token)->firstOrFail();
            $path = Storage::disk('local')->put('/public', $request->image_upload);
            $split_path = explode("/",$path);
            $image = Image::create([
                'path' => "storage/".$split_path[1],
                'user_id'=>$user->id,
            ]);
            $imgModel = Post::where('id',$id)->first();
            $imgModel->image_id = $image->id;
            $imgModel->save();
            return $image;
        }
        else
        if ($request->hasFile('image_upload')) {
            $allowedMimeTypes = ['image/jpeg','image/gif','image/png'];
            $contentType = $request->image_upload->getClientMimeType();

            if(! in_array($contentType, $allowedMimeTypes) ){
                return response()->json('Nije slika, molim vas izaberite sliku validnog formata!',400);
            }
            $validator = Validator::make($request->all(), [
                'file' => 'max:500000',
            ]);
            if($validator->fails()){
                return response()->json("Slika je prevelika, maksimalna veličina slike je 2MB !",400);
            }
            $token = $request->bearerToken();
            $user = User::where('api_token', $token)->firstOrFail();
            $path = Storage::disk('local')->put('/public', $request->file("image_upload"));
            $split_path = explode("/",$path);
            $image = Image::create([
                'path' => "storage/".$split_path[1],
                'user_id'=>$user->id,
            ]);
            $imgModel = Post::where('id',$id)->first();
            $imgModel->image_id = $image->id;
            $imgModel->save();
            return $image;
        }
        return "no file";
    }
    public function imageCreate(Request $request){
if(isset($request->image_upload)){
    $allowedMimeTypes = ['image/jpeg','image/gif','image/png'];
    $contentType = $request->image_upload->getClientMimeType();

    if(! in_array($contentType, $allowedMimeTypes) ){
        return response()->json('Nije slika, molim vas izaberite sliku validnog formata!',400);
    }
    $validator = Validator::make($request->all(), [
        'file' => 'max:500000',
    ]);
    if($validator->fails()){
        return response()->json("Slika je prevelika, maksimalna veličina slike je 2MB !",400);
    }
            $token = $request->bearerToken();
            $user = User::where('api_token', $token)->firstOrFail();
            $path = Storage::disk('local')->put('/public', $request->image_upload);
            $split_path = explode("/",$path);
            $image = Image::create([
                'path' => "storage/".$split_path[1],
                'user_id'=>$user->id,
            ]);

            return $image;
        }
        return "no file";
    }
    public function imageNews($id,Request $request){
        if(isset($request->image_upload) || get_class($request->image_upload) == "Illuminate\Http\UploadedFile"){
            $allowedMimeTypes = ['image/jpeg','image/gif','image/png'];
            $contentType = $request->image_upload->getClientMimeType();

            if(! in_array($contentType, $allowedMimeTypes) ){
                return response()->json('Nije slika, molim vas izaberite sliku validnog formata!',400);
            }
            $validator = Validator::make($request->all(), [
                'file' => 'max:500000',
            ]);
            if($validator->fails()){
                return response()->json("Slika je prevelika, maksimalna veličina slike je 2MB !",400);
            }
            $token = $request->bearerToken();
            $user = User::where('api_token', $token)->firstOrFail();
            $path = Storage::disk('local')->put('/public', $request->image_upload);
            $split_path = explode("/",$path);
            $image = Image::create([
                'path' => "storage/".$split_path[1],
                'user_id'=>$user->id,
            ]);
            $imgModel = News::where('id',$id)->first();
            $imgModel->image_id = $image->id;
            $imgModel->save();
            return $image;
        }
        else
        if ($request->hasFile('image_upload')) {
            $allowedMimeTypes = ['image/jpeg','image/gif','image/png'];
            $contentType = $request->image_upload->getClientMimeType();

            if(! in_array($contentType, $allowedMimeTypes) ){
                return response()->json('Nije slika, molim vas izaberite sliku validnog formata!',400);
            }
            $validator = Validator::make($request->all(), [
                'file' => 'max:500000',
            ]);
            if($validator->fails()){
                return response()->json("Slika je prevelika, maksimalna veličina slike je 2MB !",400);
            }
            $token = $request->bearerToken();
            $user = User::where('api_token', $token)->firstOrFail();
            $path = Storage::disk('local')->put('/public', $request->file("image_upload"));
            $split_path = explode("/",$path);
            $image = Image::create([
                'path' => "storage/".$split_path[1],
                'user_id'=>$user->id,
            ]);
            $imgModel = News::where('id',$id)->first();
            $imgModel->image_id = $image->id;
            $imgModel->save();
            return $image;
        }
        return "no file";
    }
    public function imageCompany($id,Request $request){
        $allowedMimeTypes = ['image/jpeg','image/gif','image/png'];
        $contentType = $request->image_upload->getClientMimeType();

        if(! in_array($contentType, $allowedMimeTypes) ){
            return response()->json('Nije slika, molim vas izaberite sliku validnog formata!',400);
        }
        $validator = Validator::make($request->all(), [
            'file' => 'max:500000',
        ]);
        if($validator->fails()){
            return response()->json("Slika je prevelika, maksimalna veličina slike je 2MB !",400);
        }
        if(isset($request->image_upload) || get_class($request->image_upload) == "Illuminate\Http\UploadedFile"){
            $token = $request->bearerToken();
            $user = User::where('api_token', $token)->firstOrFail();
            $path = Storage::disk('local')->put('/public', $request->image_upload);
            $split_path = explode("/",$path);
            $image = Image::create([
                'path' => "storage/".$split_path[1],
                'user_id'=>$user->id,
            ]);
            $imgModel = Company::where('id',$id)->first();
            $imgModel->image_id = $image->id;
            $imgModel->save();
            return $image;
        }
        else
        if ($request->hasFile('image_upload')) {
            $allowedMimeTypes = ['image/jpeg','image/gif','image/png'];
            $contentType = $request->image_upload->getClientMimeType();

            if(! in_array($contentType, $allowedMimeTypes) ){
                return response()->json('Nije slika, molim vas izaberite sliku validnog formata!',400);
            }
            $validator = Validator::make($request->all(), [
                'file' => 'max:500000',
            ]);
            if($validator->fails()){
                return response()->json("Slika je prevelika, maksimalna veličina slike je 2MB !",400);
            }
            $token = $request->bearerToken();
            $user = User::where('api_token', $token)->firstOrFail();
            $path = Storage::disk('local')->put('/public', $request->file("image_upload"));
            $split_path = explode("/",$path);
            $image = Image::create([
                'path' => "storage/".$split_path[1],
                'user_id'=>$user->id,
            ]);
            $imgModel = Company::where('id',$id)->first();
            $imgModel->image_id = $image->id;
            $imgModel->save();
            return $image;
        }
        return "no file";
    }
    public function imageStudentCard($id,Request $request){
        if(isset($request->image_upload) || get_class($request->image_upload) == "Illuminate\Http\UploadedFile"){
            $allowedMimeTypes = ['image/jpeg','image/gif','image/png'];
            $contentType = $request->image_upload->getClientMimeType();

            if(! in_array($contentType, $allowedMimeTypes) ){
                return response()->json('Nije slika, molim vas izaberite sliku validnog formata!',400);
            }
            $validator = Validator::make($request->all(), [
                'file' => 'max:500000',
            ]);
            if($validator->fails()){
                return response()->json("Slika je prevelika, maksimalna veličina slike je 2MB !",400);
            }
            $token = $request->bearerToken();
            $user = User::where('api_token', $token)->firstOrFail();
            $path = Storage::disk('local')->put('/public', $request->image_upload);
            $split_path = explode("/",$path);
            $image = Image::create([
                'path' => "storage/".$split_path[1],
                'user_id'=>$user->id,
            ]);
            $imgModel = StudentCard::where('id',$id)->first();
            $imgModel->image_id = $image->id;
            $imgModel->save();
            return $image;
        }
        else
            if ($request->hasFile('image_upload')) {
                $allowedMimeTypes = ['image/jpeg','image/gif','image/png'];
                $contentType = $request->image_upload->getClientMimeType();

                if(! in_array($contentType, $allowedMimeTypes) ){
                    return response()->json('Nije slika, molim vas izaberite sliku validnog formata!',400);
                }
                $validator = Validator::make($request->all(), [
                    'file' => 'max:500000',
                ]);
                if($validator->fails()){
                    return response()->json("Slika je prevelika, maksimalna veličina slike je 2MB !",400);
                }
                $token = $request->bearerToken();
                $user = User::where('api_token', $token)->firstOrFail();
                $path = Storage::disk('local')->put('/public', $request->file("image_upload"));
                $split_path = explode("/",$path);
                $image = Image::create([
                    'path' => "storage/".$split_path[1],
                    'user_id'=>$user->id,
                ]);
                $imgModel = StudentCard::where('id',$id)->first();
                $imgModel->image_id = $image->id;
                $imgModel->save();
                return $image;
            }
        return "no file";
    }

    public function imageCollege($id,Request $request){
        if(isset($request->image_upload) || get_class($request->image_upload) == "Illuminate\Http\UploadedFile"){
            $allowedMimeTypes = ['image/jpeg','image/gif','image/png'];
            $contentType = $request->image_upload->getClientMimeType();

            if(! in_array($contentType, $allowedMimeTypes) ){
                return response()->json('Nije slika, molim vas izaberite sliku validnog formata!',400);
            }
            $validator = Validator::make($request->all(), [
                'file' => 'max:500000',
            ]);
            if($validator->fails()){
                return response()->json("Slika je prevelika, maksimalna veličina slike je 2MB !",400);
            }
            $token = $request->bearerToken();
            $user = User::where('api_token', $token)->firstOrFail();
            $path = Storage::disk('local')->put('/public', $request->image_upload);
            $split_path = explode("/",$path);
            $image = Image::create([
                'path' => "storage/".$split_path[1],
                'user_id'=>$user->id,
            ]);
            $imgModel = College::where('id',$id)->first();
            $imgModel->image_id = $image->id;
            $imgModel->save();
            return $image;
        }
        else
            if ($request->hasFile('image_upload')) {
                $allowedMimeTypes = ['image/jpeg','image/gif','image/png'];
                $contentType = $request->image_upload->getClientMimeType();

                if(! in_array($contentType, $allowedMimeTypes) ){
                    return response()->json('Nije slika, molim vas izaberite sliku validnog formata!',400);
                }
                $validator = Validator::make($request->all(), [
                    'file' => 'max:500000',
                ]);
                if($validator->fails()){
                    return response()->json("Slika je prevelika, maksimalna veličina slike je 2MB !",400);
                }
                $token = $request->bearerToken();
                $user = User::where('api_token', $token)->firstOrFail();
                $path = Storage::disk('local')->put('/public', $request->file("image_upload"));
                $split_path = explode("/",$path);
                $image = Image::create([
                    'path' => "storage/".$split_path[1],
                    'user_id'=>$user->id,
                ]);
                $imgModel = College::where('id',$id)->first();
                $imgModel->image_id = $image->id;
                $imgModel->save();
                return $image;
            }
        return "no file";
    }

    public function getImage($id,Request $request){
        $image = Image::where('id', $id)->firstOrFail();
        return $image;
    }
}
