<?php
session_start();
require_once "../vendor/autoload.php";

use Controladores\ControladorClasificador;
use Controladores\ControladorEspecievalorada;
use Controladores\ControladorGiroComercial;
use Modelos\ModeloClasificador;
use Modelos\ModeloEspecievalorada;
use Modelos\ModeloGiroComercial;
class AjaxGiroComercial
{    //AGREGAR GIRO
    public function ajaxAgregarGiroComercial()
    {
        $datos = array(
            'Nombre' => $_POST["nombre_giro"],
            'Estado' => '1'
        );
        $respuesta = ControladorGiroComercial::ctrCrearGiroComercial($datos);
        echo $respuesta;
    }
    // EDITAR USARIO|
    public $idGiro;
    public $activarUsuario;
    public $activarId;
   // EDITAR
    public function ajaxEditarGiroComercial()
    {
        $item = 'Id_Giro_Establecimiento';
        $valor = $this->idGiro;
        $respuesta = ControladorGiroComercial::ctrMostrarGiroComercial($item, $valor);
        echo json_encode($respuesta);
    }
    // ACTIVAR USUARIO
    public function ajaxActivarGiroComercial()
    {
        $tabla = 'giro_comercial';
        $item1 = 'Estado';
        $valor1 = $this->activarUsuario;
        $item2 = 'Id_Giro_Comercial';
        $valor2 = $this->activarId;
        $respuesta = ModeloGiroComercial::mdlActualizarEstadoGiroComercial($tabla, $item1, $valor1, $item2, $valor2);
        echo $respuesta;
    }
    // VALIDAR NO REPETIR USUARIO
    public $validarUsuario;
    public function ajaxValidarUsuario()
    {
        $item = 'usuario';
        $valor = $this->validarUsuario;
        $respuesta = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);
        echo json_encode($respuesta);
    }
}
// OBJETO AGREGAR GIRO COMERCIAL
if (isset($_POST['nombre_giro'])) {
    $nuevo = new AjaxGiroComercial();
    $nuevo->ajaxAgregarGiroComercial();
}
// OBJETO EDITAR GIRO COMERCIAL
if (isset($_POST['idGiro'])) {
    $editar = new AjaxGiroComercial();
    $editar->idGiro = $_POST['idGiro'];
    $editar->ajaxEditarGiroComercial();
}
// OBJETO ACTIVAR GIRO COMERCIAL
if (isset($_POST['activarUsuario'])) {
    $activarUsuario = new AjaxGiroComercial();
    $activarUsuario->activarId = $_POST['activarId'];
    $activarUsuario->activarUsuario = $_POST['activarUsuario'];
    $activarUsuario->ajaxActivarGiroComercial();
}
// OBJETO VALIDAR NO REPETIR GIRO COMERCIAL
if (isset($_POST['validarUsuario'])) {
    $validarUsuario = new AjaxUsuarios();
    $validarUsuario->validarUsuario = $_POST['validarUsuario'];
    $validarUsuario->ajaxValidarUsuario();
}
