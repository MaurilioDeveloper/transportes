var inputEntrega = $('#unit-yes-no4').prop("checked",false);
$("#unit-yes-no4").change(function(){
    if(inputEntrega.prop("checked") === true){
        inputCheck = inputEntrega.prop("checked", true);
        $("#entregador").show();
    }else{
        inputCheck = inputEntrega.prop("checked", false);
        $("#entregador").hide();
    }
});

var inputColeta = $('#unit-yes-no5').prop("checked",false);
$("#unit-yes-no5").change(function(){
    if(inputColeta.prop("checked") === true){
        inputCheck = inputColeta.prop("checked", true);
        $("#coletor").show();
    }else{
        inputCheck = inputColeta.prop("checked", false);
        $("#coletor").hide();
    }
});