$(document).ready(function(){

    function sabores(){

        window.location.href = '/sabores';

    }

    $("#actualizar").on('click', function(e){

        e.preventDefault();
        let procesamiento;

        Swal.fire({

            title: 'Actualizando Sabor',
            html: 'Espera un poco: <b></b>',
            timer: 9975,
            allowOutsideClick: false,
            didOpen: ()=>{

                $("#saborEditar").attr('disabled', true);
                $("#descripcionEditar").attr('disabled', true);
                $("#actualizar").attr('disabled', true);

                Swal.showLoading()
                const b = Swal.getHtmlContainer().querySelector('b')
                procesamiento = setInterval(()=>{

                    b.textContent = Swal.getTimerLeft()

                }, 1000);

                $.ajax({

                    type: 'POST',
                    url: '/sabores/actualizar',
                    data:{

                        '_token' : $("#token").val(),
                        'sabor' : $("#saborEditar").val(),
                        'descripcion' : $("#descripcionEditar").val(),
                        'id' : $("#idSaborEditar").val()

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

                        setTimeout(sabores, 2225);

                    }else{

                        $("#saboreEditar").attr('disabled', false);
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

                setTimeout(sabores, 2225);

            }

        });

    });

});