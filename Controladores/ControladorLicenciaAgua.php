<?php

namespace Controladores;

use Modelos\ModeloLicenciAgua;
use Conect\Conexion;
class ControladorLicenciaAgua
{
  public static function ctrCrearLicencia($datos)
  {
    $tabla = 'licencia_agua';
    $respuesta = ModeloLicenciAgua::mdlNuevaLicencia($tabla, $datos);
    if ($respuesta == 'ok') {
      echo "<script>
        Swal.fire({
            position: 'top-end',
            title: '¡Licencia registrado exitosamente!',
            icon: 'success',
            showConfirmButton: false, 
            timer: 1000
        })
      </script>";
    }elseif($respuesta == 'bad'){
    echo "<script>
        Swal.fire({
            position: 'top-end',
            title: '¡El Recibo esta asignado a otra licencia!',
            icon: 'warning',
            showConfirmButton: false, 
            timer: 3000
        })
      </script>";
    }
  }
  public static function ctrTraerLastLicence()
  {
    $tabla = 'licencia_agua';
    $item = 'Fecha_Registro';
    $respuesta = ModeloLicenciAgua::mdlLastRegistro($tabla, $item);
    return $respuesta;
  }

  public static function ctrCalcular_Agua($datos)
  {

  

    $pdo = Conexion::conectar();
    $stmt = $pdo->prepare("SELECT Id_Estado_Cuenta_Agua  from estado_cuenta_agua  where Anio=:anio and Id_Licencia_Agua=:id_licencia");
    $stmt->bindParam(":anio", $datos['anio']);
    $stmt->bindParam(":id_licencia", $datos['id_licencia']);
    $stmt->execute();
		     if($datos['recalcular']=='no'){
			     if($stmt->rowCount()>0){
            $respuesta = array(
              "tipo" => "advertencia",
              "mensaje" => '<div class="col-sm-30">
              <div class="alert alert-warning">
                <button type="button" class="close font__size-18" data-dismiss="alert">
                </button>
                <i class="start-icon fa fa-exclamation-triangle faa-flash animated"></i>
                <strong class="font__weight-semibold">Alerta!</strong> Ya se encuentra Calculado el Estado de Cuenta del año '.$datos['anio'].'.
              </div>
              </div>'
            );
			     }
			     else{   	
             $respuesta = ModeloLicenciAgua::mdlCalcular_Agua($datos);
			        if($respuesta=="ok"){
                $respuesta = array(
                  "tipo" => "correcto",
                  "mensaje" => '<div class="col-sm-30">
                  <div class="alert alert-success">
                    <button type="button" class="close font__size-18" data-dismiss="alert">
                    </button>
                    <i class="start-icon far fa-check-circle faa-tada animated"></i>
                    <strong class="font__weight-semibold">Alerta!</strong> Se Calculo de forma correcta el estado de cuenta de Agua del año '.$datos['anio'].'.
                  </div>
                  </div>'
                );
			        }
					else{
            $respuesta = array(
              'tipo' => 'error',
              'mensaje' =>'<div class="col-sm-30">
              <div class="alert alert-warning">
                <button type="button" class="close font__size-18" data-dismiss="alert">
                </button>
                <i class="start-icon fa fa-exclamation-triangle faa-flash animated"></i>
                <strong class="font__weight-semibold">Alerta!</strong> Algo salio mal comunicarce con el Administrador.
              </div>
              </div>'
            );
					}	             
		         }
	       }
	       else{
	       	 $stmt = $pdo->prepare("DELETE FROM estado_cuenta_agua  where Anio=:anio  and Id_Licencia_Agua=:id_licencia");
            $stmt->bindParam(":anio", $datos['anio']);
            $stmt->bindParam(":id_licencia", $datos['id_licencia']);

		        $stmt->execute();
            $respuesta = ModeloLicenciAgua::mdlCalcular_Agua($datos);
			        if($respuesta=="ok"){
                $respuesta = array(
                  "tipo" => "correcto",
                  "mensaje" => '<div class="col-sm-30">
                  <div class="alert alert-success">
                    <button type="button" class="close font__size-18" data-dismiss="alert">
                    </button>
                    <i class="start-icon far fa-check-circle faa-tada animated"></i>
                    <strong class="font__weight-semibold">Alerta!</strong> Se ReCalculo de forma correcta el estado de cuenta de Agua del año '.$datos['anio'].'.
                  </div>
                  </div>'
                );
			        }
					else{
            $respuesta = array(
              'tipo' => 'error',
              'mensaje' =>'<div class="col-sm-30">
              <div class="alert alert-warning">
                <button type="button" class="close font__size-18" data-dismiss="alert">
                </button>
                <i class="start-icon fa fa-exclamation-triangle faa-flash animated"></i>
                <strong class="font__weight-semibold">Alerta!</strong> Algo salio mal en el Recalculo comunicarce con el Administrador.
              </div>
              </div>'
            );
					}	 
	       }
	       return $respuesta;


   
  }
  public static function ctrUpdateLicence($datos)
  {
  //var_dump($datos);

    $tabla = 'licencia_agua';
    $respuesta = ModeloLicenciAgua::mdlEditarLiciencia($tabla, $datos);
    if ($respuesta == 'ok') {
      echo "<script>
        Swal.fire({
            position: 'top-end',
            title: 'Licencia Modificada exitosamente!',
            icon: 'success',
            showConfirmButton: false, 
            timer: 1500
        })
      </script>";
    }
  }
  public static function ctrUpdateLicencet($datos)
  {
    $tabla = 'licencia_agua';
    $respuesta = ModeloLicenciAgua::mdlTranferirLiciencia($tabla, $datos);
    if ($respuesta == 'ok') {
      return "OK";
    }
  }
  public static function ctrDeleleLicence($datos)
  {
    $tabla = 'licencia_agua';
    $respuesta = ModeloLicenciAgua::mdlDeleteLicence($tabla, $datos);
    if ($respuesta == 'ok') {
      $respuesta = array(
        "tipo" => "correcto",
        "mensaje" => "<div class='alert alert-success' role='alert'>Licencia Elimada con Exito</div>"
      );
      return $respuesta;
    } else {
      $respuesta = array(
        'tipo' => 'advertencia',
        'mensaje' => '<div class="alert alert-danger" role="alert">Algo Salio Mal Comunica con el adminstrador</div>'
      );
      return $respuesta;
    }
  }
}
