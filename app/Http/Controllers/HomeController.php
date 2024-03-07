<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;
        if($role == '1')
        {
            return redirect('/admin');
        }
        else
        {
            return redirect('/');
        }
        
    }
    public function thongtinuser()
    {
        return view('thongtincanhan');
    }
    public function check()
    {
        if(Auth::user())
        {
            return 1;
        }else{
            return 0;
        }
    }
}
