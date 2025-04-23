<?php

namespace Controladores;

use Modelos\ModeloCampana;

class ControladorCampana
{
    public static function ctrCrearCampana($datos)
    {
        $tabla = 'descuento';
        $respuesta = ModeloCampana::mdlNuevaCampana($tabla, $datos);
        if ($respuesta == 'ok') {
            echo "<script>
               Swal.fire({
                   position: 'top-end',
                   title: '¡Se registro Campaña exitosamente!',
                   icon: 'success',
                   showCancelButton: false,
                   confirmButtonColor: '#3085d6',
                   cancelButtonColor: '#d33',
                   confirmButtonText: 'OK'
                 }).then((result) => {
                   if (result.isConfirmed) {
                   window.location = 'campana';
                   }
                   if(window.history.replaceState){
                       window.history.replaceState(null,null, window.location.href);
                       }
                 })</script>";
        }
    }
    public static function ctrMostrarData($item, $valor)
    {
        $tabla = 'descuento';
        $respuesta = ModeloCampana::mdlMostrarData($tabla, $item, $valor);
        return $respuesta;
    }
    public static function ctrBorrarCampana()
    {
        if (isset($_GET['idUsuario'])) {
            $tabla = 'descuento';
            $datos = $_GET['idUsuario'];
            $respuesta = ModeloCampana::mdlBorrarCampana($tabla, $datos);
            if ($respuesta == 'ok') {
                echo "<script>
                        Swal.fire({
                        position: 'top-end',
                        title: '¡La especie valorada ha sido eliminado!',
                        text: '...',
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Cerrar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                        window.location = 'campana';
                        }
                    })
                    </script>";
            }
        }
    }
    public static function ctrMostrarCampana($item, $valor)
    {
        $tabla = 'descuento';
        $respuesta = ModeloCampana::mdlMostrarCampa($tabla, $item, $valor);
        return $respuesta;
    }
    public static function ctrEditarCampana()
    {
        if (isset($_POST["edit_nombreCampana"])) {         
                $tabla = "descuento";
                $datos = array(
                    'Id_Descuento' => $_POST["idEsp"],
                    'descripcion_descuento' => $_POST["edit_nombreCampana"], 
                    'Id_Anio' => $_POST["edit_anioCampana"],
                    'Id_Uso_Predio' => $_POST["edit_usoPredioCampana"],
                    'Porcentaje' => $_POST["edit_porcentajeDescuentoG"],
                    'Documento' => $_POST["edit_numInstrumentoCampana"],
                    'Fecha_Inicio' => $_POST["edit_fechaIniCampana"],
                    'Fecha_Fin' => $_POST["edit_fechaFinCampana"]
                );
                $respuesta = ModeloCampana::mdlEditarCampana($tabla, $datos);
                if ($respuesta == "ok") {
                    echo "<script>
                            Swal.fire({
                                position: 'top-end',
                                title: 'Campaña se actualizo correctamente!',
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'OK'
                              }).then((result) => {
                                if (result.isConfirmed) {
                                  window.location = 'campana';
                                }
                                if(window.history.replaceState){
                                    window.history.replaceState(null,null, window.location.href);
                                    }
                              })</script>";
                } else {
                    echo "<script>
                    Swal.fire({
                        title: '¡El campo no puede ir vacío o llevar caracteres especiales!',
                        text: '...',
                        icon: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Cerrar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                        window.location = 'campana';
                        }
                    })</script>";
                }
            
        }
    }
    public static function crtActualizarEstadoCampana($tabla, $item1, $valor1, $item2, $valor2)
	{
		$respuesta = ModeloCampana::mdlActualizarEstadoCampana($tabla, $item1, $valor1, $item2, $valor2);
		if ($respuesta == "ok") {
			$respuesta = array(
				'tipo' => 'correcto',
				'mensaje' => '<div class="alert success">
				<input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">
				<span aria-hidden="true" class="letra">×</span>
				</button><p class="inner"><strong class="letra">Exito!</strong> 
				<span class="letra">Se aplico el descuento de maenera exitosa</span></p></div>'
			);
			return $respuesta;
		} else {
			$respuesta = array(
				'tipo' => 'advertencia',
				'mensaje' => '<div class="alert warning">
				<input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">
				<span aria-hidden="true" class="letra">×</span>
				</button><p class="inner"><strong class="letra">Exito!</strong> 
				<span class="letra">Algo salio mal comunicate con el Administrador</span></p></div>'
			);
			return $respuesta;
		}
	}
}
