<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Api;
use App\Models\Vno;

class UsersController extends Controller
{
    function home()
    {
        date_default_timezone_set('America/Santiago');
        if (Auth::guest() || strtotime(Auth::user()->expiration) < time()) return redirect('/auth');
        if (auth()->user()->group != 'admin') return abort(404);
        return view('users', [
            "title" => "Perfiles",
            "users" => User::all(),
            "reports" => Report::all(),
            "vnos" => Vno::all(),
            "apis" => Api::all(),
            "active_users" => DB::table('users as u')
                ->join('reports as r', 'u.id', '=', 'r.owner')
                ->where('r.created_at', '>=', DB::raw('DATE_SUB(CURRENT_DATE(), INTERVAL 14 DAY)'))
                ->select('u.id')
                ->distinct()
                ->groupBy('u.id')
                ->orderBy('u.id')
                ->get()
                ->toArray()
        ]);
    }

    function create(Request $request)
    {
        date_default_timezone_set('America/Santiago');
        if (Auth::guest()) return json_encode([
            "success" => false,
            "response" => "No estas autenticado correctamente"
        ]);

        if (strtotime(Auth::user()->expiration) < time()) return json_encode([
            "success" => false,
            "response" => "Tu cuenta se encuentra suspendida"
        ]);

        if (auth()->user()->group != 'admin') return json_encode([
            "success" => false,
            "response" => "No tienes suficientes permisos para hacer eso"
        ]);

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:191|unique:users',
            'password' => 'required|string|min:6|max:191',
            'expiration' => 'required|date'
        ]);

        if ($validator->fails()) {
            return json_encode([
                "success" => false,
                "response" => $validator->messages()->first()
            ]);
        }

        $user = new User();
        $user->email = $request->email;
        $user->password = $request->password;
        $user->expiration = $request->expiration;
        $user->permissions = json_encode($request->permissions);
        $user->save();
        return json_encode([
            "success" => true
        ]);
    }

    function edit(Request $request)
    {
        date_default_timezone_set('America/Santiago');
        if (Auth::guest()) return json_encode([
            "success" => false,
            "response" => "No estas autenticado correctamente"
        ]);

        if (strtotime(Auth::user()->expiration) < time()) return json_encode([
            "success" => false,
            "response" => "Tu cuenta se encuentra suspendida"
        ]);

        if (auth()->user()->group != 'admin') return json_encode([
            "success" => false,
            "response" => "No tienes suficientes permisos para hacer eso"
        ]);
        $validator = Validator::make($request->all(), [
            'user' => 'required|int',
            'password' => 'nullable|string|max:191',
            'expiration' => 'required|date'
        ]);

        if ($validator->fails()) {
            return json_encode([
                "success" => false,
                "response" => $validator->messages()->first()
            ]);
        }
        $user = User::find($request->user);
        if (!empty($request->password)) {
            $user->password = $request->password;
        }
        $user->expiration = Carbon::createFromTimestamp(strtotime($request->expiration));
        $user->permissions = json_encode($request->permissions);
        $user->save();
        return json_encode([
            "success" => true
        ]);
    }

    function delete(Request $request)
    {
        date_default_timezone_set('America/Santiago');
        if (Auth::guest()) return json_encode([
            "success" => false,
            "response" => "No estas autenticado correctamente"
        ]);

        if (strtotime(Auth::user()->expiration) < time()) return json_encode([
            "success" => false,
            "response" => "Tu cuenta se encuentra suspendida"
        ]);

        if (auth()->user()->group != 'admin') return json_encode([
            "success" => false,
            "response" => "No tienes suficientes permisos para hacer eso"
        ]);
        foreach ($request->users as $user) {
            User::find($user)->delete();
        }
        return json_encode([
            "success" => true
        ]);
    }
}
