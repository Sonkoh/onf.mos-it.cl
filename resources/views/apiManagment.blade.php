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
<div class="card">
    <div class="card-header card-header-content-md-between">
        <div class="mb-2 mb-md-0">
            <form>
                <div class="input-group input-group-merge input-group-flush">
                    <div class="input-group-prepend input-group-text">
                        <i class="bi-search"></i>
                    </div>
                    <input id="datatableSearch" type="search" class="form-control" placeholder="Buscar APIs" aria-label="Buscar APIs">
                </div>
            </form>
        </div>
        <div class="d-grid d-sm-flex justify-content-md-end align-items-sm-center gap-2">
            <div id="datatableCounterInfo" style="display: none;">
                <div class="d-flex align-items-center">
                    <span class="fs-5 me-3">
                        <span id="datatableCounter">0</span>
                        API/s Seleccionada/s
                    </span>
                    <a class="btn btn-outline-danger btn-sm" href="javascript:;">
                        <i class="bi-trash"></i> Eliminar
                    </a>
                </div>
            </div>
            <div class="dropdown">
                <button type="button" class="btn btn-white btn-sm dropdown-toggle w-100" id="usersExportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi-download me-2"></i> Exportar
                </button>

                <div class="dropdown-menu dropdown-menu-sm-end" aria-labelledby="usersExportDropdown">
                    <span class="dropdown-header">Opciones</span>
                    <a id="export-copy" class="dropdown-item" href="javascript:;">
                        <img class="avatar avatar-xss avatar-4x3 me-2" src="/template/assets/svg/illustrations/copy-icon.svg">
                        Copy
                    </a>
                    <a id="export-print" class="dropdown-item" href="javascript:;">
                        <img class="avatar avatar-xss avatar-4x3 me-2" src="/template/assets/svg/illustrations/print-icon.svg">
                        Imprimir
                    </a>
                    <div class="dropdown-divider"></div>
                    <span class="dropdown-header">Opciones de Descarga</span>
                    <a id="export-excel" class="dropdown-item" href="javascript:;">
                        <img class="avatar avatar-xss avatar-4x3 me-2" src="/template/assets/svg/brands/excel-icon.svg">
                        Excel
                    </a>
                    <a id="export-csv" class="dropdown-item" href="javascript:;">
                        <img class="avatar avatar-xss avatar-4x3 me-2" src="/template/assets/svg/components/placeholder-csv-format.svg">
                        .CSV
                    </a>
                    <a id="export-pdf" class="dropdown-item" href="javascript:;">
                        <img class="avatar avatar-xss avatar-4x3 me-2" src="/template/assets/svg/brands/pdf-icon.svg">
                        PDF
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="table-responsive datatable-custom">
        <div id="datatable_wrapper" class="dataTables_wrapper no-footer">
            <div class="dt-buttons"> <button class="dt-button buttons-copy buttons-html5 d-none" tabindex="0" aria-controls="datatable" type="button"><span>Copiar</span></button> <button class="dt-button buttons-excel buttons-html5 d-none" tabindex="0" aria-controls="datatable" type="button"><span>Excel</span></button> <button class="dt-button buttons-csv buttons-html5 d-none" tabindex="0" aria-controls="datatable" type="button"><span>CSV</span></button> <button class="dt-button buttons-pdf buttons-html5 d-none" tabindex="0" aria-controls="datatable" type="button"><span>PDF</span></button> <button class="dt-button buttons-print d-none" tabindex="0" aria-controls="datatable" type="button"><span>Imprimir</span></button> </div>
            <div id="datatable_filter" class="dataTables_filter"><label>Buscar:<input type="search" class="" placeholder="" aria-controls="datatable"></label></div>
            <table id="datatable" class="table table-lg table-borderless table-thead-bordered table-nowrap table-align-middle card-table dataTable no-footer" data-hs-datatables-options="{
                   &quot;columnDefs&quot;: [{
                      &quot;targets&quot;: [0, 2, 3, 6, 7],
                      &quot;orderable&quot;: false
                    }],
                   &quot;order&quot;: [],
                   &quot;info&quot;: {
                     &quot;totalQty&quot;: &quot;#datatableWithPaginationInfoTotalQty&quot;
                   },
                   &quot;search&quot;: &quot;#datatableSearch&quot;,
                   &quot;entries&quot;: &quot;#datatableEntries&quot;,
                   &quot;pageLength&quot;: 15,
                   &quot;isResponsive&quot;: false,
                   &quot;isShowPaging&quot;: false,
                   &quot;pagination&quot;: &quot;datatablePagination&quot;
                 }" role="grid" aria-describedby="datatable_info">
                <thead class="thead-light">
                    <tr role="row">
                        <th class="table-column-pe-0 sorting_disabled" rowspan="1" colspan="1" style="width: 40.4688px;">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="datatableCheckAll">
                                <label class="form-check-label" for="datatableCheckAll"></label>
                            </div>
                        </th>
                        <th class="table-column-ps-0 sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Project: activate to sort column ascending" style="width: 234.234px;">API</th>
                        <th class="sorting" rowspan="1" colspan="1" aria-label="Tasks" style="width: 90.094px;">Peticiones (24h)</th>
                        <th class="sorting" rowspan="1" colspan="1" aria-label="Members" style="width: 129.188px;">Peticiones Totales</th>
                        <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" style="width: 136.938px;">Fecha de Lanzamiento</th>
                        <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Completion: activate to sort column ascending" style="width: 180.484px;">URL</th>
                        <th class="sorting" rowspan="1" colspan="1" style="width: 60.734px;">Metodos</th>
                        <th class="sorting" rowspan="1" colspan="1" style="width: 64.234px;">Campos</th>
                        <th class="sorting_disabled" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" style="width: 120.625px;"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($apis as $api)
                    <tr role="row">
                        <td class="table-column-pe-0">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="usersDataCheck1">
                                <label class="form-check-label" for="usersDataCheck1"></label>
                            </div>
                        </td>
                        <td class="table-column-ps-0">
                            <a class="d-flex align-items-center" href="/apis/{{ $api->identifier }}">
                                <img class="avatar avatar-xs" src="/template/assets/svg/illustrations/oc-{{ $api->icon }}.svg" data-hs-theme-appearance="default">
                                <img class="avatar avatar-xs" src="/template/assets/svg/illustrations-light/oc-{{ $api->icon }}.svg" data-hs-theme-appearance="dark">
                                <div class="ms-3">
                                    <span class="d-block h5 text-inherit mb-0">{{ $api->name }}</span>
                                    <span class="d-block fs-6 text-body">/apis/{{ $api->identifier }}</span>
                                </div>
                            </a>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">{{ count($reports24[$api->id]) }}</div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">{{ count($reports[$api->id]) }}</div>
                        </td>
                        <td>
                            <span class="legend-indicator"></span>In progress
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <span class="fs-6 me-2">35%</span>
                                <div class="progress table-progress">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 35%" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <a class="text-body" href="./project-files.html">
                                <i class="bi-paperclip"></i> 10
                            </a>
                        </td>
                        <td>
                            <a class="text-body" href="./project-activity.html">
                                <i class="bi-chat-left-dots"></i> 2
                            </a>
                        </td>
                        <td>05 May</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="dataTables_info" id="datatable_info" role="status" aria-live="polite">Showing 1 to 15 of 24 entries</div>
        </div>
    </div>
    <div class="card-footer">
        <div class="row justify-content-center justify-content-sm-between align-items-sm-center">
            <div class="col-sm mb-2 mb-sm-0">
                <div class="d-flex justify-content-center justify-content-sm-start align-items-center">
                    <span class="me-2">Mostrando:</span>
                    <div class="tom-select-custom">
                        <select id="datatableEntries" class="js-select form-select form-select-borderless w-auto tomselected ts-hidden-accessible" autocomplete="off" data-hs-tom-select-options="{
                            &quot;searchInDropdown&quot;: false,
                            &quot;hideSearch&quot;: true
                          }" tabindex="-1">
                            <option value="10">10</option>

                            <option value="20">20</option>
                            <option value="15" selected="">15</option>
                        </select>
                        <div class="ts-wrapper js-select form-select form-select-borderless w-auto single plugin-change_listener plugin-hs_smart_position input-hidden full has-items">
                            <div class="ts-control">
                                <div data-value="15" class="item" data-ts-item="">15</div>
                            </div>
                            <div class="tom-select-custom">
                                <div class="ts-dropdown single plugin-change_listener plugin-hs_smart_position" style="display: none;">
                                    <div role="listbox" tabindex="-1" class="ts-dropdown-content" id="datatableEntries-ts-dropdown"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <span class="text-secondary me-2">de</span>
                    <span id="datatableWithPaginationInfoTotalQty">24</span>
                </div>
            </div>
            <div class="col-sm-auto">
                <div class="d-flex justify-content-center justify-content-sm-end">
                    <nav id="datatablePagination" aria-label="Activity pagination">
                        <div class="dataTables_paginate paging_simple_numbers" id="datatable_paginate">
                            <ul id="datatable_pagination" class="pagination datatable-custom-pagination">
                                <li class="paginate_item page-item disabled"><a class="paginate_button previous page-link" aria-controls="datatable" data-dt-idx="0" tabindex="0" id="datatable_previous"><span aria-hidden="true">Anterior</span></a></li>
                                <li class="paginate_item page-item active"><a class="paginate_button page-link" aria-controls="datatable" data-dt-idx="1" tabindex="0">1</a></li>
                                <li class="paginate_item page-item"><a class="paginate_button page-link" aria-controls="datatable" data-dt-idx="2" tabindex="0">2</a></li>
                                <li class="paginate_item page-item"><a class="paginate_button next page-link" aria-controls="datatable" data-dt-idx="3" tabindex="0" id="datatable_next"><span aria-hidden="true">Siguiente</span></a></li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection