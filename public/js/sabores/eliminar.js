$(document).ready(function(){

    function sabores(){

        window.location.href = '/sabores';

    }

    $("#eliminar").on('click', function(e){

        e.preventDefault();
        let procesamiento;

        $("#eliminar").attr('disabled', true);

        Swal.fire({

            title: 'Borrando Datos de Sabor',
            html: 'Espera un poco: <b></b>',
            timer: 9975,
            allowOutsideClick: false,
            didOpen: ()=>{

                Swal.showLoading()
                const b = Swal.getHtmlContainer().querySelector('b')
                procesamiento = setInterval(()=>{

                    b.textContent = Swal.getTimerLeft()

                }, 1000);

                $.ajax({

                    type: 'POST',
                    url: '/sabores/eliminar',
                    data:{

                        '_token' : $("#token").val(),
                        'id' : $("#idSaborEliminar").val()

                    },
                    dataType:'json',
                    encode: true

                }).done(function(respuesta){

                    if( respuesta.exito ){
                        
                        Swal.fire({
                            icon: 'success',
                            title: respuesta.mensaje,
                            showConfirmButton: false,
                            timer: 1500
                        });

                        setTimeout(sabores, 1225);

                    }else{

                        $("#eliminar").attr('disabled', false);

                        Swal.fire({
                            icon: 'warning',
                            title: respuesta.mensaje,
                            showConfirmButton: false,
                            timer: 1500
                        });

                    }

                });

            },
            willClose: ()=>{

                clearInterval(procesamiento);

            }

        }).then((resultado)=>{

            if(resultado.dismiss == Swal.DismissReason.timer){

                Swal.fire({
                    icon: 'error',
                    title: 'Hubo un error, estamos reiniciando el proceso',
                    showConfirmButton: false,
                    timer: 2500
                });

                setTimeout(sabores, 2225);

            }

        });

    });

});