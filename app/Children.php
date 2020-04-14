<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Children extends Model
{
    protected $fillable = ['employee_id', 'name', 'old'];
}
