<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Api;
use App\Models\FlowType;
use App\Models\Vno;
use Illuminate\Support\Facades\DB;

class FlowController extends Controller
{
    function home() {
        date_default_timezone_set('America/Santiago');
        if (Auth::guest() || strtotime(Auth::user()->expiration) < time()) return redirect('/auth');
        return view('flows', [
            "title" => "Crear Flujo",
            "vnos" => Vno::all(),
            "apis" => Api::all(),
            "flows" => FlowType::all(),
            "reports" => DB::select("SELECT apis.name, reports.ambient, reports.vno, users.email, reports.status, reports.time, reports.created_at FROM `reports` LEFT JOIN users ON users.id = reports.owner LEFT JOIN apis ON apis.id = reports.api WHERE reports.in_flow = 1 ORDER BY reports.id DESC LIMIT 20")
        ]);
    }

    function request_flow(FlowType $flow, Vno $vno) {
        $apis = Api::whereIn("id", array_map(fn($item) => $item->api, json_decode($flow->apis)))->get();
        $values = [];
        $link_values = [];
        $aps = [];
        foreach ($apis as $api) {
            // if (array_key_exists($vno->id, json_decode($api->values, true))) {
            //     foreach (json_decode($api->values, true)[$vno->id] as $k => $v) {
            //         $values[$k] = $v;
            //     }
            // }
            // if (array_key_exists($vno->id, json_decode($api->link_values, true))) {
            //     foreach (json_decode($api->link_values, true)[$vno->id] as $k => $v) {
            //         $link_values[$k] = $v;
            //     }
            // }
            $ext = $api->id;
            $d = array_filter(json_decode($flow->apis, true), function($item) use ($ext) {
                return $item['api'] == $ext;
            });
            $aps[] = [
                "id" => $api->id,
                "name" => $api->name,
                "delay" => reset($d)["delay"],
                "values" => json_decode($api->values, true),
                "link_values" => json_decode($api->link_values, true),
            ];
        }
        return [
            "values" => $values,
            "link_values" => $link_values,
            "apis" => $aps
        ];
    }
}
