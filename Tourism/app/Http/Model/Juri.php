<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Juri extends Model
{
    protected $table = "jurisdiction";
    protected $primaryKey = "ju_id";
    public $timestamps = false; //不能拼错
    protected $guarded = [];

}
