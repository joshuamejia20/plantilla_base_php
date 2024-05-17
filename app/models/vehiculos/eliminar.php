<?php

require '../sql/conexion.php';

session_start();

    $params = $_POST;

    $sql = "CALL extraer_datos('$params[id_no_normalizada]','no_normalizada', @datos)";
    $solicitar_datos = mysqli_query($con, $sql);

    $sql = "SELECT @datos";
    $registro_datos = mysqli_query($con, $sql);

    $datos = mysqli_fetch_assoc($registro_datos);
    $antes = $datos['@datos'];
    $despues = '';

    $sql = "DELETE FROM no_normalizada
        WHERE id_no_normalizada='$params[id_no_normalizada]'";
    $eliminar = mysqli_query($con, $sql);

    if(mysqli_affected_rows($con)>0){

        $sql="CALL registrar_bitacora('$params[id_no_normalizada]', 'no_normalizada', 5, '$_SESSION[vehiculos_id_usuario]', '$antes','$despues')";
        $registro_bitacora=mysqli_query($con, $sql);

        $response = array(
            'success'=>true,
            'msg'=>'Vehiculo eliminado correctamente'
        );
    }else{
        $response = array(
            'success'=>false,
            'error'=>mysqli_error($con)
        );
    }

    echo json_encode($response);

?>