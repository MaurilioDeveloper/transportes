function openOcorrenciaEdit(id){

    var id_ocorrencia = id;
    console.log(id_ocorrencia);

    $("#title-cad").hide();
    $("#ocorrencia-form").attr('action', 'http://localhost:8000/painel/parceiros/updateOcorrencia/'+id_ocorrencia);
    $("#ocorrencia-form").attr('send', 'http://localhost:8000/painel/parceiros/updateOcorrencia/'+id_ocorrencia);
    $("#ocorrencia-form").attr('method', 'PUT');
    $("#ocorrencia-form").find('input').first().remove();
    $(".msg-suc").html('Ocorrência Alterada com Sucesso');
    $("#title-edit").show();
    $("#myModalLabel").append("<h3 class='modal-title'>Editar Ocorrência</h3>");
    $.getJSON('/painel/parceiros/editOcorrencia/' + id_ocorrencia, function (dados) {
        console.log(dados);
        $(".data-ocorrencia").val(dados.data);
        $("#tipo-ocorrencia").val(dados.id_tipo_ocorrencia);
        $("#id_usuario_ocorrencia").val(dados.id_usuario);
        $(".descricao_ocorrencia").val(dados.descricao);

    });
    $("#postOcorrencia").remove();


}

jQuery('form[name="form-ocorrencia"]').submit(function () {
    if(($('#tipo-ocorrencia').val()) == 0){
        alert('Campo Tipo de Ocorrência é obrigatório!!');
        return false;
    }else {

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
                botao.attr('disabled', true).html('Carregando...', true);
                jQuery(".load").show();
            },
            success: function (data) {
                botao.attr('disabled', false).html('Salvar');
                jQuery(".load").hide();
                if (data == "1") {
                    // console.log(data);
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
