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

$(".select2_viagem").on('select2:select', function (e) {
    console.log(e.params.data);

});

