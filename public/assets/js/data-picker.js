$(document).ready(function () {
    $('.datapicker').datepicker({
        dateFormat: 'dd/mm/yy',
        nextText: 'Próximo',
        prevText: 'Anterior'
    });
    $('#ocorrencia-table').on('click', 'a.remove', function (e) {
        e.preventDefault();

        var id = $(this).attr("id-ocorrencia");

        $("#dialog-confirm").dialog({
            resizable: false,
            height: "auto",
            width: 400,
            modal: true,
            buttons: {
                "Sim": function() {
                    $.ajax({
                        url: "/painel/parceiros/delete-ocorrencia/"+id,
                        type: "GET",
                        success: function (data) {
                            if (data == "1") {
                                setTimeout(function () {
                                    alert('Ocorrencia Excluido Com Sucesso');
                                    window.location.href = '';
                                }, 2000);
                            }
                        }
                    });
                    $( this ).dialog( "close" );
                },
                "Não": function() {
                    $( this ).dialog( "close" );
                }
            }
        });
    } );


});