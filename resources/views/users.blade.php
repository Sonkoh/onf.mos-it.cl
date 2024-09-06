@extends('base')
@section('top')
<div class="col-sm mb-2 mb-sm-0">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-no-gutter">
            {{-- <li class="breadcrumb-item"><a class="breadcrumb-link" href="javascript:;">Pages</a>
                                </li> --}}
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="/">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Perfiles</li>
        </ol>
    </nav>

    <h1 class="page-header-title">Perfiles</h1>
</div>
<div class="col-sm-auto">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createUserModal">
        <i class="bi-person-plus-fill me-1"></i> Crear Perfil
    </button>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
        <div class="card h-100">
            <div class="card-body">
                <h6 class="card-subtitle mb-2">Perfiles Totales</h6>

                <div class="row align-items-center gx-2">
                    <div class="col">
                        <span class="js-counter display-4 text-dark" data-value="{{ count($users) }}">{{ count($users) }}</span>
                        <span class="text-body fs-5 ms-1">de &infin;</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
        <!-- Card -->
        <div class="card h-100">
            <div class="card-body">
                <h6 class="card-subtitle mb-2">Perfiles Activos</h6>

                <div class="row align-items-center gx-2">
                    <div class="col">
                        <span class="js-counter display-4 text-dark">{{ $active_users ? count($active_users) : 0 }}</span>
                        <span class="text-body fs-5 ms-1">de {{ count($users) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
        <div class="card h-100">
            <div class="card-body">
                <h6 class="card-subtitle mb-2">Peticiones por Perfil</h6>

                <div class="row align-items-center gx-2">
                    <div class="col">
                        <span class="js-counter display-4 text-dark">{{ round(count($reports) / count($users), 1) }}</span>
                        <span class="text-body fs-5 ms-1">reportes por perfil</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
        <!-- Card -->
        <div class="card h-100">
            <div class="card-body">
                <h6 class="card-subtitle mb-2">% de Perfiles Activos</h6>

                <div class="row align-items-center gx-2">
                    <div class="col">
                        <span class="js-counter display-4 text-dark">{{ round((($active_users ? count($active_users) : 0) / count($users)) * 100, 1) }}</span>
                        <span class="display-4 text-dark">%</span>
                        <span class="text-body fs-5 ms-1">de {{ count($users) }}</span>
                    </div>
                </div>
                <!-- End Row -->
            </div>
        </div>
        <!-- End Card -->
    </div>
</div>
<!-- End Stats -->

<!-- Card -->
<div class="card">
    <!-- Header -->
    <div class="card-header card-header-content-md-between">
        <div class="mb-2 mb-md-0">
            <form>
                <div class="input-group input-group-merge input-group-flush">
                    <div class="input-group-prepend input-group-text">
                        <i class="bi-search"></i>
                    </div>
                    <input id="datatableSearch" type="search" class="form-control" placeholder="Buscar Perfil">
                </div>
            </form>
        </div>

        <div class="d-grid d-sm-flex justify-content-md-end align-items-sm-center gap-2">
            <div id="datatableCounterInfo" style="display: none;">
                <div class="d-flex align-items-center">
                    <span class="fs-5 me-3">
                        <span id="datatableCounter">0</span>
                        Seleccionado/s
                    </span>
                    <a class="btn btn-outline-danger btn-sm" onclick="deleteUsers()">
                        <i class="bi-trash"></i> Eliminar
                    </a>
                </div>
            </div>
            <div class="dropdown">
                <button type="button" class="btn btn-white btn-sm dropdown-toggle w-100" id="usersExportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi-download me-2"></i> Exportar
                </button>

                <div class="dropdown-menu dropdown-menu-sm-end" aria-labelledby="usersExportDropdown">
                    <span class="dropdown-header">Exportar</span>
                    <a id="export-print" class="dropdown-item" href="javascript:;">
                        <img class="avatar avatar-xss avatar-4x3 me-2" src="./template/assets/svg/illustrations/print-icon.svg" alt="Image Description">
                        Imprimir
                    </a>
                    <div class="dropdown-divider"></div>
                    <span class="dropdown-header">Download options</span>
                    <a id="export-excel" class="dropdown-item" href="javascript:;">
                        <img class="avatar avatar-xss avatar-4x3 me-2" src="./template/assets/svg/brands/excel-icon.svg" alt="Image Description">
                        Excel
                    </a>
                    <a id="export-csv" class="dropdown-item" href="javascript:;">
                        <img class="avatar avatar-xss avatar-4x3 me-2" src="./template/assets/svg/components/placeholder-csv-format.svg" alt="Image Description">
                        .CSV
                    </a>
                    <a id="export-pdf" class="dropdown-item" href="javascript:;">
                        <img class="avatar avatar-xss avatar-4x3 me-2" src="./template/assets/svg/brands/pdf-icon.svg" alt="Image Description">
                        PDF
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- End Header -->

    <!-- Table -->
    <div class="table-responsive datatable-custom position-relative">
        <div id="datatable_wrapper" class="dataTables_wrapper no-footer">
            <div class="dt-buttons"> <button class="dt-button buttons-copy buttons-html5 d-none" tabindex="0" aria-controls="datatable" type="button"><span>Copiar</span></button> <button class="dt-button buttons-excel buttons-html5 d-none" tabindex="0" aria-controls="datatable" type="button"><span>Excel</span></button> <button class="dt-button buttons-csv buttons-html5 d-none" tabindex="0" aria-controls="datatable" type="button"><span>CSV</span></button> <button class="dt-button buttons-pdf buttons-html5 d-none" tabindex="0" aria-controls="datatable" type="button"><span>PDF</span></button> <button class="dt-button buttons-print d-none" tabindex="0" aria-controls="datatable" type="button"><span>Print</span></button> </div>
            <div id="datatable_filter" class="dataTables_filter"><label>Buscar:<input type="search" class="" placeholder="" aria-controls="datatable"></label></div>
            <table id="datatable" class="table table-lg table-borderless table-thead-bordered table-nowrap table-align-middle card-table dataTable no-footer" data-hs-datatables-options="{
                   &quot;columnDefs&quot;: [{
                      &quot;targets&quot;: [0, 7],
                      &quot;orderable&quot;: false
                    }],
                   &quot;order&quot;: [],
                   &quot;info&quot;: {
                     &quot;totalQty&quot;: &quot;#datatableWithPaginationInfoTotalQty&quot;
                   },
                   &quot;search&quot;: &quot;#datatableSearch&quot;,
                   &quot;entries&quot;: &quot;#datatableEntries&quot;,
                   &quot;pageLength&quot;: 100,
                   &quot;isResponsive&quot;: false,
                   &quot;isShowPaging&quot;: false,
                   &quot;pagination&quot;: &quot;datatablePagination&quot;
                 }" role="grid" aria-describedby="datatable_info">
                <thead class="thead-light">
                    <tr role="row">
                        <th class="table-column-pe-0 sorting_disabled" rowspan="1" colspan="1" aria-label="
                  
                    
                    
                  
                " style="width: 44.9219px;">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="datatableCheckAll">
                                <label class="form-check-label" for="datatableCheckAll"></label>
                            </div>
                        </th>
                        <th class="table-column-ps-0 sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending" style="width: 279.281px;">Nombre</th>
                        <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 199.656px;">
                            Grupo</th>
                        <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Country: activate to sort column ascending" style="width: 175.656px;">Estado de cuenta
                        </th>
                        <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Country: activate to sort column ascending" style="width: 175.656px;">Activo
                        </th>
                        <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 151.094px;">Fecha de
                            Expiración
                        </th>
                        <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Portfolio: activate to sort column ascending" style="width: 200.312px;">
                            Fecha de Creación</th>
                        <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="" style="width: 150px;"></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($users as $user)
                    <tr role="row">
                        <td class="table-column-pe-0">
                            <div class="form-check">
                                <input class="form-check-input ipt_user_selected" type="checkbox" value="" id="ipt_user_selected-{{ $user->id }}" data-user="{{ $user->id }}">
                                <label class="form-check-label" for="ipt_user_selected-{{ $user->id }}"></label>
                            </div>
                        </td>
                        <td class="table-column-ps-0">
                            <a class="d-flex align-items-center" href="#">
                                <div class="avatar avatar-soft-primary avatar-circle">
                                    <span class="avatar-initials">{{ mb_substr($user->email, 0, 1) }}</span>
                                </div>
                                <div class="ms-3">
                                    <?php
                                        $name = explode('.', explode('@', strtolower($user->email))[0])
                                    ?>
                                    <span class="d-block h5 text-inherit mb-0">{{ join(' ', array_map('ucfirst', $name)) }}</span>
                                    <span class="d-block fs-5 text-body">{{ strtolower($user->email) }}</span>
                                </div>
                            </a>
                        </td>
                        <td>
                            <span class="d-block h5 mb-0"><?= $user->group == 'admin' ? '<span class="badge bg-soft-danger text-danger">ADMINISTRADOR</span>' : '<span class="badge bg-soft-success text-success">USUARIO</span>' ?></span>
                        </td>
                        <td>
                            @if (strtotime($user->expiration) < time()) <span class="legend-indicator"></span>Suspendida
                                @else
                                <span class="legend-indicator bg-success"></span>Habilitada
                                @endif
                        </td>
                        <td>
                            @if(in_array(["id" => $user->id], json_decode(json_encode($active_users), true)))
                            <span class="legend-indicator bg-success"></span>Activa
                            @else
                            <span class="legend-indicator"></span>Inactiva
                            @endif
                        </td>
                        <td>{{ date('d/m/Y - m:i', strtotime($user->expiration)) }}</td>
                        <td>{{ date('d/m/Y - m:i', strtotime($user->created_at)) }}</td>
                        @php
                        $user->permissions = json_decode($user->permissions, true);
                        @endphp
                        <td>
                            <button type="button" class="btn btn-white btn-sm" data-bs-toggle="modal" data-bs-target="#editUserModal" onclick="openEditUserModal(`{{ json_encode($user) }}`)">
                                <i class="bi-pencil-fill me-1"></i> Editar
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@section('modals')

<!-- Edit user -->
<div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createUserModalLabel">Crear perfil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Body -->
            <div class="modal-body">
                <form id="createUserForm">
                    <div class="row mb-4">
                        <label for="createEmailModalLabel" class="col-sm-3 col-form-label form-label">Email</label>

                        <div class="col-sm-9">
                            <input type="email" class="form-control" name="createEmailModal" id="createUserEmail" placeholder="mail@mos-it.cl">
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="createEmailModalLabel" class="col-sm-3 col-form-label form-label">Contraseña</label>

                        <div class="col-sm-9">
                            <input type="password" class="form-control" name="createEmailModal" id="createUserPassword" placeholder="Contraseña">
                        </div>
                    </div>

                    <div class="row mb-4">
                        <label for="createEmailModalLabel" class="col-sm-3 col-form-label form-label">Vigencia</label>

                        <div class="col-sm-9" style="display: grid; grid-template-columns: 1fr 1fr">
                            <input type="date" class="form-control" placeholder="Custom" style="border-radius: .3125rem 0 0 .3125rem;" id="createUserDateExpiration" value="<?= date("Y-m-d", strtotime("+1 month", strtotime(date('Y-m-d')))) ?>">
                            <select id="createUserSelectExpiration" class="js-select form-select tomselected" autocomplete="off" name="createPhoneSelect" data-hs-tom-select-options="{
                                    &quot;searchInDropdown&quot;: false,
                                    &quot;hideSearch&quot;: true
                                  }" tabindex="-1" style="border-radius: 0 .3125rem .3125rem 0;">

                                <option value="1" selected>1 Mes</option>
                                <option value="2">2 Meses</option>
                                <option value="3">3 Meses</option>
                                <option value="4">4 Meses</option>
                                <option value="6">6 Meses</option>
                                <option value="12">1 Año</option>
                                <option value="24">2 Años</option>
                                <option value="36">3 Años</option>
                                <option value="48">4 Años</option>
                                <option value="60">5 Años</option>
                            </select>
                        </div>
                    </div>
                    <table class="table table-thead-bordered table-nowrap table-align-middle table-first-col-px-0">
                        <thead class="thead-light">
                            <tr>
                                <th>API</th>
                                @foreach ($vnos as $vno)
                                <th class="text-center">
                                    <div class="mb-1">
                                        <img class="avatar avatar-xs" src="/template/assets/svg/illustrations/oc-globe.svg" alt="Image Description" data-hs-theme-appearance="default">
                                        <img class="avatar avatar-xs" src="/template/assets/svg/illustrations-light/oc-globe.svg" alt="Image Description" data-hs-theme-appearance="dark">
                                    </div>
                                    {{ $vno->name }}
                                </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($apis as $api)
                            <tr>
                                <td>{{ $api->name }}</td>
                                @foreach($vnos as $vno)
                                <td class="text-center">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="ipt_create_user_permission-api_{{ $api->id }}_{{ $vno->id }}">
                                        <label class="form-check-label" for="ipt_create_user_permission-api_{{ $api->id }}_{{ $vno->id }}"></label>
                                    </div>
                                </td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end">
                        <div class="d-flex gap-3">
                            <button type="button" class="btn btn-white" data-bs-dismiss="modal" aria-label="Close" id="createUserCloseModal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Crear Perfil</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Editar perfil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Body -->
            <div class="modal-body">
                <form id="editUserForm">
                    <input type="hidden" id="editUserId">
                    <div class="row mb-4">
                        <label for="editEmailModalLabel" class="col-sm-3 col-form-label form-label">Email</label>

                        <div class="col-sm-9">
                            <input type="email" class="form-control" name="editEmailModal" id="editUserEmail" placeholder="mail@mos-it.cl" disabled>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="editUserPassword" class="col-sm-3 col-form-label form-label">Nueva Contraseña</label>

                        <div class="col-sm-9">
                            <input type="password" class="form-control" name="editEmailModal" id="editUserPassword" placeholder="Nueva Contraseña">
                        </div>
                    </div>

                    <div class="row mb-4">
                        <label for="editUserDateExpiration" class="col-sm-3 col-form-label form-label">Vigencia</label>

                        <div class="col-sm-9" style="display: grid; grid-template-columns: 1fr 1fr">
                            <input type="date" class="form-control" placeholder="Custom" style="border-radius: .3125rem 0 0 .3125rem;" id="editUserDateExpiration" value="<?= $fecha_mas_un_mes = date("Y-m-d", strtotime("+1 month", strtotime(date('Y-m-d')))) ?>">
                            <select id="editUserSelectExpiration" class="js-select form-select tomselected" autocomplete="off" name="editPhoneSelect" data-hs-tom-select-options="{
                                    &quot;searchInDropdown&quot;: false,
                                    &quot;hideSearch&quot;: true
                                  }" tabindex="-1" style="border-radius: 0 .3125rem .3125rem 0;">

                                <option value="1" selected>1 Mes</option>
                                <option value="2">2 Meses</option>
                                <option value="3">3 Meses</option>
                                <option value="4">4 Meses</option>
                                <option value="6">6 Meses</option>
                                <option value="12">1 Año</option>
                                <option value="24">2 Años</option>
                                <option value="36">3 Años</option>
                                <option value="48">4 Años</option>
                                <option value="60">5 Años</option>
                            </select>
                        </div>
                    </div>
                    <table class="table table-thead-bordered table-nowrap table-align-middle table-first-col-px-0">
                        <thead class="thead-light">
                            <tr>
                                <th>API</th>
                                @foreach ($vnos as $vno)
                                <th class="text-center">
                                    <div class="mb-1">
                                        <img class="avatar avatar-xs" src="/template/assets/svg/illustrations/oc-globe.svg" alt="Image Description" data-hs-theme-appearance="default">
                                        <img class="avatar avatar-xs" src="/template/assets/svg/illustrations-light/oc-globe.svg" alt="Image Description" data-hs-theme-appearance="dark">
                                    </div>
                                    {{ $vno->name }}
                                </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($apis as $api)
                            <tr>
                                <td>{{ $api->name }}</td>
                                @foreach($vnos as $vno)
                                <td class="text-center">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="ipt_edit_user_permission-api_{{ $api->id }}_{{ $vno->id }}">
                                        <label class="form-check-label" for="ipt_edit_user_permission-api_{{ $api->id }}_{{ $vno->id }}"></label>
                                    </div>
                                </td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-end">
                        <div class="d-flex gap-3">
                            <button type="button" class="btn btn-white" data-bs-dismiss="modal" aria-label="Close" id="editUserCloseModal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Editar Perfil</button>
                        </div>
                    </div>
                </form>
                <!-- End Tab Content -->
            </div>
            <!-- End Body -->
        </div>
    </div>
</div>
@endsection
@section('scripts_after')
<script src="/template/assets/vendor/hs-counter/dist/hs-counter.min.js"></script>
<script>
    (function() {
        // INITIALIZATION OF COUNTER
        // =======================================================
        new HSCounter('.js-counter')
    })();
</script>
<script>
    const apis = @json($apis);
    const vnos = @json($vnos);
    $('#createUserSelectExpiration').change(function(e) {
        var selectedMonths = parseInt($(this).val());
        if (!isNaN(selectedMonths)) {
            var t = new Date();
            t.setMonth(t.getMonth() + selectedMonths);
            var year = t.getFullYear();
            var month = (t.getMonth() + 1).toString().padStart(2, '0');
            var day = t.getDate().toString().padStart(2, '0');
            $('#createUserDateExpiration').val(`${year}-${month}-${day}`);
        }
    });
    $('#editUserSelectExpiration').change(function(e) {
        var selectedMonths = parseInt($(this).val());
        if (!isNaN(selectedMonths)) {
            var t = new Date();
            t.setMonth(t.getMonth() + selectedMonths);
            var year = t.getFullYear();
            var month = (t.getMonth() + 1).toString().padStart(2, '0');
            var day = t.getDate().toString().padStart(2, '0');
            $('#editUserDateExpiration').val(`${year}-${month}-${day}`);
        }
    });
    $('#createUserForm').submit(function(e) {
        e.preventDefault();
        permissions = [];
        apis.forEach(function(api) {
            vnos.forEach(function(vno) {
                if ($(`#ipt_create_user_permission-api_${api.id}_${vno.id}`).is(':checked')) {
                    permissions.push(`API_${api.id}.${vno.id}`);
                }
            })
        })
        $.ajax({
            type: "POST",
            url: "/api/user/create",
            data: {
                "_token": "{{ csrf_token() }}",
                "email": $('#createUserEmail').val(),
                "password": $('#createUserPassword').val(),
                "expiration": $('#createUserDateExpiration').val(),
                "permissions": permissions
            },
            success: function(response) {
                response = JSON.parse(response);
                if (response.success) {
                    Swal.fire({
                        title: '¡Usuario creado correctamente!',
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Continuar",
                        customClass: {
                            confirmButton: "btn fw-bold btn-primary",
                        }
                    }).then(function() {
                        window.location.reload()
                    });
                } else {
                    Swal.fire({
                        title: '¡Ha ocurrido un error!',
                        text: response.response,
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Continuar",
                        customClass: {
                            confirmButton: "btn fw-bold btn-primary",
                        }
                    })
                }
            }
        });
    });

    $('#editUserForm').submit(function(e) {
        e.preventDefault();
        permissions = [];
        apis.forEach(function(api) {
            vnos.forEach(function(vno) {
                if ($(`#ipt_edit_user_permission-api_${api.id}_${vno.id}`).is(':checked')) {
                    permissions.push(`API_${api.id}.${vno.id}`);
                }
            })
        })
        $.ajax({
            type: "POST",
            url: "/api/user/edit",
            data: {
                "_token": "{{ csrf_token() }}",
                "user": $('#editUserId').val(),
                "password": $('#editUserPassword').val(),
                "expiration": $('#editUserDateExpiration').val(),
                "permissions": permissions
            },
            success: function(response) {
                response = JSON.parse(response);
                if (response.success) {
                    Swal.fire({
                        title: '¡Usuario actualizado correctamente!',
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Continuar",
                        customClass: {
                            confirmButton: "btn fw-bold btn-primary",
                        }
                    }).then(function() {
                        window.location.reload()
                    });
                } else {
                    Swal.fire({
                        title: '¡Ha ocurrido un error!',
                        text: response.response,
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Continuar",
                        customClass: {
                            confirmButton: "btn fw-bold btn-primary",
                        }
                    })
                }
            }
        });
    });

    function openEditUserModal(user) {
        user = JSON.parse(user);
        var dateString = user.expiration;
        var date = new Date(dateString);
        var year = date.getFullYear();
        var month = ("0" + (date.getMonth() + 1)).slice(-2);
        var day = ("0" + date.getDate()).slice(-2);
        $('#editUserId').val(user.id);
        $('#editUserEmail').val(user.email);
        $('#editUserDateExpiration').val(formattedDate = year + "-" + month + "-" + day);
        apis.forEach(function(api) {
            vnos.forEach(function(vno) {
                $(`#ipt_edit_user_permission-api_${api.id}_${vno.id}`).prop('checked', user.permissions.includes(`API_${api.id}.${vno.id}`));
            });
        });
    }

    function deleteUsers() {
        users = [];
        $('.ipt_user_selected:checked').each(function() {
            users.push($(this).attr('data-user'));
        })
        $.ajax({
            type: "post",
            url: "/api/user/delete",
            data: {
                "_token": "{{ csrf_token() }}",
                users: users
            },
            success: function(response) {
                response = JSON.parse(response);
                if (response.success) {
                    Swal.fire({
                        title: '¡Usuario/s eliminado/s correctamente!',
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Continuar",
                        customClass: {
                            confirmButton: "btn fw-bold btn-primary",
                        }
                    }).then(function() {
                        window.location.reload()
                    });
                } else {
                    Swal.fire({
                        title: '¡Ha ocurrido un error!',
                        text: response.response,
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Continuar",
                        customClass: {
                            confirmButton: "btn fw-bold btn-primary",
                        }
                    })
                }
            }
        });
    }
</script>
@endsection