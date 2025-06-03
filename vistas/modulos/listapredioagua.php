<?php

use Controladores\ControladorPredio;
use Controladores\ControladorContribuyente;
?>
<?php
$idParam = $_GET['id'];
// Divide el valor en un array utilizando el guion (-) como delimitador
$idArray = explode('-', $idParam);
// Elimina elementos vacíos (por ejemplo, si hay varios guiones juntos)
$idArray = array_filter($idArray);
// Ahora $idArray contiene los valores sin guiones
?>
<div class="content-wrapper panel-medio-principal">


  <section class="container-fluid panel-medio">



    <div class="box container-fluid" style="border:0px; margin-bottom:3px; padding:0px;">


     <div class="progress" style="width: 100%; height: 10px; border: 0; margin: 0;">
          <?php
              // Capturar datos del contribuyente una sola vez
             // $datos_contribuyente = ControladorContribuyente::CntrVerificar_Parametro_agua($idArray);

                $datos_contribuyente = ControladorContribuyente::CntrVerificar_Parametro($idArray);

              //  var_dump($datos_contribuyente);
           //tu sabes que te amo a ti  por eso te dire estas junto ami 
                 //inicializamos estas formas de vida en la planeta tierra 
                 //los humanos venimos de la planera diferente es la u
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


         
    // $porcentaje = 0;
    // $color = '#ccc';

    // if (!empty($datos_contribuyente)) {
    //     // Obtener el primer elemento del array (sin importar la clave)
    //     $primer_contribuyente = reset($datos_contribuyente); // array con índice 0 => datos
    //     if (!empty($primer_contribuyente) && isset($primer_contribuyente[0]['Estado_progreso'])) {
    //         $estado_progreso = $primer_contribuyente[0]['Estado_progreso'];

    //         if ($estado_progreso === 'P') {
    //             $porcentaje = 30;
    //             $color = 'rgb(255, 193, 7)';
    //         } elseif ($estado_progreso === 'E') {
    //             $porcentaje = 60;
    //             $color = 'rgb(23, 162, 184)';
    //         } elseif ($estado_progreso === 'C') {
    //             $porcentaje = 100;
    //             $color = 'rgb(40, 167, 69)';
    //         } elseif ($estado_progreso === NULL) {
    //             $porcentaje = 0;
    //             $color = '#ccc';
    //         }
    //     }
    // }
            
              

          ?>

     <div class="progress-bar" role="progressbar" style="width: <?php echo $porcentaje; ?>%; height: 100%; background-color: <?php echo $color; ?>; display: flex; justify-content: center; align-items: center; color: white; font-weight: bold; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);">
        <?php echo $porcentaje . '%'; ?>
    </div>

      </div>
      

   



      <div class="col-lg-6 col-xs-6">
        <?php
       // $datos_contribuyente = ControladorContribuyente::CntrVerificar_Parametro($idArray);

        if (count($datos_contribuyente) > 0) {
        ?>

          <div id="respuestaAjax_correcto"></div> <!-- eliminar predios -->

          <table class="miTabla_propietarios">
            <caption>Propietarios jj</caption>
            <div style="display: flex; justify-content: flex-end; align-items: center; width: 100%; margin-bottom: 0.3rem; margin-top: 0.3rem;">
            <button class="bi bi-bar-chart btn btn-secundary btn-sm" id="editar_progreso_agua">
            Editar progreso
          </button>
          </div>
            <thead>
              <th class="text-center">Codigo</th>
              <th class="text-center">Documento</th>
              <th class="text-center">Nombres</th>
              <th class="text-center">Direccion</th>
              <th class="text-center">codigo SIAT</th>
            </thead>
            <tbody id="id_propietarios">
              <?php foreach ($datos_contribuyente as $valor => $filas) {
                foreach ($filas as $fila) {
                  echo '<tr id="fila"  id_contribuyente="' . $fila['Id_Contribuyente'] . '">
                       <td class="text-center" id="id_contribuyente_pro"  >' . $fila['Id_Contribuyente'] . '</td>   
                      <td class="text-center"  >' . $fila['Documento'] . '</td>
                      <td class="text-center">' . $fila['Nombre_Completo'] . '</td>
                      <td class="text-center">' . $fila['Direccion_completo'] . '</td>
                      <td class="text-center">' . $fila['Codigo_sa'] . '</td>';
                }
              }
              ?>
            <tbody>
          </table>
      </div>
    </div>
  </section>

  <section class="container-fluid panel-medio">
    <div class="box rounded">
      <div class="row">
        <div class="col-md-12 table-responsive">
          <div class="divDetallePredio_licencia_agua_2">
            <table class="table-container" id="tablalistaprediosAgua">
              <caption>Licencia de Aguam</caption>
              <thead>
                <tr>
                  <th class="text-center">N°</th>
                  <th class="text-center">Ubicación del Predio</th>
                  <th class="text-center">N° Licencia</th>
                  <th class="text-center">Fecha Licencia</th>
                  <th class="text-center">Accion</th>
                </tr>
              </thead>
              <tbody id="listaLicenciasAgua">
                <!-- Aqui Aparecen los Licencias del Piso-->
              </tbody>
            </table>
          </div>
          <div class="row col-md-12">
            <!-- Boton Casita Registrar Piso-->
            <div class="col-md-1">
              <img src="./vistas/img/iconos/agua.png" class="t-icon-tbl-imprimir" id="btnAbrirModalNuevaLicencia" data-target="#modalAgregarLicencia" title="Nueva Licencia">
            </div>

            <div class="col-md-1">
              <img src="./vistas/img/iconos/transferir.png" class="t-icon-tbl-imprimir" id="btnCambioRazonZocial" title="Cambio Razon Social"></img>
            </div>

            <div class="col-md-1">
              <img src="./vistas/img/iconos/calcular.png" class="t-icon-tbl-imprimir" id="btnProcesarDeuda" title="Calcular Estado de Cuenta">
            </div>
            <!-- Boton calcular estado de cuenta-->
          </div>
        </div>
      </div>


    </div>
</div>
</div>
</section>
</div>
<?php
        } else {
          echo "<div>error al cargar la pagina</div>";
        } ?>
<!--====== MODAL AGREGAR ALICENCIA ===========-->
<div class="modal" id="modalAgregarLicencia">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <label class="modal-title"> Registro de Nueva Licencia</label>
      </div>
      <div class="modal-body">
        <form role="form" method="POST" id="formRegistrarLicenciaAgua">
          <div class="row2">
            <label class="cajalabel2">Licencia de:</label>
            <select name="licAguaDesague" class="form2" id="licAguaDesague">
              <option value="0" selected>Seleccione</option>
              <option value="1">Agua</option>
            </select>
            <label class="cajalabel2" for="">N° Licencia</label>
            <input type="text" class="form" name="numLicenciaAd" id="numLicenciaAd">

            <label class="cajalabel1" for="">Codigo SIAT</label>
            <input type="text" class="form" name="codigo_sa" id="codigo_sa">
          </div>
          <section id="datosLicencia">
            <div class="row"> <!-- Otorgado a-->
              <label class="cajalabel2">Propietario:</label>
              <select name="propietarioLic" class="form5" id="propietarioLic">
                <?php foreach ($datos_contribuyente as $valor => $filas) {
                  foreach ($filas as $fila) {
                    echo "<option value='" . $fila['Id_Contribuyente'] . "' dniatri='" . $fila['Documento'] . "'>" . $fila['Nombre_Completo'] . '</option>';
                  }
                }
                ?>
                <!-- <option value='OTROS'>OTROS</option> -->
              </select>
            </div>
            <div class="row2" id="otrosPropietarios">
              <div class="row">
                <label class="cajalabel2" for="">Nro DNI:</label>
                <input type="text" class="form" name="numDniOtros" id="numDniOtros">
              </div>
              <div class="row">
                <label class="cajalabel2" for="">Nombres :</label>
                <input type="text" class="form" name="nombOtros" id="nombOtros">
                <label class="cajalabel2" for="">Ape. Paterno:</label>
                <input type="text" class="form" name="apePatOtros" id="apePatOtros">
                <label class="cajalabel2" for="">Ape. Materno:</label>
                <input type="text" class="form" name="apeMatOtros" id="apeMatOtros">
              </div>
            </div>
            <div class="row"> <!-- info Expediente-->
              <legend> <span class="caption_">Informacion de expediente</span></legend>
              <div class="row">
                <label class="cajalabel2">N° Expediente: </label>
                <input type="text" name="numExpedienteLic" id="numExpedienteLic" class="form2">
                <label class="cajalabel2"> Fecha Exp.: </label>
                <input type="date" id="fechaExpediente" name="fechaExpediente" class="form2">
              </div>
            </div>
            <div class="row"> <!-- Recibo Pago-->
              <legend> <span class="caption_">Informacion de Pago</span></legend>
              <div class="row">
                <label class="cajalabel2"># Recibo Caja: </label>
                <input type="text" name="numReciboCaja" id="numReciboCaja" class="form2">
                <label class="cajalabel2"># Provedio: </label>
                <input type="text" id="numProvedio" name="numProvedio" class="form2">
                <input type="hidden" id="idproveidor" name="idproveidor" class="form2">
              </div>
              <div class="row" style="padding-left: 115px !important;">
                <input id="buscarReciboPago" name="buscarReciboPago" type="button" value="Validar Recibo" class="form2">
                <label class="cajalabel2" id="respuestaRecibo" name="respuestaRecibo"> - </label>
              </div>
            </div>
            <div class="row"> <!-- Ubicacion-->
              <div class="row nuevoVia col-md-9">
                <div class="items-c registrar_licencia">

                </div>
              </div>

              <div class="row col-md-3">
                <div class="row col-md-12">
                  <div class="row">
                    <div class="form-group">
                      <label class="cajalabel12">N° Ubicación</label>
                      <input type="text" class="form-control" id="nroUbicacion" name="nroUbicacion" placeholder="Nro. Ubicacion..." maxlength="5" required>
                    </div>
                  </div>

                  <div class="row">
                    <div class="form-group">
                      <label class="cajalabel12">N° Lote</label>
                      <input type="text" class="form-control" id="nroLote" name="nroLote" placeholder="Nro. Lote ..." maxlength="5">
                    </div>
                  </div>

                  <div class="row">
                    <div class="form-group">
                      <label class="cajalabel12">N° Luz</label>
                      <input type="text" class="form-control" id="nroLuz" name="nroLuz" placeholder="Nro. Recibo Luz..." maxlength="20">
                    </div>
                  </div>

                </div>

              </div>
              <div class="row">
                <div class="row col-md-8">
                  <div class="form-group">
                    <label class="cajalabel12">Referencia</label>
                    <input type="text" class="form-control" id="ref" name="ref" placeholder="Referencia">
                  </div>
                </div>
              </div>




              <div class="row2"> <!-- Detalle Licencia-->
                <legend> <span class="caption_">Detalle Licencia</span> </legend>
                <div class="row">
                  <div class="col-lg-5 col-md-6"><!-- Tipo Instalacion-->
                    <label class="cajalabel2">Tipo:</label>
                    <select name="tipoLicenciaAd" class="form2" id="tipoLicenciaAd">
                      <option selected>Seleccione</option>
                      <option>PERMANENTE</option>
                      <option>TEMPORAL</option>
                    </select>
                  </div>
                  <div class="col-lg-5 col-md-6"><!-- Medida tuberia-->
                    <label class="cajalabel2">Tuberia(m):</label>
                    <select name="tuberiaAd" class="form2" id="tuberiaAd">
                      <option selected>Seleccione</option>
                      <option>1/2"</option>
                      <option>3/4"</option>
                      <option> 1"</option>
                    </select>
                  </div>
                  <div class="col-lg-5 col-md-6"><!-- Categoria Licencia-->
                    <label class="cajalabel2">Categoria: </label>
                    <select name="categoriaLicAd" class="form2" id="categoriaLicAd">
                      <option selected>Seleccione</option>
                      <option value="1">A - 8.00</option>
                      <option value="2">B - 6.00</option>
                      <option value="3">C - 4.00</option>
                    </select>
                  </div>
                  <div class="col-lg-5 col-md-6"><!-- Tamaño suministro-->
                    <label class="cajalabel2">Ext. Suministro: </label>
                    <select name="extSuministriAd" class="form2" id="extSuministriAd">
                      <option selected>Seleccione</option>
                      <option> HASTA 4 METROS DE LA MATRIZ</option>
                      <option> HASTA 8 METROS DE LA MATRIZ</option>
                      <option> HASTA 15 METROS</option>
                    </select>
                  </div>
                  <div class="col-lg-5 col-md-6"><!-- Prueba Instalacion-->
                    <label class="cajalabel2">Prueba Insp.: </label>
                    <label>
                      <input type="radio" id="pruebaCheckbox" name="pruebaCheckbox" value="SI"> SI
                    </label>
                    <label>
                      <input type="radio" id="pruebaCheckbox" name="pruebaCheckbox" value="NO"> NO
                    </label>
                  </div>
                  <div class="col-lg-5 col-md-6"><!-- Rotura Vereda-->
                    <label class="cajalabel2">Rotura Vereda: </label>
                    <label>
                      <input type="radio" id="roturaCheckbox" name="roturaCheckbox" value="SI"> SI
                    </label>
                    <label>
                      <input type="radio" id="roturaCheckbox" name="roturaCheckbox" value="NO"> NO
                    </label>
                  </div>
                  <div class="col-lg-5 col-md-6"><!-- Rotura Vereda-->
                    <label class="cajalabel2">Fecha Licencia:</label>
                    <input type="date" id="fechaExpedLic" name="fechaExpedLic" class="busqueda_filtros">
                  </div>
                </div>
              </div>

            
            <div class="row"> 
                <div class="col-8 col-md-8"> <!-- Obsercacion-->
                  <span class="caption_">Observaciones</span>
                    <input class="form-control" type="text" name="obsLicAd" id="obsLicAd">
                </div>

              </div>

              <div class="row" id="divDescuentoSindicatoNuevo"  style="display: none;"> <!-- Detalle Licencia-->
              <span class="caption_">Descuentos integrante del sindicato</span>
                <div class="row">

                <div class="col-lg-5 col-md-6"><!-- Categoria Licencia-->
                    <label class="cajalabel2">Desc. sindicato: </label>
                    <select name="descuentoSindicato" class="form2" id="descuentoSindicato">
                      <option selected>Seleccione</option>
                      <option value="0.50">50%</option>
                      
                    </select>
                </div>


                <div class="col-lg-5 col-md-6">
                    <label class="cajalabel2">Nu. Resolucion sindicato / otro: </label>
                    <input  type="text" name="resoSinLicAd" id="resoSinLicAd">
                </div>

              </div>
            </div>

            <div class="row" id="divDescuentoPagoServicioNuevo" > <!-- Detalle Licencia-->
            <span class="caption_">Descuento por Pago de servicio de agua potable</span>
            <div class="row">

                <div class="col-lg-5 col-md-6"><!-- Categoria Licencia-->
                    <label class="cajalabel2">Desc. pago servicio: </label>
                    <select name="descuendoServicio" class="form2" id="descuendoServicio">
                      <option selected>Seleccione</option>
                      <option value="2.00">2.00</option>
                      
                    </select>

                  </div>


              <div class="col-lg-5 col-md-6">
                <label class="cajalabel2">Numero de expediente: </label>
                <input type="text" name="resoPagoLicAd" id="resoPagoLicAd" >
              </div>

            </div>
          </div>




          </section>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" id="salirRegistroLicenAguaModal" class="btn btn-secondary btn-cancelar">Salir</button>
        <button type="button" class="btn btn-primary" id="btnRegistrarLicenAgua">Registrar</button>
      </div>
      <div class="row2 col-md-12" id="errorLicenciaAgua">
        <!--CONTENIDO DINAMICO DE MENSAJE POR NO COMPLETAR CAMPOS -->
      </div>
    </div>
  </div>
  <div class="resultados"></div>
</div>
<!--====== MODAL EDITAR ALICENCIA ===========-->


<!--====== MODAL EDITAR BARRA DE PROGRESO PARA AGUA =======-->
<div class="modal" id="modal_editar_barra_progreso_agua" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog modal-lg" role="document">
    <div class="modal-content">
    <form role="form" id="formCarpetaProgressAgua" method="post" enctype="multipart/form-data">
      
      <div class="modal-header">
        <label class="modal-title">EDITAR BARRA DE PROGRESO</label>
      </div>
      <div class="modal-body">
     
        <!-- Input oculto para almacenar el valor de Codigo_Carpeta -->
        <!-- Input oculto para almacenar el valor de Codigo_Carpeta -->
        <input  type="hidden" id="codigo_carpeta_agua" name="codigo_carpeta_agua" value="">



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
        <button type="button" class="btn btn-secondary" id="salir_modal_progreso_agua" data-dismiss="modal">Salir</button>
        <button style='float:right;' type="sudmit" class="btn btn-primary ">Guardar cambio</button>
      </div>

      </form>

    </div>
  </div>
</div>




<!--====== MODAL EDITAR ALICENCIA ===========-->
<div class="modal" id="modalEditarLicencia">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <label class="modal-title"> EDITAR LICENCIA</label>
      </div>
      <div class="modal-body">
        <form role="form" method="POST" id="formRegistrarLicenciaAguaEdit">
          <div class="row">
            <label class="cajalabel2">Licencia de:</label>
            <select name="licAguaDesagueEdit" class="form2" id="licAguaDesagueEdit">
              <option value="0">Seleccione</option>
              <option value="1" selected>Agua</option>
            </select>
            <label class="cajalabel2" for="">Nro Licencia</label>
            <input type="text" class="form" name="numLicenciaAdEdit" id="numLicenciaAdEdit">
          </div>
          <section id="datosLicencia">
            <div class="row"> <!-- Otorgado a-->
            <span class="caption_">Otorgado a:</span>
              <div class="row">
                <label class="cajalabel2" for="">Nro DNI:</label>
                <input type="text" class="form" name="numDniOtrosEdit" id="numDniOtrosEdit">
              </div>
              <label class="cajalabel2">Propietarios:</label>
              <input name="propietarioLicEdit" class="form5" id="propietarioLicEdit">
            </div>
            <div class="row"> <!-- info Expediente-->
            <span class="caption_">Informacion de Expediente</span>
              <div class="row">
                <label class="cajalabel2"># Expediente: </label>
                <input type="text" name="numExpedienteLicEdit" id="numExpedienteLicEdit" class="form2">
                <label class="cajalabel2"> Fecha Exp.: </label>
                <input type="date" name="fechaExpedienteEdit" id="fechaExpedienteEdit" class="form2">
              </div>
            </div>
            <div class="row"> <!-- Recibo Pago-->
            <span class="caption_">Informacion de Pago</span>
              <div class="row">
                <label class="cajalabel2">N° Recibo Caja: </label>
                <input type="text" name="numReciboCajaEdit" id="numReciboCajaEdit" class="form2">
                <label class="cajalabel2">N° Provedio: </label>
                <input type="text" id="numProvedioEdit" name="numProvedioEdit" class="form2">
              </div>
            </div>
            <div class="row"> <!-- Ubicacion-->
            <span class="caption_">Ubicación</span>

              <div class="row"> <!-- Ubicacion-->
                <div class="row nuevoVia col-md-9">
                  <div class="items-c editar_licencia">


                  </div>
                </div>
                

                
              <div class="row col-md-3">
                <div class="row col-md-12">
                  <div class="row">
                    <div class="form-group">
                      <label class="cajalabel12">N° Ubicación</label>
                      <input type="text" class="form-control" id="edit_nroUbicacion" name="edit_nroUbicacion" placeholder="Nro. Ubicacion..." maxlength="5" required>
                    </div>
                  </div>

                  <div class="row">
                    <div class="form-group">
                      <label class="cajalabel12">N° Lote</label>
                      <input type="text" class="form-control" id="edit_nroLote" name="edit_nroLote" placeholder="Nro. Lote ..." maxlength="5">
                    </div>
                  </div>

                  <div class="row">
                    <div class="form-group">
                      <label class="cajalabel12">N° Luz</label>
                      <input type="text" class="form-control" id="edit_nroLuz" name="edit_nroLuz" placeholder="Nro. Recibo Luz..." maxlength="20">
                    </div>
                  </div>

                </div>

              </div>
              <div class="row">
                <div class="row col-md-8">
                  <div class="form-group">
                    <label class="cajalabel12">Referencia</label>
                    <input type="text" class="form-control" id="edit_ref" name="edit_ref" placeholder="Referencia">
                  </div>
                </div>
              </div>

              </div>

              <div class="row"> <!-- Detalle Licencia-->
              <span class="caption_">Detalle de Licencia</span>
                <div class="row">
                  <div class="col-lg-5 col-md-6"><!-- Tipo Instalacion-->
                    <label class="cajalabel2">Tipo:</label>
                    <select name="tipoLicenciaAdEdit" class="form2" id="tipoLicenciaAdEdit">
                      <option selected>Seleccione</option>
                      <option>PERMANENTE</option>
                      <option>TEMPORAL</option>
                    </select>
                  </div>
                  <div class="col-lg-5 col-md-6"><!-- Medida tuberia-->
                    <label class="cajalabel2">Tuberia(m):</label>
                    <select name="tuberiaAdEdit" class="form2" id="tuberiaAdEdit">
                      <option selected>Seleccione</option>
                      <option>1/2"</option>
                      <option>3/4"</option>
                      <option> 1"</option>
                    </select>
                  </div>
                  <div class="col-lg-5 col-md-6"><!-- Categoria Licencia-->
                    <label class="cajalabel2">Categoria: </label>
                    <select name="categoriaLicAdEdit" class="form2" id="categoriaLicAdEdit">
                      <option selected>Seleccione</option>
                      <option value="1">A - 8.00</option>
                      <option value="2">B - 6.00</option>
                      <option value="3">C - 4.00</option>
                    </select>
                  </div>
                  <div class="col-lg-5 col-md-6"><!-- Tamaño suministro-->
                    <label class="cajalabel2">Ext. Suministro: </label>
                    <select name="extSuministriAdEdit" class="form2" id="extSuministriAdEdit">
                      <option selected>Seleccione</option>
                      <option> 2 ML</option>
                      <option> 5 ML</option>
                      <option> 8 ML</option>
                    </select>
                  </div>
                  <div class="col-lg-5 col-md-6"><!-- Prueba Instalacion-->
                    <label class="cajalabel2">Prueba Insp.: </label>
                    <input type="radio" id="pruebaCheckboxEdit" name="pruebaCheckboxEdit" value="1"> SI
                    <input type="radio" id="pruebaCheckboxEdit" name="pruebaCheckboxEdit" value="0"> NO
                  </div>
                  <div class="col-lg-5 col-md-6"><!-- Rotura Vereda-->
                    <label class="cajalabel2">Rotura Vereda: </label>
                    <input type="radio" id="roturaCheckboxEdit" name="roturaCheckboxEdit" value="1"> SI
                    <input type="radio" id="roturaCheckboxEdit" name="roturaCheckboxEdit" value="0"> NO
                  </div>

                  <div class="col-lg-5 col-md-6"><!-- Rotura Vereda-->
                    <label class="cajalabel2">Fecha Exp:</label>
                    <input type="date" id="fechaExpedLicEdit" name="fechaExpedLicEdit" class="busqueda_filtros">
                  </div>

                 

                </div>
              </div>

              <div class="row"> 
                <div class="col-8 col-md-8"> <!-- Obsercacion-->
                  <span class="caption_">Observaciones</span>
                    <input class="form-control" type="text" name="obsLicAdEdit" id="obsLicAdEdit">
                </div>

            </div>

            <div class="row" id="divDescuentoSindicato"  style="display: none;"> <!-- Detalle Licencia-->
              <span class="caption_">Descuentos integrante del sindicato</span>
                <div class="row">

                <div class="col-lg-5 col-md-6"><!-- Categoria Licencia-->
                    <label class="cajalabel2">Desc. sindicato: </label>
                    <select name="descuentoSindicatoEdit" class="form2" id="descuentoSindicatoEdit">
                      <option selected>Seleccione</option>
                      <option value="0.50">50%</option>
                      
                    </select>
                </div>


                <div class="col-lg-5 col-md-6">
                    <label class="cajalabel2">Nu. Resolucion sindicato / otro: </label>
                    <input  type="text" name="resoSinLicAdEdit" id="resoSinLicAdEdit">
                </div>

              </div>
            </div>

            <div class="row" id="divDescuentoPagoServicio" > <!-- Detalle Licencia-->
            <span class="caption_">Descuento por Pago de servicio de agua potable</span>
               <div class="row">

                <div class="col-lg-5 col-md-6"><!-- Categoria Licencia-->
                    <label class="cajalabel2">Desc. pago servicio: </label>
                    <select name="descuendoServicioEdit" class="form2" id="descuendoServicioEdit">
                      <option selected>Seleccione</option>
                      <option value="2.00">2.00</option>
                      
                    </select>

                  </div>


              <div class="col-lg-5 col-md-6">
                <label class="cajalabel2">Numero de expediente: </label>
                <input type="text" name="resoPagoLicAdEdit" id="resoPagoLicAdEdit" >
              </div>

            </div>
          </div>


          </section>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" id="salirRegistroLicenAguaEdit" class="btn btn-secondary btn-cancelar">Salir</button>
        <button type="button" class="btn btn-primary" id="btnRegistrarLicenAguaEdit">Modificar</button>
      </div>
      <div class="row2 col-md-12" id="errorLicenciaAguaEdit">
        <!--CONTENIDO DINAMICO DE MENSAJE POR NO COMPLETAR CAMPOS -->
      </div>
    </div>
  </div>
  <div class="resultados"></div>
</div>


<!--====== MODAL TRANSFERIR ===========-->
<div class="modal" id="modalTranferirLicence">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <label class="modal-title"> TRANSFERIR LICENCIA</label>
      </div>
      <div class="modal-body">
        <form role="form" method="POST" id="formTransferirLicenciaAguaEdit">
          <div class="row2">
            <label class="cajalabel2">Licencia de:</label>
            <select name="licAguaDesagueEdit" class="form2" id="licAguaDesagueEdit">
              <option value="1" selected>Agua</option>
            </select>
            <label class="cajalabel2" for="">N° Licencia</label>
            <input type="text" class="form" name="numLicenciaAdEditt" id="numLicenciaAdEditt">
            <input type="hidden" class="form" name="idlicencet" id="idlicencet">
          </div>
          <div class="col-md-12">
            <div class="col-md-6 table-responsive">
              <table class="table-container">
                <caption>Licencia a Nombre (Actual):</caption>
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
              <table id="tabla_propietario" class="table-container">
                <caption><b>Licencia a Nombre (Nuevo):</b></caption>
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
          <br>
          <div class="row"> <!-- Obsercacion-->
            <br>
            <label class="cajalabel2" for="">Observacion:</label>
            <input class="form6" type="text" name="obsLicAdEditt" id="obsLicAdEditt">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" id="salirTransferenLicenAguaEdit" class="btn btn-secondary btn-cancelar">Salir</button>
        <button type="button" class="btn btn-primary" id="btnTranferenLicenAguaEdit">Modificar</button>
      </div>
      <div class="row2 col-md-12" id="errorLicenciaAguaEdit">
        <!--CONTENIDO DINAMICO DE MENSAJE POR NO COMPLETAR CAMPOS -->
      </div>
    </div>
  </div>
  <div class="resultados"></div>
</div>

<!--====== MODAL CALCULAR ESTADO DE CUENTA ===========-->
<div class="modal" id="modalEstadoCuentaAgua">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <label class="modal-title"> Calcular Estado de Cuenta Agua</label>
      </div>
      <div class="modal-body">
        <form role="form" method="POST" id="formRegistrarLicenciaAguaEdit">
          <div class="row2">
            <label class="cajalabel2">Licencia de:</label>
            <select name="licAguaDesagueEditCalcular" class="form2" id="licAguaDesagueEdit">
              <option value="0">Seleccione</option>
              <option value="1" selected>Agua</option>
            </select>
            <label class="cajalabel2" for="">Nro Licencia</label>
            <input type="text" class="form" name="numLicenciaAdEditCalcular" id="numLicenciaAdEditCalcular" readonly>


            <label class="cajalabel2" for="" id="div_condicion_anio">Año</label>
            <span id="anio_agua"></span>


          </div>
          <section id="datosLicencia">
            <div class="row2"> <!-- Otorgado a-->
              <legend> Otorgado a</legend>
              <div class="row">
                <label class="cajalabel2" for="">Nro DNI:</label>
                <input type="text" class="form" name="numDniOtrosEditCalcular" id="numDniOtrosEditCalcular" readonly>
              </div>
              <label class="cajalabel2">Propietarios:</label>
              <input name="propietarioLicEditCalcular" class="form5" id="propietarioLicEditCalcular" readonly>
            </div>
            <div class="row2"> <!-- Ubicacion-->
              <legend> Ubicacion</legend>
              <div>
                <label for="">Ubicacion Predio : </label>
                <label for="" id="labelUbicacionLicEditCalcular">-</label>
              </div>

            </div>
            <div class="row2"> <!-- Detalle Licencia-->
              <legend> Detalle Licencia </legend>
              <div class="row">
                <div class="col-lg-5 col-md-6"><!-- Tipo Instalacion-->
                  <label class="cajalabel2">Tipo:</label>
                  <select name="tipoLicenciaAdEditCalcular" class="form2" id="tipoLicenciaAdEditCalcular">
                    <option selected>Seleccione</option>
                    <option>PERMANENTE</option>
                    <option>TEMPORAL</option>
                  </select>
                </div>

                <div class="col-lg-5 col-md-4"><!-- Categoria Licencia-->
                  <label class="cajalabel2">Categoria: </label>
                  <select name="categoriaLicAdEditCalcular" class="form2" id="categoriaLicAdEditCalcular">
                    <option selected>Seleccione</option>
                    <option value="1">A</option>
                    <option value="2">B</option>
                    <option value="3">C</option>
                  </select>
                </div>

                <div class="col-lg-5 col-md-4"><!-- Categoria Licencia-->
                  <label class="cajalabel2">Monto: </label>
                  <span id="MontoLicEditCalcular" name="MontoLicEditCalcular"><span>
                </div>

                <div class="col-lg-5 col-md-6"><!-- Rotura Vereda-->
                  <label class="cajalabel2">Fecha Exp:</label>
                  <span id="fechaExpedLicEditCalcular" name="fechaExpedLicEditCalcular"></span>
                </div>

                <div class="col-lg-5 col-md-4"><!-- Categoria Licencia-->
                  <label class="cajalabel2">Descuento sindicato: </label>
                  <span id="descuentoSindicatoCalcular" name="descuentoSindicatoCalcular"><span>
                </div>

                <div class="col-lg-5 col-md-6"><!-- Rotura Vereda-->
                  <label class="cajalabel2">Descuento servicio agua:</label>
                  <span id="descuentoServicioEditCalcular" name="descuentoServicioEditCalcular"></span>
                </div>

          </section>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" id="salirEstadoCuentaAgua" class="btn btn-secondary btn-cancelar">Salir</button>
        <button type="button" class="btn btn-primary" id="btnRegistrarEstadoCuentAgua">Calcular</button>
      </div>
      <div class="row2 col-md-12" id="errorLicenciaAguaEdit">
        <!--CONTENIDO DINAMICO DE MENSAJE POR NO COMPLETAR CAMPOS -->
      </div>
    </div>
  </div>
  <div class="resultados"></div>
</div>

<!-- MODAL CONFIRMAR PARA CALCULAR EL ESTADO DE CUENTA DEL AGUA -->
<div class="modal fade" id="modalGenerarAgua_si_no" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="staticBackdropLabel">Calcular Estado Cuenta Agua</h5>
      </div>
      <div class="modal-body">
        <h7>Estas Seguro de calcular el estado de cuenta de agua del año <span id="anio_formato_la"><!-- CONTENIDO DINAMICO--></span>?</h7>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-primary generardeudaagua">si</button>
      </div>
    </div>
  </div>
</div>
<!-- FIN MODAL CONFIRMAR PARA CALCULAR EL ESTADO DE CUENTA DEL AGUA -->

<!-- MODAL CONFIRMAR PARA RECALCULAR EL ESTADO DE CUENTA DEL AGUA -->
<div class="modal fade" id="modalGenerarRecalculoAgua_si_no" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="staticBackdropLabel">Recalcular Estado Cuenta Agua</h5>
      </div>
      <div class="modal-body">
        <h7>Estas Seguro de Recalcular el estado de cuenta de agua del año <span id="anio_formato_la"><!-- CONTENIDO DINAMICO--></span>?</h7>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-primary generarRecalculodeudaagua">si</button>
      </div>
    </div>
  </div>
</div>
<!-- FIN MODAL CONFIRMAR PARA RECALCULAR EL ESTADO DE CUENTA DEL AGUA -->


<!-- modal de estado de cuenta agua-->

<div class="modal in" id="ModalEstado_cuentaAgua" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-fullscreen">
    <div class="modal-content">
      <div class="modal-header">
        <label class="modal-title"> Estado de Cuenta Agua</label>
      </div>

      <div class="modal-body estado_cuentaAgua_mostrar">
        <div class="row divDetallePredio">
          <table class="table-container miprimeratabla_agua" id="primeraTabla_agua">
            <thead>
              <tr>
                <th class="text-center" style="width:30px;">Cod.</th>
                <th class="text-center" style="width:50px;">Servicio</th>
                <th class="text-center" style="width:50px;">Año</th>
                <th class="text-center" style="width:50px;">Periodo</th>
                <th class="text-center" style="width:50px;">Importe</th>
                <th class="text-center" style="width:50px;">Gastos</th>
                <th class="text-center" style="width:50px;">Subtotal</th>
                <th class="text-center" style="width:50px;">Desc.</th>
                <th class="text-center" style="width:50px;">Total</th>
                <th class="seleccionado text-center" style="width:20px;">S</th>
              </tr>
            </thead>
            <tbody id="listaLicenciasAgua_estadocuenta">
              <!-- Aqui Aparecen el estado de cuenta Agua-->
            </tbody>
          </table>
        </div>


        <table class="table-container" id="segundaTabla_agua">
          <tbody>
            <th class="text-right td-round total_c" style="width:180px;">Total Deuda =</th>
            <th class="text-center td-round" style="width:50px;"></th>
            <th class="text-center td-round" style="width:50px;"></th>
            <th class="text-center td-round" style="width:50px;"></th>
            <th class="text-center" style="width:50px;"></th>
            <th class="text-center" style="width:50px;"></th>
            <th class="text-center" style="width:20px;"></th>
          </tbody>
        </table>


        <!-- segunda tabla donde muestra el boton imprimir y el total del estado de cuenta-->

      </div>


      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
        <button type="button" class="btn btn-primary" id="popimprimir_agua" data-target="#Modalimprimir_cuentaagua">Imprimir Deuda</button>
      </div>
    </div>
  </div>
</div>

<!--  Fin del modal de mostrar el estado de cuenta de agua -->

<!-- modal de estado de cuenta agua pagados-->

<div class="modal in" id="ModalEstado_cuentaAgua_pagados" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-fullscreen">
    <div class="modal-content">
      <div class="modal-header">
        <label class="modal-title"> Estado de Cuenta Agua Pagados</label>
      </div>

      <div class="modal-body estado_cuentaAgua_mostrar">
        <div class="row divDetallePredio">
          <table class="table-container miprimeratabla_agua_pagados" id="primeraTabla_agua_pagados">
            <thead>
              <tr>
                <th class="text-center" style="width:30px;">Cod.</th>
                <th class="text-center" style="width:50px;">Servicio</th>
                <th class="text-center" style="width:50px;">Año</th>
                <th class="text-center" style="width:50px;">Periodo</th>
                <th class="text-center" style="width:100px;">Fecha Pago</th>
                <th class="text-center" style="width:50px;">Importe</th>
                <th class="text-center" style="width:50px;">Gastos</th>
                <th class="text-center" style="width:50px;">Subtotal</th>
                <th class="text-center" style="width:50px;">Desc.</th>
                <th class="text-center" style="width:50px;">Total</th>
                <th class="seleccionado text-center" style="width:20px;">S</th>
              </tr>
            </thead>
            <tbody id="listaLicenciasAgua_estadocuenta_pagados">
              <!-- Aqui Aparecen el estado de cuenta Agua-->
            </tbody>
          </table>
        </div>


        <table class="table-container" id="segundaTabla_agua_pagados">
          <tbody>
            <th class="text-right td-round total_c" style="width:280px;">Total Pagos =</th>
            <th class="text-center td-round" style="width:50px;"></th>
            <th class="text-center td-round" style="width:50px;"></th>
            <th class="text-center td-round" style="width:50px;"></th>
            <th class="text-center" style="width:50px;"></th>
            <th class="text-center" style="width:50px;"></th>
            <th class="text-center" style="width:20px;"></th>
          </tbody>
        </table>
        <!-- segunda tabla donde muestra el boton imprimir y el total del estado de cuenta-->
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
        <button type="button" class="btn btn-primary" id="popimprimir_agua_pagados" data-target="#Modalimprimir_cuentaagua">Imprimir Pagos</button>
      </div>
    </div>
  </div>
</div>

<!--  Fin del modal de mostrar el estado de cuenta de agua pagados-->


<!-- modal de imprimir estado cuenta agua-->
<div class="container-fluid">
  <div class="modal in" id="Modalimprimir_cuentaagua" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-fullscreen">
      <div class="modal-content">
        <div class="modal-header">
        </div>
        <div class="modal-body printerhereagua">
          <iframe id="iframe_agua" class="iframe-full-height"></iframe>
          <!-- Muestra el estado de cuenta de Agua-->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- fin de imprimir estado de cuenta agua-->


<!-- ubicacion del predio-->
<div class="modal fade bd-example-modal-lg" id="modalViascalles" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-body">

        <div class="row">
          <!-- BUSQUEDA NOMBRE DE CALLE-->
          <div class="contenedor-busqueda">
            <div class="input-group-search">
              <div class="input-search">
                <input type="search" class="search_direccion" id="searchViacalle" name="searchViacalle" placeholder="Ingrese Nombre de Via o Calle..." onkeyup="loadViacalle(1,'#itemsRC_editar_agua')">
                <input type="hidden" id="perfilOculto_v" value="<?php echo $_SESSION['perfil'] ?>">
              </div>
            </div>
          </div>
        </div>

        <div class="col-12 table-responsive divDetallePredio">
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
<!-- fin ubicacion del predio-->


<!--====== MODAL BUSCAR PROPIETARIO - LICENCIA-->
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




<div class="resultados"></div>
<div id="errorLicence"><!--CONTENIDO DINAMICO  --></div>
<div id="respuestaAjax_correcto"></div>