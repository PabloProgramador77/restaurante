@extends('home')
@section('content')
    <div class="container-fluid my-2">

        <!--Encabezado-->
        <div class="container-fluid row bg-white rounded border-bottom my-1">
            <h3 class="fw-bold fs-5 col-md-8 my-2">Categorías de Menú</h3>
            <div class="col-md-4">
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item">
                        <a href="{{ url('/home') }}">
                            <i class="fas fa-home"></i> Inicio
                        </a>
                    </li>
                    <li class="breadcrumb-item active">
                        <i class="fas fa-bars"></i>
                         Categorías de Menú
                    </li>
                </ol>
            </div>
            <div class="container-fluid row p-1">
                <div class="col-md-9 bg-light py-2 border rounded">
                    <small class="fw-semibold fs-5 text-info"><b>Elige la categoría a gestionar o agrega una nueva</b>.</small>
                </div>
                <div class="col-md-3">
                        <a class="btn btn-primary btn-block" data-toggle="modal" data-target="#modalRegistro">
                            <i class="fas fa-plus-circle"></i>
                            Agregar Categoría
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
                        <th scope="col">Categoría</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                    <tbody id="contenedorCategorias">
                        @if ( count($categorias) > 0 )
                            
                            @foreach ($categorias as $categoria)
                                
                                <tr>
                                    <td>{{ $categoria->id }}</td>
                                    <td>{{ $categoria->nombreCategoria }}</td>
                                    <td>
                                            <a class="btn btn-info editar" role="button" title="Editar Categoría" data-toggle="modal" data-target="#modalEdicion" data-id="{{ $categoria->id }}">
                                                <i class="fas fa-edit"></i> Editar
                                            </a>
                                        
                                            <a class="btn btn-danger eliminar" role="button" title="Eliminar Categoría" data-toggle="modal" data-target="#modalEliminacion" data-id="{{ $categoria->id }}">
                                                <i class="fas fa-trash-alt"></i> Eliminar
                                            </a>
                                        
                                            <a class="btn btn-primary menu" role="button" title="Crear Menú" data-toggle="modal" data-target="#modalMenu" data-id="{{ $categoria->id }}">
                                                <i class="fas fa-bars"></i> Menú
                                            </a>
                                        
                                    </td>
                                </tr>

                            @endforeach

                        @else

                            <tr>
                                <td colspan="3" class="text-center"><i class="fas fa-info-circle"></i> Sin categorías de menú agregadas.</td>
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
                        <h3 class="modal-title fs-4 fw-semibold">Nueva Categoría</h3>
                        <button type="button" class="btn btn-close" data-dismiss="modal" aria-label="close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group bg-light">
                            <small class="p-2">Captura los siguientes datos:</small>
                        </div>
                        <form novalidate>
                            @csrf
                            <div class="form-group">
                                <label for="categoria">Categoría</label>
                                <input type="text" id="categoria" name="categoria" required class="form-control">
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
                        <h3 class="modal-title fs-4 fw-semibold">Editar Categoría</h3>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-secondary py-1 fw-semibold fs-6">Edita los datos como creas necesario:</p>
                        <form novalidate>
                            <div class="form-group">
                                <label for="categoriaEditar">Categoría</label>
                                <input type="text" name="categoriaEditar" id="categoriaEditar" required class="form-control">
                            </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-block" id="actualizar">Guardar Cambios</button>
                                </div>
                            <input type="hidden" name="token" id="token" value="{{ csrf_token() }}">
                            <input type="hidden" name="idCategoriaEditar" id="idCategoriaEditar" >
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
                        <h3 class="modal-title fs-4 fw-semibold">Eliminar Categoría</h3>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group bg-light p-1">
                            <small class="text-danger fw-semibold fs-6">La <b>CATEGORÍA</b> y todos los datos relacionados con ella serán borrados permanentemente.</small>
                        </div>
                        <form novalidate>
                            <div class="form-group">
                                <label for="categoriaEliminar">Categoría</label>
                                <input type="text" name="categoriaEliminar" id="categoriaEliminar" readonly="true" class="form-control">
                            </div>
                                <div class="form-group">
                                    <input type="checkbox" name="borrar" id="borrar" class="position-relative top-0 start-0">
                                    <small class="fs-6 fw-semibold float-end" for>He leído la advertencia y aún deseo continuar.</small>
                                </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block" id="eliminar">Eliminar</button>
                            </div>
                            <input type="hidden" name="token" id="token" value="{{ csrf_token() }}">
                            <input type="hidden" name="idCategoria" id="idCategoria" >
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @include('categorias/menu')

    </div>

    <!--AJAX-->
    <script src="{{ asset('js/jquery-3.6.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/sweetAlert.js') }}" type="text/javascript"></script>
    <script src="{{ asset('storage/js/categorias/agregar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('storage/js/categorias/editar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('storage/js/categorias/actualizar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('storage/js/categorias/activarEliminar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('storage/js/categorias/eliminar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('storage/js/categorias/menu.js') }}" type="text/javascript"></script>
@stop