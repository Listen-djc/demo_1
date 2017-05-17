<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Sceinc_road_map extends Model
{
    protected $table = "road_map";
    protected $primaryKey = "rm_id";
    public $timestamps = false; //不能拼错
    protected $guarded = [];
}
