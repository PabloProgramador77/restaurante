@extends('home')
@section('content')
    <div class="container-fluid my-2">
        <div class="container-fluid row bg-white rounded border-bottom my-1">
            <h3 class="fw-bold fs-5 col-md-8 my-2">Historial de Ordenes</h3>
            <div class="col-md-4">
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item"><a href="{{ url('/home') }}"><i class="fas fa-home"></i> Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/ordenes') }}"><i class="fas fa-tags"></i> Pedidos</a></li>
                    <li class="breadcrumb-item active"><i class="fas fa-list"></i> Historial</li>
                </ol>
            </div>
            <small class="fs-5 fw-semibold bg-light my-2 p-1 col-md-12 rounded">A continuación, se muestra el historial de <b>PEDIDOS</b> del restaurante:</small>
        </div>

        <div class="container-fluid bg-white row rounded p-2 my-1 shadow">
            @if ( count($ordenes) > 0 )
                
            @can('Ver pedidos')

                @foreach ($ordenes as $orden)
                    
                    @can('Ver pedido')
                        <div class="col-md-3">
                            <x-adminlte-small-box title="{{ $orden->mesa->nombreMesa }}" text="{{ $orden->created_at }}" icon="fas fa-tags" theme="info" url="#" url-text="Ver Pedido" class="orden" data-id="{{ $orden->id }}" data-toggle="modal" data-target="#modalOrden"/>
                        </div>
                    @endcan

                @endforeach

            @endcan

            @else
                <div class="col-md-12">
                    <x-adminlte-small-box title="Sin Pedidos Registrados" text="0" icon="fas fa-tags" theme="info" url="{{ url('/menu') }}" url-text="Ordenar"/>
                </div>
            @endif
            
        </div>

        <!--Modal de Pedido-->
        <div class="modal fade" id="modalOrden" tabindex="-1" aria-labellebdy="modalOrdenLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header border-bottom">
                        <h3 class="modal-title fs-5 fw-semibold" id="tituloOrden">Datos de Orden</h3>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid row">
                            <div class="form-group col-md-12">
                                <p class="text-info p-1 fs-6 fw-semibold bg-light">A continuación, la información detallada del pedido:</p>
                            </div>
                            <div class="col-md-12">
                                <table class="table table-stripe table-hover">
                                    <thead>
                                        <tr class="table-info">
                                            <th scope="col">#</th>
                                            <th scope="col">Platillo</th>
                                            <th scope="col">Nota de Preparación</th>
                                            <th scope="col">Monto</th>
                                        </tr>
                                    </thead>
                                    <tbody id="contenedorPlatillos">
                                        <tr class="table-success">
                                            <td colspan="4">Total de Pedido: $ 0,000.00 M.N.</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="container-fluid row p-1">
                                <form novalidate class="container-fluid p-1 row">
                                    
                                    <input type="hidden" name="idOrden" id="idOrden">
                                    <input type="hidden" name="token" id="token" value="{{ csrf_token() }}">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="{{ asset('js/jquery-3.6.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/sweetAlert.js') }}" type="text/javascript"></script>
        <script src="{{ asset('storage/js/ordenes/orden.js') }}" type="text/javascript"></script>
    </div>
@stop