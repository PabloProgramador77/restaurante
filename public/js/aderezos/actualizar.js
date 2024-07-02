$(document).ready(function(){

    function aderezos(){

        window.location.href = '/aderezos';

    }

    $("#actualizar").on('click', function(e){

        e.preventDefault();
        let procesamiento;

        Swal.fire({

            title: 'Actualizando Aderezo',
            html: 'Espera un poco: <b></b>',
            timer: 9975,
            allowOutsideClick: false,
            didOpen: ()=>{

                $("#aderezoEditar").attr('disabled', true);
                $("#descripcionEditar").attr('disabled', true);
                $("#actualizar").attr('disabled', true);

                Swal.showLoading()
                const b = Swal.getHtmlContainer().querySelector('b')
                procesamiento = setInterval(()=>{

                    b.textContent = Swal.getTimerLeft()

                }, 1000);

                $.ajax({

                    type: 'POST',
                    url: '/aderezos/actualizar',
                    data:{

                        '_token' : $("#token").val(),
                        'aderezo' : $("#aderezoEditar").val(),
                        'descripcion' : $("#descripcionEditar").val(),
                        'id' : $("#idAderezoEditar").val()

                    },
                    dataType:'json',
                    encode: true

                }).done(function(respuesta){

                    if( respuesta.exito ){
                        
                        Swal.fire({
                            icon: 'success',
                            title: respuesta.mensaje,
                            showConfirmButton: false,
                            timer: 2500
                        });

                        setTimeout(aderezos, 2225);

                    }else{

                        $("#aderezoeEditar").attr('disabled', false);
                        $("#descripcionEditar").attr('disabled', false);
                        $("#actualizar").attr('disabled', false);

                        Swal.fire({
                            icon: 'warning',
                            title: respuesta.mensaje,
                            showConfirmButton: false,
                            timer: 2500
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

                setTimeout(aderezos, 2225);

            }

        });

    });

});