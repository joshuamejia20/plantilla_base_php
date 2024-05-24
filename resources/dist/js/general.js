$ (document).ready (function () {
  $ ('#btn_offline').click (function () {
    cerrar_sesion ();
  });
});

function cerrar_sesion () {
    Swal.fire ({
        title: '¿Deseas cerrar sesión?',
        text: 'Serás redireccionado al login',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, cerrar sesión',
        cancelButtonText: 'Cancelar',
    }).then (result => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'app/models/usuario/logout.php', //hacia donde irá la solicitud (ruta)
                type: 'POST', //el metodo http a utilizar
                dataType: 'json', //tipo de datos que se espera recibir del servidor
                data: {}
            }) // datos enviados al servidor
            .done(function (response){
                if(response.success){
                    location.href=response.url;
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
    });
}

$.fn.formJson = function (){
    var formJson = {};
    var formSerial = this.serializeArray();
    $.each(formSerial, function(){
        if(formJson[this.name]){
            if(!formJson[this.name].push){
                formJson[this.name] = [formJson[this.name]];
            }
            formJson[this.name].push(this.value || '');
        }else{
            formJson[this.name] = this.value || '';
        }
    });

    var formCheckbox = $('input[type=checkbox]', this);
    $.each(formCheckbox, function(){
        if(!formJson.hasOwnProperty(this.name)){
            formJson[this.name]=0;
        }
    });

    return formJson;
}