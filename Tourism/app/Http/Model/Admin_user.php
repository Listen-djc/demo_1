<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Admin_user extends Model{
    protected $table = "admin_user";
    protected $primaryKey = "ad_id";
    public $timestamps = false; //不能拼错
    protected $guarded = [];
}
