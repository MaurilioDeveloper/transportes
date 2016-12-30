
// Deletar Parceiro
$('#parceiros-table-pesquisa').on('click', 'a.editor_remove', function (e) {
    e.preventDefault();

    var id = $(this).attr("id-parceiro-pesquisa");

    $("#dialog-confirm").dialog({
        resizable: false,
        height: "auto",
        width: 400,
        modal: true,
        buttons: {
            "Sim": function() {
                $.ajax({
                    url: "/painel/parceiros/delete-parceiro/"+id,
                    type: "GET",
                    success: function (data) {
                        if (data == "1") {
                            setTimeout(function () {
                                alert('Parceiro Excluido Com Sucesso');
                                window.location.href = '/painel/parceiros';
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
