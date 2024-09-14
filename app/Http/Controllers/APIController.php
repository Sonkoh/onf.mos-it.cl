<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Api;
use App\Models\Vno;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class APIController extends Controller
{
    function ApiManagment()
    {
        date_default_timezone_set('America/Santiago');
        if (auth()->user()->group != 'admin') return abort(404);
        if (Auth::guest() || strtotime(Auth::user()->expiration) < time()) return redirect('/auth');
        $reports = [];
        $reports24 = [];
        foreach (Report::all() as $report) {
            if (!isset($reports[$report->api])) $reports[$report->api] = [];
            array_push($reports[$report->api], $report);
        }
        foreach (Report::all() as $report) {
            if (!strtotime($report->created_at) > strtotime('-1 hour')) return;
            if (!isset($reports24[$report->api])) $reports24[$report->api] = [];
            array_push($reports24[$report->api], $report);
        }
        return view('apiManagment', [
            "title" => "API Managment",
            "vnos" => Vno::all(),
            "apis" => Api::all(),
            "reports" => $reports,
            "reports24" => $reports,
        ]);
    }

    function apiCustom(Api $api)
    {
        date_default_timezone_set('America/Santiago');
        $hasPermissions = false;
        if (Auth::guest() || strtotime(Auth::user()->expiration) < time()) return redirect('/auth');
        foreach (Vno::all() as $vno) if (in_array("API_" . $api->id . "." . $vno->id, json_decode(auth()->user()->permissions, true))) $hasPermissions = true;
        if (!$hasPermissions) return abort(403);
        return view('apis', [
            "title" => $api->name,
            "api" => $api,
            "apis" => Api::all(),
            "reports" => Report::where('api', '=', $api->id)
                ->orderBy('created_at', 'desc')
                ->leftJoin('users', 'users.id', 'reports.owner')
                ->get(['reports.*', 'users.email']),
            "vnos" => Vno::all()
        ]);
    }

    static function executeAPI(Api $api, Vno $vno, $envrioment, Request $request, $log = true)
    {
        // return $request->access_id;
        try {
            // Establece el tiempo en Santiago
            date_default_timezone_set('America/Santiago');
            // Verificaciones de permisos
            if (Auth::guest()) return json_encode([
                "success" => false,
                "response" => "No estas autenticado correctamente"
            ]);

            if (strtotime(Auth::user()->expiration) < time()) return json_encode([
                "success" => false,
                "response" => "Tu cuenta se encuentra suspendida"
            ]);
            if (!in_array("API_" . $api->id . "." . $vno->id, json_decode(auth()->user()->permissions, true))) return json_encode([
                "success" => false,
                "response" => "No tienes suficientes permisos para hacer eso"
            ]);
            // Token
            $url = 'https://' . ($envrioment == 'qa' ? 'eq' : '') . 'api.onnetfibra.cl/token';
            $data = 'grant_type=client_credentials';
            $authorization = 'Authorization: Basic ' . json_decode($vno["token"], true)[$envrioment];
            // return $authorization;
            // if ($envrioment == 'production' && $vno->id == 1 && $api->id == 1)
            //     $authorization = 'Authorization: Basic MDd2NnIyZlZ4Tm5RbWJpR1EyaDd6YXd5ZTJJYTpNNXBzb2xvc1pmN3pSczU3aF9KYnpsRF9mdGdh';
            // if ($envrioment == 'production' && $vno->id == 1 && $api->id == 5)
            //     $authorization = 'Authorization: Basic MDd2NnIyZlZ4Tm5RbWJpR1EyaDd6YXd5ZTJJYTpNNXBzb2xvc1pmN3pSczU3aF9KYnpsRF9mdGdh';

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization));
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

            $token = curl_exec($ch);
            // return dd(json_decode($token, true));
            curl_close($ch);
            if (!isset(json_decode($token, true)["access_token"]))
                return json_encode([
                    "success" => false,
                    "response" => "Las credenciales internas han cambiado. Porfavor, contacte con un administrador."
                ]);
            // Ejecucion
            $envrioments = json_decode($api->methods, true);
            $url = "";
            foreach ($envrioments as $env) {
                if ($env["name"] == $envrioment) {
                    $url = ($env["url"]);
                    break;
                }
            }
            if ($api->id == 4) {
                $headers = array(
                    'Accept: application/json',
                    'Content-Type: application/json',
                    'Authorization: Bearer ' . json_decode($token, true)["access_token"],
                    'u_vno_id: ' . $vno->id_vno
                );
                // dd($vno->id);
            } elseif ($api->id == 5) {
                $headers = array(
                    'Accept: application/json',
                    'Content-Type: application/json',
                    'Authorization: Bearer ' . json_decode($token, true)["access_token"],
                    'u_vno_id: ' . $vno->id_vno
                );
            } elseif ($api->id == 6) {
                $headers = array(
                    'Accept: application/json',
                    'Content-Type: application/json',
                    'Authorization: Bearer ' . json_decode($token, true)["access_token"],
                    'u_vno_id: ' . $vno->id_vno
                );
            } elseif ($api->id == 7) {
                $headers = array(
                    'Accept: application/json',
                    'Content-Type: application/json',
                    'Authorization: Bearer ' . json_decode($token, true)["access_token"],
                    'u_vno_id: ' . $vno->id_vno
                );
            } else {
                $headers = array(
                    'Accept: application/json',
                    'Content-Type: application/json',
                    'Authorization: Bearer ' . json_decode($token, true)["access_token"],
                    'u_vno_Id: ' . intval($vno->id_vno)
                );
            }
            $data = $request->curl_data ?? [];
            foreach ($data as $key => $value) {
                if ($key == "u_characteristic_C1" || $key == "u_characteristic_C2") {
                    $data[$key] = intval($value);
                }
                if ($key == "u_service_voip" || $key == "u_service_iptv" || $key == "u_service_ba") {
                    $data[$key] = boolval($value);
                }
            }
            if ($api->id != 4) $data["u_id_vno"] = $vno->id_vno;
            foreach ($data as $key => $value) {
                $url = str_replace("%$key%", $value, $url);
            }
            $ch = curl_init();
            if ($api->method == "GET") {
                curl_setopt($ch, CURLOPT_HTTPGET, true);
            } else {
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            }
            // return $url;
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLINFO_HEADER_OUT, true);
            $time_start = microtime(true);
            $response = curl_exec($ch);
            if ($response == false) {
                return json_encode([
                    "success" => false,
                    "response" => "ERROR DE CURL: " . curl_error($ch)
                ]);
            }
            $curlCommand = 'curl ';
            $curlCommand .= '-X ' . $api->method . ' ';
            $curlCommand .= ' -H "accept: application/json" -H "Content-Type: application/json" -H "Authorization: Bearer <token>';
            $curlCommand .= '-d "' . json_encode($data) . '" ';
            $curlCommand .= $url;
            if ($log) {
                $report = new Report();
                $report->curl = $curlCommand;
                $report->ambient = $envrioment;
                $report->response = $response;
                $report->request = json_encode($request->curl_data ?? []);
                $report->api = $api->id;
                $report->vno = $vno->id;
                $report->in_flow = (isset($request->in_flow) ? $request->in_flow : 0);
                $report->status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                $report->owner = auth()->user()->id;
                $report->time = formatToTime(microtime(true) - $time_start);
                $report->save();
            }
            curl_close($ch);
            return json_encode([
                "success" => true,
                "report" => isset($report) ? json_encode($report) : "NO_REPORT",
                "response" => $response
            ]);
        } catch (Exception $e) {
            return json_encode([
                "success" => false,
                "response" => $e->getMessage()
            ]);
        }
    }
    function cloneRequest(Report $report)
    {
        $re = json_decode(self::executeAPI(Api::find($report->api), Vno::find($report->vno), $report->ambient, new Request(["curl_data" => json_decode($report->request, true)], ["curl_data" => json_decode($report->request, true)]), false), true);
        $re["report"] = $report;
        return $re;
    }
}
