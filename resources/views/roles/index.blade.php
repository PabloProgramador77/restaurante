@extends('home')
@section('content')
    <div class="container-fluid my-2">

        <!--Encabezado-->
        <div class="container-fluid row bg-white rounded border-bottom my-1">
            <h3 class="fw-bold fs-5 col-md-8 my-2">Roles de Usuarios</h3>
            <div class="col-md-4">
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item">
                        <a href="{{ url('/home') }}">
                            <i class="fas fa-home"></i> Inicio
                        </a>
                    </li>
                    <li class="breadcrumb-item active">
                        <i class="fas fa-user-tag"></i>
                         Roles de Usuarios
                    </li>
                </ol>
            </div>
            <div class="container-fluid row p-1">
                <div class="col-md-9 bg-light py-2 border rounded">
                    <small class="fw-semibold fs-5 text-info"><b>Elige el ROL a gestionar o agrega uno nuevo</b>.</small>
                </div>
                @can('crear-role')
                    <div class="col-md-3">
                        <a class="btn btn-primary btn-block" data-toggle="modal" data-target="#modalRegistro">
                            <i class="fas fa-plus-circle"></i>
                            Agregar Rol
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
                        <th scope="col">Rol</th>
                        <th scope="col">Fecha y hora</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody id="contenedorRoles">
                    @can('ver-roles')
                        @if ( count($roles) > 0 )
                                
                                @foreach ($roles as $rol)
                                    @can('ver-role')
                                        <tr>
                                            <td>{{ $rol->id }}</td>
                                            <td>{{ $rol->name }}</td>
                                            <td>{{ $rol->created_at }}</td>
                                            <td>
                                                @can('editar-role')
                                                    <a class="btn btn-info editar" role="button" title="Editar rol" data-toggle="modal" data-target="#modalEdicion" data-id="{{ $rol->id }}">
                                                        <i class="fas fa-edit"></i> Editar
                                                    </a>
                                                @endcan
                                                @can('borrar-role')
                                                    <a class="btn btn-danger eliminar" role="button" title="Eliminar rol" data-toggle="modal" data-target="#modalEliminacion" data-id="{{ $rol->id }}">
                                                        <i class="fas fa-trash-alt"></i> Eliminar
                                                    </a>
                                                @endcan
                                                @can('asignar-permiso')
                                                    <a class="btn btn-primary asignar" role="button" title="Asignar permisos" data-toggle="modal" data-target="#modalPermisos" data-id="{{ $rol->id }}">
                                                        <i class="fas fa-signature"></i> Permisos
                                                    </a>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endcan

                                @endforeach

                        @else

                            <tr>
                                <td colspan="4" class="text-center"><i class="fas fa-info-circle"></i> Sin roles agregados.</td>
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
                        <h3 class="modal-title fs-4 fw-semibold">Nuevo rol</h3>
                        <button type="button" class="btn btn-close" data-dismiss="modal" aria-label="close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group bg-light">
                            <small class="p-2">Captura los siguientes datos:</small>
                        </div>
                        <form novalidate>
                            @csrf
                            <div class="form-group">
                                <label for="rol">Rol</label>
                                <input type="text" id="rol" name="rol" required class="form-control">
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
                        <h3 class="modal-title fs-4 fw-semibold">Editar rol</h3>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-secondary py-1 fw-semibold fs-6">Edita los datos como creas necesario:</p>
                        <form novalidate>
                        <div class="form-group">
                                <label for="rolEditar">Rol</label>
                                <input type="text" id="rolEditar" name="rolEditar" required class="form-control">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block" id="actualizar">Guardar Cambios</button>
                            </div>
                            <input type="hidden" name="token" id="token" value="{{ csrf_token() }}">
                            <input type="hidden" name="idRolEditar" id="idRolEditar" >
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
                        <h3 class="modal-title fs-4 fw-semibold">Eliminar rol</h3>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group bg-light p-1">
                            <small class="text-danger fw-semibold fs-6">El <b>rol</b> y todos los datos relacionados con el serán borrados permanentemente.</small>
                        </div>
                        <form novalidate>
                            <div class="form-group">
                                <label for="rolEliminar">Rol</label>
                                <input type="text" name="rolEliminar" id="rolEliminar" readonly="true" class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="borrar" id="borrar" class="position-relative top-0 start-0">
                                <small class="fs-6 fw-semibold float-end" for>He leído la advertencia y aún deseo continuar.</small>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block" id="eliminar">Eliminar</button>
                            </div>
                            <input type="hidden" name="token" id="token" value="{{ csrf_token() }}">
                            <input type="hidden" name="idRolEliminar" id="idRolEliminar" >
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!--Modal de Permisos-->
        <div class="modal fade" id="modalPermisos" tabindex="-1" aria-labellebdy="modalPermisosLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header border-bottom">
                        <h3 class="modal-title fs-5 fw-bold" id="tituloRole">Permisos de Usuario</h3>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group bg-light p-1">
                            <small class="text-info fw-semibold fs-6">A continuación, selecciona los <b>PERMISOS</b> que deseas agregar al rol de usuario:</small>
                        </div>
                        <form novalidate class="row">
                            @if ( count($permisos) > 0 )
                                
                                    @foreach ($permisos as $permiso)
                                        <div class="custom-control custom-switch d-inline col-md-3 my-1">
                                            <input type="checkbox" class="custom-control-input" name="permiso" id="{{ $permiso->name }}" value="{{ $permiso->id }}">
                                            <label class="custom-control-label" for="{{ $permiso->name }}">{{ $permiso->name }}    
                                        </div>        
                                    @endforeach
                                
                            @else
                                <div class="container-fluid col-md-12">
                                    <p class="text-info bg-light p-2 rounded text-center">Sin permisos registrados.
                                        <a href="{{ url('/permisos') }}" class="btn btn-primary" role="button">
                                            <i class="fas fa-plus-circle"></i>
                                        </a>
                                    </p>
                                </div>
                            @endif
                                <div class="modal-footer col-md-12">
                                    <button type="submit" id="permisos" class="btn btn-primary"><i class="fas fa-save"></i> Guardar Permisos</button>
                                </div>
                            <input type="hidden" name="idRole" id="idRole">
                            <input type="hidden" name="token" id="token" value="{{ csrf_token() }}">
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!--AJAX-->
        <script src="{{ asset('js/jquery-3.6.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/sweetAlert.js') }}" type="text/javascript"></script>
        <script src="{{ asset('storage/js/roles/agregar.js') }}" type="text/javascript"></script>
        <script src="{{ asset('storage/js/roles/editar.js') }}" type="text/javascript"></script>
        <script src="{{ asset('storage/js/roles/actualizar.js') }}" type="text/javascript"></script>
        <script src="{{ asset('storage/js/roles/activarEliminar.js') }}" type="text/javascript"></script>
        <script src="{{ asset('storage/js/roles/eliminar.js') }}" type="text/javascript"></script>
        <script src="{{ asset('storage/js/roles/permisos.js') }}" type="text/javascript"></script>
    </div>
@stop