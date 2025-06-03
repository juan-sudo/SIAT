<?php
require_once "../vendor/autoload.php";

use Controladores\ControladorLicenciaAgua;
use Controladores\ControladorConsultaAgua;
use Controladores\ControladorEstadoCuenta;
use Modelos\ModeloLicenciAgua;

class AjaxLicenciaAgua
{
  public $datos;
  public function ajaxAgregarLicenciaAgua()
  {
    $datos = array(
      'Numero_Licencia' => $_POST["numLicenciaAd"],
      'codigo_sa' => $_POST["codigo_sa"],
      'Tipo_Licencia' => $_POST["licAguaDesague"],
      'Permanencia' => $_POST["tipoLicenciaAd"],
      'Extension_Suministro' => $_POST["extSuministriAd"],
      'PVC_Diametro' => $_POST["tuberiaAd"],
      'Numero_Expediente' => $_POST["numExpedienteLic"],
      'Fecha_Expediente' => $_POST["fechaExpediente"],
      'Fecha_Expedicion' => $_POST["fechaExpedLic"],
      'Estado' => 1,
      'DNI_Licencia' => $_POST["numDniLicencia"],
      'Id_Contribuyente' => $_POST["propietarioLic"],
      'Nombres_Licencia' => $_POST["nombresLicenia"],
      'Id_Categoria_Agua' => $_POST["categoriaLicAd"],
      'Observacion' => $_POST["obsLicAd"],
      'Inspeccion' => $_POST["pruebaCheckbox"],
      'Rotura_vereda' => $_POST["roturaCheckbox"],
      'Numero_Proveido' => $_POST["numProvedio"],
      'idproveidor' => $_POST["idproveidor"],
      'Numero_Recibo' => $_POST["numReciboCaja"],
      'id_via' => $_POST["idvia"],
      'nroUbicacion' => $_POST["nroUbicacion"],
      'nroLote' => $_POST["nroLote"],
      'nroLuz' => $_POST["nroLuz"],
      'ref' => $_POST["ref"],
      'Descuento_sindicato' => $_POST["descuentoSindicato"],
      'Numero_Resolucion_Sindicato' => $_POST["resoSinLicAd"],
      'Descuento_pago_servicio' => $_POST["descuendoServicio"],
      'Numero_Pago_Servicio' => $_POST["resoPagoLicAd"]


    );
    $respuesta = ControladorLicenciaAgua::ctrCrearLicencia($datos);
    echo $respuesta;
  }

    // EDITAR PROGRESO
      public function ajaxGuardar_editar_progreso_agua()
      {

     
           // if (preg_match('/^[azAZ09ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["e_apellPaterno"])) {
              $tabla = "contribuyente";
              $datos = array(
                "Id_contribuyente" => $_POST["codigo_carpeta_agua"],
                "Estado_progreso" => $_POST["estado_progreso"],
                
              );

              $respuesta = ControladorConsultaAgua::ctrEditarCarpetaProgresoAgua($tabla, $datos);

              $respuesta_json = json_encode($respuesta);
              header('Content-Type: application/json');
              echo $respuesta_json;
             
           // }
          
      }
  public function ajaxMostrarLicenciaAgua()
  {
  
      $datos = array(
        'id_contribuyente_agua' => $_POST['id_contribuyente_agua']
      );
            $respuesta = ModeloLicenciAgua::mdlMostrarLicencias($datos);
      echo json_encode($respuesta);
   
  }
  //muestra la licencia de agua por predio para el estado de cuenta
  public function ajaxMostrarLicenciaAgua_deuda()
  {   $idcatastro=$_POST['idCatastroAgua_deuda'];
      $respuesta = ControladorConsultaAgua::ctrMostrar_licencia_agua($idcatastro);
      echo $respuesta;
   
  }
  //muestra el estado de cuenta de agua por licencia
  public function ajaxMostrarLicenciaAgua_estado_cuenta()
  {   $idlicenciaagua=$_POST['idlicenciaagua_estadocuenta'];
      $respuesta = ControladorEstadoCuenta::ctrMostrar_licencia_estadocuenta($idlicenciaagua);
      echo $respuesta;
   
  }
  //muestra el estado de cuenta pagados de agua por licencia
  public function ajaxMostrarLicenciaAgua_estado_cuenta_pagados()
  {   $idlicenciaagua=$_POST['idlicenciaagua_estadocuenta_pagados'];
      $respuesta = ControladorEstadoCuenta::ctrMostrar_licencia_estadocuenta_pagados($idlicenciaagua);
      echo $respuesta;
   
  }

  public function ajaxNumeroLicencia()
  {
    if ($_POST["datanl"]) {
      $anio_actual = date("Y");
      $tabla = 'licencia_agua';
      $item = 'Fecha_Registro';
      $respuesta = ModeloLicenciAgua::mdlLastRegistro($tabla, $anio_actual);
      echo json_encode($respuesta);
    } else {
      echo 'vacio';
    }
  }

  public function ajaxpreEditarLicenciaAgua()
  {
    $datos = array(
      'Numero_Expediente' => $_POST["numExpedienteLicEdit"],
      'Fecha_Expediente' => $_POST["fechaExpediente"],
      'Permanencia' => $_POST["tipoLicenciaAd"],
      'Id_Categoria_Agua' => $_POST["categoriaLicAd"],
      'Observacion' => $_POST["obsLicAd"],
      'Fecha_Expedicion' => $_POST["fechaExpedLic"],
      'Inspeccion' => $_POST["pruebaCheckbox"],
      'Rotura_vereda' => $_POST["roturaCheckbox"],
      'Extension_Suministro' => $_POST["extSuministriAd"],
      'PVC_Diametro' => $_POST["tuberiaAd"],
      //'Numero_Licencia' => $_POST["numLicenciaAd"],
      //'Tipo_Licencia' => $_POST["licAguaDesague"],
      //'Estado' => 1,    // Actibo
      //'DNI_Licencia' => $_POST["numDniLicencia"],
      //'Id_Contribuyente' => $_POST["propietarioLic"],
      //'Nombres_Licencia' => $_POST["nombresLicenia"],
      //'Codigo_Catastral' => $_POST["codigoCatastral"],
      //'Numero_Recibo' => $_POST["numReciboCaja"]
    );
    $respuesta = ControladorLicenciaAgua::ctrCrearLicencia($datos);
    echo $respuesta;
  }
  public function ajaxTraerLiciencia()
  {
  
    $datos = array(
      'id_licencia' => $_POST["idLicencia"]
    );
    $respuesta = ModeloLicenciAgua::mdlMostrarLicencias_calcular($datos);
    echo json_encode($respuesta);
  }

  public function ajaxEditarLicencia()
  {

    $datos = array(
     
      'Numero_Expediente' => $_POST["numExpedienteLicEdit"],
      'Fecha_Expediente' => $_POST["fechaExpedienteEdit"],
      'Fecha_Expedicion' => $_POST["fechaExpedLicEdit"],
      'Permanencia' => $_POST["tipoLicenciaAdEdit"],
      'PVC_Diametro' => $_POST["tuberiaAdEdit"],
      'Id_Categoria_Agua' => $_POST["categoriaLicAdEdit"],
      'Inspeccion' => $_POST["pruebaCheckboxEdit"],
      'Rotura_vereda' => $_POST["roturaCheckboxEdit"],
      'Observacion' => $_POST["obsLicAdEdit"],
      'Id_Licencia_Agua' => $_POST["idLicenciEdit"],
      'idvia' => $_POST["idvia"],
      'numeracion' => $_POST["edit_nroUbicacion"],
      'lote' => $_POST["edit_nroLote"],
      'luz' => $_POST["edit_nroLuz"],
      'referencia' => $_POST["edit_ref"],

      // 'Descuento_sindicato'=> $_POST["descuentoSindicatoEdit"],
      // 'Descuento_pago_servicio'=> $_POST["descuendoServicioEdit"],

      // Asegurarse de que las claves existan antes de acceder a ellas
      'Descuento_sindicato' => isset($_POST["descuentoSindicatoEdit"]) ? $_POST["descuentoSindicatoEdit"] : 0.00,
      'Descuento_pago_servicio' => isset($_POST["descuendoServicioEdit"]) ? $_POST["descuendoServicioEdit"] : 0.00,
  
      
      'Numero_Resolucion_Sindicato'=> $_POST["resoSinLicAdEdit"],
      'Numero_Pago_Servicio'=> $_POST["resoPagoLicAdEdit"],
      

    );
    
 

    $respuesta = ControladorLicenciaAgua::ctrUpdateLicence($datos);
    echo $respuesta;
  }
  public function ajaxTransfLicencia()
  {
    $datos = array(
      'idcontribuyente_nuevo' => $_POST["idcontribuyente_nuevo"],
      'idlicencia' => $_POST["idlicencia"],
      'obs' => $_POST["obs"],
    );
    $respuesta = ControladorLicenciaAgua::ctrUpdateLicencet($datos);
    echo $respuesta;
  }
  public function ajaxEliminarLicencia()
  {
    $datos = array(
      'Estado' => 0,
      'Id_Licencia_Agua' => $_POST["idLicenceAgua"]
    );
    $arrayresp = ControladorLicenciaAgua::ctrDeleleLicence($datos);
    echo json_encode($arrayresp);
  }
  public function ajaxConsultarRecibo()
  {
    if ($_POST["datainput"]) {
      $tabla = 'ingresos_especies_valoradas';
      $item = 'Numero_Caja';
      $valor = $_POST["datainput"];
      $respuesta = ModeloLicenciAgua::mdlConsultaGenerica($tabla, $item, $valor);
      echo json_encode($respuesta);
    } else {
      echo 'vacio';
    }
  }

  public function ajaxAnio_estado_cuenta()   
  {   $dia=$_POST['dia_agua'];
      $mes=$_POST['mes_agua'];
      $anio=$_POST['anio_agua'];
      $respuesta = ModeloLicenciAgua::mdlAnio_Agua($anio,$mes,$dia);
      echo '<select class="busqueda_filtros"  id="selectnum_copiar" name="selectnum_copiar">';
			foreach ($respuesta as $row) {
				echo '<option value="' . $row['Id_Anio'] . '">' . $row['NomAnio'] . '</option>';
			}
			echo '</select>';
     
  }


  public function ajaxCalcular_Agua()
  {
    $datos = array(
      'dni' => $_POST["dni"],
      'nombres' => $_POST["nombres"],
      'monto' => $_POST["monto"],
      
      'descuento' => $_POST["descuento"],

      'monto' => $_POST["monto"],
      'categoria' => $_POST["categoria"],
      'fecha_expedicion' => $_POST["fecha_expedicion"],
      'anio' => $_POST["anio"],
      'id_contribuyente' => $_POST["id_contribuyente"],
      'id_licencia' => $_POST["id_licencia"],
      'recalcular' => $_POST["recalcular"]

    );
    $respuesta = ControladorLicenciaAgua::ctrCalcular_Agua($datos);
    $respuesta_json = json_encode($respuesta);
       header('Content-Type: application/json');
       echo $respuesta_json;  
  }

   public function ajaxEditarContribuyenteProgreso()
   {
          
       $idContribuyente=$_POST['idContribuyente'];
      
     $respuesta = ControladorLicenciaAgua::ctrBarraProgresoAgua($idContribuyente);

      echo json_encode($respuesta);
   }

}
if (isset($_POST['datainput'])) {
  $nuevo = new AjaxLicenciaAgua();
  $nuevo->ajaxConsultarRecibo();
}
if (isset($_POST['registrarLicenciaAgua'])) {
  $nuevo = new AjaxLicenciaAgua();
  $nuevo->ajaxAgregarLicenciaAgua();
}
if (isset($_POST['id_contribuyente_agua'])) {
  $nuevo = new AjaxLicenciaAgua();
  $nuevo->ajaxMostrarLicenciaAgua();
}
if (isset($_POST['datanl'])) {
  $nuevo = new AjaxLicenciaAgua();
  $nuevo->ajaxNumeroLicencia();
}
if (isset($_POST['editarLicAgua'])) {
  $nuevo = new AjaxLicenciaAgua();
  $nuevo->ajaxTraerLiciencia();
}
if (isset($_POST['transferirLicencia'])) {
  $nuevo = new AjaxLicenciaAgua();
  $nuevo->ajaxTraerLiciencia();
}

//edita licencia de agua oij
if (isset($_POST['idLicenciEdit'])) {
  $nuevo = new AjaxLicenciaAgua();
  $nuevo->ajaxEditarLicencia();
}



if (isset($_POST['transferir_licencia'])) {
  $nuevo = new AjaxLicenciaAgua();
  $nuevo->ajaxTransfLicencia();
}
if (isset($_POST["delete_liecence"])) {
  $pisoEdit = new AjaxLicenciaAgua();
  $pisoEdit->ajaxEliminarLicencia();
}
if (isset($_POST["ListaAnioCondicion"])) {
  $pisoEdit = new AjaxLicenciaAgua();
  $pisoEdit->ajaxAnio_estado_cuenta();
}
if (isset($_POST["calcular_agua"])) {
  $pisoEdit = new AjaxLicenciaAgua();
  $pisoEdit->ajaxCalcular_Agua();
}
if (isset($_POST["idCatastroAgua_deuda"])) {
  $pisoEdit = new AjaxLicenciaAgua();
  $pisoEdit->ajaxMostrarLicenciaAgua_deuda();
}
if (isset($_POST["idlicenciaagua_estadocuenta"])) {
  $pisoEdit = new AjaxLicenciaAgua();
  $pisoEdit->ajaxMostrarLicenciaAgua_estado_cuenta();
}
if (isset($_POST["idlicenciaagua_estadocuenta_pagados"])) {
  $pisoEdit = new AjaxLicenciaAgua();
  $pisoEdit->ajaxMostrarLicenciaAgua_estado_cuenta_pagados();
}


//barra de progreso de agua
if (isset($_POST['barraProgreso'])) {
   $editar = new AjaxLicenciaAgua();
   //$editar->idCarpeta = $_POST['idCarpeta'];
   $editar->ajaxEditarContribuyenteProgreso();
}

// guardar editar contribuyente
if (isset($_POST['guardar_estado_progreso_agua'])) {
   $editar = new AjaxLicenciaAgua();
   $editar->ajaxGuardar_editar_progreso_agua();
}

