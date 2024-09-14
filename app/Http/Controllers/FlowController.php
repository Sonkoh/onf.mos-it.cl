<?php

namespace App\Http\Controllers;

use App\Exports\DynamicExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Api;
use App\Models\FlowType;
use App\Models\Vno;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class FlowController extends Controller
{
    function home()
    {
        date_default_timezone_set('America/Santiago');
        if (Auth::guest() || strtotime(Auth::user()->expiration) < time()) return redirect('/auth');
        return view('flows', [
            "title" => "Crear Flujo",
            "vnos" => Vno::all(),
            "apis" => Api::all(),
            "flows" => FlowType::all(),
            "reports" => DB::select("SELECT apis.name, reports.ambient, reports.vno, users.email, reports.status, reports.in_flow, reports.time, reports.created_at FROM `reports` LEFT JOIN users ON users.id = reports.owner LEFT JOIN apis ON apis.id = reports.api WHERE reports.in_flow > 0 ORDER BY reports.id DESC LIMIT 20")
        ]);
    }
    function adminFlows()
    {
        date_default_timezone_set('America/Santiago');
        if (Auth::guest() || strtotime(Auth::user()->expiration) < time()) return redirect('/auth');
        return view('adminflows', [
            "title" => "Lista de Flujos",
            "vnos" => Vno::all(),
            "apis" => Api::all(),
            "flows" => FlowType::all()
        ]);
    }
    function createFlow(Request $request){
        date_default_timezone_set('America/Santiago');
        if (Auth::guest() || strtotime(Auth::user()->expiration) < time()) return redirect('/auth');
        $name = $request->name;
        if (strlen($name) > 16 || strlen($name) < 3)
            $name = "Flujo nuevo";
        $flow = new FlowType;
        $flow->name = $name;
        $flow->apis = "[]";
        $flow->save();
        return redirect("/admin/flows/$flow->id");
    }

    function view(FlowType $flow) {
        date_default_timezone_set('America/Santiago');
        if (Auth::guest() || strtotime(Auth::user()->expiration) < time()) return redirect('/auth');
        return view('viewFlow', [
            "title" => $flow->name,
            "vnos" => Vno::all(),
            "apis" => Api::all(),
            "flow" => $flow,
        ]);
    }

    function request_flow(FlowType $flow, Vno $vno)
    {
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
            $d = array_filter(json_decode($flow->apis, true), function ($item) use ($ext) {
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
    function download(Vno $vno, string $ambient, FlowType $flow)
    {
        if ($ambient != 'qa' && $ambient != 'production')
            return abort(404);
        $data = [
            ['Flujo', '', 'Clave', 'Valor', 'Comentario'],
            ['', '0', 'onf_vno', $vno->id, 'NO CAMBIAR'],
            ['', '0', 'onf_env', $ambient, 'qa/production'],
            ['', '0', 'onf_flow', $flow->id, 'NO CAMBIAR']
        ];
        $row = 4;
        $n = 1;
        $apiRows = [];
        $valueRows = [];
        foreach (json_decode($flow->apis, true) as $flowApi) {
            $row++;
            array_push($apiRows, $row);
            $api = Api::find($flowApi["api"]);
            array_push($data, [$api->name, 'Api', 'Clave', 'Comentario', 'Valores 1', 'Valores 2', 'Valores 3', 'Valores 4', 'Valores 5', 'Valores 6', 'Valores 7', 'Valores 8', 'Valores 9', '...']);
            foreach (json_decode($api->values, true)[$vno->id] as $key => $value) {
                $row++;
                array_push($valueRows, $row);
                array_push($data, ['', "$n", "$key", is_bool($value) ? "1 es TRUE y 0 es FALSE" : "", "$value"]);
            }
            $n++;
        }

        return Excel::download(new DynamicExport($data, $apiRows, $valueRows), str_replace("/", '', $flow->name) . '.xlsx');
    }
}
