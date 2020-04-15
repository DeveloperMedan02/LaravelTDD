<?php

namespace App\Http\Controllers;

use App\Children;
use App\Employee;
use Illuminate\Http\Request;
use App\Http\Resources\Employee as EmployeeResource;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::all();
        $employeeResource = EmployeeResource::collection($employees);
        return response()->json(['data' => $employeeResource], 200);
    }
    public function store(Request $request)
    {
        $validatedRequest = $this->validateRequest($request);
        Employee::create($validatedRequest);
    }

    public function addChildren(Request $request)
    {
        Children::create([
            'employee_id' => $request->input('employee_id'),
            'name' => $request->input('name'),
            'age' => $request->input('age')
        ]);
    }

    private function validateRequest(Request $request)
    {
        return $request->validate([
            'name' => 'required',
            'email' => 'required',
            'address' => 'required',
            'hp' => 'required',
            'city' => 'required',
            'province' => 'required'
        ]);
    }
}
