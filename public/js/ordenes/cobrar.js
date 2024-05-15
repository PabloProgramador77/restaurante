$(document).ready(function(){

    $(".cobrar").on('click', function(e){

        e.preventDefault();

        $(this).attr('disabled', true);
        $('.eliminar').attr('disabled', true);

        let procesamiento;

        Swal.fire({

            title: 'Cobrando',
            html: 'Un momento por favor. <b></b>',
            timer: 4975,
            allowOutsideClick: false,
            didOpen: ()=>{

                Swal.showLoading()
                const b = Swal.getHtmlContainer().querySelector('b')
                procesamiento = setInterval(() => {

                    b.textContent = Swal.getTimerLeft();

                }, 1000);

                $.ajax({

                    type: 'POST',
                    url: '/orden/cobrar',
                    data:{

                        '_token' : $("#token").val(),
                        'id' : $("#idOrden").val()

                    },
                    dataType: 'json',
                    encode: true

                }).done(function(respuesta){

                    if( respuesta.exito ){

                        Swal.fire({
                            
                            icon: 'success',
                            title: respuesta.mensaje,
                            showConfirmButton: true,
                            allowOutsideClick: false,
                        
                        }).then((resultado)=>{

                            if( resultado.isConfirmed ){

                                window.location.href = '/ordenes';

                            }

                        });

                    }else{

                        Toast.fire({
                            icon: 'error',
                            title: respuesta.mensaje
                        });

                    }

                });

            },
            willClose: ()=>{
                clearInterval(procesamiento);
            }

        }).then((resultado)=>{

            if( resultado.dismiss == Swal.DismissReason.timer ){
                
                Toast.fire({
                    icon: 'info',
                    title: 'Solo un poco más...'
                });

            }

        });

    });

});