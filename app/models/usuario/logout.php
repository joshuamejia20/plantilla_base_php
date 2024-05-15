<?php

    session_start();
    //session_destroy();

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