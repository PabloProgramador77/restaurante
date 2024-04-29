@extends('home')
@section('content')
    <div class="container-fluid my-2">

        <div class="container-fluid row bg-white rounded border-bottom my-1">
            <h3 class="fw-bold fs-5 col-md-8 my-2">Inicio de Restaurante</h3>
            <div class="col-md-4">
                <ol class="breadcrumb float-right">
                    <li class="breadcrubm-item active"><i class="fas fa-home"></i> Inicio</li>
                </ol>
            </div>
            <small class="fs-5 fw-semibold bg-light my-2 p-1 col-md-12 rounded">A continuación, se muestran los datos generales del restaurante:</small>
        </div>

        <div class="container-fluid bg-light p-1 col-lg-12 col-md-12">
            <p class="text-center p-1 rounded bg-info"><b><i class="fas fa-star"></i> Proxima actualización: Gestor de Empleados, Roles y Permisos de Empleados <i class="fas fa-star"></i></b>. <small class="d-block text-center p-1 rounded bg-info"><i class="fas fa-info-circle"></i> 31 de Mayo de 2024</small></p>
        </div>
        <div class="container-fluid bg-white row rounded p-2 my-1 shadow">
            @can('crear-pedido')
                <div class="col-md-6">
                    <x-adminlte-small-box title="Ordenar" text="Crear nuevo pedido" icon="fas fa-utensils" theme="warning" url="{{ url('/menu') }}" url-text="Ordenar Ahora"/>
                </div>
            @endcan
            <div class="col-md-6">
                <x-adminlte-small-box title="Videotutoriales" text="Tomate 7 minutos para ver los videos y aprende a usar la plataforma como todo un profesional" icon="fas fa-photo-video" theme="teal" url="{{ url('/videos') }}" url-text="Ver videos"/>
            </div>
        </div>

        <div class="container-fluid bg-white row rounded p-2 my-1 shadow">
                <div class="col-md-4">
                    <x-adminlte-info-box title="Categorías de Menú" text="{{ count($categorias) }}" icon="fas fa-bars" theme="gradient-teal"/>
                </div>
                <div class="col-md-4">
                    <x-adminlte-info-box title="Platillos" text="{{ count($platillos) }}" icon="fas fa-pizza-slice" theme="gradient-purple"/>
                </div>
                <div class="col-md-4">
                    <x-adminlte-info-box title="Mesas" text="{{ count($mesas) }}" icon="fas fa-chair" theme="gradient-primary"/>
                </div>
                <div class="col-md-4">
                    <x-adminlte-info-box title="Pedidos" text="{{ count($ordenes) }}" icon="fas fa-tags" theme="gradient-info"/>
                </div>
            <div class="col-md-4">
                <x-adminlte-info-box title="Total de Ventas" text="{{ $ventas }} M.N." icon="fas fa-dollar-sign" theme="gradient-success"/>
            </div>
        </div>
    </div>
@stop