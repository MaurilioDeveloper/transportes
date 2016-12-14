$.fn.dataTable.ext.errMode = 'throw';
//var editor; // use a global for the submit and return data rendering in the examples
$(document).ready(function() {


// Deletar Fretes
    $('#fretes-table-two').on('click', 'a.editor_remove', function (e) {
        e.preventDefault();

        var id = $(this).attr("id-frete");

        $("#dialog-confirm").dialog({
            resizable: false,
            height: "auto",
            width: 400,
            modal: true,
            buttons: {
                "Sim": function() {
                    $.ajax({
                        url: "/painel/fretes/delete-frete/"+id,
                        type: "GET",
                        success: function (data) {
                            if (data == "1") {
                                setTimeout(function () {
                                    alert('Frete Excluido Com Sucesso');
                                    window.location.href = '/painel/fretes';
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



    $('#fretes-table').DataTable({
        processing: true,
        serverSide: true,
        responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.modal( {
                    header: function ( row ) {
                        var data = row.data();
                        return 'Details for '+data[0]+' '+data[1];
                    }
                } ),
                renderer: $.fn.dataTable.Responsive.renderer.tableAll( {
                    tableClass: 'table'
                } )
            }
        },
        rowId: 'id',
        ajax: "fretes/lista-fretes",
        columns: [

            { data: 'nome', name: 'parceiros.nome'},
            { data: 'cidade_origem', name: 'fretes.cidade_origem' },
            { data: 'cidade_destino', name: 'fretes.cidade_destino' },
            { data: 'tipo', name: 'fretes.tipo' },
            { data: 'status', name: 'fretes.status' },
            {
                data: 'cidade_origem',
                className: "center",
                render: function(data, type, row){
                    return '<a href="fretes/edit/'+row.id+'" id-frete="'+row.id+'" class="btn btn-primary btn-sm" style="display: inline"><i class="fa fa-edit"></i> Editar</a><a href="" id-frete="'+row.id+'" class="btn btn-danger btn-sm editor_remove" style="display: inline; margin-left: 4px"><i class="fa fa-trash"></i> Deletar</a>';
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

} );