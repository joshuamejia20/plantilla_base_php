<?php

    require '../sql/conexion.php';

    $params=$_POST;

    //parametros desde el datatable
    $params['limit'] = $params['length'];
    $params['order_column'] = $params['columns'][$params['order'][0]['column']]['data'];
    $params['order'] = $params['order'][0]['dir'];
    $params['query'] = ($params['search']['value']!= "") ? "%".$params['search']['value']."%" : "%";


    $sql = "SELECT *, @numero:=@numero+1
        FROM usuario u
        INNER JOIN usuario_rol ur ON u.id_usuario=ur.id_usuario
        INNER JOIN rol r ON ur.id_rol=r.id_rol
        WHERE
        (
            CONCAT_WS(' ', u.nombres, u.apellidos) LIKE '$params[query]'
            OR u.usuario LIKE '$params[query]'
        )
        ORDER BY '". $params['order_column'] . "' " . $params['order']. 
        " LIMIT ".$params['start'].", ".$params['limit'];

    $select_usuarios = mysqli_query($con, $sql);


    $sql = "SELECT COUNT(*) total
        FROM usuario u
        INNER JOIN usuario_rol ur ON u.id_usuario=ur.id_usuario
        INNER JOIN rol r ON ur.id_rol=r.id_rol
        WHERE
        (
            CONCAT_WS(' ', u.nombres, u.apellidos) LIKE '$params[query]'
            OR u.usuario LIKE '$params[query]'
        )";
    $select_conteo = mysqli_query($con, $sql);

    if(mysqli_num_rows($select_conteo)>0){
        $numero = 0;

        while($fila = mysqli_fetch_assoc($select_usuarios)){
            $response['data'][$numero]['numero'] = $fila['numero'];
            $response['data'][$numero]['nombres'] = $fila['nombres'];
            $response['data'][$numero]['apellidos'] = $fila['apellidos'];
            $response['data'][$numero]['usuario'] = $fila['usuario'];
            $response['data'][$numero]['rol'] = $fila['rol'];
            $response['data'][$numero]['estado'] = $fila['estado'];
            $response['data'][$numero]['id_usuario'] = $fila['id_usuario'];

            $numero++;
        }

        while($fila = mysqli_fetch_assoc($select_conteo)){
            $total = intval($fila['total']);
        }
    }else{
        $response['data'] = array();

    }

    $response['data'] = ((mysqli_num_rows($select_usuarios))>0) ? $response['data'] : array();
    $response['recordsTotal'] = ((mysqli_num_rows($select_conteo))>0) ? $total : 0;
    $response['recordsFiltered'] = ((mysqli_num_rows($select_conteo))>0) ? $total : 0;
    $response['success']=true;

    echo json_encode($response);
?>