<?php

define('MODULO_DEFECTO', 'login');
define('LAYOUT_LOGIN', 'login.php');
define('LAYOUT_DESKTOP', 'desktop.php');
define('MODULO_PATH', realpath('app/views'));
define('LAYOUT_PATH', realpath('app/templates'));

$conf['login'] = array(
    'archivo'=>'login.html',
    'layout'=>LAYOUT_LOGIN
);

$conf['inicio'] = array(
    'archivo'=>'inicio.html',
    'layout'=>LAYOUT_DESKTOP
);

$conf['vehiculos'] = array(
    'archivo'=>'vehiculos.html',
    'layout'=>LAYOUT_DESKTOP
);

$conf['usuarios'] = array(
    'archivo'=>'usuarios.html',
    'layout'=>LAYOUT_DESKTOP
);

$conf['tamales'] = array(
    'archivo'=>'vehiculos.html',
    'layout'=>LAYOUT_DESKTOP
);

if(1==2){

    $conf['pupusas'] = array(
        'archivo'=>'vehiculos.html',
        'layout'=>LAYOUT_DESKTOP
    );
}

?>