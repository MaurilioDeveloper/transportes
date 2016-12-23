$(document).ready(function(){
    /*
    var next = 1;
    $(".add-more").click(function(e){
        e.preventDefault();
        var addto = "#field" + next;
        var addRemove = "#field" + (next);
        next = next + 1;
        var newIn = '<input autocomplete="off" class="input form-control" id="field' + next + '" name="field' + next + '" type="text">';
        var newInput = $(newIn);
        var removeBtn = '<button id="remove' + (next - 1) + '" class="btn btn-danger remove-me pull-right" ><i class="fa fa-trash"></i></button></div><div id="field">';
        var removeButton = $(removeBtn);
        $(addto).after(newInput);
        $(addRemove).after(removeButton);
        $("#field" + next).attr('data-source',$(addto).attr('data-source'));
        $("#count").val(next);

        $('.remove-me').click(function(e){
            e.preventDefault();
            var fieldNum = this.id.charAt(this.id.length-1);
            var fieldID = "#field" + fieldNum;
            $(this).remove();
            $(fieldID).remove();
        });
    });
*/
    var next=0;
    $(".add-more").click(function(e) {

        var x = $('.count-contato').val();
        var m = $('#campos>#id>.row-fluid').length
        var resultado = (parseInt(x) + parseInt(m));
        // console.log(x, m, resultado);
        var t = parseInt(resultado);
        $("#campos>#id")
            .append('<div class="row-fluid " id="column-'+ (t + 1) +'"><div class="col-md-12"><hr style="border: 1px solid #ccc"/></div>' +

                        '<div class=""><div class="principal"></div>' +
                        '<div class="form-group  col-md-3"><label for="nome">Nome </label>' +
                            '<input type="text" placeholder="Nome" name="extras[' + (t + 1) + '][nome]" class="form-control" />' +
                        '</div>' +
                        '<div class="form-group  col-md-3"><label for="setor">Setor </label>' +
                            '<input type="text" placeholder="Setor" name="extras[' + (t + 1) + '][setor]" class="form-control" />' +
                        '</div>' +
                        '<div class="form-group  col-md-3"><label for="email">Email </label>' +
                            '<input type="text" placeholder="Email" name="extras[' + (t + 1) + '][email]" class="form-control" />' +
                        '</div>' +
                        '<div class="form-group  col-md-2"><label for="telefone">Telefone </label>' +
                            '<input type="text" name="extras[' + (t + 1) + '][telefone]" class="form-control phone" />' +
                        '</div>' +
                        '<div class="form-group col-lg-1"><label><hr/></label>' +
                            '<a onclick="removerContato('+(t+1)+')" class="remover btn btn-danger btn-sm"  style="margin-bottom: 2px"><i class="fa fa-trash"></i></a>' +
                        '</div>' +
                    '</div></div></div>');

    });


    $("#add-caminhao").click(function(e) {

        var x = $('.count-caminhao').val();
        var c = $('#idCaminhao>.row-fluid').length
        var resultado = (parseInt(x) + parseInt(c));
        t = parseInt(resultado);
        $("#idCaminhao")
            .append('<div class="row-fluid " id="caminhao-'+ (parseInt(t) + parseInt(1)) +'"><div class="col-md-12"><hr style="border: 1px solid #ccc"/></div>' +

                '<div class="principalCaminhao"></div>' +
                '<div class="form-group  col-md-4"><label for="placa">Placa </label>' +
                    '<input type="text" placeholder="AAA-9999" name="extraCaminhoes[' + (t + 1) + '][placa]" class="form-control" />' +
                '</div>' +
                '<div class="form-group  col-md-4"><label for="modelo">Modelo </label>' +
                    '<input type="text" placeholder="Modelo" name="extraCaminhoes[' + (t + 1) + '][modelo]" class="form-control" />' +
                '</div>' +
                '<div class="form-group  col-md-3"><label for="cor">Cor </label>' +
                    '<input type="text" placeholder="Cor" name="extraCaminhoes[' + (t + 1) + '][cor]" class="form-control" />' +
                '</div>' +
                '<div class="col-lg-1">' +
                    '<label><hr/></label>' +
                    '<a class="remover btn btn-danger btn-sm" onclick="removerCaminhao('+ (t + 1) +')" style="margin-bottom: 2px"><i class="fa fa-trash"></i></a>' +
                '</div>' +
                '</div>');
    });
    $("#add-motorista").click(function(e) {

        var x = $('.count-motorista').val();
        var m = $('#idMotorista>.row-fluid').length
        var t = (parseInt(x) + parseInt(m));
        $("#idMotorista")
            .append('<div class="row-fluid " id="motorista-'+ (t + 1) +'"><div class="col-md-12"><hr style="border: 1px solid #ccc"/></div>' +

                '<div class="principalCaminhao"></div>' +
                '<div class="form-group  col-md-4">' +
                    '<label for="nome">Nome </label>' +
                    '<input type="text" placeholder="Nome" name="extraMotoristas[' + (t + 1) + '][nome]" class="form-control" />' +
                '</div>' +
                '<div class="form-group  col-md-4">' +
                    '<label for="rg">RG </label>' +
                    '<input type="text" placeholder="RG" name="extraMotoristas[' + (t + 1) + '][rg]" class="form-control" />' +
                '</div>' +
                '<div class="form-group  col-md-3">' +
                    '<label for="telefone">Telefone </label>' +
                    '<input type="text" placeholder="Telefone" name="extraMotoristas[' + (t + 1) + '][telefone]" class="form-control phone" />' +
                '</div>' +
                '<div class="col-lg-1">' +
                    '<label><hr></label>' +
                    '<a class="remover btn btn-danger btn-sm" onclick="removerMotorista('+ (t + 1) +')"  style="margin-bottom: 10px"><i class="fa fa-trash"></i></a>' +
                '</div>');

    });

    $("#botao-tipo-ocorrencia").click(function(){
        $("#ocorrencia").modal('hide');
        $("#tipoOcorrencia").modal();
    });
});

function removerContato(id) {

    $('#column-'+id).remove();
}

function removerCaminhao(id) {
    $('#caminhao-'+id).remove();
}

function removerMotorista(id) {
    $('#motorista-'+id).remove();

    $.ajax({
        url: "/painel/parceiros/delete-motorista/"+id,
        type: "GET",
        success: function (data) {

        }
    });

}
