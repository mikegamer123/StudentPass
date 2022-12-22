<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::middleware(['cors'])->group(function () {
//CORS

//API route for register new user
Route::post('/register', [App\Http\Controllers\API\AuthController::class, 'register']);
//API route for login user
Route::post('/login', [App\Http\Controllers\API\AuthController::class, 'login']);

//API route for email registration activation
Route::get('/emailReg/{emailToken}', [App\Http\Controllers\API\AuthController::class, 'setActiveUser']);

    Route::prefix('posts')->group(function () {
        //api route for returning all posts or by ID
        Route::get('/get/{id?}', [App\Http\Controllers\PostsController::class, 'getPosts']);
    });
    Route::prefix('userColleges')->group(function () {
        //api route for returning all userColleges or by ID
        Route::get('/get/{id?}', [App\Http\Controllers\UserCollegeController::class, 'getUserCollege']);
    });
    Route::prefix('companies')->group(function () {
        //api route for returning all companies or by ID
        Route::get('/get/{id?}', [App\Http\Controllers\CompaniesController::class, 'getCompanies']);
    });
    Route::prefix('reviews')->group(function () {
    //api route for returning all reviews or by ID
    Route::get('/get/{id?}', [App\Http\Controllers\ReviewsController::class, 'getReviews']);

        //api route for returning all reviews by post ID
        Route::get('/getReviewsByPost/{id}', [App\Http\Controllers\ReviewsController::class, 'getReviewsByPostId']);
    });
//Protecting Routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/profile', function(Request $request) {
        return auth()->user();
    });

    ////USERS
    Route::prefix('users')->group(function () {
        //api route for returning all users or by ID
        Route::get('/get/{id?}', [App\Http\Controllers\UserController::class, 'getUsers']);

        //api route for updating user by ID
        Route::post('/put/{id}', [App\Http\Controllers\UserController::class, 'putUsers']);

        //api route for deleting users by ID
        Route::get('/delete/{id}', [App\Http\Controllers\UserController::class, 'deleteUsers']);
    });


    ////COLLEGES
    Route::prefix('colleges')->group(function () {
        //api route for returning all colleges or by ID
        Route::get('/get/{id?}', [App\Http\Controllers\CollegeController::class, 'getCollege']);

        //api route for updating colleges by ID
        Route::post('/put/{id}', [App\Http\Controllers\CollegeController::class, 'putCollege']);

        //api route for deleting colleges by ID
        Route::get('/delete/{id}', [App\Http\Controllers\CollegeController::class, 'deleteCollege']);

        //api route for creating colleges
        Route::post('/create', [App\Http\Controllers\CollegeController::class, 'addCollege']);
    });

    ////STUDY PROGRAMS
    Route::prefix('studyPrograms')->group(function () {
        //api route for returning all studyPrograms or by ID
        Route::get('/get/{id?}', [App\Http\Controllers\StudyProgramsController::class, 'getStudyProgram']);

        //api route for updating studyPrograms by ID
        Route::post('/put/{id}', [App\Http\Controllers\StudyProgramsController::class, 'putStudyProgram']);

        //api route for deleting studyPrograms by ID
        Route::get('/delete/{id}', [App\Http\Controllers\StudyProgramsController::class, 'deleteStudyProgram']);

        //api route for creating studyPrograms
        Route::post('/create', [App\Http\Controllers\StudyProgramsController::class, 'addStudyProgram']);
    });

    ////USER TO COLLEGE
    Route::prefix('user_college')->group(function () {

        //api route for updating userColleges by ID
        Route::post('/put/{id}', [App\Http\Controllers\UserCollegeController::class, 'putUserCollege']);

        //api route for deleting userColleges by ID
        Route::get('/delete/{id}', [App\Http\Controllers\UserCollegeController::class, 'deleteUserCollege']);

        //api route for creating userColleges
        Route::post('/create', [App\Http\Controllers\UserCollegeController::class, 'addUserCollege']);
    });

    ////POSTS
    Route::prefix('posts')->group(function () {
        //api route for updating posts by ID
        Route::post('/put/{id}', [App\Http\Controllers\PostsController::class, 'putPosts']);

        //api route for deleting posts by ID
        Route::get('/delete/{id}', [App\Http\Controllers\PostsController::class, 'deletePosts']);

        //api route for creating posts
        Route::post('/create', [App\Http\Controllers\PostsController::class, 'addPosts']);
    });

    ////COMPANIES
    Route::prefix('companies')->group(function () {

        //api route for updating companies by ID
        Route::post('/put/{id}', [App\Http\Controllers\CompaniesController::class, 'putCompanies']);

        //api route for deleting companies by ID
        Route::get('/delete/{id}', [App\Http\Controllers\CompaniesController::class, 'deleteCompanies']);

        //api route for creating companies
        Route::post('/create', [App\Http\Controllers\CompaniesController::class, 'addCompanies']);
    });

    ////USER TO COMPANIES
    Route::prefix('user_company')->group(function () {
        //api route for returning all userCompanies or by ID
        Route::get('/get/{id?}', [App\Http\Controllers\UserCompanyController::class, 'getUserCompany']);

        //api route for updating userCompanies by ID
        Route::post('/put/{id}', [App\Http\Controllers\UserCompanyController::class, 'putUserCompany']);

        //api route for deleting userCompanies by ID
        Route::get('/delete/{id}', [App\Http\Controllers\UserCompanyController::class, 'deleteUserCompany']);

        //api route for creating userCompanies
        Route::post('/create', [App\Http\Controllers\UserCompanyController::class, 'addUserCompany']);
    });

    ////CATEGORIES
    Route::prefix('categories')->group(function () {
        //api route for returning all categories or by ID
        Route::get('/get/{id?}', [App\Http\Controllers\CategoriesController::class, 'getCategories']);

        //api route for updating categories by ID
        Route::post('/put/{id}', [App\Http\Controllers\CategoriesController::class, 'putCategories']);

        //api route for deleting categories by ID
        Route::get('/delete/{id}', [App\Http\Controllers\CategoriesController::class, 'deleteCategories']);

        //api route for creating categories
        Route::post('/create', [App\Http\Controllers\CategoriesController::class, 'addCategories']);
    });

    ////REVIEWS
    Route::prefix('reviews')->group(function () {

        //api route for updating reviews by ID
        Route::post('/put/{id}', [App\Http\Controllers\ReviewsController::class, 'putReviews']);

        //api route for deleting reviews by ID
        Route::get('/delete/{id}', [App\Http\Controllers\ReviewsController::class, 'deleteReviews']);

        //api route for creating reviews
        Route::post('/create', [App\Http\Controllers\ReviewsController::class, 'addReviews']);
    });

    ////POST CATEGORIES
    Route::prefix('postCategories')->group(function () {
        //api route for returning all postCategories or by ID
        Route::get('/get/{id?}', [App\Http\Controllers\PostCategoriesController::class, 'getPostCategories']);

        //api route for updating postCategories by ID
        Route::post('/put/{id}', [App\Http\Controllers\PostCategoriesController::class, 'putPostCategories']);

        //api route for deleting postCategories by ID
        Route::get('/delete/{id}', [App\Http\Controllers\PostCategoriesController::class, 'deletePostCategories']);

        //api route for creating postCategories
        Route::post('/create', [App\Http\Controllers\PostCategoriesController::class, 'addPostCategories']);
    });

    ////REVIEW TYPES
    Route::prefix('reviewTypes')->group(function () {
        //api route for returning all reviewTypes or by ID
        Route::get('/get/{id?}', [App\Http\Controllers\ReviewTypesController::class, 'getReviewTypes']);

        //api route for updating reviewTypes by ID
        Route::post('/put/{id}', [App\Http\Controllers\ReviewTypesController::class, 'putReviewTypes']);

        //api route for deleting reviewTypes by ID
        Route::get('/delete/{id}', [App\Http\Controllers\ReviewTypesController::class, 'deleteReviewTypes']);

        //api route for creating reviewTypes
        Route::post('/create', [App\Http\Controllers\ReviewTypesController::class, 'addReviewTypes']);
    });

    ////REVIEW TO REVIEW TYPES
    Route::prefix('reviewReviewTypes')->group(function () {
        //api route for returning all reviewReviewTypes or by ID
        Route::get('/get/{id?}', [App\Http\Controllers\ReviewReviewTypesController::class, 'getReviewReviewTypes']);

        //api route for updating reviewReviewTypes by ID
        Route::post('/put/{id}', [App\Http\Controllers\ReviewReviewTypesController::class, 'putReviewReviewTypes']);

        //api route for deleting reviewReviewTypes by ID
        Route::get('/delete/{id}', [App\Http\Controllers\ReviewReviewTypesController::class, 'deleteReviewReviewTypes']);

        //api route for creating reviewReviewTypes
        Route::post('/create', [App\Http\Controllers\ReviewReviewTypesController::class, 'addReviewReviewTypes']);
    });

    ////NEWS
    Route::prefix('news')->group(function () {
        //api route for returning all reviewReviewTypes or by ID
        Route::get('/get/{id?}', [App\Http\Controllers\NewsController::class, 'getNews']);

        //api route for updating reviewReviewTypes by ID
        Route::post('/put/{id}', [App\Http\Controllers\NewsController::class, 'putNews']);

        //api route for deleting reviewReviewTypes by ID
        Route::get('/delete/{id}', [App\Http\Controllers\NewsController::class, 'deleteNews']);

        //api route for creating reviewReviewTypes
        Route::post('/create', [App\Http\Controllers\NewsController::class, 'addNews']);
    });


    ////STUDENT_CARDS
    Route::prefix('student_card')->group(function () {
        //api route for returning all reviewReviewTypes or by ID
        Route::get('/get/{id?}', [App\Http\Controllers\StudentCardController::class, 'getStudentCards']);

        //api route for updating reviewReviewTypes by ID
        Route::post('/put/{id}', [App\Http\Controllers\StudentCardController::class, 'putStudentCard']);

        Route::get('/by_code/{code}', [App\Http\Controllers\StudentCardController::class, 'getUserByCode']);

        //api route for deleting reviewReviewTypes by ID
        Route::get('/delete/{id}', [App\Http\Controllers\StudentCardController::class, 'deleteStudentCard']);

        //api route for creating reviewReviewTypes
        Route::post('/create', [App\Http\Controllers\StudentCardController::class, 'addStudentCard']);
    });


    ////IMAGES
    Route::prefix('images')->group(function () {

        //api route for adding just images
        Route::post('/create', [App\Http\Controllers\ImageController::class, 'imageCreate']);

        //api route for User images
        Route::post('/users/{id}', [App\Http\Controllers\ImageController::class, 'imageUser']);

        //api route for Post images
        Route::post('/posts/{id}', [App\Http\Controllers\ImageController::class, 'imagePost']);

        //api route for News images
        Route::post('/news/{id}', [App\Http\Controllers\ImageController::class, 'imageNews']);

        //api route for Company images
        Route::post('/companies/{id}', [App\Http\Controllers\ImageController::class, 'imageCompany']);

        //api route for StudentCard images
        Route::post('/student_card/{id}', [App\Http\Controllers\ImageController::class, 'imageStudentCard']);

        //api route for College images
        Route::post('/colleges/{id}', [App\Http\Controllers\ImageController::class, 'imageStudentCard']);

        //api route for get images
        Route::get('/get/{id}', [App\Http\Controllers\ImageController::class, 'getImage']);

    });



    // API route for logout user
        Route::post('/logout', [App\Http\Controllers\API\AuthController::class, 'logout']);

});


});
