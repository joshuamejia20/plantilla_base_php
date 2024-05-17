<?php

require '../sql/conexion.php';
    session_start();
    //session_destroy();

    $sql ="INSERT INTO bitacora(fecha, accion, tabla, id_afectado, id_usuario)
        VALUES(NOW(), 2, 'no aplica', 0, '$_SESSION[vehiculos_id_usuario]')";
    $resultado = mysqli_query($con, $sql);

    unset(
        $_SESSION['vehiculos'],
        $_SESSION['vehiculos_id_usuario'],
        $_SESSION['vehiculos_usuario'],
        $_SESSION['vehiculos_name'],
        $_SESSION['vehiculos_id_rol'],
        $_SESSION['vehiculos_rol']
    );

    $response=array('success'=>true, 'url'=>"?mod=login");

    echo json_encode($response);

?>