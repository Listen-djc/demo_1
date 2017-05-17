<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Sceinc extends Model
{
    protected $table = "sceinc";
    protected $primaryKey = "sc_id";
    public $timestamps = false; //不能拼错
    protected $guarded = [];
}
