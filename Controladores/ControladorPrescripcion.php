<?php

namespace Controladores;

use Modelos\ModeloPrescripcion;
use Conect\Conexion;
use PDO;

class ControladorPrescripcion
{
    public static function ctrRegistrarPrescripcion($idDeuda,$data)
  {
    $respuesta = ModeloPrescripcion::mdlRegistrarPrescripcion($idDeuda,$data);
    return $respuesta;
  }
}

?>