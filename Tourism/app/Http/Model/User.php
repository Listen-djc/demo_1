<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = "user";
    protected $primaryKey = "us_id";
    public $timestamps = false; //不能拼错
    protected $guarded = [];

}
