<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        if (Auth::user()->isAdmin()) 
        {
            return redirect()->route('admin');
        }
        elseif (Auth::user()->isVendor()) 
        { 
            return redirect()->route('vendor');
        }
        elseif (Auth::user()->isSubVendor()) 
        { 
            return redirect()->route('subVendor');
        }
        else
        {
            return redirect()->route('unauthorized');
        }
        
    }
}
