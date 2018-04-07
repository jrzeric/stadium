<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class UserApi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = DB::table('users')
                    ->join('employees', 'users.employee', '=', 'employees.id')
                    ->join('profiles', 'users.profile', '=', 'profiles.id')
                    ->select('users.employee as usersEmployee', 'users.profile as usersProfile', 'users.email as usersEmail', 'users.password as usersPassword', 'users.status as usersStatus',
                        'employees.id as employeesId', 'employees.firstName as employeesFirstName', 'employees.lastname as employeesLastName', 'employees.hired as employeesHired', 'employees.status as employeesStatus',
                        'profiles.id as profilesId', 'profiles.name as profilesName'
                    )
                    ->where([
                      ['employees.status', 'UP'],
                      ['users.status', 'UP']
                    ])->get();

        $array = array('status' => 1, 'message' => 'No users found!');

        if (count($users) > 0) {
            $list = array();

            foreach ($users as $user) {
                $profile = array(
                    'id' => $user->profilesId,
                    'name' => $user->profilesName
                );

                $employee = array(
                    'id' => $user->employeesId,
                    'firstName' => $user->employeesFirstName,
                    'lastname' => $user->employeesLastName,
                    'hired' => $user->employeesHired,
                    'status' => $user->employeesStatus
                );

                $user = array(
                    'employee' => $employee,
                    'profile' => $profile,
                    'email' => $user->usersEmail,
                    'password' => $user->usersPassword,
                    'status' => $user->usersStatus,
                );

                array_push($list, $user);
            }

            $array = array('status' => 0, 'users' => $list);
        }

        return response()->json($array);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
