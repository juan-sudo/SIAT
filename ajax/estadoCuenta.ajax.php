<?php
session_start();
require_once "../vendor/autoload.php";

use Controladores\ControladorEstadoCuenta;

class AjaxEstadoCuenta
{
    public function estadoCuenta()
    {
       $idContribuyente = [$_POST['idContribuyente']];
       $respuesta = ControladorEstadoCuenta::ctrEstadoCuenta($idContribuyente, "estadocuenta");
       echo $respuesta;
    }

    public function deudasPrescritas()
    {
       $idContribuyente = [$_POST['idContribuyente']];
       $respuesta = ControladorEstadoCuenta::ctrDeudasPrescritas($idContribuyente);
       echo $respuesta;
    }
}

if (isset($_POST['estadoCuenta'])) {
    $nuevo = new AjaxEstadoCuenta();
    $nuevo->estadoCuenta();
 }
 if (isset($_POST['deudasPrescritas'])) {
    $nuevo = new AjaxEstadoCuenta();
    $nuevo->deudasPrescritas();
 }