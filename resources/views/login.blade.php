<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login | {{ env('APP_NAME') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../template/assets/vendor/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="preload" href="../template/assets/css/theme-dark.min.css" data-hs-appearance="dark" as="style">
    <link rel="preload" href="../template/assets/css/theme-dark.min.css" data-hs-appearance="dark" as="style">
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
    <script>
        window.hs_config = {
            "autopath": "@@autopath",
            "deleteLine": "hs-builder:delete",
            "deleteLine:build": "hs-builder:build-delete",
            "deleteLine:dist": "hs-builder:dist-delete",
            "previewMode": false,
            "startPath": "/",
            "vars": {
                "themeFont": "https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap",
                "version": "?v=1.0"
            },
            "layoutBuilder": {
                "extend": {
                    "switcherSupport": true
                },
                "header": {
                    "layoutMode": "dark",
                    "containerMode": "container-fluid"
                },
                "sidebarLayout": "dark"
            },
            "themeAppearance": {
                "layoutSkin": "dark",
                "sidebarSkin": "dark",
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
                "lang": "en"
            },
            "skipFilesFromBundle": {
                "dist": ["template/assets/js/hs.theme-appearance.js", "template/assets/js/hs.theme-appearance-charts.js", "template/assets/js/demo.js"],
                "build": ["template/assets/css/theme-dark.css", "template/assets/vendor/hs-navbar-vertical-aside/dist/hs-navbar-vertical-aside-mini-cache.js", "template/assets/js/demo.js", "template/assets/css/theme-dark.css", "template/assets/css/docs.css", "template/assets/vendor/icon-set/style.css", "template/assets/js/hs.theme-appearance.js", "template/assets/js/hs.theme-appearance-charts.js", "node_modules/chartjs-plugin-datalabels/dist/chartjs-plugin-datalabels.min.js", "template/assets/js/demo.js"]
            },
            "minifyCSSFiles": ["template/assets/css/theme-dark.css", "template/assets/css/theme-dark.css"],
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
                "src": "./src",
                "dist": "./dist",
                "build": "./build"
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
        [data-hs-theme-appearance]:not([data-hs-theme-appearance='dark']) {
            display: none !important;
        }
    </style>
</head>
<link rel="stylesheet" href="../template/assets/css/theme.min.css" data-hs-current-theme="stylesheet">

<body class="user-select-none">
    <script src="../template/assets/js/hs.theme-appearance.js"></script>
    <main id="content" role="main" class="main">
        <div class="position-fixed top-0 end-0 start-0 bg-img-start" style="height: 32rem; background-image: url(./template/assets/svg/components/card-6.svg);">
            <div class="shape shape-bottom zi-1">
                <svg preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 1921 273">
                    <polygon fill="#fff" points="0,273 1921,273 1921,0 "></polygon>
                </svg>
            </div>
        </div>
        <div class="container py-5 py-sm-7">
            <a class="d-flex justify-content-center mb-5" href="/">
                <img class="zi-2" src="https://mos-it.cl/wp-content/uploads/2022/09/PNG-Mos-It.png" alt="Image Description" style="width: 10rem; -webkit-user-drag: none;">
            </a>

            <div class="mx-auto" style="max-width: 30rem;">
                <div class="card card-lg mb-5">
                    <div class="card-body">
                        <form class="js-validate needs-validation" novalidate="">
                            <div class="text-center">
                                <div class="mb-5">
                                    <h1 class="display-5">Log In</h1>
                                    <p>Ingresa tus datos</p>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="signinSrEmail">Email</label>
                                <input type="email" class="form-control form-control-lg" name="email" id="signinSrEmail" tabindex="1" placeholder="email@mos-it.cl" aria-label="email@mos-it.cl" required>
                                <span class="invalid-feedback">El email ingresado es invalido.</span>
                            </div>
                            <div class="mb-4">
                                <label class="form-label w-100" for="signupSrPassword" tabindex="0">
                                    <span class="d-flex justify-content-between align-items-center">
                                        <span>Contraseña</span>
                                    </span>
                                </label>

                                <div class="input-group input-group-merge" data-hs-validation-validate-class="">
                                    <input type="password" class="js-toggle-password form-control form-control-lg" name="password" id="signupSrPassword" placeholder="Ingresa tu contraseña" aria-label="Ingresa tu contraseña" required data-hs-toggle-password-options="{
                           &quot;target&quot;: &quot;#changePassTarget&quot;,
                           &quot;darkClass&quot;: &quot;bi-eye-slash&quot;,
                           &quot;showClass&quot;: &quot;bi-eye&quot;,
                           &quot;classChangeTarget&quot;: &quot;#changePassIcon&quot;
                         }">
                                    <a id="changePassTarget" class="input-group-append input-group-text" href="javascript:;">
                                        <i id="changePassIcon" class="bi-eye-slash"></i>
                                    </a>
                                </div>

                                <span class="invalid-feedback">La contraseña ingresada es invalida.</span>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">Log In</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="../template/assets/vendor/jquery/dist/jquery.min.js"></script>
    <script src="../template/assets/vendor/jquery-migrate/dist/jquery-migrate.min.js"></script>
    <script src="../template/assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../template/assets/vendor/hs-toggle-password/dist/js/hs-toggle-password.js"></script>
    <script src="../template/assets/js/theme.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        (function() {
            disabled = false
            window.onload = function() {
                HSBsValidation.init('.js-validate', {
                    onSubmit: data => {
                        event.preventDefault()
                        if (!disabled) {
                            disabled = true
                            $.ajax({
                                type: "POST",
                                url: "/api/auth/login",
                                data: {
                                    "email": $('#signinSrEmail').val(),
                                    "password": $('#signupSrPassword').val(),
                                    "_token": "{{ csrf_token() }}"
                                },
                                success: function(response) {
                                    disabled = false
                                    response = JSON.parse(response);
                                    if (response.success) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: '¡Te has logueado correctamente!',
                                            text: '¡Bienvenid@ a {{ env("APP_NAME") }}!'
                                        }).then(function() {
                                            window.location.href = "/";
                                        });
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: '¡Ha ocurrido un error!',
                                            text: response.response
                                        });
                                    }
                                }
                            });
                        }
                    }
                })
                new HSTogglePassword('.js-toggle-password')
            }
        })()
    </script>
</body>

</html>