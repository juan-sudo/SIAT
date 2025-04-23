<?php
require_once "../vendor/autoload.php";

use Controladores\ControladorProveido;
use Controladores\ControladorPisos;
use Modelos\ModeloEspecievalorada;
use Modelos\ModeloProveido;


class AjaxProveidos
{
    public $datos;
    public $activarUsuario;
    public $activarId;
    public $idUsuario;
    public function ajaxAgregarProveido()
    {
        $datos = array(
            'Numero_Proveido' => $_POST["nroProveido"],
            'Descripcion' => $_POST["obserProveido"],
            'area' => $_POST["area_generar"],
            'Estado_Caja' => 0,
            'Estado_Uso' => 0,
            'Id_Ingreso_Especie' => NULL,
            'Nombres' => $_POST["nombreProveido"] ,
            'DNI' => $_POST["dniProveido"],
            'observaciones' => $_POST["obserProveido"],
            'items' => $_POST["items"]
        );
        $respuesta = ControladorProveido::ctrCrearProveido($datos);
        $respuesta_json = json_encode($respuesta);
		header('Content-Type: application/json');
		echo $respuesta_json;
    }
    public function ajaxAgregarProveido_editar()
    {
        $datos = array(
            'Numero_Proveido' => $_POST["nroProveido_e"],
            'Descripcion' => $_POST["obserProveido_e"],
            'area' => $_POST["area_generar_e"],
            'Estado_Caja' => 0,
            'Estado_Uso' => 0,
            'Id_Ingreso_Especie' => NULL,
            'Nombres' => $_POST["nombreProveido_e"] ,
            'DNI' => $_POST["dniProveido_e"],
            'observaciones' => $_POST["obserProveido_e"],
            'items' => $_POST["items_e"]
        );
        $respuesta = ControladorProveido::ctrCrearProveido_editar($datos);
        $respuesta_json = json_encode($respuesta);
		header('Content-Type: application/json');
		echo $respuesta_json;
    }
    public function ajaxTraerProveido()
    {
        $area = $_POST['idAreaPro']; // Asegúrate de obtener el área del POST correctamente.
        $respuesta = ControladorProveido::ctrMostrarUltimoProveido($area);
        echo json_encode($respuesta); // Codificar la respuesta como JSON
    }

    public function ajaxMostrarProveidosEspecie()
    {  //error_reporting(0);
        
            $area = $_POST["area"];
            $fecha = $_POST["fechPres"];
            $respuesta = ControladorProveido::ctrMostrarProveido($area,$fecha);
            if ($respuesta != 'nulo') {
                echo json_encode($respuesta);
            } else {
                echo  'no hay proveidos';
            }
        
    }

    public function ajaxMostrarEspeciesValoradas()
    {
        $valores = isset($_POST["idArea"]) ? $_POST["idArea"] : null;
        $tabla = 'especie_valorada';
        $item = 'Id_Area';
        $respuesta = ModeloEspecievalorada::mdlMostrarEspecievalorada($tabla, $item, $valores);
        echo json_encode($respuesta);
    }
    public function traerinfodeProvedio()
    {
        if ($_POST["numero_proveido"]) {
           
            $numero_proveido = $_POST["numero_proveido"];
            $area = $_POST["area"];
            $respuesta = ModeloProveido::mdlMostrarProveido2($numero_proveido,$area);
            echo json_encode($respuesta);
        } else {
            echo 'No se encontro Proveido';
        }
    }
    public function ajaxEditarProveido()
    {
        $datos = array(
            'Cantidad' => $_POST["cantidaProveidoEdit"],
            'Valor_Total' => $_POST["totalProveidoEdit"],
            'Descripcion' => $_POST["obserProveidoEdit"],
            'Id_Proveido' => $_POST["idProvEdit"]
        );
        $respuesta = ControladorProveido::ctrEditarProveido($datos);
        echo $respuesta;
    }
    public function ajaxEliminarProveido()
    {
        $datos = array(
            'Id_Proveido' => $_POST["idProveEli"]
        );
        $respuesta = ControladorProveido::ctrEliminarrProveido($datos);
        echo $respuesta;
    }

    public function ajaxMostrar_detalle_pago()
    {
        $numero_proveido = $_POST["numero_proveido"];
        $area = $_POST["area"];
        $respuesta = ControladorProveido::ctrMostrar_detalle_pago($numero_proveido,$area);
        echo json_encode($respuesta);
    }
}
//==== traer numero de proveido
if (isset($_POST['traerinfoProve'])) {
    $editar = new AjaxProveidos();
    $editar->ajaxTraerProveido();
}

// OBJETO AGREGAR 
if (isset($_POST['registrarProveido'])) {
    $nuevo = new AjaxProveidos();
    $nuevo->ajaxAgregarProveido();
}

// OBJETO AGREGAR editar proveido 
if (isset($_POST['registrarProveido_editar'])) {
    $nuevo = new AjaxProveidos();
    $nuevo->ajaxAgregarProveido_editar();
}

// OBJETO editar 
if (isset($_POST['mostrar_proveido'])) {
    $nuevo = new AjaxProveidos();
    $nuevo->ajaxMostrarProveidosEspecie();
}

if (isset($_POST['editarEprovedio'])) {
    $nuevo = new AjaxProveidos();
    $nuevo->traerinfodeProvedio();
}

if (isset($_POST['editar_proveido'])) {
    $nuevo = new AjaxProveidos();
    $nuevo->ajaxEditarProveido();
}

if (isset($_POST['eliminarProve'])) {
    $nuevo = new AjaxProveidos();
    $nuevo->ajaxEliminarProveido();
}

if (isset($_POST['mostrar_detalle_pago'])) {
    $nuevo = new AjaxProveidos();
    $nuevo->ajaxMostrar_detalle_pago();
}
