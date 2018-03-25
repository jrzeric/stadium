<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Employee;
use DB;

class EmployeeController extends Controller
{
    public function index()
    {
        $value = session('login');
        if($value) {
            $user = DB::table('users')
                        ->join('employees', 'users.employee', '=', 'employees.id')
                        ->join('profiles', 'users.profile', '=', 'profiles.id')
                        ->select('users.employee as usersEmployee', 'users.profile as usersProfile', 'users.email as usersEmail', 'users.password as usersPassword', 'users.status as usersStatus',
                            'employees.id as employeesId', 'employees.firstName as employeesFirstName', 'employees.lastname as employeesLastName', 'employees.hired as employeesHired', 'employees.status as employeesStatus',
                            'profiles.id as profilesId', 'profiles.name as profilesName'
                        )
                        ->where([
                          ['users.employee', $value],
                          ['employees.status', 'UP']
                        ])->get();
            if ($user[0]->profilesId != 1) {
                return redirect()->route('sales.index');
            }

            $employees = Employee::all()->where('status', 'UP');
            return view('employees/index', ['employees' => $employees]);
        } else {
            return redirect()->route('admin.auth.login');
        }
    }

    public function create()
    {
        $value = session('login');
        if($value) {
            return view('employees/create');
        } else {
            return redirect()->route('admin.auth.login');
        }
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
        $value = session('login');
        if($value) {
            $employee = Employee::find($id);
            return view('employees/show', ['employee' => $employee]);
        } else {
            return redirect()->route('admin.auth.login');
        }
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
