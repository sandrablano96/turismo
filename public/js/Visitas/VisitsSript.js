    //Mostrar maximo de letras y actualizado
        $(document).ready(function () {
            $('textarea').keyup(function () {

                var characterCount = $(this).val().length,
                        current = $('#current'),
                        maximum = $('#maximum'),
                        theCount = $('#the-count');

                current.text(characterCount);


                /*This isn't entirely necessary, just playin around*/
                if (characterCount < 70) {
                    current.css('color', '#666');
                }
                if (characterCount > 70 && characterCount < 90) {
                    current.css('color', '#6d5555');
                }
                if (characterCount > 90 && characterCount < 100) {
                    current.css('color', '#793535');
                }
                if (characterCount > 100 && characterCount < 120) {
                    current.css('color', '#841c1c');
                }
                if (characterCount > 120 && characterCount < 139) {
                    current.css('color', '#8f0001');
                }

                if (characterCount >= 140) {
                    maximum.css('color', '#8f0001');
                    current.css('color', '#8f0001');
                    theCount.css('font-weight', 'bold');
                } else {
                    maximum.css('color', '#666');
                    theCount.css('font-weight', 'normal');
                }


            });
        });

        //Mandar opinion
        $(document).ready(function () {

            var itemId = '';
            var button = null;

            $('#reviewModal').on('show.bs.modal', function (e) {

                button = $(e.relatedTarget);
                $('#error').addClass('d-none');
                itemId = $(button).attr('data-bs-id');
                $('#reviewModal').unbind('shown.bs.modal')

            })

            $('#comentar').on('click', function () {

                let opinion = $('textarea').val();
                let url = Routing.generate('app_opiniones_post', {uid: itemId});

                $.ajax({
                    type: 'POST',
                    url: url,
                    dataType: 'JSON',
                    data: JSON.stringify({opinion: opinion}),
                    beforeSend: function () {
                        $('#loading').removeClass('d-none');
                    },
                    success: function (response) {
                        if (response.code == 200) {
                            $('#loading').addClass('d-none');
                            $('#reviewModal').modal('hide');
                            $('#textarea').val("");
                            //console.log(response.data.usuario);
                            //console.log(response.data.opinion);
                            
                            $(`#opinions-${itemId}>p`).remove();
                            if ($(`#opinions-${itemId}`).children('div') > 1) {
                                $(`#opinions-${itemId}`).children('div').append(`<p data-id=opinion-${response.data.uid}><button class="btn btn-transparent btn-delete"><i class="fa-solid fa-circle-minus"></i></button> <span class="font-weight-bold">${response.data.usuario}</span> opina: ${response.data.opinion} 
                                </p>`)
                            } else {
                                $(`#opinions-${itemId}`).append(`<div class="card"><p data-id=opinion-${response.data.uid}><button class="btn btn-transparent btn-delete"><i class="fa-solid fa-circle-minus"></i></button> <span class="font-weight-bold">${response.data.usuario}</span> opina: ${response.data.opinion} 
                                </p></div>`)
                            }

                        } else {
                            $('#loading').addClass('d-none');
                            $('#error').removeClass('d-none');
                            $('#error').html('Ya ha comentado en esta visita previamente');
                        }


                    },
                    complete: function () {
                        $('#delete').addClass('d-none');
                    },
                    error: function () {
                         $('#loading').addClass('d-none');
                        $('#error').removeClass('d-none');
                        $('#error').html('Ha sucedido un error. Inténtelo de nuevo');
                    }

                });
            })
        });
        
        //borrar opinion
        $(document).ready(function () {
            
            $('.opinions-list').on('click','.btn-delete', function (e){
                let button = $(e.target)
                let parentP = $(button).parent();
                let opinion = $(parentP).attr('data-id').split('ion-');
                let opinionId = opinion[1];
                let divContainer = $(parentP).parent();
                
                let visitOpinionsDiv = $(parentP).parent().parent();
               
                let deleteUrl = Routing.generate('app_opiniones_delete', {uid: opinionId}); 
                
                $.ajax({
                    type: 'DELETE',
                    url: deleteUrl,
                    dataType: 'JSON',
                    beforeSend: function () {
                        $('#deleting').removeClass('d-none');
                    },
                    success: function (response) {
                        if (response.code == 200) {
                            $('#deleting').addClass('d-none');
                            $(parentP).remove();
                            $(divContainer).removeClass('card');
                            $(visitOpinionsDiv).append('<p>Todavía no hay comentarios</p>');
                        } else {
                            $('#deleting').addClass('d-none');
                            $('#delete_err').removeClass('d-none');
                        }


                    },
                    complete: function () {
                        $('#deleting').addClass('d-none');
                    },
                    error: function () {
                        $('#delete_err').removeClass('d-none');
                    }

                });
                
                
            });
        });
        



