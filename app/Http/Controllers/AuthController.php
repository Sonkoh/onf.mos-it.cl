<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    function login(Request $request)
    {
        date_default_timezone_set('America/Santiago');
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return json_encode([
                "success" => false,
                "response" => $validator->messages()->first()
            ]);
        }

        if (Auth::attempt($validator->validated(), true)) {
            if (strtotime(Auth::user()->expiration) < time()) {
                return json_encode([
                    "success" => false,
                    "response" => "Tu cuenta se encuentra suspendida"
                ]);
            }
            Auth::login(Auth::user(), true);
            return json_encode([
                "success" => true
            ]);
        } else {
            return json_encode([
                "success" => false,
                "response" => "Datos Invalidos"
            ]);
        }
    }

    function update_password(Request $request)
    {
        if (Auth::guest()) return [
            "success" => false,
            "response" => "No te encuentras autenticado correctamente"
        ];
        $validator = Validator::make($request->all(), [
            'password' => 'required|string|confirmed|min:8|max:32',
        ]);
        if ($validator->fails()) return [
            "success" => false,
            "response" => $validator->messages()->first()
        ];
        $user = User::find(auth()->user()->id);
        $user->password = $request->password;
        $user->save();
        return [
            "success" => true,
            "response" => "Contraseña actualizada correctamente"
        ];
    }
}
