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
<div class="col-sm-auto">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createUserModal">
        <i class="bi-person-plus-fill me-1"></i> Crear Flujo
    </button>
</div>
@endsection
@section('content')
<div class="row row-cols-1">
    @foreach ($flows as $flow)
    <div class="col-md-6 mb-3">
        <div class="card card-body">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex gap-4">
                    <i class="bi bi-bezier2" style="font-size: 2rem;"></i>
                    <div>
                        <h4 class="mb-2"><a href="#">{{$flow->name}}</a></h4>
                        <p class="text-muted m-0">Flujo Sincrono</p>
                    </div>
                </div>
                <div class="dropdown">
                    <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm rounded-circle" id="teamsListDropdown1" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi-three-dots-vertical"></i>
                    </button>

                    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-end" aria-labelledby="teamsListDropdown1">
                        <a class="dropdown-item" href="#">Ver</a>
                        <a class="dropdown-item text-danger" href="#">Eliminar</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
@section('modals')

<!-- Edit user -->
<div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createUserModalLabel">Crear Flujo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    @csrf
                    <div class="row mb-4">
                        <label for="nameFlush" class="col-sm-3 col-form-label form-label">Nombre del Flujo</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="name" maxlength="16" placeholder="Inserta un nombre para el flujo">
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <div class="d-flex gap-3">
                            <button type="button" class="btn btn-white" data-bs-dismiss="modal" aria-label="Close" id="createUserCloseModal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Crear Flujo</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection