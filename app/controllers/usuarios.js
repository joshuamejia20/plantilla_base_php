$(document).ready(function () {
    listar_usuarios();
});

function listar_usuarios(){
    /*if($.fn.DataTable.isDataTable("#tbl_usuarios")){
        $("#tbl_usuarios").DataTable().clear();
        $("#tbl_usuarios").DataTable().destroy();
    }*/
    $("#tbl_usuarios").DataTable({
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