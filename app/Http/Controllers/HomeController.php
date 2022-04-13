<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Config;
use App\Models\Todo;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Auth::user()->isUserLoggedIn()){

            $dos = Todo::paginate(6);

            return view('home',compact('dos')); 

        }

        if(Auth::user()->isCompanyLoggedIn()){

            return redirect('/');

        }

        if(Auth::user()->isAdminLoggedIn() || Auth::user()->isSuperAdminLoggedIn()){

            return redirect()->route('user.index');

        }
    }

}
