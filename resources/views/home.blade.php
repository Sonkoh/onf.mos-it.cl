@extends('base')
@section('top')
    <div class="col-sm mb-2 mb-sm-0">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-no-gutter">
                {{-- <li class="breadcrumb-item"><a class="breadcrumb-link" href="javascript:;">Pages</a>
            </li> --}}
                <li class="breadcrumb-item"><a class="breadcrumb-link" href="javascript:;"></a></li>
                <li class="breadcrumb-item active" aria-current="page">Inicio</li>
            </ol>
        </nav>

        <h1 class="page-header-title">Inicio</h1>
    </div>
    <div>
        <div>
            <span class="divider-center mb-4">APIs</span>
            @foreach ($apis as $api)
                @php
                    $hasPermissions = false;
                    foreach ($vnos as $vno_base) {
                        if (in_array('API_' . $api->id . '.' . $vno_base->id, json_decode(auth()->user()->permissions, true))) {
                            $hasPermissions = true;
                        }
                    }
                @endphp
                @if (!$hasPermissions)
                    @continue
                @endif
                <div class="card mb-2 col-lg">
                    <div class="card-body d-flex">
                        <div class="flex-shrink-0 d-flex">
                            <img class="avatar avatar-xs avatar-4x3" src="/template/assets/svg/illustrations/oc-globe.svg"
                                data-hs-theme-appearance="default">
                            <img class="avatar avatar-xs avatar-4x3"
                                src="/template/assets/svg/illustrations-light/oc-globe.svg" data-hs-theme-appearance="dark">
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h5 class="mb-0">{{ $api->name }}</h5>
                                </div>
                                <div class="col-auto">
                                    <a class="btn btn-danger rounded-pill" href="/apis/{{ $api->identifier }}"><i
                                            class="bi bi-play-fill"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="px-5">
        <span class="divider-center my-4">Manual de Uso</span>
        <h1>¿Cómo probar una api?</h1>
        <p>Para probar una api primero debes seleccionarla desde el sidebar o desde el panel.</p>
        <img src="/img/1.png" class="w-100">
        <h1 class="mt-5">Selección de VNO</h1>
        <p>En la parte superior derecha, desde el panel de la api que estes utilizando, puedes seleccionar la VNO a utilizar
            al momento de ejecutar la api, en esta sección podrás ver las VNOs que tienes disponible dependiendo la API.</p>
        <img src="/img/2.png" class="w-100">
        <h1 class="mt-5">Planificar ejecución</h1>
        <p>Para ejecutar la API con la versión seleccionada, debes presionar el botón verde ubicado a la derecha del nombre
            de la API <button type="button" data-bs-toggle="modal" data-bs-target="#open_1Modal"
                style="width: 42.59px; height: 42.59px; padding: 0; align-items: center; justify-content: center;"
                class="btn btn-success rounded-pill"><i class="bi bi-play-fill"></i></button>. Esto desplegará un menú en el
            cual podrás ver dos botones grandes: uno denominado "Básico" y otro "Avanzado". Ambos representan distintos
            enfoques para enviar datos a la API. Con el método básico, se emplea un sistema de clave y valor, requiriendo
            que completes o modifiques cada uno de los campos. Por otro lado, el método avanzado implica introducir, en un
            único campo de texto, un JSON que equivalga a los datos a enviar.</p>
        <img src="/img/3.png" class="w-100">
        <h1 class="mt-5">Selección de entorno y ejecución de la api</h1>
        <p>Antes de ejecutar la API, es necesario que elijas el entorno en el cual deseas ejecutarla. Para hacerlo, haz clic
            en el botón ubicado a la izquierda del botón de ejecución. Esto desplegará un menú que mostrará todos los
            entornos disponibles para esa configuración. Una vez que hayas preparado la solicitud, presiona el botón verde
            para ejecutar la API <button type="button" data-bs-toggle="modal" data-bs-target="#open_1Modal"
                style="width: 42.59px; height: 42.59px; padding: 0; align-items: center; justify-content: center;"
                class="btn btn-success rounded-pill"><i class="bi bi-play-fill"></i></button>. Finalmente, luego de unos
            segundos, se mostrarán los resultados de la petición.</p>
        <img src="/img/4.png" class="w-100">
    </div>
@endsection
