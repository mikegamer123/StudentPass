<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use App\Models\User_Company;
use Illuminate\Http\Request;

class UserCompanyController extends Controller
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
    public function getUserCompany($id = 0,Request $request){
        if(!$this->declareAdmin($request)){
            return "Unathorized";
        }

        if($id == 0){
            $userCompany = User_Company::all();
            $i = 0;
            foreach ($userCompany as $model){
                $allModels[$i]["user_id"] = User::where("id",$model->user_id)->first();
                $allModels[$i]["company_id"] = Company::where("id",$model->company_id)->first();
                $allModels[$i]["position"] = $model->position;
                $i++;
            }
            return $allModels;
        }
        else{
            $userCompany = User_Company::where('id', $id)->firstOrFail();
            $i = 0;
            foreach ($userCompany as $model){
                $allModels[$i]["user_id"] = User::where("id",$model->user_id)->first();
                $allModels[$i]["company_id"] = Company::where("id",$model->company_id)->first();
                $allModels[$i]["position"] = $model->position;
                $i++;
            }
            return $allModels;
        }
    }

    public function putUserCompany($id,Request $request){
        if(!$this->declareAdmin($request)){
            return "Unathorized";
        }

        $userCompany = User_Company::where('id',$id)->first();

        if($request->user_id){
            $userCompany->user_id = $request->user_id;
        }
        if($request->company_id){
            $userCompany->company_id = $request->company_id;
        }
        if($request->position){
            $userCompany->position = $request->position;
        }

        $userCompany->updated_at = now()->toDateTimeString();
        $userCompany->save();

        $company = Company::where('id',$userCompany->company_id)->first();
        $user = User::where('id',$userCompany->user_id)->first();

        return "User ".$user->fname." ".$user->lname." added to Company: ".$company->name;
    }

    public function addUserCompany(Request $request){
        if(!$this->declareAdmin($request)){
            return "Unathorized";
        }

        $userCompany = User_Company::create([
            'user_id' => $request->user_id,
            'company_id' => $request->company_id,
        ]);

        $user = User::where("id",$request->user_id)->firstOrFail();
        $user->userType = "Worker";
        $user->save();

        return $userCompany;
    }

    public function deleteUserCompany($id,Request $request){
        if(!$this->declareAdmin($request)){
            return "Unathorized";
        }

        $userCompany = User_Company::where('id',$id)->first();
        $company = Company::where('id',$userCompany->company_id)->first();
        $user = User::where('id',$userCompany->user_id)->first();
        $user->userType = "User";
        $user->save();

        $userCompany->delete();
        return "User ".$user->fname." ".$user->lname." removed from Company: ".$company->name;
    }
}
