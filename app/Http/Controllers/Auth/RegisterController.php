<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Auth\JsonResponse;
use App\Http\Controllers\MailController;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'nrp' => $data['nrp'],
            'email' => $data['email'],
            'name' => $data['nama'],
            'password' => Hash::make($data['password']),
            'vote_tickets' => 3,
            'role' => 'Umum',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */

    public function register(Request $request)
    {
        $request->validate([
            'nrp' => ['required', 'string', 'min:9', 'max:9', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required', 'string'],
        ], [
            'nrp.min' => "NRP must have 9 characters",
            'nrp.max' => "NRP must have 9 characters",
        ]);
        
        $user = new User();
        $user->nrp = $request->nrp;
        $user->name = $request->nama;
        $user->email = "s".$request->nrp."@student.ubaya.ac.id";
        $user->password = Hash::make($request->password);
        $user->vote_tickets = 3;
        $user->role = "Umum";
        $user->save();

        if($user != null){
            return redirect()->back()->with(session()->flash('alert-success', 'Your account has been created. Please login for verification link.'));
        }

        return redirect()->back()->with(session()->flash('alert-danger', 'Something went wrong!'));
    }
}