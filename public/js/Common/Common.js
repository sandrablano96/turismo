        $(document).ready(function () {
            $("#advancedButton").on("click", function () {
                console.log("click");
                $("#formFiltros").parent().toggleClass("d-none");
            });
        });

        $(document).ready(function () {
            $('#formFiltros').on("keyup", e => {
                if (e.key === "Escape")
                    e.target.value = ""

                $(".element-container").each(function () {
                    $(this).attr('id').toLowerCase().includes(e.target.value.toLowerCase())
                            ? $(this).removeClass("d-none")
                            : $(this).addClass("d-none")
                })
                if ($(".element-container").children(':visible').length == 0) {
                    $("#no-results").removeClass('d-none');
                } else {
                    $("#no-results").addClass('d-none');
                }

            })

        })
