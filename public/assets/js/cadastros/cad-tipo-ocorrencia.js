jQuery('form[name="form-tipo-ocorrencia"]').submit(function () {
    jQuery(".msg-warn-tipo").hide();
    jQuery(".msg-suc-tipo").hide();
    var dadosForm = jQuery(this).serialize();
    var form = jQuery(this);
    var botao = $(this).find('#btn-tipo');
    console.log(botao);
    $.ajax({
        url: $(this).attr("send"),
        type: "POST",
        data: dadosForm,
        beforeSend: function () {
            console.log(dadosForm);
            botao.attr('disabled', true).html('Carregando...', true);
            jQuery(".load").show();
        },
        success: function (data) {
            botao.attr('disabled', false).html('Salvar');
            jQuery(".load").hide();
            console.log(data);
            if (data == "1") {
                form.fadeOut('slow', function () {
                    jQuery(".msg-suc-tipo").show();
                    setTimeout(function () {
                        window.location.href = '';
                    }, 3000);
                });
            } else {
                jQuery(".msg-warn-tipo").show();
                jQuery(".msg-warn-tipo").html(data);
                console.log(data)
                setTimeout("jQuery('.msg-warn').hide();", 3500);
            }
        },
        error: function (event, request, settings) {
            console.log(event);
            console.log("erro");
            console.log(request);
            console.log(settings);
        }
    });
    return false;
});
