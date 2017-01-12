$(document).ready(function () {
    $( function() {
        $(".datapicker" ).datepicker({
            dateFormat: 'dd/mm/yy',
            nextText: 'Próximo',
            prevText: 'Anterior'
        });
    } );
    
    $(".select2_frete").select2({
        "language": "pt-BR",
        ajax: {
            url: function (params) {
                // console.log(params.term);
                return "/painel/fretes/busca-parceiro/" + params.term;
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
                            bairro: item.bairro,
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
    $(".select2_frete").on('select2:select', function (e) {
        // console.log(e.params.data);
        $("#dados1").show();
        $("#dados2").show();
        $(".edit").attr('href', '/painel/parceiros/edit/'+e.params.data.id);
        $(".nome_parceiro").val(e.params.data.text);
        $(".documento").val(e.params.data.documento);
        $(".telefone").val(e.params.data.telefone);
        $(".email").val(e.params.data.email);
        $(".inscricao_estadual").val(e.params.data.inscricao_estadual);
        $(".cidade").val(e.params.data.cidade);
        $(".estado").val(e.params.data.estado);
        $(".endereco").val(e.params.data.endereco);
        $(".bairro").val(e.params.data.bairro);
        $(".cep").val(e.params.data.cep);
        $(".fantasia").val(e.params.data.fantasia);
        $(".data_nasc").val(e.params.data.data_nasc);
        $(".estado_civil").val(e.params.data.estado_civil);
        $(".sexo").val(e.params.data.sexo);
        console.log(e.params.data.data_nasc);
        var pessoa = (e.params.data.pessoa);
        if(pessoa === 'juridica'){
            $(".cnpj").show();
            $(".cpf").hide();
            $(".juridica").show();
            $(".fisica").hide();
        }
        if(pessoa === 'fisica'){
            $(".cpf").show();
            $(".cnpj").hide();
            $(".fisica").show();
            $(".juridica").hide();
        }
        $("#parceiros").modal();
    });

    $(".select2_ce").select2({
        theme: "classic",
        "language": "pt-BR",
        ajax: {
            url: function (params) {
                // console.log(params.term);
                return "/painel/fretes/busca-parceiro/" + params.term;
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
        // placeholder: "Selecione um Parceiro",
        minimumInputLength: 1
    });

    jQuery('form[name="form-frete"]').submit(function () {
        jQuery(".msg-warn").hide();
        jQuery(".msg-suc").hide();
        var dadosForm = jQuery(this).serialize();
        // console.log(dadosForm);
        var form = jQuery(this);
        var botao = $(this).find('#botao');
        var status = $("#status-select>option:selected").val();
        var cidade_origem = $("#cidade_origem>option:selected").val();
        var cidade_destino = $("#cidade_destino>option:selected").val();
        // console.log(status);
        if(cidade_origem == 0){
            alert("Por Favor, preencha o campo de CIDADE ORIGEM.");
            return false;
        }
        if(cidade_destino == 0){
            alert("Por Favor, preencha o campo de CIDADE DESTINO.");
            return false;
        }
        if(status == 0){
            alert("Por Favor, preencha o campo de STATUS.");
            return false;
        }

            // $.ajax({
            //     url: $(this).attr("send"),
            //     type: "POST",
            //     data: dadosForm,
            //     beforeSend: function () {
                //         botao.attr('disabled', true).html('Carregando...', true);
            //         jQuery(".load").show();
            //     },
            //     success: function (data) {
            //         botao.attr('disabled', false).html('Salvar');
            //         jQuery(".load").hide();
            //         console.log(data);
            //         if (data == "1") {
            //             form.fadeOut('slow', function () {
            //                 jQuery(".msg-suc").show();
            //                 jQuery("#gritter-notice-wrapper").show();
                            // setTimeout(function () {
                            //     window.location.href = '/painel/fretes';
                            // }, 3000);
                        });
                    // } else {
                    //     jQuery(".msg-warn").show();
                    //     jQuery(".msg-warn").html(data);
                    //     console.log(data)
                    //     setTimeout("jQuery('.msg-warn').hide();", 3500);
                    // }
                // },
                // error: function (event, request, settings) {
                //     console.log(event);
                //     console.log("erro");
                //     console.log(request);
                //     console.log(settings);
                // },
                //  cache: false,
                //  contentType: false,
            // });
            // return false;
    //
    // });

});

function verHistorico(){
    $("#ui-datepicker-div").hide();
    $("#lista-historico").modal('toggle');


}