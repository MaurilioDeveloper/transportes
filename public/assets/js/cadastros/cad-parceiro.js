$(function(){
/*

    $(".select2_frete").on('select2:select', function (e) {
        $("#fretes-parceiro").modal();

        $.fn.dataTable.ext.errMode = 'throw';
        jQuery('form[name="form-edit"]').submit(function () {
            var url = "frete/atualizar-frete/" + e.params.data.id;
            $('form[name="form-edit"]').attr("action", url);
            $('form[name="form-edit"]').attr("send", url);

            jQuery(".alert-warning").hide();
            jQuery(".alert-success").hide();
            var dadosForm = jQuery(this).serialize();
            var form = jQuery(this);
            var botao = $(this).find('.salve');


            $.ajax({
                url: $(this).attr("send"),
                type: "POST",
                data: dadosForm,
                beforeSend: function () {
                    botao.attr('disabled', true).html('Carregando...', true);
                    jQuery(".load").show();
                },
                success: function (data) {
                    botao.attr('disabled', false);
                    jQuery(".load").hide();
                    if (data == "1") {
                        jQuery(".alert-success").show();
                        setTimeout(function () {
                            window.location.href = 'fretes';
                        }, 2000);
                    } else {
                        jQuery(".alert-warning").show();
                        jQuery(".alert-warning").html(data);
                        setTimeout("jQuery('.alert-warning').hide();", 3500);
                    }
                }
            });
            return false;
        });
    });
    */
});