$(document).ready(function(){

    $("#platillo").attr('disabled', true);

    var platillos = new Array();

    //Crear Menú de Platillos
    $("#asignar").on('click', function(e){

        e.preventDefault();
        let procesamiento;

        function aderezos(){

            window.location.href = '/aderezos';

        }

        $("input[type=checkbox][name=platillo]:checked").each( function(){

            platillos.push( $(this).val() );

        });

        $("#platillo").attr('disabled', true);
        $("input[name=platillo]").attr('disabled', true);

        Swal.fire({

            title: 'Asignando aderezo a platillo(s)',
            html: 'Un momento por favor. <b></b>',
            timer: 4975,
            allowOutsideClick: false,
            didOpen: ()=>{

                Swal.showLoading()
                const b = Swal.getHtmlContainer().querySelector('b')
                procesamiento = setInterval(()=>{

                    b.textContent = Swal.getTimerLeft()

                }, 1000);

                $.ajax({

                    type: 'POST',
                    url: '/aderezo/platillos',
                    data:{

                        '_token' : $("#token").val(),
                        'aderezo' : $("#idAderezo").val(),
                        'platillos' : platillos

                    },
                    dataType: 'json',
                    encode: true

                }).done(function(respuesta){

                    if( respuesta.exito ){

                        Swal.fire({
                            icon: 'success',
                            title: respuesta.mensaje,
                            showConfirmButton: false,
                            allowOutsideClick: false,
                        });

                        setTimeout(aderezos, 1250);

                    }else{

                        $("#platillo").attr('disabled', true);

                        Swal.fire({
                            icon: 'warning',
                            title: respuesta.mensaje,
                            showConfirmButton: false,
                            allowOutsideClick: false,
                            timer: 1750,
                        });

                        setTimeout( aderezos, 2250);

                    }

                }); 

            },
            willClose: ()=>{

                clearInterval(procesamiento);

            }

        }).then((resultado)=>{

            if( resultado.dismiss == Swal.DismissReason.timer ){

                Swal.fire({
                    icon: 'error',
                    title: 'Hubo un error. Reiniciando proceso.',
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    timer: 1750,
                });

                setTimeout(aderezos, 2225);

            }

        });

    });

});