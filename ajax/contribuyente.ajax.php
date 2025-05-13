<?php
session_start();
require_once "../vendor/autoload.php";

use Controladores\ControladorContribuyente;

class AjaxContribuyente
{
   //AGREGAR CONTRIBUYENTE
   public function ajaxAgregarContribuyente()
   {
      $datos = array(
         'Documento' => $_POST["docIdentidad"], //
         'Nombres' => $_POST["razon_social"], //
         'Apellido_Paterno' => $_POST["apellPaterno"], //
         'Apellido_Materno' => $_POST["apellMaterno"], //
         'Id_Ubica_Vias_Urbano' => $_POST["idvia"], //
         'Numero_Ubicacion' => $_POST["nroUbicacion"], //
         'Bloque' => $_POST["nrobloque"], //
         'Numero_Departamento' => $_POST["nroDepartamento"], //
         'Referencia' => $_POST["referencia"], //
         'Telefono' => $_POST["telefono"], //
         'Correo' => $_POST["correo"], //
         'Id_Condicion_Contribuyente' => $_POST["condicionContri"], //
         'Observaciones' => $_POST["observacion"], //
         'Codigo_sa' => $_POST["codigo_sa"], //
         'Id_Tipo_Contribuyente' => $_POST["tipoContribuyente"], //
         'Id_Condicion_Predio_Fiscal' => $_POST["condicionpredio"], //
         'Id_Clasificacion_Contribuyente' => $_POST["clasificacion"], //
         'Estado' => '1',
         'Coactivo' => '0',
         'Numero_Luz' => $_POST["nroLuz"], //
         // 'fecharegistro' => $_POST["docIdentidad"],
         // 'fechamodifica' => $_POST["docIdentidad"],
         'Lote' => $_POST["nroLote"], // 
         'Id_Tipo_Documento' => $_POST["tipoDoc"], //esta
         'usuario_Id_Usuario' => $_SESSION['id'] 
      );
      $respuesta = ControladorContribuyente::ctrCrearContribuyente($datos);
      echo $respuesta;
   }
   // EDITAR CONTRIBUYENTE
   public $idContribuyente;

   public function ajaxEditarContribuyente()
   {
      $item = 'Id_Contribuyente';
      $valor = $this->idContribuyente;
      $respuesta = ControladorContribuyente::ctrMostrarContribuyente($item, $valor);
      echo json_encode($respuesta);
   }
   // EDITAR CONTRIBUYENTE
   public function ajaxContribuyente_impuesto()
   {
      $datos = $_POST['idContribuyente_impuesto'];
      $respuesta = ControladorContribuyente::ctrContribuyente_impuesto($datos);
      echo $respuesta;
   }
   // Predio Propietario
   public function ajaxPredio_Propietario()
   {
      $idContribuyente = $_POST['idContribuyente_pc'];
      $parametro_b = $_POST['parametro_b'];
      $init_envio = $_POST['init_envio']; 
      $area_usuario = $_POST['area_usuario']; 
      $coactivo = $_POST['coactivo']; 
      $anio = $_POST['anio'];
      $respuesta = ControladorContribuyente::ctrPredio_Propietario($idContribuyente,$parametro_b,$init_envio,$anio,$area_usuario,$coactivo );
      echo $respuesta;
   }

   
    // Predio Propietario
    public function ajaxGuardar_editar_contribuyente()
    {
      if (isset($_POST["e_tipoDoc"]) && isset($_POST["idrc"])) {
         // if (preg_match('/^[azAZ09ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["e_apellPaterno"])) {
            $tabla = "contribuyente";
            $datos = array(
              "Id_Contribuyente" => $_POST["idc"],
              "Id_Tipo_Documento" => $_POST["e_tipoDoc"],
              "Documento" => $_POST["e_docIdentidad"],
              "Id_Tipo_Contribuyente" => $_POST["e_tipoContribuyente"],
              "Codigo_sa" => $_POST["e_codigo_sa"],
              "Nombres" => strtoupper($_POST["e_razon_social"]),
              "Apellido_Paterno" => strtoupper($_POST["e_apellPaterno"]),
              "Apellido_Materno" => strtoupper($_POST["e_apellMaterno"]),
              "Id_Ubica_Vias_Urbano" => $_POST["idvia"],
              "Numero_Ubicacion" => $_POST["e_nroUbicacion"],
              "Bloque" => $_POST["e_nrobloque"],
              "Numero_Departamento" => $_POST["e_nroDepartamento"],
              "Referencia" => strtoupper($_POST["e_referencia"]),
              "Telefono" => $_POST["e_telefono"],
              "Correo" => $_POST["e_correo"],
              "Observaciones" => strtoupper($_POST["e_observacion"]),
              "Id_Condicion_Predio_Fiscal" => $_POST["e_condicionpredio"],
              "Id_Clasificacion_Contribuyente" => $_POST["e_clasificacion"],
              "Estado" => "1",
              "Coactivo" => $_POST["usuariocoactivo"],
              "Fallecida" => $_POST["usuariofallecida"],
              "Numero_Luz" => $_POST["e_nroLuz"],
              "Fecha_Modificacion" => date("Y-m-d H:i:s"),
              "Lote" => $_POST["e_nroLote"],
              "usuario_Id_Usuario" => $_SESSION['id']
            );
            $respuesta = ControladorContribuyente::ctrEditarContribuyente($tabla, $datos);
            $respuesta_json = json_encode($respuesta);
            header('Content-Type: application/json');
            echo $respuesta_json;
           
         // }
        }
    }
}
// OBJETO AGREGAR CONTRIBUYENTE
if (isset($_POST['registrarContri'])) {
   $nuevo = new AjaxContribuyente();
   $nuevo->ajaxAgregarContribuyente();
}
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

// OBJETO EDITAR DATOS CONTRIBUYENTE
if (isset($_POST['idContribuyente'])) {
   $editar = new AjaxContribuyente();
   $editar->idContribuyente = $_POST['idContribuyente'];
   $editar->ajaxEditarContribuyente();
}

// OBJETO CALCULAR IMPUESTO
if (isset($_POST['idContribuyente_impuesto'])) {
   $editar = new AjaxContribuyente();
   $editar->ajaxContribuyente_impuesto();
}

// Predio Propietario
if (isset($_POST['predio_propietario'])) {
   $editar = new AjaxContribuyente();
   $editar->ajaxPredio_Propietario();
}
// guardar editar contribuyente
if (isset($_POST['guardar_editar_contribuyente'])) {
   $editar = new AjaxContribuyente();
   $editar->ajaxGuardar_editar_contribuyente();
}
