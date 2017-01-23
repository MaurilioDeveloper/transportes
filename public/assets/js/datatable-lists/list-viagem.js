$.fn.dataTable.ext.errMode = 'throw';
//var editor; // use a global for the submit and return data rendering in the examples
$(document).ready(function() {


// Deletar Parceiro
    $('#lista-viagens').on('click', 'a.editor_remove', function (e) {
        e.preventDefault();

        var id = $(this).attr("id-viagem");

        $("#dialog-confirm").dialog({
            resizable: false,
            height: "auto",
            width: 400,
            modal: true,
            buttons: {
                "Sim": function() {
                    $.ajax({
                        url: "/painel/viagens/delete-viagem/"+id,
                        type: "GET",
                        success: function (data) {
                            if (data == "1") {
                                setTimeout(function () {
                                    alert('Viagem Excluida Com Sucesso');
                                    window.location.href = 'viagens';
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



    var statusPesquisa = $("#statusPesquisa").val();
    console.log(statusPesquisa);

    $('#lista-viagens').DataTable({
        // processing: true,
        "oSearch":  {"sSearch": statusPesquisa},
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
        ajax: "/painel/viagens/lista-fretes",
        columns: [

            { data: 'parceiro', name: 'parceiros.nome'},
            { data: 'motorista', searchable: false},
            { data: 'caminhao', name: 'c.modelo'},
            { data: 'status', name: 'viagens.status' },
            { type:'date', data: 'data_inicio', name: 'viagens.data_inicio',
                render:function(a){
                    var d=new Date(a.replace('-','/'));if(d == 'Invalid Date'){return '00/00/0000'}else{return d.toLocaleDateString()}
                }
            },
            { data: 'cidade_origem', searchable: false },
            { data: 'cidade_destino', searchable: false },
            {
                data: 'cidade_origem',
                searchable: false,
                className: "center",
                render: function(data, type, row){
                    // console.log(data);
                    // console.log(row);
                    return '<a href="viagens/edit/'+row.id+'" id-viagem="'+row.id+'" class="btn btn-primary btn-sm" style="display: inline"><i class="fa fa-edit"></i> Editar</a><a href="" id-viagem="'+row.id+'" class="btn btn-danger btn-sm editor_remove" style="display: inline; margin-left: 4px"><i class="fa fa-trash"></i> Deletar</a>';
                }
            },
            { data: null, name: 'f.chassi',visible:false },
            { data: null, name: 'f.identificacao',visible:false },
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