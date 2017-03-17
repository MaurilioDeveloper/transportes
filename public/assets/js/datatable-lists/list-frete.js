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
                                } else{
                                    if(confirm('Impossível remover este frete pois ele faz parte de uma viagem. Quer abrir a viagem para vê-lo?')){
                                        window.open('/painel/viagens/edit/'+data)
                                    }
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


    var pesquisa = $("#pesquisa").val();
    console.log(pesquisa);
    var table = $('#fretes-table-two').DataTable({
        "oSearch":  {"sSearch": pesquisa},
        processing: true,
        serverSide: true,
        responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.modal( {
                    header: function ( row ) {
                        var data = row.data();
                        return 'Detalhes';
                    }
                } ),
                renderer: $.fn.dataTable.Responsive.renderer.tableAll( {
                    tableClass: 'table'
                } )
            }
        },
        rowId: 'id',
        ajax: {
            url:"/painel/fretes/lista-fretes",
            data:function () {
                return {filtrar:$('#filtroExibirEntregue:checked').length}
            }
        },
        columns: [

            { data: 'nome', "searchable": true, name: 'parceiros.nome'},
            { data: 'cidade_origem', name: 'od.cidade'},
            { data: 'cidade_destino', name: 'od2.cidade' },
            { data: 'localizacao', name: 'od3.cidade' },
            { data: 'identificacao', name: 'fretes.identificacao', render: function (data, type, row) {
                if(row.identificacao == ''){
                    return row.chassi;
                }else{
                    return row.identificacao
                }
            } },
            { data: 'tipo', name: 'fretes.tipo' },
            { data: 'status', name: 'fretes.status' },
            {
                data: 'od2.cidade',
                className: "center",
                render: function(data, type, row){
                        return '<a href="fretes/edit/'+row.id+'" id-frete="'+row.id+'" class="btn btn-primary btn-sm" style="display: inline"><i class="fa fa-edit"></i> Editar</a><a href="" id-frete="'+row.id+'" class="btn btn-danger btn-sm editor_remove" style="display: inline; margin-left: 4px"><i class="fa fa-trash"></i> Deletar</a>';
                }
            },
            { data: 'chassi', name: 'fretes.chassi',visible:false }
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
    $('#filtroExibirEntregue').on('change',function (event) {
        table.ajax.reload();
    })

    $('.dataTables_length').hide();

} );

function enableEntregue(){
    location.href = '/painel/fretes?exibirEntregues=1';
}