@extends('home')
@section('content')
    <div class="container-fluid my-2">

        <!--Encabezado-->
        <div class="container-fluid row bg-white rounded border-bottom my-1">
            <h3 class="fw-bold fs-5 col-md-8 my-2"><i class="fas fa-lemon"></i> Sabores de Platillos</h3>
            <div class="col-md-4">
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item">
                        <a href="{{ url('/home') }}">
                            <i class="fas fa-home"></i> Inicio
                        </a>
                    </li>
                    <li class="breadcrumb-item active">
                        <i class="fas fa-lemon"></i> Sabores
                    </li>
                </ol>
            </div>
            <div class="container-fluid row p-1">
                <div class="col-md-10 bg-warning py-1 border">
                    <small class="fw-semibold fs-5">
                        <i class="fas fa-info-circle"></i><b> Elige el SABOR a gestionar o agrega uno nuevo pulsando el botón "<i class="fas fa-plus-circle"></i> Sabor".</b>
                        Si tienes dudas visita los videomanuales <a href="{{ url('/videos') }}">aquí</a>
                    </small>
                </div>
                <div class="col-md-2">
                    <a class="btn btn-primary btn-block" data-toggle="modal" data-target="#modalRegistro">
                        <i class="fas fa-plus-circle"></i> Sabor
                    </a>
                </div>
            </div>
        </div>

        <!--Concentrado de datos-->
        <div class="container-fluid row bg-white rounde shadow">
            <table class="table table-striped table-hover">
                <thead>
                    <tr class="table-info">
                        <th scope="col">N°</th>
                        <th scope="col">Sabor</th>
                        <th scope="col">Descripción</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody id="contenedorSabores">
        
                        @if ( count($sabores) > 0 )
                                
                                @foreach ($sabores as $sabor)
                                    
                                        <tr>
                                            <td>{{ $sabor->id }}</td>
                                            <td>{{ $sabor->nombre }}</td>
                                            <td>{{ $sabor->descripcion }}</td>
                                            <td>
                                                
                                                    <a class="btn btn-info editar" role="button" title="Editar sabor" data-toggle="modal" data-target="#modalEdicion" data-id="{{ $sabor->id }}">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                
                                                    <a class="btn btn-danger eliminar" role="button" title="Eliminar sabor" data-toggle="modal" data-target="#modalEliminacion" data-id="{{ $sabor->id }}">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </a>
                                                
                                                    <a class="btn btn-primary asignar" role="button" title="Asignar a platillos" data-toggle="modal" data-target="#modalPlatillos" data-id="{{ $sabor->id }}">
                                                        <i class="fas fa-utensils"></i>
                                                    </a>
                                                
                                            </td>
                                        </tr>
                                    

                                @endforeach

                        @else

                            <tr>
                                <td colspan="4" class="text-center text-danger"><i class="fas fa-info-circle"></i> Sin sabores registrados.</td>
                            </tr>
                            
                        @endif

                </tbody>
            </table>
        </div>

        <!--Modal de Registro-->
        <div class="modal fade" id="modalRegistro" tabindex="-1" aria-labellebdy="modalRegistroLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="bg-primary modal-header border-bottom">
                        <h3 class="modal-title fs-4 fw-semibold"><i class="fas fa-plus-circle"></i> Nuevo sabor</h3>
                        <button type="button" class="btn btn-close" data-dismiss="modal" aria-label="close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group bg-light">
                            <p class="p-2"><i class="fas fa-info-circle"></i> Captura los siguientes datos. Los campos con etiqueta * son obligatorios.</p>
                        </div>
                        <form novalidate>
                            @csrf
                            <div class="form-group">
                                <label for="sabor">* Sabor</label>
                                <input type="text" id="sabor" name="sabor" required class="form-control">
                            </div>
                            <div class="fomr-group">
                                <label for="descripcion">Descripción</label>
                                <textarea name="descripcion" id="descripcion" class="form-control"></textarea>
                            </div>
                            
                            <input type="hidden" name="token" id="token" value="{{ csrf_token() }}">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <div class="form-group">
                            <button type="submit" id="registrar" class="btn btn-success btn-block"><i class="fas fa-save"></i> Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--Modal de Edición-->
        <div class="modal fade" id="modalEdicion" tabindex="-1" aria-labellebdy="modalEdicionLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header border-bottom">
                        <h3 class="modal-title fs-4 fw-semibold"><i class="fas fa-edit"></i> Editar sabor</h3>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-secondary py-1 fw-semibold fs-6">Edita los datos como creas necesario:</p>
                        <form novalidate>
                        <div class="form-group">
                            <label for="sabor">* Sabor</label>
                            <input type="text" id="saborEditar" name="saborEditar" required class="form-control">
                        </div>
                        <div class="fomr-group">
                            <label for="descripcion">Descripción</label>
                            <textarea name="descripcionEditar" id="descripcionEditar" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block" id="actualizar">Guardar cambios</button>
                        </div>
                        <input type="hidden" name="token" id="token" value="{{ csrf_token() }}">
                        <input type="hidden" name="idSaborEditar" id="idSaborEditar" >
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
                        <h3 class="modal-title fs-4 fw-semibold"><i class="fas fa-trash"></i> Eliminar sabor</h3>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group bg-light p-1">
                            <small class="text-danger fw-semibold fs-6">El <b>SABOR</b> y todos los datos relacionados con el serán borrados permanentemente.</small>
                        </div>
                        <form novalidate>
                            <div class="form-group">
                                <label for="saborEliminar">* Sabor</label>
                                <input type="text" id="saborEliminar" name="saborEliminar" required class="form-control" readonly="true">
                            </div>
                            <div class="fomr-group">
                                <label for="descripcionEliminar">Descripción</label>
                                <textarea name="descripcionEliminar" id="descripcionEliminar" class="form-control" readonly="true"></textarea>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="borrar" id="borrar" class="position-relative top-0 start-0">
                                <small class="fs-6 fw-semibold float-end" for>He leído la advertencia y aún deseo continuar.</small>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block" id="eliminar">Eliminar</button>
                            </div>
                            <input type="hidden" name="token" id="token" value="{{ csrf_token() }}">
                            <input type="hidden" name="idSaborEliminar" id="idSaborEliminar" >
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!--Modal de Platillos-->
        <div class="modal fade" id="modalPlatillos" tabindex="-1" aria-labellebdy="modalPlatillosLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header border-bottom">
                        <h3 class="modal-title fs-5 fw-bold" id="tituloSabor">Platillos</h3>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group bg-warning p-1">
                            <small class="fw-semibold fs-6"><i class="fas fa-info-circle"></i> A continuación, elige los <b>PLATILLOS</b> a los que deseas agregar el sabor</small>
                        </div>
                        <form novalidate class="row">
                            @if ( count($platillos) > 0 )
                                
                                    @foreach ($platillos as $platillo)
                                        <div class="custom-control custom-switch d-inline col-md-3 my-1">
                                            <input type="checkbox" class="custom-control-input" name="platillo" id="{{ $platillo->nombrePlatillo }}" value="{{ $platillo->id }}">
                                            <label class="custom-control-label" for="{{ $platillo->nombrePlatillo }}">{{ $platillo->nombrePlatillo }}    
                                        </div>        
                                    @endforeach
                                
                            @else
                                <div class="container-fluid col-md-12">
                                    <p class="text-info bg-light p-2 rounded text-center text-danger">Sin platillos registrados.
                                        <a href="{{ url('/platillos') }}" class="btn btn-primary" role="button">
                                            <i class="fas fa-plus-circle"></i>
                                        </a>
                                    </p>
                                </div>
                            @endif
                            <div class="modal-footer col-md-12">
                                <button type="submit" id="asignar" class="btn btn-primary"><i class="fas fa-save"></i> Agregar</button>
                            </div>
                            <input type="hidden" name="idSabor" id="idSabor">
                            <input type="hidden" name="token" id="token" value="{{ csrf_token() }}">
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!--AJAX-->
        <script src="{{ asset('js/jquery-3.6.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/sweetAlert.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/sabores/agregar.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/sabores/editar.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/sabores/actualizar.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/sabores/activarEliminar.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/sabores/eliminar.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/sabores/platillos.js') }}" type="text/javascript"></script>
    </div>
@stop