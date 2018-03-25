<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use DB;
use Redirect;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/sales';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        $value = session('login');
        if($value) {
            return redirect()->route('sales.index');
        } else {
            return view('auth/login');
        }
    }

    public function login(Request $request)
    {
        $user = DB::table('users')
                    ->join('employees', 'users.employee', '=', 'employees.id')
                    ->join('profiles', 'users.profile', '=', 'profiles.id')
                    ->select('users.employee as usersEmployee', 'users.profile as usersProfile', 'users.email as usersEmail', 'users.password as usersPassword', 'users.status as usersStatus',
                        'employees.id as employeesId', 'employees.firstName as employeesFirstName', 'employees.lastname as employeesLastName', 'employees.hired as employeesHired', 'employees.status as employeesStatus',
                        'profiles.id as profilesId', 'profiles.name as profilesName'
                    )
                    ->where([
                      ['users.email', $request->input('email')],
                      ['users.password', $request->input('password')],
                      ['employees.status', 'UP']
                    ])->get();

          if(count($user) == 1) {
              session(['login' => $user[0]->employeesId]);
              session(['profile' => $user[0]->profilesId]);
              return redirect()->route('sales.index');
          } else {
              return Redirect::back()->with('message','Bad E-Mail or Password!');
          }
    }

    public function logout()
    {
        session()->forget('login');
        return Redirect::back();
    }
}
