<?php
session_start();
require_once "../vendor/autoload.php";

use Controladores\ControladorFormulaimpuesto;
use Controladores\ControladorEspecievalorada;
use Modelos\ModeloFormulaimpuesto;
use Modelos\ModeloEspecievalorada;

class AjaxFormulaimpuesto
{
    
    //AGREGAR USUARIOS
    public function ajaxAgregarFormulaimpuesto()
    {
                $datos_1 = array(
                    'codigo' => $_POST["codigo_1"],
                    'anio' => $_POST["anio"],
                    'uit' => $_POST["uit"],
                    'baseimponible' => $_POST["baseimponible_1"],
                    'base' => $_POST["base_1"],
                    'formulabase' => $_POST["formulabase_1"],
                    'porcentaje' => $_POST["porcentaje_1"],
                    'autovaluo' => $_POST["autovaluo_1"]
                    
                );
                 $datos_2 = array(
                    'codigo' => $_POST["codigo_2"],
                    'anio' => $_POST["anio"],
                    'uit' => $_POST["uit"],
                    'baseimponible' => $_POST["baseimponible_2"],
                    'base' => $_POST["base_2"],
                    'formulabase' => $_POST["formulabase_2"],
                    'porcentaje' => $_POST["porcentaje_2"],
                    'autovaluo' => $_POST["autovaluo_2"]
                    
                );
                  $datos_3 = array(
                    'codigo' => $_POST["codigo_3"],
                    'anio' => $_POST["anio"],
                    'uit' => $_POST["uit"],
                    'baseimponible' => $_POST["baseimponible_3"],
                    'base' => $_POST["base_3"],
                    'formulabase' => $_POST["formulabase_3"],
                    'porcentaje' => $_POST["porcentaje_3"],
                    'autovaluo' => $_POST["autovaluo_3"]
                    
                );
                   $datos_4 = array(
                    'codigo' => $_POST["codigo_4"],
                    'anio' => $_POST["anio"],
                    'uit' => $_POST["uit"],
                    'baseimponible' => $_POST["baseimponible_4"],
                    'base' => $_POST["base_4"],
                    'formulabase' => $_POST["formulabase_4"],
                    'porcentaje' => $_POST["porcentaje_4"],
                    'autovaluo' => $_POST["autovaluo_4"]
                    
                );
                $respuesta1 = ControladorFormulaimpuesto::ctrCrearFormulaimpuesto($datos_1);
                $respuesta2 = ControladorFormulaimpuesto::ctrCrearFormulaimpuesto($datos_2);
                $respuesta3 = ControladorFormulaimpuesto::ctrCrearFormulaimpuesto($datos_3);
                $respuesta = ControladorFormulaimpuesto::ctrCrearFormulaimpuesto($datos_4);
                echo $respuesta;
  
        
    }
    // EDITAR FORMULA
    public $idUsuario;

    public function ajaxEditarFormulaimpuesto()
    {
        $item = 'Id_Formula_Impuesto';
        $valor = $this->idUsuario;
        $respuesta = ControladorFormulaimpuesto::ctrMostrarFormulaimpuesto($item, $valor);

        echo json_encode($respuesta);
    }
    // ACTIVAR USUARIO
    public $activarUsuario;
    public $activarId;

    public function ajaxActivarEspecievalorada()
    {

        $tabla = 'especie_valorada';
        $item1 = 'Estado';
        $valor1 = $this->activarUsuario;
        $item2 = 'Id_Especie_Valorada';
        $valor2 = $this->activarId;

        $respuesta = ModeloEspecievalorada::mdlActualizarEstadoEspecievalorada($tabla, $item1, $valor1, $item2, $valor2);
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

// OBJETO AGREGAR USUARIO
if (isset($_POST['uit'])) {
    $nuevo = new AjaxFormulaimpuesto();
    $nuevo->ajaxAgregarFormulaimpuesto();
}
// OBJETO EDITAR USUARIO
if (isset($_POST['idUsuario'])) {

    $editar = new AjaxFormulaimpuesto();
    $editar->idUsuario = $_POST['idUsuario'];
    $editar->ajaxEditarFormulaimpuesto();
}
// OBJETO ACTIVAR USUARIO
if (isset($_POST['activarUsuario'])) {

    $activarUsuario = new AjaxEspecievalorada();
    $activarUsuario->activarId = $_POST['activarId'];
    $activarUsuario->activarUsuario = $_POST['activarUsuario'];
    $activarUsuario->ajaxActivarEspecievalorada();
}
// OBJETO VALIDAR NO REPETIR USUARIO
if (isset($_POST['validarUsuario'])) {
    $validarUsuario = new AjaxUsuarios();
    $validarUsuario->validarUsuario = $_POST['validarUsuario'];
    $validarUsuario->ajaxValidarUsuario();
}
// OBJETO VALIDAR NO REPETIR USUARIO
if (isset($_POST['dni'])) {
    $objDni = new AjaxUsuarios();
    $objDni->dni = $_POST['dni'];
    $objDni->ajaxBuscarDni();
}

