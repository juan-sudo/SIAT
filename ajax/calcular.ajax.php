<?php
session_start();
require_once "../vendor/autoload.php";

use Controladores\ControladorCalcular;

class AjaxCalcular
{


    // EDITAR CONTRIBUYENTE
    public function ajaxRegistro_Impuesto()
    {   if($_POST['base_imponible']=='null'){
                    $respuesta = array(
                    'tipo' => 'correcto',
                    'mensaje' => '<div class="alert alert-danger" role="alert">El contribuyente no registra Predios en el año '.$_POST['selectnum'].'</div>'
                    );
        $respuesta_json = json_encode($respuesta);
        header('Content-Type: application/json');
        echo $respuesta_json;                
         }
         else{
          $datos=array("contribuyente"=>$_POST['idContribuyente_impuesto'],
                     "anio"=>$_POST["selectnum"],
                     "impuesto_anual"=>$_POST["impuesto_anual"],
                     "base_imponible"=>$_POST["base_imponible"],
                     "impuesto_trimestral"=>$_POST["impuesto_trimestral"],
                     "gasto_emision"=>$_POST["gasto_emision"],
                     "total_pagar"=>$_POST["total_pagar"],
                     "recalcular"=>$_POST["recalcular"],
                     "predio_select"=>$_POST["predio_select"],
                     "predios_seleccionados"=>$_POST["predios_seleccionados"],

                     //AGREGADOS

                    "id_Regimen_Afecto"=>$_POST["id_Regimen_Afecto"],
                    "predios_totales"=>$_POST["predios_totales"]

                    );
        $respuesta = ControladorCalcular::ctrRegistro_Impuesto($datos);
        $respuesta_json = json_encode($respuesta);
        header('Content-Type: application/json');
        echo $respuesta_json;    
         }
        
    }
    // EDITAR CONTRIBUYENTE
    // public function ajaxRegistro_Impuesto()
    // {  
        
      

    //       $datos=array("contribuyente"=>$_POST['idContribuyente_impuesto'],
    //                  "anio"=>$_POST["selectnum"],
    //                  "impuesto_anual"=>$_POST["impuesto_anual"],
    //                  "base_imponible"=>$_POST["base_imponible"],
    //                  "impuesto_trimestral"=>$_POST["impuesto_trimestral"],
    //                  "gasto_emision"=>$_POST["gasto_emision"],
    //                  "total_pagar"=>$_POST["total_pagar"],
    //                  "recalcular"=>$_POST["recalcular"],
    //                  "predio_select"=>$_POST["predio_select"],
    //                  "predios_seleccionados"=>$_POST["predios_seleccionados"],
    //                 "id_Regimen_Afecto"=>$_POST["id_Regimen_Afecto"],
    //                 "tipo_predio"=>$_POST["tipo_predio"]
                     

    //                 );
    //     $respuesta = ControladorCalcular::ctrRegistro_Impuesto($datos);
    //     $respuesta_json = json_encode($respuesta);
    //     header('Content-Type: application/json');
    //     echo $respuesta_json;    
    //      //}

         
        
    // }
    // MOSTRAR CALCULO IMPUESTO 
    public function ajaxMostrar_calculo_impuesto()
    {  
        $datos=array("contribuyente"=>$_POST['idContribuyente_impuesto'],
                     "anio"=>$_POST["selectnum"],
                     "predios_seleccionados"=>$_POST["predios_seleccionados"],
                     "predios_s"=>$_POST["predios_s"]
                    );

      
       $respuesta = ControladorCalcular::ctrMostrar_calculo_impuesto($datos);
        $respuesta_json = json_encode($respuesta);
        header('Content-Type: application/json');
        echo $respuesta_json;
    }
    // MOSTRAR CUOTAS VFNCIMIENTO ARBITRIOS 
    public function ajaxMostrar_cuotas_vencimiento()
    {
       $datos=array("contribuyente"=>$_POST['idContribuyente_impuesto'],
                     "anio"=>$_POST["selectnum"],
                     "id_predio"=>$_POST["id_predio"]
                    );
       $respuesta = ControladorCalcular::ctrMostrar_cuotas_la($datos);
        echo $respuesta;
    }
   
}
// OBJETO AGREGAR CONTRIBUYENTE
if (isset($_POST['registrar_impuesto'])) {
    $registro = new AjaxCalcular();
    $registro->ajaxRegistro_Impuesto();
}

// MOSTRAR VALOR A GUARDAR DEL CALCULO
if (isset($_POST['mostrar_valor_calculado'])) {
    $mostrar_calculo = new AjaxCalcular();
    $mostrar_calculo->ajaxMostrar_calculo_impuesto();
}
// MOSTRAR VALOR A GUARDAR DEL CALCULO
if (isset($_POST['cuotas_vencimiento_la'])) {
    $mostrar_cuotas_vencimiento = new AjaxCalcular();
    $mostrar_cuotas_vencimiento->ajaxMostrar_cuotas_vencimiento();
}
