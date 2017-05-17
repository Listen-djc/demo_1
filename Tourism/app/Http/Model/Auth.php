<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Auth extends Model
{
    protected $table = "auth";
    protected $primaryKey = "au_id";
    public $timestamps = false; //不能拼错
    protected $guarded = [];
    
}
