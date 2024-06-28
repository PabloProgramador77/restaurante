@extends('home')
@section('content')
    <div class="container-fluid my-2">

        <div class="container-fluid row bg-white rounded border-bottom my-1">
            <h3 class="fw-bold fs-5 col-md-8 my-2">Cortes de Caja</h3>
            <div class="col-md-4">
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item"><a href="{{ url('/home') }}"><i class="fas fa-home"></i> Inicio</a></li>
                    <li class="breadcrumb-item active"><i class="fas fa-cash-register"></i> Cortes de Caja</li>
                </ol>
            </div>
            <div class="container-fluid row p-1">
                <div class="col-md-10 bg-warning py-2">
                    <small class="fw-semibold fs-5"><i class="fas fa-info-circle"></i> <b>Elige el CORTE a gestionar o agrega uno nuevo presionando el botón <i class="fas fa-plus-circle"></i> Corte</b>. Si tienes dudas visita los videomanuales <a href="{{ url('/videos') }}">aquí</a></small>
                </div>
                @can('crear-corte')
                
                    <div class="col-md-2">
                        <a class="btn btn-primary btn-block nuevoCorte" data-toggle="modal" data-target="#modalRegistroCorte">
                            <i class="fas fa-plus-circle"></i>
                             Corte
                        </a>
                    </div>

                @endcan
                
            </div>
        </div>

        <div class="container-fluid bg-white row rounded p-2 my-1 shadow">
            @can('ver-cortes')
            
                @if ( count($cortes) > 0 )
                    
                    @can('ver-corte')
                        
                        @foreach ($cortes as $corte)
                            <div class="col-md-3">
                                <x-adminlte-small-box title="$ {{ $corte->totalCorte }} M.N." text="{{ $corte->created_at }}" icon="fas fa-cash-register" theme="success" url="#" url-text="Ver Corte" class="corte" data-id="{{ $corte->id }}" data-toggle="modal" data-target="#modalCorte"/>
                            </div>
                        @endforeach

                    @endcan
                    
                @else
                    <div class="col-md-12">
                        <x-adminlte-small-box title="Sin Cortes Registrados" text="0" icon="fas fa-cash-register" theme="info"/>
                    </div>
                @endif

            @endcan
            
            
        </div>

        <!--Registro de Corte-->
        <div class="modal fade" id="modalRegistroCorte" tabindex="-1" aria-labellebdy="modalRegistroLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header border-bottom">
                        <h3 class="modal-title fs-5 fw-semibold">Nuevo Corte de Caja</h3>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid row">
                            <div class="col-md-8">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Platillo(s)</th>
                                            <th scope="col">Importe</th>
                                        </tr>
                                    </thead>
                                    <tbody id="contenedorPlatillos">
                                        <tr>
                                            <td colspan="3" class="text-align fs-6 fw-semibold">Sin datos en el corte</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-4">
                                <form novalidate>
                                    <div class="form-group">
                                        <label for="total">Total del Corte</label>
                                        <input type="text" name="total" id="total" readonly="true" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <input type="checkbox" name="activar" id="activar" class="position-relative top-0 start-0">
                                        <small class="fs-6 fw-semibold float-end" for> Acepto los datos y deseo continuar.</small>
                                    </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-block" id="registrar" name="registrar"><i class="fas fa-save"></i> Hacer Corte</button>
                                        </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!--Modal de Corte-->
        <div class="modal fade" id="modalCorte" tabindex="-1" aria-labellebdy="modalCorteLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header border-bottom">
                        <h3 class="modal-title fs-5 fw-semibold" id="titulocorte">Corte de Caja</h3>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid row">
                            <div class="form-group col-md-12">
                                <p class="text-info p-1 fs-6 fw-semibold bg-light">A continuación, la información detallada del corte de caja:</p>
                            </div>
                            <div class="col-md-12">
                                <table class="table table-stripe table-hover">
                                    <thead>
                                        <tr class="table-info">
                                            <th scope="col">#</th>
                                            <th scope="col">Platillo</th>
                                            <th scope="col">Importe</th>
                                        </tr>
                                    </thead>
                                    <tbody id="contenedorPlatillosCorte">
                                        <tr class="table-success">
                                            <td colspan="4">Total de Corte: $ 0,000.00 M.N.</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="container-fluid row p-1">
                                <form novalidate class="container-fluid p-1 row">
                                    @can('imprimir-corte')
                                        <div class="form-group col-md-12 p-1">
                                            <a href="#" class="bnt btn-primary btn-block p-2 text-center imprimir"><i class="fas fa-print" ></i> Imprimir</a>
                                        </div>
                                    @endcan
                                    <input type="hidden" name="idCorte" id="idCorte">
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
        <script src="{{ asset('js/cortes/calcular.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/cortes/activar.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/cortes/agregar.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/cortes/corte.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/cortes/imprimir.js') }}" type="text/javascript"></script>
    </div>
@stop