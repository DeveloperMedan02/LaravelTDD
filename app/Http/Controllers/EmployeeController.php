<?php

namespace App\Http\Controllers;

use App\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function store(Request $request)
    { 
        $validatedRequest = $this->validateRequest($request);
        Employee::create($validatedRequest);
    }

    private function validateRequest(Request $request){
        return $request->validate([
            'name' => 'required',
            'email' => 'required',
            'address' => 'required',
            'hp' => 'required'
        ]);
    }
}
