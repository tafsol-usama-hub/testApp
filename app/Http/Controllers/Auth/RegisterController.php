<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Config;

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
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user_type_id = array_key_exists('company', $data) ? Config::get('constants.UserTypeIds.Company') : Config::get('constants.UserTypeIds.User');

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'user_type_id' => Config::get('constants.UserTypeIds.User'),
            'password' => Hash::make($data['password']),
        ]);

        // if($user_type_id == Config::get('constants.UserTypeIds.Company')){

        //     Company::create([
        //         'user_id'=>$user->id,
        //         'name'=>$data["name"],
        //         "contact_no"=>$data['number'],
        //         "isActive"=>1,
        //     ]);

        //     $user->assignRole('Company');

        // }

        // if($user_type_id == Config::get('constants.UserTypeIds.User')){

        //     UserDetail::create([
        //         'user_id'=>$user->id,
        //         'name'=>$data["name"],
        //         "contact_no"=>$data['number'],
        //         "isActive"=>1,
        //     ]);

        //     $user->assignRole('User');

        // }

        return $user;
    }
}
