<div class="modal fade" id="modalMenu" tabindex="-1" aria-labellebdy="modalMenuLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h3 class="modal-title fs-5 fw-bold" id="tituloCategoria">Menú de Categoría</h3>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group bg-light p-1">
                    <small class="text-info fw-semibold fs-6">A continuación, selecciona los PLATILLOS que deseas agregar al menú de la categoría:</small>
                </div>
                <form novalidate>
                    @if ( count($platillos) > 0 )
                        
                        @foreach ($platillos as $platillo)
                            <div class="custom-control custom-switch d-inline m-2">
                                <input type="checkbox" class="custom-control-input" name="platillo" id="{{ $platillo->nombrePlatillo }}" value="{{ $platillo->id }}">
                                <label class="custom-control-label" for="{{ $platillo->nombrePlatillo }}">{{ $platillo->nombrePlatillo }}    
                            </div>        
                        @endforeach

                    @else
                        <div class="container-fluid">
                            <p class="text-info bg-light p-2 rounded text-center">Sin platillos registrados.
                                <a href="{{ url('/platillos') }}" class="btn btn-primary" role="button">
                                    <i class="fas fa-plus-circle"></i>
                                </a>
                            </p>
                        </div>
                    @endif
                    @can('Crear menu')
                        <div class="modal-footer">
                            <button type="submit" id="menu" name="menu" class="btn btn-primary w-25"><i class="fas fa-save"></i> Crear Menú</button>
                        </div>
                    @endcan
                    <input type="hidden" name="idCategoriaMenu" id="idCategoriaMenu">
                    <input type="hidden" name="token" id="token" value="{{ csrf_token() }}">
                </form>
            </div>
        </div>
    </div>
</div>