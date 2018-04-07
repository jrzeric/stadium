<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Employee;
use App\Http\Profile;
use App\Http\User;
use DB;

class EmployeeController extends Controller
{
    public function index()
    {
        $value = session('login');
        if($value) {
            $users = DB::table('users')
                        ->join('employees', 'users.employee', '=', 'employees.id')
                        ->join('profiles', 'users.profile', '=', 'profiles.id')
                        ->select('users.employee as usersEmployee', 'users.profile as usersProfile', 'users.email as usersEmail', 'users.password as usersPassword', 'users.status as usersStatus',
                            'employees.id as employeesId', 'employees.firstName as employeesFirstName', 'employees.lastname as employeesLastName', 'employees.hired as employeesHired', 'employees.status as employeesStatus',
                            'profiles.id as profilesId', 'profiles.name as profilesName'
                        )
                        ->where([
                          ['employees.status', 'UP']
                        ])->get();
            if (User::find($value)->profile != 1) {
                return redirect()->route('sales.index');
            }

            $employees = Employee::all()->where('status', 'UP');
            return view('employees/index', ['employees' => $employees], ['users' => $users]);
        } else {
            return redirect()->route('admin.auth.login');
        }
    }

    public function create()
    {
        $value = session('login');
        if($value) {
            $profiles = Profile::all();
            return view('employees/create')->with('profiles', $profiles);
        } else {
            return redirect()->route('admin.auth.login');
        }
    }

    public function store(Request $request)
    {
        $firstName = $request->input('firstName');
        $lastName = $request->input('lastName');
        $hired = date('Y-m-d');

        $profile = $request->input('profile');

        $email = $request->input('email');
        $password = $request->input('password');

        $employee = new Employee ([
            'firstName' => $firstName,
            'lastname' => $lastName,
            'hired' => $hired
        ]);

        $employee->save();

        // encrypt password
        $salt = substr(sha1(date('r')), rand(0, 17), 22);
        $cost = 10;
        $hash = '$2y$' . $cost . '$' . $salt;
        //$verify = password_verify($request->input('password'), $hash);
        $hashed = crypt($password, "$hash");

        /*$employee = DB::table('employees')
                        ->select('employees.id as employeesId')
                        ->last();*/

        $user = new User ([
            'employee' => $employee->id,
            'profile' => $profile,
            'email' => $email,
            'password' => $hashed,
            'status' => 'UP'
        ]);

        $user->save();

        return redirect()->route('employeeIndex')->with('status', 'Employee created!');
    }

    public function edit($id)
    {
        $value = session('login');
        if($value) {
            //$employee = Employee::find($id);
            $profiles = Profile::all();
            //$user = User::find(1);*/

            $employee = DB::table('users')
                        ->join('employees', 'users.employee', '=', 'employees.id')
                        ->join('profiles', 'users.profile', '=', 'profiles.id')
                        ->select('users.employee as usersEmployee', 'users.profile as usersProfile', 'users.email as usersEmail', 'users.password as usersPassword', 'users.status as usersStatus',
                            'employees.id as employeesId', 'employees.firstName as employeesFirstName', 'employees.lastname as employeesLastName', 'employees.hired as employeesHired', 'employees.status as employeesStatus',
                            'profiles.id as profilesId', 'profiles.name as profilesName'
                        )
                        ->where([
                          ['employees.id', $id]
                        ])->get();

            return view('employees/show', ['employee' => $employee[0]], ['profiles' => $profiles]);
        } else {
            return redirect()->route('admin.auth.login');
        }
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if ($request->input('password') != '') {
            // encrypt password
            $salt = substr(sha1(date('r')), rand(0, 17), 22);
            $cost = 10;
            $hash = '$2y$' . $cost . '$' . $salt;
            //$verify = password_verify($request->input('password'), $hash);
            $hashed = crypt($request->input('password'), "$hash");
            $user->password = $hashed;
        }

        $user->profile = $request->input('profile');
        $user->save();
        return redirect()->route('employeeIndex')->with('status', 'Changes saved!');
    }

    public function destroy($id)
    {
        $employee = Employee::find($id);
        $employee->status = 'DW';
        $employee->save();

        $user = User::find($id);
        $user->status = 'DW';
        $user->save();
        return redirect()->route('employeeIndex')->with('status', 'Changes saved!');
    }
}
