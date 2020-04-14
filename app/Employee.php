<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\Employee as EmployeeResource;

class Employee extends Model
{
    protected $fillable = ['full_name', 'first_name', 'last_name', 'email', 'address', 'city', 'province', 'hp'];

    public static function provideAllEmployee(){
        $employees = self::all();
        $employeeResource = EmployeeResource::collection($employees);
        return $employeeResource;
    }

    public function childrens(){
        return $this->hasMany(Children::class, 'employee_id', 'id');
    }
}
