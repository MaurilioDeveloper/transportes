jQuery('form[name="form-ocorrencia"]').submit(function () {
    if(($('#tipo-ocorrencia').val()) == 0){
        alert('Campo Tipo de Ocorrência é obrigatório!!');
        return false;
    }else {

        jQuery(".msg-warn").hide();
        jQuery(".msg-suc").hide();
        var dadosForm = jQuery(this).serialize();
        var form = jQuery(this);
        console.log(form);
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
    }
});

function openOcorrenciaEdit(id){

    var id_ocorrencia = id;
    console.log(id_ocorrencia);

    $("#title-cad").hide();
    $("#postOcorrencia").remove();
    $("#updateOcorrencia").show();
    $("#form-ocorrencia-edit").attr('action', '/painel/parceiros/updateOcorrencia/'+id_ocorrencia);
    $("#title-edit").show();
    $("#myModalLabel").append("<h3 class='modal-title'>Editar Ocorrência</h3>");
    $.getJSON('/painel/parceiros/editOcorrencia/' + id_ocorrencia, function (dados) {
        console.log(dados);
        $(".data-ocorrencia").val(dados.data);
        $("#tipo-ocorrencia").val(dados.id_tipo_ocorrencia);
        $("#id_usuario_ocorrencia").val(dados.id_usuario);
        $(".descricao_ocorrencia").val(dados.descricao);
        console.log(dados.descricao);
    });


}