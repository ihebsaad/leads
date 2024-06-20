<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\User;

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
        return view('home');
    }

    public function settheme(Request $request)
	{
		$user = $request->get('user');
		$theme =  $request->get('theme');

		User::where('id', $user)->update(array('theme' => $theme));
        //session(['theme' => $theme]);

    }
}
