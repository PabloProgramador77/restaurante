@extends('home')
@section('content')
    <div class="container-fluid my-2">

        <div class="container-fluid row bg-white rounded border-bottom my-1">
            <h3 class="fw-bold fs-5 col-md-6 my-2">Menú de Restaurante</h3>
            <div class="col-md-2 my-2">
                <input type="hidden" name="token" id="token" value="{{ csrf_token() }}">
                <a href="#" class="btn btn-warning orden" role="button" data-toggle="modal" data-target="#modalOrden"><i class="fas fa-list"></i> Orden</a>
            </div>
            <div class="col-md-4">
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item"><a href="{{ url('/home') }}"><i class="fas fa-home"></i> Inicio</a></li>
                    <li class="breadcrumb-item "><a href="{{ url('/menu') }}"><i class="fas fa-bars"></i> Menú</a></li>
                    <li class="breadcrumb-item active"><i class="fas fa-utensils"></i> Platillos</li>
                </ol>
            </div>
            <small class="fs-5 fw-semibold bg-light my-2 p-1 col-md-12 rounded">A continuación, se muestran los <b>PLATILLOS</b> del restaurante:</small>
        </div>

        <div class="container-fluid bg-white row rounded p-2 my-1 shadow">
            @if ( count($menu) > 0 )
                
                    @foreach ($menu as $platillo)
                        <div class="col-md-4">
                            <x-adminlte-small-box title="{{ $platillo->nombrePlatillo }}" text="$ {{ $platillo->precioPlatillo }} M.N." icon="fas fa-utensils" theme="primary" url="#" url-text="Ordenar Platillo" data-id="{{ $platillo->id }}" data-toggle="modal" data-target="#modalPlatillo" class="platillo"/>
                        </div>
                    @endforeach
                
            @else
                @can('ver-categorias')
                    <div class="col-md-12">
                        <x-adminlte-small-box title="Sin Platillos Agregados a la Categoría" text="0" icon="fas fa-bars" theme="info" url="{{ url('/categorias') }}" url-text="Agregar Platillos a Categoría Ahora"/>
                    </div>
                @endcan
            @endif
            
        </div>

        <!--Modal de Platillo-->
        <div class="modal fade" id="modalPlatillo" tabindex="-1" aria-labellebdy="modalPlatilloLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header border-bottom">
                        <h3 class="modal-title fs-4 fw-bold">Platillo a ordenar</h3>
                        <button type="button" class="btn btn-close" data-dismiss="modal" aria-label="close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group bg-light">
                            <small class="fs-5 fw-semibold text-info">Datos del platillo y su preparación:</small>
                        </div>
                        <form novalidate>
                            @csrf
                            <div class="form-group">
                                <label for="platilo">Platillo</label>
                                <input type="text" name="platillo" id="platillo" class="form-control" readonly="true">
                            </div>
                            <div class="form-group">
                                <label for="cantidad">Cantidad</label>
                                <input type="number" name="cantidad" id="cantidad" required class="form-control" value="1" max="100" min="1">
                            </div>
                            <div class="form-group">
                                <label for="nota">Nota de preparación</label>
                                <textarea name="nota" id="nota" cols="30" rows="3" class="form-control"></textarea>
                            </div>
                            <div class="modal-footer">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary" name="ordenar" id="ordenar"><i class="fas fa-ok"></i> Ordenar</button>
                                </div>
                            </div>
                            <input type="hidden" name="token" id="token" value="{{ csrf_token() }}">
                            <input type="hidden" name="idPlatilloMenu" id="idPlatilloMenu">
                            @if ( session()->get('idOrden') )
                                <input type="hidden" name="idOrden" id="idOrden">
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!--Modal de Orden-->
        <div class="modal fade" id="modalOrden" tabindex="-1" aria-labellebdy="modalOrdenLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header border-bottom">
                        <h3 class="modal-title fs-4 fw-bold">Orden</h3>
                        <button type="button" class="btn btn-close" data-dismiss="modal" aria-label="close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Cantidad</th>
                                    <th scope="col">Precio</th>
                                    <th scope="col">Platillo</th>
                                    <th scope="col">Nota de Preparación</th>
                                    <th></th>
                                </tr>
                                <tbody id="contenedorPlatillos">
                                    <td colspan="3" class="text-info bg-light fs-5 fw-semibold">Sin platillos agregados.</td>
                                </tbody>
                            </thead>
                        </table>
                    </div>
                    <div class="modal-footer bg-light">
                        <form novalidate class="container-fluid row">
                            @csrf
                            <div class="form-group col-md-8">
                                <label for="mesa" class="float-start d-inline">Elige la mesa</label>
                                <select name="mesa" id="mesa" class="form-control float-end w-50 d-inline">
                                    @foreach ($mesas as $mesa)
                                        <option value="{{ $mesa->id }}">{{ $mesa->nombreMesa }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <button type="submit" class="btn btn-primary btn-block" id="terminar" name="terminar"><i class="fas fa-dumpster-fire"></i> Terminar Orden</button>
                            </div>
                            <input type="hidden" name="token" id="token" value="{{ csrf_token() }}">
                            <input type="hidden" name="idPedido" id="idPedido" value="{{ session()->get('idOrden') }}">
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <script src="{{ asset('js/jquery-3.6.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/sweetAlert.js') }}" type="text/javascript"></script>
        <script src="{{ asset('storage/js/platillos/editar.js') }}" type="text/javascript"></script>
        <script src="{{ asset('storage/js/ordenes/init.js') }}" type="text/javascript"></script>
        
        @if ( session()->get('idOrden') )
            
            <script src="{{ asset('storage/js/platillos/ordenar.js') }}" type="text/javascript"></script>
            <script src="{{ asset('storage/js/ordenes/terminar.js') }}" type="text/javascript"></script>

        @else

            <script src="{{ asset('storage/js/platillos/orden.js') }}" type="text/javascript"></script>
            
        @endif
        
    </div>
@stop