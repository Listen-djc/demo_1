<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Sceinc_pic extends Model
{
    protected $table = "sceinc_pic";
    protected $primaryKey = "sp_id";
    public $timestamps = false; //不能拼错
    protected $guarded = [];
}
