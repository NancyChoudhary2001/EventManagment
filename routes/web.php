<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdduserController;
use App\Http\Controllers\AddbranchController;
use App\Http\Controllers\AddeventController;
use App\Http\Controllers\EditprofileController;
use App\Http\Controllers\UserprofileController;
use App\Http\Middleware\ValidUser;
use App\Http\Middleware\Adminrole;
use App\Http\Middleware\Userrole;
use App\Http\Middleware\Authenticate;


use Illuminate\Http\Request;

use App\Http\Controllers\Auth\UserController;


route::middleware('SetLang')->group(function(){

    Route::view('/', 'welcome')->name('signup')->middleware([Authenticate::class]);
    Route::view('/login', 'login')->name('login')->middleware([Authenticate::class]);;
    Route::view('/forgetpassword', 'forgetpassword')->name('forgetpassword');
    // Route::view('/verifyOtp', 'verifyOtp')->name('otp_view');
    // Route::get('/resetPassword', 'resetPassword')->name('reset_password');
    
    Route::get('setlang/{lang}', function($lang){
        Session::put('lang', $lang);
        return redirect('/');
    });
    Route::get('/verifyOtp/{email}', function ($email) {
        return view('verifyOtp', compact('email'));
    })->name('otp_view');
    Route::get('/resetPassword/{email}', function ($email) {
        return view('resetPassword', compact('email'));
    })->name('reset_password');
    Route::get('/eventuser', [AdduserController::class, 'eventuser'])->name('eventuser');
});

// ADmin Panel

Route::middleware('AdminModule')->group(function(){
    Route::get('dashboard', function(){
        return view('admin.layouts.layout');
    })->name('dashboard');
    
    Route::get('index', function () {
        return view('admin.index'); 
    })->name('index');
    Route::get('/addUser', [AdduserController::class, 'getCountries'])->name('addUser');
    Route::post('/addUser', [AdduserController::class, 'adduser'])->name('addUser');
    Route::get('/states/{country_id}', [AdduserController::class, 'getStates'])->name('getStates');
    Route::get('/cities/{state_id}', [AdduserController::class, 'getCities'])->name('getCities');
    Route::get('/branches/{city_id}', [AdduserController::class, 'getBranches']);
    Route::get('/getusers',[AdduserController::class, 'getUser'])->name('getuser');
    Route::get('/users',[AdduserController::class, 'index'])->name('indexx');
    Route::delete('/users/delete', [AdduserController::class, 'destroy'])->name('users.destroy');
    Route::get('/users/edit/{id}', [AdduserController::class, 'edit'])->name('editUserByEmail');
    Route::post('/users/update', [AdduserController::class, 'update'])->name('updateUser');

    Route::get('/branches',function(){
        return view('admin.branch');
    })->name('branch');
    Route::get('/addBranch',[AddbranchController::class,'getCountries'])->name('addBranch');
    Route::get('/getbranches',[AddbranchController::class, 'getBranch'])->name('getbranch');
    Route::get('/newbranches',[AddbranchController::class, 'newbranch'])->name('branch');
    Route::delete('/branches/delete/{name}', [AddbranchController::class, 'destroyByName'])->name('branches.destroyByName');
    Route::get('/branches/edit/{name}', [AddbranchController::class, 'editBranch'])->name('branches.edit');
    Route::put('/branches/update/{name}', [AddbranchController::class, 'updateBranch'])->name('branches.update');
    Route::get('/states/{countryId}', [AddbranchController::class, 'getStates'])->name('getStates');
    Route::get('/cities/{stateId}', [AddbranchController::class, 'getCities'])->name('getCities');
    //Event Routes
    Route::get('/events', function(){
        return view('admin.events');
    })->name('events');
    Route::get('/addevent', [AddeventController::class, 'getCountries'])->name('addevent');
    Route::get('/getevents',[AddeventController::class,'getEvents'])->name('getevent');
    Route::get('/events/edit/{id}', [AddeventController::class, 'edit'])->name('events.edit');
    Route::delete('/events/delete/{id}', [AddeventController::class, 'destroy'])->name('events.destroy');
    Route::get('/events/edit/{name}', [AddeventController::class, 'edit'])->name('events.edit');
    Route::put('/events/update/{name}', [AddeventController::class, 'update'])->name('events.update');
    Route::put('/profile', [EditprofileController::class, 'update'])->name('profile.update');

    Route::get('/profile', [EditprofileController::class, 'edit'])->name('profile.edit');
    Route::post('/password-update', [EditprofileController::class, 'updatePassword'])->name('password.update');
    Route::get('/logout', [EditprofileController::class, 'signout'])->name('signout');
});

//User Panel

Route::middleware('UserModule')->group(function(){
    Route::put('/user-profile', [UserprofileController::class, 'update'])->name('userprofile.update');

    Route::get('/user-profile', [UserprofileController::class, 'edit'])->name('userprofile.edit'); ///User ka hai 

    Route::post('/userpassword-update', [UserprofileController::class, 'updatePassword'])->name('userpassword.update');
    Route::get('/userlogout', [UserprofileController::class, 'signout'])->name('usersignout');
    Route::get('/event-purchased', [UserprofileController::class, 'userEvents'])->name('user.events');
    Route::post('/buy-item', [AddeventController::class, 'buyitem'])->name('buyitem');
    Route::get('/user-payment', [AddeventController::class, 'showPaymentPage'])->name('payment.show');

});

// API 
Route::post('/api/signup',[UserController::class,'signup']);
Route::post('/api/login',[UserController::class,'login']);
Route::post('/api/forgetpassword',[UserController::class,'forgetpassword']);
Route::post('/api/verifyOtp',[UserController::class,'verifyOtp']);
Route::post('/api/resetPassword',[UserController::class,'resetPassword']);
Route::post('/api/adduser',[AdduserController::class,'adduser'])->middleware(ValidUser::class);
Route::post('/api/addbranch',[AddbranchController::class,'addbranch'])->middleware(ValidUser::class);
Route::post('/api/addevent',[AddeventController::class, 'addevent'])->middleware(ValidUser::class);



