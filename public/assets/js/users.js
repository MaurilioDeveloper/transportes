//$.fn.dataTable.ext.errMode = 'throw';
//var editor; // use a global for the submit and return data rendering in the examples
$(document).ready(function() {
   /*
   editor = new $.fn.dataTable.Editor( {
        ajax: "",
        table: "#table-usuarios",
        fields: [ {
                label: "Nome:",
                name: "name"
            }, {
                label: "Last name:",
                name: "email"
            }, {
                label: "Senha:",
                name: "password"
            }
        ]
    } );
 
    $('#table-usuarios').on( 'click', 'a.editor_edit', function (e) {
        var index = $(this).index();
 
        if ( index === 1 ) {
            editor.bubble( this, {
                title: 'Nome:'
            } );
        }
        else if ( index === 2 ) {
            editor.bubble( this, {
                buttons: false
            } );
        }
        else if ( index === 3 ) {
            editor.bubble( this );
        }
       
    } );
   */
// Deletar Visita
    $('#table-usuarios').on('click', 'a.editor_remove', function (e) {
        e.preventDefault();
        
        var id = $(this).attr("id-usuario");
 
        $("#dialog-confirm").dialog({
            resizable: false,
            height: "auto",
            width: 400,
            modal: true,
            buttons: {
              "Sim": function() {
                $.ajax({
                    url: "delete-usuario/"+id,
                    type: "GET",
                    success: function (data) {
                        if (data == "1") {
                            setTimeout(function () {
                                window.location.href = 'usuarios';
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

    
$.fn.dataTable.ext.errMode = 'throw';    
$('#table-usuarios').DataTable({
    processing: true,
    serverSide: true,
    ajax: "usuarios/listaUsuarios",
    columns: [
        { data: 'name', name: 'users.name' },
        { data: 'email', name: 'users.email' },
        {
            data: 'id',
            className: "center",
            render: function(data, type, row){
                return '<a href="" id-usuario="'+data+'" class="editor_edit btn btn-sm btn-primary"><i class="fa fa-edit"></i> Editar</a>\n\
                        <a href="" id-usuario="'+data+'" class="editor_remove btn btn-sm btn-danger"><i class="fa fa-trash"></i> Deletar</a>';
            }
        }
        
        
        
    ],
    "lengthMenu": [
            [10, 25, 50, 100],
            ['10 linhas', '25 linhas', '50 linhas', '100 linhas']
        ],
        "dom": 'Bfrtip',
        "buttons": [
            'pageLength',
            'excelHtml5',
            'pdfHtml5',
            'print',
            {extend: 'selectAll', text: 'Selecionar todas'},
            {extend: 'selectNone', text: 'Remover seleção'},
            {extend: 'colvis', text: 'Colunas Visível'},
     //       { extend: "remove", editor: editor }

        ],

    language: {
                "url": "../assets/datatables/Portuguese-Brasil.json"
              }
      
    
});

});