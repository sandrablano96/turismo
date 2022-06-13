  $(document).ready(function () {

            $('#contact-form').on('submit', function (e) {
                e.preventDefault();
                let form = $(e.target);
                console.log(form);
                
                let url = Routing.generate('app_oficina_get', {uid: 'aaf165e2-ed80-4e3f-b8ce-3b4f9488c4ea'});
                
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: $(form).serialize(),
                    beforeSend: function () {
                        $('#loading').removeClass('d-none');
                    },
                    success: function (response) {
                        if (response.code == 200) {
                            $('#loading').addClass('d-none');
                            $('#success').removeClass('d-none');
                            $(form).trigger('reset');
                            $('#contactModal').modal('show');
                        }


                    },
                    complete: function () {
                        $('#delete').addClass('d-none');
                    },
                    error: function () {
                        
                        $('#error').removeClass('d-none');
                        $('#loading').addClass('d-none');
                        $('#error').html('Ha sucedido un error. Inténtelo de nuevo');
                        $('#contactModal').modal('show');
                    }

                });
            });
        });
        


