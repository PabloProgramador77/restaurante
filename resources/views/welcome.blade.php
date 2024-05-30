<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Restaurante</title>
        <!-- Styles -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/00b567f7fc.js" crossorigin="anonymous"></script>
    </head>
    <body class="container-fluid">

        <!--Navegación/Cabecera Principal-->
        <nav class="navbar navbar-expand sticky-top bg-white shadow" id="inicio">
            <div class="container-fluid">
                <a href="#" class="navbar-brand">
                    <img src="{{ asset('media/2-removebg-preview.png') }}" alt="Logo" class="d-inline-block align-text-top" width="100px" height="auto">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        <a class="nav-link" href="#inicio">
                            <i class="fas fa-home"></i>
                            Inicio
                        </a>
                        <a class="nav-link" href="#about">
                            <i class="fas fa-info-circle"></i>
                            Acerca de
                        </a>
                        <a class="nav-link" href="#videomanual">
                            <i class="fas fa-video"></i>   
                            Videomanual
                        </a>
                        <a class="nav-link" href="#coming">
                            <i class="fas fa-award"></i>   
                            Proximamente
                        </a>
                    </div>
                </div>
                <ul class="nav justify-content-end">
                    @if( Route::has('login') )
                        @auth
                            <li class="nav-item mx-2">
                                <a href="{{ url('/home') }}" class="btn btn-success shadow rounded" role="button">
                                    <i class="fas fa-bell"></i>
                                    Continuar
                                </a>
                            </li>
                        @else
                            <li class="nav-item mx-2">
                                <a href="{{ route('login') }}" class="btn btn-primary shadow rounded" role="button">
                                    <i class="fas fa-sign-in-alt"></i>
                                    Entrar
                                </a>
                            </li>
                            @if( Route::has('register') )
                                <li class="nav-item mx-2">
                                    <a href="{{ route('register') }}" class="btn btn-secondary shadow rounded" role="button">
                                        <i class="fas fa-user-plus"></i>
                                        Registrate
                                    </a>
                                </li>
                            @endif
                        @endauth
                    @endif
                </ul>
            </div>
        </nav>

        <!--Banner Principal-->
        <div class="container-fluid p-2" style="background-image: url('media/bg01.jpg'); background-position: center; background-container: container;">
            <div class="container-fluid">
                <img src="{{ asset('media/2-removebg-preview.png') }}" alt="Logo" width="250px" height="auto" class="d-block m-auto">
                <h1 class="text-center fs-1 fw-bold">TU ALIADO GASTRONÓMICO DIGITAL</h1>
                <p class="text-center fs-5 fw-semibold w-50 m-auto p-3">La primer plataforma en línea con todo las funciones que tu restaurante, bar y cafetería necesita desde cualquier dispositivo móvil, tableta u ordenador.</p>
                <p class="fw-semibold fs-6 text-center p-2 bg-light w-50 m-auto">Versión actual: 1.2.2.</p>
                <a href="#about" class="d-block btn btn-info rounded shadow m-auto my-4 p-3" role="button" style="width: 200px">
                    <i class="fas fa-arrow-down"></i>
                    Saber más
                </a>
            </div>
        </div>

        <!--About it-->
        <div class="container border-bottom p-2 my-5" id="about">
            <h2 class="text-center fs-4 fw-bold">¿Qué es Foodify?</h2>
            <p class="text-center fs-6 fw-semibold w-50 m-auto text-secondary my-4">Es la primer plataforma en línea con las herramientas y funciones necesarias para administrar las diferentes áreas de cualquier restaurante, bar y cafetería.
                Esto por medio de cualquier ordenador, tableta o dispositivo móvil que cuente con conexión a internet.
            </p>
            <div class="container-fluid p-2 my-5">
                <div class="row">
                    <div class="card col-md-4 shadow">
                        <img src="{{ asset('media/card01.jpg') }}" alt="Card 1">
                        <div class="card-body bg-tertiary">
                            <h4 class="fs-5 fw-semibold border-bottom">Diversidad de Funciones</h4>
                            <p class="fs-6 fw-normal">Cuenta con diversas secciones como categorías de menú, platillos, pedidos, cortes de caja y más.</p>
                        </div>
                    </div>
                    <div class="card col-md-4 shadow">
                        <img src="{{ asset('media/card02.jpg') }}" alt="Card 2">
                        <div class="card-body bg-tertiary">
                            <h4 class="fs-5 fw-semibold border-bottom">Adaptable</h4>
                            <p class="fs-6 fw-normal">Se adapta a cualquier tamaño de pantalla, ya sea ordenador, tableta o dispositivo móvil.</p>
                        </div>
                    </div>
                    <div class="card col-md-4 shadow">
                        <img src="{{ asset('media/card03.jpg') }}" alt="Card 3">
                        <div class="card-body bg-tertiary">
                            <h4 class="fs-5 fw-semibold border-bottom">Personalizable</h4>
                            <p class="fs-6 fw-normal">Tu eliges las funciones extras para administrar tu negocio. Sin complicaciones innecesarias.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--Videmanual-->
        <div class="container-fluid" id="videomanual">
            <h4 class="fs-4 fw-bold text-center">Videomanual</h4>
            <p class="fs-6 fw-semibold text-secondary text-center">Por si fuera poco, ponemos a tu disposición un video manual de las diferentes secciones de la plataforma.</p>
            <p class="fs-6 fw-semibold text-center bg-primary p-2 text-white w-50 m-auto">Te capacitas en el mismo tiempo en que preparas tu café.</p>
            <div class="row p-2 m-5 border-bottom">
                <div class="col-md-6">
                    <h4 class="fs-5 fw-bold">Categorías de Menú</h4>
                    <p class="fs-6 fw-semibold">Aprende a gestionar las categorías de menú de tu negocio en el siguiente mínuto:</p>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Altas</li>
                        <li class="list-group-item">Edición</li>
                        <li class="list-group-item">Eliminación</li>
                        <li class="list-group-item">Asignación de platillos</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <video src="{{ asset('media/videos/Categorias.mp4') }}" controls="true" width="625px" height="auto"></video>
                </div>
            </div>
            <div class="row p-2 m-5 border-bottom">
                <div class="col-md-6">
                    <h4 class="fs-5 fw-bold">Platillos</h4>
                    <p class="fs-6 fw-semibold">Aprende a gestionar los platillos de menú de tu negocio en el siguiente mínuto:</p>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Altas</li>
                        <li class="list-group-item">Edición</li>
                        <li class="list-group-item">Eliminación</li>
                        <li class="list-group-item">Asignación de platillos</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <video src="{{ asset('media/videos/Platillos.mp4') }}" controls="true" width="625px" height="auto"></video>
                </div>
            </div>
            <div class="row p-2 m-5 border-bottom">
                <div class="col-md-6">
                    <h4 class="fs-5 fw-bold">Mesas</h4>
                    <p class="fs-6 fw-semibold">Aprende a gestionar las mesas de tu negocio en el siguiente mínuto:</p>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Altas</li>
                        <li class="list-group-item">Edición</li>
                        <li class="list-group-item">Eliminación</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <video src="{{ asset('media/videos/Mesas.mp4') }}" controls="true" width="625px" height="auto"></video>
                </div>
            </div>
            <div class="row p-2 m-5 border-bottom">
                <div class="col-md-6">
                    <h4 class="fs-5 fw-bold">Pedidos</h4>
                    <p class="fs-6 fw-semibold">Aprende a crear y gestionar los pedidos de tu negocio en los siguientes 2 mínuto:</p>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Toma de pedido</li>
                        <li class="list-group-item">Edición</li>
                        <li class="list-group-item">Eliminación</li>
                        <li class="list-group-item">Cobrar pedido</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <video src="{{ asset('media/videos/Pedidos.mp4') }}" controls="true" width="625px" height="auto"></video>
                </div>
            </div>
            <div class="row p-2 m-5 border-bottom">
                <div class="col-md-6">
                    <h4 class="fs-5 fw-bold">Caja y Corte</h4>
                    <p class="fs-6 fw-semibold">Aprende a gestionar cortes de caja de tu negocio en el siguiente mínuto:</p>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Altas</li>
                        <li class="list-group-item">Consulta</li>
                        <li class="list-group-item">Visualización</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <video src="{{ asset('media/videos/Corte.mp4') }}" controls="true" width="625px" height="auto"></video>
                </div>
            </div>
            <div class="row p-2 m-5 border-bottom rounded">
                <h4 class="fs-5 fw-bold text-center bg-warning p-2 rounded"><i class="fas fa-star"></i> Nuevas Funciones <i class="fas fa-star"></i></h4>
                <div class="col-md-6">
                    <h4 class="fs-5 fw-bold">Gestión de Empleados</h4>
                    <p class="fs-6 fw-semibold">Aprende a gestionar tus empleados, así como su rol y permisos dentro de la plataforma:</p>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Altas</li>
                        <li class="list-group-item">Consulta</li>
                        <li class="list-group-item">Visualización</li>
                        <li class="list-group-item">Rol y Permisos</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <video src="{{ asset('media/videos/RolesPermisos.mp4') }}" controls="true" width="625px" height="auto"></video>
                </div>
            </div>
        </div>

        <!--Banner Proximamente-->
        <div class="container-fluid" id="coming">
            <div class="row" style="background-image: url('media/coming.jpg'); background-size: cover; background-position: center;">
                <div class="col-md-12 p-5 m-5 w-50 m-auto">
                    <h4 class="fs-4 fw-bold text-center p-2"><i class="fas fa-award"></i> Proximamente</h4>
                    <p class="fs-5 fw-semibold text-center p-2">En la recta final de junio de 2024 se actualizará a la versión 1.2.1 con una nueva función de administración de sabores.</p>
                    <p class="fs-6 fw-semibold bg-info p-2">Contará con funciones como:</p>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Alta de sabores</li>
                        <li class="list-group-item">Consulta de sabores</li>
                        <li class="list-group-item">Edición de sabores</li>
                        <li class="list-group-item">Eliminación de sabores</li>
                        <li class="list-group-item">Asignación de sabores a los platillos</li>
                        <li class="list-group-item">Selección de sabores en los platillos al tomar la orden del cliente</li>
                    </ul>
                </div>
            </div>
        </div>

        <!--Footer-->
        <div class="container">
            <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
                <div class="col-md-4 d-flex align-items-center">
                    <a href="/" class="mb-3 me-2 mb-md-0 text-body-secondary text-decoration-none lh-1">
                        <svg class="bi" width="30" height="24"><use xlink:href="#bootstrap"></use></svg>
                    </a>
                    <span class="mb-3 mb-md-0 text-body-secondary">© 2024 PabloProgramador</span>
                </div>

                <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
                    <li class="ms-3">
                        <a class="text-body-secondary" href="https://www.facebook.com/pablodeveloper" target="_blank">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    </li>
                </ul>
            </footer>
        </div>

    </body>
</html>
