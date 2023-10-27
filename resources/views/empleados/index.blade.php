@extends('home')
@section('content')
    <div class="container-fluid my-2">

        <!--Encabezado-->
        <div class="container-fluid row bg-white rounded border-bottom my-1">
            <h3 class="fw-bold fs-5 col-md-8 my-2">Empleados</h3>
            <div class="col-md-4">
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item">
                        <a href="{{ url('/home') }}">
                            <i class="fas fa-home"></i> Inicio
                        </a>
                    </li>
                    <li class="breadcrumb-item active">
                        <i class="fas fa-users"></i>
                         Empleados
                    </li>
                </ol>
            </div>
            <div class="container-fluid row p-1">
                <div class="col-md-9 bg-light py-2 border rounded">
                    <small class="fw-semibold fs-5 text-info"><b>Elige el EMPLEADO a gestionar o agrega uno nuevo</b>.</small>
                </div>
                <div class="col-md-3">
                    @can('Crear empleado')
                        <a class="btn btn-primary btn-block" data-toggle="modal" data-target="#modalRegistro">
                            <i class="fas fa-plus-circle"></i>
                            Agregar Empleado
                        </a>
                    @endcan
                </div>
            </div>
        </div>

        <!--Concentrado de datos-->
        <div class="container-fluid row bg-white rounde shadow">
            <table class="table table-striped table-hover">
                <thead>
                    <tr class="table-info">
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Email</th>
                        <th scope="col">Rol</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody id="contenedorEmpleados">
                    @if ( count($empleados) > 0 )
                        
                        @can('Ver empleados')
                            @foreach ($empleados as $empleado)
                                
                                <tr>
                                    <td>{{ $empleado->id }}</td>
                                    <td>{{ $empleado->name }}</td>
                                    <td>{{ $empleado->email }}</td>
                                    <td>{{ $empleado->role() }}</td>
                                    <td>
                                        @can('Editar empleado')
                                            <a class="btn btn-info editar" role="button" title="Editar rol" data-toggle="modal" data-target="#modalEdicion" data-id="{{ $empleado->id }}">
                                                <i class="fas fa-edit"></i> Editar
                                            </a>
                                        @endcan
                                        @can('Borrar empleado')
                                            <a class="btn btn-danger eliminar" role="button" title="Eliminar rol" data-toggle="modal" data-target="#modalEliminacion" data-id="{{ $empleado->id }}">
                                                <i class="fas fa-trash-alt"></i> Eliminar
                                            </a>
                                        @endcan
                                        @can('Cambiar rol')
                                            <a class="btn btn-secondary role" role="button" title="Cambiar Rol" data-toggle="modal" data-target="#modalRole" data-id="{{ $empleado->id }}">
                                                <i class="fas fa-user-alt"></i> Rol
                                            </a>
                                        @endcan
                                    </td>
                                </tr>

                            @endforeach
                        @endcan

                    @else

                        <tr>
                            <td colspan="4" class="text-center"><i class="fas fa-info-circle"></i> Sin empleados agregados.</td>
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
                        <h3 class="modal-title fs-4 fw-semibold">Nuevo Empleado</h3>
                        <button type="button" class="btn btn-close" data-dismiss="modal" aria-label="close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group bg-light">
                            <small class="p-2">Captura los siguientes datos:</small>
                        </div>
                        <form novalidate>
                            @csrf
                            <div class="form-group">
                                <label for="nombre">Nombre</label>
                                <input type="text" id="nombre" name="nombre" required class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="rol">Rol</label>
                                <select name="rol" id="rol" class="form-control" required>
                                    @foreach($roles as $rol)
                                        <option value="{{ $rol->id }}">{{ $rol->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="email">Email de acceso</label>
                                <input type="email" id="email" name="email" required class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="password">Contraseña de acceso</label>
                                <input type="password" id="password" name="password" required class="form-control">
                            </div>
                            @can('Crear empleado')
                                <div class="form-group">
                                    <button type="submit" id="registrar" class="btn btn-primary btn-block">Agregar</button>
                                </div>
                            @endcan
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
                        <h3 class="modal-title fs-4 fw-semibold">Editar Empleado</h3>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-secondary py-1 fw-semibold fs-6">Edita los datos como creas necesario:</p>
                        <form novalidate>
                            <div class="form-group">
                                <label for="nombreEditar">Nombre</label>
                                <input type="text" id="nombreEditar" name="nombreEditar" required class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="emailEditar">Email de acceso</label>
                                <input type="email" id="emailEditar" name="emailEditar" required class="form-control">
                            </div>
                            @can('Editar empleado')
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-block" id="actualizar">Guardar Cambios</button>
                                </div>
                            @endcan
                            <input type="hidden" name="token" id="token" value="{{ csrf_token() }}">
                            <input type="hidden" name="idEmpleadoEditar" id="idEmpleadoEditar" >
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
                        <h3 class="modal-title fs-4 fw-semibold">Eliminar Empleado</h3>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group bg-light p-1">
                            <small class="text-danger fw-semibold fs-6">El <b>EMPLEADO</b> y todos los datos relacionados con el serán borrados permanentemente.</small>
                        </div>
                        <form novalidate>
                            <div class="form-group">
                                <label for="nombreEliminar">Nombre</label>
                                <input type="text" id="nombreEliminar" name="nombreEliminar" readonly="true" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="emailEliminar">Email</label>
                                <input type="text" name="emailEliminar" id="emailEliminar" readonly="true" class="form-control">
                            </div>
                            @can('Borrar empleado')
                                <div class="form-group">
                                    <input type="checkbox" name="borrar" id="borrar" class="position-relative top-0 start-0">
                                    <small class="fs-6 fw-semibold float-end" for>He leído la advertencia y aún deseo continuar.</small>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-block" id="eliminar">Eliminar</button>
                                </div>
                            @endcan
                            <input type="hidden" name="token" id="token" value="{{ csrf_token() }}">
                            <input type="hidden" name="idEmpleadoEliminar" id="idEmpleadoEliminar" >
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!--Modal de Edición de Rol-->
        <div class="modal fade" id="modalRole" tabindex="-1" aria-labellebdy="modalRoleLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header border-bottom">
                        <h3 class="modal-title fs-4 fw-semibold">Cambio de Rol</h3>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group bg-light p-1">
                            <small class="text-info fw-semibold fs-6">Elige el nuevo <b>ROL</b> del <b>EMPLEADO</b></small>
                        </div>
                        <form novalidate>
                            <div class="form-group">
                                <label for="nombreRole">Nombre</label>
                                <input type="text" id="nombreRole" name="nombreRole" readonly="true" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="roleRole">Rol Actual</label>
                                <input type="text" name="roleRole" id="roleRole" readonly="true" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="rolRole">Rol Nuevo</label>
                                <select name="rolRole" id="rolRole" required class="form-control">
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @can('Cambiar rol')
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-block" id="role">Cambiar Rol</button>
                                </div>
                            @endcan
                            <input type="hidden" name="token" id="token" value="{{ csrf_token() }}">
                            <input type="hidden" name="idEmpleadoRole" id="idEmpleadoRole" >
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!--AJAX-->
        <script src="{{ asset('js/jquery-3.6.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/sweetAlert.js') }}" type="text/javascript"></script>
        <script src="{{ asset('storage/js/empleados/agregar.js') }}" type="text/javascript"></script>
        <script src="{{ asset('storage/js/empleados/editar.js') }}" type="text/javascript"></script>
        <script src="{{ asset('storage/js/empleados/actualizar.js') }}" type="text/javascript"></script>
        <script src="{{ asset('storage/js/empleados/activarEliminar.js') }}" type="text/javascript"></script>
        <script src="{{ asset('storage/js/empleados/eliminar.js') }}" type="text/javascript"></script>
        <script src="{{ asset('storage/js/empleados/role.js') }}" type="text/javascript"></script>
    </div>
@stop