$(".select2_viagem").select2({
    "language": "pt-BR",
    ajax: {
        url: function (params) {
            // console.log(params.term);
            return "/painel/viagens/busca-parceiro/" + params.term;
        },
        data: function (params) {
            return null;
        },
        dataType: 'json',
        delay: 150,
        cache: true,
        processResults: function (data) {
            // console.log(data);
            return {
                results: $.map(data, function (item) {
                    return {
                        text: item.nome,
                        id: item.id,
                        documento: item.documento,
                        pessoa: item.pessoa,
                        email: item.email,
                        telefone: item.telefone,
                        inscricao_estadual: item.inscricao_estadual,
                        cidade: item.cidade,
                        estado: item.estado,
                        endereco: item.endereco,
                        cep: item.cep,
                        fantasia: item.fantasia,
                        inscricao_estadual: item.inscricao_estadual,
                        data_nasc: item.data_nasc,
                        estado_civil: item.estado_civil,
                        sexo: item.sexo

                    }
                })
            };

        },
    },
    placeholder: "Selecione um Parceiro",
    minimumInputLength: 1
});

$("#dados").hide();


$(".select2_viagem").on('select2:select', function (e) {
    // console.log(e.params.data);
    $("#id_parceiro").val(e.params.data.id);
    var id = $("#id_parceiro").val();
    var idCaminhao = $("#id_parceiro").val();
    $("#dados").show();
    $(".overlay-loading").show();
    $.getJSON('/painel/viagens/busca-motorista/'+id, function (dados) {
        // console.log(dados);
        // console.log("Abaixo vem o Length dos Motoristas");

        $(".overlay-loading").hide();
        if($("#motorista option").size() > 1){
            $("#motorista").find('option')
                .remove().end().append('<option value="0">Selecione um motorista</option>');
        }

        if($("#caminhao option").size() > 1){
            $("#caminhao").find('option').remove().end().append('<option value="0">Selecione um caminhão</option>')
        }

        $.each(dados, function(i, obj){
            // console.log(i);
            // console.log(obj);
            option = '<option value="'+obj.id+'">'+obj.nome+'</option>';
            $("#motorista").append(option);
        });
    });
    console.log(idCaminhao);
    $.getJSON('/painel/viagens/busca-caminhao/'+idCaminhao, function (dados) {
        console.log(dados);
        $.each(dados, function(i, obj){
            // console.log(i);
            // console.log(dados[i]);
            option = '<option value="'+obj.id+'">'+obj.placa+' - '+obj.modelo+'</option>';
            $("#caminhao").append(option);
        });
    });

});

var idEd = $("#edicao").val();

if($("#edicao").val() >= 1){
    $("#dados").show();
    $(".overlay-loading").show();
    $("#parceiro-viagem").val();
    var id = $("#parceiro-viagem").val();
    var idCaminhao = $("#parceiro-viagem").val();
    // $("#dados").show();
    // $(".overlay-loading").show();
    $.getJSON('/painel/viagens/busca-motorista/'+id, function (dados) {
        // console.log(dados);
        // console.log("Abaixo vem o Length dos Motoristas");

        if($("#motorista option").size() > 1){
            $("#motorista").find('option')
                .remove().end().append('<option value="0">Selecione um motorista</option>');
        }

        if($("#caminhao option").size() > 1){
            $("#caminhao").find('option').remove().end().append('<option value="0">Selecione um caminhão</option>')
        }

        var nomeMotorista = $("#nomeMotorista").val();
        var idMotorista = $("#idMotorista").val();
        var idCaminhao = $("#idCaminhao").val();

        $.each(dados, function(i, obj){
            $("#motorista option[value=idMotorista]").attr('selected', 'selected');

            if(idMotorista == obj.id){
                option = '<option selected value="'+obj.id+'">'+obj.nome+'</option>';
                // alert(option);
            }else {
                option = '<option value="' + obj.id + '">' + obj.nome + '</option>';
            }
            $("#motorista").append(option);
        });

    });
    // $("#motorista option[value=idMotorista]").prop('selected', true)
    // console.log(idCaminhao);
    $.getJSON('/painel/viagens/busca-caminhao/'+idCaminhao, function (dados) {
        // console.log(dados);
        $.each(dados, function(i, obj){
            // console.log(i);
            console.log(dados);
            if(idCaminhao == obj.id){
                option = '<option selected value="'+obj.id+'">'+obj.placa+' - '+obj.modelo+'</option>';
                // alert(option);
            }else{
                option = '<option value="'+obj.id+'">'+obj.placa+' - '+obj.modelo+'</option>';
            }
            $("#caminhao").append(option);
            $(".overlay-loading").hide();
        });
    });

    $("#noneFrete").hide();
    $("#freteAdicionado").show();
    // $("#status").val();

}

function adicionarFrete(id){
    $("#adicionarFrete").modal('toggle');
    $("#id_frete").val(id);

    $("#freteAdicionado").show();
}
$(document).ready(function () {

    jQuery('form[name="form-viagem"]').submit(function () {
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
                // jQuery(".load").show();
            },
            success: function (data) {
                botao.attr('disabled', false).html('Salvar');
                // jQuery(".load").hide();
                console.log(data);
                if (data == "1") {
                    form.fadeOut('slow', function () {
                        jQuery(".msg-suc").show();
                        // jQuery("#gritter-notice-wrapper").show();
                        setTimeout(function () {
                            window.location.href = '/painel/viagens';
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

});