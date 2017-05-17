<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Replay extends Model
{
    protected $table = "replay";
    protected $primaryKey = "re_id";
    public $timestamps = false; //不能拼错
    protected $guarded = [];
}
