<?php

namespace Controladores;

use Modelos\ModeloUsuarios;
use Modelos\ModeloEspecievalorada;
use Modelos\ModeloGiroComercial;
use Controladores\ControladorEmpresa;
use Modelos\ModeloEmpresa;

class ControladorGiroComercial
{

    // REGISTRO DE GIRO COMERCIAL -------------------------------
    public static function ctrCrearGiroComercial($datos)
    {
        $tabla = 'giro_comercial';
        $nombre = $datos['nombre_giro'];
        $checknombre=ModeloGiroComercial::ejecutar_consulta_simple("SELECT Nombre FROM $tabla  WHERE Nombre='$nombre'");
        if($checknombre->rowCount()>0){
            echo "<script>
            Swal.fire({
                position: 'top-end',
                title: '<p style=color:red;>ya se encuentra registrado<p>',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'OK'
                })</script>";
            exit();  
        }

        $respuesta = ModeloGiroComercial::mdlNuevoGiroComercial($tabla, $datos);
        if ($respuesta == 'ok') {
            echo "<script>
                    Swal.fire({
                        position: 'top-end',
                        title: '¡Se registro exitosamente!',
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                            window.location = 'girocomercial';
                            }
                            if(window.history.replaceState){
                            window.history.replaceState(null,null, window.location.href);
                            }
                })</script>";
        }
    }
    // MOSTRAR GIRO COMERCIAL --------------------------------------
    public static function ctrMostrarGiroComercial($item, $valor)
    {
        $tabla = 'giro_establecimiento';
        $respuesta = ModeloGiroComercial::mdlMostrarGiroComercial($tabla, $item, $valor);
        return $respuesta;
    }

    // SIN USAR VER QUE HACE ????
    public static function ctrMostrarData($tabla)
    {
        $respuesta = ModeloEspecievalorada::mdlMostrarData($tabla);
        return $respuesta;
    }

    // EDITAR GIRO COMERCIAL|---------------------------------
    public static function ctrEditarGiroComercial()
    {

        if (isset($_POST["editar_nombreGiro"])) {

            if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editar_nombreGiro"])) {

                $tabla = "Id_Giro_Establecimiento";
                $datos = array(
                    'ide' => $_POST["ide"],
                    'nombreGiro' => $_POST["editar_nombreGiro"],
                );

                $respuesta = ModeloGiroComercial::mdlEditarGiroComercial($tabla, $datos);

                if ($respuesta == "ok") {

                    echo "<script>
                            Swal.fire({
                                position: 'top-end',
                                title: '¡Se actualizo correctamente!',
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                window.location = 'girocomercial';
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
                        window.location = 'girocomercial';
                        }
                    })</script>";
                }
            }
        }
    }

    // BORRAR GIRO COMERCIAL------------------------
    public static function ctrBorrarGiroComercial()
    {
        if (isset($_GET['idGiro'])) {
            $tabla = 'giro_establecimiento';
            $datos = $_GET['idGiro'];
            $respuesta = ModeloGiroComercial::mdlBorrarGiroComercial($tabla, $datos);
            if ($respuesta == 'ok') {

                echo "<script>
                        Swal.fire({
                        position: 'top-end',
                        title: '¡EL giro Comercial ha sido eliminado!',
                        text: '....exito',
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Cerrar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                        window.location = 'girocomercial';
                        }
                    })
                    </script>";
            }
        }
    }
}
