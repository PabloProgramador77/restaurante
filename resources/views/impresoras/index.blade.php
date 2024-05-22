@extends('home')
@section('content')
    <div class="container-fluid my-2">

        <!--Encabezado-->
        <div class="container-fluid row bg-white rounded border-bottom my-1">
            <h3 class="fw-bold fs-5 col-md-8 my-2"><i class="fas fa-print"></i> Impresoras de Negocio</h3>
            <div class="col-md-4">
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item">
                        <a href="{{ url('/home') }}">
                            <i class="fas fa-home"></i> Inicio
                        </a>
                    </li>
                    <li class="breadcrumb-item active">
                        <i class="fas fa-print"></i>
                         Mis Impresoras
                    </li>
                </ol>
            </div>
            <div class="container-fluid row p-1">
                <div class="col-md-9 bg-light py-2 border rounded">
                    <small class="fw-semibold fs-5 text-info"><b>Elige la impresora a gestionar o agrega una nueva</b>.</small>
                </div>
                <div class="col-md-3">
                    <a class="btn btn-primary btn-block" data-toggle="modal" data-target="#modalRegistro">
                        <i class="fas fa-plus-circle"></i>
                        Agregar Impresora
                    </a>
                </div>
            </div>
        </div>

        <!--Concentrado de datos-->
        <div class="container-fluid row bg-white rounde shadow">
            <table class="table table-striped table-hover">
                <thead>
                    <tr class="table-info">
                        <th scope="col">#</th>
                        <th scope="col">Impresora</th>
                        <th scope="col">Función de Impresión</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                    <tbody id="contenedorImpresoras">
                        @if ( count($impresoras) > 0 )
                                
                                @foreach ($impresoras as $impresora)
                                    
                                    <tr>
                                        <td>{{ $impresora->id }}</td>
                                        <td>{{ $impresora->seriePrint }}</td>
                                        <td>{{ $impresora->tipoImpresion }}</td>
                                        <td>
                                            <a class="btn btn-info editar" role="button" title="Editar Impresora" data-toggle="modal" data-target="#modalEdicion" data-id="{{ $impresora->id }}">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a class="btn btn-danger eliminar" role="button" title="Eliminar Impresora" data-toggle="modal" data-target="#modalEliminacion" data-id="{{ $impresora->id }}">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                            <a class="btn btn-secondary prueba" role="button" title="Prueba de Impresión" data-id="{{ $impresora->id }}">
                                                <i class="fas fa-print"></i>
                                            </a>
                                        </td>
                                    </tr>    

                                @endforeach

                            @else

                                <tr>
                                    <td colspan="4" class="text-center"><i class="fas fa-info-circle"></i> Sin impresoras agregadas.</td>
                                </tr>
                                
                            @endif
                    </tbody>
            </table>
        </div>

        <!--Modal de Registro-->
        <div class="modal fade" id="modalRegistro" tabindex="-1" aria-labellebdy="modalRegistroLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header border-bottom">
                        <h3 class="modal-title fs-4 fw-semibold">Nueva Impresora</h3>
                        <button type="button" class="btn btn-close" data-dismiss="modal" aria-label="close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group bg-light">
                            <small class="p-2">Captura los siguientes datos:</small>
                        </div>
                        <form novalidate>
                            @csrf
                            <div class="form-group">
                                <label for="impresora">Id de Impresora</label>
                                <input type="text" id="impresora" name="impresora" required class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="funcion">Función de Impresora</label>
                                <select name="funcion" id="funcion" class="form-control" required>
                                    <option value="Comandas">Comandas</option>
                                    <option value="Tickets">Tickets</option>
                                    <option value="Comandas y Tickets">Comandas y Tickets</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <button type="submit" id="registrar" name="registrar" class="btn btn-primary btn-block">Agregar</button>
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
                        <h3 class="modal-title fs-4 fw-semibold">Editar Impresora</h3>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-secondary py-1 fw-semibold fs-6">Edita los datos como creas necesario:</p>
                        <form novalidate>
                            <div class="form-group">
                                <label for="impresoraEditar">Impresora</label>
                                <input type="text" name="impresoraEditar" id="impresoraEditar" required class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="funcionEditar">Función de Impresora</label>
                                <select name="funcionEditar" id="funcionEditar" class="form-control" required>
                                    <option value="Comandas">Comandas</option>
                                    <option value="Tickets">Tickets</option>
                                    <option value="Comandas y Tickets">Comandas y Tickets</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block" id="actualizar">Guardar Cambios</button>
                            </div>
                            <input type="hidden" name="token" id="token" value="{{ csrf_token() }}">
                            <input type="hidden" name="idImpresoraEditar" id="idImpresoraEditar" >
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
                        <h3 class="modal-title fs-4 fw-semibold">Eliminar Impresora</h3>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group bg-light p-1">
                            <small class="text-danger fw-semibold fs-6">La <b>Impresora</b> y todos los datos relacionados con ella serán borrados permanentemente.</small>
                        </div>
                        <form novalidate>
                            <div class="form-group">
                                <label for="impresoraEliminar">Impresora</label>
                                <input type="text" name="impresoraEliminar" id="impresoraEliminar" readonly="true" class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="borrar" id="borrar" class="position-relative top-0 start-0">
                                <small class="fs-6 fw-semibold float-end" for>He leído la advertencia y aún deseo continuar.</small>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block" id="eliminar">Eliminar</button>
                            </div>
                            <input type="hidden" name="token" id="token" value="{{ csrf_token() }}">
                            <input type="hidden" name="idImpresora" id="idImpresora" >
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!--AJAX-->
    <script src="{{ asset('js/jquery-3.6.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/sweetAlert.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/impresoras/agregar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/impresoras/editar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/impresoras/actualizar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/impresoras/activarEliminar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/impresoras/eliminar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/impresoras/prueba.js') }}" type="text/javascript"></script>
@stop