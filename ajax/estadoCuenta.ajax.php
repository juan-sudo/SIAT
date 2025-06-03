<?php

//file_put_contents('log_post.txt', print_r($_POST, true));
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

    
    public function eliminarEstadoCuenta()
      {
         $idEstado = $_POST['idEstado'] ?? null;

         if ($idEstado) {
            // Llamar al método del controlador que elimina el estado de cuenta
            $respuesta = ControladorEstadoCuenta::ctrEliminarEstadoCuenta($idEstado);

            // Manejar las posibles respuestas que puede devolver el controlador
            if ($respuesta === 'ok') {
                  echo 'success';
            } elseif ($respuesta === 'no_exist') {
                  echo 'no_exist';
            } else {
                  echo 'error';
            }
         } else {
            echo 'error';
         }
      }

        public function pagadoEstadoCuenta()
      {
         $idEstado = $_POST['idEstado'] ?? null;

         if ($idEstado) {
            // Llamar al método del controlador que elimina el estado de cuenta
            $respuesta = ControladorEstadoCuenta::ctrPagadoEstadoCuenta($idEstado);

            // Manejar las posibles respuestas que puede devolver el controlador
            if ($respuesta === 'ok') {
                  echo 'success';
            } elseif ($respuesta === 'no_exist') {
                  echo 'no_exist';
            } else {
                  echo 'error';
            }
         } else {
            echo 'error';
         }
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

 if (isset($_POST['eliminarCuenta'])) {
    //file_put_contents('log_condicionEliminarCuenta.txt', "Se detectó eliminarCuenta\n", FILE_APPEND);
    $nuevo = new AjaxEstadoCuenta();
    $nuevo->eliminarEstadoCuenta();
}

 if (isset($_POST['pagadoCuenta'])) {
    //file_put_contents('log_condicionEliminarCuenta.txt', "Se detectó eliminarCuenta\n", FILE_APPEND);
    $nuevo = new AjaxEstadoCuenta();
    $nuevo->pagadoEstadoCuenta();
}

if (isset($_POST['cargarEstadoCuenta'])) {
    // Supongamos que $idArray viene del POST o sesión
    $idArray = $_POST['idArray'] ?? [];  // Ajusta según cómo tengas el idArray
    echo ControladorEstadoCuenta::ctrEstadoCuenta($idArray, "estadocuenta");
    exit;
}


