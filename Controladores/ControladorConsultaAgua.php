<?php
namespace Controladores;
use Modelos\ModeloLicenciAgua;
use Conect\Conexion;

class ControladorConsultaAgua
{
	 // MOSTRAR EL IMPUESTO A PAGAR
	 public static function ctrMostrar_licencia_agua($idcatastro)
	 {
	        $respuesta = ModeloLicenciAgua::mdlMostrarLicencias_deuda($idcatastro);
            if(count($respuesta)>0){
                foreach ($respuesta as $fila) {
                            echo '<tr>
                            <td class="text-center">'.$fila['Numero_Licencia'].'</td>
                            <td class="text-center">'.$fila['Fecha_Expedicion'].'</td>
                            <td class="text-center">'.$fila['Monto'].'</td>
                            <td class="text-center"><button class="btn btn-warning btnEstadoCuentaAgua" idLicenciaAgua="' . $fila["Id_Licencia_Agua"] . '" ><i class="fas fa-file"></i></button></td>                   
                            </tr>';
                         }
                       }
                   else{
                         echo '<tr><td class="text-center" colspan="6">No registra Licencia de Agua</td></tr>';		  
                        }
	        return $respuesta;
	 }
	
}
