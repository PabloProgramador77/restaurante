$(document).ready(function(){

    function aderezos(){

        window.location.href = '/aderezos';

    }

    $("#registrar").on('click', function(e){

        e.preventDefault();
        let procesamiento;

        Swal.fire({

            title: 'Agregando aderezo',
            html: 'Espera un poco: <b></b>',
            timer: 9975,
            allowOutsideClick: false,
            didOpen: ()=>{

                $("#aderezo").attr('disabled', true);
                $("#descripcion").attr('disabled', true);
                $("#registrar").attr('disabled', true);

                Swal.showLoading()
                const b = Swal.getHtmlContainer().querySelector('b')
                procesamiento = setInterval(()=>{

                    b.textContent = Swal.getTimerLeft()

                }, 1000);

                $.ajax({

                    type: 'POST',
                    url: '/aderezos/agregar',
                    data:{

                        '_token' : $("#token").val(),
                        'aderezo' : $("#aderezo").val(),
                        'descripcion' : $("#descripcion").val(),

                    },
                    dataType:'json',
                    encode: true

                }).done(function(respuesta){

                    if( respuesta.exito ){

                        Swal.fire({
                            icon: 'success',
                            title: respuesta.mensaje,
                            showConfirmButton: false,
                            timer: 1000
                        });

                        setTimeout(aderezos, 2250);

                    }else{

                        Swal.fire({
                            icon: 'warning',
                            title: respuesta.mensaje,
                            showConfirmButton: false,
                        });

                        setTimeout(aderezos, 2250);

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
                    title: 'Hubo un error, estamos reiniciando el proceso.',
                    showConfirmButton: false,
                    timer: 2500
                });

                setTimeout(aderezos, 2250);

            }

        });

    });

});