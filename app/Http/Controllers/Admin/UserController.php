<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Http\Requests\Admin\UserRequest;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{

    /**
     *  Disply user list and form view
     * 
     * @return \Illuminate\Http\Response
    */
    public function viewUsers(){

        return view('admin.user.user');
    }


    /**
     *  get user data and set with datatable
     *
     * @return \Illuminate\Http\Responce
     */
     public function getUserDataTable(Request $request)
     {
       
           $input = $request->all();
          
           $response = [];
           $code = 200;
   
           $take =15;

           $columns = [
               'id',
                DB::raw("CONCAT(fname,' ',lname) as fullname"),
               'user_name',
               'email',
               'dob'              
           ];
           $orderBy = [
               'id',
               'fname',
               'user_name',
               'email',
               'dob'              
           ];

           $users = User::select($columns);
           $total= $users->count("id");

           // search logic
           if(array_key_exists("search", $input) && isset($input["search"]))
           {
               $search = trim($input['search']['value']);
               $searchData = explode(' ', $search);

               $users->where(function ($where) use ($searchData){
                   foreach ($searchData as $query){
                       $where->orWhere("fname", "like", "%" . $query . "%");
                       $where->orWhere("lname", "like", "%" . $query . "%");
                       $where->orWhere("email", "like", "%" . $query . "%");
                       $where->orWhere("user_name", "like", "%" . $query . "%");
                   }
               });
           }

           // orderby logic
           if (isset($input["order"])) {

               $columnName = $orderBy[$input["order"][0]["column"]];
               $sortOrder = $input["order"][0]["dir"];
               $users = $users->orderBy($columnName, $sortOrder);
           }
           
           //fitered data and count
           $filteredTotal = $users->count("id");
           $users = $users->skip($input["start"])->take($take)->get();
           $userData = $users->toArray();

           //response    
           $data['data'] = $userData;
           $data['recordsTotal'] = $total;
           $data['recordsFiltered'] = $filteredTotal;

           return response()->json($data, $code);
     }


    /**
    *save User data
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function saveUserData(UserRequest $request)
    {
       $input = $request->all();
     
       $response = [];
       $code = 500;

       if ($request->has("id") && isset($input['id'])) {

           $user = User::find($input["id"]);
           if (!$user) {
               $user = false;
           }
       } else {

           $user = new User;
       }

       if ($user !== false) {
     
           // value set
           if (isset($input["fname"])) {

               $userData["fname"] = $input["fname"];
           }
           if (isset($input["lname"])) {

               $userData["lname"] = $input["lname"];
           }
           if (isset($input["email"])) {

               $userData["email"] = $input["email"];
           }
           if (isset($input["username"])) {

               $userData["username"] = $input["username"];
           }
           if (isset($input["dob"])) {

               $userData["dob"] = $input["dob"];
           }
           if (isset($input["password"])) {

               $userData["password"] = $input["password"];
           }
        //    dd($input,$userData);
           //   transaction start 
           DB::beginTransaction();
           try {

               if ($user->mySave($userData)) {

                   if ($request->has("id") && isset($input['id'])) {

                        $response=[
                            "message" => "User data updated successfully."
                        ];
                      
                   } else {

                        $response=[
                             "message" => "New user added successfully."
                        ];
                   }
                   $code=200;
                   DB::commit();
               } else {

                    $response=[
                        "message" => "Something went wrong!"
                    ];
                    $code=500;
                    DB::rollback();
               }
           } catch (\Exception $e) {
                // Session::flash("error", "Please try again. Something went wrong.");
                // $response = back()->with("user", $input);
                // dd($e);
                $response=[
                    "message" => "Please try again. Something went wrong."
                ];
                $code=500;
                DB::rollback();
           }
       } else {

           $message = "Something went wrong.";

           if ($user == false) {

               $message = "Given input is not valid.";
           }
            $response=[
                "message" => $message
            ];
            $code=500;

        //    Session::flash("error", $message);

        //    $response = back()->with("user", $input);
       }
    //    return $response;
       return response($response,$code);
    } 

    /**
     * Check email exists or not
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function checkEmailExists(Request $request) {

        $input = $request->all();

        if (array_key_exists("id", $input) && $input["id"] != ""){
            $data =User::where('email','=',$input['email'])->where('id','!=',$input['id'])->first();
        }else {
            $data =User::where('email','=',$input['email'])->first();
        }

        if ($data)
            echo "false";
        else
            echo "true";
    }

    /**
     * Check user name exists or not
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function checkUserNameExists(Request $request) {

        $input = $request->all();
        $userName= $input["username"] ? $input["username"] : "";
        $id= $input["id"] ? $input["id"] : "";

        if (array_key_exists("id", $input) && $input["id"] != ""){
            $data =User::where('user_name','=',$userName)->where('id','!=',$id)->first();
        }else {
            $data =User::where('user_name','=',$userName)->first();
        }

        if ($data)
            echo "false";
        else
            echo "true";
    }

    /**
     * get user detail 
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function getUserDetail(Request $request) {

        $input = $request->all();
        $response = [];
        $code = 500;
 
        //column name
        $columns = [
            "id",
            "fname",
            "lname",
            "email",
            "user_name",
            "dob"
            // DB::raw('DATE_FORMAT("dob", "%d/%M/%YYYY") as dob')
        ];
 
        //find record
        $user = User::select($columns)->find($input['id']);
 
        if (isset($user) && $user) {
          
            $code=200;
            $response = [
                "user"=>$user->toArray()
            ];

        }else{

            $code=404;
            $response=[
                "message"=>"User Record Not Found"
            ];

        }
 
        return response($response,$code);
    } 

    /**
     * delete user detail 
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function deleteUserDetail(Request $request) {

        $response = [];
        $code = 500;

        //find record
        $user = User::find($request->id)->delete();

        if ($user) {
           
            $response=[
               'message' => "User Has Been Deleted Successfully."
            ];

        }else{
            $response=[
                'message' => "User Record Not Found..!!!"
            ];
        }
        return $response ;
    }

}
