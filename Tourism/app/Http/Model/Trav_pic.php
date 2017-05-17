<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Trav_pic extends Model
{
    protected $table = "trav_pic";
    protected $primaryKey = "tp_id";
    public $timestamps = false;
    protected $guarded = [];
}
