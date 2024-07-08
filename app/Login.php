<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Login extends Model
{
    public $table='partners_login';
    public $timestamps=false;
    public function loginData(){
        
        return Login::all();
    }
}
