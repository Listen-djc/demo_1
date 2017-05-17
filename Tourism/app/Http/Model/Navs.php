<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Navs extends Model
{
    protected $table = "navs";
    protected $primaryKey = "nav_id";
    public $timestamps = false; //不能拼错
    protected $guarded = [];
}
