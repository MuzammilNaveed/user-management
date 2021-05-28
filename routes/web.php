<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\FeatureController;
use App\Http\Controllers\CourseController;



    Route::get('/', [HomeController::class,'userHomePage']);
    Route::get('/login',[HomeController::class,'index'])->name('login');
    Route::post('/login_user',[HomeController::class,'UserLogin']);
    Route::get('/logout',[HomeController::class,'logout'])->name('logout.user');

Route::group(['middleware' => ['auth']], function() {

    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard.index');

    // roles crud
    Route::resource('roles', RoleController::class);
    Route::get('/manage_roles', [RoleController::class, 'manageRoles'])->name('role.index');

    // users crud
    Route::get('/manage_users',[HomeController::class, 'manageUserPage'])->name("user.index");
    Route::post('/create_users',[HomeController::class, 'createUser']);
    Route::get('/get_all_users',[HomeController::class, 'getAllUsers']);
    Route::post('/update_users',[HomeController::class, 'updateUser']);
    Route::post('/rest_user_ip',[HomeController::class, 'resetUserIP']);


    // settings
    Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
    Route::post('/change_password', [SettingController::class, 'changePassword']);
    Route::post('/save_setting', [SettingController::class, 'saveSetting']);


    // feature
    Route::get('/feature', [FeatureController::class, 'index'])->name('feature.index');
    Route::post('/add_features', [FeatureController::class, 'store']);
    Route::get('/get_all_features', [FeatureController::class, 'getFeatures']);
    Route::get('/get_features_by_id/{id}', [FeatureController::class, 'getFeaturesByID']);
    Route::post('/update_feature', [FeatureController::class, 'update']);


    // courses
    Route::get('/courses', [CourseController::class, 'index'])->name('course.index');
    Route::post('/save_course', [CourseController::class, 'save']);
    Route::get('/get_courses', [CourseController::class, 'view']);
    Route::post('/update_course', [CourseController::class, 'update']);


    // lectures
    Route::get('/lectures', [CourseController::class, 'lectures'])->name('lecture.index');
    Route::post('/save_lecture', [CourseController::class, 'saveLecture']);
    Route::get('/get_lecture', [CourseController::class, 'viewLecture']);
    Route::post('/update_lecture', [CourseController::class, 'updateLecture']);

 
});

