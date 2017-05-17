<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = "log";
    protected $primaryKey = "lg_id";
    public $timestamps = false; //不能拼错
    protected $guarded = [];
}
