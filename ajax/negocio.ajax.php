<?php
session_start();
require_once "../vendor/autoload.php";

use Controladores\ControladorNegocio;

class AjaxNegocio
{

    
      public function ajaxListar_negocio()
    {  
       
        $datos=array(

            "Id_Predio"=>$_POST['id_predio'],
           
                
                    );

  
       $respuesta = ControladorNegocio::ctrListar_negocio($datos);

     //  return $respuesta;
      // var_dump($respuesta);
        header('Content-Type: application/json');
         echo json_encode($respuesta); // Devuelve la respuesta como JSON

    }
 
    //VER NEGOCIO

    

    //  registrar neogicio
    public function ajaxRegistrar_negocio()
    {  
        $datos=array(

            "Id_Predio"=>$_POST['id_predio'],
            "Id_Giro_Establecimiento"=>$_POST['id_giro_establecimiento'],
            "Razon_Social"=>$_POST['razon_social'],
            "N_Licencia"=>$_POST['nro_licencia'],
            "N_Ruc"=>$_POST['nro_ruc'],

            "Tenencia_Negocio"=>$_POST['tenencia_negocio'],
            "Personeria"=>$_POST['personeria'],
            "Tipo_personeria"=>$_POST['t_personeria'],
            "N_Trabajadores"=>$_POST['nro_trabajadores'],
                
                 
            "N_Mesas"=>$_POST['nro_mesas'],
            "Area_negocio"=>$_POST['area_negocio'],
            "N_Cuartos"=>$_POST['nro_cuartos'],
            "N_Camas"=>$_POST['nro_camas'],
            
            "N_Bano"=>$_POST['nro_bano'],
            "T_Agua_Negocio"=>$_POST['t_agua'],
            "T_Itse"=>$_POST['t_Itse'],
             "Vencimiento_Itse"=>$_POST['vencimiento_Itse']
                
                    );

  
       $respuesta = ControladorNegocio::ctrRegistar_negocio($datos);

       return  $respuesta ;
 
    }
   


    //  registrar neogicio
    public function ajaxVer_negocio()
    {  
        $datos=array(

            "Id_Negocio"=>$_POST['id_negocio'],
           
                
                    );
  
       $respuesta = ControladorNegocio::ctrVer_negocio($datos);

       return  $respuesta ;
 
    }
      //  registrar neogicio
    public function ajaxEditar_negocio()
    {  
        $datos=array(

            "Id_Negocio"=>$_POST['id_negocio'],
           
                
                    );
  
       $respuesta = ControladorNegocio::ctrEditar_negocio($datos);

       return  $respuesta ;
 
    }

    
 
   
}

// REGISTRAR GECOSIO
if (isset($_POST['registrar_negocio'])) {
    $mostrar_cuotas_vencimiento = new AjaxNegocio();
    $mostrar_cuotas_vencimiento->ajaxRegistrar_negocio();
}

//LISTAR NEGOCIO
if (isset($_POST['listar_negocio'])) {
    $mostrar_cuotas_vencimiento = new AjaxNegocio();
    $mostrar_cuotas_vencimiento->ajaxListar_negocio();
}


//VER NEGOCIO
if (isset($_POST['ver_negocio'])) {
    $mostrar_cuotas_vencimiento = new AjaxNegocio();
    $mostrar_cuotas_vencimiento->ajaxVer_negocio();
}

//EDITAT NEGOCIO



if (isset($_POST['editar_negocio'])) {
    $mostrar_cuotas_vencimiento = new AjaxNegocio();
    $mostrar_cuotas_vencimiento->ajaxEditar_negocio();
}