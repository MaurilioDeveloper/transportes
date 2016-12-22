jQuery('form[name="form-ocorrencia"]').submit(function () {
    jQuery(".msg-warn").hide();
    jQuery(".msg-suc").hide();
    var dadosForm = jQuery(this).serialize();
    var form = jQuery(this);
    var botao = $(this).find('#botao');
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
                    jQuery(".msg-suc").show();
                    setTimeout(function () {
                        window.location.href = '';
                    }, 3000);
                });
            } else {
                jQuery(".msg-warn").show();
                jQuery(".msg-warn").html(data);
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
