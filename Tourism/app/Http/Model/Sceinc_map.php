<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Sceinc_map extends Model
{
    protected $table = "route";
    protected $primaryKey = "ro_id";
    public $timestamps = false; //不能拼错
    protected $guarded = [];
}
