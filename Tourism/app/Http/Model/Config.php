<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $table = "config";
    protected $primaryKey = "conf_id";
    public $timestamps = false; //不能拼错
    protected $guarded = [];
}
