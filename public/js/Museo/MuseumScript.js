

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
