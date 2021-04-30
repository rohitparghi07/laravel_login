<?php

use Illuminate\Support\Facades\Route;

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



// Route::get('/login', function () {
//     return view('admin.login.login');
// });

// admin route
Route::group(['prefix' => 'admin','namespace'=>'Admin'], function () {


    //login module
    Route::group(['namespace'=>'Auth','middleware'=>'guest'], function () {
        Route::get('/', 'LoginController@viewLoginForm')->name('login');
        Route::post('login', 'LoginController@hasLogin')->name('hasLogin');
        Route::post('checkUserNameExists', 'LoginController@checkUserNameExists');
    });

    // authenticate user get all funcationality
    Route::group(['middleware' => 'auth'], function () {

        //login module
        Route::group(['namespace'=>'Auth'], function () {
            Route::get('/logout', 'LoginController@logout')->name('logout');
        });

        // dashboard
        Route::group(['prefix' => 'dashboard'], function () {
            Route::get('/', function () {
                return view('admin.dashboard.index');
            })->name('dashboard');
        });

        //users 
        Route::group(['prefix' => 'user'], function () {

            Route::get('/', "UserController@viewUsers")->name('user');
            Route::get('getUserDataTable', "UserController@getUserDataTable");
            Route::post('save-user-data', 'UserController@saveUserData')->name('save-user');
            Route::post('checkEmailExists', 'UserController@checkEmailExists');
            Route::post('checkUserNameExists', 'UserController@checkUserNameExists');
            Route::post('getUserDetail', 'UserController@getUserDetail');
            Route::post('deleteUserDetail', 'UserController@deleteUserDetail');
        
        });
    });

});

