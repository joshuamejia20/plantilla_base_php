$(document).ready(function () {
    listar_usuarios();
    listar_rol();
});

function listar_usuarios(){
    /*if($.fn.DataTable.isDataTable("#tbl_usuarios")){
        $("#tbl_usuarios").DataTable().clear();
        $("#tbl_usuarios").DataTable().destroy();
    }*/
    $("#tbl_usuarios").DataTable({
        language:{
            url: 'resources/plugins/datatables/spanish.json'
        },
        destroy: true,
        info: true,
        filter: true,
        lengthChange: false,
        pageLength: 1,
        responsive: true,
        processing: true,
        serverSide: true,
        order:[
            [1, 'asc']
        ],
        ajax:{
            url: 'app/models/usuario/listar.php',
            type: 'POST',
            dataType: 'Json'
        },
        columns:[
            {
                data: 'numero'
            },
            {
                data: 'nombres'
            },
            {
                data: 'apellidos'
            },
            {
                data: 'usuario'
            },
            {
                data: 'rol'
            },
            {
                data: 'estado'
            },
            {
                data: 'id_usuario',
                orderable: false,
                searchable: false
            }
        ]
    });
}

function listar_rol(data){
    $("#id_rol").select2({
        placeholder: 'Seleccione un rol',
        ajax:{
            url: 'app/models/rol/listar.php',
            type: 'GET',
            dataType: 'json',
            data: function(params){
                return{
                    query: params.term
                }
            },
            delay: 250,
            processResults: function(data, page){
                return {
                    results: data.data
                }
            },
            cache: true
        },
        theme: 'bootstrap4',
        allowClear: true,
        minimumInputLength: 0
    });
    $("#id_rol").val(null).trigger('change');
    if(data!=undefined && data != null){
        var option = new Option(data.rol, data.id_rol, false, false);
        $("#id_rol").html(option);
        $("#id_rol").trigger('change');
    }
}