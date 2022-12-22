<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CompaniesController extends Controller
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

    public function getCompanies($id = 0){
//        if(!$this->declareAdmin($request)){
//            return "Unathorized";
//        }

        if($id == 0){
            $models = Company::all();
            $allModels = [];
            $i = 0;
            foreach ($models as $model){
                $allModels[$i]["image"] = Image::where("id",$model->image_id)->first();
                $allModels[$i]["company"] = $model;
                $i++;
            }
            return $allModels;
        }
        else{
            $model = Company::where('id', $id)->firstOrFail(); $allModels = [];
            $allModels["image"] = Image::where("id",$model->image_id)->first();
            $allModels["company"] = $model;
            return $allModels;
        }
    }

    public function putCompanies($id,Request $request){
        if(!$this->declareAdmin($request)){
            return "Unathorized";
        }

        $company = Company::where('id',$id)->first();

        if($request->name){
            $company->name = $request->name;
        }
        if($request->description){
            $company->description = $request->description;
        }
        if($request->email){
            $company->email = $request->email;
        }
        if($request->phone){
            $company->phone = $request->phone;
        }

        $company->updated_at = now()->toDateTimeString();
        $company->save();
        return "Company ".$company->name. " updated successfully";
    }

    public function deleteCompanies($id,Request $request){
        if(!$this->declareAdmin($request)){
            return "Unathorized";
        }

        $company = Company::where('id',$id)->first();
        $company->delete();
        return "Deleted company ".$company->name." by id of ".$id;
    }

    public function addCompanies(Request $request){

        if(!$this->declareAdmin($request)){
            return "Unathorized";
        }

        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255|unique:companies',
            'description' => 'required|string',
            'location' => 'required|string',
            'email' => 'required|string|email|max:255',
            'phone'=> 'required|string',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $filePath = "";


        $company = Company::create([
            'name' => $request->name,
            'description' => $request->description,
            'email' => $request->email,
            'location' => $request->location,
            'phone' => $request->phone,
            'image_id'=> null,
        ]);

        return $company;
    }
}
