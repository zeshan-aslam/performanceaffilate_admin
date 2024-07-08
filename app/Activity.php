<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable=[
        'description','ip','country','user_id','type','url'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
}
