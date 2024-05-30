@extends('home')
@section('content')
    <div class="container-fluid my-2">

        <div class="container-fluid row bg-white rounded border-bottom my-1">
            <h3 class="fw-bold fs-5 col-md-8 my-2">Videotutoriales</h3>
            <div class="col-md-4">
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item"><a href="{{ url('/home') }}"><i class="fas fa-home"></i> Inicio</a></li>
                    <li class="breadcrumb-item active"><i class="fas fa-photo-video"></i> Videotutoriales</li>
                </ol>
            </div>
            <small class="fs-3 fw-semibold bg-light my-2 p-1 col-md-12 rounded">A continuación, se muestran los videos para que aprendas a administrar tu restaurante, cafetería y/o bar como se todo un profesional:</small>
        </div>

        <div class="container-fluid bg-white row rounded p-2 my-1 shadow">
            <div class="col-lg-4 col-md-3 col-sm-6">
                <x-adminlte-small-box title="Categorías" text="Administración de categorías" icon="fas fa-bars" theme="secondary" url="#" url-text="Ver video" data-toggle="modal" data-target="#modalCategorias"/>
            </div>
            <div class="col-lg-4 col-md-3 col-sm-6">
                <x-adminlte-small-box title="Platillos" text="Administración de platillos" icon="fas fa-hamburger" theme="primary" url="#" url-text="Ver videos" data-toggle="modal" data-target="#modalPlatillos"/>
            </div>
            <div class="col-lg-4 col-md-3 col-sm-6">
                <x-adminlte-small-box title="Mesas" text="Administración de mesas" icon="fas fa-chair" theme="info" url="#" url-text="Ver videos" data-toggle="modal" data-target="#modalMesas"/>
            </div>
            <div class="col-lg-4 col-md-3 col-sm-6">
                <x-adminlte-small-box title="Pedidos" text="Administración de pedidos" icon="fas fa-tags" theme="success" url="#" url-text="Ver videos" data-toggle="modal" data-target="#modalPedidos"/>
            </div>
            <div class="col-lg-4 col-md-3 col-sm-6">
                <x-adminlte-small-box title="Caja" text="Administración de cortes de caja" icon="fas fa-cash-register" theme="teal" url="#" url-text="Ver videos" data-toggle="modal" data-target="#modalCaja"/>
            </div>
            <div class="col-lg-4 col-md-3 col-sm-6">
                <x-adminlte-small-box title="Empleados" text="Administración de empleados" icon="fas fa-user-alt" theme="warning" url="#" url-text="Ver video" data-toggle="modal" data-target="#modalEmpleado"/>
            </div>
            <div class="col-lg-4 col-md-3 col-sm-6">
                <x-adminlte-small-box title="Impresoras" text="Administración de impresoras" icon="fas fa-print" theme="purple" url="#" url-text="Ver video" data-toggle="modal" data-target="#modalImpresora"/>
            </div>
        </div>
    </div>

    <!--Modal Videos de Categorías-->
    <div class="modal fade" id="modalCategorias" tabindex="-1" aria-labellebdy="modalCategoriasLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header border-bottom">
                    <h3 class="modal-title fs-4 fw-semibold"><i class="fas fa-bars"></i> Administración de Categorías</h3>
                    <button type="button" class="btn btn-close" data-dismiss="modal" aria-label="close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid border rounde">
                        <p class="fs-4 fw-semibold text-secondary">Video breve explicativo de como registrar, editar y borrar categorías de tu negocio.</p>
                        <video src="{{ asset('media/videos/Categorias.mp4') }}" controls width="100%" height="auto" autoplay="true"></video>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalPlatillos" tabindex="-1" aria-labellebdy="modalPlatillosLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header border-bottom">
                    <h3 class="modal-title fs-4 fw-semibold"><i class="fas fa-hamburger"></i> Administración de Platillos</h3>
                    <button type="button" class="btn btn-close" data-dismiss="modal" aria-label="close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid border rounde">
                        <p class="fs-4 fw-semibold text-secondary">Video breve explicativo de como registrar, editar y borrar platillos de tu negocio.</p>
                        <video src="{{ asset('media/videos/Platillos.mp4') }}" controls width="100%" height="auto" autoplay="true"></video>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalMesas" tabindex="-1" aria-labellebdy="modalMesasLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header border-bottom">
                    <h3 class="modal-title fs-4 fw-semibold"><i class="fas fa-chair"></i> Administración de Mesas</h3>
                    <button type="button" class="btn btn-close" data-dismiss="modal" aria-label="close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid border rounde">
                        <p class="fs-4 fw-semibold text-secondary">Video breve explicativo de como registrar, editar y borrar mesas de tu negocio.</p>
                        <video src="{{ asset('media/videos/Mesas.mp4') }}" controls width="100%" height="auto" autoplay="true"></video>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalPedidos" tabindex="-1" aria-labellebdy="modalPedidosLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header border-bottom">
                    <h3 class="modal-title fs-4 fw-semibold"><i class="fas fa-tags"></i> Administración de Pedidos</h3>
                    <button type="button" class="btn btn-close" data-dismiss="modal" aria-label="close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid border rounde">
                        <p class="fs-4 fw-semibold text-secondary">Video breve explicativo de como registrar, editar y cobrar pedidos de tu negocio.</p>
                        <video src="{{ asset('media/videos/Pedidos.mp4') }}" controls width="100%" height="auto" autoplay="true"></video>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalCaja" tabindex="-1" aria-labellebdy="modalCajaLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header border-bottom">
                    <h3 class="modal-title fs-4 fw-semibold"><i class="fas fa-cash-register"></i> Administración de Caja</h3>
                    <button type="button" class="btn btn-close" data-dismiss="modal" aria-label="close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid border rounde">
                        <p class="fs-4 fw-semibold text-secondary">Video breve explicativo de como hacer corte de caja de tu negocio.</p>
                        <video src="{{ asset('media/videos/Corte.mp4') }}" controls width="100%" height="auto" autoplay="true"></video>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEmpleado" tabindex="-1" aria-labellebdy="modalEmpleadoLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header border-bottom">
                    <h3 class="modal-title fs-4 fw-semibold"><i class="fas fa-cash-register"></i> Administración de Empleados</h3>
                    <button type="button" class="btn btn-close" data-dismiss="modal" aria-label="close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid border rounde">
                        <p class="fs-4 fw-semibold text-secondary">Video breve explicativo de como gestionar los empleados de tu negocio.</p>
                        <video src="{{ asset('media/videos/RolesPermisos.mp4') }}" controls width="100%" height="auto" autoplay="true"></video>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalImpresora" tabindex="-1" aria-labellebdy="modalImpresoraLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header border-bottom">
                    <h3 class="modal-title fs-4 fw-semibold"><i class="fas fa-cash-register"></i> Administración de Impresoras</h3>
                    <button type="button" class="btn btn-close" data-dismiss="modal" aria-label="close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid border rounde">
                        <p class="fs-4 fw-semibold text-secondary">Video breve explicativo de como gestionar los impresoras de tu negocio.</p>
                        <video src="{{ asset('media/videos/Impresoras.mp4') }}" controls width="100%" height="auto" autoplay="true"></video>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop