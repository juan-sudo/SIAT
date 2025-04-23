<?php
session_start();
require_once "../vendor/autoload.php";

use Controladores\ControladorClasificador;
use Modelos\ModeloClasificador;

class AjaxClasificador
{ 
    //AGREGAR USUARIOS
    public function ajaxAgregarClasificador()
    {
                $datos = array(
                    'codigo' => $_POST["codigo"],
                    'descripcion' => $_POST["descripcion"],
                    'estado' =>'1',
                    'id_financiamiento' => $_POST["id_financiamiento"]
                );             
                $respuesta = ControladorClasificador::ctrCrearClasificador($datos);
                echo $respuesta;      
    }
    // EDITAR USARIO|
    public $idUsuario;
    public function ajaxEditarClasificador()
    {
        $item = 'Id_Presupuesto';
        $valor = $this->idUsuario;
        $respuesta = ControladorClasificador::ctrMostrarClasificador($item, $valor);
        echo json_encode($respuesta);
    }
    // ACTIVAR USUARIO
    public $activarUsuario;
    public $activarId;

    public function ajaxActivarClasificador()
    {
        $tabla = 'presupuesto';
        $item1 = 'Estado';
        $valor1 = $this->activarUsuario;
        $item2 = 'Id_Presupuesto';
        $valor2 = $this->activarId;
        $respuesta = ModeloClasificador::mdlActualizarClasificador($tabla, $item1, $valor1, $item2, $valor2);
        echo $respuesta;
    }
    // VALIDAR NO REPETIR USUARIO
    public $validarUsuario;
}

// OBJETO AGREGAR USUARIO
if (isset($_POST['codigo'])) {
    $nuevo = new AjaxClasificador();
    $nuevo->ajaxAgregarClasificador();
}
// OBJETO EDITAR USUARIO
if (isset($_POST['idUsuario'])) {
    $editar = new AjaxClasificador();
    $editar->idUsuario = $_POST['idUsuario'];
    $editar->ajaxEditarClasificador();
}
// OBJETO ACTIVAR USUARIO
if (isset($_POST['activarUsuario'])) {
    $activarUsuario = new AjaxClasificador();
    $activarUsuario->activarId = $_POST['activarId'];
    $activarUsuario->activarUsuario = $_POST['activarUsuario'];
    $activarUsuario->ajaxActivarClasificador();
}
// OBJETO VALIDAR NO REPETIR USUARIO
if (isset($_POST['validarUsuario'])) {
    $validarUsuario = new AjaxUsuarios();
    $validarUsuario->validarUsuario = $_POST['validarUsuario'];
    $validarUsuario->ajaxValidarUsuario();
}
// OBJETO VALIDAR NO REPETIR USUARIO


