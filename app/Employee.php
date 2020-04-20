<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\Employee as EmployeeResource;
use Laravel\Scout\Searchable;

class Employee extends Model
{
    use Searchable;

    protected $fillable = ['name', 'email', 'address', 'hp', 'city', 'province'];

    public function childrens(){
        return $this->hasMany(Children::class, 'employee_id', 'id');
    }
}
