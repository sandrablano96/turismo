
//museos
        $(document).ready(function (event) {
            $('#form_ordenar').on('change', function (e) {
                event.preventDefault();
                let order = $('#form_order').children("option:selected").val();
                //console.log(order);
                
                let url = Routing.generate('app_museos_ordered_get');

                $.ajax({
                    type: 'POST',
                    url: url,
                    dataType: 'JSON',
                    data: JSON.stringify({orden: order}),
                    beforeSend: function () {
                        $('#all-museum').remove();
                        $('#loading').removeClass('d-none');
                    },
                    success: function (response) {

                        $('#loading').addClass('d-none');
                        if (response.response == "") {
                            $('#no-results').removeClass('d-none');
                        } else {
                            $('#search-results').html(response.response);
                            $('#search-results').removeClass('d-none');
                            $('#no-results').addClass('d-none');
                            
                        }

                    },
                    complete: function () {
                        $('#loading').addClass('d-none');
                    },
                    error: function () {
                        $('#error').removeClass('d-none');
                    }

                });
                
            });

        });


//Obtener pieza para aquellas que tengan una descripción muy larga
$(document).ready(function () {
    $('#piezaModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var itemId = $(button).attr('data-bs-whatever')
        console.log(itemId);

        let url = Routing.generate('app_pieza_get');

        $.ajax({
            type: 'POST',
            url: url,
            dataType: 'JSON',
            data: JSON.stringify({itemId: itemId}),
            beforeSend: function(){
                $('#loading').removeClass('d-none');
            },
            success: function (response) {
                
                if (response.code == 200) {
                    $('#piezaModalLabel').html(response.titulo);
                    $('.modal-body').html(response.descripcion);
                    $('#loading').addClass('d-none');
                    
                }
            },
            error: function (error) {
                $('#loading').addClass('d-none');
                $('.modal-body').html('Ha sucedido un error. Por favor inténtelo de nuevo');
            }, 
            complete: function(){
                $('#loading').addClass('d-none');
            }

        });
    })
});