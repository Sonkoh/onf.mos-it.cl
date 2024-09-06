<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Api;
use App\Models\Vno;

class HomeController extends Controller
{
    function home() {
        date_default_timezone_set('America/Santiago');
        if (Auth::guest() || strtotime(Auth::user()->expiration) < time()) return redirect('/auth');
        return view('home', [
            "title" => "Inicio",
            "vnos" => Vno::all(),
            "apis" => Api::all()
        ]);
    }

    function login() {
        date_default_timezone_set('America/Santiago');
        if (Auth::check() && !(strtotime(Auth::user()->expiration) < time())) return redirect('/');
        return view('login');
    }

    function logout() {
        date_default_timezone_set('America/Santiago');
        Auth::logout();
        return redirect('/auth');
    }
}
