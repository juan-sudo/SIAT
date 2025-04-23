<?php
session_start();
require_once "../vendor/autoload.php";

use Controladores\ControladorGiroComercial;
use Controladores\ControladorTim;
use Modelos\ModeloGiroComercial;
use Modelos\ModeloTim;

class AjaxTim
{
    //AGREGAR TIM
    public function ajaxAgregarTim()
    {
        $datos = array(
            'anio' => $_POST["anio"],
            'tim' => $_POST["tim"]
        );
        $respuesta = ControladorTim::ctrCrearTim($datos);
        echo $respuesta;
    }
    // EDITAR USARIO|
    public $idUsuario;
    public function ajaxEditarTim()
    {
        $item = 'Id_TIM';
        $valor = $this->idUsuario;
        $respuesta = ControladorTim::ctrMostrarTim($item, $valor);
        echo json_encode($respuesta);
    }
    // ACTIVAR USUARIO
    public $activarUsuario;
    public $activarId;
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
    public function ajaxMostrarEstadoCuentaTim()
    {
        $datos = array(
            'Anio' => $_POST["anioFiscalTim"],
            'Concatenado_idc' => $_POST["idContribuyente_idc"]
        );
        $respuesta = ControladorTim::ctrEstadoCuentaTim($datos);
         echo json_encode($respuesta);
    }


    public function ajaxCalcularTimporanio()
    {
        $datos = array(
            'Anio' => $_POST["anioFiscalTim"],
            'Concatenado_idc' => $_POST["idContribuyente_idc"]
        );
        $respuesta = ControladorTim::ctrCalculartimpoanio($datos);
        if ($respuesta == 'ok') {
            $respuesta = array(
              "tipo" => "correcto",
              "mensaje" => '<div class="col-sm-30">
                          <div class="alert alert-success">
                            <button type="button" class="close font__size-18" data-dismiss="alert">
                            </button>
                            <i class="start-icon far fa-check-circle faa-tada animated"></i>
                            <strong class="font__weight-semibold">Alerta!</strong>Tim calculado correctamente.
                          </div>
                        </div>'
            );
            $respuesta_json = json_encode($respuesta);
            header('Content-Type: application/json');
            echo $respuesta_json;
          }
    }
}
// OBJETO AGREGAR GIRO COMERCIAL
if (isset($_POST['anio'])) {
    $nuevo = new AjaxTim();
    $nuevo->ajaxAgregarTim();
}
// OBJETO EDITAR GIRO COMERCIAL
if (isset($_POST['idUsuario'])) {
    $editar = new AjaxTim();
    $editar->idUsuario = $_POST['idUsuario'];
    $editar->ajaxEditarTim();
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

if (isset($_POST['estadoCuentaTim'])) {
    $estadoCuentaTim = new AjaxTim();
    $estadoCuentaTim->ajaxMostrarEstadoCuentaTim();
}

if (isset($_POST['calculartim'])) {
    $estadoCuentaTim = new AjaxTim();
    $estadoCuentaTim->ajaxCalcularTimporanio();
}