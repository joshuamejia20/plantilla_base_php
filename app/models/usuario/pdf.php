<?php

require '../sql/conexion.php';
define('_URL_SYSTEM_','C:/xampp_7_4/htdocs/plantilla_base_php/');
require_once(_URL_SYSTEM_.'resources/plugins/mpdf/vendor/autoload.php');

try{

    $params = array();
    $response = array();

    $sql = "SELECT *
        FROM usuario u
        INNER JOIN usuario_rol ur ON u.id_usuario=ur.id_usuario
        INNER JOIN rol r ON ur.id_rol=r.id_rol";
    $resultado = mysqli_query($con, $sql);

    if($resultado){
        if(mysqli_num_rows($resultado)>0){
            $contenido = '
                <table width="100%" style="border: 1px solid #ccc;">
                    <thead>
                        <tr>
                            <th style="border: 1px solid #ccc;">#</th>
                            <th style="border: 1px solid #ccc;">Nombres</th>
                            <th style="border: 1px solid #ccc;">Apellidos</th>
                            <th style="border: 1px solid #ccc;">Usuario</th>
                            <th style="border: 1px solid #ccc;">Rol</th>
                            <th style="border: 1px solid #ccc;">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
            ';
            $contador = 1;
            while($fila = mysqli_fetch_assoc($resultado)){
                $contenido .= '
                    <tr>
                        <td style="border: 1px solid #ccc;">'.$contador.'</td>
                        <td style="border: 1px solid #ccc;">'.$fila['nombres'].'</td>
                        <td style="border: 1px solid #ccc;">'.$fila['apellidos'].'</td>
                        <td style="border: 1px solid #ccc;">'.$fila['usuario'].'</td>
                        <td style="border: 1px solid #ccc;">'.$fila['rol'].'</td>
                        <td style="border: 1px solid #ccc;">'.$fila['estado'].'</td>
                    </tr>
                ';
                $contador++;
            }
            $contenido .= '
                    </tbody>
                </table>
            ';

            $mpdfConfig = array(
                'mode' => 'utf-8',
                'format' => 'Letter',
                'default_font_size' => 12,
                'default_font' => 'arial',
                'margin_left' => 30,
                'margin_right' => 30,
                'margin_top' => 40,
                'margin_bottom' => 30,
                'margin_header' => 30,
                'margin_footer' => 30,
                'orientation' => 'P',
                'aliasNbPg' => '[pagetotal]'
            );

            $texto_encabezado = '
                <table width="100%">
                    <tr>
                        <td>
                            <img src="'._URL_SYSTEM_.'media/img/ucad.png" width="75">
                        </td>
                        <td style="text-align: center;">
                            UNIVERSIDAD CRISTIANA DE LAS ASAMBLEAS DE DIOS<br>
                            FACULTAD DE CIENCIAS ECONÓMICAS<br>
                            LISTA DE USUARIOS
                        </td>
                    </tr>
                </table>
            ';

            $texto_pie = '
                <table width="100%">
                    <tr>
                        <td>{PAGENO}/[pagetotal]</td>
                    </tr>
                </table>
            ';

            $mpdf = new \Mpdf\Mpdf($mpdfConfig);
            $mpdf->allow_charset_conversion = true;
            $mpdf->charset_in ='UTF-8';
            $mpdf->setAutoBottomMargin = "stretch";
            $mpdf->setAutoTopMargin = "stretch";

            $mpdf->SetHTMLHeader($texto_encabezado);
            $mpdf->SetHTMLFooter($texto_pie);
            $mpdf->WriteHTML($contenido);

            $file = "lista_usuarios.pdf";
            $mpdf->Output(_URL_SYSTEM_.'media/tmp/'.$file);

            if(@file_exists(_URL_SYSTEM_.'media/tmp/'.$file)){
                $response = array('success'=>true, 'url'=>'media/tmp/'.$file);
            }else{
                $response=array('success'=>false,'error'=>'No fue posible generar el pdf');
            }

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