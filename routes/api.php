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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('login', 'App\Http\Controllers\Api\Auth\LoginController@login');
Route::get('refresh', 'App\Http\Controllers\Api\Auth\LoginController@refresh');
Route::post('userRegistration', 'App\Http\Controllers\Api\User\UserController@userRegistration');

Route::post('messageSave', 'App\Http\Controllers\Api\Messages\MessagesController@messageSave');

Route::get('products/{id}', 'App\Http\Controllers\Api\Products\ProductsController@productById');
Route::get('products', 'App\Http\Controllers\Api\Products\ProductsController@products');

Route::get('posts', 'App\Http\Controllers\Api\Posts\PostsController@posts');
Route::get('posts/{id}', 'App\Http\Controllers\Api\Posts\PostsController@postById');
Route::post('postSave', 'App\Http\Controllers\Api\Posts\PostsController@postSave');

Route::get('schools', 'App\Http\Controllers\Api\Schools\SchoolsController@schools');
Route::post('schoolSave', 'App\Http\Controllers\Api\Schools\SchoolsController@schoolSave');
Route::get('schools/{id}', 'App\Http\Controllers\Api\Schools\SchoolsController@schoolById');

Route::post('addSchoolRating', 'App\Http\Controllers\Api\Ratings\SchoolRatingsController@addSchoolRating');
Route::get('singleSchoolsRatings/{id}', 'App\Http\Controllers\Api\Ratings\SchoolRatingsController@singleSchoolsRatings');

Route::get('professors', 'App\Http\Controllers\Api\Professors\ProfessorsController@professors');
Route::post('professorSave', 'App\Http\Controllers\Api\Professors\ProfessorsController@professorSave');
Route::get('professorById/{id}', 'App\Http\Controllers\Api\Professors\ProfessorsController@professorById');
Route::post('professorApplicationsSave', 'App\Http\Controllers\Api\Professors\ProfessorsController@professorApplicationsSave');

Route::get('savedProfessors', 'App\Http\Controllers\Api\Professors\SavedProfessorsController@savedProfessors');
Route::post('favoriteProfessors', 'App\Http\Controllers\Api\Professors\SavedProfessorsController@favoriteProfessors');

Route::get('applications', 'App\Http\Controllers\Api\Applications\ApplicationsController@applications');
Route::post('applicationSave', 'App\Http\Controllers\Api\Applications\ApplicationsController@applicationSave');
Route::post('subjectApplicationSave', 'App\Http\Controllers\Api\Applications\ApplicationsController@subjectApplicationSave');
Route::get('professorApplications', 'App\Http\Controllers\Api\Applications\ApplicationsController@professorApplications');
Route::get('subjectApplications', 'App\Http\Controllers\Api\Applications\ApplicationsController@subjectApplications');

Route::post('applyApplication', 'App\Http\Controllers\Api\Applications\ApplicationsController@applyApplication');
Route::post('applyProfessor', 'App\Http\Controllers\Api\Applications\ApplicationsController@applyProfessor');
Route::post('applySubject', 'App\Http\Controllers\Api\Applications\ApplicationsController@applySubject');

Route::get('singleSchoolTeachers/{id}', 'App\Http\Controllers\Api\Ratings\RatingsController@singleSchoolTeachers');
Route::get('singleProfessorRatings/{id}', 'App\Http\Controllers\Api\Ratings\RatingsController@singleProfessorRatings');
Route::post('addProfessorRating', 'App\Http\Controllers\Api\Ratings\RatingsController@addProfessorRating');

Route::get('subjects', 'App\Http\Controllers\Api\Subjects\SubjectsController@subjects');
Route::get('subjectById/{id}', 'App\Http\Controllers\Api\Subjects\SubjectsController@subjectById');
Route::post('subjectSave', 'App\Http\Controllers\Api\Subjects\SubjectsController@subjectSave');

Route::group(['middleware' => ['jwt.verify']], function () {
    Route::get('allUsers', 'App\Http\Controllers\Api\User\UserController@allUsers');
    Route::put('updatePassword', 'App\Http\Controllers\Api\User\UserController@updatePassword');
    Route::put('updateUserInfo', 'App\Http\Controllers\Api\User\UserController@updateUserInfo');
    Route::get('user', 'App\Http\Controllers\Api\User\UserController@userData');

    Route::put('posts/{post}', 'App\Http\Controllers\Api\Posts\PostsController@postEdit');
    Route::delete('posts/{post}', 'App\Http\Controllers\Api\Posts\PostsController@postRemove');

    Route::post('productSave', 'App\Http\Controllers\Api\Products\ProductsController@productSave');
    Route::put('products/{post}', 'App\Http\Controllers\Api\Products\ProductsController@productEdit');

    Route::get('messages', 'App\Http\Controllers\Api\Messages\MessagesController@messages');
});
