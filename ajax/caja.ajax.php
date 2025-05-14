<?php
session_start();
require_once "../vendor/autoload.php";

use Controladores\ControladorEstadoCuenta;
use Controladores\ControladorCaja;

class AjaxCaja
{


    
    //MOSTRAR ANTERIOR

    public function ajaxMostrar_anterior()
    {


        $anterior = isset($_POST['anterior']) ? $_POST['anterior'] : null;
        //$anio_trimestre = isset($_POST['anio_trimestre']) ? $_POST['anio_trimestre'] : null;

        if (!$anterior ) {
            echo json_encode(array("error" => "Datos insuficientes"));
            return;
        }
        $datos = array(
            //"id_propietarios" => $_POST['id_propietarios'],
            //"tipo_tributo" => '006',
            "anterior" => $anterior,
            //"anio_trimestre" => $anio_trimestre
        );

        $respuesta = ControladorEstadoCuenta::ctrEstadoCuenta_anterior($datos);

        // $datos = array(
        //     "id_propietarios" => $_POST['id_propietarios'],
        //     // "tipo_tributo" => $_POST['tipo_tributo'],
        //     "tipo_tributo" => '006',
        //     "anio" => $_POST['anio'],
        //     "anio_trimestre" => $_POST['anio_trimestre']
        // );
        // $respuesta = ControladorEstadoCuenta::ctrEstadoCuenta_Orden_anio($datos);
      
        // if ($respuesta === null) {
        //     echo "<pre>No hay respuesta desde el modelo (es null)</pre>";
        // } else {
        //     echo "<pre>";
        //     print_r($respuesta);
        //     echo "</pre>";
        // }
        $respuesta_json = json_encode($respuesta);

  

        header('Content-Type: application/json');

        
        echo $respuesta_json;
    }

   

     //MOSTRAR IDS A TRAVEZ DE VARIOS IDS
     public function ajaxMostrar_ids_de_id()
     {
        
 

         // Paso 1: Verifica si el valor existe
         $idseleccionadoJson = isset($_POST['id_selecionado']) ? $_POST['id_selecionado'] : null;

        
     
         if (!$idseleccionadoJson) {
             echo json_encode(array("error" => "Datos insuficientes"));
             return;
         }
     
         // Paso 2: Decodifica el JSON
         $idseleccionadoArray = json_decode($idseleccionadoJson, true);
     
         // Paso 3: Verifica si la decodificación fue correcta y convierte a enteros
         if (!is_array($idseleccionadoArray)) {
             echo json_encode(array("error" => "Formato inválido de IDs"));
             return;
         }
     

         // Paso 4: Convierte todos los valores a enteros
         $idsConvertidos = array_map('intval', $idseleccionadoArray);

            //   echo "<pre>";
            //  print_r($idsConvertidos);
            //  echo "</pre>";
         
     
         // Paso 5: Pasa al controlador
         $datos = array(
             "idseleccionado" => $idsConvertidos
         );

          // Paso 4: Puedes devolver el array para verificar que llega correctamente
   // echo json_encode(["resultado de ida" => $datos]);
     
         $respuesta = ControladorEstadoCuenta::ctrEstadoCuenta_ids_de_id($datos);

        //  echo "<pre>"; // Mejor legibilidad al imprimir datos complejos
        //  echo "📦 Datos caja de ajax:\n";
        //  print_r($respuesta); // Imprime la respuesta de manera estructurada
        //  echo "</pre>";
  
     
         header('Content-Type: application/json');
         echo json_encode($respuesta);

     }
     


     //MOSTRAR SIGUIENTE
     public function ajaxMostrar_siguiente()
     {
 
 
         $siguiente = isset($_POST['siguiente']) ? $_POST['siguiente'] : null;
         //$anio_trimestre = isset($_POST['anio_trimestre']) ? $_POST['anio_trimestre'] : null;
 
         if (!$siguiente ) {
             echo json_encode(array("error" => "Datos insuficientes"));
             return;
         }
         $datos = array(
             //"id_propietarios" => $_POST['id_propietarios'],
             //"tipo_tributo" => '006',
             "siguiente" => $siguiente,
             //"anio_trimestre" => $anio_trimestre
         );
 
         $respuesta = ControladorEstadoCuenta::ctrEstadoCuenta_siguiente($datos);
 
         // $datos = array(
         //     "id_propietarios" => $_POST['id_propietarios'],
         //     // "tipo_tributo" => $_POST['tipo_tributo'],
         //     "tipo_tributo" => '006',
         //     "anio" => $_POST['anio'],
         //     "anio_trimestre" => $_POST['anio_trimestre']
         // );
         // $respuesta = ControladorEstadoCuenta::ctrEstadoCuenta_Orden_anio($datos);
       
         // if ($respuesta === null) {
         //     echo "<pre>No hay respuesta desde el modelo (es null)</pre>";
         // } else {
         //     echo "<pre>";
         //     print_r($respuesta);
         //     echo "</pre>";
         // }
         $respuesta_json = json_encode($respuesta);
 
   
 
         header('Content-Type: application/json');
 
         
         echo $respuesta_json;
     }
 
 
 
     //esatdod e cuenta por año
 
     public function ajaxMostrar_estadocuenta_orden_anio()
     {
 
 
         $anio = isset($_POST['anio']) ? $_POST['anio'] : null;
         $anio_trimestre = isset($_POST['anio_trimestre']) ? $_POST['anio_trimestre'] : null;
 
         if (!$anio || !$anio_trimestre) {
             echo json_encode(array("error" => "Datos insuficientes"));
             return;
         }
         $datos = array(
             "id_propietarios" => $_POST['id_propietarios'],
             "tipo_tributo" => '006',
             "anio" => $anio,
             "anio_trimestre" => $anio_trimestre
         );
 
         $respuesta = ControladorEstadoCuenta::ctrEstadoCuenta_Orden_anio($datos);
 
         // $datos = array(
         //     "id_propietarios" => $_POST['id_propietarios'],
         //     // "tipo_tributo" => $_POST['tipo_tributo'],
         //     "tipo_tributo" => '006',
         //     "anio" => $_POST['anio'],
         //     "anio_trimestre" => $_POST['anio_trimestre']
         // );
         // $respuesta = ControladorEstadoCuenta::ctrEstadoCuenta_Orden_anio($datos);
       
         // echo "<pre>"; // Mejor legibilidad al imprimir datos complejos
         // print_r($respuesta); // Imprime la respuesta de manera estructurada
         // echo "</pre>";
       
       
         $respuesta_json = json_encode($respuesta);
 
   
 
         header('Content-Type: application/json');
 
         
         echo $respuesta_json;
     }
 
 
    // Mostrar estado cuenta en el modulo de caja
    public function ajaxMostrar_estadocuenta_caja()
    {
        $datos = array(
            "id_propietarios" => $_POST['id_propietarios'],
            "tipo_tributo" => $_POST['tipo_tributo']
        );
        $respuesta = ControladorEstadoCuenta::ctrEstadoCuenta($datos, "caja");
        echo $respuesta;
    }



    

    // Mostrar HISTORIAL DE ORDENES
    public function ajaxMostrar_estadocuenta_orden_historial()
    {
        $datos = array(
            "id_propietarios" => $_POST['id_propietarios'],
          //  "tipo_tributo" => $_POST['tipo_tributo']
          //  "anio" => $_POST['anio']
        );
        $respuesta = ControladorEstadoCuenta::ctrEstadoCuenta_orden_historial($datos);
        $respuesta_json = json_encode($respuesta);
        header('Content-Type: application/json');
        echo $respuesta_json;
    }


    // Mostrar estado cuenta en el orden
    public function ajaxMostrar_estadocuenta_orden()
    {
        $datos = array(
            "id_propietarios" => $_POST['id_propietarios'],
            "tipo_tributo" => $_POST['tipo_tributo'],
            "anio" => $_POST['anio']
        );
        $respuesta = ControladorEstadoCuenta::ctrEstadoCuenta_orden($datos);
        $respuesta_json = json_encode($respuesta);
        header('Content-Type: application/json');
        echo $respuesta_json;
    }



    // Mostrar el numero correlativo de recibo
    public function ajaxMostrar_nrecibo()
    {
        $respuesta = ControladorCaja::ctrMostrar_n_recibo();
        $respuesta_json = json_encode($respuesta);
        header('Content-Type: application/json');
        echo $respuesta_json;
    }
    // Mostrar el numero correlativo de recibo
    public function ajaxCobrar_caja()
    {
        $datos = array(
            "id_propietarios" => $_POST['propietarios'],
            "id_cuenta" => $_POST['id_cuenta']
        );
        $respuesta = ControladorCaja::ctrRegistro_ingresos($datos);
        $respuesta_json = json_encode($respuesta);
        header('Content-Type: application/json');
        echo $respuesta_json;
    }
    // Cobrar caja Agua
    public function ajaxCobrar_caja_agua()
    {
        $datos = array(
            "idlicencia" => $_POST['idlicencia'],
            "id_cuenta" => $_POST['id_cuenta']
        );
        $respuesta = ControladorCaja::ctrRegistro_ingresos_agua($datos);
        $respuesta_json = json_encode($respuesta);
        header('Content-Type: application/json');
        echo $respuesta_json;
    }

    
    //registro de ingreso de proveido
    public function ajaxCobrar_caja_proveido()
    {
        $datos = array(
            "id_proveido" => $_POST['id_proveido'],
            "id_usuario" => $_POST['id_usuario']
        );
        $respuesta = ControladorCaja::ctrRegistro_ingresos_proveidos($datos);
        $respuesta_json = json_encode($respuesta);
        header('Content-Type: application/json');
        echo $respuesta_json;
    }
    // tipo_papel
    public function ajaxTipo_papel()
    {
        $respuesta = ControladorCaja::ctrTipo_papel();
        $respuesta_json = json_encode($respuesta);
        header('Content-Type: application/json');
        echo $respuesta_json;
    }
    // tipo_papel
    public function ajaxLista_Proveidos()
    {
        $datos = array("fecha" => $_POST['fecha']);
        $respuesta = ControladorCaja::ctrLista_Proveidos($datos);
        echo $respuesta;
    }
    // extornar
    public function ajaxExtornar()
    {
        $datos = array("numero_caja" => $_POST['numero_caja']);
        $respuesta = ControladorCaja::ctrExtornar($datos);
        $respuesta_json = json_encode($respuesta);
        header('Content-Type: application/json');
        echo $respuesta_json;  
    }
    // reimprimir
    public function ajaxReimprimir()
    {
        $numero_recibo = $_POST['numero_recibo'];
        $tipo = $_POST['tipo'];
        $respuesta = ControladorCaja::ctrReimprimir($numero_recibo,$tipo);
        $respuesta_json = json_encode($respuesta);
        header('Content-Type: application/json');
        echo $respuesta_json;  
    }
}

//CONUSLTA DE IDS DE UN SOLO ID


if (isset($_POST['obtener_ids_de_id'])) {
    $mostrar_estadocuenta_caja = new AjaxCaja();
    $mostrar_estadocuenta_caja->ajaxMostrar_ids_de_id();
}


//SIGUIENTE

if (isset($_POST['estado_siguiente'])) {
    $mostrar_estadocuenta_caja = new AjaxCaja();
    $mostrar_estadocuenta_caja->ajaxMostrar_siguiente();
}

//ANTERIOR
if (isset($_POST['estado_anterior'])) {
    $mostrar_estadocuenta_caja = new AjaxCaja();
    $mostrar_estadocuenta_caja->ajaxMostrar_anterior();
}

// estado cuenta caja - modulo caja
if (isset($_POST['estado_cuenta_caja'])) {
    $mostrar_estadocuenta_caja = new AjaxCaja();
    $mostrar_estadocuenta_caja->ajaxMostrar_estadocuenta_caja();
}


if (isset($_POST['estado_cuenta_orden'])) {
    $mostrar_estadocuenta_caja = new AjaxCaja();
    $mostrar_estadocuenta_caja->ajaxMostrar_estadocuenta_orden();
}


if (isset($_POST['estado_cuenta_orden_anio'])) {
    $mostrar_estadocuenta_caja = new AjaxCaja();
    $mostrar_estadocuenta_caja->ajaxMostrar_estadocuenta_orden_anio();
}


//HISTPORIAL DE ORDENES
if (isset($_POST['estado_cuenta_ordenes'])) {
    $mostrar_estadocuenta_caja = new AjaxCaja();
    $mostrar_estadocuenta_caja->ajaxMostrar_estadocuenta_orden_historial();
}





// numero correlativo -caja
if (isset($_POST['n_recibo'])) {
    $numerorecibo = new AjaxCaja();
    $numerorecibo->ajaxMostrar_nrecibo();
}
// cobrar_caja
if (isset($_POST['cobrar_caja'])) {
    $numerorecibo = new AjaxCaja();
    $numerorecibo->ajaxCobrar_caja();
}
// cobrar_caja_agua
if (isset($_POST['cobrar_caja_agua'])) {
    $numerorecibo = new AjaxCaja();
    $numerorecibo->ajaxCobrar_caja_agua();
}
// cobrar caja proveido
if (isset($_POST['cobrar_proveido'])) {
    $numerorecibo = new AjaxCaja();
    $numerorecibo->ajaxCobrar_caja_proveido();
}
// tipo_papel
if (isset($_POST['tipo_papel'])) {
    $tipo_papel = new AjaxCaja();
    $tipo_papel->ajaxTipo_papel();
}
// tipo_papel
if (isset($_POST['lista_proveidos'])) {
    $tipo_papel = new AjaxCaja();
    $tipo_papel->ajaxLista_Proveidos();
}
// tipo_papel
if (isset($_POST['extornar'])) {
    $tipo_papel = new AjaxCaja();
    $tipo_papel->ajaxExtornar();
}
// reimprimir
if (isset($_POST['reimprimir'])) {
    $reimprimir = new AjaxCaja();
    $reimprimir->ajaxReimprimir();
}
