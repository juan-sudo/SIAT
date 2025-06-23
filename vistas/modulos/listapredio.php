<?php

use Controladores\ControladorPredio;
use Controladores\ControladorContribuyente;
use Controladores\ControladorEstadoCuenta;


?>

<?php
$idParam = $_GET['id'];
$anio_propietario = $_GET['anio'];
// Divide el valor en un array utilizando el guion (-) como delimitador
$idArray = explode('-', $idParam);
// Elimina elementos vacíos (por ejemplo, si hay varios guiones juntos)
$idArray = array_filter($idArray);
// Ahora $idArray contiene los valores sin guiones

$concatenado_id=$idParam;
//PARA CARPETA PROGRESO

//$codigoCarpeta = isset($_GET['id']) ? $_GET['id'] : '';

//$codigoCarpeta = isset($idArray[2]) ? $idArray[2] : '';

?>




<!-- Aquí va el link a tu hoja de estilos, fuera del bloque PHP -->
<link rel="stylesheet" href="vistas/css/form.css">


<div class="content-wrapper panel-medio-principal" >


  <section class="container-fluid panel-medio" >
    <div class="box container-fluid" style="border:0px; margin-bottom:3px; padding:0px;" >
   
   
    <div class="progress" style="width: 100%; height: 10px; border: 0; margin: 0;">
    <?php
        // Capturar datos del contribuyente una sola vez
        $datos_contribuyente = ControladorContribuyente::CntrVerificar_Parametro($idArray);

      
      
       
        // Inicializar el porcentaje
        $porcentaje = 0;
        $color = '#ccc'; // Color por defecto

        // Verificar si los datos del contribuyente están disponibles
        // Verificar si los datos del contribuyente están disponibles
        if (count($datos_contribuyente) > 0) {
          // Solo mostrar una vez la barra de progreso
          foreach ($datos_contribuyente as $contribuyentes) {
              foreach ($contribuyentes as $contribuyente) {
                  // Asignar el valor de Estado_progreso
                  $estado_progreso = $contribuyente['Estado_progreso'];

                  // Asignar el porcentaje y color según el estado
                  if ($estado_progreso === 'P') {
                      $porcentaje = 30;
                      $color = 'rgb(255, 193, 7)';
                  } elseif ($estado_progreso === 'E') {
                      $porcentaje = 60;
                      $color = 'rgb(23, 162, 184)';
                  } elseif ($estado_progreso === 'C') {
                      $porcentaje = 100;
                      $color = 'rgb(40, 167, 69)';
                  } elseif ($estado_progreso === NULL) {
                      $porcentaje = 0;
                      $color = '#ccc';
                  }

                  // Salir del loop después de obtener el primer valor
                  break 2;
              }
          }
        }

    ?>

   <!-- Mostrar la barra de progreso con el porcentaje y color calculado -->
    <div class="progress-bar" role="progressbar" style="width: <?php echo $porcentaje; ?>%; height: 100%; background-color: <?php echo $color; ?>; display: flex; justify-content: center; align-items: center; color: white; font-weight: bold; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);">
        <?php echo $porcentaje . '%'; ?>
    </div>

</div>



<div class="row">

   <div class="col-12  col-lg-7 "  >
        <?php
       // $datos_contribuyente = ControladorContribuyente::CntrVerificar_Parametro($idArray);
            
            // var_dump($datos_contribuyente);
              if (count($datos_contribuyente) > 0) {
              ?>



          <div style="display: flex; justify-content: flex-end; align-items: center; width: 100%; margin-bottom: 0.3rem; margin-top: 0.3rem;">
          
          <button class="bi bi-bar-chart btn btn-secundary btn-sm" id="editar_progreso_Predio">
            Editar progreso
          </button>
          <button class="bi bi-person-fill-add btn btn-success btn-sm" id="agregarContribuyente_Predio">
            Agregar Contribuyente
          </button>
        </div>


           <table class="miTabla_propietarios" style="width: 100%;">
                    <caption>Propietarios j</caption>
                </table>


                <div class="table-responsive">
                <table class="miTabla_propietarios table-sm" style=" margin-bottom: 0.3rem;">
              
                  <thead>
                    <th class="text-center">Codigo</th>
                    <th class="text-center">Documento</th>
                    <th class="text-center">Nombres</th>
                    <th class="text-center">Direccion</th>
                    <th class="text-center">Carpeta</th>
                    <th class="text-center">Accion</th>
                  </thead>
                  <tbody id="id_propietarios">
                    <?php foreach ($datos_contribuyente as $valor => $filas) {
                      
                      
                      foreach ($filas as $fila) {
                    

                        $backgroundColor = $fila['Fallecida'] == 1 ? 'background-color: #333b40; color:rgb(224, 232, 236);' : '';  // Fondo oscuro y texto blanco si está fallecido, vacío si no


                        echo '<tr id="fila" id_contribuyente="' . $fila['Id_Contribuyente'] . '">
                            <td class="text-center"  style="' . $backgroundColor . '" >' . $fila['Id_Contribuyente'] . '</td>
                            <td class="text-center"  style="' . $backgroundColor . '" >' . $fila['Documento'] . '</td>
                            <td class="text-center"  style="' . $backgroundColor . '" >' . $fila['Nombre_Completo'] . '</td>
                            <td class="text-center"  style="' . $backgroundColor . '" >' . $fila['Direccion_completo'] . '</td>
                                                        <td style="display:none" class="text-center"  style="' . $backgroundColor . '" >' . $fila['Telefono'] . '</td>
                            <td class="text-center codigo_carpeta_contribuyente_p" id="carpeta_contribuyente" id_carpeta="' . $fila['Codigo_Carpeta'] . '">' . $fila['Codigo_Carpeta'] . '</td>
                          <td class="text-center"  >
                          <span class="link btnEditarcontribuyente " 
                              title="Editar" 
                              idContribuyente="' . $fila['Id_Contribuyente'] . '" 
                              idDireccionnu="' . $fila['Id_Ubica_Vias_Urbano'] . '" 
                              data-toggle="modal" 
                              data-target="#modalEditarcontribuyente">
                          Editar
                        </span> | 
      
                            <span class=" btnEliminarcontribuyente text-danger" 
                                  title="Eliminar" 
                                  idContribuyente="' . $fila['Id_Contribuyente'] . '" 
                                  idDireccionnu="' . $fila['Id_Ubica_Vias_Urbano'] . '" 
                                  data-toggle="modal" 
                                  data-target="#modalEliminarcontribuyente">
                              Eliminar
                            </span>
                          </td>

                            
                            
                            ';
                    
                          }
                    }
                    ?>
                  <tbody>
                </table>
          </div>
      </div>

      <div class="col-12 col-lg-5 d-flex flex-column justify-content-center align-items-center pt-lg-5" style="display: flex; flex-direction: column; justify-content: center; align-items: center; ">
   
            <div>
                <button class="btn btn-secondary btn-sm btn-1" id="anterior_Predio" style="margin-bottom: 1rem;">
                    <i class="bi bi-chevron-left"></i>
                </button>

                <button class="btn btn-secondary btn-sm btn-1" id="siguiente_Predio" style="margin-bottom: 1rem;">
                    <i class="bi bi-chevron-right"></i>
                </button>
            </div>
      </div>




    </div>

    
   



     
      


    </div>









  </section>
  <section class="container-fluid panel-medio">
    <div class="box rounded">
      <div class="box-body table-user">
        <div class="row">
          <div class="col-md-7 table-responsive">
            <div class="row divDetallePredio">
              <div class="col-mod-12">
                <span class="caption_">Predios del Contribuyente probamdo</span>
                

                <div class="row pull-right">
                  <input type="hidden" id="perfilOculto_p" value="<?php echo $_SESSION['perfil'] ?>">

                  <select class="busqueda_filtros" id="selectnum" name="selectnum">
                    <?php
                    $anio = ControladorPredio::ctrMostrarDataAnio();
                    foreach ($anio as $data_anio) {
                      $selected = ($anio_propietario == $data_anio['NomAnio']) ? 'selected' : '';
                      echo "<option value='" . $data_anio['Id_Anio'] . "' $selected>" . $data_anio['NomAnio'] . '</option>';
                    }
                    ?>
                  </select>
                </div>
              </div>
              
              <br>

              <table class="table-container" id="tablalistapredios">
                <thead>
                  <tr>
                   
                    <th class="text-center" style="width: 3rem;"> </th>
                    <th class="text-center">Tipo</th>
                    <th class="text-center">Ubicacion del Predio</th>
                    <th class="text-center" style="display:none;">Id.Catastro</th>
                    <th class="text-center">A.Terreno n</th>
                    <th class="text-center">A.Const.</th>
                    <th class="text-center">Val.Predio</th>
                    <th class="text-center" style="width: 3rem;"></th>
                  </tr>
                </thead>
                <tbody class='body-predio'>
                  <?php
                  $listaPredio = ControladorPredio::ctrListarPredio($idArray, $anio_propietario);
                  ?>
                </tbody>

                

                
            

              </table>
             


            <div style="margin-top: 4rem ;">
            <span class="caption_" >Predios transferidos</span>
            </div>
              
              <table class="table-container" id="tablalistapredios">
                <thead>
                  <tr>
                    <th class="text-center"  style="background-color: rgb(149, 153, 161)  !important; ">N°</th>
                    <th class="text-center" style="background-color:rgb(149, 153, 161) !important; ">Tipo</th>
                    <th class="text-center" style="background-color: rgb(149, 153, 161)  !important; ">Ubicacion del Predio</th>
                    <th class="text-center" style="display:none;">Id.Catastro</th>
                    <th class="text-center" style="background-color: rgb(149, 153, 161)  !important; ">A.Terreno n</th>
                    <th class="text-center" style="background-color: rgb(149, 153, 161)  !important; ">A.Const.</th>
                    <th class="text-center"style="background-color: rgb(149, 153, 161)  !important; ">Val.Predio</th>
                    <th class="text-center" style="background-color: rgb(149, 153, 161)  !important; ">Detalle</th>
                  </tr>
                </thead>
               
                
                <tbody class='body-predio-historial'>
                  <?php
                  $listaPredio = ControladorPredio::ctrListarPredio_historial($idArray, $anio_propietario);
                  ?>
                </tbody>


              </table>


              <!-- <span class="caption_">Predios transferidos</span>
              <table >
              
                <tbody>

                        
            <?php
           // $listaPredioo = ControladorPredio::ctrListarPredio_historial($idArray, $anio_propietario);
            ?>
            

                  <tr style="background-color:rgb(235, 240, 241);">
                  <td scope="row">1</td>
                    <td scope="row">U</td>
                    <td >JR. MANUEL ESCAJADILLO N°S/N Mz.23 Lt. Cdr.6-URBANIZACION-VISTA ALEGRE</td>
                    <td scope="row">200.000000</td>
                    <td scope="row">0.00</td>
                    <td scope="row">9800.00</td>
                    <td scope="row">carpeta: 1</td>
                  
                    
                  </tr> -->
                
                </tbody>
              </table> 


            </div>
            <label class="bltp" id="countpredio"></label>
            <!--======== CONTADOR PREDIOS ===========-->
           

                  <div class="row">

                 <div class="col-xs-12 col-md-6 icon-container " style="display: flex; justify-content: flex-end; padding-right:0; padding-left:0">
                 
                      <div class="col-xs-2  text-center">
                        <img src="./vistas/img/iconos/transferir.png" id="abrirPopupButton" class="t-icon-tbl-imprimir" data-target="#modalTransferenciaPredio" data-toggle="tooltip" alt="Transferir" title="Transferir de Predio">
                      </div>
                      <div class="col-xs-2  text-center">
                        <img src="./vistas/img/iconos/copiar.svg" id="abrirPopupButton_copiar" class="t-icon-tbl-imprimir" data-target="#modalCopiarPredio" alt="Copiar" title="Copiar Predio">
                      </div>
                      <div class="col-xs-2  text-center">
                        <img src="./vistas/img/iconos/editar.png" id="btnEditarPredioU" class="t-icon-tbl-imprimir" data-target="#modalEditarPredio" alt="Editar" title="Editar Predio">
                      </div>
                      <div class="col-xs-2  text-center">
                        <img src="./vistas/img/iconos/orden_pago.png" id="abrirOrdenPago" class="t-icon-tbl-imprimir" data-target="#modalOrdenPago" alt="Orden Pago" title="Orden Pago">
                      </div>
                      <div class="col-xs-2  text-center">
                        <img src="./vistas/img/iconos/icono_coactivo.png" id="abrirEstadoCoactivo" class="t-icon-tbl-imprimir" data-target="#modalEstadoCuentaC" alt="Coactivo" title="Coactivo">
                      </div>

                 </div> 


                 <div class="col-xs-12 col-md-6 icon-container  " style="display: flex; justify-content: flex-start; padding-right:0; padding-left:0">

                    <div class=" col-xs-2  text-center">
                      <img src="./vistas/img/iconos/deuda.png" id="abrirEstadoCuenta" class="t-icon-tbl-imprimir" data-target="#modalEstadoCuenta" alt="Deuda" title="Estado Cuenta">
                    </div>

                    <div class=" col-xs-2  text-center">
                      <img src="./vistas/img/iconos/pagos_.png" id="abrirPagosImpuestoArbitrios" class="t-icon-tbl-imprimir" data-target="#modalPagosImpuestoArbitrios" alt="Pagos" title="Pagos Impuesto Arbitrios">
                    </div>

                    <div class="col-xs-2  text-center">
                      <img src="./vistas/img/iconos/calcular.png" id="obciones_calcular" class="t-icon-tbl-imprimir" alt="Calcular" title="Calcular Impuesto" data-target="#modal_predio_propietario_">
                    </div>

                    <div class="col-xs-2  text-center">
                      <img src="./vistas/img/iconos/delete.png" id="abrirEliminar_Predio" class="t-icon-tbl-imprimir" data-target="#modalEliminarPredio" alt="Eliminar" title="Eliminar Predio">
                    </div>

                    <div class="col-xs-2  text-center">
                      <img src="./vistas/img/iconos/foto.png" id="abrirFoto" class="t-icon-tbl-imprimir" data-target="#modal_foto" alt="Foto" title="Gestionar Foto">
                    </div>
              </div>




  
              </div>

            


<!-- Si quieres que la décima imagen (foto.png) también aparezca, la puedes colocar en una tercera fila o dentro de la segunda con otra lógica -->




          </div>
          <!--DETALLE PREDIOS - PISOS-->
          <div class="col-md-5 table-responsive">
            <div class="row divDetallePredio">
              <table class="table-container" id="listaDePisosContainer">
                <caption>Lista de Pisos html</caption>
                <thead>
                  <tr>
                    <th class="text-center">Catastro</th>
                    <th class="text-center">N° Piso</th>
                    <th class="text-center">A.Const.</th>
                    <th class="text-center">Val.Const.</th>
                    <th class="text-center">Val.Edifica</th>
                  </tr>
                </thead>
                <tbody id="listaPisos">
                </tbody>
                <!-- Aqui Aparecen los Pisos del Predio-->
              </table>
            </div>

            <div class="row">
                  </br>

              <div class="col-xs-12 col-md-6 icon-container " style="display: flex; justify-content: flex-start; padding-right:0; padding-left:0" >
                 
                 
                    <!-- Boton Casita Registrar Piso-->
                    <div class="col-xs-2  text-center">
                      <img src="./vistas/img/iconos/nuevo_piso.png" class="t-icon-tbl-imprimir" id="btnAbrirRegistrarPiso" data-target="#modalAgregarPiso" title="Nuevo Piso"></img>
                    </div>
                    <!-- Boton Tarjeta Editar-->
                    <div class="col-xs-2  text-center">
                      <img src="./vistas/img/iconos/editar.png" class="t-icon-tbl-imprimir" id="btnAbrirEditarPiso" data-target="#modalEditarPiso" title="Editar Piso"></img>
                    </div>
                    <!-- Boton Eliminar Piso -->
                    <div class="col-xs-2  text-center">
                      <img src="./vistas/img/iconos/delete.png" class="t-icon-tbl-imprimir" id="btnEliminarPiso" title="Eliminar Piso"></img> <!-- data-toggle="modal" -->
                    </div>



                </div>
            </div>

          </div>
        </div>
      </div>
    </div>

</div>




</section>
</div>



<!-- MODAL PARA IMÁGENES -->

<!-- MODAL PARA IMÁGENES -->
<!-- MODAL PARA IMÁGENES -->
<!-- MODAL PARA IMÁGENES -->
<!-- MODAL PARA IMÁGENES -->



<div class="modal fade" id="modalFotosPredio" tabindex="-1" role="dialog" aria-labelledby="modalFotosPredioTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="modalFotosPredioTitle">Historial de predio</h5>
               
            </div>
            <div class="aqui" style="margin-left: 20px; margin-top:10px" >


            </div>

            <div class="modal-body">
                <!-- Mostrar los detalles de las fotos en la línea de tiempo -->
                <div class="show-historial-predio"></div>

                <!-- Mensaje cuando no hay fotos -->
                <div id="mensaje-no-fotos" class="alert alert-info" style="display:none;">
                    No hay fotos disponibles para este predio.
                </div>
            </div>
        </div>
    </div>
</div>





<!--====== MODAL DE TRANSFERIR PREDIO -->
<div class="modal fade " id="modalTransferenciaPredio" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        TRANSFERIR PREDIO j
      </div>
      <div class="modal-body">
        <div class="form-group predio_catastro_transferir">
          <!--CONTENIDO DINAMICO DEL PREDIO A TRANSFERIR -->
        </div>
        <div class="col-md-6 table-responsive">
          <table class="table-container">
            <caption>Propietarios </caption>
            <thead>
              <tr>
                <th class="text-center">Código</th>
                <th class="text-center">Documento</th>
                <th class="text-center">Nombres</th>
              </tr>
            </thead>
            <tbody id="id_propietarios_modal">
              <?php foreach ($datos_contribuyente as $valor => $filas) {
                foreach ($filas as $fila) {
                  echo '<tr id="fila" id_contribuyente="' . $fila['Id_Contribuyente'] . '">
                      <td class="text-center">' . $fila['Id_Contribuyente'] . '</td>
                      <td class="text-center">' . $fila['Documento'] . '</td>
                      <td class="text-center">' . $fila['Nombre_Completo'] . '</td>';
                }
              }
              ?>
            </tbody>
          </table>
        </div>

        <div class="col-md-6 table-responsive">
          <div class="col-md-12">
            <span class="caption_"> Documento de Transferencia</span>
          </div>
          <div class="col-md-6">
            <label for="tipodocInscripcion">Documento Inscripcion</label>
            <select class="form-control" id="tipodocInscripcion" required="" id="tipodocInscripcion" required="">
              <option value="" selected="" disabled="">Seleccione Documento</option>
              <?php
              $tabla = 'documento_inscripcion';
              $registros = ControladorPredio::ctrMostrarData($tabla);
              foreach ($registros as $data_d) {
                echo "<option value='" . $data_d['Id_Documento_Inscripcion'] . "'>" . $data_d['Documento_Inscripcion'] . '</option>';
              }
              ?>
            </select>
          </div>
          <div class="col-md-6">
            <label>N° Documento </label>
            <input type="text" class="form-control" id="n_documento" placeholder="N° documento">
          </div>

          <div class="col-md-6">
            <br>
            <label for="tipoEscritura">Tipo de Documento</label>
            <select class="form-control" name="tipoEscritura" required="" id="tipoEscritura">
              <option value="" selected="" disabled="">Seleccione Tipo Documento</option>
              <?php
              $tabla = 'tipo_escritura';
              $registros = ControladorPredio::ctrMostrarData($tabla);
              foreach ($registros as $data_d) {
                echo "<option value='" . $data_d['Id_Tipo_Escritura'] . "'>" . $data_d['Tipo_Escritura'] . '</option>';
              }
              ?>
            </select>

          </div>

          <div class="col-md-6">
            <br>
            <label for="fechaEscritura">Fecha Documento</label>
            <input type="date" class="form-control-date-normal" name="fechaEscritura" id="fechaEscritura" required="">
          </div>
          </fieldset>
        </div>
      </div>

      <div class="col-md-12">
        <div class="col-md-6 table-responsive">
          <table id="tabla_propietario" class="table-container">
            <caption><b>(Nuevo Propietario)</b></caption>
            <thead>
              <tr>
                <th class="text-center transferir">Código</th>
                <th class="text-center transferir">Documento</th>
                <th class="text-center transferir">Nombres</th>
                <th class="text-center transferir">Acciones</th>
              </tr>
            </thead>
            <tbody id="div_propietario">
              <!-- Aquí se agregarán las filas de datos -->
            </tbody>
          </table>
          <div class="boton-propietario">
            <button type="button" class="btn btn-secundary btn-1" data-toggle="modal" data-target="#modalPropietarios">Nuevo Propietario</button>
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
        <button type="button" class="btn btn-primary btnTransferirPredio">Trasnferir</button>
      </div>
    </div>
  </div>
</div>
<!--====== FIN DEL MODAL TRANSFERIR PREDIO =======-->




<!--====== MODAL EDITAR BARRA DE PROGRESO =======-->
<div class="modal" id="modal_editar_barra_progreso" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog modal-lg" role="document">
    <div class="modal-content">
    <form role="form" id="formCarpetaProgress" method="post" enctype="multipart/form-data">
      
      <div class="modal-header">
        <label class="modal-title">EDITAR BARRA DE PROGRESO</label>
      </div>
      <div class="modal-body">
     
        <!-- Input oculto para almacenar el valor de Codigo_Carpeta -->
        <!-- Input oculto para almacenar el valor de Codigo_Carpeta -->
        <input type="hidden" id="codigo_carpeta" name="codigo_carpeta" value="">



        <!-- Sección de Estado de Progreso -->
        <section class="container-fluid panel-medio col-xs-6" id="propietarios" style="width: 100%;">
            <div class="row">
                <div class="col-12 col-md-2" style="display: flex; align-items: center;">
                    <!-- Label para el select -->
                    <label for="estado_progreso" style="font-weight: bold;">Estado de progreso:</label>
                </div>
                <div class="col-12 col-md-2" style="display: flex; align-items: center;">
                    <!-- Select con las opciones -->
                    <select id="estado_progreso" name="estado_progreso" class="form-control" style="border-radius: 8px; box-shadow: 0px 4px 6px rgba(0,0,0,0.1);">
                        <option value="P">Pendiente</option>
                        <option value="E">En Progreso</option>
                        <option value="C">Completado</option>
                    </select>
                </div>
            </div>
        </section>

        <!-- Sección de Barra de Progreso -->
        <section class="container-fluid panel-medio" id="propietarios" style="width: 100%; margin-top:5rem">
            <div class="row">
                <div class="col-12" style="display: flex; align-items: center; width: 100%;">
                    <!-- Barra de progreso que ocupa el 100% del ancho -->
                    <div class="progress" style="width: 100%; height: 20px; border-radius: 10px ; background-color: #f0f0f0; border:0">
                        <div id="progress-bar" class="progress-bar" role="progressbar" style="width: 0%; background-color: #ffc107; border-radius: 10px;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                            0%
                        </div>
                    </div>
                </div>
            </div>
        </section>


      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="salir_modal_progreso" data-dismiss="modal">Salir</button>
        <button style='float:right;' type="sudmit" class="btn btn-primary ">Guardar cambio</button>
      </div>

      </form>

    </div>
  </div>
</div>

<!--====== FIN DEL MODAL REGISTRAR CONTRIBUYENTE A PREDIO EXISTENTE =======-->

<!--====== MODAL REGISTRAR CONTRIBUYENTE A PREDIO EXISTENTE =======-->
<div class="modal" id="modalAgregarContribuyente_Predio" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <label class="modal-title"> AGREGAR CONTRIBUYENTE i </label>
      </div>
      <div class="modal-body">
        <div class="row divDetallePredio_predio">
          <section class="container-fluid panel-medio col-xs-6" id="propietarios" style='width: 100%;'>
            <div class="box container-fluid">
              <div class="text-bordeada">
                Propietarios 
              </div>
              <table id="tabla_contribuyente_predio" class="table-container">
                <thead>
                  <tr>
                    <th class="text-center">Código</th>
                    <th class="text-center">Documento</th>
                    <th class="text-center">Nombres</th>
                    <th class="text-center">Acciones</th>
                  </tr>
                </thead>
                <tbody id="div_propietario2">
                  <!-- Aquí se agregarán los propietarios en filas -->
                </tbody>
              </table>
              <div class="boton-propietario">
                <button type="button" class="btn btn-secundary btn-1" data-toggle="modal" data-target="#modalPropietarios">Agregar Propietarios</button>
              </div>
            </div>
          </section>
          <section class="container-fluid panel-medio col-xs-6" id="propietarios" style='width: 100%;'>
            <div class="box container-fluid">
              <div class="text-bordeada">
                Predios
              </div>
              <table class="table-container" id="tablalistapredios2">
                <thead>
                  <tr>
                    <th class="text-center">N°</th>
                    <th class="text-center">Tipo</th>
                    <th class="text-center">Ubicacion del Predio</th>
                    <th class="text-center" style="display:none;">Id.Catastro</th>
                    <th class="text-center">A.Terreno</th>
                    <th class="text-center">A.Const.</th>
                    <th class="text-center">Val.Predio</th>
                    <th class="text-center">Foto</th>
                  </tr>
                </thead>
                <tbody class='body-predio' id='predios_contribuyente'>
                  <?php
                  $listaPredio = ControladorPredio::ctrListarPredio($idArray, $anio_propietario);
                  ?>
                </tbody>
              </table>
            </div>


            <!-- <button type="button" class="btn btn-secondary" id="salir_AgregarContribuyente" data-dismiss="modal">Salir</button>
            <button style='float:right;' type="button" class="btn btn-primary btnAgregarContribuyente_predio">Agregar</button>
           -->
          
          </section>
        </div>
      </div>

      <div class="modal-footer">

          <button type="button" class="btn btn-secondary" id="salir_AgregarContribuyente" data-dismiss="modal">Salir</button>
            <button style='float:right;' type="button" class="btn btn-primary btnAgregarContribuyente_predio">Agregar</button>
          
     
      </div>


    </div>
  </div>
</div>
<!--====== FIN DEL MODAL REGISTRAR CONTRIBUYENTE A PREDIO EXISTENTE =======-->

<!--====== MODAL DE COPIAR PREDIO -->
<div class="modal" id="modalCopiarPredio" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="exampleModalLongTitle">COPIAR PREDIO m</h5>
      </div>

            
      <div class="modal-body">
        <div class="predio_catastro ">
          <!--CONTENIDO DINAMICO DEL PREDIO A TRANSFERIR -->
        </div>
        
        
        
       </div>



         <div class="row" style="margin-bottom: 20px;"> 
           <div class="col-12 col-md-5">
                  <label for="anioFiscal_e" class="cajalabel2">Año a copiar</label>
                  <select class="form2" name="anioFiscal_e" id="anioFiscal_e" required="">
                    <option value="" selected="" disabled="">Seleccione Año</option>
                    <?php
                    $anioSiat = 'anio';
                    $registros = ControladorPredio::ctrMostrarData($anioSiat);
                    foreach ($registros as $data_d) {
                        // Asegúrate de añadir el 'NomAnio' en el atributo data-nomanio
                        echo "<option value='" . $data_d['Id_Anio'] . "' data-nomanio='" . $data_d['NomAnio'] . "'>" . $data_d['NomAnio'] . "</option>";
                      }
                    ?>
                  </select>
          </div>
      </div>


      


      

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
        <button type="button" class="btn btn-primary btnCopiarPredio">Copiar</button>
      </div>
    </div>
  </div>
</div>

<!--====== FIN DEL MODAL COPIAR PREDIO URB========-->
<!--====== MODAL EDITAR PREDIO U==================-->
<div class="modal fade" id="modalEditarPredio" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <label class="modal-title"> EDITAR PREDIO I</label>
      </div>
      <div class="modal-body" style="padding-bottom: 0 !important;padding-top: 0 !important;">
        <div class="row ">
          <!-- FORMULARIO -->
          <div class="col-lg-12 col-xs-12">
            <form role="form" method="post" class="formEditarPredio" id="formEditarPredio">
              <!--=============== DOCUMENTOS DE INSCRPCION ===================-->
              <div class="row">

              <input type="text" name="idPredio" id="idPredio">
                <!-- TIPO PREDIO  -->
                <div class="col-12 col-md-5">
                  <label for="tipoPredioUR_e" class="cajalabel2">Tipo Predio</label>
                  <select class="form2" name="tipoPredioUR_e" id="tipoPredioUR_e" required>
                    <option value="" selected="" disabled="">Seleccione</option>
                    <option value="U">Urbano </option>
                    <option value="R">Rural</option>
                  </select>
                </div>
                <!-- AÑO FISCAL   -->
                <div class="col-12 col-md-5">
                  <label for="anioFiscal_e" class="cajalabel2">Año Fiscal</label>
                  <select class="form2" name="anioFiscal_e" id="anioFiscal_e" required="">
                    <option value="" selected="" disabled="">Seleccione Año</option>
                    <?php
                    $anioSiat = 'anio';
                    $registros = ControladorPredio::ctrMostrarData($anioSiat);
                    foreach ($registros as $data_d) {
                      echo "<option value='" . $data_d['Id_Anio'] . "'>" . $data_d['NomAnio'] . '</option>';
                    }
                    ?>
                  </select>
                </div>
              </div>

              <div class="box box-success" style="border-top: 0px;">
                <div class="box-body" style="border: 1px dotted gray; padding-top:5px; ">
                  <!-- ENTRADA DOC INDCRIPCION -->
                  <div class="row2">
                    <legend class="text-bold" style="margin-left:15px; font-size:1.3em; letter-spacing: 1px; margin-bottom: 10px !important;">DOCUMENTO DE INSCRIPCION:</legend>
                    <div class="row">
                      <!-- ENTRADA DOC INSCRIPCION -->
                      <div class="col-sm-6">
                        <label for="tipodocInscripcion_e" class="cajalabel31">Doc. Inscripcion:</label>
                        <select class="form2" name="tipodocInscripcion_e" required="" id="tipodocInscripcion_e" required="">
                          <option value="" selected="" disabled="">Seleccione Documento</option>
                          <?php
                          $tabla = 'documento_inscripcion';
                          $registros = ControladorPredio::ctrMostrarData($tabla);
                          foreach ($registros as $data_d) {
                            echo "<option value='" . $data_d['Id_Documento_Inscripcion'] . "'>" . $data_d['Documento_Inscripcion'] . '</option>';
                          }
                          ?>
                        </select>
                      </div>
                      <!-- ENTRADA NRO DOC -->
                      <div class="col-sm-6">
                        <label for="nroDocIns_e" class="cajalabel31">Nro. Doc.:</label>
                        <input type="text" pattern="[A-Za-z0-9\s:.\-]+" title="Solo se permiten letras" class="form3" name="nroDocIns_e" id="nroDocIns_e" maxlength="10" required>
                      </div>
                    </div>
                    <div class="row">
                      <!-- ENTRADA TIPO DOC -->
                      <div class="col-sm-6">
                        <label for="tipoEscritura_e" class="cajalabel31">Tipo de Doc.:</label>
                        <select class="form2" name="tipoEscritura_e" required="" id="tipoEscritura_e">
                          <option value="" selected="" disabled="">Seleccione</option>
                          <?php
                          $tabla = 'tipo_escritura';
                          $registros = ControladorPredio::ctrMostrarData($tabla);
                          foreach ($registros as $data_d) {
                            echo "<option value='" . $data_d['Id_Tipo_Escritura'] . "'>" . $data_d['Tipo_Escritura'] . '</option>';
                          }
                          ?>
                        </select>
                      </div>
                      <!-- ENTRADA FECHA DOC -->
                      <div class="col-sm-6">
                        <label for="fechaEscritura_e" class="cajalabel31">Fecha Doc.:</label>
                        <input type="date" class="form2" name="fechaEscritura_e" id="fechaEscritura_e" required="">
                      </div>
                    </div>
                  </div>
                  <!-- ENTRADA PROPIETARIOS-->

                  <div class="col-md-6">
                    <span class="caption_">Propietarios</span>
                    <table id="tabla_propietario" class="table-container">
                      <thead>
                        <tr>
                          <th>Código</th>
                          <th>Documento</th>
                          <th>Nombres</th>
                        </tr>
                      </thead>
                      <tbody id="div_propietario_e">
                        <?php foreach ($datos_contribuyente as $valor => $filas) {
                          foreach ($filas as $fila) {
                            echo '<tr id="fila" id_contribuyente="' . $fila['Id_Contribuyente'] . '">
                                    <td class="text-center">' . $fila['Id_Contribuyente'] . '</td>
                                    <td class="text-center">' . $fila['Documento'] . '</td>
                                    <td class="text-center">' . $fila['Nombre_Completo'] . '</td>';
                          }
                        }
                        ?>
                      </tbody>
                    </table>
                  </div>

                  
                   <div class="col-md-6">
                     <span class="caption_">Direccion de predio</span>
                      <div class="row2">
                        <div class="flex">
                          <button type="button" class="bi bi-geo-alt-fill btn btn-secundary btn-1" data-toggle="modal" data-target="#modalViacalle_Predio">Ubicacion del Predio u</button>
                        </div>
                       
                      </div>
                  </div>


                </div>
                <!--====== ENTRADA UBIGEO PREDIO URBANO =======-->
                <div id="divUbigeoPreu">
                  <div class="box">
                    <div class="box-body">
                   
                      <!-- Tabla-->
                      <div class="row2">
                        <div class="">
                          <div class="">
                            <table class="table-container">
                              <thead>
                                <tr>
                                  <th>Nombre Via</th>
                                  <th>Manzana</th>
                                  <th>Cuadra</th>
                                  <th>Lado</th>
                                  <th>Zona</th>
                                  <th>Habilitacion</th>
                                  <th>Arancel</th>
                                  <th>Id Via</th>
                                  <th>Condición</th>
                                </tr>
                              </thead>
                              <tbody id="itemsRP">
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- otros Campos-->
                    <div class="box-body" style="border: 1px dotted gray; border-top: 0px ; padding-top:5px; ">
                      <div class="col-12 col-md-3"> <!-- LADO 1 PARAMETROS DEL PREDIO-->
                        <!-- ENTRADA NRO UBICACION-->
                        <div class="row">
                          <label for="nroUbicacion_e" class=""># Ubic</label>
                          <input type="text" pattern="[0-9]+" title="Solo se permiten números" class="form3" name="nroUbicacion_e" id="nroUbicacion_e" maxlength="5" required="">
                        </div>
                        <!-- ENTRADA NRO LOTE-->
                        <div class="row">
                          <label for="nroLote_e" class="">#Lote</label>
                          <input type="text" pattern="[0-9]+" title="Solo se permiten números" class="form3" name="nroLote_e" id="nroLote_e" maxlength="5" required="">
                        </div>
                      </div>
                      <div class="col-12 col-md-3"> <!-- LADO 1 PARAMETROS DEL PREDIO-->
                        <!-- ENTRADA NRO LUZ-->
                        <div class="row">
                          <label for="reciboLuz_e" class="">#Rec.Luz</label>
                          <input type="text" pattern="[0-9]+" title="Solo se permiten números" class="form3" name="reciboLuz_e" id="reciboLuz_e" required="" maxlength="5">
                        </div>
                        <!-- ENTRADA RECIBO AGUA-->
                        <div class="row">
                          <label for="codCofopri_e" class="">Cod.Cof</label>
                          <input type="text" pattern="[0-9]+" title="Solo se permiten números" class="form3" name="codCofopri_e" id="codCofopri_e" required="" maxlength="10">
                        </div>
                      </div>
                      <div class="col-12 col-md-3"> <!-- LADO 1 PARAMETROS DEL PREDIO-->
                        <!-- ENTRADA NRO BLOQUE-->
                        <div class="row">
                          <label for="nroBloque_e" class="">#Bloque</label>
                          <input type="text" pattern="[0-9]+" title="Solo se permiten números" class="form3" name="nroBloque_e" id="nroBloque_e" maxlength="5">
                        </div>
                        <!-- ENTRADA NRO DEPARTAMENTO-->
                        <div class="row">
                          <label for="nroDepa_e" class="">#Depart.</label>
                          <input type="text" pattern="[0-9]+" title="Solo se permiten números" class="form3" name="nroDepa_e" id="nroDepa_e" maxlength="5">
                        </div>
                      </div>
                      <div class="col-12 col-md-3"> <!-- LADO 1 PARAMETROS DEL PREDIO-->
                        <!-- ENTRADA REFERENCIA-->
                        <div class="row">
                          <label for="referenUbi_e" class="cajalabe2">Referencia</label>
                          <input type="text" pattern="[A-Za-z0-9\s:.\-]+" title="Solo se permiten letras" class="form1" name="referenUbi_e" id="referenUbi_e" maxlength="70">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>


                <!--====== DESCRIPCION ENTRADA PREDIO URBANO ==-->
                <div id="divDescripPreu">
                  <div class="box box-success" style="border-top: 0px;">
                    <div class="box-body" style="border: 1px dotted gray; padding-top:0px; ">
                      <div class="row">
                        <div class="col-12 col-md-4"> <!-- LADO 1 PARAMETROS DEL PREDIO URBANO-->
                          <legend class="text-bold" style="margin-left:15px;  letter-spacing: 1px;">Parametro predio</legend>
                          <!-- ENTRADA AREA TERRENO-->
                          <div class="row">
                            <label for="areaTerreno_e" class="cajalabel2">Area (m2)</label>
                            <input type="text" title="Solo se permiten números" class="form3" name="areaTerreno_e" id="areaTerreno_e" maxlength="10" required="">
                          </div>
                          <!-- VALOR ARANCEL-->
                          <div class="row">
                            <label for="" class="cajalabel2">Val Arancel</label>
                            <label id="valorArancel_e">-</label>
                          </div>
                          <!-- VALOR TERRENO-->
                          <div class="row">
                            <label class="cajalabel2">Val Terreno</label>
                            <label id="valorTerreno_e">-</label>
                          </div>
                          <!-- VALOR CONSTRUCCION-->
                          <div class="row">
                            <label class="cajalabel2">Val Const.</label>
                            <label id="valorConstruc_e">-</label>
                          </div>
                          <!-- VALOR OTRAS INSTALACIONES-->
                          <div class="row">
                            <label for="valorOtrasIns_e" class="cajalabel2">Val. Inst.</label>
                            <label id="valorOtrasIns_e">-</label>
                          </div>
                          <!-- AREA CONSTRUCCION-->
                          <div class="row">
                            <label for="areaConstruc_e" class="cajalabel2">Area Const.(m2)</label>
                            <label id="areaConstruc_e">-</label>
                          </div>
                          <!-- VALOR PREDIO POR AÑO-->
                          <div class="row">
                            <label for="valorPredioAnio_e" class="cajalabel2">Valor Total</label>
                            <label id="valorPredioAnio_e">-</label>
                          </div>
                        </div>

                        <div class="col-12 col-md-8"><!-- LADO 2 DESCRIPCION DEL PREDIO-->
                          <legend class="text-bold" style="margin-left:15px; font-size:1.3em; letter-spacing: 1px;">Descripcion predio</legend>
                         
                         
                          <div class="col-12 col-md-6">
                            <!-- TIPO PREDIO   -->
                            <div class="row">
                              <label for="tipoPredio_e" class="cajalabet"> Tipo </label>
                              <select class="form2" name="tipoPredio_e" id="tipoPredio_e">
                                <option value="" selected="" disabled="">Seleccione</option>
                                <?php
                                $tabla = 'tipo_predio';
                                $registros = ControladorPredio::ctrMostrarData($tabla);
                                foreach ($registros as $data_d) {
                                  echo "<option value='" . $data_d['Id_Tipo_Predio'] . "'>" . $data_d['Tipo'] . '</option>';
                                }
                                ?>
                              </select>
                            </div>
                            <!-- USO PREDIO    -->
                            <div class="row">
                              <label for="usoPredio_e" class="cajalabet"> Uso</label>
                              <select class="form2" name="usoPredio_e" id="usoPredio_e">
                                <option value="" selected="" disabled="">Seleccione</option>
                                <?php
                                $tabla = 'uso_predio';
                                $registros = ControladorPredio::ctrMostrarData($tabla);
                                foreach ($registros as $data_d) {
                                  echo "<option value='" . $data_d['Id_Uso_Predio'] . "'>" . $data_d['Uso'] . '</option>';
                                }
                                ?>
                              </select>
                            </div>
                            <!-- ESTADO PREDIO -->
                            <div class="row">
                              <label for="estadoPredio_e" class="cajalabet"> Estado</label>
                              <select class="form2" name="estadoPredio_e" required="" id="estadoPredio_e">
                                <option value="" selected="" disabled="">Seleccione</option>
                                <?php
                                $tabla = 'estado_predio';
                                $registros = ControladorPredio::ctrMostrarData($tabla);
                                foreach ($registros as $data_d) {
                                  echo "<option value='" . $data_d['Id_Estado_Predio'] . "'>" . $data_d['Estado'] . '</option>';
                                }
                                ?>
                              </select>
                            </div>




                            <!-- GIRO ESTABLECIMIENTO -->
                            <div class="row "  style="margin-top: 3px; margin-bottom: 3px" >
                              <label for="giroPredio_e" class="cajalabet"> Giro Est.</label>

                                  <select id="giroPredio_e" class="form2" name="giroPredio_e" required style="width: 66%">
                                        <option value=""></option> <!-- Para placeholder -->
                                        <?php
                                        $tabla = 'giro_establecimiento';
                                        $registros = ControladorPredio::ctrMostrarData($tabla);
                                        foreach ($registros as $data_d) {
                                          echo "<option value='" . intval($data_d['Id_Giro_Establecimiento']) . "'>" . htmlspecialchars($data_d['Nombre']) . "</option>";
                                        }
                                        ?>
                                </select>

                            </div>



                            


                            <!-- CONDICION DEL PREDIO  -->
                            <div class="row">
                              <label for="condicionPredio_e" class="cajalabet"> Cond.
                              </label>
                              <select class="form2" name="condicionPredio_e" required="" id="condicionPredio_e">
                                <option value="" selected="" disabled="">Seleccione</option>
                                <?php
                                $tabla = 'condicion_predio';
                                $registros = ControladorPredio::ctrMostrarData($tabla);
                                foreach ($registros as $data_d) {
                                  echo "<option value='" . $data_d['Id_Condicion_Predio'] . "'>" . $data_d['Condicion'] . '</option>';
                                }
                                ?>
                              </select>
                            </div>
                            <!--FECHA DE ADQUICISION-->
                            <div class="row">
                              <label for="fechaAdqui_e" class="cajalabet">Fec Adq.</label>
                              <input type="date" class="form2" name="fechaAdqui_e" id="fechaAdqui_e">
                            </div>
                          </div>
                          <div class="col-12 col-md-6">
                            <!--REGIMEN AFECTACION-->
                            <div class="row">
                              <label for="regInafecto_e" class="cajalabet"> Reg.Inaf</label>
                              <select class="form2" name="regInafecto_e" id="regInafecto_e">
                                <option value="" selected="" disabled="">Seleccione</option>
                                <?php
                                $tabla = 'regimen_afecto';
                                $registros = ControladorPredio::ctrMostrarData($tabla);
                                foreach ($registros as $data_d) {
                                  echo "<option value='" . $data_d['Id_Regimen_Afecto'] . "'>" . $data_d['Regimen'] . '</option>';
                                }
                                ?>
                              </select>
                            </div>

                         <div class="row" id="fecha_ini_div" style="display: none; justify-content: flex-end; align-items: center;">
                              <label for="fechaInicio_e" class="cajalabet" style="margin-right: 10px; margin-left:24px">Fecha ini.</label>
                              <input type="date" class="form2" style="width: 110px; margin-right: 4px; background-color:#a83018; color:#f0f0f0" name="fechaInicio_e" id="fechaInicio_e">
                          </div>

                          <div class="row" id="fecha_fin_div" style="display: none;  justify-content: flex-end; align-items: center;">
                              <label for="fechaFin_e" class="cajalabet" style="margin-right: 10px;  margin-left:24px">Fecha fin</label>
                              <input type="date" class="form2" style="width: 110px; margin-right: 4px; background-color:#a83018; color:#f0f0f0" name="fechaFin_e" id="fechaFin_e">
                          </div>

                          <div class="row" id="expediente_div" style="display: none; justify-content: flex-end; align-items: center;">
                              <label for="numeroExpediente_e" class="cajalabet" style="margin-right: 10px;  margin-left:24px">N° exped.</label>
                              <input type="text" class="form2" style="width: 110px; margin-right: 4px; background-color:#a83018; color:#f0f0f0" name="numeroExpediente_e" id="numeroExpediente_e">
                          </div>

                            
                            <!-- ENTRADA REGIMEN AFECTACION POR COMPAÑIA -->
                            <div class="row">
                              <label for="afecto_e" class="cajalabet"> Inafecto</label>
                              <select class="form2" name="afecto_e" id="afecto_e">
                                <option value="" selected="" disabled="">Seleccione</option>
                                <?php
                                $tabla = 'inafecto';
                                $registros = ControladorPredio::ctrMostrarData($tabla);
                                foreach ($registros as $data_d) {
                                  echo "<option value='" . $data_d['Id_inafecto'] . "'>" . $data_d['Inafectacion'] . '</option>';
                                }
                                ?>
                              </select>
                            </div>
                            <!--AFECTACION ARBITRIOS-->
                            <div class="row">
                              <label for="afectacionArb_e" class="cajalabet">Afec.Arbit.</label>
                              <select class="form2" name="afectacionArb_e" required="" id="afectacionArb_e">
                                <option value="" selected="" disabled="">Seleccione</option>
                                <?php
                                $tabla = 'arbitrios';
                                $registros = ControladorPredio::ctrMostrarData($tabla);
                                foreach ($registros as $data_d) {
                                  echo "<option value='" . $data_d['Id_Arbitrios'] . "'>" . $data_d['Categoria'] . '</option>';
                                }
                                ?>
                              </select>
                            </div>
                            <!--EXPEDIENTE -->
                            <div class="row">
                              <label for="nroExpediente_e" class="cajalabet"># Exped.</label>
                              <input type="text" pattern="[0-9]+" title="Solo se permiten números" class="form2" name="nroExpediente_e" id="nroExpediente_e" maxlength="10">
                            </div>
                            <!--FECHA DE INICIO-->
                            <div class="row">
                              <label class="cajalabet">F.Inicio</label>
                              <label id="fechaIni">01-01-2023</label>
                            </div>
                            <!--FECHA DE FINALIZA-->
                            <div class="row">
                              <label class="cajalabet">F.Fin</label>
                              <label id="fechaFin">31-12-2023</label>
                            </div>
                          </div>
                        </div>
                        <!--OBSERVACIONES-->
                      </div>
                      <div class="row">
                        <div>
                          <label for="observacion_e" class="cajalabel2">Obervaciones</label>
                          <input style="width: 50%;" type="text" pattern="[A-Za-z0-9\s:.\-]+" title="Solo se permiten letras" name="observacion_e" id="observacion_e" maxlength="70">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>


                 
                <!--====== LEVANTAMIENTO YANO ==-->
                <div id="divDescripPreu" >
                  <div class="box box-success" style="border-top: 0px;">
                    <div class="box-body" style="border: 1px dotted gray;  ">
                      <div class="row">


                       <div class="col-md-4">
                   
                      <div class="row2">
                        <div class="flex">
                          <button type="button" class="bi bi-cart-fill btn btn-secundary btn-1" id="btnAbrirModal" style="border: 1px solid #6c757d; padding: 5px 10px; border-radius: 5px;">Agregar negocio</button>

                          <!-- <button type="button" class="bi bi-geo-alt-fill btn btn-secundary btn-1" data-toggle="modal" data-target="#modalRegistrar_negocio">Agregar negocio</button>
                        -->
                       
                       
                        </div>
                       
                      </div>
                  </div>
                      
                         <div class="col-12 col-md-4"> <!-- LADO 1 PARAMETROS DEL PREDIO URBANO-->
                        
                              <div class="row">
                                  <label for="npersonas_e" class="cajalabel2">¿Cuantas personas viven?</label>
                                  <input type="number" title="Solo se permiten números" class="form33" name="npersonas_e" id="npersonas_e" maxlength="10" required="">
                            
                            
                                </div>

                                     

                        </div>


                         <div class="col-12 col-md-4"> <!-- LADO 1 PARAMETROS DEL PREDIO URBANO-->
                        
                            
                            <!-- TIENE AGUA DEL MISMO PREDIO -->
                                <div class="row align-items-center">
                                  <div class="d-flex align-items-center">
                                  <span class="cajalabet">¿Tiene agua el predio?</span>
                                  </div>

                                <div class="col-auto d-flex align-items-center">
                                <input type="radio" id="agua_si" name="tieneAgua" value="si" />
                                <label for="agua_si" class="cajalabet">Sí</label>

                                <input type="radio" id="agua_no" name="tieneAgua" value="no" />
                                <label for="agua_no" class="cajalabet">No</label>
                              </div>
                               <div class="row"  id="paga_otro_nombre_row">
                                      <label for="paga_otro_nombre_e" class="cajalabel22">¿Paga a otro nombre?(opcional)</label>
                                        <input type="text" title="Solo se permiten números" class="form33" name="paga_otro_nombre_e" id="paga_otro_nombre_e" maxlength="150" required="">
                                  
                                 </div>


                                </div>


                        </div>


                        
                         <div class="col-12 col-md-4"> <!-- LADO 1 PARAMETROS DEL PREDIO URBANO-->
                        
                            
                            <!-- TIENE AGUA DEL MISMO PREDIO -->
                               


                        </div>


                       









                        <!--OBSERVACIONES-->
                      </div>
                      
                    </div>
                  </div>
                </div>

          

                  <!--====== LISTA DE NEGOCIOS ==-->

                  <div id="divUbigeoPreu">
                  <div class="box">
                    <div class="box-body">
                   
                      <!-- Tabla-->
                      <div class="row2">
                      
                            <table class="table-container">
                              <thead>
                                <tr>
                                 <th style="text-align: center;">Razon social</th>
                                  <th style="text-align: center;">licencia</th>
                                  <th style="text-align: center;">Ruc</th>
                                  <th style="text-align: center;">Area</th>
                                  <th style="text-align: center;">Agua</th>
                                  <th style="text-align: center;">Itze</th>
                                   <th style="text-align: center;">Accion</th>
                                </tr>
                              </thead>
                              <tbody id="listaNegocio">
                              </tbody>
                            </table>
                         
                      </div>
                    </div>
                    
                  </div>
                </div>



                


                <!--====== ENTRADA UBIGEO PREDIO RUST =========-->
                <div id="divUbigeoPreR">

                  <div class="">
                    <div class="row2">
                      <span class="caption_">Informacion de Ubicacion del Predio</span>
                      <div class="flex">
                        <button id="btnAbrirUbigeoRural_e" type="button" class="btn btn-secundary" data-toggle="modal" data-target="#moda_PredioRusticoe"><i class="bi bi-geo-fill"></i>UBIGEO PREDIO RUSTICO</button>
                      </div>
                    </div>
                    <!-- Tabla-->

                    <table class="table-container">
                      <thead>
                        <tr>
                          <th>Nombre Zona</th>
                          <th>IdZona</th>
                          <th>Grupo Tierra</th>
                          <th>Categoria</th>
                          <th>Calidad Agricola</th>
                          <th>Valor x Hectarea</th>
                          <th>Año</th>
                          <th>id</th>
                        </tr>
                      </thead>
                      <tbody id="itemsR">
                      </tbody>
                    </table>

                  </div>
                  <!-- -->
                  <div class="box-body" style="border: 1px dotted gray; border-top: 0px ; padding-top:5px; ">
                    <div class="col-12 col-md-4"> <!-- LADO 1 DENOMINACION PREDIO RURAL-->
                      <!-- ENTRADA DENOMINACION RURAL-->
                      <div class="">
                        <label for="denoSectorR_e" class="cajalabel2">Denominacion Rural</label>
                        <input type="text" pattern="[A-Za-z0-9\s:.\-]+" title="" class="form5" name="denoSectorR_e" id="denoSectorR_e" required="">
                      </div>
                    </div>
                    <div class="col-12 col-md-8"> <!-- LADO 2 COLINDANTES-->
                      <div class="">
                        <label for="" class="cajalabel2">Colindantes </label>
                        <input for="" class="form2" value="Propietarios" disabled>
                        <input for="" class="form2" value="Denominacion Rural" disabled>
                      </div>
                      <div class="">
                        <label for="colSurNombre" class="cajalabel2">Colindante Sur</label>
                        <input type="text" pattern="[0-9]+" title="" class="form2" name="colSurNombre_e" id="colSurNombre_e" maxlength="50" required="">
                        <input type="text" pattern="[0-9]+" title="" class="form2" name="colSurSector_e" id="colSurSector_e" maxlength="50" required="">
                      </div>
                      <div class="">
                        <label for="colNorteNombre" class="cajalabel2">Colindantes Norte</label>
                        <input type="text" pattern="[0-9]+" title="" class="form2" name="colNorteNombre_e" id="colNorteNombre_e" maxlength="50" required="">
                        <input type="text" pattern="[0-9]+" title="" class="form2" name="colNorteSector_e" id="colNorteSector_e" maxlength="50" required="">
                      </div>
                      <div class="">
                        <label for="colEsteNombre" class="cajalabel2">Colindantes Este </label>
                        <input type="text" pattern="[0-9]+" title="" class="form2" name="colEsteNombre_e" id="colEsteNombre_e" maxlength="50" required="">
                        <input type="text" pattern="[0-9]+" title="" class="form2" name="colEsteSector_e" id="colEsteSector_e" maxlength="50" required="">
                      </div>
                      <div class="">
                        <label for="colOesteNombre" class="cajalabel2">Colindantes Oeste</label>
                        <input type="text" pattern="[0-9]+" title="" class="form2" name="colOesteNombre_e" id="colOesteNombre_e" maxlength="50" required="">
                        <input type="text" pattern="[0-9]+" title="" class="form2" name="colOesteSector_e" id="colOesteSector_e" maxlength="50" required="">
                      </div>
                    </div>
                  </div>

                </div>

              </div>

              <!--====== DESCRIPCION ENTRADA PREDIO RUST =====-->
              <div id="divDescriPreR">

                <div class="box box-success" style="border-top: 0px;">
                  <div class="box-body" style="border: 1px dotted gray; padding-top:0px; ">
                    <div class="row">
                      <div class="col-12 col-md-4"> <!-- LADO 1 PARAMETROS DEL PREDIO-->

                        <legend class="text-bold" style="margin-left:15px; font-size:1.3em; letter-spacing: 1px;">PARAMETROS PREDIO RUSTICO:</legend>

                        <!-- ENTRADA AREA TERRENO-->
                        <div class="row">
                          <label for="areaTerrenoR_e" class="cajalabel2">Area (Hectareas)</label>
                          <input type="text" pattern="[0-9]+" title="Solo se permiten números" class="form3" name="areaTerrenoR_e" id="areaTerrenoR_e" maxlength="10" required="">
                        </div>
                        <!-- VALOR ARANCEL-->
                        <div class="row">

                          <label for="" class="cajalabel2">Valor Arancel</label>
                          <label id="valorArancelR">-</label>

                        </div>
                        <!-- VALOR TERRENO-->
                        <div class="row">

                          <label class="cajalabel2">Valor Terreno</label>
                          <label id="valorTerrenoR_e">-</label>

                        </div>
                        <!-- VALOR PREDIO POR AÑO-->
                        <div class="row">

                          <label for="" class="cajalabel2">Valor Predio</label>
                          <label id="valorPredioRAnio_e">-</label>

                        </div>
                        <!--FECHA DE INICIO-->
                        <div class="row">

                          <label class="cajalabel2">Fecha Inicio</label>
                          <label id="fechaIni">01-01</label>

                        </div>
                        <!--FECHA DE FINALIZA-->
                        <div class="row">

                          <label class="cajalabel2">Fecha Finaliza</label>
                          <label id="fechaFin">31-12</label>

                        </div>

                      </div>

                      <div class="col-12 col-md-8"><!-- LADO 2 DESCRIPCION DEL PREDIO-->

                        <legend class="text-bold" style="margin-left:15px; font-size:1.3em; letter-spacing: 1px;">DESCRIPCION DEL PREDIO:</legend>
                        <div class="col-12 col-md-6">
                          <!-- TIPO PREDIO   -->
                          <div class="row">
                            <label for="tipoPredioR_e" class="cajalabel2"> Tipo Predio</label>
                            <select class="form2" name="tipoPredioR_e" id="tipoPredioR_e">
                              <option value="" selected="" disabled="">Seleccione</option>
                              <?php
                              $tabla = 'tipo_predio';
                              $registros = ControladorPredio::ctrMostrarDataItems($tabla);
                              foreach ($registros as $data_d) {
                                echo "<option value='" . $data_d['Id_Tipo_Predio'] . "'>" . $data_d['Tipo'] . '</option>';
                              }
                              ?>
                            </select>
                          </div>

                          <!-- USO PREDIO    -->
                          <div class="row">
                            <label for="usoPredioR_e" class="cajalabel2"> Uso Predio</label>
                            <select class="form2" name="usoPredioR_e" id="usoPredioR_e">
                              <option value="" selected="" disabled="">Seleccione</option>
                              <?php
                              $tabla = 'uso_predio';
                              $registros = ControladorPredio::ctrMostrarData($tabla);
                              foreach ($registros as $data_d) {
                                echo "<option value='" . $data_d['Id_Uso_Predio'] . "'>" . $data_d['Uso'] . '</option>';
                              }
                              ?>
                            </select>
                          </div>

                          <!-- ESTADO PREDIO -->
                          <div class="row">
                            <label for="estadoPredioR_e" class="cajalabel2"> Estado del Predio</label>
                            <select class="form2" name="estadoPredioR_e" required="" id="estadoPredioR_e">
                              <option value="" selected="" disabled="">Seleccione</option>
                              <?php
                              $tabla = 'estado_predio';
                              $registros = ControladorPredio::ctrMostrarData($tabla);
                              foreach ($registros as $data_d) {
                                echo "<option value='" . $data_d['Id_Estado_Predio'] . "'>" . $data_d['Estado'] . '</option>';
                              }
                              ?>
                            </select>
                          </div>

                          <!-- CONDICION DEL PREDIO  -->
                          <div class="row">
                            <label for="condicionPredioR_e" class="cajalabel2"> Cond. Propietario
                            </label>
                            <select class="form2" name="condicionPredioR_e" required="" id="condicionPredioR_e">
                              <option value="" selected="" disabled="">Seleccione</option>
                              <?php
                              $tabla = 'condicion_predio';
                              $registros = ControladorPredio::ctrMostrarData($tabla);
                              foreach ($registros as $data_d) {
                                echo "<option value='" . $data_d['Id_Condicion_Predio'] . "'>" . $data_d['Condicion'] . '</option>';
                              }
                              ?>
                            </select>
                          </div>

                          <!--FECHA DE ADQUICISION-->
                          <div class="row">
                            <div class="form-group">
                              <label for="fechaAdquiR_e" class="cajalabel2">Fecha Adquisicion</label>
                              <input type="date" class="form2" name="fechaAdquiR_e" id="fechaAdquiR_e">
                            </div>
                          </div>

                        </div>
                        <div class="col-12 col-md-6">
                          <!--REGIMEN AFECTACION-->
                          <div class="row">
                            <label for="regInafectoR_e" class="cajalabel2"> Reg. Inafecto</label>
                            <select class="form2" name="regInafectoR_e" id="regInafectoR_e">
                              <option value="" selected="" disabled="">Seleccione</option>
                              <?php
                              $tabla = 'regimen_afecto';
                              $registros = ControladorPredio::ctrMostrarData($tabla);
                              foreach ($registros as $data_d) {
                                echo "<option value='" . $data_d['Id_Regimen_Afecto'] . "'>" . $data_d['Regimen'] . '</option>';
                              }
                              ?>
                            </select>
                          </div>
                          <!-- ENTRADA REGIMEN AFECTACION POR COMPAÑIA -->
                          <div class="row">
                            <label for="inafectoRpor_e" class="cajalabel2"> Inafecto</label>
                            <select class="form2" name="inafectoRpor_e" required="" id="inafectoRpor_e">
                              <option value="" selected="" disabled="">Seleccione</option>
                              <?php
                              $tabla = 'inafecto';
                              $registros = ControladorPredio::ctrMostrarData($tabla);
                              foreach ($registros as $data_d) {
                                echo "<option value='" . $data_d['Id_inafecto'] . "'>" . $data_d['Inafectacion'] . '</option>';
                              }
                              ?>
                            </select>
                          </div>
                          <div class="row">
                            <label for="tipoTerrenoR_e" class="cajalabel2"> Tipo Terreno</label>
                            <select class="form2" name="tipoTerrenoR_e" required="" id="tipoTerrenoR_e">
                              <option value="" selected="" disabled="">Seleccione</option>
                              <?php
                              $tabla = 'tipo_terreno';
                              $registros = ControladorPredio::ctrMostrarData($tabla);
                              foreach ($registros as $data_d) {
                                echo "<option value='" . $data_d['Id_Tipo_Terreno'] . "'>" . $data_d['Tipo_Terreno'] . '</option>';
                              }
                              ?>
                            </select>
                          </div>
                          <div class="row">
                            <label for="usoTerrenoR_e" class="cajalabel2"> Uso Terreno</label>
                            <select class="form2" name="usoTerrenoR_e" required="" id="usoTerrenoR_e">
                              <option value="" selected="" disabled="">Seleccione</option>
                              <?php
                              $tabla = 'uso_terreno';
                              $registros = ControladorPredio::ctrMostrarData($tabla);
                              foreach ($registros as $data_d) {
                                echo "<option value='" . $data_d['Id_Uso_Terreno'] . "'>" . $data_d['Uso_Terreno'] . '</option>';
                              }
                              ?>
                            </select>
                          </div>
                          <!--EXPEDIENTE -->
                          <div class="row">
                            <div class="form-group">
                              <label for="nroExpedienteR_e" class="cajalabel2">#Expediente</label>
                              <input type="text" pattern="[0-9]+" title="Solo se permiten números" class="form2" name="nroExpedienteR_e" id="nroExpedienteR_e" maxlength="10">
                            </div>
                          </div>

                        </div>

                      </div>
                      <!--OBSERVACIONES-->
                    </div>
                    <div class="row">
                      <div>
                        <label for="observacionR_e" class="cajalabel2">Obervaciones</label>
                        <input style="width: 50%;" type="text" pattern="[A-Za-z0-9\s:.\-]+" title="Solo se permiten letras" name="observacionR_e" id="observacionR_e" maxlength="70">
                      </div>
                    </div>
                  </div>
                </div>

              </div>

              

          </div>
          </form>
        </div>
      </div>

      <div class="modal-footer" style="padding-top: 0 !important;padding-bottom: 0 !important;">

        <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
        <button type="button" class="btn btn-primary" id="btnGuardarPredio_e"><i class="bi bi-floppy2-fill"></i> Guardar Cambios s</button>
    
      </div>


    </div>
    <div id="respuestaFechaEdit"></div>
  </div>
</div>


<!-- MODAL  VER NEGOCIO -->
<!-- MODAL  VER NEGOCIO -->
<!-- MODAL  VER NEGOCIO -->

<!-- MODAL  VER NEGOCIO -->
<div class="modal" id="modalVer_negocio" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detalle del Negocio</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <div class="col-12">
          <div class="card shadow-sm" style="border-radius: 10px;">
            <div class="card-body">
               <div class="row mb-4">
                <div class="col-md-6">
                
                  <p id="nombreNegocioModal" class="lead text-muted"></p>
                </div>
               
              </div>
              
            

              <!-- Información del Negocio -->
              <div class="row">
                <div class="col-md-6">
                  <div class="d-flex align-items-center ">
                    <i class="bi bi-person-circle me-2 text-muted" style="font-size: 1.5rem;"></i>
                    <span class="fw-bold mb-0">Razón Social</span>
                  </div>
                  <p id="razonSocialModal"></p>
                </div>
                <div class="col-md-6">
                  <div class="d-flex align-items-center ">
                    <i class="bi bi-building me-2 text-muted" style="font-size: 1.5rem;"></i>
                    <span class="fw-bold mb-0">RUC</span>
                  </div>
                  <p id="rucModal"></p>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="d-flex align-items-center ">
                    <i class="bi bi-geo-alt me-2 text-muted" style="font-size: 1.5rem;"></i>
                    <span class="fw-bold mb-0">Área del Negocio</span>
                  </div>
                  <p id="areaNegocioModal"></p>
                </div>
                <div class="col-md-6">
                  <div class="d-flex align-items-center ">
                    <i class="bi bi-house-door me-2 text-muted" style="font-size: 1.5rem;"></i>
                    <span class="fw-bold mb-0">Tenencia del Negocio</span>
                  </div>
                  <p id="tenenciaNegocioModal"></p>
                </div>
              </div>

              <!-- Más Información -->
              <div class="row">
                <div class="col-md-6">
                  <div class="d-flex align-items-center ">
                    <i class="bi bi-person-check me-2 text-muted" style="font-size: 1.5rem;"></i>
                    <span class="fw-bold mb-0">Número de Trabajadores</span>
                  </div>
                  <p id="nTrabajadoresModal"></p>
                </div>
                <div class="col-md-6">
                  <div class="d-flex align-items-center ">
                    <i class="bi bi-table me-2 text-muted" style="font-size: 1.5rem;"></i>
                    <span class="fw-bold mb-0">Número de Mesas</span>
                  </div>
                  <p id="nMesasModal"></p>
                </div>
              </div>

              <!-- LADO 2 -->
              <div class="row">
                <div class="col-md-6">
                  <div class="d-flex align-items-center ">
                    <i class="bi bi-bed me-2 text-muted" style="font-size: 1.5rem;"></i>
                    <span class="fw-bold mb-0">Número de Camas</span>
                  </div>
                  <p id="nCamasModal"></p>
                </div>
                <div class="col-md-6">
                  <div class="d-flex align-items-center ">
                    <i class="bi bi-door-open me-2 text-muted" style="font-size: 1.5rem;"></i>
                    <span class="fw-bold mb-0">Número de Cuartos</span>
                  </div>
                  <p id="nCuartosModal"></p>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="d-flex align-items-center ">
                    <i class="bi bi-droplet me-2 text-muted" style="font-size: 1.5rem;"></i>
                    <span class="fw-bold mb-0">Agua del Negocio</span>
                  </div>
                  <p id="aguaNegocioModal"></p>
                </div>
                <div class="col-md-6">
                  <div class="d-flex align-items-center ">
                    <i class="bi bi-shield-lock me-2 text-muted" style="font-size: 1.5rem;"></i>
                    <span class="fw-bold mb-0">ITSE</span>
                  </div>
                  <p id="itseModal"></p>
                </div>
              </div>

              <div class="row">
                 <div class="col-md-6">
                  <div class="d-flex align-items-center ">
                    <i class="bi bi-check-circle me-2 text-muted" style="font-size: 1.5rem;"></i>
                    <span class="fw-bold mb-0">Estado</span>
                  </div>
                  <p id="estadoModal"></p>
                </div>
                <div class="col-md-6">
                  <div class="d-flex align-items-center ">
                    <i class="bi bi-calendar-event me-2 text-muted" style="font-size: 1.5rem;"></i>
                    <span class="fw-bold mb-0">Vencimiento ITSE</span>
                  </div>
                  <p id="vencimientoItseModal"></p>
                </div>
               
              </div>

            </div>
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" id="cancelarModalVer" class="btn btn-secondary" data-bs-dismiss="modal">Salir</button>
      
     
      </div>
    </div>
  </div>
</div>


<!-- MODAL  EDITAR NEGOCIO -->
<div class="modal" id="modalRegistrar_negocio_editar">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> Editar negocio</h5>
      </div>
      <div class="modal-body">
        <div class="col-12">

        
         <div id="divDescripPreu" >
                  <div class="box box-success" style="border-top: 0px;">
                    <div class="box-body" style="border: 1px dotted gray;  ">
                      <div class="row">


                        <div class="col-12 col-md-3"> <!-- LADO 1 PARAMETROS DEL PREDIO URBANO-->
                         
                         <input  type="text" name="idPredioModal" class="hidden" id="idPredioModal" />

                              <!-- GIRO ESTABLECIMIENTO -->
                            <div class="row "  style="margin-top: 3px; margin-bottom: 3px" >
                              <label for="giroNegocio_e" class="cajalabett"> Giro negocio</label>

                                  <select id="giroNegocio_e_d" class="form22" name="giroNegocio_e_d" required >
                                        <option value=""></option> <!-- Para placeholder -->
                                        <?php
                                        $tabla = 'giro_establecimiento';
                                        $registros = ControladorPredio::ctrMostrarData($tabla);
                                        foreach ($registros as $data_d) {
                                          echo "<option value='" . intval($data_d['Id_Giro_Establecimiento']) . "'>" . htmlspecialchars($data_d['Nombre']) . "</option>";
                                        }
                                        ?>
                                </select>

                            </div>

                          <div class="row">
                            <label for="razon_social" class="cajalabel2">Razón social</label>
                            <input type="text" title="Solo se permite todo" class="form33" name="razon_social_d" id="razon_social_d" maxlength="100" required="">
                          </div>

                            <div class="row">
                            <label for="nro_ruc" class="cajalabel2">Nro RUC</label>
                            <input type="text" title="Solo se permite todo" class="form33" name="nro_ruc_d" id="nro_ruc_d" maxlength="50" required="">
                          </div>

                          
                          <!-- ENTRADA AREA TERRENO-->
                           <div class="row">
                            <label for="nro_licencia" class="cajalabel2">N° licencia</label>
                            <input type="text" title="Solo se permite todo" class="form33" name="nro_licencia_d" id="nro_licencia_d" maxlength="30" required="">
                          </div>

                          
                          <!-- VALOR ARANCEL-->
                         
                        </div>

                           <div class="col-12 col-md-3"> <!-- LADO 1 PARAMETROS DEL PREDIO URBANO-->
                        
                           <div class="row">
                              <label for="tenencia_ne_d" class="cajalabel2"> Tenencia neg. </label>
                              <select class="form33" name="tenencia_ne_d" id="tenencia_ne_d">
                                <option value="" selected="" >Seleccione</option>
                                 <option value="PROPIO"  >Propio</option>
                                  <option value="ALQUILADO"  >Alquilado</option>
                                    <option value="OTRO"  >Otro</option>
                               
                              </select>
                            </div>


                        <!-- Personería (Natural o Jurídica) -->
                    <div class="row">
                      <label for="personeria_ne_d" class="cajalabel2">Personería jurídica</label>
                      <select class="form33" name="personeria_ne_d" id="personeria_ne_d">
                        <option value="" selected>Seleccione</option>
                        <option value="PERSONA_NATURAL">Persona natural</option>
                        <option value="PERSONA_JURIDICA">Persona jurídica</option>
                      </select>
                    </div>

                    <!-- Tipo sociedad (solo se muestra si es PERSONA_JURIDICA) -->
                    <div class="row" id="otroInputRowJuridica" style="display: none;">
                      <label for="tipo_sociedad_d" class="cajalabel2">Tipo sociedad</label>
                      <select class="form33" name="tipo_sociedad_d" id="tipo_sociedad_d">
                        <option value="" selected>Seleccione</option>
                        <option value="SA">S.A.</option>
                        <option value="SAC">S.A.C.</option>
                        <option value="SRL">S.R.L.</option>
                        <option value="EIRL">E.I.R.L.</option>
                      </select>
                    </div>


                             <div class="row">
                            <label for="n_trabajadores_d" class="cajalabel2">N° trabajadores </label>
                            <input type="number" title="Solo se permiten números" class="form33" name="n_trabajadores_d" id="n_trabajadores_d" maxlength="10" required="">
                          </div>

                          
                         
                         
                        </div>


                        <div class="col-12 col-md-3"> <!-- LADO 1 PARAMETROS DEL PREDIO URBANO-->
                        
                        <div class="row">
                            <label for="nMesas_e_d" class="cajalabel2">N° mesas(Restaurante)</label>
                            <input type="number" title="Solo se permiten números" class="form33" name="nMesas_e_d" id="nMesas_e_d" maxlength="10" required="">
                        </div>
                          
                          <!-- ENTRADA AREA TERRENO-->
                          <div class="row">
                            <label for="areaNegocio_e_d" class="cajalabel2">Area neg. m2</label>
                            <input type="text" title="Solo se permiten números" class="form33" name="areaNegocio_e_d" id="areaNegocio_e_d" maxlength="10" required="">
                          </div>
                          <!-- VALOR ARANCEL-->

                        <div class="row">
                            <label for="ncuartos_d" class="cajalabel2">N° cuartos(hotel)</label>
                            <input type="number" title="Solo se permiten números" class="form33" name="ncuartos_d" id="ncuartos_d" maxlength="10" required="">
                        </div>

                          <div class="row">
                            <label for="ncamas_d" class="cajalabel2">N° camas(hotel)</label>
                            <input type="number" title="Solo se permiten números" class="form33" name="ncamas_d" id="ncamas_d" maxlength="10" required="">
                        </div>
                         
                         
                       
                         
                        </div>

                         <div class="col-12 col-md-3"> <!-- LADO 1 PARAMETROS DEL PREDIO URBANO-->
                        
                        <div class="row">
                            <label for="nBano_d" class="cajalabel2">N° baño</label>
                            <input type="number" title="Solo se permiten números" class="form33" name="nBano_d" id="nBano_d" maxlength="10" required="">
                        </div>

                     <div class="row align-items-center">
                      <div class="d-flex align-items-center">
                      <span class="cajalabet">¿Tiene agua negocio?</span>
                      </div>

                     <div class="col-auto d-flex align-items-center">
                    <input type="radio" id="agua_si" name="tieneAguan_n" value="si" />
                    <label for="agua_si" class="cajalabet">Sí</label>

                    <input type="radio" id="agua_no" name="tieneAguan_n" value="no" />
                    <label for="agua_no" class="cajalabet">No</label>
                  </div>


                    </div>
                        
                        </div>

                         <div class="col-12 col-md-3"> <!-- LADO 1 PARAMETROS DEL PREDIO URBANO-->
                        
                         <div class="row align-items-center">
                                  <div class="d-flex align-items-center">
                                  <span class="cajalabet">¿Cuenta con ITSE?</span>
                                  </div>

                                <div class="col-auto d-flex align-items-center">
                                <input type="radio" id="agua_si" name="licenciaitse_n" value="si" />
                                <label for="agua_si" class="cajalabet">Sí</label>

                                <input type="radio" id="agua_no" name="licenciaitse_n" value="no" />
                                <label for="agua_no" class="cajalabet">No</label>
                              </div>
                               <div class="row"  id="licencia_itse_row">
                                      <label for="fecha_vencimiento_n" class="cajalabel22">Fecha vencimiento</label>
                                        <input type="date" title="Solo se permiten números" class="form33" name="fecha_vencimiento_n" id="fecha_vencimiento_n" maxlength="150" required="">
                                  
                                 </div>


                                </div>
                                </div>

                       


                        <!--OBSERVACIONES-->
                      </div>
                      
                    </div>
                  </div>
                </div>

        </div>
      </div>
      
      <div class="modal-footer">
        <button type="button" id="cancelarModal" class="btn btn-secondary btn-cancelar" data-dismiss="modal">Salir</button>
   
       <button type="button" class="btn btn-primary" id="btnGuardarNegocio_e"><i class="bi bi-floppy2-fill"></i> Guardar</button>
    
      </div>

<div class="resultados3"></div>

    </div>
  </div>
</div>



<!-- MODAL  AGREGAR NEGOCIO -->
<div class="modal" id="modalRegistrar_negocio">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> Agregar negocio</h5>
      </div>
      <div class="modal-body">
        <div class="col-12">

        
         <div id="divDescripPreu" >
                  <div class="box box-success" style="border-top: 0px;">
                    <div class="box-body" style="border: 1px dotted gray;  ">
                      <div class="row">


                        <div class="col-12 col-md-3"> <!-- LADO 1 PARAMETROS DEL PREDIO URBANO-->
                         
                         <input  type="text" name="idPredioModal" class="hidden" id="idPredioModal" />

                              <!-- GIRO ESTABLECIMIENTO -->
                            <div class="row "  style="margin-top: 3px; margin-bottom: 3px" >
                              <label for="giroNegocio_e" class="cajalabett"> Giro negocio</label>

                                  <select id="giroNegocio_e" class="form22" name="giroNegocio_e" required >
                                        <option value=""></option> <!-- Para placeholder -->
                                        <?php
                                        $tabla = 'giro_establecimiento';
                                        $registros = ControladorPredio::ctrMostrarData($tabla);
                                        foreach ($registros as $data_d) {
                                          echo "<option value='" . intval($data_d['Id_Giro_Establecimiento']) . "'>" . htmlspecialchars($data_d['Nombre']) . "</option>";
                                        }
                                        ?>
                                </select>

                            </div>

                          <div class="row">
                            <label for="razon_social" class="cajalabel2">Razón social</label>
                            <input type="text" title="Solo se permite todo" class="form33" name="razon_social" id="razon_social" maxlength="100" required="">
                          </div>

                            <div class="row">
                            <label for="nro_ruc" class="cajalabel2">Nro RUC</label>
                            <input type="text" title="Solo se permite todo" class="form33" name="nro_ruc" id="nro_ruc" maxlength="50" required="">
                          </div>

                          
                          <!-- ENTRADA AREA TERRENO-->
                           <div class="row">
                            <label for="nro_licencia" class="cajalabel2">N° licencia</label>
                            <input type="text" title="Solo se permite todo" class="form33" name="nro_licencia" id="nro_licencia" maxlength="30" required="">
                          </div>

                          
                          <!-- VALOR ARANCEL-->
                         
                        </div>

                           <div class="col-12 col-md-3"> <!-- LADO 1 PARAMETROS DEL PREDIO URBANO-->
                        
                           <div class="row">
                              <label for="tenencia_ne" class="cajalabel2"> Tenencia neg. </label>
                              <select class="form33" name="tenencia_ne" id="tenencia_ne">
                                <option value="" selected="" >Seleccione</option>
                                 <option value="PROPIO"  >Propio</option>
                                  <option value="ALQUILADO"  >Alquilado</option>
                                    <option value="OTRO"  >Otro</option>
                               
                              </select>
                            </div>


                        <!-- Personería (Natural o Jurídica) -->
                    <div class="row">
                      <label for="personeria_ne" class="cajalabel2">Personería jurídica</label>
                      <select class="form33" name="personeria_ne" id="personeria_ne">
                        <option value="" selected>Seleccione</option>
                        <option value="PERSONA_NATURAL">Persona natural</option>
                        <option value="PERSONA_JURIDICA">Persona jurídica</option>
                      </select>
                    </div>

                    <!-- Tipo sociedad (solo se muestra si es PERSONA_JURIDICA) -->
                    <div class="row" id="otroInputRowJuridica" style="display: none;">
                      <label for="tipo_sociedad" class="cajalabel2">Tipo sociedad</label>
                      <select class="form33" name="tipo_sociedad" id="tipo_sociedad">
                        <option value="" selected>Seleccione</option>
                        <option value="SA">S.A.</option>
                        <option value="SAC">S.A.C.</option>
                        <option value="SRL">S.R.L.</option>
                        <option value="EIRL">E.I.R.L.</option>
                      </select>
                    </div>


                             <div class="row">
                            <label for="n_trabajadores" class="cajalabel2">N° trabajadores </label>
                            <input type="number" title="Solo se permiten números" class="form33" name="n_trabajadores" id="n_trabajadores" maxlength="10" required="">
                          </div>

                          
                         
                         
                        </div>


                        <div class="col-12 col-md-3"> <!-- LADO 1 PARAMETROS DEL PREDIO URBANO-->
                        
                        <div class="row">
                            <label for="nMesas_e" class="cajalabel2">N° mesas(Restaurante)</label>
                            <input type="number" title="Solo se permiten números" class="form33" name="nMesas_e" id="nMesas_e" maxlength="10" required="">
                        </div>
                          
                          <!-- ENTRADA AREA TERRENO-->
                          <div class="row">
                            <label for="areaNegocio_e" class="cajalabel2">Area neg. m2</label>
                            <input type="text" title="Solo se permiten números" class="form33" name="areaNegocio_e" id="areaNegocio_e" maxlength="10" required="">
                          </div>
                          <!-- VALOR ARANCEL-->

                        <div class="row">
                            <label for="ncuartos" class="cajalabel2">N° cuartos(hotel)</label>
                            <input type="number" title="Solo se permiten números" class="form33" name="ncuartos" id="ncuartos" maxlength="10" required="">
                        </div>

                          <div class="row">
                            <label for="ncamas" class="cajalabel2">N° camas(hotel)</label>
                            <input type="number" title="Solo se permiten números" class="form33" name="ncamas" id="ncamas" maxlength="10" required="">
                        </div>
                         
                         
                       
                         
                        </div>

                         <div class="col-12 col-md-3"> <!-- LADO 1 PARAMETROS DEL PREDIO URBANO-->
                        
                        <div class="row">
                            <label for="nBano" class="cajalabel2">N° baño</label>
                            <input type="number" title="Solo se permiten números" class="form33" name="nBano" id="nBano" maxlength="10" required="">
                        </div>

                     <div class="row align-items-center">
                      <div class="d-flex align-items-center">
                      <span class="cajalabet">¿Tiene agua negocio?</span>
                      </div>

                     <div class="col-auto d-flex align-items-center">
                    <input type="radio" id="agua_si" name="tieneAguan" value="si" />
                    <label for="agua_si" class="cajalabet">Sí</label>

                    <input type="radio" id="agua_no" name="tieneAguan" value="no" />
                    <label for="agua_no" class="cajalabet">No</label>
                  </div>


                    </div>
                        
                        </div>

                         <div class="col-12 col-md-3"> <!-- LADO 1 PARAMETROS DEL PREDIO URBANO-->
                        
                         <div class="row align-items-center">
                                  <div class="d-flex align-items-center">
                                  <span class="cajalabet">¿Cuenta con ITSE?</span>
                                  </div>

                                <div class="col-auto d-flex align-items-center">
                                <input type="radio" id="agua_si" name="licenciaitse" value="si" />
                                <label for="agua_si" class="cajalabet">Sí</label>

                                <input type="radio" id="agua_no" name="licenciaitse" value="no" />
                                <label for="agua_no" class="cajalabet">No</label>
                              </div>
                               <div class="row"  id="licencia_itse_row">
                                      <label for="fecha_vencimiento" class="cajalabel22">Fecha vencimiento</label>
                                        <input type="date" title="Solo se permiten números" class="form33" name="fecha_vencimiento" id="fecha_vencimiento" maxlength="150" required="">
                                  
                                 </div>


                                </div>
                                </div>

                       


                        <!--OBSERVACIONES-->
                      </div>
                      
                    </div>
                  </div>
                </div>

        </div>
      </div>
      
      <div class="modal-footer">
        <button type="button" id="cancelarModal" class="btn btn-secondary btn-cancelar" data-dismiss="modal">Salir</button>
   
       <button type="button" class="btn btn-primary" id="btnGuardarNegocio_e"><i class="bi bi-floppy2-fill"></i> Guardar</button>
    
      </div>

<div class="resultados3"></div>

    </div>
  </div>
</div>


<!--  MODAL VIAS -->
<div class="modal" id="modalViacalle_Predio">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> UBICACION DEL PREDIO u</h5>
      </div>
      <div class="modal-body">
        <div class="col-12">
          <?php include_once "table-viacallePredioEdit.php";  ?>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" id="cancelarModal" class="btn btn-secondary btn-cancelar" data-dismiss="modal">Salir</button>
      </div>
    </div>
  </div>
</div>

<div class="modal" id="moda_PredioRusticoe">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> UBICACION DEL RUSTICO EDITAR</h5>
      </div>
      <div class="modal-body">
        <div class="col-12">
          <?php include_once "table-viaPredioRusticoe.php";  ?>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" id="cancelarModal" class="btn btn-secondary btn-cancelar" data-dismiss="modal">Salir</button>
      </div>
    </div>
  </div>
</div>
</div>
<!--====== FIN EDITAR PREDIO =====================-->
<!--====== MODAL DE ELIMINAR PREDIO -->
<div class="modal fade" id="modalEliminarPredio" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="exampleModalLongTitle">Eliminar Predio</h5>
      </div>
      <div class="modal-body">
        <div class="form-group predio_catastro_eliminar bg-success p-2 text-dark bg-opacity-25">
          <!--CONTENIDO DINAMICO DEL PREDIO A TRANSFERIR -->
        </div>
        <label for="" class="lbl-text">Ingrese Sustento</label>
        <div class="row2"> <!--Datos del Predio-->
          <input type="text" class="form-control " id="documento_eliminar" name="documento_eliminar" placeholder="Documento Sustentatorio para eliminar el Predio" required="">
        </div>
        <div id="error_eliminar">
          <!--CONTENIDO DINAMICO DE MENSAJE POR NO COMPLETAR CAMPOS -->
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
        <button type="button" class="btn btn-primary btnEliminarPredio">Eliminar</button>
      </div>
    </div>
  </div>
</div>
<!--====== FIN DEL MODAL ELIMINAR PREDIO =========-->
<!--====== MODAL AGREGAR PISO =============-->
<div class="modal" id="modalAgregarPiso">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <label class="modal-title"> NUEVO PISO</label>
      </div>

      <div class="modal-body">
        <form role="form" method="POST" enctype="multipart/form-data" class="formRegistrarPiso" id="formRegistrarPiso">

          <div class="row2"> <!--Datos del Predio-->
            <label class="cajalabel" for=""> Codigo Predio: </label>
            <input type="text" class="form2" name="idCatastroRow" id="idCatastroRow" disabled="true">
            <label class="cajalabel" for=""> Año Fiscal: </label>
            <input type="text" class="form2" name="anioFiscal" id="anioFiscal" disabled="true">
          </div>

          <div class="row"> <!--Datos del Piso-->
            <fieldset style="border: 1px dotted #000;">
              <div class="col-lg-5 col-md-6">
                <label class="cajalabel2">Estado Conservacion:</label>
                <select name="estadoConservaImp" class="form2" id="estadoConservaImp">
                  <option selected="" disabled="">Seleccione</option>
                  <?php
                  $tabla = 'estado_conservacion';
                  $registros = ControladorPredio::ctrMostrarData($tabla);
                  foreach ($registros as $data_d) {
                    echo "<option value='" . $data_d['Id_Estado_Conservacion'] . "'>" . $data_d['Nombre'] . '</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="col-lg-5 col-md-6">
                <label class="cajalabel2">Clasificacion Piso: </label>
                <select name="clasificaPisoImp" class="form2" id="clasificaPisoImp">
                  <option selected="" disabled="">Seleccione</option>
                  <?php
                  $tabla = 'clasificacion_piso';
                  $registros = ControladorPredio::ctrMostrarData($tabla);
                  foreach ($registros as $data_d) {
                    echo "<option value='" . $data_d['Id_Clasificacion_Piso'] . "'>" . $data_d['Nombre'] . '</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="col-lg-5 col-md-6">
                <label class="cajalabel2">Numero Piso: </label>
                <input type="text" name="numeroPiso" id="numeroPiso" class="form2" disabled="true">
              </div>
              <!--<div class="col-lg-5 col-md-6">
                <label class="cajalabel2">Incrememto: </label>
                <input type="text" class="form2" value="1" disabled="true">
              </div>-->
              <div class="col-lg-5 col-md-6">
                <label class="cajalabel2">Años Antiguedad: </label>
                <input id="aniosAntiguedadImp" name="aniosAntiguedadImp" type="text" class="form2" disabled>
              </div>
              <div class="col-lg-5 col-md-6">
                <label class="cajalabel2">Material Predominante: </label>
                <select name="materialConsImp" class="form2" id="materialConsImp">
                  <option selected="" disabled="">Seleccione</option>
                  <?php
                  $tabla = 'material_piso';
                  $registros = ControladorPredio::ctrMostrarData($tabla);
                  foreach ($registros as $data_d) {
                    echo "<option value='" . $data_d['Id_Material_Piso'] . "'>" . $data_d['Nombre'] . '</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="col-lg-5 col-md-6">
                <label class="cajalabel2">Fecha Construccion: </label>
                <input id="fechaAntiguedad" name="fechaAntiguedad" type="date" class="form2">
              </div>
            </fieldset>
          </div>

          <!-- Valores de Edificacion del Piso -->
          <div class="row2 col-md-6">
            <fieldset style="border: 1px dotted #000; padding: 5px;">
              <legend>Valores Unitarios de Edificacion</legend>
              <div>
                <label for="" class="cajalabel2">Muros y Columnas</label>
                <select name="murosColumnas" id="murosColumnas">
                  <option selected="" disabled="true">Seleccione</option>
                  <?php
                  $tabla = 'categoria';
                  $registros = ControladorPredio::ctrMostrarData($tabla);
                  foreach ($registros as $data_d) {
                    echo "<option value='" . $data_d['Id_Categoria'] . "'>" . $data_d['Categoria'] . '</option>';
                  }
                  ?>
                </select>
                <input type="text" id="valorMuros" class="form3" disabled="true">
              </div>

              <div>
                <label for="techos" class="cajalabel2">Techos</label>
                <select name="techos" id="techos">
                  <option selected="" disabled="">Seleccione</option>
                  <?php
                  $tabla = 'categoria';
                  $registros = ControladorPredio::ctrMostrarData($tabla);
                  foreach ($registros as $data_d) {
                    echo "<option value='" . $data_d['Id_Categoria'] . "'>" . $data_d['Categoria'] . '</option>';
                  }
                  ?>
                </select>
                <input type="text" id="valorTechos" class="form3" disabled="true">
              </div>

              <div>
                <label for="" class="cajalabel2">Pisos</label>
                <select name="pisos" id="pisos">
                  <option selected="" disabled="">Seleccione</option>
                  <?php
                  $tabla = 'categoria';
                  $registros = ControladorPredio::ctrMostrarData($tabla);
                  foreach ($registros as $data_d) {
                    echo "<option value='" . $data_d['Id_Categoria'] . "'>" . $data_d['Categoria'] . '</option>';
                  }
                  ?>
                </select>
                <input type="text" id="valorPisos" class="form3">
              </div>

              <div>
                <label for="" class="cajalabel2">Puertas y Ventanas</label>
                <select name="puertasVentanas" id="puertasVentanas">
                  <option selected="" disabled="">Seleccione</option>
                  <?php
                  $tabla = 'categoria';
                  $registros = ControladorPredio::ctrMostrarData($tabla);
                  foreach ($registros as $data_d) {
                    echo "<option value='" . $data_d['Id_Categoria'] . "'>" . $data_d['Categoria'] . '</option>';
                  }
                  ?>
                </select>
                <input type="text" id="valorPuertasyVentanas" class="form3" disabled="true">
              </div>

              <div>
                <label for="" class="cajalabel2">Revestimientos</label>
                <select name="revestimiento" id="revestimiento">
                  <option value="" selected="" disabled="">Seleccione</option>
                  <?php
                  $tabla = 'categoria';
                  $registros = ControladorPredio::ctrMostrarData($tabla);
                  foreach ($registros as $data_d) {
                    echo "<option value='" . $data_d['Id_Categoria'] . "'>" . $data_d['Categoria'] . '</option>';
                  }
                  ?>
                </select>
                <input type="text" id="valorRevestimientos" class="form3">
              </div>

              <div>
                <label for="" class="cajalabel2">Baños</label>
                <select name="banios" id="banios">
                  <option value="" selected="" disabled="">Seleccione</option>
                  <?php
                  $tabla = 'categoria';
                  $registros = ControladorPredio::ctrMostrarData($tabla);
                  foreach ($registros as $data_d) {
                    echo "<option value='" . $data_d['Id_Categoria'] . "'>" . $data_d['Categoria'] . '</option>';
                  }
                  ?>
                </select>
                <input type="text" id="valorBaños" class="form3">
              </div>

              <div>
                <label for="" class="cajalabel2">Instalaciones</label>
                <select name="OtrasInsta" id="OtrasInsta">
                  <option value="" selected="" disabled="">Seleccione</option>
                  <?php
                  $tabla = 'categoria';
                  $registros = ControladorPredio::ctrMostrarData($tabla);
                  foreach ($registros as $data_d) {
                    echo "<option value='" . $data_d['Id_Categoria'] . "'>" . $data_d['Categoria'] . '</option>';
                  }
                  ?>
                </select>
                <input type="text" id="valorOtrasInsta" class="form3">
              </div>

            </fieldset>
          </div>

          <!-- Categorias del Piso -->
          <div class="row2 col-md-6">
            <div> <label for="" class="cajalabel2">Valor Unitario</label><input type="text" value="S/." class="form4" disabled><input type="text" name="valUnitariosCal" id="valUnitariosCal"></div>
            <!--<div> <label for="" class="cajalabel2">Incrementos</label><input type="text" value="S/." class="form4" disabled><input type="text" name="" id="" disabled="true"></div>-->
            <div> <label for="" class="cajalabel2">Tasa de Depreciacion</label><input type="text" name="tasaDepreCal" id="tasaDepreCal" class="form4" disabled="true"><input type="text" name="depresiacionInp" id="depresiacionInp"><input type="button" value="Depreciar" id="btnDepreciar" class="btn btn-info"></div>
            <div> <label for="" class="cajalabel2">Valor Unit. Depreciado</label><input type="text" value="S/." class="form4" disabled><input type="text" name="valUniDepreciadoImp" id="valUniDepreciadoImp"></div>
            <div> <label for="" class="cajalabel2">Area Construida</label><input type="text" value="m2" class="form4" disabled><input type="text" class="input_import" name="areaConstruidaImp" id="areaConstruidaImp"></div>
            <div> <label for="" class="cajalabel2">Valor Area Construida </label><input type="text" value="S/." class="form4" disabled><input type="text" name="valorAreaConstruImp" id="valorAreaConstruImp"></div>
            <div> <label for="" class="cajalabel2">Areas Comunes</label><input type="text" value="m2" class="form4" disabled><input type="text" name="areaComunesImp" id="areaComunesImp"></div>
            <div> <label for="" class="cajalabel2">Valores Areas Comunes</label><input type="text" value="S/." class="form4" disabled><input type="text" name="valorAreComunImp" id="valorAreComunImp"></div>
            <div> <label for="" class="cajalabel2">Valor de Construcion </label><input type="text" value="S/." class="form4" disabled><input type="text" name="valorConstrucionCal" id="valorConstrucionCal"></div>
          </div>

          <div class="modal-footer">
            <button type="button" id="salirRegistroModal" class="btn btn-secondary btn-cancelar">Salir</button>
            <button type="button" class="btn btn-primary" id="btnRegistrarPiso">Registrar</button>
          </div>
          <div class="row2 col-md-12" id="errorPiso">
            <!--CONTENIDO DINAMICO DE MENSAJE POR NO COMPLETAR CAMPOS -->
          </div>
        </form>
      </div>

    </div>
  </div>
</div>
</div>
<!--====== FIN DEL MODAL AGREGAR PISO ============-->
<!--====== MODAL EDITAR PISO =============-->
<div class="modal" id="modalEditarPiso">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <label class="modal-title"> EDITAR PISO</label>
      </div>
      <div class="modal-body">
        <form role="form" method="POST" enctype="multipart/form-data" class="formEditarPiso" id="formEditarPiso">
          <div class="row2"> <!--Datos del Predio-->
            <label class="cajalabel" for=""> Codigo Predio: </label>
            <input type="text" class="form2" name="idCatastroEdit" id="idCatastroEdit" disabled="true">
            <label class="cajalabel" for=""> Año Fiscal: </label>
            <input type="text" class="form2" name="anioFiscalEdit" id="anioFiscalEdit" disabled="true">
          </div>
          <div class="row"> <!--Datos del Piso-->
            <fieldset style="border: 1px dotted #000;">
              <div class="col-lg-5 col-md-6">
                <label class="cajalabel2">Estado Conservacion:</label>
                <select name="estadoConservaEdit" class="form2" id="estadoConservaEdit">
                  <option selected="" disabled="">Seleccione</option>
                  <?php
                  $tabla = 'estado_conservacion';
                  $registros = ControladorPredio::ctrMostrarData($tabla);
                  foreach ($registros as $data_d) {
                    echo "<option value='" . $data_d['Id_Estado_Conservacion'] . "'>" . $data_d['Nombre'] . '</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="col-lg-5 col-md-6">
                <label class="cajalabel2">Clasificacion Piso: </label>
                <select name="clasificaPisoEdit" class="form2" id="clasificaPisoEdit">
                  <option selected="" disabled="">Seleccione</option>
                  <?php
                  $tabla = 'clasificacion_piso';
                  $registros = ControladorPredio::ctrMostrarData($tabla);
                  foreach ($registros as $data_d) {
                    echo "<option value='" . $data_d['Id_Clasificacion_Piso'] . "'>" . $data_d['Nombre'] . '</option>';
                  }
                  ?>
                </select>
              </div>

              <div class="col-lg-5 col-md-6">
                <label class="cajalabel2">Numero Piso: </label>
                <input type="text" name="numeroPisoEdit" id="numeroPisoEdit" class="form2" disabled="true">
              </div>

              <!--<div class="col-lg-5 col-md-6">
                <label class="cajalabel2">Incrememto: </label>
                <input type="text" class="form2" value="1" disabled="true">
              </div> -->
              <div class="col-lg-5 col-md-6">
                <label class="cajalabel2">Años Antiguedad: </label>
                <input id="aniosAntiguedadEdit" name="aniosAntiguedadEdit" type="text" class="form2" disabled>
              </div>
              <div class="col-lg-5 col-md-6">
                <label class="cajalabel2">Material Predominante: </label>
                <select name="materialConsEdit" class="form2" id="materialConsEdit">
                  <option selected="" disabled="">Seleccione</option>
                  <?php
                  $tabla = 'material_piso';
                  $registros = ControladorPredio::ctrMostrarData($tabla);
                  foreach ($registros as $data_d) {
                    echo "<option value='" . $data_d['Id_Material_Piso'] . "'>" . $data_d['Nombre'] . '</option>';
                  }
                  ?>
                </select>
              </div>

              <div class="col-lg-5 col-md-6">
                <label class="cajalabel2">Antifuedad: </label>
                <input id="fechaAntiguedadEdit" name="fechaAntiguedadEdit" type="date" class="form2">
              </div>
            </fieldset>
          </div>
          <!-- Valores de Edificacion del Piso -->
          <div class="row2 col-md-6">
            <fieldset style="border: 1px dotted #000; padding: 5px;">
              <legend>Valores Unitarios de Edificacion</legend>
              <div>
                <label for="" class="cajalabel2">Muros y Columnas</label>
                <select name="murosColumnasEdit" id="murosColumnasEdit">
                  <option selected="" disabled="">Seleccione</option>
                  <?php
                  $tabla = 'categoria';
                  $registros = ControladorPredio::ctrMostrarData($tabla);
                  foreach ($registros as $data_d) {
                    echo "<option value='" . $data_d['Id_Categoria'] . "'>" . $data_d['Categoria'] . '</option>';
                  }
                  ?>
                </select>
                <input type="text" id="valorMurosEdit" class="form3" disabled="">
              </div>

              <div>
                <label for="techos" class="cajalabel2">Techos</label>
                <select name="techosEdit" id="techosEdit">
                  <option selected="" disabled="">Seleccione</option>
                  <?php
                  $tabla = 'categoria';
                  $registros = ControladorPredio::ctrMostrarData($tabla);
                  foreach ($registros as $data_d) {
                    echo "<option value='" . $data_d['Id_Categoria'] . "'>" . $data_d['Categoria'] . '</option>';
                  }
                  ?>
                </select>
                <input type="text" id="valorTechosEdit" class="form3" disabled="">
              </div>

              <div>
                <label for="" class="cajalabel2">Pisos</label>
                <select name="pisosEdit" id="pisosEdit">
                  <option selected="" disabled="">Seleccione</option>
                  <?php
                  $tabla = 'categoria';
                  $registros = ControladorPredio::ctrMostrarData($tabla);
                  foreach ($registros as $data_d) {
                    echo "<option value='" . $data_d['Id_Categoria'] . "'>" . $data_d['Categoria'] . '</option>';
                  }
                  ?>
                </select>
                <input type="text" id="valorPisosEdit" class="form3">
              </div>

              <div>
                <label for="" class="cajalabel2">Puertas y Ventanas</label>
                <select name="puertasVentanasEdit" id="puertasVentanasEdit">
                  <option selected="" disabled="">Seleccione</option>
                  <?php
                  $tabla = 'categoria';
                  $registros = ControladorPredio::ctrMostrarData($tabla);
                  foreach ($registros as $data_d) {
                    echo "<option value='" . $data_d['Id_Categoria'] . "'>" . $data_d['Categoria'] . '</option>';
                  }
                  ?>
                </select>
                <input type="text" id="valorPuertasyVentanasEdit" class="form3" disabled="">
              </div>

              <div>
                <label for="" class="cajalabel2">Revestimientos</label>
                <select name="revestimientoEdit" id="revestimientoEdit">
                  <option value="" selected="" disabled="">Seleccione</option>
                  <?php
                  $tabla = 'categoria';
                  $registros = ControladorPredio::ctrMostrarData($tabla);
                  foreach ($registros as $data_d) {
                    echo "<option value='" . $data_d['Id_Categoria'] . "'>" . $data_d['Categoria'] . '</option>';
                  }
                  ?>
                </select>
                <input type="text" id="valorRevestimientosEdit" class="form3">
              </div>

              <div>
                <label for="" class="cajalabel2">Baños</label>
                <select name="baniosEdit" id="baniosEdit">
                  <option value="" selected="" disabled="">Seleccione</option>
                  <?php
                  $tabla = 'categoria';
                  $registros = ControladorPredio::ctrMostrarData($tabla);
                  foreach ($registros as $data_d) {
                    echo "<option value='" . $data_d['Id_Categoria'] . "'>" . $data_d['Categoria'] . '</option>';
                  }
                  ?>
                </select>
                <input type="text" id="valorBaniosEdit" class="form3">
              </div>

              <div>
                <label for="" class="cajalabel2">Instalaciones</label>
                <select name="OtrasInstaEdit" id="OtrasInstaEdit">
                  <option value="" selected="" disabled="">Seleccione</option>
                  <?php
                  $tabla = 'categoria';
                  $registros = ControladorPredio::ctrMostrarData($tabla);
                  foreach ($registros as $data_d) {
                    echo "<option value='" . $data_d['Id_Categoria'] . "'>" . $data_d['Categoria'] . '</option>';
                  }
                  ?>
                </select>
                <input type="text" id="valorOtrasInstaEdit" class="form3">
              </div>

            </fieldset>
          </div>
          <!-- Categorias del Piso -->
          <div class="row2 col-md-6">
            <div> <label for="" class="cajalabel2">Valor Unitario</label><input type="text" value="S/." class="form4" disabled><input type="text" name="valUnitariosEdit" id="valUnitariosEdit" disabled=""></div>
            <!--<div> <label for="" class="cajalabel2">Incrementos</label><input type="text" value="S/." class="form4" disabled><input type="text" name="" id=""></div>-->
            <div> <label for="" class="cajalabel2">Tasa de Depreciacion</label><input type="text" name="tasaDepreEdit" id="tasaDepreEdit" class="form4" disabled><input type="text" name="depresiacionEdit" id="depresiacionEdit" disabled=""><input type="button" value="Depreciar" id="btnDepreciarEdit" class="btn btn-info"></div>
            <div> <label for="" class="cajalabel2">Valor Unit. Depreciado</label><input type="text" value="S/." class="form4" disabled><input type="text" name="valUniDepreciadoEdit" id="valUniDepreciadoEdit" disabled=""></div>
            <div> <label for="" class="cajalabel2">Area Construida</label><input type="text" value="m2" class="form4" disabled><input type="text" name="areaConstruidaEdit" id="areaConstruidaEdit"></div>
            <div> <label for="" class="cajalabel2">Valor Area Construida </label><input type="text" value="S/." class="form4" disabled><input type="text" name="valorAreaConstruEdit" id="valorAreaConstruEdit" disabled=""></div>
            <div> <label for="" class="cajalabel2">Areas Comunes</label><input type="text" value="m2" class="form4" disabled><input type="text" name="areaComunesEdit" id="areaComunesEdit" disabled=""></div>
            <div> <label for="" class="cajalabel2">Valores Areas Comunes</label><input type="text" value="S/." class="form4" disabled><input type="text" name="valorAreComunEdit" id="valorAreComunEdit" disabled=""></div>
            <div> <label for="" class="cajalabel2">Valor de Construcion </label><input type="text" value="S/." class="form4" disabled><input type="text" name="valorConstrucionEdit" id="valorConstrucionEdit" disabled=""></div>
          </div>
          <div class="modal-footer">
            <button type="button" id="btnSalirModalEditar" class="btn btn-secondary btn-cancelar">Salir</button>

            <button type="button" class="btn btn-primary" id="btnRegistrarEditar">Registrar Cambios</button>
          </div>
          <div class="row2 col-md-12" id="errorPiso">
            <!--CONTENIDO DINAMICO DE MENSAJE POR NO COMPLETAR CAMPOS -->
          </div>
        </form>
      </div>
      <div id="respuestaFechaEdit"></div>
    </div>
  </div>
</div>
<!--====== FIN DEL MODAL EDITAR PISO =============-->
<?php
        } else {
          echo "<div>error al cargar la pagina</div>";
        } ?>
<!--====== MODAL BUSCAR PROPIETARIO - LISTA PREDIOS-->
<div class="modal" id="modalPropietarios">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> BUSCAR PROPIETARIO</h5>
      </div>

      <div class="modal-body">
        <div class="col-12">
          <?php include_once "table-propietarios.php";  ?>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" id="cancelarModal" class="btn btn-secondary btn-cancelar" data-dismiss="modal">Salir</button>
        <button type="button" class="btn btn-primary btn-guardar" data-dismiss="modal">Guardar</button>
      </div>

    </div>
  </div>
</div>
<!--====== MODAL BUSCAR UBICACION PREDIO URBANO-->
<div class="modal" id="modalViacalle_Predioe">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> UBICACION DEL PREDIO</h5>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="clasificador_descripcion" class="bmd-label-floating">Localidad</label>
          <input type="text" class="form-control" name="localidad" id="localidad" maxlength="50" required="" disabled="" value="Puquio">
        </div>
        <div class="col-12">
          <?php include_once "table-viacallePredio.php";  ?>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" id="cancelarModal" class="btn btn-secondary btn-cancelar" data-dismiss="modal">Salir</button>
      </div>
    </div>
  </div>
</div>

<!-- MODAL CONFIRMAR LA TRANSFERENCIA SI O NO -->
<div class="modal fade" id="modal_transferir_si_no" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        CONFIRMAR TRANSFERIR PREDIO
      </div>
      <div class="modal-body">
        <h7>Estas Seguro Transferir el Predio ?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-primary confirmar_transferencia_si">si</button>
      </div>
    </div>
  </div>
</div>
<!-- FIN MODAL  CONFIRMAR TRANSFERENCIA SI O NO -->

<!-- MODAL CONFIRMAR LA COPIAR FORZOSAMENTE SI O NO -->
<div class="modal fade" id="modal_forzosamente_si_no" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        COPEAR PREDIO FORZOSAMENTE
      </div>
      <div class="modal-body">
        <h7>Estas Seguro de remplazar el Predio ?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-primary confirmar_copear_forzosamente_si">si</button>
      </div>
    </div>
  </div>
</div>
<!-- FIN MODAL  CONFIRMAR TRANSFERENCIA SI O NO -->




<!--=============== MODAL EDITAR CONTRIBUYENTE===============-->
<div id="modalEditarcontribuyente" class="modal fade modal-forms  fullscreen-modal" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form role="form" id="formEmpresa" method="post" enctype="multipart/form-data">
        <input type="hidden" name="idc" id="idc">
        <input type="hidden" name="iduc" id="iduc">
        <input type="hidden" name="idrc" id="idrc" value="true">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <caption>EDITAR CONTRIBUYENTE</caption>
        </div>
        <div class="modal-body">
          <div class="box-body">
            <div class="text-bordeada">
              <caption>Datos del Contribuyente</caption>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="" class="lbl-text">Tipo Contribuyente</label>
                <div class="input-group">
                  <select class="form-control" name="e_tipoContribuyente" id="e_tipoContribuyente" value="">
                    <?php
                    $tabla_tipo = 'tipo_contribuyente';
                    $tipo = ControladorContribuyente::ctrMostrarData($tabla_tipo);
                    foreach ($tipo as $data_tipo) {
                      echo "<option value='" . $data_tipo['Id_Tipo_Contribuyente'] . "'>" . $data_tipo['Tipo'] . '</option>';
                    }
                    ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="" class="lbl-text">Tipo Documento</label>
                <div class="input-group">
                  <select class="form-control" name="e_tipoDoc" id="e_tipoDoc">
                    <?php
                    $tabla_documento = 'tipo_documento_siat';
                    $documento = ControladorContribuyente::ctrMostrarData($tabla_documento);
                    foreach ($documento as $data_d) {
                      echo "<option value='" . $data_d['Id_Tipo_Documento'] . "'>" . $data_d['descripcion'] . '</option>';
                    }
                    ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label for="" class="lbl-text">N° Documento</label>
                <div class="input-group">
                  <input type="text" class="form-control" id="e_docIdentidad" name="e_docIdentidad" placeholder="Número de documento...">
                </div>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label for="" class="lbl-text">Cod. Antiguo</label>
                <div class="input-group">
                  <input type="text" class="form-control" id="e_codigo_sa" name="e_codigo_sa" placeholder="Codigo antiguo">
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="" class="lbl-text">Nombre o Razon social</label>
                <div class="input-group-adddon">
                  <input type="text" class="form-control" id="e_razon_social" name="e_razon_social" placeholder="Ingrese nombre o razón social...">
                </div>
              </div>
            </div>
            <div class="col-md-5">
              <div class="form-group">
                <label for="e_clasificacion" class="lbl-text">Clasificacion</label>
                <div class="input-group">
                  <select class="form-control" name="e_clasificacion" id="e_clasificacion" value="">
                    <?php
                    $tabla_cla = 'clasificacion_contribuyente';
                    $clasificacion = ControladorContribuyente::ctrMostrarData($tabla_cla);
                    foreach ($clasificacion as $data_cla) {
                      echo "<option value='" . $data_cla['Id_Clasificacion_Contribuyente'] . "'>" . $data_cla['Clasificacion'] . '</option>';
                    }
                    ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="" class="lbl-text">Apellido Paterno</label>
                <div class="input-group-adddon">
                  <input type="text" class="form-control" id="e_apellPaterno" name="e_apellPaterno" placeholder="Ingrese Apellido Paterno ...">
                  <!-- <span class="input-group-addon"></span>  -->
                </div>
              </div>
            </div>
            <div class="col-md-5">
              <div class="form-group">
                <label for="e_condicionContri" class="lbl-text">Condicion Contribuyente</label>
                <div class="input-group">
                  <select class="form-control" name="e_condicionContri" id="e_condicionContri" value="">
                    <?php
                    $tabla_cla = 'condicion_contribuyente';
                    $clasificacion = ControladorContribuyente::ctrMostrarData($tabla_cla);
                    foreach ($clasificacion as $data_cla) {
                      echo "<option value='" . $data_cla['Id_Condicion_Contribuyente'] . "'>" . $data_cla['Condicion_Contribuyente'] . '</option>';
                    }
                    ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="e_apellMaterno" class="lbl-text">Apellido Materno</label>
                <div class="input-group-adddon">
                  <input type="text" class="form-control" id="e_apellMaterno" name="e_apellMaterno" placeholder="Ingrese Apellido Materno ...">
                </div>
              </div>
            </div>


            <div class="col-md-5">
              <div class="row">
                <div class="col-md-6">
                <div class="form-group">
                <label for="e_apellMaterno" class="lbl-text">Coactivo</label>
                <div class="input-group">
                  <input type="checkbox" data-toggle="toggle" id="usuarioCoactivo" check="1" uncheck="0" data-size="mini" data-width="110">
                </div>
              </div>

                </div>

                <div class="col-md-6">
                    <div class="form-group">
                    <label for="e_afallecido" class="lbl-text">Fallecido</label>
                    <div class="input-group">
                      <input type="checkbox" data-toggle="toggle" id="usuarioFallecida" check="1" uncheck="0" data-size="mini" data-width="110">
                    </div>
                  </div>

                </div>

                  </div>
              
              
            </div>

            
          </div>


          <div class="box-body">
            <div class="row nuevoVia">

              <div class="text-bordeada">
                <caption>Domicilo Fiscal del Contribuyente</caption>
                <button type="button" class="pull-right boton-direccion" data-toggle="modal" data-target="#modalViascalles">Direccion<img src='./vistas/img/iconos/direccion4.png' class="icon-direccion pull-right"></button>
              </div>
            </div>
            <div class="row">
              <div class="items-c">
                <table class="table-container" style="box-sizing: border-box;">
                  <thead>
                    <tr>
                      <th class="text-center">Nombre Via</th>
                      <th class="text-center">Manzana</th>
                      <th class="text-center">Cuadra</th>
                      <th class="text-center">Lado</th>
                      <th class="text-center">Zona</th>
                      <th class="text-center">Habilitacion</th>
                      <th class="text-center">Cod. Via</th>
                    </tr>
                  </thead>
                  <tbody id="itemsRC">
                  </tbody>
                </table>
              </div>
            </div>
            <div class="row">
              <div class="col-md-2">
                <label for="" class="lbl-text">Numeracion</label>
                <div class="form-group">
                  <input type="text" class="form-control" id="e_nroUbicacion" name="e_nroUbicacion" placeholder="Nro. Ubicacion...">
                </div>
              </div>
              <div class="col-md-2">
                <label for="" class="lbl-text">N° Lote</label>
                <div class="form-group">
                  <input type="text" class="form-control" id="e_nroLote" name="e_nroLote" placeholder="Nro. Lote ...">
                </div>
              </div>
              <div class="col-md-2">
                <label for="e_nroDepartamento" class="lbl-text">N° Dept.</label>
                <div class="form-group">
                  <input type="text" class="form-control" id="e_nroDepartamento" name="e_nroDepartamento" placeholder="Nro. Departamento...">
                </div>
              </div>
              <div class="col-md-2">
                <label for="e_nrobloque" class="lbl-text">N° Bloque</label>
                <div class="form-group">
                  <input type="text" class="form-control" id="e_nrobloque" name="e_nrobloque" placeholder="Nro. Bloque...">
                </div>
              </div>
              <div class="col-md-2">
                <label for="e_nroLuz" class="lbl-text">N° Luz</label>
                <div class="form-group">
                  <input type="text" class="form-control" id="e_nroLuz" name="e_nroLuz" placeholder="Nro. Recibo Luz...">
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <label for="e_referencia" class="lbl-text">Referencia</label>
              <div class="form-group">
                <input type="text" class="form-control" id="e_referencia" name="e_referencia" placeholder="Referencia...">
              </div>
            </div>
            <div class="col-md-4 col-xs-3">
              <div class="form-group">
                <label for="e_condicionpredio" class="lbl-text">Cond. Propietario</label>
                <div class="input-group">
                  <select class="form-control" name="e_condicionpredio" id="e_condicionpredio" value="">
                    <?php
                    $tabla = 'condicion_predio_fiscal';
                    $condicion = ControladorContribuyente::ctrMostrarData($tabla);
                    foreach ($condicion as $data_c) {
                      echo "<option value='" . $data_c['Id_Condicon_Predio_Fiscal'] . "'>" . $data_c['Descripcion'] . '</option>';
                    }
                    ?>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="box-body">

            <div class="text-bordeada">
              <caption>Datos de Contacto</caption>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label for="" class="lbl-text">N° Celular</label>
               
                <input type="text" class="form-control" style="transition: all 0.5s ease; border-radius: 5px;" id="e_telefono" name="e_telefono" placeholder="celular...">
              
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="" class="lbl-text">Correo</label>
                <div class="input-group-adddon">
                  <input type="text" class="form-control" style="transition: all 0.5s ease; border-radius: 5px;"  id="e_correo" name="e_correo" placeholder="Correo Electronico...">
                </div>
              </div>
            </div>
            <div class="col-md-7">
              <div class="form-group">
                <label for="" class="lbl-text">Observaciones</label>
                <div class="input-group-adddon">
                  <input type="text" class="form-control" id="e_observacion" name="e_observacion" placeholder="Observacioenes...">
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <label class="btn btn-danger pull-left" data-dismiss="modal">Salir</label>
          <button type="sudmit" class="btn btn-primary">Guardar cambios</button>
        </div>
        <?php
        //  $editarProducto = new ControladorContribuyente();
        //  $editarProducto->ctrEditarContribuyente();
        ?>
      </form>
    </div>
  </div>
</div>
<!--FIN DE MODAL EDITAR CONTRIBUYENTE -->

<!-- editar direccion del contribuyente -->
<div class="modal fade bd-example-modal-lg" id="modalViascalles" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <caption>DIRECCION FISCAL</caption>
      </div>
      <div class="modal-body table-responsive">
        <div class="row">
          <div class="contenedor-busqueda">
            <div class="input-group-search">
              <div class="input-search">
                <input type="search" class="search_direccion" id="searchViacalle" name="searchViacalle" placeholder="Ingrese Nombre de Via o Calle..." onkeyup="loadViacalle(1,'#itemsRC')">
                <input type="hidden" id="perfilOculto_v" value="<?php echo $_SESSION['perfil'] ?>">
              </div>
            </div>
          </div>
        </div>
        <div class="col-12 divDetallePredio">
          <?php include_once "table-viacalle.php";  ?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Salir</button>
          <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
        </div>

      </div>
    </div>
  </div>
</div>
<!-- fin de editar direccion de contribuyente -->

<!--====== MODAL ORDEN DE PAGO -->
<div class="modal fade " id="modalOrdenPago" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        ORDEN DE PAGO 
      </div>
      <div class="modal-body">

        <section class="container-fluid panel-medio ">
          <div class="box rounded table-responsive">
            <div class="row">
              <div class="col-md-12 " style="padding-left: 0;padding-right: 0;">
                <div class="col-md-5 " >

                <div class="col-md-12" style="padding-left: 0;padding-right: 0;">
                  
                <input type="hidden" id="area_oculta" name="area_oculta" value="">
                






              </div>


                </div>

              

                <div class="col-md-7">

                
               
                  <select class="busqueda_filtros pull-right" id="select_tributo_orden" name="select_tributo_orden">
                    <option value='006'>Impuesto Predial</option>
                    <option value='742'>Arbitrio Municipal</option>
                    ?>
                  </select>
                  <select class="busqueda_filtros pull-right" id="anio_orden" name="anio_orden">
                    <?php
                    $anio = ControladorPredio::ctrMostrarDataAnio();
                    foreach ($anio as $data_anio) {
                      $selected = ($anio_propietario == $data_anio['NomAnio']) ? 'selected' : '';
                      echo "<option value='" . $data_anio['Id_Anio'] . "' $selected>" . $data_anio['NomAnio'] . '</option>';
                    }
                    ?>
                  </select>

                 
                </div>
              </div>
              <div class="col-md-12">
                <div class="box divDetallePredio">

                  <table class="table-container miprimeratabla" id="primeraTabla_caja">
                    <thead>
                      <tr>
                        <th class="text-center" style="width:100px;">Cod.</th>
                        <th class="text-center" style="width:200px;">Tributo</th>
                        <th class="text-center" style="width:100px;">Año</th>
                        <th class="text-center" style="width:100px;">Periodo</th>
                        <th class="text-center" style="width:100px;">Importe</th>
                        <th class="text-center" style="width:100px;">Gasto</th>
                        <th class="text-center" style="width:100px;">Subtotal</th>
                        <th class="text-center" style="width:100px;">T.I.M</th>
                        <th class="text-center" style="width:100px;">Total</th>
                      </tr>
                    </thead>
                    <tbody id="estadoCuenta" class="scrollable estadocuentaorden">
                      <!-- Aqui Aparecen los estado de cuenta-->
                    </tbody>
                  </table>

                </div>

                <!-- segunda tabla donde muestra el boton imprimir y el total del estado de cuenta-->
                <table class="table-container" id="segundaTabla_orden" class="table table-bordered">
                  <tbody>
                    <tr>
                      <th class="text-right td-round" style="width:550px;">Total Deuda = </th>
                      <th class="text-center td-round" style="width:100px;" id="importe_o"></th>
                      <th class="text-center td-round" style="width:100px;" id="gasto_o"></th>
                      <th class="text-center td-round" style="width:100px;" id="subtotal_o"></th>
                      <th class="text-center td-round" style="width:100px;" id="tim_o"></th>
                      <th class="text-center td-round" style="width:100px;" id="total_o"></th>

                    </tr>
                  </tbody>
                </table>

              </div>
              <!--FIN DETALLE ESTADO CUENTA-->


            </div>
          </div>
        </section>
      </div>
      <div class="modal-footer">
      <div class="row">
      <div class="col-md-12 " style="padding-left: 0;padding-right: 0;">
      
      <!-- HTML con el select y los botones -->
      <div class="col-md-5" style="display: flex; flex-direction: row; align-items: center; gap: 10px;">
   
   
      <select class="select-elegante historialOrdenPago" name="select_tributo_orden_h" id="select_tributo_orden_h" style="width: 60%; text-align: left;">
      </select>


    <!-- Botones para Modificar y Borrar, inicialmente ocultos -->
    <button type="button " id="modificarBtn"  class="btn-elegante mostrar-btn" style="display: none;">Mostrar</button>
  
    <button type="button" id="borrarBtn"  class="btn-elegante " style="display: none;">Borrar</button>



  </div>

      <div class="col-md-7 " >


     
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
        <button type="button" class="btn btn-primary btnOrdenPago">Imprimir Orden</button>
      </div>
      </div>
      </div>

      </div>
    </div>
  </div>
  
</div>






<!--====== FIN DEL MODAL ORDEN DE PAGO =======-->

<!-- modal donde se genera el pdf oden pago - impuesto-->
<div class="container-fluid">
  <div class="modal in" id="Modal_Orden_Pago" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-fullscreen">
      <div class="modal-content">
        <div class="modal-body printerhere">
          <iframe id="iframe_orden_pago" class="iframe-full-height"><!-- Muestra el PDF --></iframe>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary cerrar-modal">Close</button>
        <!--  <button type="button" class="btn btn-secondary cerrar-modal" data-dismiss="modal">Close</button> -->
        </div>
      </div>
    </div>
  </div>
</div>
<!-- fin de generar pdf oden pago - impuesto-->


<!-- MODAL MOSTRAR PAGADO -->

<!-- MODAL MOSTRAR PAGADO -->
<div class="modal fade" id="modal_pagado_estado_cuenta" tabindex="-1" aria-labelledby="modalPagadoLabel" aria-hidden="true" style="z-index: 99999 !important;">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
     
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
     
      <div class="modal-body text-center">
        <i class="bi bi-exclamation-circle" style="color: red; font-size: 48px;"></i>
        <p>¿Está seguro de cambiar el estado a "Pagado"?</p>

        <input type="hidden" id="idEstadoPagado" value="">

        <p><strong>Código:</strong> <span id="modelTipoPagado"></span></p>
        <p><strong>Año:</strong> <span id="modalAnioPagado"></span></p>
        <p><strong>Periodo:</strong> <span id="modalPeriodoPagado"></span></p>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-danger btnConfirmarPagado">Pagado</button>
      </div>
    </div>
  </div>
</div>



<!-- MODAL ELIMINAR ESTADO DE CUENTA-->

<!-- MODAL ELIMINAR ESTADO DE CUENTA -->

<!-- MODAL ELIMINAR ESTADO DE CUENTA -->
<div class="modal fade" id="modal_eliminar_estado_cuenta" tabindex="-1" aria-labelledby="modalEliminarLabel" aria-hidden="true" style="z-index: 99999 !important;">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      
      <div class="modal-body text-center">
        <i class="bi bi-exclamation-circle" style="color: red; font-size: 48px;"></i>
        <p>¿Está seguro que desea eliminar este estado de cuenta?</p>

        <input type="hidden" id="idEstado" value="">

        <p><strong>Código:</strong> <span id="modelTipo"></span></p>
        <p><strong>Año:</strong> <span id="modalAnio"></span></p>
        <p><strong>Periodo:</strong> <span id="modalPeriodo"></span></p>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-danger btnConfirmarEliminar">Eliminar</button>
      </div>
    </div>
  </div>
</div>





<!-- MODAL ELIMINAR PISO -->
<div class="modal fade" id="modal_eliminar_piso" data-backdrop="true" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 99999 !important;">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-body">
        <div class="row">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="row">
          <div class="col-xs-12 text-center">
            <i class="bi bi-exclamation-circle" style="color: red; font-size: 48px;"></i>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 text-center">
            <h7>¿Estás seguro de que deseas eliminar este piso?</h7>
          </div>
        </div>
      </div>
      <div class="modal-footer" style="display: flex; justify-content: center; align-items: center;">
        <button type="button" class="btn btn-primary" id="confirmarEliminarPiso">Sí, Eliminar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>




<!-- MODAL CUANOD EL COACTIVO ESTA VACIO-->
<div class="modal fade" id="modal_vacio_coactivo" data-backdrop="true" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 99999 !important;">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      
      <div class="modal-body">

      <div class="row">

      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="row">
        <div class="col-xs-12 text-center">
          <i class="bi bi-exclamation-circle" style="color: red; font-size: 48px;"></i>
        </div>
      </div>


      <div class="row">
        <div class="col-xs-12 text-center">
          
          <h7> Al menos debe elegir una fila <span id="anio_formato"><!-- CONTENIDO DINAMICO--></span></h7>
        </div>
      </div>
      </div>
      
      <div class="modal-footer" style=" display: flex; justify-content: center; align-items: center;">
    <button type="button" class="btn btn-primary print_orden_coactivo_aviso">OK</button>
</div>


    </div>
  </div>
</div>




<!-- MODAL CONFIRMAR LA IMPRESION DEL ORDEN PAGO -->
<div class="modal fade" id="modalImprimir_ordenpago_si_no" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="staticBackdropLabel">Imprimir Orden Pago</h5>
      </div>
      <div class="modal-body">
        <h7>Estas Seguro de Generar Orden de Pago desde el año <span id="anio_formato"><!-- CONTENIDO DINAMICO--></span>?</h7>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-primary print_orden_pago">si</button>
      </div>
    </div>
  </div>
</div>
<!-- FIN MODAL PARA CUARGAR SI O NO ORDEN DE PAGO -->

<!-- MODAL PARA CONFIRMAR ELIMINAR -->f
<div class="modal fade" id="modalEliminar_ordenpago_si_no" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="staticBackdropLabel">Imprimir Orden Pago</h5>
      </div>
      <div class="modal-body">
        <h7>Estas Seguro de eliminar generar orden de Pago  <span id="anio_formato"><!-- CONTENIDO DINAMICO--></span>?</h7>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-primary eliminar_orden_pago_si">si</button>
      </div>
    </div>
  </div>
</div>
<!-- FIN MODAL PARA CUARGAR SI O NO ORDEN DE PAGO -->





<!--====== MODAL ESTADO DE CUENTA -->
<div class="modal fade" id="modalEstadoCuenta" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        Estado de Cuenta i
      </div>
      <div class="modal-body">

        <section class="container-fluid panel-medio ">
          <div class="box-body table-responsive">

            <div class="col-md-12">
              Estdo de Cuenta + Tasa de Interes Moratorio (TIM)
            </div>

            <div id="contenedor" data-idarray='<?php echo json_encode(array_values($idArray)); ?>'></div>


            <div class="box divDetallePredio">
              <table class="table-container" id="primeraTabla">

                <thead>
                  <tr>
                    <th class="text-center tdBotonese" style="display:none;" style="width:10px;">Acciones</th>
                    <th class="text-center" style="width:50px;">Cod.</th>
                    <th class="text-center" style="width:100px;">Tributo</th>
                    <th class="text-center" style="width:50px;">Año</th>
                    <th class="text-center" style="width:50px;">Periodo</th>
                    <th class="text-center" style="width:50px;">Importe</th>
                    <th class="text-center" style="width:50px;">Gasto</th>
                    <th class="text-center" style="width:50px;">Subtotal</th>
                    <th class="text-center" style="width:50px;" id="des_es">Descuento</th>
                    <th class="text-center" style="width:50px;">T.I.M</th>
                    <th class="text-center" style="width:50px;">Total</th>
                    <th class="seleccionado text-center" style="width:30px;">S</th>
                  </tr>
                </thead>

                <tbody id="estadoCuenta" class="scrollable">
                  <!-- Aqui Aparecen los estado de cuenta-->
                  <?php
                  $estado_cuenta = ControladorEstadoCuenta::ctrEstadoCuenta($idArray, "estadocuenta"); ?>

                </tbody>
              </table>
            </div>
          </div>
          <!-- segunda tabla donde muestra el boton imprimir y el total del estado de cuenta-->

          <!-- segunda tabla donde muestra el boton imprimir y el total del estado de cuenta-->
          <table class="table-container" id="segundaTabla">
            <tbody>
              <th class="text-center" style="width:20px;">
              </th>
              <!-- no eliminar los Td-->
              <th class="text-right td-round total_c" style="width:100px;">Total Deuda =</th>
             
              <th class="text-center td-round" style="width:30px;"></th>
              <th class="text-center td-round" style="width:30px;"></th>
              <th class="text-center td-round" style="width:30px;"></th>
              <th class="text-center td-round" style="width:30px;"></th>
              <th class="text-center rd-round" style="width:30px;"></th>
              <th class="text-center rd-round" style="width:30px;"></th>
              
            </tbody>
          </table>




        </section>
      </div>
      <div class="modal-footer">

      <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>

        <button type="button" class="btn btn-info" id="editarEsatdoCuentaDeuda">Editar</button>

        
        <button type="button" class="btn btn-success" id="enviarWhapsApp">Inviar whapsApp</button>
        <button type="button" class="btn btn-primary" id="popimprimir">Imprimir Estado Cuenta</button>
      </div>
    </div>
  </div>
</div>
<!--FIN DETALLE ESTADO CUENTA-->


<!--====== MODAL ESTADO DE CUENTA COACTIVO-->
<div class="modal fade" id="modalEstadoCuentaC" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                Estado de Cuenta para coactivo
            </div>
            <div class="modal-body" style="padding: 0;">
                <!-- Ajustamos el estilo del cuerpo del modal a 100% -->
                <section class="container-fluid panel-medio">
                    <div class="box-body table-responsive" style="width: 100%; overflow-x: auto;">

                       

                    <div class="row " style="margin-bottom: 8px;">
                      <div class="col-md-8 pl-0 pr-0"> <!-- Quité el padding de izquierda y derecha -->
                          Estado de Cuenta + Tasa de Interés Moratorio (TIM)
                      </div>
                      <div class="col-md-4 pl-0 pr-0">
                      <!-- <select class="busqueda_filtros pull-right" id="select_tributo_orden" name="select_tributo_orden">
                          <option value="trimestre">Trimestre</option>
                          <option value="anios">Años</option>
                      </select> -->

                      <select class="busqueda_filtros pull-right" id="anio_orden_coactivo" name="select_tributo_orden">
                        <?php
                        $anio = [
                            ["Id_Anio" => "trimestre", "NomAnio" => "Trimestre"],
                            ["Id_Anio" => "anio", "NomAnio" => "Año"]
                          
                        ];

                        // Usamos un ciclo para generar las opciones del select
                        foreach ($anio as $data_anio) {
                            // Aquí se evalúa si la opción debe estar seleccionada
                            $selected = ($anio_propietario == $data_anio['NomAnio']) ? 'selected' : '';
                            echo "<option value='" . $data_anio['Id_Anio'] . "' $selected>" . $data_anio['NomAnio'] . "</option>";
                        }
                        ?>
                    </select>


                  
                  </div>

                  </div>


                        <div class="box divDetallePredio">
                            <!-- Hacemos la tabla de ancho completo <th class="seleccionado text-center" style="width:20px; padding: 0;">
                                        <input type="checkbox" style="width:15px; height:15px; margin: 0;" id="selectAll">
                                    </th> -->
                                    <table class="table-container " id="primeraTablac" style="width: 100%;">
                                <thead>
                                    <tr   >
                                    <th class="seleccionado text-center" style="width:20px; padding: 0; cursor:pointer">
            S
        </th>

                                        <th class="text-center" style="width:50px;">Cod.</th>
                                        <th class="text-center" style="width:100px;">Tributo</th>
                                        <th class="text-center" style="width:50px;">Año</th>
                                        <th class="text-center" style="width:50px;">Periodo</th>
                                        <th class="text-center" style="width:50px;">Importe</th>
                                        <th class="text-center" style="width:50px;">Gasto</th>
                                        <th class="text-center" style="width:50px;">Subtotal</th>
                                        <th class="text-center" style="width:50px;" id="des_es">Descuento</th>
                                        <th class="text-center" style="width:50px;">T.I.M</th>
                                        <th class="text-center" style="width:50px;">Total</th>
                                      
                                    </tr>
                                </thead>

                                <tbody id="estadoCuenta" class="scrollable estadocuentacoactivo">
                                  <!-- Aqui Aparecen los estado de cuenta-->
                                </tbody>
                                 
                                <!-- <tbody id="estadocuentaC" class="scrollable">
                                 
                                    <?php
                                   // $estado_cuenta = ControladorEstadoCuenta::ctrEstadoCuentaCA($idArray, "estadocuentaC");
                                    
                                    ?>
                               <!--  </tbody> -->



                            </table>
                        </div>
                    </div>
                    <table class="table-container" id="segundaTablac" style="width: 100%;">
                      <tbody>
                          <tr>
                          <td class="text-center" style="width:40px;"></td>
                          <td class="text-right td-round total_c" style="width:150px; font-weight: bold;">Total Deuda</td>
                          <td class="text-left td-round total_c" style="width:50px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:45px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:45px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:44px; font-weight: bold;"></td>
                          <td class="text-center td-round" style="width:55px; font-weight: bold;"></td>
                          <td class="text-center rd-round" style="width:43px; font-weight: bold;"></td>
                          <td class="text-center rd-round" style="width:58px; font-size:16px; font-weight: bold;"></td>
                          </tr>
                      </tbody>
                  </table>

                    <!-- Segunda tabla donde muestra el botón imprimir y el total del estado de cuenta-->
                    <!-- <table class="table-container" id="segundaTablac" style="width: 100%;">
                        <tbody>
                            <th class="text-center" style="width:40px;"></th>
                            <th class="text-right td   -round total_c" style="width:150px;">Total Deuda </th>
                            <th class="text-left td-round total_c" style="width:50px;"></th>
                            <th class="text-center td-round" style="width:45px;"></th>
                            <th class="text-center td-round" style="width:45px;"></th>
                            <th class="text-center td-round" style="width:44px;"></th>
                            <th class="text-center td-round" style="width:55px;"></th>
                            <th class="text-center rd-round" style="width:43px;"></th>
                            <th class="text-center rd-round" style="width:58px; font-size:16px;"></th>
                        </tbody>
                    </table> -->

                </section>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
                <button type="button" class="btn btn-primary " id="popimprimircoactiva">Imprimir coactivo</button>
      
            </div>
        </div>
    </div>
</div>
<!--FIN DETALLE ESTADO CUENTA-->






<!--====== MODAL PAGOS REALIZADOS DE IMPUESTO Y ARBITRIOS -->
<div class="modal fade " id="modalPagosImpuestoArbitrios" tabindex="-2" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        Pagos Realizados
      </div>
      <div class="modal-body">

        <section class="container-fluid panel-medio ">
          <div class="box rounded table-responsive">
            <div class="row">
              <div class="col-md-12">

                Estado Cuenta Pagos de Impuesto - Arbitrios

              </div>
              <div class="col-md-12">
                <div class="box divDetallePredio">
                  <table class="table-container" id="primeraTabla_reporte_pagados_IA">

                    <thead>
                      <tr>
                        <th class="text-center" style="width:30px;">Cod.</th>
                        <th class="text-center" style="width:70px;">Tributo</th>
                        <th class="text-center" style="width:30px;">Año</th>
                        <th class="text-center" style="width:30px;">Periodo</th>
                        <th class="text-center" style="width:100px;">Fecha Pago</th>
                        <th class="text-center" style="width:50px;">Estado</th>
                        <th class="text-center" style="width:50px;">Importe</th>
                        <th class="text-center" style="width:50px;">Gasto M</th>
                        <th class="text-center" style="width:50px;">Subtotal</th>
                        <th class="text-center" style="width:50px;">T.I.M</th>
                        <th class="text-center" style="width:50px;">Total</th>
                        <th class="seleccionado text-center" style="width:20px;">S</th>
                      </tr>
                    </thead>
                    <tbody id="estadoCuenta" class="scrollable">
                      <!-- Aqui Aparecen los estado de cuenta-->
                      <?php
                      $estado_cuenta = ControladorEstadoCuenta::ctrEstadoCuenta_Pagado($idArray, "estadocuenta"); ?>
                    </tbody>
                  </table>
                </div>
                <!-- segunda tabla donde muestra el boton imprimir y el total del estado de cuenta-->
                <table class="table-container" id="segundaTabla_reporte_pagados_IA">
                  <tbody>
                    <th class="text-right td-round total_c" style="width:330px;">Total Pagado =</th>
                    <th class="text-center td-round" style="width:50px;"></th>
                    <th class="text-center td-round" style="width:50px;"></th>
                    <th class="text-center td-round" style="width:50px;"></th>
                    <th class="text-center" style="width:50px;"></th>
                    <th class="text-center" style="width:50px;"></th>
                    <th class="text-center" style="width:20px;"></th>
                  </tbody>
                </table>

              </div>
            </div>
          </div>
        </section>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
        <button type="button" class="btn btn-primary" id="popimprimir_estadoCuentapagados">Imprimir Pagos</button>
      </div>

    </div>
  </div>
</div>
<!--FIN DE PAGOS REALIZADOS DE IMPUESTO Y ARBITRIOS-->



<!-- modal de imprimir estado cuenta -->
<div class="container-fluid">
  <div class="modal in" id="Modalimprimir_cuenta_coactivo" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-fullscreen">
      <div class="modal-content">
        <div class="modal-header">
        </div>
        <div class="modal-body printerhere">
          <iframe id="iframec" class="iframe-full-height"></iframe>


        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- fin de imprimir estado de cuenta-->



<!-- modal de imprimir estado cuenta -->
<div class="container-fluid">
  <div class="modal in" id="Modalimprimir_cuenta" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-fullscreen">
      <div class="modal-content">
        <div class="modal-header">
        </div>
        <div class="modal-body printerhere">
          <iframe id="iframe" class="iframe-full-height"></iframe>


        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- fin de imprimir estado de cuenta-->


<!-- SECCION DE CALCULAR IMPUESTO - FORMATOS Y TIM -->
<div class="modal fade" id="modal_predio_propietario" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content modal-content-e">
      <div class="modal-body">
        <table class="table-container">
          <thead>
            <th class="text-center">Calcular Impuesto-Arbitrios</th>
            <th class="text-center">Imprimir Formatos</th>
            <th class="text-center">Calcular TIM</th>
          </thead>
          <tbody class="m_predio_propietario">
            <tr>
              <th class="text-center"> <img src="./vistas/img/iconos/calcular_impuesto.png" class="t-icon-tbl-imprimir btnCalcular_impuesto" title="Calcular Impuesto"></th>
              <th class="text-center"> <img src="./vistas/img/iconos/FORMATO.png" class="t-icon-tbl-imprimir btnImprimir_cartilla" title="Imprimir Formato" data-toggle="modal" data-target="#modalImprimirFormato"></th>
              <th class="text-center"> <img src="./vistas/img/iconos/PORCENTAJE.png" class="t-icon-tbl-imprimir_tim btnCalcularTim_img" title="Calcular T.I.M" data-toggle="modal" data-target="#modalCalcularTim"></th>
            </tr>

          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
      </div>

    </div>
  </div>
</div>
<!-- CALCULAR IMPUESTO SECCION DE ICONOS FIN -->


<div class="modal fade" id="modal_foto" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="border-radius: 10px; box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);">
      <!-- Encabezado del modal con color suave y texto centrado -->
      <div class="modal-header" style="background-color: #6c757d; color: white; border-top-left-radius: 10px; border-top-right-radius: 10px;">
        <h4 class="modal-title" id="exampleModalCenterTitle" style="text-align: center;">Gestionar Foto</h4>
      </div>

      <!-- Cuerpo del modal con contenido y espacio más organizado -->
      <div class="modal-body" style="padding: 25px; text-align: center;">
        <p style="font-size: 18px; font-weight: 500; color: #555;">Sube tu imagen (máximo 1)</p>
        
        <!-- Input de imagen con estilo sencillo y moderno -->
        <input type="file" id="imageInput" accept="image/*" capture="environment" 
               class="form-control" >
        
        <!-- Contenedor para las imágenes subidas -->
        <div class="image-container" id="imageContainer" style="margin-top: 20px; text-align: center;"></div>
      </div>

      <!-- Pie del modal con botones con bordes suaves -->
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
        <button type="button" class="btn btn-primary" id="popiguardarfoto">Guardar</button>
      </div>
    </div>
  </div>
</div>

<!-- SECCION DE FOTO-->
<!-- <div class="modal fade" id="modal_foto" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content modal-content-e">
      <div class="modal-header">
        Gestionar Fotos
      </div>
      <div class="modal-body">
        <span>Sube tus imágenes (máximo 3)</span>
        <input type="file" id="imageInput"  accept="image/*" capture="environment" >
       
      
       <div class="image-container" id="imageContainer"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
        <button type="button" class="btn btn-primary" id="popiguardarfoto">Guardar</button>
      </div>
    </div>
  </div>
</div> -->
<!-- FIN DE SECCION DE FOTO -->


<!-- SECCION DE FOTO-->
<div class="modal fade" id="modal_foto_ver" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content modal-content-e">
      <div class="modal-body">
        <div class="row div_fotos">
          <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
            </ol>
            <div class="carousel-inner">
            </div>
            <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
              <span class="glyphicon glyphicon-chevron-left"></span></a><a class="right carousel-control"
              href="#carousel-example-generic" data-slide="next"><span class="glyphicon glyphicon-chevron-right">
              </span></a>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
      </div>
    </div>
  </div>
</div>
<!-- FIN DE SECCION DE FOTO -->



<!-- modal cargando -->
<?php include_once "proceso-calcular-impuesto.php";  ?>
<!-- fin de modal cargando-->

<!-- modal cargando -->
<?php include_once "modalcargar.php";  ?>
<!-- fin de modal cargando-->