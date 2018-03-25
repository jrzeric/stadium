<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Event;
use DB;

class EventController extends Controller
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

            $events = Event::all();
            return view('events/index', ['events' => $events]);
        } else {
            return redirect()->route('admin.auth.login');
        }

    }

    public function create()
    {
        $value = session('login');
        if($value) {
            return view('events/create');
        } else {
            return redirect()->route('admin.auth.login');
        }
    }

    public function store(Request $request)
    {
        $name = $request->input('name');
        $date = $request->input('date');
        $description = $request->input('description');
        $image = '0';

        $event = new Event ([
            'name' => $name,
            'date' => $date,
            'description' => $description,
            'image' => $image
        ]);

        $event->save();
        return redirect()->route('eventIndex')->with('status', 'Event created!');
    }

    public function edit($id)
    {
        $value = session('login');
        if($value) {
            $event = Event::find($id);
            return view('events/show', ['event' => $event]);
        } else {
            return redirect()->route('admin.auth.login');
        }
    }

    public function update(Request $request, $id)
    {
        $event = Event::find($id);

        $event->name = $request->input('name');
        $event->date = $request->input('date');
        $event->description = $request->input('description');

        $event->save();
        return redirect()->route('eventIndex')->with('status', 'Changes saved!');
    }

    public function destroy()
    {
        // Vacio
    }
}
