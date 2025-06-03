<?php
namespace Controladores;
use Modelos\ModeloEstadoCuenta;
use Conect\Conexion;

class ControladorEstadoCuenta
{

      
    //PARA OBTENER IDS DE UN ID
    public  static function ctrEstadoCuenta_ids_de_id($datos)
	{
          // Capturando el valor de "anio" para verificar que llega correctamente

        //   echo "<pre>";
        //   echo "📦 Datos recibidos en controlador:\n";
        //   print_r($datos);
        //   echo "</pre>";
      
        
            $respuesta = ModeloEstadoCuenta::mdlEstadoCuenta_ids_de_id($datos);

          // $respuesta = ModeloEstadoCuenta::mdlEstadoCuenta_Orden_anio($siguiente);

            // echo "<pre>"; // Mejor legibilidad al imprimir datos complejos
            // print_r($respuesta); // Imprime la respuesta de manera estructurada
            // echo "</pre>";

        
           
           


	
		return  $respuesta;
	}


    //PARA BOTON SIGUIENTE
    public  static function ctrEstadoCuenta_siguiente($datos)
	{
          // Capturando el valor de "anio" para verificar que llega correctamente
        
            $respuesta = ModeloEstadoCuenta::mdlEstadoCuenta_siguiente_carpeta($datos);

          // $respuesta = ModeloEstadoCuenta::mdlEstadoCuenta_Orden_anio($siguiente);

            // echo "<pre>"; // Mejor legibilidad al imprimir datos complejos
            // print_r($respuesta); // Imprime la respuesta de manera estructurada
            // echo "</pre>";

        
           
            //    echo "<pre>"; // Mejor legibilidad al imprimir datos complejos
            //    print_r($respuesta); // Imprime la respuesta de manera estructurada
            //    echo "</pre>";
        


	
		return  $respuesta;
	}


      //PARA BOTON ANTERIOR
      public  static function ctrEstadoCuenta_anterior($datos)
      {
            // Capturando el valor de "anio" para verificar que llega correctamente
          
              $respuesta = ModeloEstadoCuenta::mdlEstadoCuenta_anterior_carpeta($datos);
  
            // $respuesta = ModeloEstadoCuenta::mdlEstadoCuenta_Orden_anio($siguiente);
  
              // echo "<pre>"; // Mejor legibilidad al imprimir datos complejos
              // print_r($respuesta); // Imprime la respuesta de manera estructurada
              // echo "</pre>";
  
          
             
              //    echo "<pre>"; // Mejor legibilidad al imprimir datos complejos
              //    print_r($respuesta); // Imprime la respuesta de manera estructurada
              //    echo "</pre>";
          
  
  
      
          return  $respuesta;
      }
  


	public  static function ctrEstadoCuenta($valor,$condicion)
	{
		$respuesta = ModeloEstadoCuenta::mdlEstadoCuenta($valor,$condicion);
		echo $respuesta;
	}


    // public  static function ctrEstadoCuentaC($valor,$condicion)
    // {
    //     $respuesta = ModeloEstadoCuenta::mdlEstadoCuentaC($valor,$condicion);
    //     echo $respuesta;
    // }


	// public  static function ctrEstadoCuentaCA($valor,$condicion)
    // {
    //     $respuesta = ModeloEstadoCuenta::mdlEstadoCuentaCA($valor,$condicion);
    //     echo $respuesta;
    // }


    // public static function obtenerEstadoCuenta()
    // {
    //     // Verificar el método de solicitud
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         // Obtener el filtro enviado desde AJAX
    //         $filtro = isset($_POST['filtro']) ? $_POST['filtro'] : '';

    //         // Validar el filtro
    //         if ($filtro === 'trimestre') {
    //             $estado_cuenta = ModeloEstadoCuenta::mdlEstadoCuentaCA('valor', 'estadocuentaC');
    //         } elseif ($filtro === 'anios') {
    //             $estado_cuenta = ModeloEstadoCuenta::mdlEstadoCuenta_Orden_anio('valor', 'estadocuentaC');
    //         } else {
    //             echo "<tr><td>No hay datos disponibles</td></tr>";
    //             return;
    //         }

    //         // Imprimir el resultado
    //         echo $estado_cuenta;
    //     } else {
    //         echo "<tr><td>Método no permitido</td></tr>";
    //     }
    // }




    public  static function ctrEstadoCuenta_Orden($datos)
	{
		$respuesta = ModeloEstadoCuenta::mdlEstadoCuenta_Orden($datos);
		return  $respuesta;
	}


    
    public  static function ctrEstadoCuenta_orden_historial($datos)
	{
		$respuesta = ModeloEstadoCuenta::mdlEstadoCuenta_Orden_historial($datos);
		return  $respuesta;
	}



    

  

    //estado de cuenta para coactico por año
    public  static function ctrEstadoCuenta_Orden_anio($datos)
	{
          // Capturando el valor de "anio" para verificar que llega correctamente
          $anio = $datos['anio'];

        if($anio ==='trimestre'){
            

            $respuesta = ModeloEstadoCuenta::mdlEstadoCuenta_Orden_periodo($datos);

            //     echo "<pre>"; // Mejor legibilidad al imprimir datos complejos
            //    print_r($respuesta); // Imprime la respuesta de manera estructurada
            //    echo "</pre>";


        }  
        if($anio ==='anio'){

            $respuesta = ModeloEstadoCuenta::mdlEstadoCuenta_Orden_anio($datos);

            // echo "<pre>"; // Mejor legibilidad al imprimir datos complejos
            // print_r($respuesta); // Imprime la respuesta de manera estructurada
            // echo "</pre>";

        
            // Usamos print_r para imprimir el arreglo de forma legible en el backend
               // echo "<pre>"; // Mejor legibilidad al imprimir datos complejos
               // print_r($respuesta); // Imprime la respuesta de manera estructurada
               // echo "</pre>";
        }


	
		return  $respuesta;
	}





	
	public  static function ctrEstadoCuenta_Pagado($valor,$condicion)
	{
		$respuesta = ModeloEstadoCuenta::mdlEstadoCuenta_Pagado($valor,$condicion);
		echo $respuesta;
	}
	public  static function ctrMostrar_licencia_estadocuenta($idlicenciaagua)
	{
		$respuesta = ModeloEstadoCuenta::mdlEstadoCuenta_agua($idlicenciaagua);
            if(count($respuesta)>0){
                foreach ($respuesta as $fila) {
                            echo '<tr id='.$fila['Id_Estado_Cuenta_Agua'].'>
                            <td class="text-center" style="width:30px;">'.$fila['Tipo_Tributo'].'</td>
                            <td class="text-center" style="width:50px;">Agua</td>
                            <td class="text-center" style="width:50px;">'.$fila['Anio'].'</td>
							<td class="text-center" style="width:50px;">'.$fila['Periodo'].'</td>
							<td class="text-center" style="width:50px;">'.$fila['Importe'].'</td>
							<td class="text-center" style="width:50px;">'.$fila['Gasto_Emision'].'</td>
							<td class="text-center" style="width:50px;">'.$fila['Total'].'</td>
							<td class="text-center" style="width:50px;">'.$fila['Descuento'].'</td>
							<td class="text-center" style="width:50px;">'.$fila['Total_Aplicar'].'</td>
							<td class="text-center" style="width:20px;"></td>
                            </tr>';
                         }
                       }
                   else{
                         echo '<tr><td class="text-center" colspan="10">No registra Deuda de Agua</td></tr>';		  
                        }
	       
	}
	public  static function ctrMostrar_licencia_estadocuenta_pagados($idlicenciaagua)
	{
		$respuesta = ModeloEstadoCuenta::mdlEstadoCuenta_agua_pagados($idlicenciaagua);
            if(count($respuesta)>0){
                foreach ($respuesta as $fila) {
                            echo '<tr id='.$fila['Id_Estado_Cuenta_Agua'].'>
                            <td class="text-center" style="width:30px;">'.$fila['Tipo_Tributo'].'</td>
                            <td class="text-center" style="width:50px;">Agua</td>
                            <td class="text-center" style="width:50px;">'.$fila['Anio'].'</td>
							<td class="text-center" style="width:50px;">'.$fila['Periodo'].'</td>
							<td class="text-center" style="width:100px;">'.$fila['Fecha_Pago'].'</td>
							<td class="text-center" style="width:50px;">'.$fila['Importe'].'</td>
							<td class="text-center" style="width:50px;">'.$fila['Gasto_Emision'].'</td>
							<td class="text-center" style="width:50px;">'.$fila['Total'].'</td>
							<td class="text-center" style="width:50px;">'.$fila['Descuento'].'</td>
							<td class="text-center" style="width:50px;">'.$fila['Total_Pagar'].'</td>
							<td class="text-center" style="width:20px;"></td>
                            </tr>';
                         }
                       }
                   else{
                         echo '<tr><td class="text-center" colspan="11">No registra Pagos de Agua</td></tr>';		  
                        }
	       
	}
	public  static function ctrDeudasPrescritas($valor)
	{
		$respuesta = ModeloEstadoCuenta::mdlDeudasPrescritas($valor);
		echo $respuesta;
	}

    public static function ctrEliminarEstadoCuenta($valor)
        {
            // Llamar al modelo para eliminar
            $respuesta = ModeloEstadoCuenta::mdlEliminarEstadoCuenta($valor);
            return $respuesta;  // Retorna 'ok', 'no_exist' o null/error
        }

            public static function ctrPagadoEstadoCuenta($valor)
        {
            // Llamar al modelo para eliminar
            $respuesta = ModeloEstadoCuenta::mdlPagadoEstadoCuenta($valor);
            return $respuesta;  // Retorna 'ok', 'no_exist' o null/error
        }






    

	

}
