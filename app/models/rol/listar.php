<?php

require '../sql/conexion.php';

try{

    $params = $_GET;
    $params['query'] = ($params['query']=="") ? '%': '%'.$params['query'].'%';
    $response = array();

    $sql = "SELECT id_rol id, rol text
        FROM rol
        WHERE CAST(estado as UNSIGNED)=1
        AND rol LIKE '$params[query]'";
    $resultado = mysqli_query($con, $sql);

    if($resultado){
        if(mysqli_num_rows($resultado)>0){
            $items = array();
            while($fila = mysqli_fetch_assoc($resultado)){
                array_push($items, $fila);
            }

            $response = array(
                'success' => true,
                'data' => $items,
                'total' => COUNT($items)
            );
        }else{
            $response = array(
                'success'=>false,
                'error'=>'No se encontraron resultados'
            );
        }
    }else{
        $response = array(
            'success'=>false,
            'error'=>mysqli_error($con)
        );
    }

    echo json_encode($response);
}catch(Exception $e){
    $response = array(
        'success'=>false,
        'error'=>'Error en la consulta: ' . $e->getMessage()
    );

    echo json_encode($response);
}

$con->close();
unset($response);

?>