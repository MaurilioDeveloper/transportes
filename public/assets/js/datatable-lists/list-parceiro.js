$.fn.dataTable.ext.errMode = 'throw';
//var editor; // use a global for the submit and return data rendering in the examples
$(document).ready(function () {


// Deletar Parceiro
    $('#parceiros-table').on('click', 'a.editor_remove', function (e) {
        e.preventDefault();

        var id = $(this).attr("id-parceiro");

        $("#dialog-confirm").dialog({
            resizable: false,
            height: "auto",
            width: 400,
            modal: true,
            buttons: {
                "Sim": function () {
                    $.ajax({
                        url: "/painel/parceiros/delete-parceiro/" + id,
                        type: "GET",
                        success: function (data) {
                            if (data == "1") {
                                setTimeout(function () {
                                    alert('Parceiro Excluido Com Sucesso');
                                    window.location.href = 'parceiros';
                                }, 2000);
                            }
                        }
                    });
                    $(this).dialog("close");
                },
                "Não": function () {
                    $(this).dialog("close");
                }
            }
        });
    });


    var palavraPesquisa = $("#palavraPesquisa").val();

    $('#parceiros-table').DataTable({
        processing: true,
        "oSearch": {"sSearch": palavraPesquisa},
        serverSide: true,
        responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.modal({
                    header: function (row) {
                        var data = row.data();
                        return 'Detalhes do Parceiro '+row.nome;
                    }
                }),
                renderer: $.fn.dataTable.Responsive.renderer.tableAll({
                    tableClass: 'table'
                })
            }
        },
        rowId: 'id',
        ajax: "parceiros/listaParceiros",
        columns: [

            {data: 'nome', name: 'parceiros.nome'},
            // { data: 'documento', name: 'parceiros.documento' },
            {data: 'email', name: 'parceiros.email'},
            {data: 'telefone', name: 'parceiros.telefone'},
            // { data: 'data_nasc', name: 'parceiros.data_nasc' },
            // { data: 'sexo', name: 'parceiros.sexo' },
            // { data: 'cep', name: 'parceiros.cep' },
            {data: 'endereco', name: 'parceiros.endereco'},
            // { data: 'numero', name: 'parceiros.numero' },
            {data: 'bairro', name: 'parceiros.bairro'},
            {data: 'cidade', name: 'parceiros.cidade'},
            // { data: 'estado', name: 'parceiros.estado' },
            {
                data: 'id',
                className: "center",
                render: function (data, type, row) {
                    var html = '<a href="parceiros/edit/' + row.id + '" id-parceiro="' + row.id + '" class="btn btn-primary btn-sm" style="display: inline"><i class="fa fa-edit"></i> Editar</a>' +
                        '<a href="" id-parceiro="' + row.id + '" class="btn btn-danger btn-sm editor_remove" style="display: inline; margin-left: 4px"><i class="fa fa-trash"></i> Deletar</a>' +
                        '<a id-parceiro="' + row.id + '" class="btn btn-success btn-sm" style="display: inline; margin-left: 4px" onclick="novoFrete(' + row.id + ')"><i class="fa fa-truck"></i> Novo Frete</a>';
                    if (row.caminhoes > 0 && row.motoristas > 0) {
                        html +='<a class="btn btn-info btn-sm v' + row.id + '" style="display: inline; margin-left: 4px" onclick="novaViagem(' + row.id + ')"><i class="fa fa-plane"></i> Nova Viagem</a>';
                    }else{
                        html += '<a disabled="true" class="btn btn-info btn-sm v' + row.id + '" style="display: inline; margin-left: 4px" onclick="novaViagem(' + row.id + ')"><i class="fa fa-plane"></i> Nova Viagem</a>'
                    }
                    return html;
                }
            },
        ],
        "language": {
            "url": "/assets/Portuguese-Brasil.json"
        },
        "lengthMenu": [
            [10, 25, 50, 100],
            ['10 linhas', '25 linhas', '50 linhas', '100 linhas']
        ],
        "dom": 'Bfrtip',
        "buttons": [
            'pageLength',
            // 'excelHtml5',
            // 'pdfHtml5',
            // 'print',
            {extend: 'selectAll', text: 'Selecionar todas'},
            {extend: 'selectNone', text: 'Remover seleção'},
            {extend: 'colvis', text: 'Colunas Visível'}

        ],
        "createdRow": function (row, data, index) {

            $('td', row).on('click', function () {
                // console.log(data.nomequestionario);
                // console.log(dash.getUsuario(data.codigo));
            })
        },

    });

    $('.dataTables_length').hide();

});

function novoFrete(id) {
    window.location.href = '/painel/fretes/create/' + id;
}

function novaViagem(id) {
    window.location.href = '/painel/viagens/create-edit/' + id;
    $(".overlay-loading").show();

}