<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class User extends Authenticatable
{
    use Notifiable;

    /*
    *  The attributes that should be accessor
    */
    public function getDobAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d-m-Y');
    }
    
    /*
    *  The attributes
    */
    public function setDobAttribute($value)
    {
        $this->attributes['dob'] =Carbon::createFromFormat("d/m/Y", $value)->format('Y-m-d');
    }

    /**
     * Always encrypted  password when we save it to the database
    */
    public function setPasswordAttribute($value) {
        $this->attributes['password'] = Hash::make($value);
    }

    public function getFullNameAttribute()
    {
        return ucfirst($this->fname) . ' ' . ucfirst($this->lname);
    }
    

    /**
     * 
     * @name : scopeMySave
     * 
     * @description : save data for user signUp 
     * 
    **/
    public function scopeMySave($q, $data)
    {

        $this->fname = isset($data["fname"])  ? $data["fname"] : $this->fname;
        $this->lname = isset($data["lname"])  ? $data["lname"] : $this->lname;
        $this->dob = isset($data["dob"]) ? $data["dob"] : $this->dob;
        $this->user_name = isset($data["username"]) ? $data["username"] : $this->user_name;
        $this->email = isset($data["email"])  ? $data["email"] : $this->email;
        if (isset($data["password"])) {
            $this->password = isset($data["password"]) ? $data["password"] : $this->password;
        }
        return $this->save();
    }

}
