$(document).ready(function(){

    function sabores(){

        window.location.href = '/sabores';

    }

    $("#registrar").on('click', function(e){

        e.preventDefault();
        let procesamiento;

        Swal.fire({

            title: 'Agregando Sabor',
            html: 'Espera un poco: <b></b>',
            timer: 9975,
            allowOutsideClick: false,
            didOpen: ()=>{

                $("#sabor").attr('disabled', true);
                $("#descripcion").attr('disabled', true);
                $("#registrar").attr('disabled', true);

                Swal.showLoading()
                const b = Swal.getHtmlContainer().querySelector('b')
                procesamiento = setInterval(()=>{

                    b.textContent = Swal.getTimerLeft()

                }, 1000);

                $.ajax({

                    type: 'POST',
                    url: '/sabores/agregar',
                    data:{

                        '_token' : $("#token").val(),
                        'sabor' : $("#sabor").val(),
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

                        setTimeout(sabores, 2250);

                    }else{

                        Swal.fire({
                            icon: 'warning',
                            title: respuesta.mensaje,
                            showConfirmButton: false,
                        });

                        setTimeout(sabores, 2250);

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

                setTimeout(sabores, 2250);

            }

        });

    });

});