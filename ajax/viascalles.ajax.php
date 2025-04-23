<?php
session_start();
require_once "../vendor/autoload.php";

use Controladores\Controladorviascalles;

class AjaxViascalles
{
    public $idDireccion;
    public function AjaxMostrarViascalles_editar_contribuyente()
    {
        $item = "Id_Ubica_Vias_Urbano";
        $valor = $this->idDireccion;
        $respuesta = ControladorViascalles::ctrMostrarDireccion_edicontri($item, $valor);
        echo json_encode($respuesta);
    }
    public function AjaxMostrarViascalles_editar_contribuyenteDir()
    {
        $item = "Id_Contribuyente";
        $valor = $this->idDireccion;
        $respuesta = ControladorViascalles::ctrMostrarDireccion_edicontri2($item, $valor);
        echo json_encode($respuesta);
    }

    public function AjaxAgregarViascalles()
    {
        $datos = array(
            'id_barrio' => $_POST["id_barrio"],
            'id_zona' => $_POST["id_zona"],
            'id_zona_c' => $_POST["id_zona_c"],
            'id_tipovia' => $_POST["id_tipovia"],
            'id_manzana' => $_POST["id_manzana"],
            'nombre_direccion' => $_POST["nombre_direccion"]
        );
        $respuesta = ControladorViascalles::ctrCrearViascalles($datos);
        echo $respuesta;
    }
    // EDITAR DIRECCION
    public $idUsuario;
    public function ajaxEditarViascalles()
    {
        $item = 'Id_Direccion';
        $valor = $this->idUsuario;
        $respuesta = ControladorViascalles::ctrMostrarViascalles($item, $valor);

        echo json_encode($respuesta);
    }
    // ACTIVAR USUARIO
    public $activarUsuario;
    public $activarId;
    // VALIDAR NO REPETIR USUARIO
    public $validarUsuario;
    public function ajaxValidarUsuario()
    {
        $item = 'usuario';
        $valor = $this->validarUsuario;
        //  $respuesta = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);
        //  echo json_encode($respuesta);
    }
    public function ajaxBuscarSubVias()
    {
        $datos = array(
            'Id_Nombre_Via' => $_POST["idNombreVia"]
        );
        $subviaResultado = ControladorViascalles::ctrMostrarSubVias($datos);
        echo json_encode($subviaResultado);
    }
    public function ajaxRegistrarCuadra()
    {
        $datos = array(
            'Id_Cuadra' => $_POST["idNumeroCuadra"],
            'Id_Lado' => $_POST["idLadoCuadra"],
            'Id_Direccion' => $_POST["idDireccionesVia"],
            'Id_Condicion_Catastral' => $_POST["idCondCatastral"],
            'Id_Situacion_Cuadra' => $_POST["idSituacionCuadra"],
            'Id_Parque_Distancia' => $_POST["idDistanciaParque"],
            'Id_Manzana' => $_POST["idManzana"],
            'Id_Zona_Catastro' => $_POST["idZonaCatastro"],
            'Id_Nombre_Via' => $_POST["nombreViaC"],
            'Id_Zona' => $_POST["idZona"]
        );
        $respuesta = Controladorviascalles::ctrRegistrarCuadras($datos);
        echo $respuesta;
    }
    public function ajaxRegistrarArancelVia()
    {
        $datos = array(
            'Id_Arancel' => $_POST["idviaArancel"],
            'Id_Ubica_Vias_Urbano' => $_POST["idubicaViaC"],
        );
        $respuesta = Controladorviascalles::ctrRegistrarArancelVias($datos);
        echo $respuesta;
    }
    public function ajaxListarUbicaVias()
    {
        $datos = array(
            'Id_Direccion' => $_POST["idDireccionVia"]
        );
        $subviaResultado = ControladorViascalles::ctrMostrarUbicaVia($datos);
        echo json_encode($subviaResultado);
    }
    public function ajaxListarArancelVias()
    {
        $datos = array(
            'Id_Ubica_Vias_Urbano' => $_POST["idubicaArancel"]
        );
        $subviaResultado = ControladorViascalles::ctrMostrarUbicaViaAracel($datos);
        echo json_encode($subviaResultado);
    }
    public function ajaxListaArancelyear()
    {
        $datos = array(
            'Id_Anio' => $_POST["selectedYear"]
        );
        $subviaResultado = ControladorViascalles::ctrMostrarArancelYear($datos);
        echo json_encode($subviaResultado);
    }
    public function AjaxMostrarVia_editarpredio()
    {
        $datos = array(
            'Id_Ubica_Vias_Urbano' => $_POST["idubicaviaedit"],
            'Id_Anio' => $_POST["idanioedit"],
        );
        $via = ControladorViascalles::ctrMostrarViasEditarPredio($datos);
        echo json_encode($via);
    }
    public function AjaxMostrarVia_editarpredior()
    {
        $datos = array(
            'Id_via_rus' => $_POST["idubicaviaeditr"],
            'Id_Anio' => $_POST["idanioedit"],
        );
        $via = ControladorViascalles::ctrMostrarViasEditarPredior($datos);
        echo json_encode($via);
    }
    public function AjaxMostrarVia_editarArancel()
    {
        $datos = array(
            'Id_Arancel_Vias' => $_POST["idArancelVia"],
        );
        $via = ControladorViascalles::ctrMostrarArancelVia($datos);
        echo json_encode($via);
    }

    public function AjaxEditarArancel_via()
    {
        $datos = array(
            'Id_Arancel_Vias' => $_POST["idarancelVia_e"],
            'Id_Arancel' => $_POST["idArancel_e"]
        );
        $respuesta = Controladorviascalles ::ctrEditarArancelViaEdit($datos);
        echo json_encode($respuesta);
    }
}
// AGREGAR ITEM AL CARRO
if (isset($_POST['idViascalles'])) {
    $objCarrito = new AjaxViascalles();
    $objCarrito->idDireccion = $_POST['idViascalles'];
    $objCarrito->AjaxAgregarViascalles();
}

if (isset($_POST['idDireccion'])) {
    $objMostrar = new AjaxViascalles();
    $objMostrar->idDireccion = $_POST['idDireccion'];
    $objMostrar->AjaxMostrarViascalles_editar_contribuyente();
}

if (isset($_POST['idcoDireccion'])) {
    $objMostrar = new AjaxViascalles();
    $objMostrar->idDireccion = $_POST['idcoDireccion'];
    $objMostrar->AjaxMostrarViascalles_editar_contribuyenteDir();
}

if (isset($_POST['idNombreVia'])) {
    $objDireccio = new AjaxViascalles();
    $objDireccio->ajaxBuscarSubVias();
}

if (isset($_POST['registrarCuadra'])) {
    $objDireccio = new AjaxViascalles();
    $objDireccio->ajaxRegistrarCuadra();
}

if (isset($_POST['idDireccionVia'])) {
    $objUbicaVias = new AjaxViascalles();
    $objUbicaVias->ajaxListarUbicaVias();
}

if (isset($_POST['idubicaArancel'])) {
    $objUbicaVias = new AjaxViascalles();
    $objUbicaVias->ajaxListarArancelVias();
}
if (isset($_POST['selectedYear'])) {
    $objUbicaVias = new AjaxViascalles();
    $objUbicaVias->ajaxListaArancelyear();
}
if (isset($_POST['regiArancelVia'])) {
    $objDireccio = new AjaxViascalles();
    $objDireccio->ajaxRegistrarArancelVia();
}

if (isset($_POST['idubicaviaedit'])) {
    $objDireccio = new AjaxViascalles();
    $objDireccio->AjaxMostrarVia_editarpredio();
}

if (isset($_POST['idubicaviaeditr'])) {
    $objDireccio = new AjaxViascalles();
    $objDireccio->AjaxMostrarVia_editarpredior();
}

if (isset($_POST['idArancelVia'])) {
    $objDireccio = new AjaxViascalles();
    $objDireccio->AjaxMostrarVia_editarArancel();
}

if (isset($_POST['idaranceViaEdi'])) {
    $objDireccio = new AjaxViascalles();
    $objDireccio->AjaxEditarArancel_via();
}
