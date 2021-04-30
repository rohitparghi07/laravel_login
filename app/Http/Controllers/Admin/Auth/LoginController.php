<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  Session;
use App\User;

// use App\Providers\RouteServiceProvider;

class LoginController extends Controller
{

    /**
     *Name : viewLoginForm
     *
     * @desc : login form view
     *  
    */
    public function viewLoginForm() {
        return view('admin.login.login');
    }

    /**
     *Name : viewLoginForm
     *
     * @desc : login form view
     *  
    */
    public function hasLogin(Request $request) {
        
        //validation       
        $request->validate(
                            [
                                'user_name' => 'required',
                                'password' => 'required',
                            ],
                            [
                                'user_name.required'=>'Please enter user name',
                                'password.required'=>'Please provide password',
                            ]);
                            
            $credentials = $request->only('user_name', 'password');
         
            if (Auth::attempt($credentials)) {
                
                session()->put("user",auth()->user()->user_name);

                // Authentication passed...
                return redirect()->route('dashboard');
            }
            return redirect()->route("login")->withError('Oppes! You have entered invalid credentials')->withInput();
    }

    /**
     *Name : logout
     *
     * @desc :logout all session
     *  
    */
    public function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect()->route("login");
    }

    /**
     * Check user name exists or not
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function checkUserNameExists(Request $request) {

        $input = $request->all();
        $userName= $input["user_name"] ? $input["user_name"] : "";
      
        $data =User::where('user_name','=',$userName)->first();

        if ($data)
            echo "true";
        else
            echo "false";
    }

}
