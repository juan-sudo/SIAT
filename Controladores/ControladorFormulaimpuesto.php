<?php

namespace Controladores;
use Modelos\ModeloFormulaimpuesto;
use Modelos\ModeloEspecievalorada;
use Controladores\ControladorEmpresa;
use Modelos\ModeloEmpresa;

class ControladorFormulaimpuesto
{
    // REGISTRO DE USUARIO
    public static function ctrCrearFormulaimpuesto($datos)
    {
        $tabla = 'formula_impuesto';
        $anio=$datos['anio'];
        $codigo=$datos['codigo'];
        $uit=$datos['uit'];
        $porcentaje=$datos['porcentaje'];

        $checknombre=ModeloFormulaimpuesto::ejecutar_consulta_simple("SELECT anio FROM $tabla  WHERE Anio='$anio' and Codigo_Calculo='$codigo'");
        if($checknombre->rowcount()>0){
        echo "<script>
                Swal.fire({
                    position: 'top-end',
                    title: '<p style=color:red;>ya se encuentra registrado ese rango<p>',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'OK'
                    })</script>";
         exit();    
         } 
         $respuesta = ModeloFormulaimpuesto::mdlNuevoFormulaimpuesto($tabla, $datos);
         
            if($respuesta=='ok'){   
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
                            window.location = 'formulaimpuesto';
                        }
                        if(window.history.replaceState){
                            window.history.replaceState(null,null, window.location.href);
                            }
                        })</script>";
                  }
    }
    // MOSTRAR USUARIOS|
    public static function ctrMostrarFormulaimpuesto($item, $valor)
    {
        $tabla = 'formula_impuesto';
        $respuesta = ModeloFormulaimpuesto::mdlMostrarFormulaimpuesto($tabla, $item, $valor);
        return $respuesta;
    }
    public static function ctrMostrarData($tabla)
    {
        $respuesta = ModeloEspecievalorada::mdlMostrarData($tabla);
        return $respuesta;
    }

    // EDITAR USUARIOS|
    public static function ctrEditarFormulaimpuesto()
    {
        if (isset($_POST["editar_uit"])) {

            if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editar_base"])) {

                $tabla = "formula_impuesto";
                $datos = array(
                    'id' => $_POST["idf"],
                    'anio' => $_POST["editar_anio"],
                    'uit' => $_POST["editar_uit"],
                    'codigo' => $_POST["editar_codigo"],
                    'baseimponible' => $_POST["editar_baseimponible"],
                    'base' => $_POST["editar_base"],
                    'formulabase' => $_POST["editar_formulabase"],
                    'porcentaje' => $_POST["editar_porcentaje"],
                    'autovaluo' => $_POST["editar_autovaluo"]
                );
                $respuesta = ModeloFormulaimpuesto::mdlEditarFormulaimpuesto($tabla, $datos);

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
                                  window.location = 'formulaimpuesto';
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
                        window.location = 'formulaimpuesto';
                        }
                    })</script>";
                }
            }
        }
    }

    // BORRAR USUARIO
    public static function ctrBorrarFormulaimpuesto()
    {
        if (isset($_GET['idUsuario'])) {
            $tabla = 'formula_impuesto';
            $datos = $_GET['idUsuario'];
            $respuesta = ModeloFormulaimpuesto::mdlBorrarFormulaimpuesto($tabla, $datos);
            if ($respuesta == 'ok') {

                echo "<script>
                        Swal.fire({
                             position: 'top-end',
                        title: '¡La formula impuesto ha sido eliminado!',
                        text: '...',
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Cerrar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                        window.location = 'formulaimpuesto';
                        }
                    })
                    </script>";
            }
        }
    }
  
}