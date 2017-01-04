jQuery('form[name="update-parceiro"]').submit(function () {
    jQuery(".msg-warn").hide();
    jQuery(".msg-suc").hide();
    var dadosForm = jQuery(this).serialize();
    console.log(dadosForm);
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
            console.log(data);
            if (data == "1") {
                form.fadeOut('slow', function () {
                    jQuery(".msg-suc").show();
                    setTimeout(function () {
                        window.location.href = '/painel/parceiros';
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
    $("#state").val("");
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

console.log($("#pessoa").val());
if($("#pessoa").val() === 'fisica'){
jQuery.validator.addMethod("cpf", function(value, element) {
    value = jQuery.trim(value);

    console.log(value);
    value = value.replace('.','');
    value = value.replace('.','');
    cpf = value.replace('-','');
    if(cpf.length == 0){
        return true;
    }else{
        // console.log(cpf);
        while(cpf.length < 11) cpf = "0"+ cpf;
        var expReg = /^0+$|^1+$|^2+$|^3+$|^4+$|^5+$|^6+$|^7+$|^8+$|^9+$/;
        var a = [];
        var b = new Number;
        var c = 11;
        for (i=0; i<11; i++){
            a[i] = cpf.charAt(i);
            if (i < 9) b += (a[i] * --c);
        }
        if ((x = b % 11) < 2) { a[9] = 0 } else { a[9] = 11-x }
        b = 0;
        c = 11;
        for (y=0; y<10; y++) b += (a[y] * c--);
        if ((x = b % 11) < 2) { a[10] = 0; } else { a[10] = 11-x; }

        var retorno = true;
        if ((cpf.charAt(9) != a[9]) || (cpf.charAt(10) != a[10]) || cpf.match(expReg)) retorno = false;

        return this.optional(element) || retorno;
    }

}, "Informe um CPF válido");


    $(document).ready(function(){

        $("#meuForm").validate({
            rules: {
                documento: {cpf: true}
            },
            messages: {
                documento: { cpf: 'CPF inválido'}
            }
        });
    });

}else{

jQuery.validator.addMethod("cnpj", function(cnpj, element) {
    // DEIXA APENAS OS NÚMEROS
    cnpj = cnpj.replace('/','');
    cnpj = cnpj.replace('.','');
    cnpj = cnpj.replace('.','');
    cnpj = cnpj.replace('-','');
    if(cnpj.length == 0){
        return true;
    }else{
        var numeros, digitos, soma, i, resultado, pos, tamanho,
            digitos_iguais;
        digitos_iguais = 1;

        if (cnpj.length < 14 && cnpj.length < 15){
            return false;
        }
        for (i = 0; i < cnpj.length - 1; i++){
            if (cnpj.charAt(i) != cnpj.charAt(i + 1)){
                digitos_iguais = 0;
                break;
            }
        }

        if (!digitos_iguais){
            tamanho = cnpj.length - 2
            numeros = cnpj.substring(0,tamanho);
            digitos = cnpj.substring(tamanho);
            soma = 0;
            pos = tamanho - 7;

            for (i = tamanho; i >= 1; i--){
                soma += numeros.charAt(tamanho - i) * pos--;
                if (pos < 2){
                    pos = 9;
                }
            }
            resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
            if (resultado != digitos.charAt(0)){
                return false;
            }
            tamanho = tamanho + 1;
            numeros = cnpj.substring(0,tamanho);
            soma = 0;
            pos = tamanho - 7;
            for (i = tamanho; i >= 1; i--){
                soma += numeros.charAt(tamanho - i) * pos--;
                if (pos < 2){
                    pos = 9;
                }
            }
            resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
            if (resultado != digitos.charAt(1)){
                return false;
            }
            return true;
        }else{
            return false;
        }
    }
}, "Informe um CNPJ válido."); // Mensagem padrão

    $(document).ready(function(){
        $("#meuForm").validate({
            rules: {
                documento: {cnpj: true}
            },
            messages: {
                documento: { cnpj: 'CNPJ inválido'}
            }
        });
    });


}

jQuery('form[name="cad-parceiro"]').submit(function () {
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
            console.log(data);
            if (data == "1") {
                form.fadeOut('slow', function () {
                    jQuery(".msg-suc").show();
                    setTimeout(function () {
                        window.location.href = '/painel/parceiros';
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

