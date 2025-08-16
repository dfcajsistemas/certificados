<?php

if(!function_exists('estadoDoc')) {
    function estadoDoc($e=null) {
        $estado=[
            1=>'Aprobado',
            2=>'Aprobado con notas',
            3=>'Revisar y volver a enviar',
            4=>'Rechazado'
        ];
        return $e ? $estado[$e] : $estado;
    }
}
