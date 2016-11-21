$(document).ready(function () {
    $('form[name="form"]').submit(function () {
        jQuery(".alert-warning").hide();
        var dadosForm = jQuery(this).serialize();
        var form = jQuery(this);
        var botao = $(this).find(':button');

        $.ajax({
            url: 'login',
            type: "POST",
            data: dadosForm,
            beforeSend: function () {
                botao.attr('disabled', true).html('Aguarde Carregando...', true);
            },
            success: function (data) {
                console.log(data);
                botao.attr('disabled', false).html('Entrar');
                if (data == "1") {
                    form.fadeOut('fast', function () {
                        jQuery(".alert-success").show();
                        $('#load').fadeIn('slow');
                        window.location.href = 'painel/usuarios';
                    });
                } else {
                    jQuery(".alert-warning").show().delay(2000).fadeOut();
                }
            }
        });

        return false;
    });

    //FUNÇÕES GERAIS
    function msg(msg, tipo) {
        var retorno = $('.retorno');
        var tipo = (tipo === 'success') ? 'success' : (tipo === 'warning') ? 'warning' : (tipo === 'danger') ? 'danger' : (tipo === 'info') ? 'info' : alert('INFORME UMA MENSAGEM DE SUCESSO, ATENÇÃO, ERRO OU INFORMAÇÃO');
        retorno.empty().fadeOut('fast', function () {
            return $(this).html('<div class="alert alert-' + tipo + '">' + msg + '</div>').fadeIn('slow');

        });

        setTimeout(function () {
            retorno.fadeOut('slow').empty();
        }, 6000)
    }

});
