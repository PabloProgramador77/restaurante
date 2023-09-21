@extends('home')
@section('content')
    <div class="container-fluid my-2">
        <div class="container-fluid row bg-white rounded border-bottom my-1">
            <h3 class="fw-bold fs-5 col-md-6 my-2">Pedidos a domicilio</h3>
            <div class="col-md-2 my-2">
                <a href="{{ url('/ordenes/historial') }}" class="btn btn-warning" role="button"><i class="fas fa-list"></i> Historial</a>
            </div>
            <div class="col-md-4">
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item"><a href="{{ url('/home') }}"><i class="fas fa-home"></i> Inicio</a></li>
                    <li class="breadcrumb-item active"><i class="fas fa-map-marker-alt"></i> Pedidos a domicilio</li>
                </ol>
            </div>
            <small class="fs-5 fw-semibold bg-light my-2 p-1 col-md-12 rounded">A continuación, se muestran los <b>PEDIDOS</b> a domicilio:</small>
        </div>

        <div class="container-fluid bg-white row rounded p-2 my-1 shadow">
            @if ( count($ordenes) > 0 )
                
                @foreach ($ordenes as $orden)
                    <div class="col-md-3">
                        <x-adminlte-small-box title="{{ $orden->mesa->nombreMesa }}" text="$ {{ $orden->totalPedido }} M.N." icon="fas fa-chair" theme="info" url="#" url-text="Ver Pedido" class="orden" data-id="{{ $orden->id }}" data-toggle="modal" data-target="#modalOrden"/>
                    </div>
                @endforeach

            @else
                <div class="col-md-12">
                    <x-adminlte-small-box title="Sin Pedidos Abiertos" text="0" icon="fas fa-chair" theme="info" url="{{ url('/menu') }}" url-text="Ordenar"/>
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
                                            <th scope="col">Precio</th>
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
                                    <div class="form-group col-md-6 p-1 ">
                                        <a href="#" class="bnt btn-success btn-block p-2 text-center cobrar"><i class="fas fa-hand-holding-usd" ></i> Cobrar Orden</a>
                                    </div>
                                    <div class="form-group col-md-6 p-1 ">
                                        <a href="#" class="bnt btn-danger btn-block p-2 text-center eliminar"><i class="fas fa-trash-alt" ></i> Cancelar Orden</a>
                                    </div>
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
        <script src="{{ asset('storage/js/ordenes/cobrar.js') }}" type="text/javascript"></script>
        <script src="{{ asset('storage/js/ordenes/eliminar.js') }}" type="text/javascript"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                Swal.fire({
                    title: 'Función Premium',
                    html: 'Crea y gestiona los pedidos a domicilio de tu restaurante por solo <b>$ 115.00 M.N.</b> mensuales.',
                    allowOutsideClick: false
                }).then((resultado)=>{
                    if(resultado.isConfirmed){
                        window.location.href = '/ordenes';
                    }
                })
            });
        </script>
    </div>
@stop