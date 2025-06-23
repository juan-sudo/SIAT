<?php

namespace Conect;
use Exception;

date_default_timezone_set('America/Lima');
class Conexion
{
    const HOST = '127.0.0.1';
    const USER = 'root';
    const PASSWORD = ''; 
    const BDNAME = '300479';
    public static function conectar()
    {
        try {
            $link = new \PDO(
                "mysql:host=" . self::HOST . "; dbname=" . self::BDNAME . ";",
                self::USER,
                self::PASSWORD
            );
            $link->exec("set names utf8");
            return $link;
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}