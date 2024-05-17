<?php

require '../sql/conexion.php';

$params = $_POST;

try{

    $sql = "SELECT u.id_usuario, u.nombres, u.apellidos, u.usuario, r.rol, r.id_rol,
        IF(
            CAST(u.estado AS UNSIGNED) =1,
            true,
            false
        ) estadoOk,
        IF(
            c.fecha_vencimiento < NOW(),
            false,
            true
        ) accesoOk
        FROM usuario u
        INNER JOIN clave c ON u.id_usuario=c.id_usuario AND CAST(c.estado AS UNSIGNED)=1
        INNER JOIN usuario_rol ur ON u.id_usuario=ur.id_usuario AND CAST(ur.estado AS UNSIGNED)=1
        INNER JOIN rol r ON ur.id_rol=r.id_rol
        WHERE u.usuario='$params[usuario]'
        AND c.clave=PASSWORD('$params[clave]')";
        $resultado = mysqli_query($con, $sql);

        if(!$resultado){
            throw new Exception(mysqli_error($con));
        }

        if(mysqli_num_rows($resultado)==0){
            throw new Exception('No hay coincidencia en las credenciales');
        }

        $datosUsuario = mysqli_fetch_assoc($resultado);

        if(!$datosUsuario['estadoOk']){
            throw new Exception('Su cuenta está inactiva');
        }

        if(!$datosUsuario['accesoOk']){
            throw new Exception('Su clave está  vencida');
        }


        session_start();

        $_SESSION['vehiculos'] = true;
        $_SESSION['vehiculos_id_usuario'] = $datosUsuario['id_usuario'];
        $_SESSION['vehiculos_usuario'] = $datosUsuario['usuario'];
        $_SESSION['vehiculos_name'] = $datosUsuario['nombres'] . " " . $datosUsuario["apellidos"];
        $_SESSION['vehiculos_id_rol'] = $datosUsuario['id_rol'];
        $_SESSION['vehiculos_rol'] = $datosUsuario['rol'];

        $sql ="INSERT INTO bitacora(fecha, accion, tabla, id_afectado, id_usuario)
        VALUES(NOW(), 1, 'no aplica', 0, '$_SESSION[vehiculos_id_usuario]')";
        $resultado = mysqli_query($con, $sql);

        $response = array('success'=>true, 'url'=>"?mod=inicio");
        

}catch(Exception $e){
    $response = array(
        'success'=>false,
        'error'=>$e->getMessage()
    );
}

echo json_encode($response);

?>