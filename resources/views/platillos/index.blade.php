@extends('home')
@section('content')
    <div class="container-fluid my-2">

        <!--Encabezado-->
        <div class="container-fluid row bg-white rounded border-bottom my-1">
            <h3 class="fw-bold fs-5 col-md-8 my-2">Platillos de Menú</h3>
            <div class="col-md-4">
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item">
                        <a href="{{ url('/home') }}">
                            <i class="fas fa-home"></i> Inicio
                        </a>
                    </li>
                    <li class="breadcrumb-item active">
                        <i class="fas fa-bars"></i>
                         Platillos de Menú
                    </li>
                </ol>
            </div>
            <div class="container-fluid row p-1">
                <div class="col-md-9 bg-light py-2 border rounded">
                    <small class="fw-semibold fs-5 text-info"><b>Elige el PLATILLO a gestionar o agrega una nueva</b>.</small>
                </div>
                @can('crear-platillo')
                    <div class="col-md-3">
                        <a class="btn btn-primary btn-block" data-toggle="modal" data-target="#modalRegistro">
                            <i class="fas fa-plus-circle"></i>
                            Agregar Platillo
                        </a>
                    </div>
                @endcan
            </div>
        </div>

        <!--Concentrado de datos-->
        <div class="container-fluid row bg-white rounde shadow">
            <table class="table table-striped table-hover">
                <thead>
                    <tr class="table-info">
                        <th scope="col">#</th>
                        <th scope="col">Platillo</th>
                        <th scope="col">Precio</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody id="contenedorPlatillos">
                    @can('ver-platillos')
                        @if ( count($platillos) > 0 )
                        
                            @foreach ($platillos as $platillo)
                                @can('ver-platillo')
                                    <tr>
                                        <td>{{ $platillo->id }}</td>
                                        <td>{{ $platillo->nombrePlatillo }}</td>
                                        <td>$ {{ $platillo->precioPlatillo }} M.N.</td>
                                        <td>
                                            @can('editar-platillo')
                                                <a class="btn btn-info editar" role="button" title="Editar Platillo" data-toggle="modal" data-target="#modalEdicion" data-id="{{ $platillo->id }}">
                                                    <i class="fas fa-edit"></i> Editar
                                                </a>
                                            @endcan
                                            @can('borrar-platillo')
                                                <a class="btn btn-danger eliminar" role="button" title="Eliminar Platillo" data-toggle="modal" data-target="#modalEliminacion" data-id="{{ $platillo->id }}">
                                                    <i class="fas fa-trash-alt"></i> Eliminar
                                                </a>
                                            @endcan
                                        </td>
                                    </tr>
                                @endcan
                            @endforeach
                            
                        @else

                            <tr>
                                <td colspan="4" class="text-center"><i class="fas fa-info-circle"></i> Sin platillos de menú agregados.</td>
                            </tr>
                            
                        @endif
                    @endcan
                </tbody>
            </table>
        </div>

        <!--Modal de Registro-->
        <div class="modal fade" id="modalRegistro" tabindex="-1" aria-labellebdy="modalRegistroLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header border-bottom">
                        <h3 class="modal-title fs-4 fw-semibold">Nuevo Platillo</h3>
                        <button type="button" class="btn btn-close" data-dismiss="modal" aria-label="close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group bg-light">
                            <small class="p-2">Captura los siguientes datos:</small>
                        </div>
                        <form novalidate>
                            @csrf
                            <div class="form-group">
                                <label for="platillo">Platillo</label>
                                <input type="text" id="platillo" name="platillo" required class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="precio">Precio</label>
                                <input type="text" id="precio" name="precio" required class="form-control">
                            </div>
                                <div class="form-group">
                                    <button type="submit" id="registrar" class="btn btn-primary btn-block">Agregar</button>
                                </div>
                            <input type="hidden" name="token" id="token" value="{{ csrf_token() }}">
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!--Modal de Edición-->
        <div class="modal fade" id="modalEdicion" tabindex="-1" aria-labellebdy="modalEdicionLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header border-bottom">
                        <h3 class="modal-title fs-4 fw-semibold">Editar Platillo</h3>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-secondary py-1 fw-semibold fs-6">Edita los datos como creas necesario:</p>
                        <form novalidate>
                        <div class="form-group">
                                <label for="platilloEditar">Platillo</label>
                                <input type="text" id="platilloEditar" name="platilloEditar" required class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="precioEditar">Precio</label>
                                <input type="text" id="precioEditar" name="precioEditar" required class="form-control">
                            </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-block" id="actualizar">Guardar Cambios</button>
                                </div>
                            <input type="hidden" name="token" id="token" value="{{ csrf_token() }}">
                            <input type="hidden" name="idPlatillo" id="idPlatillo" >
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!--Modal de Eliminación-->
        <div class="modal fade" id="modalEliminacion" tabindex="-1" aria-labellebdy="modalEdicionLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header border-bottom">
                        <h3 class="modal-title fs-4 fw-semibold">Eliminar Platillo</h3>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group bg-light p-1">
                            <small class="text-danger fw-semibold fs-6">El <b>PLATILLO</b> y todos los datos relacionados con el serán borrados permanentemente.</small>
                        </div>
                        <form novalidate>
                            <div class="form-group">
                                <label for="platilloEliminar">Platillo</label>
                                <input type="text" name="platilloEliminar" id="platilloEliminar" readonly="true" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="precioEliminar">Precio</label>
                                <input type="text" id="precioEliminar" name="precioEliminar" readonly="true" class="form-control">
                            </div>
                                <div class="form-group">
                                    <input type="checkbox" name="borrar" id="borrar" class="position-relative top-0 start-0">
                                    <small class="fs-6 fw-semibold float-end" for>He leído la advertencia y aún deseo continuar.</small>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-block" id="eliminar">Eliminar</button>
                                </div>
                            <input type="hidden" name="token" id="token" value="{{ csrf_token() }}">
                            <input type="hidden" name="idPlatillo" id="idPlatillo" >
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!--AJAX-->
        <script src="{{ asset('js/jquery-3.6.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/sweetAlert.js') }}" type="text/javascript"></script>
        <script src="{{ asset('storage/js/platillos/agregar.js') }}" type="text/javascript"></script>
        <script src="{{ asset('storage/js/platillos/editar.js') }}" type="text/javascript"></script>
        <script src="{{ asset('storage/js/platillos/actualizar.js') }}" type="text/javascript"></script>
        <script src="{{ asset('storage/js/platillos/activarEliminar.js') }}" type="text/javascript"></script>
        <script src="{{ asset('storage/js/platillos/eliminar.js') }}" type="text/javascript"></script>
    </div>
@stop