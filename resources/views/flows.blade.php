@extends('base')
@section('top')
<div class="col-sm mb-2 mb-sm-0">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-no-gutter">
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="javascript:;"></a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
        </ol>
    </nav>
    <h1 class="page-header-title">{{ $title }}</h1>
</div>
@endsection
@section('content')
<ul class="nav nav-segment mb-2">
    <li class="nav-item">
        <a class="nav-link active" href="javascript:void(0)">Única</a>
    </li>
    <li class="nav-item">
        <input type="file" class="d-none" id="masive" accept=".xlsx">
        <label for="masive" class="nav-link cursor-pointer">Masiva</label>
    </li>
</ul>
<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card p-4 mb-2">
            <label for="vno" class="form-label">VNO</label>
            <select class="form-select mb-4" id="vno" disabled>
                @foreach($vnos as $vno)
                <option value="{{$vno->id}}">{{$vno->name}}</option>
                @endforeach
            </select>
            <label for="" class="form-label">Ambiente</label>
            <div class="input-group input-group-sm-vertical mb-4">
                <label class="form-control" for="editUserModalAccountTypeModalRadioEg1_1">
                    <span class="form-check">
                        <input type="radio" class="form-check-input" name="ambiente" id="editUserModalAccountTypeModalRadioEg1_1" checked data-value="qa" data-value2="QA">
                        <span class="form-check-label">QA</span>
                    </span>
                </label>
                <label class="form-control" for="editUserModalAccountTypeModalRadioEg1_2">
                    <span class="form-check">
                        <input type="radio" class="form-check-input" name="ambiente" id="editUserModalAccountTypeModalRadioEg1_2" data-value="production" data-value2="Producción">
                        <span class="form-check-label">Producción</span>
                    </span>
                </label>
            </div>
            <label for="flow" class="form-label">Flujo</label>
            <select class="form-select mb-4" id="flow" disabled>
                @foreach($flows as $flow)
                <option value="{{$flow->id}}">{{$flow->name}}</option>
                @endforeach
            </select>
            <a href="javascript:downloadFlow()" class="btn btn-sm btn-secondary">Descargar Plantilla de Flujo (Excel)</a>
        </div>
        <!-- Nav -->
        <ul class="nav nav-segment mb-2 w-100" role="tablist" id="tab">
            <li class="nav-item">
                <a class="nav-link active" id="nav-one-eg1-tab" href="#nav-one-eg1" data-bs-toggle="pill" data-bs-target="#nav-one-eg1" role="tab" aria-controls="nav-one-eg1" aria-selected="true">Valores 1</a>
            </li>
        </ul>
        <div class="tab-content" id="tb-content">
            <div class="tab-pane fade show active" id="nav-one-eg1" role="tabpanel" aria-labelledby="nav-one-eg1-tab">
                <div class="card p-4">
                    <div id="inputs">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div id="apis" class="d-grid gap-3 mb-2">
        </div>
        <button class="btn btn-primary w-100 mt-2 mb-4" id="executeFlush" disabled>Ejecutar Flujo</button>
        <div class="card p-5" style="overflow-x: scroll;">
            <table class="table overflow-x-scroll">
                <thead>
                    <tr>
                        <th scope="col"><i class="bi bi-clock-history" style="margin-right: .5rem;"></i></th>
                        <th scope="col">Ambiente</th>
                        <th scope="col">Flujo</th>
                        <th scope="col">Ejecutado por</th>
                        <th scope="col">Código de respuesta</th>
                        <th scope="col" style="text-transform: initial;">TIEMPO DE RESPUESTA (Seg)</th>
                        <th scope="col">Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $i = 0;
                    @endphp
                    @foreach($reports as $report)
                    @php
                    $i++;
                    $formattedDate = date('d/m/Y', strtotime($report->created_at));
                    $formattedTime = date('H:i', strtotime($report->created_at));
                    $datetime = new DateTime($report->created_at);
                    $currentDatetime = new DateTime();
                    $interval = $currentDatetime->diff($datetime);
                    $timeAgo = '';
                    if ($interval->y > 0) {
                    $timeAgo = 'hace ' . $interval->y . ' año' . ($interval->y > 1 ? 's' : '');
                    } elseif ($interval->m > 0) {
                    $timeAgo = 'hace ' . $interval->m . ' mes' . ($interval->m > 1 ? 'es' : '');
                    } elseif ($interval->d > 0) {
                    $timeAgo = 'hace ' . $interval->d . ' día' . ($interval->d > 1 ? 's' : '');
                    } elseif ($interval->h > 0) {
                    $timeAgo = 'hace ' . $interval->h . ' hora' . ($interval->h > 1 ? 's' : '');
                    } elseif ($interval->i > 0) {
                    $timeAgo = 'hace ' . $interval->i . ' minuto' . ($interval->i > 1 ? 's' : '');
                    } elseif ($interval->s > 0) {
                    $timeAgo = 'hace ' . $interval->s . ' segundo' . ($interval->s > 1 ? 's' : '');
                    } else {
                    $timeAgo = 'justo ahora';
                    }
                    @endphp
                    <tr>
                        <th scope="row">{{ $timeAgo }}</th>
                        <td><span class="badge bg-soft-danger rounded-pill">{{ strtoupper($report->ambient) }}</span></td>
                        <td>{{ $report->in_flow }}</td>
                        <td>{!! isset($report->email) ? $report->email : '<span class="badge bg-soft-danger rounded-pill">USUARIO NO ENCONTRADO</span>' !!}</td>
                        <td>{{ $report->status }}</td>
                        <td>{{ $report->time }}s</td>
                        <td>{{ $formattedDate . ' a las ' . $formattedTime }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
@endsection
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script>
    var flush;
    var responses = {};
    var n = 0;
    var only = true;
    var flow = 0;
    var vno = 0;
    var eles = {};

    function downloadFlow() {
        window.open(`/flows/${$('#vno').val()}/${$('[name="ambiente"]:checked').attr('data-value')}/${$('#flow').val()}/download`, "_blank");
    }

    function transpose(matrix) {
        return matrix[0].map((_, colIndex) => matrix.map(row => row[colIndex]));
    }

    async function imprimirValores(obj, flow, vno) {
        $('#apis').html(`<div class="alert alert-soft-warning m-0" role="alert">Tienes cargado un flujo masivo.</div>`);
        only = false;
        $('#tab').html('');
        ac = true;
        $('#tb-content').html('');
        eles = {};
        for (h = 4; h < obj.length; h++) {
            for (let i = 0; i < obj[h].length; i++) {
                const val = obj[h][i];
                if (obj[1][i] != "Api") {
                    if (!eles[h]) {
                        eles[h] = {
                            list: {},
                            name: obj[h][0]
                        };
                    }
                    if (!eles[h]["list"]) {
                        eles[h]["list"] = {};
                    }
                    if (!eles[h]["list"][obj[1][i]]) {
                        eles[h]["list"][obj[1][i]] = {};
                    }
                    eles[h]["list"][obj[1][i]][obj[2][i]] = obj[h][i];
                }
            }
            const keysToRemove = [];

            Object.keys(eles).forEach(h => {
                const list = eles[h]["list"];

                const allUndefined = Object.keys(list).every(key =>
                    Object.values(list[key]).every(value => value === undefined)
                );

                if (allUndefined) {
                    keysToRemove.push(h);
                }
            });

            keysToRemove.forEach(h => {
                delete eles[h];
            });
        }
        for (const h of Object.keys(eles)) {
            value = eles[h];
            if (!value) return;
            await new Promise((r) => {
                $.ajax({
                    type: "GET",
                    url: `/api/v2/flow/request/${flow}/${vno}`,
                    data: {
                        _token: "{{csrf_token()}}"
                    },
                    success: function(response) {
                        $('#tb-content').append(`<div class="tab-pane fade ${ac ? "show active" : ""}" id="masive_${h}_t" role="tabpanel" aria-labelledby="masive_${h}_tt">
                                <div class="card p-4" id="masive_${h}">
                                </div>
                            </div>`);
                        $('#tab').append(`<li class="nav-item">
                                <a class="nav-link ${ac ? "active" : ""}" id="masive_${h}_tt" href="#masive_${h}_t" data-bs-toggle="pill" data-bs-target="#masive_${h}_t" role="tab" aria-controls="masive_${h}_t" aria-selected="true">${eles[h]["name"]}</a>
                            </li>`);
                        ac = false;
                        i = 0;
                        response.apis.forEach(api => {
                            i++;
                            ac = false
                            $(`#masive_${h}`).append(`<div class="divider divider-center">${api.name}</div>`);
                            Object.keys(api.values[parseInt($('#vno').val())]).forEach(key => {
                                value = api.values[parseInt($('#vno').val())][key];
                                $(`#masive_${h}`).append(`<label for="ipt_${i}_${key}_${h}" class="form-label">${key}</label><input type="text" data-masive-api="${i}" data-masive-key="${key}" data-masive-h="${h}" autocomplete="off" id="ipt_${i}_${key}_${h}" name="curl_data" class="form-control mb-2 zzzzz" value="${eles[h]["list"][i][key]}">`);
                            });
                        });
                        r();
                    }
                });
            });
        }
        $('#loader').fadeOut();
    }
    $('#masive').change(function() {
        file = event.target.files[0];
        if (!file) return;
        $('#loader').fadeIn(500);

        setTimeout(() => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const data = new Uint8Array(e.target.result);
                const workbook = XLSX.read(data, {
                    type: 'array'
                });
                const sheetName = workbook.SheetNames[0];
                const sheet = workbook.Sheets[sheetName];
                const rows = XLSX.utils.sheet_to_json(sheet, {
                    header: 1
                });
                const columns = rows[0].map((_, colIndex) => rows.map(row => row[colIndex]));;
                rows.forEach((row, index) => {
                    if (row[1] == 0 && row[2] == "onf_vno") {
                        vno = row[3];
                        setTimeout(() => {
                            $('#vno').val(row[3]).change();
                        }, 200);
                        return;
                    }
                    if (row[1] == 0 && row[2] == "onf_env") {
                        $('input[name="ambiente"][data-value="' + row[3] + '"]').prop('checked', true);
                        return;
                    }
                    if (row[1] == 0 && row[2] == "onf_flow") {
                        $('#vno').val(row[3])
                        flow = row[3];
                        return;
                    }
                });
                setTimeout(() => {
                    // loadFlow(function() {
                    imprimirValores(transpose(rows.slice(4)), flow, vno);
                    // rows.forEach((row, index) => {
                    //     $(`[data-api="${parseInt(row[1])-1}"][data-key="${row[2]}"]`).val(row[3]);
                    // });
                    // $('#loader').fadeOut();
                    // });
                }, 1000);
            };
            reader.readAsArrayBuffer(file)
        }, 500);
        $('#masive').val('');
    })

    function drawResponse(result, tab, son = 0) {
        for (var key in result) {
            if (typeof(result[key]) == 'object') {
                sons = "";
                for (i = 0; i < son; i++) {
                    if (son - 1 == i) {
                        sons += `<i class="bi bi-arrow-return-right" style="margin-right: 1rem"></i>`;
                    } else {
                        sons += `<span style="width: 14px; display: inline-block; height:1ch"></span>`;
                    }
                }
                if (Array.isArray(result[key]) && result[key].length > 0) {
                    $(tab).append(`<div class="row" style="margin: 1rem 0;">
                                <label class="col-sm-4 col-form-label">${sons}${key}</label>
                                <div class="col-sm-8 d-flex m-auto">Array(${result[key].length})</div>
                            </div>`);
                } else {
                    $(tab).append(`<div class="row" style="margin: 1rem 0;">
                                <label class="col-sm-4 col-form-label">${sons}${key}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" value="{}" readonly disabled>
                                </div>
                            </div>`);
                }
                drawResponse(result[key], tab, son + 1)
            } else {
                sons = "";
                for (i = 0; i < son; i++) {
                    if (son - 1 == i) {
                        sons += `<i class="bi bi-arrow-return-right" style="margin-right: 1rem"></i>`;
                    } else {
                        sons += `<span style="width: 14px; display: inline-block; height:1ch"></span>`;
                    }
                }

                $(tab).append(`<div class="row" style="margin: 1rem 0;">
                                <label class="col-sm-4 col-form-label">${sons}${key}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" value="${result[key]}" readonly disabled>
                                </div>
                            </div>`);
            }
        }
    }

    function drawResponse2(result, resultNew, tab, son = 0) {
        for (var key in result) {
            if (typeof(result[key]) == 'object') {
                sons = "";
                for (i = 0; i < son; i++) {
                    if (son - 1 == i) {
                        sons += `<i class="bi bi-arrow-return-right" style="margin-right: 1rem"></i>`;
                    } else {
                        sons += `<span style="width: 14px; display: inline-block; height:1ch"></span>`;
                    }
                }
                if (Array.isArray(result[key]) && result[key].length > 0) {
                    $(tab).append(`<div class="row" style="margin: 1rem 0;">
                                <label class="col-sm-4 col-form-label">${sons}${key}</label>
                                <div class="col-sm-8 d-flex m-auto">Array(${result[key].length})</div>
                            </div>`);
                } else {
                    $(tab).append(`<div class="row" style="margin: 1rem 0;">
                                <label class="col-sm-4 col-form-label">${sons}${key}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" value="{}" readonly disabled>
                                </div>
                            </div>`);
                }
                drawResponse2(result[key], resultNew[key], tab, son + 1)
            } else {
                sons = "";
                for (i = 0; i < son; i++) {
                    if (son - 1 == i) {
                        sons += `<i class="bi bi-arrow-return-right" style="margin-right: 1rem"></i>`;
                    } else {
                        sons += `<span style="width: 14px; display: inline-block; height:1ch"></span>`;
                    }
                }

                nResult = (resultNew[key] ?? "INDEFINIDO");

                $(tab).append(`<div class="row" style="margin: 1rem 0;">
                            <label class="col-sm-4 col-form-label">${sons}${key}</label>
                            <div class="col-sm-8">
                                <div class="row">
                                    <div class="col">
                                        <input type="text" class="form-control" value="${result[key]}" readonly>
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control bg-${filterEquals(result[key], nResult) ? 'success' : 'danger'}" value="${nResult}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>`);
            }
        }
    }

    function loadFlow(cb = function() {}) {
        $.ajax({
            type: "GET",
            url: "/api/v2/flow/request/" + $('#flow').val() + "/" + $('#vno').val(),
            data: {
                _token: "{{csrf_token()}}"
            },
            success: function(response) {
                $('#flow').prop("disabled", false);
                $('#vno').prop("disabled", false);
                $('#apis').html('');
                only = true;
                $('#tab').html(`<li class="nav-item"><a class="nav-link active" role="tab" aria-selected="true">Flujo</a></li>`);
                $('#tb-content').html('<div id="inputs" class="card p-4"></div>');
                // Object.keys(response.values).forEach(key => {
                //     value = response.values[key];
                //     $('#inputs').append(`<label for="ipt_${key}" class="form-label">${key}</label><input type="text" id="ipt_${key}" name="curl_data" class="form-control mb-2 zzzzz" value="${value}" data-key="${key}">`);
                // });
                // for (i = 0; i < response.apis.length; i++) {
                //     api = response.apis[i];
                //     $('#apis').append(`<div class="row" data-api="${i}">
                //         <div class="col-4 d-flex align-items-center">${api.name}</div>
                //         <div class="col-4 text-center d-flex align-items-center justify-content-center" data-util="time">-</div>
                //         <div class="col-4 d-flex align-items-center justify-content-end" data-util="proc"></div>
                //     </div>`);
                // }
                // $('#executeFlush').prop('disabled', false);
                i = 0;
                response.apis.forEach(api => {
                    $('#inputs').append(`<div class="divider divider-center">${api.name}</div>`);
                    Object.keys(api.values[parseInt($('#vno').val())]).forEach(key => {
                        value = api.values[parseInt($('#vno').val())][key];
                        $('#inputs').append(`<label for="ipt_${i}_${key}" class="form-label">${key}</label><input type="text" autocomplete="off" id="ipt_${i}_${key}"  name="curl_data" class="form-control mb-2 zzzzz" value="${value}" data-key="${key}" data-api="${i}">`);
                    });
                    $('#apis').append(`<div class="row" data-api="${i}">
                        <div class="col-4 d-flex align-items-center">${api.name}</div>
                        <div class="col-4 text-center d-flex align-items-center justify-content-center" data-util="time">-</div>
                        <div class="col-4 d-flex align-items-center justify-content-end" data-util="proc"></div>
                    </div>`);
                    i++;
                });
                flush = response.apis;
                $('#executeFlush').prop('disabled', false);
                cb();
            }
        });
    }

    function openRep(n) {
        $("#modal-ddd").html('');
        drawResponse(responses[n], "#modal-ddd");
        $('#exampleModalLong').modal('show')
    }

    $('#executeFlush').click(async function(e) {
        e.preventDefault();
        $('#executeFlush').prop('disabled', true);
        $('#flow').prop("disabled", true);
        $('#vno').prop("disabled", true);
        $('[name="ambiente"]').each((a, b) => {
            $(b).prop("disabled", true);
        });
        $('.zzzzz').each((a, b) => {
            $(b).prop("disabled", true);
        });
        x=0
        await (async function() {
            if (only) {
                z = 0;
                sBreak = false;
                for (const o of flush) {
                    if (sBreak)
                        break;
                    $(`[data-api="${z}"] [data-util="proc"]`).html('<div class="spinner-border text-primary" role="status" style="height: 14px; width: 14px"><span class="visually-hidden">Loading...</span></div>');
                    curl_data = {};
                    $(`[name="curl_data"][data-api="${z}"]`).each(function(a, b) {
                        curl_data[$(b).attr('data-key')] = $(b).val();
                    });
                    await new Promise((resolve) => {
                        $.ajax({
                            type: "POST",
                            url: `/api/execute/${o.id}/${$('#vno').val()}/${$('[name="ambiente"]:checked').attr('data-value')}`,
                            data: {
                                "_token": "{{csrf_token()}}",
                                "curl_data": curl_data,
                                "ambient": $('[name="ambiente"]:checked').attr('data-value2'),
                                "in_flow": $('#flow').val()
                            },
                            success: function(response) {
                                x++;
                                $(`[data-api="${z}"] [data-util="time"]`).html(`<div class="row"><div class="col-sm-6"><button onclick="openRep(${x})" class="text-decoration-underline text-primary fs-6 bg-transparent" style="border: none">Ver</button></div><div class="col-sm-6 text-muted">${JSON.parse(JSON.parse(response).report).time}s</div></div>`);
                                responses[x] = JSON.parse(JSON.parse(response).response).result;
                                if (JSON.parse(JSON.parse(response).report).status != "200" || responses[x]["u_return_code"] != "0") {
                                    $(`[data-api="${z}"] [data-util="proc"]`).html('<i class="bi bi-x-lg text-danger"></i>');
                                    sBreak = true;
                                } else {
                                    $(`[data-api="${z}"] [data-util="proc"]`).html('<i class="bi bi-check-lg text-primary"></i>');
                                }
                                setTimeout(resolve, o.delay)
                            }
                        });
                    });
                    z++;
                }
            } else {
                $('#exampleModalTopCover').modal('show');
                $('#logger').html('');
                for (const h of Object.keys(eles)) {
                    await new Promise(async (resolve) => {
                        nBreak = false;
                        await $.ajax({
                            type: "GET",
                            url: `/api/v2/flow/request/${flow}/${vno}`,
                            data: {
                                _token: "{{csrf_token()}}"
                            },
                            success: async function(response) {
                                $('#logger').append(`<h5>${eles[h].name}</h5>`);
                                i=0;
                                for (const api of response.apis) {
                                    if (!nBreak) {
                                        await new Promise((resolveApi) => {
                                            i++;
                                            let curl_data = {};
                                            for (const key of Object.keys(api.values[$('#vno').val()])) {
                                                curl_data[key] = $(`[data-masive-api="${i}"][data-masive-key="${key}"][data-masive-h="${h}"]`).val();
                                            }
                                            $.ajax({
                                                type: "POST",
                                                url: `/api/execute/${api.id}/${$('#vno').val()}/${$('[name="ambiente"]:checked').attr('data-value')}`,
                                                data: {
                                                    "_token": "{{csrf_token()}}",
                                                    "curl_data": curl_data,
                                                    "ambient": $('[name="ambiente"]:checked').attr('data-value2'),
                                                    "in_flow": flow
                                                },
                                                success: function(response) {
                                                    $('#logger').append(`<div class="d-flex gap-2">
                                                    <div style="border-radius: 50%; min-width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; background-color: #17181a; color: white">
                                                        ${JSON.parse(JSON.parse(response).report).status != "200" || JSON.parse(response).response["u_return_code"] != "0" ? '<i class="bi bi-x-lg text-danger"></i>' : '<i class="bi bi-check-lg text-primary"></i>'}
                                                    </div>
                                                    <div><p class="mb-1 text-muted">${api.name}</p>
                                                        <pre style="background-color: #17181a;" class="rounded p-4">${JSON.stringify(JSON.parse(JSON.parse(response).response), null, 4)}</pre>
                                                    </div>
                                                </div>`);
                                                    if (JSON.parse(JSON.parse(response).report).status != "200" || JSON.parse(response).response["u_return_code"] != "0")
                                                        nBreak = true;
                                                    setTimeout(resolveApi, api.delay);
                                                }
                                            });
                                        });
                                    }
                                }
                                resolve();
                            }
                        });
                    });
                }
            }
        })();
        $('#executeFlush').prop('disabled', false);
        $('#flow').prop("disabled", false);
        $('#vno').prop("disabled", false);
        $('.zzzzz').each((a, b) => {
            $(b).prop("disabled", false);
        });
        $('[name="ambiente"]').each((a, b) => {
            $(b).prop("disabled", false);
        });
    });
    $('#flow').change(function() {
        $('#flow').prop("disabled", true);
        $('#vno').prop("disabled", true);
        $('#executeFlush').prop('disabled', true);
        loadFlow();
    });
    $('#vno').change(function() {
        $('#flow').prop("disabled", true);
        $('#vno').prop("disabled", true);
        $('#executeFlush').prop('disabled', true);
        loadFlow();
    });
    $(document).ready(function() {
        loadFlow()
    });
</script>
@endsection
@section('modals')
<div class="modal modal-xl fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Ver</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modal-ddd">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<div id="exampleModalTopCover" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalTopCoverTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <!-- Header -->
            <div class="modal-top-cover bg-dark text-center">
                <figure class="position-absolute end-0 bottom-0 start-0">
                    <svg preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 1920 100.1">
                        <path fill="#fff" d="M0,0c0,0,934.4,93.4,1920,0v100.1H0L0,0z" />
                    </svg>
                </figure>

                <div class="modal-close">
                    <button type="button" class="btn-close btn-close-light" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <!-- End Header -->

            <div class="modal-top-cover-icon">
                <span class="icon icon-lg icon-light icon-circle icon-centered shadow-sm">
                    <i class="bi-receipt fs-2"></i>
                </span>
            </div>

            <div class="modal-body" style="height: 60vh; overflow-y: scroll" id="logger">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
@endsection