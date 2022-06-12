
        $(document).ready(function () {
            $('#form_tipos, #form_meses').on('change', function (e) {
                event.preventDefault();
                let types = [];
                $(":checkbox").each(function () {
                    var ischecked = $(this).is(":checked");
                    if (ischecked) {
                        types.push($(this).val());
                    }
                });
                //console.log(types.length)
                //console.log(types)
                let monthSelected = $('#form_mes').children("option:selected").val();
                //console.log(monthSelected);

                let url = Routing.generate('app_eventos_type_get');

                $.ajax({
                    type: 'POST',
                    url: url,
                    dataType: 'JSON',
                    data: JSON.stringify({month: monthSelected, types: types}),
                    beforeSend: function () {
                        $('#search-results').html("")
                        $('#all-events').remove();
                        $('#loading').removeClass('d-none');
                        $('#no-results').addClass('d-none');
                    },
                    success: function (response) {
                        let month = response.mes.charAt(0).toUpperCase() + response.mes.slice(1);
                        $('#month-chosen').html(month);
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



