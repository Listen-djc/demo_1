<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    protected $table = "notice";
    protected $primaryKey = "nt_id";
    public $timestamps = false; //不能拼错
    protected $guarded = [];
}
