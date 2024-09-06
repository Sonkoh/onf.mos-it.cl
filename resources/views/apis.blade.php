@extends('base')
<?php
$permissions = json_decode(auth()->user()->permissions, true);
?>
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
<style>
    .hs-nav-scroller-horizontal .nav .nav-link:not(.active) {
        background-color: transparent;
    }
</style>
<div style="text-align: right;">
    <ul class="nav nav-segment nav-pills mb-7" role="tablist">
        @php
        $hasActive = false;
        @endphp
        @foreach ($vnos as $vno)
        @if (array_key_exists($vno->id, json_decode($api->values, true)) && in_array("API_" . $api->id .".". $vno->id,
        $permissions))
        <li class="nav-item">
            <a class="nav-link<?= $hasActive ? "" : " active" ?>" id="nav-VNO_{{ $vno->id }}s7d-tab" href="#nav-VNO_{{
                $vno->id }}s7d" data-bs-toggle="pill" data-bs-target="#nav-VNO_{{ $vno->id }}s7d" role="tab" aria-controls="nav-VNO_{{ $vno->id }}s7d" aria-selected="true">{{ $vno->name }}</a>
        </li>
        @php
        $hasActive = true;
        @endphp
        @endif
        @endforeach
    </ul>
</div>
<style>
    td,
    th {
        text-align: center;
    }
</style>
<div class="tab-content">
    @php
    $hasActive = false;
    @endphp
    @foreach ($vnos as $vno)
    @if (array_key_exists($vno->id, json_decode($api->values, true)) && in_array("API_" . $api->id .".". $vno->id,
    $permissions))
    <div class="tab-pane fade<?= $hasActive ? "" : " show active" ?>" id="nav-VNO_{{ $vno->id }}s7d" role="tabpanel" aria-labelledby="nav-VNO_{{ $vno->id }}s7d-tab">
        <div class="card">
            <div class="card-header card-header-content-md-between">
                <h3 class="card-header-title">{{ $title }} <span class="badge bg-soft-primary rounded-pill">{{
                        $vno->name }}</span></h3>
                <div>
                    <button type="button" data-bs-toggle="modal" data-bs-target="#open_{{ $vno->id }}Modal" style="width: 42.59px; height: 42.59px; padding: 0; display: flex; align-items: center; justify-content: center;" class="btn btn-success rounded-pill"><i class="bi bi-play-fill"></i></button>
                </div>
            </div>
            <div class="card-body">
                <table class="table" id="id_{{ $vno->id }}Table">
                    <thead>
                        <tr>
                            @if($api->id == 5 || $api->id == 4)
                            <th scope="col">AccessId</th>
                            @endif
                            <th scope="col"><i class="bi bi-clock-history" style="margin-right: .5rem;"></i></th>
                            <th scope="col">Ambiente</th>
                            <th scope="col">Ejecutado por</th>
                            <th scope="col">Código de respuesta</th>
                            <th scope="col" style="text-transform: initial;">TIEMPO DE RESPUESTA (Seg)</th>
                            <th scope="col">Fecha</th>
                            <th><i class="bi bi-eye"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $i = 0;
                        @endphp
                        @foreach($reports as $report)
                        @if($report->vno != $vno->id) @continue @endif
                        @if($i >= 30) @break @endif
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
                            @if($api->id == 5)
                            <td>{{ json_decode($report->request)->u_access_id_vno ?? "NULO" }}</td>
                            @elseif($api->id == 4)
                            <td>{{ json_decode($report->request)->access_id ?? "NULO" }}</td>
                            @endif
                            <th scope="row">{{ $timeAgo }}</th>
                            <td><span class="badge bg-soft-danger rounded-pill">{{ strtoupper($report->ambient) }}</span></td>
                            <td>{!! isset($report->email) ? $report->email : '<span class="badge bg-soft-danger rounded-pill">USUARIO NO ENCONTRADO</span>' !!}</td>
                            <td>{{ $report->status }}</td>
                            <td>{{ $report->time }}</td>
                            <td>{{ $formattedDate . ' a las ' . $formattedTime }}</td>
                            <td>
                                @if($report->request == '')
                                <button class="btn btn-danger rounded-pill"><i class="bi bi-eye-slash"></i></button>
                                @else
                                <button class="btn btn-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#previewModal" onclick="openReportDetails({{ $report }})"><i class="bi bi-eye"></i></button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @php
    $hasActive = true;
    @endphp
    @endif
    @endforeach
</div>
@endsection
@section('modals')
<div id="previewModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom-width: 0.0625rem; padding: 1.5rem 2rem">
                <h5 class="modal-title" id="previewModalTitle">Petición #</h5>
                <div style="display: flex; gap: .5rem">
                    <div class="dropdown dropup">
                        <button type="button" class="btn btn-ghost-secondary" data-bs-dismiss="modal" aria-label="Close">Cerrar</button>
                    </div>
                    <button id="cloneRequestButton" onclick="cloneRequest($('#previewModal').attr('log'))" style="width: 42.59px; height: 42.59px; padding: 0; display: flex; align-items: center; justify-content: center;" class="btn btn-info rounded-pill text-white"><i class="bi bi-layers-fill"></i></button>
                </div>
            </div>
            <div class="modal-body">
                <div class="js-nav-scroller hs-nav-scroller-horizontal">
                    <span class="hs-nav-scroller-arrow-prev" style="display: none;">
                        <a class="hs-nav-scroller-arrow-link" href="javascript:;">
                            <i class="bi-chevron-left"></i>
                        </a>
                    </span>
                    <span class="hs-nav-scroller-arrow-next" style="display: none;">
                        <a class="hs-nav-scroller-arrow-link" href="javascript:;">
                            <i class="bi-chevron-right"></i>
                        </a>
                    </span>
                    <ul class="js-tabs-to-dropdown nav nav-segment nav-fill mb-5" id="editUserModalTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button style="border:none;" class="nav-link active" href="#previewModalTabContentData" id="previewModalTabData" data-bs-toggle="tab" data-bs-target="#previewModalTabContentData" role="tab" aria-selected="true">
                                <i class="bi-bookmark me-1"></i> Informe
                            </button>
                        <li class="nav-item" role="presentation">
                            <button style="border:none;" class="nav-link" href="#previewModalTabContentRequest" id="previewModalTabRequest" data-bs-toggle="tab" data-bs-target="#previewModalTabContentRequest" role="tab" aria-selected="false">
                                <i class="bi-person me-1"></i> Petición
                            </button>
                        <li class="nav-item" role="presentation">
                            <button style="border:none;" class="nav-link" href="#previewModalTabContentResponse" id="previewModalTabResponse" data-bs-toggle="tab" data-bs-target="#previewModalTabContentResponse" role="tab" aria-selected="false">
                                <i class="bi-shield-lock me-1"></i> Respuesta
                            </button>
                        </li>
                        <li id="comparator" class="nav-item" role="presentation" style="display: none">
                            <button style="border:none;" class="nav-link" href="#previewModalTabContentComparator" id="previewModalTabComparator" data-bs-toggle="tab" data-bs-target="#previewModalTabContentComparator" role="tab" aria-selected="false">
                                <i class="bi bi-layers-fill"></i> Comparador
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="previewModalTabContentData" role="tabpanel" aria-labelledby="previewModalTabData">
                        <div class="row" style="margin: 1rem 0;">
                            <label class="col-sm-4 col-form-label">Petición número</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="" readonly id="previewModalDataPetId">
                            </div>
                        </div>
                        <div class="row" style="margin: 1rem 0;">
                            <label class="col-sm-4 col-form-label">API</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" readonly id="previewModalDataApi">
                            </div>
                        </div>
                        <div class="row" style="margin: 1rem 0;">
                            <label class="col-sm-4 col-form-label">VNO</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" readonly id="previewModalDataVno">
                            </div>
                        </div>
                        <div class="row" style="margin: 1rem 0;">
                            <label class="col-sm-4 col-form-label">Entorno</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" readonly id="previewModalDataEnv">
                            </div>
                        </div>
                        <div class="row" style="margin: 1rem 0;">
                            <label class="col-sm-4 col-form-label">USUARIO</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="previewModalDataUsr" readonly>
                            </div>
                        </div>
                        <!-- <span class="divider-center mb-4">cURL</span>
                        <div class="code-toolbar bg-dark p-3" style="border-radius: .5rem;">
                            <pre class=" language-markup"><code class=" language-markup" data-lang="bash" id="previewModalDataCurl">curl</code></pre>
                        </div> -->
                        <span class="divider-center mb-4">JSON</span>
                        <div class="code-toolbar bg-dark p-3" style="border-radius: .5rem;">
                            <pre class=" language-markup"><code class=" language-markup" data-lang="bash" id="previewModalDataJSON">json</code></pre>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="previewModalTabContentRequest" role="tabpanel" aria-labelledby="previewModalTabRequest">
                        <div class="row" style="margin: 1rem 0;">
                            <label class="col-sm-4 col-form-label">KEY</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="VALOR CAMBIAR" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="previewModalTabContentResponse" role="tabpanel" aria-labelledby="previewModalTabResponse">
                        <div class="row" style="margin: 1rem 0;">
                            <label class="col-sm-4 col-form-label">KEY</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="VALOR CAMBIAR" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="previewModalTabContentComparator" role="tabpanel" aria-labelledby="previewModalTabComparator">
                        <div class="row" style="margin: 1rem 0;">
                            <label class="col-sm-4 col-form-label">KEY</label>
                            <div class="col-sm-8">
                                <div class="row">
                                    <div class="col">
                                        <input type="text" class="form-control" value="VALOR CAMBIAR" readonly>
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" value="VALOR CAMBIAR" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@foreach ($vnos as $vno)
@if (array_key_exists($vno->id, json_decode($api->values, true)) && in_array("API_" . $api->id .".". $vno->id,
$permissions))
<div id="open_{{ $vno->id }}Modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom-width: 0.0625rem; padding: 1.5rem 2rem">
                <h5 class="modal-title" id="id_{{ $vno->id }}ModalTitle">{{ $title }} <span class="badge bg-soft-primary rounded-pill">{{ $vno->name }}</span></h5>
                <div style="display: flex; gap: .5rem">
                    <div class="dropdown dropup">
                        <button type="button" class="btn btn-ghost-secondary" data-bs-dismiss="modal" aria-label="Close">Cerrar</button>
                        <button type="button" class="btn btn-ghost-secondary" id="env_{{ $vno->id }}SelectEnviorment" data-bs-toggle="dropdown" aria-expanded="true" data-bs-dropdown-animation="">{{
                            json_decode($api->methods, true)[0]["label"] }}</button>
                        <div class="dropdown-menu navbar-dropdown-menu-borderless" aria-labelledby="env_{{ $vno->id }}SelectEnviorment" data-bs-popper="static" style="opacity: 1; transform: translateY(10px) translateY(-10px); transition: transform 300ms ease 0s, opacity 300ms ease 0s;">
                            <span class="dropdown-header">Entorno</span>
                            @foreach (json_decode($api->methods, true) as $envrioment)
                            <button class="dropdown-item" onclick="setEnvrioment('env_<?= $vno->id ?>SelectEnviorment', '<?= $envrioment['name'] ?>')">
                                <span class="text-truncate">{{ $envrioment["label"] }}</span>
                            </button>
                            @endforeach
                        </div>
                    </div>
                    <button id="id_{{ $vno->id }}ExecuteAPIButton" onclick="executeAPI_<?= $vno->id ?>()" style="width: 42.59px; height: 42.59px; padding: 0; display: flex; align-items: center; justify-content: center;" class="btn btn-success rounded-pill"><i class="bi bi-play-fill"></i></button>
                </div>
            </div>
            <div class="modal-body">
                <div class="js-nav-scroller hs-nav-scroller-horizontal">
                    <span class="hs-nav-scroller-arrow-prev" style="display: none;">
                        <a class="hs-nav-scroller-arrow-link" href="javascript:;">
                            <i class="bi-chevron-left"></i>
                        </a>
                    </span>
                    <span class="hs-nav-scroller-arrow-next" style="display: none;">
                        <a class="hs-nav-scroller-arrow-link" href="javascript:;">
                            <i class="bi-chevron-right"></i>
                        </a>
                    </span>
                    <ul class="js-tabs-to-dropdown nav nav-segment nav-fill mb-5" id="editUserModalTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button style="border:none;" class="nav-link active" href="#id_{{ $vno->id }}TabContentBasic" id="tab_{{ $vno->id }}TabBasic" data-bs-toggle="tab" data-bs-target="#id_{{ $vno->id }}TabContentBasic" role="tab" aria-selected="true">
                                <i class="bi-person me-1"></i> Básico
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button style="border:none;" class="nav-link" href="#id_{{ $vno->id }}TabContentAdvanced" id="id_{{ $vno->id }}TabAdvanced" data-bs-toggle="tab" data-bs-target="#id_{{ $vno->id }}TabContentAdvanced" role="tab" aria-selected="false" tabindex="-1">
                                <i class="bi-shield-lock me-1"></i> Avanzado
                            </button>
                        </li>
                        <li class="nav-item" role="presentation" style="display: none;"><button style="border:none;" class="nav-link" href="#id_{{ $vno->id }}TabContentResponse" id="tab_{{ $vno->id }}TabResponse" data-bs-toggle="tab" data-bs-target="#id_{{ $vno->id }}TabContentResponse" role="tab" aria-selected="false" tabindex="-1"><i class="bi-shield-lock me-1"></i> Respuesta</button></li>
                    </ul>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="id_{{ $vno->id }}TabContentBasic" role="tabpanel" aria-labelledby="tab_{{ $vno->id }}TabBasic">
                        <form id="id_{{ $vno->id }}FormBasic">
                            @if (isset(json_decode($api->values, true)[$vno->id]))
                            @foreach(json_decode($api->values, true)[$vno->id] as $key => $value)
                            <div class="row" style="margin: 1rem 0;">
                                <label class="col-sm-4 col-form-label">{{ $key }}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" value="{{ $value }}" id="ipt_{{ $vno->id }}-{{ $key }}">
                                </div>
                            </div>
                            @endforeach
                            @endif
                            @if (isset(json_decode($api->link_values, true)[$vno->id]))
                            @foreach(json_decode($api->link_values, true)[$vno->id] as $key => $value)
                            <div class="row" style="margin: 1rem 0;">
                                <label class="col-sm-4 col-form-label">{{ $key }}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" value="{{ $value }}" id="ipt_{{ $vno->id }}-{{ $key }}">
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </form>
                    </div>

                    <div class="tab-pane fade" id="id_{{ $vno->id }}TabContentAdvanced" role="tabpanel" aria-labelledby="{{ $vno->id }}TabAdvanced">
                        <form>
                            @php
                            $ta = json_decode($api->values, true)[$vno->id] ?? [];
                            if (isset(json_decode($api->link_values, true)[$vno->id])) {
                            foreach(json_decode($api->link_values, true)[$vno->id] as $key => $value) {
                            $ta[$key] = $value;
                            }
                            }
                            @endphp
                            @if (isset(json_decode($api->values, true)[$vno->id]))
                            <textarea class="form-control" cols="30" rows="20" id="id_{{ $vno->id }}Data-customCURL"><?= json_encode($ta, JSON_PRETTY_PRINT); ?></textarea>
                            @else
                            <textarea class="form-control" cols="30" rows="20" id="id_{{ $vno->id }}Data-customCURL">{}</textarea>
                            @endif
                        </form>
                    </div>

                    <div class="tab-pane fade" id="id_{{ $vno->id }}TabContentResponse" role="tabpanel" aria-labelledby="tab_{{ $vno->id }}TabResponse">

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endif
@endforeach
@endsection
@section('scripts')
<script>
    const enviroments = {};
    const enviromentsInvertedKey = {};
    cloneRequestPool = false;
    JSON.parse(@json($api["methods"])).forEach(e => {
        enviroments[e.label] = e.name;
        enviromentsInvertedKey[e.name] = e.label;
    });

    function setEnvrioment(element, envrioment) {
        $(`#${element}`).html(enviromentsInvertedKey[envrioment]);
        if (envrioment == "production") {
            if (!$(`#${element}`).hasClass('bg-danger')) {
                $(`#${element}`).addClass('bg-danger');
                $(`#${element}`).addClass('text-white');
            }
        } else {
            if ($(`#${element}`).hasClass('bg-danger')) {
                $(`#${element}`).removeClass('text-white');
                $(`#${element}`).removeClass('bg-danger');
            }
        }
    }

    function cloneRequest(requestId) {
        cloneRequestPool = true;
        $('#cloneRequestButton').attr('disabled', true);
        $('#cloneRequestButton').html('<div class="spinner-grow text-white" role="status"><span class="visually-hidden">Clonando...</span></div>');
        $.ajax({
            type: "POST",
            url: `/api/clone/${requestId}`,
            data: {
                "_token": "{{ csrf_token() }}"
            },
            success: function(response) {
                if (cloneRequest) {
                    $('#cloneRequestButton').attr('disabled', false);
                    $('#cloneRequestButton').html('<i class="bi bi-layers-fill"></i>');
                    $('#comparator').css('display', 'block');
                    $('#previewModalTabData').removeClass('active');
                    $('#previewModalTabRequest').removeClass('active');
                    $('#previewModalTabResponse').removeClass('active');
                    $('#previewModalTabComparator').addClass('active');
                    // 
                    $('#previewModalTabContentData').removeClass('active');
                    $('#previewModalTabContentRequest').removeClass('active');
                    $('#previewModalTabContentResponse').removeClass('active');
                    $('#previewModalTabContentComparator').addClass('active');
                    // 
                    $('#previewModalTabContentData').removeClass('show');
                    $('#previewModalTabContentRequest').removeClass('show');
                    $('#previewModalTabContentResponse').removeClass('show');
                    $('#previewModalTabContentComparator').addClass('show');
                    // 
                    $('#previewModalTabContentComparator').html('');
                    $('#previewModalTabContentComparator').append(`<div class="row" style="margin: 1rem 0;">
                            <label class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-8">
                                <div class="row">
                                    <div class="col text-center">Reporte #${requestId}</div>
                                    <div class="col text-center">Ahora</div>
                                </div>
                            </div>
                        </div>`);
                    drawResponse2(JSON.parse(response.report.response), JSON.parse(response.response), '#previewModalTabContentComparator');
                }
            }
        });
    }

    function openReportDetails(report) {
        cloneRequestPool = false;
        $('#previewModalTabComparator').removeClass('active');
        $('#previewModalTabData').addClass('active');
        $('#previewModalTabRequest').removeClass('active');
        $('#previewModalTabResponse').removeClass('active');
        $('#previewModalTabContentData').addClass('show');
        // 
        $('#previewModalTabContentComparator').removeClass('active');
        $('#previewModalTabContentData').addClass('active');
        $('#previewModalTabContentRequest').removeClass('active');
        $('#previewModalTabContentResponse').removeClass('active');
        $('#cloneRequestButton').attr('disabled', false);
        $('#cloneRequestButton').html('<i class="bi bi-layers-fill"></i>');
        $('#comparator').css('display', 'none');
        $('#previewModalTitle').html(`Petición #${report.id}`);
        $('#previewModalDataPetId').val(report.id);
        $('#previewModalDataApi').val('{{ $title }}');
        $('#previewModalDataVno').val(@json($vnos).find(item => item.id === report.vno).name);
        $('#previewModalDataEnv').val(report.ambient);
        $('#previewModalDataUsr').val(report.email);
        $('#previewModal').attr('log', report.id)
        // $('#previewModalDataCurl').html(report.curl.replaceAll('-H', '\\\n-H').replaceAll('-d', '\\\n-d').replaceAll('https', '\\\nhttps'));
        $('#previewModalDataJSON').html(JSON.stringify(JSON.parse(report.response), null, 2));
        $('#previewModalTabContentRequest').html('');
        for (const Key in JSON.parse(report.request)) {
            if (JSON.parse(report.request).hasOwnProperty(Key)) {
                const value = JSON.parse(report.request)[Key];
                $('#previewModalTabContentRequest').append(`<div class="row" style="margin: 1rem 0;">
                            <label class="col-sm-4 col-form-label">${Key}</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="${value}" readonly>
                            </div>
                        </div>`)
            }
        }
        $('#previewModalTabContentResponse').html('');
        drawResponse(JSON.parse(report.response), '#previewModalTabContentResponse');
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

    function filterEquals(oldResult, newResult) {
        oldResult = String(oldResult);
        newResult = String(newResult);
        if (oldResult.endsWith(' dBm') && newResult.endsWith(' dBm')) {
            oldResult = oldResult.substr(0, oldResult.length - 5);
            newResult = newResult.substr(0, newResult.length - 5);
            return Math.abs(oldResult - newResult) <= 1
        }
        return oldResult == newResult;
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
</script>
@foreach ($vnos as $vno)
@if (array_key_exists($vno->id, json_decode($api->values, true)) && in_array("API_" . $api->id .".". $vno->id,
$permissions))
@php
$ta = json_decode($api->values, true)[$vno->id] ?? [];
if (isset(json_decode($api->link_values, true)[$vno->id])) {
foreach(json_decode($api->link_values, true)[$vno->id] as $key => $value) {
$ta[$key] = $value;
}
}
@endphp
<script>
    function executeAPI_<?= $vno->id ?>() {
        $('#id_{{ $vno->id }}ExecuteAPIButton').prop('disabled', true);
        $('#id_{{ $vno->id }}ExecuteAPIButton').html('<div class="spinner-grow text-light" role="status"><span class="visually-hidden">Cargando...</span></div>');
        curl_data = {};
        if ($('#tab_{{ $vno->id }}TabBasic').hasClass('active')) {
            if ('<?= isset(json_decode($api->values, true)[$vno->id]) ?>' == 1) {
                for (const [key, value] of Object.entries(JSON.parse(@json(json_encode($ta))))) {
                    curl_data[key] = $(`#ipt_{{ $vno->id }}-${key}`).val();
                }
            }
        } else curl_data = JSON.parse($('#id_{{ $vno->id }}Data-customCURL').val());
        // console.log(curl_data)
        $.ajax({
            type: "POST",
            url: `/api/execute/{{ $api->id }}/{{ $vno->id }}/${enviroments[$('#env_<?= $vno->id ?>SelectEnviorment').html()]}`,
            data: {
                "_token": "{{ csrf_token() }}",
                "curl_data": curl_data,
                "ambient": $('#env_{{ $vno->id }}SelectEnviorment').html()
            },
            success: function(response) {
                response = JSON.parse(response);
                if ('{{ $api->id }}' == '5') {
                    response.response = JSON.stringify({
                        "result": JSON.parse(response.response)
                    });
                }
                if (response.success) {
                    $('#id_{{ $vno->id }}ExecuteAPIButton').prop('disabled', false);
                    $('#id_{{ $vno->id }}ExecuteAPIButton').html('<i class="bi bi-play-fill"></i>');
                    $('.nav-item:has( #tab_{{ $vno->id }}TabResponse)').show();
                    $('#tab_{{ $vno->id }}TabResponse').click();
                    $('#id_{{ $vno->id }}TabContentResponse').html('');
                    accessId = '';
                    if ('{{ $api->id }}' == '5') accessId = `<th scope="row">${JSON.parse(response.response)["result"]["result"]["u_access_id_vno"] ?? "NULO"}</th>`;
                    if ('{{ $api->id }}' == '4') accessId = `<th scope="row">${JSON.parse(response.response)["result"]["u_access_id_vno"] ?? "NULO"}</th>`;
                    $('#id_{{ $vno->id }}Table tbody').html(`
                            <tr>
                                ${accessId}
                                <th scope="row">justo ahora</th>
                                <td><span class="badge bg-soft-danger rounded-pill">${JSON.parse(response.report).ambient.toUpperCase()}</span></td>
                                <td>{{ auth()->user()->email }}</td>
                                <td>${JSON.parse(response.report).status}</td>
                                <td>${JSON.parse(response.report).time}</td>
                                <td>${new Date().getDate().toString().padStart(2, '0')}/${(new Date().getMonth() + 1).toString().padStart(2, '0')}/${new Date().getFullYear().toString().padStart(2, '0')} a las ${new Date().getHours().toString().padStart(2, '0')}:${new Date().getMinutes().toString().padStart(2, '0')}</td>
                                <td>
                                    <button class="btn btn-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#previewModal" onclick='openReportDetails(${response.report})'><i class="bi bi-eye"></i></button>
                                </td>
                            </tr>
                            ${$('#id_{{ $vno->id }}Table tbody').html()}`);
                            console.log(JSON.parse(JSON.stringify(response.response)))
                    drawResponse(JSON.parse(response.response).result, '#id_{{ $vno->id }}TabContentResponse');
                } else {
                    $('#id_{{ $vno->id }}ExecuteAPIButton').prop('disabled', false);
                    $('#id_{{ $vno->id }}ExecuteAPIButton').html('<i class="bi bi-play-fill"></i>');
                    Swal.fire({
                        icon: 'error',
                        title: '¡Ha ocurrido un error!',
                        text: response.response
                    });
                }
            }
        });
    }
</script>
@endif
@endforeach
@endsection