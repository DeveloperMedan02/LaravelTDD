<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = ['name', 'email', 'address', 'hp', 'city', 'province'];

    public function childrens(){
        return $this->hasMany(Children::class, 'employee_id', 'id');
    }
}
