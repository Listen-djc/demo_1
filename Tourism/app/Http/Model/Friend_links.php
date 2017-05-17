<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Friend_links extends Model
{
    protected $table = "links";
    protected $primaryKey = "link_id";
    public $timestamps = false; //不能拼错
    protected $guarded = [];
}
