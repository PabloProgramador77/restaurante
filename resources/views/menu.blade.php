@extends('home')
@section('content')
    <div class="container-fluid my-2">

        <div class="container-fluid row bg-white rounded border-bottom my-1">
            <h3 class="fw-bold fs-5 col-md-8 my-2">Menú de Restaurante</h3>
            <div class="col-md-4">
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item"><a href="{{ url('/home') }}"><i class="fas fa-home"></i> Inicio</a></li>
                    <li class="breadcrumb-item active"><i class="fas fa-bars"></i> Menú</li>
                </ol>
            </div>
            <small class="fs-5 fw-semibold bg-light my-2 p-1 col-md-12 rounded">A continuación, se muestran las <b>CATEGORÍAS</b> del restaurante:</small>
        </div>

        <div class="container-fluid bg-white row rounded p-2 my-1 shadow">
            @if ( count($categorias) > 0 )
                
                    @foreach ($categorias as $categoria)
                        <div class="col-md-4">
                            <x-adminlte-small-box title="{{ $categoria->nombreCategoria }}" text="" icon="fas fa-bars" theme="info" url="{{ url('/menu') }}/{{ $categoria->id }}" url-text="Ver Platillos"/>
                        </div>
                    @endforeach
                
            @else
                @can('ver-categorias')
                    <div class="col-md-12">
                        <x-adminlte-small-box title="Sin Categorías Registradas" text="0" icon="fas fa-bars" theme="info" url="{{ url('/categorias') }}" url-text="Agregar Categoría(s) Ahora"/>
                    </div>
                @endcan
            @endif
            
        </div>

    </div>
@stop