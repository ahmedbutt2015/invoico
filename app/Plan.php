<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $primaryKey = 'id';
    protected $table = "plans";
    public $timestamps = false;

}
