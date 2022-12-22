<?php

use App\Models\Category;
use App\Models\College;
use App\Models\Company;
use App\Models\Post;
use App\Models\Review;
use App\Models\Review_Type;
use App\Models\StudentCard;
use App\Models\Study_Program;
use App\Models\User;
use App\Models\Image;
use App\Models\User_College;
use App\Models\UserLog;
use App\Models\User_Company;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/logout', function () {

        Session::remove('token');
        Session::remove('userId');

    return redirect(env("APP_URL").'/login');
});

Route::get('/admin', function () {
    if(!Session::has("token")){
        return redirect("/login");
    }

    $userLogged["user"] = User::where("id",Session::get("userId"))->first();
    $userLogged["image"] = Image::where("id",$userLogged["user"]->image_id)->first();

    $users = User::all();
    $posts = Post::all()->take(3)->sortByDesc("created_at");
    $images = [];
    $imagesPost = [];
    $userLogs = [];
    $i=0;
    foreach ($users as $user){
        $images[$i] = Image::where("id",$user->image_id)->first();
        $userLogs[$i] = UserLog::where("user_id",$user->id)->first();
        $i++;
    }
    $i=0;
    foreach ($posts as $post){
        $imagesPost[$i] = Image::where("id",$post->image_id)->first();
        $i++;
    }
    return view('index')->with("users",$users)->with("images",$images)->with("userLogs",$userLogs)->with("posts",$posts)->with("imagesPost",$imagesPost)->with("userLogged",$userLogged);
});

Route::get('/analytics', function () {
    if (!Session::has("token")) {
        return redirect("/login");
    }

    $userLogged["user"] = User::where("id", Session::get("userId"))->first();
    $userLogged["image"] = Image::where("id", $userLogged["user"]->image_id)->first();

    $chartUserLogin = [];
    $chartUserLogin["loginTypes"] = UserLog::select("user_agent")->distinct()->get();
    $chartUserLogin["loginCount"] = UserLog::select("user_id",DB::raw('count(*) as userAgent'))->groupBy("user_id")->groupBy("user_agent")->get();

    return view('analytics')->with("userLogged", $userLogged)->with("chartUserLogin",$chartUserLogin);
});

Route::get('{model}/delete/{id}', function ($model,$id) {
    $request = Illuminate\Http\Request::create('api/'.$model.'/delete/'.$id."", 'get');
    $request->headers->set('Authorization', 'Bearer '.Session::get("token"));
    $request->headers->set('Accept', 'application/json');
    $response = App::handle($request);

    if($response->status() == 201 || $response->status() == 200)
        return redirect()->back();
});

Route::get('{model}/edit/{id}', function ($model,$id) {
    if(!Session::has("token")){
        return redirect("/login");
    }

    $userLogged["user"] = User::where("id",Session::get("userId"))->first();
    $userLogged["image"] = Image::where("id",$userLogged["user"]->image_id)->first();
    $input = ["model" => $model,
        "inputs" => [],
        "inputFormat" => [],
        "inputNames" => [],
        "index" => 0];

    switch ($model) {
        case "users":
            $entity = User::where("id",$id)->firstOrFail();
            $input["title"] = "Edituj Korisnika";
            $input["inputs"] = ["Ime", "Prezime", "Index", "Godina Rodjenja", "Email","Aktivan?"];
            $input["required"] = ["fname", "lname", "index", "dateOfBirth", "email", "password"];
            $input["inputFormat"] = ["text", "text", "text", "date", "email","checkbox"];
            $input["inputNames"] = ["fname", "lname", "index", "dateOfBirth", "email","isActive"];
            $input["inputVals"] = [$entity->fname, $entity->lname, $entity->index, $entity->dateOfBirth, $entity->email, ($entity->isActive==0)?false:true];
            $input["index"] = 1;
            break;
        case "posts":
            $entity = Post::where("id",$id)->firstOrFail();
            $input["title"] = "Edituj Popuste/Postove";
            $input["inputs"] = ["Titl", "Deskripcija", "Snizena cena", "Originalna Cena", "Vreme pocetka", "Vreme kraja"];
            $input["required"] = ["title", "description"];
            $input["inputFormat"] = ["text", "text", "text", "text", "date", "date"];
            $input["inputNames"] = ["title", "description", "discountedPrice", "originalPrice", "startDate", "endDate"];
            $input["inputVals"] = [$entity->title, $entity->description, $entity->discountedPrice, $entity->originalPrice, $entity->startDate, $entity->endDate];
            $input["inputHidden"] = ["admin_id", 1];
            $input["inputSelect"] = ["Firma", "company_id", Company::all()];
            $input["index"] = 2;
            break;

        case "categories":
            $entity = Category::where("id",$id)->firstOrFail();
            $input["title"] = "Edituj Kategoriju";
            $input["inputs"] = ["Ime"];
            $input["required"] = ["name"];
            $input["inputFormat"] = ["text"];
            $input["inputNames"] = ["name"];
            $input["inputVals"] = [$entity->name];
            $input["inputHidden"] = ["admin_id", 1];
            $input["index"] = 3;
            break;

        case "reviewTypes":
            $entity = Review_Type::where("id",$id)->firstOrFail();
            $input["title"] = "Edituj brze tipove recenzije za kategoriju";
            $input["inputs"] = ["Ime"];
            $input["required"] = ["name"];
            $input["inputFormat"] = ["text"];
            $input["inputNames"] = ["name"];
            $input["inputVals"] = [$entity->name];
            $input["inputHidden"] = ["admin_id", 1];
            $input["inputSelect"] = ["Kategorija", "category_id", Category::all()];
            $input["index"] = 3;
            break;
        case "reviews":
            $entity = Review::where("id",$id)->firstOrFail();
            $input["title"] = "Edituj Recenziju";
            $input["inputs"] = ["Recenzija", "Pisana recenzija"];
            $input["required"] = ["rating"];
            $input["inputFormat"] = ["number","text"];
            $input["inputNames"] = ["rating","writtenReview"];
            $input["inputVals"] = [$entity->rating,$entity->writtenReview];
            $input["inputHidden"] = ["user_id", 1];
            $input["inputSelect"] = ["Post", "post_id", Post::all()];
            $input["index"] = 4;
            break;

        case "colleges":
            $entity = College::where("id",$id)->firstOrFail();
            $input["title"] = "Edituj Fakultet";
            $input["inputs"] = ["Ime","Lokacija","Informacije o fakultetu","Email fakulteta", "Broj telefona"];
            $input["required"] = ["name","location","info","email","phone"];
            $input["inputFormat"] = ["text","text","text","email","text"];
            $input["inputNames"] = ["name","location","info","email","phone"];
            $input["inputVals"] = [$entity->name,$entity->location,$entity->info,$entity->email,$entity->phone];
            $input["inputHidden"] = ["admin_id", 1];
            $input["index"] = 5;
            break;
        case "companies":
            $entity = Company::where("id",$id)->firstOrFail();
            $input["title"] = "Edituj Firmu";
            $input["inputs"] = ["Ime","Lokacija","Opis firme","Email firme", "Broj telefona"];
            $input["required"] = ["name","location","description","email","phone"];
            $input["inputFormat"] = ["text","text","text","email","text"];
            $input["inputNames"] = ["name","location","description","email","phone"];
            $input["inputVals"] = [$entity->name,$entity->location,$entity->description,$entity->email,$entity->phone];
            $input["inputHidden"] = ["admin_id", 1];
            $input["index"] = 7;
            break;
        case "student_card":
            $input["userSelect"] = true;
            $input["title"] = "Edituj Studentsku Karticu";
            $input["inputSelect"] = ["Korisnik", "id", User::all()];
            $input["inputHidden"] = ["created_by", $userLogged["user"]->id ];
            $input["index"] = 9;
            break;
    }
    return view('edit')->with("input",$input)->with("id",$id)->with("userLogged",$userLogged);
});

Route::get('add/{model}', function ($model) {
    if(!Session::has("token")){
        return redirect("/login");
    }

    $userLogged["user"] = User::where("id",Session::get("userId"))->first();
    $userLogged["image"] = Image::where("id",$userLogged["user"]->image_id)->first();

    $input = ["model" => $model,
        "inputs" => [],
        "inputFormat" => [],
        "inputNames" => [],
        "index" => 0];

    switch ($model) {
        case "users":
            $input["title"] = "Dodaj Korisnika";
            $input["inputs"] = ["Ime", "Prezime", "Index", "Godina Rodjenja", "Email", "Sifra"];
            $input["required"] = ["fname", "lname", "index", "dateOfBirth", "email", "password"];
            $input["inputFormat"] = ["text", "text", "text", "date", "email", "password"];
            $input["inputNames"] = ["fname", "lname", "index", "dateOfBirth", "email", "password"];
            $input["index"] = 1;
            break;
        case "posts":
            $input["title"] = "Dodaj Popuste/Postove";
            $input["inputs"] = ["Titl", "Deskripcija", "Snizena cena", "Originalna Cena", "Vreme pocetka", "Vreme kraja"];
            $input["required"] = ["title", "description"];
            $input["inputFormat"] = ["text", "text", "text", "text", "date", "date"];
            $input["inputNames"] = ["title", "description", "discountedPrice", "originalPrice", "startDate", "endDate"];
            $input["inputHidden"] = ["admin_id", 1];
            $input["inputSelect"] = ["Firma", "company_id", Company::all()];
            $input["index"] = 2;
            break;

        case "categories":
            $input["title"] = "Dodaj Kategoriju";
            $input["inputs"] = ["Ime"];
            $input["required"] = ["name"];
            $input["inputFormat"] = ["text"];
            $input["inputNames"] = ["name"];
            $input["inputHidden"] = ["admin_id", 1];
            $input["index"] = 3;
            break;

        case "reviewTypes":
            $input["title"] = "Dodaj brze tipove recenzije za kategoriju";
            $input["inputs"] = ["Ime"];
            $input["required"] = ["name"];
            $input["inputFormat"] = ["text"];
            $input["inputNames"] = ["name"];
            $input["inputHidden"] = ["admin_id", 1];
            $input["inputSelect"] = ["Kategorija", "category_id", Category::all()];
            $input["index"] = 3;
            break;
case "reviews":
            $input["title"] = "Dodaj Recenziju";
            $input["inputs"] = ["Recenzija", "Pisana recenzija"];
            $input["required"] = ["rating"];
            $input["inputFormat"] = ["number","text"];
            $input["inputNames"] = ["rating","writtenReview"];
            $input["inputHidden"] = ["user_id", 1];
            $input["inputSelect"] = ["Post", "post_id", Post::all()];
            $input["index"] = 4;
    break;

    case "colleges":
            $input["title"] = "Dodaj Fakultet";
            $input["inputs"] = ["Ime","Lokacija","Informacije o fakultetu","Email fakulteta", "Broj telefona"];
            $input["required"] = ["name","location","info","email","phone"];
            $input["inputFormat"] = ["text","text","text","email","text"];
            $input["inputNames"] = ["name","location","info","email","phone"];
            $input["inputHidden"] = ["admin_id", 1];
            $input["index"] = 5;
    break;
        case "images":
            $input["title"] = "Dodaj Sliku";
            $input["inputs"] = ["Slika"];
            $input["required"] = ["image_upload"];
            $input["inputFormat"] = ["file"];
            $input["inputNames"] = ["image_upload"];
            $input["inputHidden"] = ["user_id", 1];
            $input["inputFile"] = true;
            $input["index"] = 6;
    break;
        case "companies":
            $input["title"] = "Dodaj Firmu";
            $input["inputs"] = ["Ime","Lokacija","Opis firme","Email firme", "Broj telefona"];
            $input["required"] = ["name","location","description","email","phone"];
            $input["inputFormat"] = ["text","text","text","email","text"];
            $input["inputNames"] = ["name","location","description","email","phone"];
            $input["inputHidden"] = ["admin_id", 1];
            $input["index"] = 7;
            break;
        case "student_card":
            $input["userSelect"] = true;
            $input["title"] = "Dodaj Studentsku Karticu";
            $input["inputSelect"] = ["Korisnik", "id", User::all()];
            $input["inputHidden"] = ["created_by", $userLogged["user"]->id ];
            $input["index"] = 9;
            break;

        case "studyPrograms":
            $input["title"] = "Dodaj Smer";
            $input["inputs"] = ["Ime", "Dužina trajanja", "Opis"];
            $input["required"] = ["name","duration","description"];
            $input["inputFormat"] = ["text","number","text"];
            $input["inputNames"] = ["name","duration","description"];
            $input["inputHidden"] = ["user_id", 1];
            $input["inputSelect"] = ["Fakultet", "college_id", College::all()];
            $input["index"] = 4;
            break;
}


    return view('add')->with("input",$input)->with("userLogged",$userLogged);
});

Route::post('conn/add/{model}', function ($model, Request $request) {
    if(!Session::has("token")){
        return redirect("/login");
    }

    $userLogged["user"] = User::where("id",Session::get("userId"))->first();
    $userLogged["image"] = Image::where("id",$userLogged["user"]->image_id)->first();

    $input = ["model" => $model,
        "inputs" => [],
        "inputFormat" => [],
        "inputNames" => [],
        "index" => 0];
    switch ($model) {
        case "user_college":
            $input["title"] = "Koji smer pohadja?";
            $input["inputs"] = ["Datum pocetka pohadjanja"];
            $input["required"] = ["educationStartYear"];
            $input["inputFormat"] = ["date"];
            $input["inputNames"] = ["educationStartYear"];
            $input["inputSelect"] = ["Studijski program", "studyProgramId", Study_Program::where("college_id", $request->college_id)->get()];
            $input["index"] = 5;
            break;
    }
    return view('add')->with("input",$input)->with("extra",$request->all())->with("userLogged",$userLogged);
});

Route::post('requestHandler/{model}', function ($model, Request $request) {

    $body = $request->all();
    if($model == "users"){
        $request = Illuminate\Http\Request::create('api/register', 'POST',$body);
    }
    else
    {
        if($model == "student_card"){
            $body["code"] = generateRandomString(20) ;
        }
        $request = Illuminate\Http\Request::create('api/' . $model . '/create', 'POST', $body);
        $request->headers->set('Authorization', 'Bearer '.Session::get("token"));
        $request->headers->set('Accept', 'application/json');
    }

    $response = App::handle($request);

    if($response->status() == 201 || $response->status() == 200) {
        if ($model == "user_college") {
            $model = "colleges";
        }
        if ($model == "studyPrograms") {
            $model = "colleges";
        }
        return redirect(env("APP_URL") . "/" . $model);
    }
});

Route::post('editHandler/{model}/{id}', function ($model, $id, Request $request) {

    $body = $request->all();
    $request = Illuminate\Http\Request::create('api/'.$model.'/put/'.$id, 'POST',$body);
    $request->headers->set('Authorization', 'Bearer '.Session::get("token"));
    $request->headers->set('Accept', 'application/json');
    $response = App::handle($request);
    if($response->status() == 201 || $response->status() == 200)
        if ($model == "studyPrograms") {
            $model = "colleges";
        }
        return redirect(env("APP_URL")."/".$model);
});
Route::post('images/{model}/{id}', function ($model, $id, Request $request) {
    $body = $request->all();
    $request = Illuminate\Http\Request::create('api/images/'.$model.'/'.$id, 'POST',$body);
    $request->headers->set('Authorization', 'Bearer '.Session::get("token"));
    $request->headers->set('Accept', 'application/json');
    $response = App::handle($request);
    if($response->status() == 201 || $response->status() == 200)
        return redirect(env("APP_URL")."/".$model);
    else
        return redirect(env("APP_URL")."/".$model."?message=".$response->getData()."");
});
Route::post('connection/{connection}', function ($connection,  Request $request) {
    $body = $request->all();
    $request = Illuminate\Http\Request::create('api/'.$connection.'/create', 'POST',$body);
    $request->headers->set('Authorization', 'Bearer '.Session::get("token"));
    $request->headers->set('Accept', 'application/json');
    $response = App::handle($request);
    if($response->status() == 201 || $response->status() == 200)
        return redirect()->back();
});

Route::post('loginHandler', function (Request $request) {
    $body = $request->all();
    $body["user_agent"] = $request->header('user-agent');
    $request = Illuminate\Http\Request::create('api/login', 'POST',$body);
    $response = App::handle($request);

    if($response->status() == 201 || $response->status() == 200)
        $decoded = $response->getData();
        Session::put('token', $decoded->access_token);
        Session::put('userId', User::where("api_token",$decoded->access_token)->first()->id);
        return redirect(env("APP_URL")."/admin");
});

Route::get('/{model}', function ($model) {
    if(!Session::has("token")){
        return redirect("/login");
    }

    $userLogged["user"] = User::where("id",Session::get("userId"))->first();
    $userLogged["image"] = Image::where("id",$userLogged["user"]->image_id)->first();

    $tableParams = ["model" => $model,
        "table" =>[],
        "tableVals" => [],
    "index" => 0];

    switch ($model) {

        case "users":
            $tableParams["hasPicture"] = true;
            $tableParams["title"] = "Korisnici";
            $models = User::all('*');
        //define table structure
    $tableParams["table"] = ["Id", "Ime", "Prezime", "God. Rodjenja", "Index", "Email", "Tip korisnika", "Aktivan?", "Url slike"];
    $i = 0;
        //add table values
    foreach ($models as $model) {
    $tableParams["tableVals"][$i] = [$model->id, $model->fname, $model->lname, $model->dateOfBirth, $model->index, $model->email, $model->userType, $model->isActive, (!is_null(Image::where("id",$model->image_id)->first()))?Image::where("id",$model->image_id)->first()->path:null];
    $i++;
    }
    $tableParams["index"] = 1;
    break;

        case "posts":
            $tableParams["hasPicture"] = true;
            $tableParams["title"] = "Postovi";
            $models = Post::all('*');
            //define table structure
            $tableParams["table"] = ["Id", "Titl", "Deskripcija", "Snizena cena", "Original cena", "Vreme pocetka", "Vreme kraja", "Admin Id", "Firma Id", "Url slike"];
            $i = 0;
            //add table values
            foreach ($models as $model) {
                $tableParams["tableVals"][$i] = [$model->id, $model->title, $model->description, $model->discountedPrice, $model->originalPrice, $model->startDate, $model->endDate, $model->admin_id,$model->company_id, (!is_null(Image::where("id",$model->image_id)->first()))?Image::where("id",$model->image_id)->first()->path:null];
                $i++;
            }
            $tableParams["index"] = 2;
            break;

        case "categories":
            $tableParams["title"] = "Kategorije";
            $models = Category::all('*');
            //define table structure
            $tableParams["table"] = ["Id","Ime"];
            $i = 0;
            //add table values
            foreach ($models as $model) {
                $tableParams["tableVals"][$i] = [$model->id, $model->name];
                $i++;
            }
            $models = Review_Type::all('*');
            $tableParams["tableReviewType"] = ["Id","Ime", "Id kategorije"];
            $tableParams["tableReviewTypeVals"] = [];
            $i = 0;
            foreach ($models as $model) {
                $tableParams["tableReviewTypeVals"][$i] = [$model->id, $model->name,$model->category_id];
                $i++;
            }
            $tableParams["index"] = 3;
            break;

        case "reviews":
            $tableParams["title"] = "Recenzije";
            $models = Review::all('*');
            //define table structure
            $tableParams["table"] = ["Id", "Id usera", "Id posta", "Recenzija", "Tekst Recenzije"];
            $i = 0;
            //add table values
            foreach ($models as $model) {
                $tableParams["tableVals"][$i] = [$model->id, $model->user_id, $model->post_id, $model->rating, $model->writtenReview];
                $i++;
            }
            $tableParams["index"] = 4;
            break;

        case "colleges":
            $tableParams["hasPicture"] = true;
            $tableParams["title"] = "Fakulteti";
            $tableParams["hasConnections"] = true;
            $models = College::all('*');
            //define table structure
            $tableParams["table"] = ["Id", "Ime", "Lokacija", "Info", "Email", "Broj telefona","Url slike"];
            $i = 0;
            //add table values
            foreach ($models as $model) {
                $tableParams["tableVals"][$i] = [$model->id, $model->name, $model->location, $model->info, $model->email, $model->phone,(!is_null(Image::where("id",$model->image_id)->first()))?Image::where("id",$model->image_id)->first()->path:null];
                $i++;
            }
            $models = User::all();
            $modelsData  = [];
            $i = 0;
            foreach ($models as $model){
                $modelsData[$i]["name"] = $model->id." ".$model->fname." ".$model->lname;
                $modelsData[$i]["id"] = $model->id;
                $i++;
            }
            $models = College::all();
            $modelsData2  = [];
            $i = 0;
            foreach ($models as $model){
                $modelsData2[$i]["name"] = $model->id." ".$model->name;
                $modelsData2[$i]["id"] = $model->id;
                $i++;
            }
            $tableParams["extraConnections"] = "extraConnections";
            $tableParams["connections"] = ["Korisnik",$modelsData,"user","Fakultet",$modelsData2,"college"];

            $models = User_College::all('*');
            $tableParams["tableConnectionModel"] = "user_college";
            $tableParams["tableConnectionTitle"] = "Studenti u fakultetima";
            $tableParams["tableConnection"] = ["Id","Id studenta", "Id fakulteta","Pocetak pohadjanja","Id smera"];
            $tableParams["tableConnectionVals"] = [];
            $i = 0;
            foreach ($models as $model) {
                $tableParams["tableConnectionVals"][$i] = [$model->id, $model->user_id,$model->college_id,$model->educationStartYear,$model->studyProgramId];
                $i++;
            }

            $models = Study_Program::all('*');
            $tableParams["tableStudyProgram"] = ["Id","Ime", "Dužina trajanja","Fakultet", "Opis"];
            $tableParams["tableStudyProgramVals"] = [];
            $i = 0;
            foreach ($models as $model) {
                $tableParams["tableStudyProgramVals"][$i] = [$model->id, $model->name,$model->duration,$model->college_id." ".College::where("id",$model->college_id)->first()->name,$model->description];
                $i++;
            }
            $tableParams["index"] = 5;
            break;


        case "images":
            $tableParams["title"] = "Slike";
            $models = Image::all('*');
            //define table structure
            $tableParams["table"] = ["Id", "Putanja", "Korisnik Id"];
            $i = 0;
            //add table values
            foreach ($models as $model) {
                $tableParams["tableVals"][$i] = [$model->id, $model->path, $model->user_id];
                $i++;
            }
            $tableParams["index"] = 6;
            break;

        case "companies":
            $tableParams["hasPicture"] = true;
            $tableParams["hasConnections"] = true;
            $tableParams["title"] = "Kompanije";
            $models = Company::all('*');
            //define table structure
            $tableParams["table"] = ["Id", "Ime", "Deskripcija","Lokacija", "Email", "Broj telefona", "Url slike"];
            $i = 0;
            //add table values
            foreach ($models as $model) {
                $tableParams["tableVals"][$i] = [$model->id, $model->name, $model->description, $model->location, $model->email, $model->phone,(!is_null(Image::where("id",$model->image_id)->first()))?Image::where("id",$model->image_id)->first()->path:null];
                $i++;
            }
            $models = User::all();
            $modelsData  = [];
            $i = 0;
            foreach ($models as $model){
                $modelsData[$i]["name"] = $model->id." ".$model->fname." ".$model->lname;
                $modelsData[$i]["id"] = $model->id;
                $i++;
            }
            $models = Company::all();
            $modelsData2  = [];
            $i = 0;
            foreach ($models as $model){
                $modelsData2[$i]["name"] = $model->id." ".$model->name;
                $modelsData2[$i]["id"] = $model->id;
                $i++;
            }

            $tableParams["connections"] = ["Korisnik",$modelsData,"user","Kompanija",$modelsData2,"company"];

            $models = User_Company::all('*');
            $tableParams["tableConnectionModel"] = "user_company";
            $tableParams["tableConnectionTitle"] = "Korisnici u firmama";
            $tableParams["tableConnection"] = ["Id","Id zaposlenog", "Id firme"];
            $tableParams["tableConnectionVals"] = [];
            $i = 0;
            foreach ($models as $model) {
                $tableParams["tableConnectionVals"][$i] = [$model->id, $model->user_id,$model->company_id];
                $i++;
            }

            $tableParams["index"] = 7;
            break;
        case "student_card":
            $tableParams["hasPicture"] = true;
            $tableParams["title"] = "Studentske kartice";
            $models = StudentCard::all('*');
            //define table structure
            $tableParams["table"] = ["Id korisnika", "Napravljenja od strane korisnika","Kod","Url slike"];
            $i = 0;
            //add table values
            foreach ($models as $model) {
                $tableParams["tableVals"][$i] = [$model->id,$model->created_by,$model->code, (!is_null(Image::where("id",$model->image_id)->first()))?Image::where("id",$model->image_id)->first()->path:null];
                $i++;
            }
            $tableParams["index"] = 9;
            break;
}

    return view('all')->with("tableParams",$tableParams)->with("userLogged",$userLogged);
});

function generateRandomString($length = 10) {
    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
}
