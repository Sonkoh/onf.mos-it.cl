@php
date_default_timezone_set('America/Santiago');
@endphp
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ $title }} | {{ env('APP_NAME') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&amp;display=swap" rel="stylesheet">
    <!-- <link rel="stylesheet" href="/template/assets/vendor/bootstrap-icons/font/bootstrap-icons.css"> -->
    <link href="
https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.min.css
" rel="stylesheet">
    <link rel="stylesheet" href="/template/assets/vendor/tom-select/dist/css/tom-select.bootstrap5.css">
    <link rel="stylesheet" href="/template/assets/vendor/quill/dist/quill.snow.css">
    <link rel="preload" href="/template/assets/css/theme.min.css" data-hs-appearance="default" as="style">
    <link rel="preload" href="/template/assets/css/theme-dark.min.css" data-hs-appearance="dark" as="style">
    @yield('head')  
    <script>
        window.hs_config = {
            "autopath": "@@autopath",
            "deleteLine": "hs-builder:delete",
            "deleteLine:build": "hs-builder:build-delete",
            "deleteLine:dist": "hs-builder:dist-delete",
            "previewMode": false,
            "startPath": "/index.html",
            "vars": {
                "themeFont": "https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap",
                "version": "?v=1.0"
            },
            "layoutBuilder": {
                "extend": {
                    "switcherSupport": true
                },
                "header": {
                    "layoutMode": "default",
                    "containerMode": "container-fluid"
                },
                "sidebarLayout": "default"
            },
            "themeAppearance": {
                "layoutSkin": "default",
                "sidebarSkin": "default",
                "styles": {
                    "colors": {
                        "primary": "#377dff",
                        "transparent": "transparent",
                        "white": "#fff",
                        "dark": "132144",
                        "gray": {
                            "100": "#f9fafc",
                            "900": "#1e2022"
                        }
                    },
                    "font": "Inter"
                }
            },
            "languageDirection": {
                "lang": "es"
            },
            "skipFilesFromBundle": {
                "dist": ["template/assets/js/hs.theme-appearance.js",
                    "template/assets/js/hs.theme-appearance-charts.js", "template/assets/js/demo.js"
                ],
                "build": ["template/assets/css/theme.css",
                    "template/assets/vendor/hs-navbar-vertical-aside/dist/hs-navbar-vertical-aside-mini-cache.js",
                    "template/assets/js/demo.js", "template/assets/css/theme-dark.css",
                    "template/assets/css/docs.css", "template/assets/vendor/icon-set/style.css",
                    "template/assets/js/hs.theme-appearance.js", "template/assets/js/hs.theme-appearance-charts.js",
                    "node_modules/chartjs-plugin-datalabels/dist/chartjs-plugin-datalabels.min.js",
                    "template/assets/js/demo.js"
                ]
            },
            "minifyCSSFiles": ["template/assets/css/theme.css", "template/assets/css/theme-dark.css"],
            "copyDependencies": {
                "dist": {
                    "*template/assets/js/theme-custom.js": ""
                },
                "build": {
                    "*template/assets/js/theme-custom.js": "",
                    "node_modules/bootstrap-icons/font/*fonts/**": "template/assets/css"
                }
            },
            "buildFolder": "",
            "replacePathsToCDN": {},
            "directoryNames": {
                "src": "/src",
                "dist": "/dist",
                "build": "/build"
            },
            "fileNames": {
                "dist": {
                    "js": "theme.min.js",
                    "css": "theme.min.css"
                },
                "build": {
                    "css": "theme.min.css",
                    "js": "theme.min.js",
                    "vendorCSS": "vendor.min.css",
                    "vendorJS": "vendor.min.js"
                }
            },
            "fileTypes": "jpg|png|svg|mp4|webm|ogv|json"
        }
        window.hs_config.gulpRGBA = (p1) => {
            const options = p1.split(',')
            const hex = options[0].toString()
            const transparent = options[1].toString()

            var c;
            if (/^#([A-Fa-f0-9]{3}){1,2}$/.test(hex)) {
                c = hex.substring(1).split('');
                if (c.length == 3) {
                    c = [c[0], c[0], c[1], c[1], c[2], c[2]];
                }
                c = '0x' + c.join('');
                return 'rgba(' + [(c >> 16) & 255, (c >> 8) & 255, c & 255].join(',') + ',' + transparent + ')';
            }
            throw new Error('Bad Hex');
        }
        window.hs_config.gulpDarken = (p1) => {
            const options = p1.split(',')

            let col = options[0].toString()
            let amt = -parseInt(options[1])
            var usePound = false

            if (col[0] == "#") {
                col = col.slice(1)
                usePound = true
            }
            var num = parseInt(col, 16)
            var r = (num >> 16) + amt
            if (r > 255) {
                r = 255
            } else if (r < 0) {
                r = 0
            }
            var b = ((num >> 8) & 0x00FF) + amt
            if (b > 255) {
                b = 255
            } else if (b < 0) {
                b = 0
            }
            var g = (num & 0x0000FF) + amt
            if (g > 255) {
                g = 255
            } else if (g < 0) {
                g = 0
            }
            return (usePound ? "#" : "") + (g | (b << 8) | (r << 16)).toString(16)
        }
        window.hs_config.gulpLighten = (p1) => {
            const options = p1.split(',')

            let col = options[0].toString()
            let amt = parseInt(options[1])
            var usePound = false

            if (col[0] == "#") {
                col = col.slice(1)
                usePound = true
            }
            var num = parseInt(col, 16)
            var r = (num >> 16) + amt
            if (r > 255) {
                r = 255
            } else if (r < 0) {
                r = 0
            }
            var b = ((num >> 8) & 0x00FF) + amt
            if (b > 255) {
                b = 255
            } else if (b < 0) {
                b = 0
            }
            var g = (num & 0x0000FF) + amt
            if (g > 255) {
                g = 255
            } else if (g < 0) {
                g = 0
            }
            return (usePound ? "#" : "") + (g | (b << 8) | (r << 16)).toString(16)
        }
    </script>
    <style data-hs-appearance-visability-styles="">
        [data-hs-theme-appearance]:not([data-hs-theme-appearance='default']) {
            display: none !important;
        }
    </style>
</head>
<link rel="stylesheet" href="/template/assets/css/theme.min.css" data-hs-current-theme="stylesheet">

<body class="has-navbar-vertical-aside navbar-vertical-aside-show-xl footer-offset">
    <style>
        #loader {
            display: flex;
        }
    </style>
    <div style="position: fixed; width: 100vw; height: 100vh; background: var(--bs-body-bg); top: 0; left: 0; z-index: 1; display: flex; align-items: center; justify-content: center; display: none" id="loader">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <script src="/template/assets/js/hs.theme-appearance.js"></script>

    <script src="/template/assets/vendor/hs-navbar-vertical-aside/dist/hs-navbar-vertical-aside-mini-cache.js"></script>



    @if (auth()->user()->id == 1 || env('APP_ENV') == 'local')
    <aside
        class="js-navbar-vertical-aside navbar navbar-vertical-aside navbar-vertical navbar-vertical-fixed navbar-expand-xl navbar-bordered bg-white navbar-vertical-aside-initialized">
        <div class="navbar-vertical-container">
            <div class="navbar-vertical-footer-offset">
                <a class="navbar-brand" href="/" aria-label="MOS-iT">
                    <img class="navbar-brand-logo" src="https://mos-it.cl/wp2/wp-content/uploads/2023/12/PNG-Mos-It-2.png"
                        alt="MOS-iT" data-hs-theme-appearance="default"
                        style="width: 100%;min-width: 8rem;max-width: 8rem;margin: auto;">
                    <img class="navbar-brand-logo"
                        src="https://mos-it.cl/wp2/wp-content/uploads/2023/12/PNG-Mos-It-2.png" alt="MOS-iT"
                        data-hs-theme-appearance="dark"
                        style="width: 100%;min-width: 8rem;max-width: 8rem;margin: auto;">
                    <img class="navbar-brand-logo-mini" src="/favicon.png" alt="MOS-iT"
                        data-hs-theme-appearance="default">
                    <img class="navbar-brand-logo-mini" src="/favicon.png" alt="MOS-iT"
                        data-hs-theme-appearance="dark">
                </a>
                <button type="button" class="js-navbar-vertical-aside-toggle-invoker navbar-aside-toggler"
                    style="opacity: 1;">
                    <i class="bi-arrow-bar-left navbar-toggler-short-align"
                        data-bs-template="<div class=&quot;tooltip d-none d-md-block&quot; role=&quot;tooltip&quot;><div class=&quot;arrow&quot;></div><div class=&quot;tooltip-inner&quot;></div></div>"
                        data-bs-toggle="tooltip" data-bs-placement="right" aria-label="Collapse"
                        data-bs-original-title="Collapse"></i>
                    <i class="bi-arrow-bar-right navbar-toggler-full-align"
                        data-bs-template="<div class=&quot;tooltip d-none d-md-block&quot; role=&quot;tooltip&quot;><div class=&quot;arrow&quot;></div><div class=&quot;tooltip-inner&quot;></div></div>"
                        data-bs-toggle="tooltip" data-bs-placement="right" aria-label="Expand"
                        data-bs-original-title="Expand"></i>
                </button>
                <div class="navbar-vertical-content">
                    <div id="navbarVerticalMenu" class="nav nav-pills nav-vertical card-navbar-nav">
                        <span class="dropdown-header mt-4">Páginas</span>
                        <a class="nav-link" href="/">
                            <i class="bi-house-door nav-icon"></i>
                            <span class="nav-link-title">Inicio</span>
                        </a>
                        @if (auth()->user()->group == 'admin')
                        <a class="nav-link" href="/users">
                            <i class="bi-person nav-icon"></i>
                            <span class="nav-link-title">Usuarios</span>
                        </a>
                        @endif
                        <div class="nav-item">
                            <a class="nav-link dropdown-toggle" href="#navbarVerticalMenuPagesAPISMenu"
                                role="button" data-bs-toggle="collapse"
                                data-bs-target="#navbarVerticalMenuPagesAPISMenu" aria-expanded="true"
                                aria-controls="navbarVerticalMenuPagesAPISMenu">
                                <i class="bi-key nav-icon"></i>
                                <span class="nav-link-title">APIS</span>
                            </a>

                            <div id="navbarVerticalMenuPagesAPISMenu" class="nav-collapse collapse"
                                data-bs-parent="#navbarVerticalMenuPagesMenu" hs-parent-area="#navbarVerticalMenu">
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
                                <a class="nav-link " href="/apis/{{ $api->identifier }}">{{ $api->name }}</a>
                                @endforeach
                            </div>
                        </div>

                        <span class="dropdown-header mt-4">Cuenta</span>
                        <a class="nav-link" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                            <i class="bi-lock nav-icon"></i>
                            <span class="nav-link-title">Cambiar contraseña</span>
                        </a>
                    </div>

                </div>
                <div class="navbar-vertical-footer">
                    <ul class="navbar-vertical-footer-list">
                        <li class="navbar-vertical-footer-list-item">
                            <div class="dropdown dropup">
                                <button type="button" class="btn btn-ghost-secondary btn-icon rounded-circle"
                                    id="selectThemeDropdown" data-bs-toggle="dropdown" aria-expanded="false"
                                    data-bs-dropdown-animation=""><i class="bi-brightness-high"></i></button>

                                <div class="dropdown-menu navbar-dropdown-menu navbar-dropdown-menu-borderless"
                                    aria-labelledby="selectThemeDropdown">
                                    <a class="dropdown-item" href="#" data-icon="bi-moon-stars"
                                        data-value="auto">
                                        <i class="bi-moon-stars me-2"></i>
                                        <span class="text-truncate" title="Auto">Auto</span>
                                    </a>
                                    <a class="dropdown-item active" href="#" data-icon="bi-brightness-high"
                                        data-value="default">
                                        <i class="bi-brightness-high me-2"></i>
                                        <span class="text-truncate" title="Modo Claro">Modo Claro</span>
                                    </a>
                                    <a class="dropdown-item" href="#" data-icon="bi-moon"
                                        data-value="dark">
                                        <i class="bi-moon me-2"></i>
                                        <span class="text-truncate" title="Modo Oscuro">Modo Oscuro</span>
                                    </a>
                                </div>
                            </div>

                        </li>

                        <li class="navbar-vertical-footer-list-item">
                            <a href="/logout" class="btn btn-ghost-secondary btn-icon rounded-circle">
                                <i class="bi-box-arrow-right"></i>
                            </a>

                            <!-- End Other Links -->
                        </li>

                        <li class="navbar-vertical-footer-list-item">
                            <!-- Language -->
                            <div class="dropdown dropup">
                                <button type="button" class="btn btn-ghost-secondary btn-icon rounded-circle"
                                    id="selectLanguageDropdown" data-bs-toggle="dropdown" aria-expanded="false"
                                    data-bs-dropdown-animation="">
                                    <img class="avatar avatar-xss avatar-circle"
                                        src="/template/assets/vendor/flag-icon-css/flags/1x1/cl.svg"
                                        alt="Chilean Flag">
                                </button>

                                <div class="dropdown-menu navbar-dropdown-menu-borderless"
                                    aria-labelledby="selectLanguageDropdown">
                                    <span class="dropdown-header">Seleccionar Idioma</span>
                                    <a class="dropdown-item" href="#">
                                        <img class="avatar avatar-xss avatar-circle me-2"
                                            src="/template/assets/vendor/flag-icon-css/flags/1x1/cl.svg"
                                            alt="Flag">
                                        <span class="text-truncate" title="Español">Español</span>
                                    </a>
                                </div>
                            </div>

                            <!-- End Language -->
                        </li>
                    </ul>
                </div>
                <!-- End Footer -->
            </div>
        </div>
    </aside>

    <main id="content" role="main" class="main">
        <!-- Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-end">
                    @yield('top')
                </div>
            </div>
            <div>
                @yield('content')
            </div>
            <div class="footer">
                <div class="row justify-content-between align-items-center">
                    <div class="col">
                        <p class="fs-6 mb-0">© Mos-iT. <span class="d-none d-sm-inline-block">2024 Chile.</span>
                        </p>
                    </div>
                </div>
            </div>

    </main>
    @else
    <div class="content container-fluid">
        <div class="row justify-content-sm-center text-center py-10">
            <div class="col-sm-7 col-md-5">
                <img class="img-fluid mb-5" src="/template/assets/svg/illustrations/oc-collaboration.svg" alt="Image Description" data-hs-theme-appearance="default">
                <img class="img-fluid mb-5" src="/template/assets/svg/illustrations-light/oc-collaboration.svg" alt="Image Description" data-hs-theme-appearance="dark">

                <h1>Aplicación en mantención!</h1>
                <p>Vuelve a intentarlo más tarde</p>
            </div>
        </div>
        <!-- End Row -->
    </div>
    @endif
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasKeyboardShortcuts"
        aria-labelledby="offcanvasKeyboardShortcutsLabel">
        <div class="offcanvas-header">
            <h4 id="offcanvasKeyboardShortcutsLabel" class="mb-0">Keyboard shortcuts</h4>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="list-group list-group-sm list-group-flush list-group-no-gutters mb-5">
                <div class="list-group-item">
                    <h5 class="mb-1">Formatting</h5>
                </div>
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <span class="fw-semibold">Bold</span>
                        </div>
                        <!-- End Col -->

                        <div class="col-7 text-end">
                            <kbd class="d-inline-block mb-1">Ctrl</kbd> <span class="text-muted small">+</span> <kbd
                                class="d-inline-block mb-1">b</kbd>
                        </div>
                    </div>
                    <!-- End Row -->
                </div>

                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <em>italic</em>
                        </div>
                        <!-- End Col -->

                        <div class="col-7 text-end">
                            <kbd class="d-inline-block mb-1">Ctrl</kbd> <span class="text-muted small">+</span> <kbd
                                class="d-inline-block mb-1">i</kbd>
                        </div>
                        <!-- End Col -->
                    </div>
                    <!-- End Row -->
                </div>

                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <u>Underline</u>
                        </div>
                        <!-- End Col -->

                        <div class="col-7 text-end">
                            <kbd class="d-inline-block mb-1">Ctrl</kbd> <span class="text-muted small">+</span> <kbd
                                class="d-inline-block mb-1">u</kbd>
                        </div>
                        <!-- End Col -->
                    </div>
                    <!-- End Row -->
                </div>

                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <s>Strikethrough</s>
                        </div>
                        <!-- End Col -->

                        <div class="col-7 text-end">
                            <kbd class="d-inline-block mb-1">Ctrl</kbd> <span class="text-muted small">+</span> <kbd
                                class="d-inline-block mb-1">Alt</kbd> <span class="text-muted small">+</span> <kbd
                                class="d-inline-block mb-1">s</kbd>
                            <!-- End Col -->
                        </div>
                    </div>
                    <!-- End Row -->
                </div>

                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <span class="small">Small text</span>
                        </div>
                        <!-- End Col -->

                        <div class="col-7 text-end">
                            <kbd class="d-inline-block mb-1">Ctrl</kbd> <span class="text-muted small">+</span> <kbd
                                class="d-inline-block mb-1">s</kbd>
                        </div>
                        <!-- End Col -->
                    </div>
                    <!-- End Row -->
                </div>

                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <mark>Highlight</mark>
                        </div>
                        <!-- End Col -->

                        <div class="col-7 text-end">
                            <kbd class="d-inline-block mb-1">Ctrl</kbd> <span class="text-muted small">+</span> <kbd
                                class="d-inline-block mb-1">e</kbd>
                        </div>
                        <!-- End Col -->
                    </div>
                    <!-- End Row -->
                </div>

            </div>

            <div class="list-group list-group-sm list-group-flush list-group-no-gutters mb-5">
                <div class="list-group-item">
                    <h5 class="mb-1">Insert</h5>
                </div>
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <span>Mention person <a href="#">(@Brian)</a></span>
                        </div>
                        <!-- End Col -->

                        <div class="col-7 text-end">
                            <kbd class="d-inline-block mb-1">@</kbd>
                        </div>
                        <!-- End Col -->
                    </div>
                    <!-- End Row -->
                </div>

                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <span>Link to doc <a href="#">(+Meeting notes)</a></span>
                        </div>
                        <!-- End Col -->

                        <div class="col-7 text-end">
                            <kbd class="d-inline-block mb-1">+</kbd>
                        </div>
                        <!-- End Col -->
                    </div>
                    <!-- End Row -->
                </div>

                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <a href="#">#hashtag</a>
                        </div>
                        <!-- End Col -->

                        <div class="col-7 text-end">
                            <kbd class="d-inline-block mb-1">#hashtag</kbd>
                        </div>
                        <!-- End Col -->
                    </div>
                    <!-- End Row -->
                </div>

                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <span>Date</span>
                        </div>
                        <!-- End Col -->

                        <div class="col-7 text-end">
                            <kbd class="d-inline-block mb-1">/date</kbd>
                            <kbd class="d-inline-block mb-1">Space</kbd>
                            <kbd class="d-inline-block mb-1">/datetime</kbd>
                            <kbd class="d-inline-block mb-1">/datetime</kbd>
                            <kbd class="d-inline-block mb-1">Space</kbd>
                        </div>
                        <!-- End Col -->
                    </div>
                    <!-- End Row -->
                </div>

                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <span>Time</span>
                        </div>
                        <!-- End Col -->

                        <div class="col-7 text-end">
                            <kbd class="d-inline-block mb-1">/time</kbd>
                            <kbd class="d-inline-block mb-1">Space</kbd>
                        </div>
                        <!-- End Col -->
                    </div>
                    <!-- End Row -->
                </div>

                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <span>Note box</span>
                        </div>
                        <!-- End Col -->

                        <div class="col-7 text-end">
                            <kbd class="d-inline-block mb-1">/note</kbd>
                            <kbd class="d-inline-block mb-1">Enter</kbd>
                            <kbd class="d-inline-block mb-1">/note red</kbd>
                            <kbd class="d-inline-block mb-1">/note red</kbd>
                            <kbd class="d-inline-block mb-1">Enter</kbd>
                        </div>
                        <!-- End Col -->
                    </div>
                    <!-- End Row -->
                </div>

            </div>

            <div class="list-group list-group-sm list-group-flush list-group-no-gutters mb-5">
                <div class="list-group-item">
                    <h5 class="mb-1">Editing</h5>
                </div>
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <span>Find and replace</span>
                        </div>
                        <!-- End Col -->

                        <div class="col-7 text-end">
                            <kbd class="d-inline-block mb-1">Ctrl</kbd> <span class="text-muted small">+</span> <kbd
                                class="d-inline-block mb-1">r</kbd>
                        </div>
                        <!-- End Col -->
                    </div>
                    <!-- End Row -->
                </div>

                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <span>Find next</span>
                        </div>
                        <!-- End Col -->

                        <div class="col-7 text-end">
                            <kbd class="d-inline-block mb-1">Ctrl</kbd> <span class="text-muted small">+</span> <kbd
                                class="d-inline-block mb-1">n</kbd>
                        </div>
                        <!-- End Col -->
                    </div>
                    <!-- End Row -->
                </div>

                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <span>Find previous</span>
                        </div>
                        <!-- End Col -->

                        <div class="col-7 text-end">
                            <kbd class="d-inline-block mb-1">Ctrl</kbd> <span class="text-muted small">+</span> <kbd
                                class="d-inline-block mb-1">p</kbd>
                        </div>
                        <!-- End Col -->
                    </div>
                    <!-- End Row -->
                </div>

                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <span>Indent</span>
                        </div>
                        <!-- End Col -->

                        <div class="col-7 text-end">
                            <kbd class="d-inline-block mb-1">Tab</kbd>
                        </div>
                        <!-- End Col -->
                    </div>
                    <!-- End Row -->
                </div>

                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <span>Un-indent</span>
                        </div>
                        <!-- End Col -->

                        <div class="col-7 text-end">
                            <kbd class="d-inline-block mb-1">Shift</kbd> <span class="text-muted small">+</span>
                            <kbd class="d-inline-block mb-1">Tab</kbd>
                        </div>
                        <!-- End Col -->
                    </div>
                    <!-- End Row -->
                </div>

                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <span>Move line up</span>
                        </div>
                        <!-- End Col -->

                        <div class="col-7 text-end">
                            <kbd class="d-inline-block mb-1">Ctrl</kbd> <span class="text-muted small">+</span> <kbd
                                class="d-inline-block mb-1">Shift</kbd> <span class="text-muted small">+</span> <kbd
                                class="d-inline-block mb-1"><i class="bi-arrow-up-short"></i></kbd>
                        </div>
                        <!-- End Col -->
                    </div>
                    <!-- End Row -->
                </div>

                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <span>Move line down</span>
                        </div>
                        <!-- End Col -->

                        <div class="col-7 text-end">
                            <kbd class="d-inline-block mb-1">Ctrl</kbd> <span class="text-muted small">+</span> <kbd
                                class="d-inline-block mb-1">Shift</kbd> <span class="text-muted small">+</span> <kbd
                                class="d-inline-block mb-1"><i class="bi-arrow-down-short fs-5"></i></kbd>
                        </div>
                        <!-- End Col -->
                    </div>
                    <!-- End Row -->
                </div>

                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <span>Add a comment</span>
                        </div>
                        <!-- End Col -->

                        <div class="col-7 text-end">
                            <kbd class="d-inline-block mb-1">Ctrl</kbd> <span class="text-muted small">+</span> <kbd
                                class="d-inline-block mb-1">Alt</kbd> <span class="text-muted small">+</span> <kbd
                                class="d-inline-block mb-1">m</kbd>
                        </div>
                        <!-- End Col -->
                    </div>
                    <!-- End Row -->
                </div>

                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <span>Undo</span>
                        </div>
                        <!-- End Col -->

                        <div class="col-7 text-end">
                            <kbd class="d-inline-block mb-1">Ctrl</kbd> <span class="text-muted small">+</span> <kbd
                                class="d-inline-block mb-1">z</kbd>
                        </div>
                        <!-- End Col -->
                    </div>
                    <!-- End Row -->
                </div>

                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <span>Redo</span>
                        </div>
                        <!-- End Col -->

                        <div class="col-7 text-end">
                            <kbd class="d-inline-block mb-1">Ctrl</kbd> <span class="text-muted small">+</span> <kbd
                                class="d-inline-block mb-1">y</kbd>
                        </div>
                        <!-- End Col -->
                    </div>
                    <!-- End Row -->
                </div>

            </div>

            <div class="list-group list-group-sm list-group-flush list-group-no-gutters">
                <div class="list-group-item">
                    <h5 class="mb-1">Application</h5>
                </div>
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <span>Create new doc</span>
                        </div>
                        <!-- End Col -->

                        <div class="col-7 text-end">
                            <kbd class="d-inline-block mb-1">Ctrl</kbd> <span class="text-muted small">+</span> <kbd
                                class="d-inline-block mb-1">Alt</kbd> <span class="text-muted small">+</span> <kbd
                                class="d-inline-block mb-1">n</kbd>
                        </div>
                        <!-- End Col -->
                    </div>
                    <!-- End Row -->
                </div>

                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <span>Present</span>
                        </div>
                        <!-- End Col -->

                        <div class="col-7 text-end">
                            <kbd class="d-inline-block mb-1">Ctrl</kbd> <span class="text-muted small">+</span> <kbd
                                class="d-inline-block mb-1">Shift</kbd> <span class="text-muted small">+</span> <kbd
                                class="d-inline-block mb-1">p</kbd>
                        </div>
                        <!-- End Col -->
                    </div>
                    <!-- End Row -->
                </div>

                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <span>Share</span>
                        </div>
                        <!-- End Col -->

                        <div class="col-7 text-end">
                            <kbd class="d-inline-block mb-1">Ctrl</kbd> <span class="text-muted small">+</span> <kbd
                                class="d-inline-block mb-1">Shift</kbd> <span class="text-muted small">+</span> <kbd
                                class="d-inline-block mb-1">s</kbd>
                        </div>
                        <!-- End Col -->
                    </div>
                    <!-- End Row -->
                </div>

                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <span>Search docs</span>
                        </div>
                        <!-- End Col -->

                        <div class="col-7 text-end">
                            <kbd class="d-inline-block mb-1">Ctrl</kbd> <span class="text-muted small">+</span> <kbd
                                class="d-inline-block mb-1">Shift</kbd> <span class="text-muted small">+</span> <kbd
                                class="d-inline-block mb-1">o</kbd>
                        </div>
                        <!-- End Col -->
                    </div>
                    <!-- End Row -->
                </div>

                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <span>Keyboard shortcuts</span>
                        </div>
                        <!-- End Col -->

                        <div class="col-7 text-end">
                            <kbd class="d-inline-block mb-1">Ctrl</kbd> <span class="text-muted small">+</span> <kbd
                                class="d-inline-block mb-1">Shift</kbd> <span class="text-muted small">+</span> <kbd
                                class="d-inline-block mb-1">/</kbd>
                        </div>
                        <!-- End Col -->
                    </div>
                    <!-- End Row -->
                </div>

            </div>
        </div>
    </div>
    <!-- End Keyboard Shortcuts -->

    <!-- Activity -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasActivityStream"
        aria-labelledby="offcanvasActivityStreamLabel">
        <div class="offcanvas-header">
            <h4 id="offcanvasActivityStreamLabel" class="mb-0">Activity stream</h4>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <!-- Step -->
            <ul class="step step-icon-sm step-avatar-sm">
                <!-- Step Item -->
                <li class="step-item">
                    <div class="step-content-wrapper">
                        <div class="step-avatar">
                            <img class="step-avatar" src="/template/assets/img/160x160/img9.jpg"
                                alt="Image Description">
                        </div>

                        <div class="step-content">
                            <h5 class="mb-1">Iana Robinson</h5>

                            <p class="fs-5 mb-1">Added 2 files to task <a class="text-uppercase" href="#"><i
                                        class="bi-journal-bookmark-fill"></i> Fd-7</a></p>

                            <ul class="list-group list-group-sm">
                                <!-- List Item -->
                                <li class="list-group-item list-group-item-light">
                                    <div class="row gx-1">
                                        <div class="col-6">
                                            <!-- Media -->
                                            <div class="d-flex">
                                                <div class="flex-shrink-0">
                                                    <img class="avatar avatar-xs"
                                                        src="/template/assets/svg/brands/excel-icon.svg"
                                                        alt="Image Description">
                                                </div>
                                                <div class="flex-grow-1 text-truncate ms-2">
                                                    <span class="d-block fs-6 text-dark text-truncate"
                                                        title="weekly-reports.xls">weekly-reports.xls</span>
                                                    <span class="d-block small text-muted">12kb</span>
                                                </div>
                                            </div>
                                            <!-- End Media -->
                                        </div>
                                        <!-- End Col -->

                                        <div class="col-6">
                                            <!-- Media -->
                                            <div class="d-flex">
                                                <div class="flex-shrink-0">
                                                    <img class="avatar avatar-xs"
                                                        src="/template/assets/svg/brands/word-icon.svg"
                                                        alt="Image Description">
                                                </div>
                                                <div class="flex-grow-1 text-truncate ms-2">
                                                    <span class="d-block fs-6 text-dark text-truncate"
                                                        title="weekly-reports.xls">weekly-reports.xls</span>
                                                    <span class="d-block small text-muted">4kb</span>
                                                </div>
                                            </div>
                                            <!-- End Media -->
                                        </div>
                                        <!-- End Col -->
                                    </div>
                                    <!-- End Row -->
                                </li>
                                <!-- End List Item -->
                            </ul>

                            <span class="small text-muted text-uppercase">Now</span>
                        </div>
                    </div>
                </li>
                <!-- End Step Item -->

                <!-- Step Item -->
                <li class="step-item">
                    <div class="step-content-wrapper">
                        <span class="step-icon step-icon-soft-dark">B</span>

                        <div class="step-content">
                            <h5 class="mb-1">Bob Dean</h5>

                            <p class="fs-5 mb-1">Marked <a class="text-uppercase" href="#"><i
                                        class="bi-journal-bookmark-fill"></i> Fr-6</a> as <span
                                    class="badge bg-soft-success text-success rounded-pill"><span
                                        class="legend-indicator bg-success"></span>"Completed"</span></p>

                            <span class="small text-muted text-uppercase">Today</span>
                        </div>
                    </div>
                </li>
                <!-- End Step Item -->

                <!-- Step Item -->
                <li class="step-item">
                    <div class="step-content-wrapper">
                        <div class="step-avatar">
                            <img class="step-avatar-img" src="/template/assets/img/160x160/img3.jpg"
                                alt="Image Description">
                        </div>

                        <div class="step-content">
                            <h5 class="h5 mb-1">Crane</h5>

                            <p class="fs-5 mb-1">Added 5 card to <a href="#">Payments</a></p>

                            <ul class="list-group list-group-sm">
                                <li class="list-group-item list-group-item-light">
                                    <div class="row gx-1">
                                        <div class="col">
                                            <img class="img-fluid rounded"
                                                src="/template/assets/svg/components/card-1.svg"
                                                alt="Image Description">
                                        </div>
                                        <div class="col">
                                            <img class="img-fluid rounded"
                                                src="/template/assets/svg/components/card-2.svg"
                                                alt="Image Description">
                                        </div>
                                        <div class="col">
                                            <img class="img-fluid rounded"
                                                src="/template/assets/svg/components/card-3.svg"
                                                alt="Image Description">
                                        </div>
                                        <div class="col-auto align-self-center">
                                            <div class="text-center">
                                                <a href="#">+2</a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>

                            <span class="small text-muted text-uppercase">May 12</span>
                        </div>
                    </div>
                </li>
                <!-- End Step Item -->

                <!-- Step Item -->
                <li class="step-item">
                    <div class="step-content-wrapper">
                        <span class="step-icon step-icon-soft-info">D</span>

                        <div class="step-content">
                            <h5 class="mb-1">David Lidell</h5>

                            <p class="fs-5 mb-1">Added a new member to Front Dashboard</p>

                            <span class="small text-muted text-uppercase">May 15</span>
                        </div>
                    </div>
                </li>
                <!-- End Step Item -->

                <!-- Step Item -->
                <li class="step-item">
                    <div class="step-content-wrapper">
                        <div class="step-avatar">
                            <img class="step-avatar-img" src="/template/assets/img/160x160/img7.jpg"
                                alt="Image Description">
                        </div>

                        <div class="step-content">
                            <h5 class="mb-1">Rachel King</h5>

                            <p class="fs-5 mb-1">Marked <a class="text-uppercase" href="#"><i
                                        class="bi-journal-bookmark-fill"></i> Fr-3</a> as <span
                                    class="badge bg-soft-success text-success rounded-pill"><span
                                        class="legend-indicator bg-success"></span>"Completed"</span></p>

                            <span class="small text-muted text-uppercase">Apr 29</span>
                        </div>
                    </div>
                </li>
                <!-- End Step Item -->

                <!-- Step Item -->
                <li class="step-item">
                    <div class="step-content-wrapper">
                        <div class="step-avatar">
                            <img class="step-avatar-img" src="/template/assets/img/160x160/img5.jpg"
                                alt="Image Description">
                        </div>

                        <div class="step-content">
                            <h5 class="mb-1">Finch Hoot</h5>

                            <p class="fs-5 mb-1">Earned a "Top endorsed" <i
                                    class="bi-patch-check-fill text-primary"></i> badge</p>

                            <span class="small text-muted text-uppercase">Apr 06</span>
                        </div>
                    </div>
                </li>
                <!-- End Step Item -->

                <!-- Step Item -->
                <li class="step-item">
                    <div class="step-content-wrapper">
                        <span class="step-icon step-icon-soft-primary">
                            <i class="bi-person-fill"></i>
                        </span>

                        <div class="step-content">
                            <h5 class="mb-1">Project status updated</h5>

                            <p class="fs-5 mb-1">Marked <a class="text-uppercase" href="#"><i
                                        class="bi-journal-bookmark-fill"></i> Fr-3</a> as <span
                                    class="badge bg-soft-primary text-primary rounded-pill"><span
                                        class="legend-indicator bg-primary"></span>"In progress"</span></p>

                            <span class="small text-muted text-uppercase">Feb 10</span>
                        </div>
                    </div>
                </li>
                <!-- End Step Item -->
            </ul>
            <!-- End Step -->

            <div class="d-grid">
                <a class="btn btn-white" href="javascript:;">View all <i class="bi-chevron-right"></i></a>
            </div>
        </div>
    </div>
    <div class="modal fade" id="newProjectModal" tabindex="-1" aria-labelledby="newProjectModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newProjectModalLabel">New project</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Body -->
                <div class="modal-body">
                    <!-- Step Form -->
                    <form class="js-step-form"
                        data-hs-step-form-options="{
                    &quot;progressSelector&quot;: &quot;#createProjectStepFormProgress&quot;,
                    &quot;stepsSelector&quot;: &quot;#createProjectStepFormContent&quot;,
                    &quot;endSelector&quot;: &quot;#createProjectFinishBtn&quot;,
                    &quot;isValidate&quot;: false
                  }">
                        <!-- Step -->
                        <ul id="createProjectStepFormProgress"
                            class="js-step-progress step step-sm step-icon-sm step-inline step-item-between mb-3 mb-sm-7">
                            <li class="step-item active focus">
                                <a class="step-content-wrapper" href="javascript:;"
                                    data-hs-step-form-next-options="{
                      &quot;targetSelector&quot;: &quot;#createProjectStepDetails&quot;
                    }">
                                    <span class="step-icon step-icon-soft-dark">1</span>
                                    <div class="step-content">
                                        <span class="step-title">Details</span>
                                    </div>
                                </a>
                            </li>

                            <li class="step-item">
                                <a class="step-content-wrapper" href="javascript:;"
                                    data-hs-step-form-next-options="{
                       &quot;targetSelector&quot;: &quot;#createProjectStepTerms&quot;
                     }">
                                    <span class="step-icon step-icon-soft-dark">2</span>
                                    <div class="step-content">
                                        <span class="step-title">Terms</span>
                                    </div>
                                </a>
                            </li>

                            <li class="step-item">
                                <a class="step-content-wrapper" href="javascript:;"
                                    data-hs-step-form-next-options="{
                       &quot;targetSelector&quot;: &quot;#createProjectStepMembers&quot;
                     }">
                                    <span class="step-icon step-icon-soft-dark">3</span>
                                    <div class="step-content">
                                        <span class="step-title">Members</span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                        <!-- End Step -->

                        <!-- Content Step Form -->
                        <div id="createProjectStepFormContent">
                            <div id="createProjectStepDetails" class="active">
                                <!-- Form -->
                                <div class="mb-4">
                                    <label class="form-label">Project logo</label>

                                    <div class="d-flex align-items-center">
                                        <!-- Avatar -->
                                        <label class="avatar avatar-xl avatar-circle avatar-uploader me-5"
                                            for="avatarNewProjectUploader">
                                            <img id="avatarNewProjectImg" class="avatar-img"
                                                src="/template/assets/img/160x160/img2.jpg" alt="Image Description">

                                            <input type="file" class="js-file-attach avatar-uploader-input"
                                                id="avatarNewProjectUploader"
                                                data-hs-file-attach-options="{
                                  &quot;textTarget&quot;: &quot;#avatarNewProjectImg&quot;,
                                  &quot;mode&quot;: &quot;image&quot;,
                                  &quot;targetAttr&quot;: &quot;src&quot;,
                                  &quot;resetTarget&quot;: &quot;.js-file-attach-reset-img&quot;,
                                  &quot;resetImg&quot;: &quot;/template/assets/img/160x160/img1.jpg&quot;,
                                  &quot;allowTypes&quot;: [&quot;.png&quot;, &quot;.jpeg&quot;, &quot;.jpg&quot;]
                               }">

                                            <span class="avatar-uploader-trigger">
                                                <i class="bi-pencil-fill avatar-uploader-icon shadow-sm"></i>
                                            </span>
                                        </label>
                                        <!-- End Avatar -->

                                        <button type="button"
                                            class="js-file-attach-reset-img btn btn-white">Delete</button>
                                    </div>
                                </div>
                                <!-- End Form -->

                                <!-- Form -->
                                <div class="mb-4">
                                    <label for="clientNewProjectLabel" class="form-label">Client</label>

                                    <div class="row align-items-center">
                                        <div class="col-12 col-md-7 mb-3">
                                            <div class="input-group input-group-merge">
                                                <div class="input-group-prepend input-group-text">
                                                    <i class="bi-person-square"></i>
                                                </div>
                                                <input class="form-control" id="clientNewProjectLabel"
                                                    placeholder="Add creater name" aria-label="Add creater name">
                                            </div>
                                        </div>
                                        <!-- End Col -->

                                        <span class="col-auto mb-3">or</span>

                                        <div class="col-md mb-md-3">
                                            <a class="btn btn-white" href="javascript:;">
                                                <i class="tio-add me-1"></i>New client
                                            </a>
                                        </div>
                                        <!-- End Col -->
                                    </div>
                                    <!-- End Row -->
                                </div>
                                <!-- End Form -->

                                <!-- Form -->
                                <div class="mb-4">
                                    <label for="projectNameNewProjectLabel" class="form-label">Project name <i
                                            class="bi-question-circle text-body ms-1" data-toggle="tooltip"
                                            data-placement="top"
                                            title="Displayed on public forums, such as Front."></i></label>

                                    <div class="input-group input-group-merge">
                                        <div class="input-group-prepend input-group-text">
                                            <i class="bi-briefcase"></i>
                                        </div>
                                        <input type="text" class="form-control" name="projectName"
                                            id="projectNameNewProjectLabel" placeholder="Enter project name here"
                                            aria-label="Enter project name here">
                                    </div>
                                </div>
                                <!-- End Form -->

                                <!-- Quill -->
                                <div class="mb-4">
                                    <label class="form-label">Project description <span
                                            class="form-label-secondary">(Optional)</span></label>

                                    <!-- Quill -->
                                    <div class="quill-custom">
                                        <div class="ql-toolbar ql-snow"><span class="ql-formats"><button
                                                    type="button" class="ql-bold"><svg viewBox="0 0 18 18">
                                                        <path class="ql-stroke"
                                                            d="M5,4H9.5A2.5,2.5,0,0,1,12,6.5v0A2.5,2.5,0,0,1,9.5,9H5A0,0,0,0,1,5,9V4A0,0,0,0,1,5,4Z">
                                                        </path>
                                                        <path class="ql-stroke"
                                                            d="M5,9h5.5A2.5,2.5,0,0,1,13,11.5v0A2.5,2.5,0,0,1,10.5,14H5a0,0,0,0,1,0,0V9A0,0,0,0,1,5,9Z">
                                                        </path>
                                                    </svg></button><button type="button" class="ql-italic"><svg
                                                        viewBox="0 0 18 18">
                                                        <line class="ql-stroke" x1="7" x2="13"
                                                            y1="4" y2="4"></line>
                                                        <line class="ql-stroke" x1="5" x2="11"
                                                            y1="14" y2="14"></line>
                                                        <line class="ql-stroke" x1="8" x2="10"
                                                            y1="14" y2="4"></line>
                                                    </svg></button><button type="button" class="ql-underline"><svg
                                                        viewBox="0 0 18 18">
                                                        <path class="ql-stroke"
                                                            d="M5,3V9a4.012,4.012,0,0,0,4,4H9a4.012,4.012,0,0,0,4-4V3">
                                                        </path>
                                                        <rect class="ql-fill" height="1" rx="0.5"
                                                            ry="0.5" width="12" x="3"
                                                            y="15"></rect>
                                                    </svg></button><button type="button" class="ql-strike"><svg
                                                        viewBox="0 0 18 18">
                                                        <line class="ql-stroke ql-thin" x1="15.5" x2="2.5"
                                                            y1="8.5" y2="9.5"></line>
                                                        <path class="ql-fill"
                                                            d="M9.007,8C6.542,7.791,6,7.519,6,6.5,6,5.792,7.283,5,9,5c1.571,0,2.765.679,2.969,1.309a1,1,0,0,0,1.9-.617C13.356,4.106,11.354,3,9,3,6.2,3,4,4.538,4,6.5a3.2,3.2,0,0,0,.5,1.843Z">
                                                        </path>
                                                        <path class="ql-fill"
                                                            d="M8.984,10C11.457,10.208,12,10.479,12,11.5c0,0.708-1.283,1.5-3,1.5-1.571,0-2.765-.679-2.969-1.309a1,1,0,1,0-1.9.617C4.644,13.894,6.646,15,9,15c2.8,0,5-1.538,5-3.5a3.2,3.2,0,0,0-.5-1.843Z">
                                                        </path>
                                                    </svg></button><button type="button" class="ql-link"><svg
                                                        viewBox="0 0 18 18">
                                                        <line class="ql-stroke" x1="7" x2="11"
                                                            y1="7" y2="11"></line>
                                                        <path class="ql-even ql-stroke"
                                                            d="M8.9,4.577a3.476,3.476,0,0,1,.36,4.679A3.476,3.476,0,0,1,4.577,8.9C3.185,7.5,2.035,6.4,4.217,4.217S7.5,3.185,8.9,4.577Z">
                                                        </path>
                                                        <path class="ql-even ql-stroke"
                                                            d="M13.423,9.1a3.476,3.476,0,0,0-4.679-.36,3.476,3.476,0,0,0,.36,4.679c1.392,1.392,2.5,2.542,4.679.36S14.815,10.5,13.423,9.1Z">
                                                        </path>
                                                    </svg></button><button type="button" class="ql-image"><svg
                                                        viewBox="0 0 18 18">
                                                        <rect class="ql-stroke" height="10" width="12"
                                                            x="3" y="4"></rect>
                                                        <circle class="ql-fill" cx="6" cy="7"
                                                            r="1"></circle>
                                                        <polyline class="ql-even ql-fill"
                                                            points="5 12 5 11 7 9 8 10 11 7 13 9 13 12 5 12">
                                                        </polyline>
                                                    </svg></button><button type="button" class="ql-blockquote"><svg
                                                        viewBox="0 0 18 18">
                                                        <rect class="ql-fill ql-stroke" height="3" width="3"
                                                            x="4" y="5"></rect>
                                                        <rect class="ql-fill ql-stroke" height="3" width="3"
                                                            x="11" y="5"></rect>
                                                        <path class="ql-even ql-fill ql-stroke"
                                                            d="M7,8c0,4.031-3,5-3,5"></path>
                                                        <path class="ql-even ql-fill ql-stroke"
                                                            d="M14,8c0,4.031-3,5-3,5"></path>
                                                    </svg></button><button type="button" class="ql-code"><svg
                                                        viewBox="0 0 18 18">
                                                        <polyline class="ql-even ql-stroke" points="5 7 3 9 5 11">
                                                        </polyline>
                                                        <polyline class="ql-even ql-stroke" points="13 7 15 9 13 11">
                                                        </polyline>
                                                        <line class="ql-stroke" x1="10" x2="8"
                                                            y1="5" y2="13"></line>
                                                    </svg></button><button type="button" class="ql-list"
                                                    value="bullet"><svg viewBox="0 0 18 18">
                                                        <line class="ql-stroke" x1="6" x2="15"
                                                            y1="4" y2="4"></line>
                                                        <line class="ql-stroke" x1="6" x2="15"
                                                            y1="9" y2="9"></line>
                                                        <line class="ql-stroke" x1="6" x2="15"
                                                            y1="14" y2="14"></line>
                                                        <line class="ql-stroke" x1="3" x2="3"
                                                            y1="4" y2="4"></line>
                                                        <line class="ql-stroke" x1="3" x2="3"
                                                            y1="9" y2="9"></line>
                                                        <line class="ql-stroke" x1="3" x2="3"
                                                            y1="14" y2="14"></line>
                                                    </svg></button></span></div>
                                        <div class="js-quill ql-container ql-snow hs-quill-initialized"
                                            style="height: 15rem;"
                                            data-hs-quill-options="{
                           &quot;placeholder&quot;: &quot;Type your message...&quot;,
                            &quot;modules&quot;: {
                              &quot;toolbar&quot;: [
                                [&quot;bold&quot;, &quot;italic&quot;, &quot;underline&quot;, &quot;strike&quot;, &quot;link&quot;, &quot;image&quot;, &quot;blockquote&quot;, &quot;code&quot;, {&quot;list&quot;: &quot;bullet&quot;}]
                              ]
                            }
                           }">
                                            <div class="ql-editor ql-blank" data-gramm="false" contenteditable="true"
                                                data-placeholder="Type your message...">
                                                <p><br></p>
                                            </div>
                                            <div class="ql-clipboard" contenteditable="true" tabindex="-1"></div>
                                            <div class="ql-tooltip ql-hidden"><a class="ql-preview"
                                                    rel="noopener noreferrer" target="_blank"
                                                    href="about:blank"></a><input type="text"
                                                    data-formula="e=mc^2" data-link="https://quilljs.com"
                                                    data-video="Embed URL"><a class="ql-action"></a><a
                                                    class="ql-remove"></a></div>
                                        </div>
                                    </div>
                                    <!-- End Quill -->
                                </div>
                                <!-- End Quill -->

                                <div class="row">
                                    <div class="col-sm-6">
                                        <!-- Form -->
                                        <div class="mb-4">
                                            <label for="projectDeadlineNewProjectLabel" class="form-label">Due
                                                date</label>

                                            <div id="projectDeadlineNewProject" class="input-group input-group-merge">
                                                <div class="input-group-prepend input-group-text">
                                                    <i class="bi-calendar-week"></i>
                                                </div>

                                                <input type="text" class="form-control"
                                                    id="projectDeadlineNewProjectLabel" placeholder="Select dates">
                                            </div>
                                        </div>
                                        <!-- End Form -->
                                    </div>
                                    <!-- End Col -->

                                    <div class="col-sm-6">
                                        <!-- Form -->
                                        <div class="mb-4">
                                            <label for="ownerNewProjectLabel-ts-control" class="form-label"
                                                id="ownerNewProjectLabel-ts-label">Owner</label>

                                            <!-- Select -->
                                            <div class="tom-select-custom">
                                                <select class="js-select form-select tomselected ts-hidden-accessible"
                                                    id="ownerNewProjectLabel"
                                                    data-hs-tom-select-options="{
                                    &quot;searchInDropdown&quot;: false,
                                    &quot;hideSearch&quot;: true
                                  }"
                                                    tabindex="-1">
                                                    <option value="owner1"
                                                        data-option-template="<span class=&quot;d-flex align-items-center&quot;><img class=&quot;avatar avatar-xss avatar-circle&quot; src=&quot;/template/assets/img/160x160/img6.jpg&quot; alt=&quot;Avatar&quot; /><span class=&quot;flex-grow-1 ms-2&quot;>Mark Williams</span></span>">
                                                        Mark Williams</option>
                                                    <option value="owner2"
                                                        data-option-template="<span class=&quot;d-flex align-items-center&quot;><img class=&quot;avatar avatar-xss avatar-circle&quot; src=&quot;/template/assets/img/160x160/img10.jpg&quot; alt=&quot;Avatar&quot; /><span class=&quot;flex-grow-1 ms-2&quot;>Amanda Harvey</span></span>">
                                                        Amanda Harvey</option>

                                                    <option value="owner3" selected=""
                                                        data-option-template="<span class=&quot;d-flex align-items-center&quot;><i class=&quot;bi-person text-body&quot;></i><span class=&quot;flex-grow-1 ms-2&quot;>Assign to owner</span></span>">
                                                        Assign to owner</option>
                                                </select>
                                                <div
                                                    class="ts-wrapper js-select form-select single plugin-change_listener plugin-hs_smart_position input-hidden full has-items">
                                                    <div class="ts-control"><span
                                                            class="d-flex align-items-center item" data-value="owner3"
                                                            data-ts-item=""><i class="bi-person text-body"></i><span
                                                                class="flex-grow-1 ms-2">Assign to owner</span></span>
                                                    </div>
                                                    <div class="tom-select-custom">
                                                        <div class="ts-dropdown single plugin-change_listener plugin-hs_smart_position"
                                                            style="display: none;">
                                                            <div role="listbox" tabindex="-1"
                                                                class="ts-dropdown-content"
                                                                id="ownerNewProjectLabel-ts-dropdown"
                                                                aria-labelledby="ownerNewProjectLabel-ts-label"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Select -->
                                        </div>
                                        <!-- End Form -->
                                    </div>
                                    <!-- End Col -->
                                </div>
                                <!-- End Row -->

                                <!-- Form -->
                                <div class="mb-4">
                                    <label class="form-label">Attach files</label>

                                    <!-- Dropzone -->
                                    <div id="attachFilesNewProjectLabel"
                                        class="js-dropzone dz-dropzone dz-dropzone-card dz-clickable">
                                        <div class="dz-message">
                                            <img class="avatar avatar-xl avatar-4x3 mb-3"
                                                src="/template/assets/svg/illustrations/oc-browse.svg"
                                                alt="Image Description" data-hs-theme-appearance="default">
                                            <img class="avatar avatar-xl avatar-4x3 mb-3"
                                                src="/template/assets/svg/illustrations-light/oc-browse.svg"
                                                alt="Image Description" data-hs-theme-appearance="dark">

                                            <h5>Drag and drop your file here</h5>

                                            <p class="mb-2">or</p>

                                            <span class="btn btn-white btn-sm">Browse files</span>
                                        </div>
                                    </div>
                                    <!-- End Dropzone -->
                                </div>
                                <!-- End Form -->

                                <label class="form-label">Default view</label>

                                <div class="input-group input-group-md-vertical">
                                    <!-- Radio Check -->
                                    <label class="form-control" for="projectViewNewProjectTypeRadio1">
                                        <span class="form-check form-check-reverse">
                                            <input type="radio" class="form-check-input"
                                                name="projectViewNewProjectTypeRadio"
                                                id="projectViewNewProjectTypeRadio1">
                                            <span class="form-check-label"><i
                                                    class="bi-view-list text-muted me-2"></i> List</span>
                                        </span>
                                    </label>
                                    <!-- End Radio Check -->

                                    <!-- Radio Check -->
                                    <label class="form-control" for="projectViewNewProjectTypeRadio2">
                                        <span class="form-check form-check-reverse">
                                            <input type="radio" class="form-check-input"
                                                name="projectViewNewProjectTypeRadio"
                                                id="projectViewNewProjectTypeRadio2" checked="">
                                            <span class="form-check-label"><i class="bi-table text-muted me-2"></i>
                                                Table</span>
                                        </span>
                                    </label>
                                    <!-- End Radio Check -->

                                    <!-- Radio Check -->
                                    <label class="form-control" for="projectViewNewProjectTypeRadio3">
                                        <span class="form-check form-check-reverse">
                                            <input type="radio" class="form-check-input"
                                                name="projectViewNewProjectTypeRadio"
                                                id="projectViewNewProjectTypeRadio3" disabled="">
                                            <span class="form-check-label">Timeline</span>
                                            <span class="badge bg-soft-primary text-primary rounded-pill">Coming
                                                soon...</span>
                                        </span>
                                    </label>
                                    <!-- End Radio Check -->
                                </div>

                                <!-- Footer -->
                                <div class="d-flex align-items-center mt-5">
                                    <div class="ms-auto">
                                        <button type="button" class="btn btn-primary"
                                            data-hs-step-form-next-options="{
                                &quot;targetSelector&quot;: &quot;#createProjectStepTerms&quot;
                              }">
                                            Next <i class="bi-chevron-right"></i>
                                        </button>
                                    </div>
                                </div>
                                <!-- End Footer -->
                            </div>

                            <div id="createProjectStepTerms" style="display: none;">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <!-- Form -->
                                        <div class="mb-4">
                                            <label for="paymentTermsNewProjectLabel-ts-control" class="form-label"
                                                id="paymentTermsNewProjectLabel-ts-label">Terms</label>

                                            <!-- Select -->
                                            <div class="tom-select-custom">
                                                <select class="js-select form-select tomselected ts-hidden-accessible"
                                                    id="paymentTermsNewProjectLabel"
                                                    data-hs-tom-select-options="{
                                    &quot;searchInDropdown&quot;: false,
                                    &quot;hideSearch&quot;: true
                                  }"
                                                    tabindex="-1">

                                                    <option value="Per hour">Per hour</option>
                                                    <option value="Per day">Per day</option>
                                                    <option value="Per week">Per week</option>
                                                    <option value="Per month">Per month</option>
                                                    <option value="Per quarter">Per quarter</option>
                                                    <option value="Per year">Per year</option>
                                                    <option value="fixed" selected="">Fixed</option>
                                                </select>
                                                <div
                                                    class="ts-wrapper js-select form-select single plugin-change_listener plugin-hs_smart_position input-hidden full has-items">
                                                    <div class="ts-control">
                                                        <div data-value="fixed" class="item" data-ts-item="">
                                                            Fixed</div>
                                                    </div>
                                                    <div class="tom-select-custom">
                                                        <div class="ts-dropdown single plugin-change_listener plugin-hs_smart_position"
                                                            style="display: none;">
                                                            <div role="listbox" tabindex="-1"
                                                                class="ts-dropdown-content"
                                                                id="paymentTermsNewProjectLabel-ts-dropdown"
                                                                aria-labelledby="paymentTermsNewProjectLabel-ts-label">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Select -->
                                        </div>
                                        <!-- End Form -->
                                    </div>
                                    <!-- End Col -->

                                    <div class="col-sm-6">
                                        <label for="expectedValueNewProjectLabel" class="form-label">Expected
                                            value</label>

                                        <!-- Form -->
                                        <div class="mb-4">
                                            <div class="input-group input-group-merge">
                                                <div class="input-group-prepend input-group-text">
                                                    <i class="bi-currency-dollar"></i>
                                                </div>
                                                <input type="text" class="form-control" name="expectedValue"
                                                    id="expectedValueNewProjectLabel" placeholder="Enter value here"
                                                    aria-label="Enter value here">
                                            </div>
                                        </div>
                                        <!-- End Form -->
                                    </div>
                                    <!-- End Col -->
                                </div>
                                <!-- End Form Row -->

                                <div class="row">
                                    <div class="col-lg-6">
                                        <!-- Form -->
                                        <div class="mb-4">
                                            <label for="milestoneNewProjectLabel-ts-control" class="form-label"
                                                id="milestoneNewProjectLabel-ts-label">Milestone <a class="small ms-1"
                                                    href="javascript:;">Change
                                                    probability</a></label>

                                            <!-- Select -->
                                            <div class="tom-select-custom">
                                                <select class="js-select form-select tomselected ts-hidden-accessible"
                                                    id="milestoneNewProjectLabel"
                                                    data-hs-tom-select-options="{
                                    &quot;searchInDropdown&quot;: false,
                                    &quot;hideSearch&quot;: true
                                  }"
                                                    tabindex="-1">

                                                    <option value="Qualified">Qualified</option>
                                                    <option value="Meeting">Meeting</option>
                                                    <option value="Proposal">Proposal</option>
                                                    <option value="Negotiation">Negotiation</option>
                                                    <option value="Contact">Contact</option>
                                                    <option value="New">New</option>
                                                </select>
                                                <div
                                                    class="ts-wrapper js-select form-select single plugin-change_listener plugin-hs_smart_position input-hidden full has-items">
                                                    <div class="ts-control">
                                                        <div data-value="New" class="item" data-ts-item="">New
                                                        </div>
                                                    </div>
                                                    <div class="tom-select-custom">
                                                        <div class="ts-dropdown single plugin-change_listener plugin-hs_smart_position"
                                                            style="display: none;">
                                                            <div role="listbox" tabindex="-1"
                                                                class="ts-dropdown-content"
                                                                id="milestoneNewProjectLabel-ts-dropdown"
                                                                aria-labelledby="milestoneNewProjectLabel-ts-label">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Select -->
                                        </div>
                                        <!-- End Form -->
                                    </div>
                                    <!-- End Col -->

                                    <div class="col-lg-6">
                                        <!-- Form -->
                                        <div class="mb-4">
                                            <label for="privacyNewProjectLabel-ts-control" class="form-label me-2"
                                                id="privacyNewProjectLabel-ts-label">Privacy</label>

                                            <!-- Select -->
                                            <div class="tom-select-custom">
                                                <select class="js-select form-select tomselected ts-hidden-accessible"
                                                    id="privacyNewProjectLabel"
                                                    data-hs-tom-select-options="{
                                    &quot;searchInDropdown&quot;: false,
                                    &quot;hideSearch&quot;: true
                                  }"
                                                    tabindex="-1">

                                                    <option value="privacy2" disabled=""
                                                        data-option-template="<span class=&quot;d-flex&quot;><i class=&quot;bi-lock fs2 text-body&quot;></i><span class=&quot;flex-grow-1 ms-2&quot;><span class=&quot;d-block&quot;>Private to project members <span class=&quot;badge bg-soft-primary text-primary&quot;>Upgrade to Premium</span></span><small class=&quot;tom-select-custom-hide&quot;>Only visible to project members</small></span></span>">
                                                        Private to project members</option>
                                                    <option value="privacy3"
                                                        data-option-template="<span class=&quot;d-flex&quot;><i class=&quot;bi-person fs2 text-body&quot;></i><span class=&quot;flex-grow-1 ms-2&quot;><span class=&quot;d-block&quot;>Private to me</span><small class=&quot;tom-select-custom-hide&quot;>Only visible to you</small></span></span>">
                                                        Private to me</option>
                                                    <option value="privacy1"
                                                        data-option-template="<span class=&quot;d-flex&quot;><i class=&quot;bi-people fs2 text-body&quot;></i><span class=&quot;flex-grow-1 ms-2&quot;><span class=&quot;d-block&quot;>Everyone</span><small class=&quot;tom-select-custom-hide&quot;>Public to Front Dashboard</small></span></span>">
                                                        Everyone</option>
                                                </select>
                                                <div
                                                    class="ts-wrapper js-select form-select single plugin-change_listener plugin-hs_smart_position input-hidden full has-items">
                                                    <div class="ts-control"><span class="d-flex item"
                                                            data-value="privacy1" data-ts-item=""><i
                                                                class="bi-people fs2 text-body"></i><span
                                                                class="flex-grow-1 ms-2"><span
                                                                    class="d-block">Everyone</span><small
                                                                    class="tom-select-custom-hide">Public to Front
                                                                    Dashboard</small></span></span></div>
                                                    <div class="tom-select-custom">
                                                        <div class="ts-dropdown single plugin-change_listener plugin-hs_smart_position"
                                                            style="display: none;">
                                                            <div role="listbox" tabindex="-1"
                                                                class="ts-dropdown-content"
                                                                id="privacyNewProjectLabel-ts-dropdown"
                                                                aria-labelledby="privacyNewProjectLabel-ts-label">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Select -->
                                        </div>
                                        <!-- End Form -->
                                    </div>
                                    <!-- End Col -->
                                </div>
                                <!-- End Form Row -->

                                <div class="d-grid gap-2">
                                    <!-- Check -->
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                            id="budgetNewProjectCheckbox">
                                        <label class="form-check-label" for="budgetNewProjectCheckbox">
                                            Budget resets every month
                                        </label>
                                    </div>
                                    <!-- End Check -->

                                    <!-- Check -->
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                            id="emailAlertNewProjectCheckbox" checked="">
                                        <label class="form-check-label" for="emailAlertNewProjectCheckbox">
                                            Send email alerts if project exceeds <span
                                                class="font-weight-bold">50.00%</span> of budget
                                        </label>
                                    </div>
                                    <!-- End Check -->
                                </div>

                                <!-- Footer -->
                                <div class="d-flex align-items-center mt-5">
                                    <button type="button" class="btn btn-ghost-secondary me-2"
                                        data-hs-step-form-prev-options="{
                         &quot;targetSelector&quot;: &quot;#createProjectStepDetails&quot;
                       }">
                                        <i class="bi-chevron-left"></i> Previous step
                                    </button>

                                    <div class="ms-auto">
                                        <button type="button" class="btn btn-primary"
                                            data-hs-step-form-next-options="{
                                &quot;targetSelector&quot;: &quot;#createProjectStepMembers&quot;
                              }">
                                            Next <i class="bi-chevron-right"></i>
                                        </button>
                                    </div>
                                </div>
                                <!-- End Footer -->
                            </div>

                            <div id="createProjectStepMembers" style="display: none;">
                                <!-- Form -->
                                <div class="mb-4">
                                    <div class="input-group mb-2 mb-sm-0">
                                        <input type="text" class="form-control" name="fullName"
                                            placeholder="Search name or emails" aria-label="Search name or emails">

                                        <div class="input-group-append input-group-append-last-sm-down-none">
                                            <!-- Select -->
                                            <div class="tom-select-custom tom-select-custom-end">
                                                <select
                                                    class="js-select form-select tom-select-custom-form-select-invite-user tomselected ts-hidden-accessible"
                                                    autocomplete="off"
                                                    data-hs-tom-select-options="{
                                    &quot;searchInDropdown&quot;: false,
                                    &quot;hideSearch&quot;: true,
                                    &quot;dropdownWidth&quot;: &quot;11rem&quot;
                                  }"
                                                    id="tomselect-14" tabindex="-1">

                                                    <option value="can edit">Can edit</option>
                                                    <option value="can comment">Can comment</option>
                                                    <option value="full access">Full access</option>
                                                    <option value="guest" selected="">Guest</option>
                                                </select>
                                                <div
                                                    class="ts-wrapper js-select form-select tom-select-custom-form-select-invite-user single plugin-change_listener plugin-hs_smart_position input-hidden full has-items">
                                                    <div class="ts-control">
                                                        <div data-value="guest" class="item" data-ts-item="">
                                                            Guest</div>
                                                    </div>
                                                    <div class="tom-select-custom">
                                                        <div class="ts-dropdown single plugin-change_listener plugin-hs_smart_position"
                                                            style="display: none;">
                                                            <div role="listbox" tabindex="-1"
                                                                class="ts-dropdown-content"
                                                                id="tomselect-14-ts-dropdown"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Select -->

                                            <a class="btn btn-primary d-none d-sm-inline-block"
                                                href="javascript:;">Invite</a>
                                        </div>
                                    </div>

                                    <a class="btn btn-primary w-100 d-sm-none" href="javascript:;">Invite</a>
                                </div>
                                <!-- End Form -->

                                <ul class="list-unstyled list-py-3 mb-5">
                                    <!-- List Group Item -->
                                    <li>
                                        <div class="d-flex">
                                            <div class="flex-shrink-0">
                                                <span class="icon icon-soft-dark icon-sm icon-circle">
                                                    <i class="bi-people-fill"></i>
                                                </span>
                                            </div>

                                            <div class="flex-grow-1 ms-3">
                                                <div class="row align-items-center">
                                                    <div class="col-sm">
                                                        <h5 class="text-body mb-0">#digitalmarketing</h5>
                                                        <span class="d-block fs-6">8 members</span>
                                                    </div>
                                                    <!-- End Col -->

                                                    <div class="col-sm-auto">
                                                        <!-- Select -->
                                                        <div class="tom-select-custom tom-select-custom-sm-end">
                                                            <select
                                                                class="js-select form-select form-select-borderless tom-select-custom-form-select-invite-user tom-select-form-select-ps-0 tomselected ts-hidden-accessible"
                                                                autocomplete="off"
                                                                data-hs-tom-select-options="{
                                          &quot;searchInDropdown&quot;: false,
                                          &quot;hideSearch&quot;: true,
                                          &quot;dropdownWidth&quot;: &quot;11rem&quot;
                                        }"
                                                                id="tomselect-15" tabindex="-1">

                                                                <option value="can edit">Can edit</option>
                                                                <option value="can comment">Can comment</option>
                                                                <option value="full access">Full access</option>
                                                                <option value="remove"
                                                                    data-option-template="<div class=&quot;text-danger&quot;>Remove</div>">
                                                                    Remove</option>
                                                                <option value="guest" selected="">Guest</option>
                                                            </select>
                                                            <div
                                                                class="ts-wrapper js-select form-select form-select-borderless tom-select-custom-form-select-invite-user tom-select-form-select-ps-0 single plugin-change_listener plugin-hs_smart_position input-hidden full has-items">
                                                                <div class="ts-control">
                                                                    <div data-value="guest" class="item"
                                                                        data-ts-item="">Guest</div>
                                                                </div>
                                                                <div class="tom-select-custom">
                                                                    <div class="ts-dropdown single plugin-change_listener plugin-hs_smart_position"
                                                                        style="display: none;">
                                                                        <div role="listbox" tabindex="-1"
                                                                            class="ts-dropdown-content"
                                                                            id="tomselect-15-ts-dropdown"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- End Select -->
                                                    </div>
                                                    <!-- End Col -->
                                                </div>
                                                <!-- End Row -->
                                            </div>
                                        </div>
                                    </li>
                                    <!-- End List Group Item -->

                                    <!-- List Group Item -->
                                    <li>
                                        <div class="d-flex">
                                            <div class="flex-shrink-0">
                                                <div class="avatar avatar-sm avatar-circle">
                                                    <img class="avatar-img"
                                                        src="/template/assets/img/160x160/img3.jpg"
                                                        alt="Image Description">
                                                </div>
                                            </div>

                                            <div class="flex-grow-1 ms-3">
                                                <div class="row align-items-center">
                                                    <div class="col-sm">
                                                        <h5 class="text-body mb-0">David Harrison</h5>
                                                        <span class="d-block fs-6">david@site.com</span>
                                                    </div>
                                                    <!-- End Col -->

                                                    <div class="col-sm-auto">
                                                        <!-- Select -->
                                                        <div class="tom-select-custom tom-select-custom-sm-end">
                                                            <select
                                                                class="js-select form-select form-select-borderless tom-select-custom-form-select-invite-user tom-select-form-select-ps-0 tomselected ts-hidden-accessible"
                                                                autocomplete="off"
                                                                data-hs-tom-select-options="{
                                          &quot;searchInDropdown&quot;: false,
                                          &quot;hideSearch&quot;: true,
                                          &quot;dropdownWidth&quot;: &quot;11rem&quot;
                                        }"
                                                                id="tomselect-16" tabindex="-1">

                                                                <option value="can edit">Can edit</option>
                                                                <option value="can comment">Can comment</option>
                                                                <option value="full access">Full access</option>
                                                                <option value="remove"
                                                                    data-option-template="<div class=&quot;text-danger&quot;>Remove</div>">
                                                                    Remove</option>
                                                                <option value="guest" selected="">Guest</option>
                                                            </select>
                                                            <div
                                                                class="ts-wrapper js-select form-select form-select-borderless tom-select-custom-form-select-invite-user tom-select-form-select-ps-0 single plugin-change_listener plugin-hs_smart_position input-hidden full has-items">
                                                                <div class="ts-control">
                                                                    <div data-value="guest" class="item"
                                                                        data-ts-item="">Guest</div>
                                                                </div>
                                                                <div class="tom-select-custom">
                                                                    <div class="ts-dropdown single plugin-change_listener plugin-hs_smart_position"
                                                                        style="display: none;">
                                                                        <div role="listbox" tabindex="-1"
                                                                            class="ts-dropdown-content"
                                                                            id="tomselect-16-ts-dropdown"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- End Select -->
                                                    </div>
                                                    <!-- End Col -->
                                                </div>
                                                <!-- End Row -->
                                            </div>
                                        </div>
                                    </li>
                                    <!-- End List Group Item -->

                                    <!-- List Group Item -->
                                    <li>
                                        <div class="d-flex">
                                            <div class="flex-shrink-0">
                                                <div class="avatar avatar-sm avatar-circle">
                                                    <img class="avatar-img"
                                                        src="/template/assets/img/160x160/img9.jpg"
                                                        alt="Image Description">
                                                </div>
                                            </div>

                                            <div class="flex-grow-1 ms-3">
                                                <div class="row align-items-center">
                                                    <div class="col-sm">
                                                        <h5 class="text-body mb-0">Ella Lauda <i
                                                                class="tio-verified text-primary"
                                                                data-toggle="tooltip" data-placement="top"
                                                                title="Top endorsed"></i></h5>
                                                        <span class="d-block fs-6">Markvt@site.com</span>
                                                    </div>
                                                    <!-- End Col -->

                                                    <div class="col-sm-auto">
                                                        <!-- Select -->
                                                        <div class="tom-select-custom tom-select-custom-sm-end">
                                                            <select
                                                                class="js-select form-select form-select-borderless tom-select-custom-form-select-invite-user tom-select-form-select-ps-0 tomselected ts-hidden-accessible"
                                                                autocomplete="off"
                                                                data-hs-tom-select-options="{
                                          &quot;searchInDropdown&quot;: false,
                                          &quot;hideSearch&quot;: true,
                                          &quot;dropdownWidth&quot;: &quot;11rem&quot;
                                        }"
                                                                id="tomselect-17" tabindex="-1">

                                                                <option value="can edit">Can edit</option>
                                                                <option value="can comment">Can comment</option>
                                                                <option value="full access">Full access</option>
                                                                <option value="remove"
                                                                    data-option-template="<div class=&quot;text-danger&quot;>Remove</div>">
                                                                    Remove</option>
                                                                <option value="guest" selected="">Guest</option>
                                                            </select>
                                                            <div
                                                                class="ts-wrapper js-select form-select form-select-borderless tom-select-custom-form-select-invite-user tom-select-form-select-ps-0 single plugin-change_listener plugin-hs_smart_position input-hidden full has-items">
                                                                <div class="ts-control">
                                                                    <div data-value="guest" class="item"
                                                                        data-ts-item="">Guest</div>
                                                                </div>
                                                                <div class="tom-select-custom">
                                                                    <div class="ts-dropdown single plugin-change_listener plugin-hs_smart_position"
                                                                        style="display: none;">
                                                                        <div role="listbox" tabindex="-1"
                                                                            class="ts-dropdown-content"
                                                                            id="tomselect-17-ts-dropdown"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- End Select -->
                                                    </div>
                                                    <!-- End Col -->
                                                </div>
                                                <!-- End Row -->
                                            </div>
                                        </div>
                                    </li>
                                    <!-- End List Group Item -->

                                    <!-- List Group Item -->
                                    <li>
                                        <div class="d-flex">
                                            <div class="flex-shrink-0">
                                                <span class="icon icon-soft-dark icon-sm icon-circle">
                                                    <i class="bi-people-fill"></i>
                                                </span>
                                            </div>

                                            <div class="flex-grow-1 ms-3">
                                                <div class="row align-items-center">
                                                    <div class="col-sm">
                                                        <h5 class="text-body mb-0">#conference</h5>
                                                        <span class="d-block fs-6">3 members</span>
                                                    </div>
                                                    <!-- End Col -->

                                                    <div class="col-sm-auto">
                                                        <!-- Select -->
                                                        <div class="tom-select-custom tom-select-custom-sm-end">
                                                            <select
                                                                class="js-select form-select form-select-borderless tom-select-custom-form-select-invite-user tom-select-form-select-ps-0 tomselected ts-hidden-accessible"
                                                                autocomplete="off"
                                                                data-hs-tom-select-options="{
                                          &quot;searchInDropdown&quot;: false,
                                          &quot;hideSearch&quot;: true,
                                          &quot;dropdownWidth&quot;: &quot;11rem&quot;
                                        }"
                                                                id="tomselect-18" tabindex="-1">

                                                                <option value="can edit">Can edit</option>
                                                                <option value="can comment">Can comment</option>
                                                                <option value="full access">Full access</option>
                                                                <option value="remove"
                                                                    data-option-template="<div class=&quot;text-danger&quot;>Remove</div>">
                                                                    Remove</option>
                                                                <option value="guest" selected="">Guest</option>
                                                            </select>
                                                            <div
                                                                class="ts-wrapper js-select form-select form-select-borderless tom-select-custom-form-select-invite-user tom-select-form-select-ps-0 single plugin-change_listener plugin-hs_smart_position input-hidden full has-items">
                                                                <div class="ts-control">
                                                                    <div data-value="guest" class="item"
                                                                        data-ts-item="">Guest</div>
                                                                </div>
                                                                <div class="tom-select-custom">
                                                                    <div class="ts-dropdown single plugin-change_listener plugin-hs_smart_position"
                                                                        style="display: none;">
                                                                        <div role="listbox" tabindex="-1"
                                                                            class="ts-dropdown-content"
                                                                            id="tomselect-18-ts-dropdown"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- End Select -->
                                                    </div>
                                                    <!-- End Col -->
                                                </div>
                                                <!-- End Row -->
                                            </div>
                                        </div>
                                    </li>
                                    <!-- End List Group Item -->
                                </ul>

                                <div class="d-grid gap-3">
                                    <!-- Form Switch -->
                                    <label class="row form-check form-switch"
                                        for="addTeamPreferencesNewProjectSwitch1">
                                        <span class="col-8 col-sm-9 ms-0">
                                            <i class="bi-bell text-primary me-3"></i>
                                            <span class="text-dark">Inform all project members</span>
                                        </span>
                                        <span class="col-4 col-sm-3 text-end">
                                            <input type="checkbox" class="form-check-input"
                                                id="addTeamPreferencesNewProjectSwitch1" checked="">
                                        </span>
                                    </label>
                                    <!-- End Form Switch -->

                                    <!-- Form Switch -->
                                    <label class="row form-check form-switch"
                                        for="addTeamPreferencesNewProjectSwitch2">
                                        <span class="col-8 col-sm-9 ms-0">
                                            <i class="bi-chat-left-dots text-primary me-3"></i>
                                            <span class="text-dark">Show team activity</span>
                                        </span>
                                        <span class="col-4 col-sm-3 text-end">
                                            <input type="checkbox" class="form-check-input"
                                                id="addTeamPreferencesNewProjectSwitch2">
                                        </span>
                                    </label>
                                    <!-- End Form Switch -->
                                </div>

                                <!-- Footer -->
                                <div class="d-sm-flex align-items-center mt-5">
                                    <button type="button" class="btn btn-ghost-secondary mb-3 mb-sm-0 me-2"
                                        data-hs-step-form-prev-options="{
                         &quot;targetSelector&quot;: &quot;#createProjectStepTerms&quot;
                       }">
                                        <i class="bi-chevron-left"></i> Previous step
                                    </button>

                                    <div class="d-flex justify-content-end gap-3 ms-auto">
                                        <button type="button" class="btn btn-white" data-bs-dismiss="modal"
                                            aria-label="Close">Cancel</button>
                                        <button id="createProjectFinishBtn" type="button"
                                            class="btn btn-primary">Create project</button>
                                    </div>
                                </div>
                                <!-- End Footer -->
                            </div>
                        </div>
                        <!-- End Content Step Form -->

                        <!-- Message Body -->
                        <div id="createProjectStepSuccessMessage" style="display:none;">
                            <div class="text-center">
                                <img class="img-fluid mb-3" src="/template/assets/svg/illustrations/oc-hi-five.svg"
                                    alt="Image Description" data-hs-theme-appearance="default"
                                    style="max-width: 15rem;">
                                <img class="img-fluid mb-3"
                                    src="/template/assets/svg/illustrations-light/oc-hi-five.svg"
                                    alt="Image Description" data-hs-theme-appearance="dark"
                                    style="max-width: 15rem;">

                                <div class="mb-4">
                                    <h2>Successful!</h2>
                                    <p>New project has been successfully created.</p>
                                </div>

                                <div class="d-flex justify-content-center gap-3">
                                    <a class="btn btn-white" href="/projects.html">
                                        <i class="bi-chevron-left"></i> Back to projects
                                    </a>

                                    <a class="btn btn-primary" href="javascript:;" data-toggle="modal"
                                        data-target="#newProjectModal">
                                        <i class="bi-building"></i> Add new project
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- End Message Body -->
                    </form>
                    <!-- End Step Form -->
                </div>
                <!-- End Body -->
            </div>
        </div>
    </div>

    <!-- End New Project Modal -->
    <!-- ========== END SECONDARY CONTENTS ========== -->

    <!-- JS Global Compulsory  -->
    <script src="/template/assets/vendor/jquery/dist/jquery.min.js"></script>
    <script src="/template/assets/vendor/jquery-migrate/dist/jquery-migrate.min.js"></script>
    <script src="/template/assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JS Implementing Plugins -->
    <script src="/template/assets/vendor/hs-navbar-vertical-aside/dist/hs-navbar-vertical-aside.min.js"></script>
    <script src="/template/assets/vendor/hs-form-search/dist/hs-form-search.min.js"></script>

    <script src="/template/assets/vendor/hs-toggle-password/dist/js/hs-toggle-password.js"></script>
    <script src="/template/assets/vendor/hs-file-attach/dist/hs-file-attach.min.js"></script>
    <script src="/template/assets/vendor/hs-step-form/dist/hs-step-form.min.js"></script>
    <script src="/template/assets/vendor/tom-select/dist/js/tom-select.complete.min.js"></script>
    <script src="/template/assets/vendor/quill/dist/quill.min.js"></script>
    <script src="/template/assets/vendor/dropzone/dist/min/dropzone.min.js"></script>
    <script src="/template/assets/vendor/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="/template/assets/vendor/datatables.net.extensions/select/select.min.js"></script>
    <script src="/template/assets/vendor/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="/template/assets/vendor/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="/template/assets/vendor/jszip/dist/jszip.min.js"></script>
    <script src="/template/assets/vendor/pdfmake/build/pdfmake.min.js"></script>
    <script src="/template/assets/vendor/pdfmake/build/vfs_fonts.js"></script>
    <script src="/template/assets/vendor/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="/template/assets/vendor/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="/template/assets/vendor/datatables.net-buttons/js/buttons.colVis.min.js"></script>

    <!-- JS Front -->
    <script src="/template/assets/js/theme.min.js"></script>

    <!-- JS Plugins Init. -->
    <script>
        $(document).on('ready', function() {
            // INITIALIZATION OF DATATABLES
            // =======================================================
            HSCore.components.HSDatatables.init($('#datatable'), {
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'copy',
                        className: 'd-none'
                    },
                    {
                        extend: 'excel',
                        className: 'd-none'
                    },
                    {
                        extend: 'csv',
                        className: 'd-none'
                    },
                    {
                        extend: 'pdf',
                        className: 'd-none'
                    },
                    {
                        extend: 'print',
                        className: 'd-none'
                    },
                ],
                select: {
                    style: 'multi',
                    selector: 'td:first-child input[type="checkbox"]',
                    classMap: {
                        checkAll: '#datatableCheckAll',
                        counter: '#datatableCounter',
                        counterInfo: '#datatableCounterInfo'
                    }
                },
                language: {
                    zeroRecords: `<div class="text-center p-4">
                <img class="mb-3" src="/template/assets/svg/illustrations/oc-error.svg" alt="Image Description" style="width: 10rem;" data-hs-theme-appearance="default">
                <img class="mb-3" src="/template/assets/svg/illustrations-light/oc-error.svg" alt="Image Description" style="width: 10rem;" data-hs-theme-appearance="dark">
              <p class="mb-0">No data to show</p>
              </div>`
                }
            });

            const datatable = HSCore.components.HSDatatables.getItem(0)

            $('#export-copy').click(function() {
                datatable.button('.buttons-copy').trigger()
            });

            $('#export-excel').click(function() {
                datatable.button('.buttons-excel').trigger()
            });

            $('#export-csv').click(function() {
                datatable.button('.buttons-csv').trigger()
            });

            $('#export-pdf').click(function() {
                datatable.button('.buttons-pdf').trigger()
            });

            $('#export-print').click(function() {
                datatable.button('.buttons-print').trigger()
            });

            $('.js-datatable-filter').on('change', function() {
                var $this = $(this),
                    elVal = $this.val(),
                    targetColumnIndex = $this.data('target-column-index');

                datatable.column(targetColumnIndex).search(elVal).draw();
            });
        });
    </script>

    <!-- JS Plugins Init. -->
    <script>
        (function() {
            window.onload = function() {


                // INITIALIZATION OF NAVBAR VERTICAL ASIDE
                // =======================================================
                new HSSideNav('.js-navbar-vertical-aside').init()


                // INITIALIZATION OF FORM SEARCH
                // =======================================================
                new HSFormSearch('.js-form-search')


                // INITIALIZATION OF BOOTSTRAP DROPDOWN
                // =======================================================
                HSBsDropdown.init()


                // INITIALIZATION OF SELECT
                // =======================================================
                HSCore.components.HSTomSelect.init('.js-select')


                // INITIALIZATION OF FILE ATTACHMENT
                // =======================================================
                new HSFileAttach('.js-file-attach')


                // INITIALIZATION OF QUILLJS EDITOR
                // =======================================================
                HSCore.components.HSQuill.init('.js-quill')


                // INITIALIZATION OF DROPZONE
                // =======================================================
                HSCore.components.HSDropzone.init('.js-dropzone')


                // INITIALIZATION OF STEP FORM
                // =======================================================
                new HSStepForm('.js-step-form', {
                    finish: () => {
                        document.getElementById("createProjectStepFormProgress").style.display = 'none'
                        document.getElementById("createProjectStepFormContent").style.display = 'none'
                        document.getElementById("createProjectStepDetails").style.display = 'none'
                        document.getElementById("createProjectStepTerms").style.display = 'none'
                        document.getElementById("createProjectStepMembers").style.display = 'none'
                        document.getElementById("createProjectStepSuccessMessage").style.display =
                            'block'
                        const formContainer = document.getElementById('formContainer')
                    }
                })
            }
        })()
    </script>

    <!-- Style Switcher JS -->

    <script>
        (function() {
            // STYLE SWITCHER
            // =======================================================
            const $dropdownBtn = document.getElementById('selectThemeDropdown') // Dropdowon trigger
            const $variants = document.querySelectorAll(
                `[aria-labelledby="selectThemeDropdown"] [data-icon]`) // All items of the dropdown

            // Function to set active style in the dorpdown menu and set icon for dropdown trigger
            const setActiveStyle = function() {
                $variants.forEach($item => {
                    if ($item.getAttribute('data-value') === HSThemeAppearance.getOriginalAppearance()) {
                        $dropdownBtn.innerHTML = `<i class="${$item.getAttribute('data-icon')}" />`
                        return $item.classList.add('active')
                    }

                    $item.classList.remove('active')
                })
            }

            // Add a click event to all items of the dropdown to set the style
            $variants.forEach(function($item) {
                $item.addEventListener('click', function() {
                    HSThemeAppearance.setAppearance($item.getAttribute('data-value'))
                })
            })

            // Call the setActiveStyle on load page
            setActiveStyle()

            // Add event listener on change style to call the setActiveStyle function
            window.addEventListener('on-hs-appearance-change', function() {
                setActiveStyle()
            })
        })()
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @yield('scripts')

    @yield('modals')

    <div id="changePasswordModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header" style="border-bottom-width: 0.0625rem; padding: 1.5rem 2rem">
                    <h5 class="modal-title">Cambiar contraseña</h5>
                    <div style="display: flex; gap: .5rem">
                        <div class="dropdown dropup">
                            <button type="button" class="btn btn-ghost-secondary" data-bs-dismiss="modal" aria-label="Close">Cerrar</button>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <!-- Form -->
                    <form id="changePasswordForm">
                        <div class="row mb-4">
                            <label for="newPassword" class="col-sm-3 col-form-label form-label">Nueva contraseña</label>

                            <div class="col-sm-9">
                                <input type="password" class="form-control" name="newPassword" id="newPassword"
                                    placeholder="Ingresa una contraseña" aria-label="Ingresa una contraseña">
                            </div>
                        </div>
                        <!-- End Form -->

                        <!-- Form -->
                        <div class="row mb-4">
                            <label for="confirmNewPasswordLabel" class="col-sm-3 col-form-label form-label">Confirmar
                                contraseña</label>

                            <div class="col-sm-9">
                                <div class="mb-3">
                                    <input type="password" class="form-control" name="confirmNewPassword"
                                        id="confirmNewPasswordLabel" placeholder="Vuelve a ingresar la contraseña creada"
                                        aria-label="Vuelve a ingresar la contraseña creada">
                                </div>

                                <h5>Requisitos de la contraseña:</h5>

                                <p class="fs-6 mb-2">Para mayor seguridad, procura que la contraseña cumpla con las siguientes
                                    reglas:</p>

                                <ul class="fs-6">
                                    <li>Mínimo 8 cáracteres.</li>
                                    <li>Minimo una letra minúscula.</li>
                                    <li>Mínimo una letra mayúscula.</li>
                                    <li>Mínimo un cáracter especial.</li>
                                    <li>Mínimo un número.</li>
                                </ul>
                            </div>
                        </div>
                        <!-- End Form -->

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-danger" id="updatePasswordButton">Actualizar
                                contraseña</button>
                        </div>
                    </form>
                    <!-- End Form -->
                    <!-- End Body -->
                </div>
            </div>
        </div>
    </div>
    <script>
        $("#changePasswordForm").submit(function(e) {
            $('#updatePasswordButton').attr('disabled', true);
            $('#changePasswordForm').attr('disabled', true);
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "/api/account/update_password",
                data: {
                    "_token": "{{ csrf_token() }}",
                    password: $('#newPassword').val(),
                    password_confirmation: $('#confirmNewPasswordLabel').val()
                },
                success: function(response) {
                    $('#updatePasswordButton').attr('disabled', false);
                    $('#changePasswordForm').attr('disabled', false);
                    Swal.fire({
                        title: response.response,
                        icon: response.success ? "success" : "error",
                        confirmButtonText: 'Volver',
                        confirmButtonColor: "#6d747b",
                    });
                    if (response.success) {
                        $('#newPassword').val('');
                        $('#confirmNewPasswordLabel').val('');
                    }
                }
            });
        });
    </script>
    @yield('scripts_after')
    <div class="js-navbar-vertical-aside-toggle-invoker navbar-vertical-aside-mobile-overlay" style="opacity: 1;">
    </div><input type="file" multiple="multiple" class="dz-hidden-input" tabindex="-1"
        style="visibility: hidden; position: absolute; top: 0px; left: 0px; height: 0px; width: 0px;">
</body>

</html>