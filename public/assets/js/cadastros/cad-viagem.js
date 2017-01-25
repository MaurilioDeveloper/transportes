$.fn.dataTable.ext.errMode = 'throw';
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

// $("#dados").hide();


$(".select2_viagem").on('select2:select', function (e) {
    // console.log(e.params.data);
    $("#id_parceiro").val(e.params.data.id);
    var id = $("#id_parceiro").val();
    var idCaminhao = $("#id_parceiro").val();
    $("#dados").show();
    $(".overlay-loading").show();

    if ($("#motorista option").size() > 1) {
        $("#motorista").find('option')
            .remove().end().append('<option value="0">Selecione um motorista</option>');
    }

    if ($("#caminhao option").size() > 1) {
        $("#caminhao").find('option').remove().end().append('<option value="0">Selecione um caminhão</option>')
    }

    $.getJSON('/painel/viagens/busca-motorista/' + id, function (dados) {
        // console.log(dados);
        // console.log("Abaixo vem o Length dos Motoristas");

        $.each(dados, function (i, obj) {
            // console.log(i);
            // console.log(obj);
            option = '<option value="' + obj.id + '">' + obj.nome + '</option>';
            $("#motorista").append(option);
        });
    });
    // console.log(idCaminhao);
    $.getJSON('/painel/viagens/busca-caminhao/' + idCaminhao, function (dados) {

        $.each(dados, function (i, obj) {
            // console.log(i);
            // console.log(dados[i]);
            option = '<option value="' + obj.id + '">' + obj.placa + ' - ' + obj.modelo + '</option>';
            $("#caminhao").append(option);
        });

        $(".overlay-loading").hide();
    });

});

var idEd = $("#edicao").val();

$(document).ready(function(){
    if ($("#edicao").val() >= 1) {
        $("#dados").show();
        $(".overlay-loading").show();
        $("#parceiro-viagem").val();
        var id = $("#parceiro-viagem").val();
        var idCaminhao = $("#parceiro-viagem").val();
        // $("#dados").show();
        // $(".overlay-loading").show();
        $.getJSON('/painel/viagens/busca-motorista/' + id, function (dados) {
            // console.log(dados);
            // console.log("Abaixo vem o Length dos Motoristas");

            if ($("#motorista option").size() > 1) {
                $("#motorista").find('option')
                    .remove().end().append('<option value="0">Selecione um motorista</option>');
            }

            var nomeMotorista = $("#nomeMotorista").val();
            var idMotorista = $("#idMotorista").val();
            // var idCaminhao = $("#idCaminhao").val();

            $.each(dados, function (i, obj) {
                $("#motorista option[value=idMotorista]").attr('selected', 'selected');

                if (idMotorista == obj.id) {
                    option = '<option selected value="' + obj.id + '">' + obj.nome + '</option>';
                    // alert(option);
                } else {
                    option = '<option value="' + obj.id + '">' + obj.nome + '</option>';
                }
                $("#motorista").append(option);
            });

        });
        // $("#motorista option[value=idMotorista]").prop('selected', true)
        // console.log(idCaminhao);

        $.getJSON('/painel/viagens/busca-caminhao/' + idCaminhao, function (dados) {

            if ($("#caminhao option").size() > 1) {
                $("#caminhao").find('option').remove().end().append('<option value="0">Selecione um caminhão</option>')
            }

            var idCam = $("#idCaminhao").val();
            $.each(dados, function (i, obj) {
                $("#motorista option[value=idCaminhao]").attr('selected', 'selected');
                // console.log(i);
                // alert(obj.id);
                if (idCam == obj.id) {
                    option = '<option selected value="' + obj.id + '">' + obj.placa + ' - ' + obj.modelo + '</option>';
                    // alert(option);
                } else {
                    option = '<option value="' + obj.id + '">' + obj.placa + ' - ' + obj.modelo + '</option>';
                }
                $("#caminhao").append(option);
            });
            $(".overlay-loading").hide();
        });

        $("#noneFrete").hide();
        $("#freteAdicionado").show();
        $("#fretesPreenchidos > #listaFrete > .frete_id").each(function(index, value){
            // $(".freteListaId").each(function (index, value) {
            // alert(index);
            if($(this).attr('value') === $(this).attr('value')){
                $("#id-frete"+$(this).attr('value')).attr('disabled', true);
            }
            // });
            // alert($(this).attr('value'));
        });

        // $("#status").val();
        // $.each(idDesable, function(i, obj){
        // var idDesable = $("#frete-disable"+obj.id).val();
        // jQuery("#nome").keydown(function(event){
        //     if(event.which == "69"){
        //         alert('Pressionou a tecla a')
        //     }
        // });
        // console.log(idDesable);
        // $("#id-frete"+idDesable).attr('disabled', true);
        // });




    }

});


function adicionarFrete(id) {
    $("#adicionarFrete").modal('toggle');
    $("#id_frete").val(id);
    $("#noneFrete").hide();
    $(".nenhum").remove();
    $("#freteAdicionado").show();
    var id_frete = id;
    $('.moeda').maskMoney();

    $.getJSON('/painel/viagens/fretes-adicionados/' + id_frete, function (dados) {
        // $("#freteAdicionado").append('<input type="text" class="form-control moeda" name="custos" data-prefix="R$"/>');
        $('.moeda').maskMoney();
        $.each(dados, function (i, obj) {
            // console.log($("#freteAd tr").length);
            // if($("#freteAd tr").length > 0) {
                $("#vazio").remove();
                $("#id-frete"+obj.id).attr('disabled', true);
                $("#freteAd").append('<tr id="freteTable' + obj.id + '"><td>' + obj.nome + '</td><td>' + obj.tipo + '</td><td>' + obj.identificacao + '</td><td>' + obj.cidade_origem + '</td><td>' + obj.cidade_destino + '</td>' +
                    '<td><input type="text" class="form-control moeda" name="custos['+ obj.id +']" data-prefix="R$"/></td>' +
                    '<td><a onclick="removerFrete(' + obj.id + ')" class="remover btn btn-danger btn-sm"><i class="fa fa-trash"></i></a></td></tr>')
                $("#dados>#fretesPreenchidos").append('<input type="hidden" class="frete_id" name="fretes[' + obj.id + ']" value="' + obj.id + '"/>');
            // }
        });
        // console.log($("#freteAd tr").length);
        if($("#freteAd tr").length === 0){
            $("#freteAd").append('<tr class="warning"><td style="text-align: center" colspan="6">Nenhum dado Cadastrado</td></tr>');
        }
        // console.log(dados);
        $('.moeda').maskMoney();
    });

}
$(document).ready(function () {

    jQuery('form[name="form-viagem"]').submit(function () {
        jQuery(".msg-warn").hide();
        jQuery(".msg-suc").hide();
        var dadosForm = jQuery(this).serialize();
        var form = jQuery(this);
        var botao = $(this).find('#botao');
        var status = $("#status-select>option:selected").val();
        var cidade_origem = $("#cidade_origem>option:selected").val();
        var cidade_destino = $("#cidade_destino>option:selected").val();
        var motorista = $("#motorista>option:selected").val();
        var caminhao = $("#caminhao>option:selected").val();
        console.log(status);

        if(status == 0){
            alert("Por Favor, preencha o campo de STATUS.");
            return false;
        }
        if(cidade_origem == 0){
            alert("Por Favor, preencha o campo de CIDADE ORIGEM.");
            return false;
        }
        if(cidade_destino == 0){
            alert("Por Favor, preencha o campo de CIDADE DESTINO.");
            return false;
        }
        if(motorista == 0){
            alert("Por Favor, selecione um MOTORISTA.");
            return false;
        }
        if(caminhao == 0){
            alert("Por Favor, selecione um CAMINHÃO.");
            return false;
        }

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
                // console.log(data);
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
                    // console.log(data)
                    // setTimeout("jQuery('.msg-warn').hide();", 3500);
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

function removerFrete(id){
    // console.log($("input[name='"+id+"][id]']"));
    $("input[name='fretes["+id+"]']").remove();
    $("#freteTable"+id).remove();
    $("#id-frete"+id).attr('disabled', false);
    if($("#freteAd tr").length === 0){
        $("#freteAd").append('<tr class="warning" id="vazio"><td style="text-align: center" colspan="6">Nenhum dado Cadastrado</td></tr>');
    }
}


function verHistorico(){
    $("#ui-datepicker-div").hide();
    $("#lista-historico").modal('toggle');


}