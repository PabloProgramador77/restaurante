$(document).ready(function(){

    $("#ordenar").on('click', function(e){

        var sabores = new Array();
        var aderezos = new Array();

        $("input[type=checkbox][name=sabor]:checked").each(function(){

            sabores.push( $(this).val() );

        });

        $("input[type=checkbox][name=aderezo]:checked").each(function(){

            aderezos.push( $(this).val() );

        });

        e.preventDefault();

        $("#ordenar").attr('disabled', true);
        $("#cantidad").attr('disabled', true);
        $("#nota").attr('disabled', true);

        let procesamiento;

        Swal.fire({

            title: 'Agregando Platillo a Orden',
            html: 'Un momento por favor. <b></b>',
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
                    url: '/platillos/ordenar',
                    data:{

                        '_token' : $("#token").val(),
                        'idPlatillo' : $("#idPlatilloMenu").val(),
                        'cantidad' : $("#cantidad").val(),
                        'nota' : $("#nota").val(),
                        'sabores' : sabores,
                        'aderezos' : aderezos,

                    },
                    dataType: 'json',
                    encode: true

                }).done(function(respuesta){

                    if( respuesta.exito ){

                        $("#platillo").val('');
                        $("#cantidad").val(1);
                        $("#nota").val('');

                        $("#cantidad").attr('disabled', false);
                        $("#nota").attr('disabled', false);

                        Swal.fire({
                            
                            icon: 'success',
                            title: 'Platillo Ordenado.',
                            showConfirmButton: true,
                            allowOutsideClick: false,

                        }).then(function(resultado){

                            if( resultado.isConfirmed ){

                                window.location.href = '/menu';

                            }

                        });

                    }else{

                        Toast.fire({
                            info: 'error',
                            title: respuesta.mensaje
                        });

                        $("#ordenar").attr('disabled', false);
                        $("#cantidad").attr('disabled', false);
                        $("#nota").attr('disabled', false);

                    }

                });

            },
            willClose: ()=>{

                setInterval(procesamiento);

            }

        }).then((resultado)=>{

            if( resultado.dismiss == Swal.DismissReason.timer ){

                Toast.fire({
                    icon: 'info',
                    title:'Solo un poco más...'
                });

            }

        });

    });

});