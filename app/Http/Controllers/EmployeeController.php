<?php

namespace App\Http\Controllers;

use App\Children;
use App\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function store(Request $request)
    {
        $validatedRequest = $this->validateRequest($request);
        Employee::create($validatedRequest);
    }

    public function index(Request $request)
    {
        $response = Employee::provideAllEmployee();
        return response()->json(['data' => $response], 200);
    }

    public function addChildren(Request $request){
        Children::create([
            'employee_id' => $request->input('employee_id'),
            'name' => $request->input('name'),
            'old' => $request->input('old'),
        ]);
    }

    private function validateRequest(Request $request)
    {
        return $request->validate([
            'id' => 'required',
            'full_name' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'address' => 'required',
            'city' => 'required',
            'province' => 'required',
            'hp' => 'required'
        ]);
    }
}
