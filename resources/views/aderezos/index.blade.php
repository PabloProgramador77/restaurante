@extends('home')
@section('content')
    <div class="container-fluid my-2">

        <!--Encabezado-->
        <div class="container-fluid row bg-white rounded border-bottom my-1">
            <h3 class="fw-bold fs-5 col-md-8 my-2"><i class="fas fa-lemon"></i> Aderezos de Platillos</h3>
            <div class="col-md-4">
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item">
                        <a href="{{ url('/home') }}">
                            <i class="fas fa-home"></i> Inicio
                        </a>
                    </li>
                    <li class="breadcrumb-item active">
                        <i class="fas fa-wine-bottle"></i> Aderezos
                    </li>
                </ol>
            </div>
            <div class="container-fluid row p-1">
                <div class="col-md-10 bg-warning py-1 border">
                    <small class="fw-semibold fs-5">
                        <i class="fas fa-info-circle"></i><b> Elige el ADEREZO a gestionar o agrega uno nuevo pulsando el botón "<i class="fas fa-plus-circle"></i> Aderezo".</b>
                        Si tienes dudas visita los videomanuales <a href="{{ url('/videos') }}">aquí</a>
                    </small>
                </div>
                <div class="col-md-2">
                    <a class="btn btn-primary btn-block" data-toggle="modal" data-target="#modalRegistro">
                        <i class="fas fa-plus-circle"></i> Aderezo
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
                        <th scope="col">Aderezo</th>
                        <th scope="col">Descripción</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody id="contenedoraderezos">
        
                        @if ( count($aderezos) > 0 )
                                
                                @foreach ($aderezos as $aderezo)
                                    
                                        <tr>
                                            <td>{{ $aderezo->id }}</td>
                                            <td>{{ $aderezo->nombre }}</td>
                                            <td>{{ $aderezo->descripcion }}</td>
                                            <td>
                                                
                                                    <a class="btn btn-info editar" role="button" title="Editar aderezo" data-toggle="modal" data-target="#modalEdicion" data-id="{{ $aderezo->id }}">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                
                                                    <a class="btn btn-danger eliminar" role="button" title="Eliminar aderezo" data-toggle="modal" data-target="#modalEliminacion" data-id="{{ $aderezo->id }}">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </a>
                                                
                                                    <a class="btn btn-primary asignar" role="button" title="Asignar a platillos" data-toggle="modal" data-target="#modalPlatillos" data-id="{{ $aderezo->id }}">
                                                        <i class="fas fa-utensils"></i>
                                                    </a>
                                                
                                            </td>
                                        </tr>
                                    

                                @endforeach

                        @else

                            <tr>
                                <td colspan="4" class="text-center text-danger"><i class="fas fa-info-circle"></i> Sin aderezos registrados.</td>
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
                        <h3 class="modal-title fs-4 fw-semibold"><i class="fas fa-plus-circle"></i> Nuevo aderezo</h3>
                        <button type="button" class="btn btn-close" data-dismiss="modal" aria-label="close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group bg-light">
                            <p class="p-2"><i class="fas fa-info-circle"></i> Captura los siguientes datos. Los campos con etiqueta * son obligatorios.</p>
                        </div>
                        <form novalidate>
                            @csrf
                            <div class="form-group">
                                <label for="aderezo">* Aderezo</label>
                                <input type="text" id="aderezo" name="aderezo" required class="form-control">
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
                        <h3 class="modal-title fs-4 fw-semibold"><i class="fas fa-edit"></i> Editar aderezo</h3>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-secondary py-1 fw-semibold fs-6">Edita los datos como creas necesario:</p>
                        <form novalidate>
                        <div class="form-group">
                            <label for="aderezo">* Aderezo</label>
                            <input type="text" id="aderezoEditar" name="aderezoEditar" required class="form-control">
                        </div>
                        <div class="fomr-group">
                            <label for="descripcion">Descripción</label>
                            <textarea name="descripcionEditar" id="descripcionEditar" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block" id="actualizar">Guardar cambios</button>
                        </div>
                        <input type="hidden" name="token" id="token" value="{{ csrf_token() }}">
                        <input type="hidden" name="idAderezoEditar" id="idAderezoEditar" >
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
                        <h3 class="modal-title fs-4 fw-semibold"><i class="fas fa-trash"></i> Eliminar aderezo</h3>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group bg-light p-1">
                            <small class="text-danger fw-semibold fs-6">El <b>ADEREZO</b> y todos los datos relacionados con el serán borrados permanentemente.</small>
                        </div>
                        <form novalidate>
                            <div class="form-group">
                                <label for="aderezoEliminar">*Aderezo</label>
                                <input type="text" id="aderezoEliminar" name="aderezoEliminar" required class="form-control" readonly="true">
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
                            <input type="hidden" name="idAderezoEliminar" id="idAderezoEliminar" >
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
                        <h3 class="modal-title fs-5 fw-bold" id="tituloaderezo">Platillos</h3>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group bg-warning p-1">
                            <small class="fw-semibold fs-6"><i class="fas fa-info-circle"></i> A continuación, elige los <b>PLATILLOS</b> a los que deseas agregar el aderezo</small>
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
                            <input type="hidden" name="idAderezo" id="idAderezo">
                            <input type="hidden" name="token" id="token" value="{{ csrf_token() }}">
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!--AJAX-->
        <script src="{{ asset('js/jquery-3.6.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/sweetAlert.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/aderezos/agregar.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/aderezos/editar.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/aderezos/actualizar.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/aderezos/activarEliminar.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/aderezos/eliminar.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/aderezos/platillos.js') }}" type="text/javascript"></script>
    </div>
@stop