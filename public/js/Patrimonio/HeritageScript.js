
        $(document).ready(function () {
            $('#form_ordenar').on('change', function (event) {
                event.preventDefault();
                let order = $('#form_order').children("option:selected").val();
                
                let type = $('.main-section').attr('id');
                
                let url = Routing.generate('app_patrimonio_ordered_get');
                
                $.ajax({
                    type: 'POST',
                    url: url,
                    dataType: 'JSON',
                    data: JSON.stringify({orden: order, type: type }),
                    beforeSend: function () {
                        $('#all-heritage').remove();
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

