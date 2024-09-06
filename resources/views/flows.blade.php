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
        <a class="nav-link" href="javascript:void(0)">Masiva</a>
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
            <select class="form-select mb-2" id="flow" disabled>
                @foreach($flows as $flow)
                <option value="{{$flow->id}}">{{$flow->name}}</option>
                @endforeach
            </select>
            <a href="javascript:downloadFlow()" class="text-link" target="_blank">Descargar Flujo</a>
        </div>
        <div class="card p-4">
            <div id="inputs">
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div id="apis" class="d-grid gap-3 mb-2">
            <!-- <div class="row">
                        <div class="col-4 d-flex align-items-center">Factibilidad</div>
                        <div class="col-4 text-center d-flex align-items-center justify-content-center gap-2">
                            <a href="asd" class="text-decoration-underline text-primary fs-6">Ver</a>
                        </div>
                        <div class="col-4 d-flex align-items-center justify-content-end text-primary gap-1">
                            <i class="bi bi-check-lg"></i>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4 d-flex align-items-center">Factibilidad</div>
                        <div class="col-4 text-center d-flex align-items-center justify-content-center">-</div>
                        <div class="col-4 d-flex align-items-center justify-content-end text-primary">
                            <div class="spinner-border text-primary" role="status" style="height: 14px; width: 14px">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4 d-flex align-items-center">Factibilidad</div>
                        <div class="col-4 text-center d-flex align-items-center justify-content-center">-</div>
                        <div class="col-4 d-flex align-items-center justify-content-end text-danger">
                            <i class="bi bi-x-lg"></i>
                        </div>
                    </div> -->
        </div>
        <button class="btn btn-primary w-100 mt-2 mb-4" id="executeFlush" disabled>Ejecutar Flujo</button>
        <div class="card p-5" style="overflow-x: scroll;">
            <table class="table overflow-x-scroll">
                <thead>
                    <tr>
                        <th scope="col"><i class="bi bi-clock-history" style="margin-right: .5rem;"></i></th>
                        <th scope="col">Ambiente</th>
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
<script>
    var flush;
    var responses = {};
    var n = 0;

    function downloadFlow() {
        alert("a")
    }

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

    function loadFlow() {
        $.ajax({
            type: "GET",
            url: "/api/v2/flow/request/" + $('#flow').val() + "/" + $('#vno').val(),
            data: {
                _token: "{{csrf_token()}}"
            },
            success: function(response) {
                $('#flow').prop("disabled", false);
                $('#vno').prop("disabled", false);
                $('#inputs').html('');
                $('#apis').html('');
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
                        $('#inputs').append(`<label for="ipt_${key}" class="form-label">${key}</label><input type="text" id="ipt_${key}" name="curl_data" class="form-control mb-2 zzzzz" value="${value}" data-key="${key}" data-api="${i}">`);
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
        await (async function() {
            i = 0;
            sBreak = false;
            for (const o of flush) {
                if (sBreak)
                    break;
                $(`[data-api="${i}"] [data-util="proc"]`).html('<div class="spinner-border text-primary" role="status" style="height: 14px; width: 14px"><span class="visually-hidden">Loading...</span></div>');
                curl_data = {};
                $(`[name="curl_data"][data-api="${i}"]`).each(function(a, b) {
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
                            "in_flow": true
                        },
                        success: function(response) {
                            n++;
                            $(`[data-api="${i}"] [data-util="time"]`).html(`<div class="row"><div class="col-sm-6"><button onclick="openRep(${n})" class="text-decoration-underline text-primary fs-6 bg-transparent" style="border: none">Ver</button></div><div class="col-sm-6 text-muted">${JSON.parse(JSON.parse(response).report).time}s</div></div>`);
                            responses[n] = JSON.parse(JSON.parse(response).response).result;
                            if (JSON.parse(JSON.parse(response).report).status != "200" || responses[n]["u_return_code"] != "0") {
                                $(`[data-api="${i}"] [data-util="proc"]`).html('<i class="bi bi-x-lg text-danger"></i>');
                                sBreak = true;
                            } else {
                                $(`[data-api="${i}"] [data-util="proc"]`).html('<i class="bi bi-check-lg text-primary"></i>');
                            }
                            setTimeout(resolve, o.delay)
                        }
                    });
                });
                i++;
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
@endsection