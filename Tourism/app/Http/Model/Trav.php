<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Trav extends Model{
    protected $table = "trav";
    protected $primaryKey = "tr_id";
    public $timestamps = false;
    protected $guarded = [];
}
