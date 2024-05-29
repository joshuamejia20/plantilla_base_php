$(document).ready(function () {
    listar_usuarios();
    listar_rol();

    $("#btn_guardar_user").click(function () { 
        $("#frm_registro_user").validate({
            ignore: "",
            rules :{
                nombres: 'required',
                apellidos: 'required',
                usuario: 'required',
                id_rol: 'required'
            },
            messages:{
                nombres: 'Debe rellenar los nombres',
                apellidos: 'Debe rellenar los apellidos',
                usuario: 'Pongase las vivas',
                id_rol: 'y como va iniciar sesión'
            },
            errorElement: 'span',
            errorPlacement: function(error, element){
                error.addClass('invalid-feedback');
                element.closest('.col-6').append(error);
            },
            highlight: function(element, errorClass, validClass){
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass){
                $(element).removeClass('is-invalid');
            },
            submitHandler: function(form){
                guardar_data();
            }
        });
    });
    
    $("#btn_imprimir").click(function(){
        imprimir_pdf();
    })
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

function guardar_data(){
    let form = $("#frm_registro_user").formJson();
    console.log(form);
    $.ajax({
        url: 'app/models/vehiculos/registrar.php', //hacia donde irá la solicitud (ruta)
        type: 'POST', //el metodo http a utilizar
        dataType: 'json', //tipo de datos que se espera recibir del servidor
        data: {
            form: form
        }
    }) // datos enviados al servidor
    .done(function (response){
        if(response.success){
            listar_vehiculos();
            $("#mdl_registro_car").modal('hide');
            Swal.fire({
                title: "<strong>Éxito</strong>",
                icon: "success",
                html: response.msg,
                showCloseButton: true,
                showCancelButton: true,
                focusConfirm: false,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
            });
        }else{
            //console.error(response.error);
            Swal.fire({
                title: "<strong>Atención</strong>",
                icon: "info",
                html: response.error,
                showCloseButton: true,
                showCancelButton: true,
                focusConfirm: false,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
            });
        }
    })//si la respuesta es exitosa (comunicacion)
    .fail(function(jqXHR, textStatus, errorThrown){
        console.log("Error al realizar la solicitud: "+ textStatus, errorThrown);
    })
}

function imprimir_pdf(){
  
    $.ajax({
        url: 'app/models/usuario/pdf.php', //hacia donde irá la solicitud (ruta)
        type: 'POST', //el metodo http a utilizar
        dataType: 'json', //tipo de datos que se espera recibir del servidor
        data: {
        }
    }) // datos enviados al servidor
    .done(function (response){
        if(response.success){
            
        }else{
            //console.error(response.error);
            Swal.fire({
                title: "<strong>Atención</strong>",
                icon: "info",
                html: response.error,
                showCloseButton: true,
                showCancelButton: true,
                focusConfirm: false,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
            });
        }
    })//si la respuesta es exitosa (comunicacion)
    .fail(function(jqXHR, textStatus, errorThrown){
        console.log("Error al realizar la solicitud: "+ textStatus, errorThrown);
    })
}