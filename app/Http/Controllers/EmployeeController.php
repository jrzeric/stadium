<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Employee;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::all()->where('status', 'UP');
        return view('employees/index', ['employees' => $employees]);
    }

    public function create()
    {
        return view('employees/create');
    }

    public function store(Request $request)
    {
        $firstName = $request->input('firstName');
        $lastName = $request->input('lastName');
        $hired = date('Y-m-d');

        $employee = new Employee ([
            'firstName' => $firstName,
            'lastname' => $lastName,
            'hired' => $hired
        ]);

        $employee->save();
        return redirect()->route('employeeIndex')->with('status', 'Employee created!');
    }

    public function edit($id)
    {
        $employee = Employee::find($id);
        return view('employees/show', ['employee' => $employee]);
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::find($id);

        $employee->firstName = $request->input('firstName');
        $employee->lastname = $request->input('lastName');

        $employee->save();
        return redirect()->route('employeeIndex')->with('status', 'Changes saved!');
    }

    public function destroy($id)
    {
        $employee = Employee::find($id);
        $employee->status = 'DW';

        $employee->save();
        return redirect()->route('employeeIndex')->with('status', 'Changes saved!');
    }
}
