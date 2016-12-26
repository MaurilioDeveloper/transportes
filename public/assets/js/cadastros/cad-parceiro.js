/*$(document).ready(function(){




    // Buscar cep
    function buscaCep() {
        // var buscaUrl = "http://republicavirtual.com.br/web_cep.php";
        var buscaUrl = " viacep.com.br/ws/";
        var cep = $("#cep").val();

        var header = $("meta[name='_csrf_header']").attr("content");
        var token = $("meta[name='_token']").attr("content");

        console.log(header, token);


        $.ajax({
            // url: buscaUrl + "?cep=" + cep + "&formato=json",
            url: buscaUrl + cep + "/json",
            type: 'POST',
            ContenType: "application/json",
            beforeSend: function (xhr) {
                console.log(xhr);
                xhr.setRequestHeader(header, token);
            },
            success: function (data) {
                console.log(data);

                $("#rua").val(data.tipo_logradouro + " " + data.logradouro);
                $("#bairro").val(data.bairro);
                $("#cidade").val(data.cidade);
                $("#state").val(data.uf);

            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status + ": " + thrownError);
            }
        });

    }

});
    */
function limpa_formulário_cep() {
    // Limpa valores do formulário de cep.
    $("#rua").val("");
    $("#bairro").val("");
    $("#cidade").val("");
    $("#uf").val("");
}

$(".overlay-loading").hide();

//Quando o campo cep perde o foco.
$("#cep").blur(function() {

    //Nova variável "cep" somente com dígitos.
    var cep = $(this).val().replace(/\D/g, '');

    //Verifica se campo cep possui valor informado.
    if (cep != "") {

        //Expressão regular para validar o CEP.
        var validacep = /^[0-9]{8}$/;

        //Valida o formato do CEP.
        if(validacep.test(cep)) {

            //Preenche os campos com "..." enquanto consulta webservice.
            $("#rua").val("...");
            $("#bairro").val("...");
            $("#cidade").val("...");
            $("#state").val("...");
            $(".overlay-loading").show();

            //Consulta o webservice viacep.com.br/
            $.getJSON("//viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                if (!("erro" in dados)) {
                    //Atualiza os campos com os valores da consulta.
                    $("#rua").val(dados.logradouro);
                    $("#bairro").val(dados.bairro);
                    $("#cidade").val(dados.localidade);
                    $("#state").val(dados.uf);
                    $(".overlay-loading").hide();
                } //end if.
                else {
                    //CEP pesquisado não foi encontrado.
                    limpa_formulário_cep();
                    alert("CEP não encontrado.");
                    $(".overlay-loading").hide();
                }
            });
        } //end if.
        else {
            //cep é inválido.
            limpa_formulário_cep();
            alert("Formato de CEP inválido.");
            $(".overlay-loading").hide();
        }
    } //end if.
    else {
        //cep sem valor, limpa formulário.
        limpa_formulário_cep();
    }
});