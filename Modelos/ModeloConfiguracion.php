<?php

namespace Modelos;

use Conect\Conexion;
use PDO;

class ModeloConfiguracion
{
    public static function mdlConfiguracion()
    {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM configuracion");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
