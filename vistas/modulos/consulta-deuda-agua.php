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
<!--
<div class="content-wrapper panel-medio-principal">
  <section class="container-fluid panel-medio">
        <div class="box container-fluid table-responsive"  style="border:0px; margin-bottom:3px; padding:0px;">
          <div class="col-lg-6 col-xs-6">
            <?php
            $datos_contribuyente = ControladorContribuyente::CntrVerificar_Parametro($idArray);
            if (count($datos_contribuyente) > 0) {
            ?>
                <div id="respuestaAjax_correcto"></div> <!-- eliminar predios -->
                
                <table class="miTabla_propietarios" >
                <caption>Propietarios</caption>
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
                      echo '<tr id="fila" id_contribuyente="' . $fila['Id_Contribuyente'] . '">
                      <td class="text-center">' . $fila['Id_Contribuyente'] . '</td>
                      <td class="text-center">' . $fila['Documento'] . '</td>
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
            <div class="col-md-6 table-responsive divDetallePredio">
                <table class="table-container" id="tablalistaprediosAgua_consulta">
                  <caption>Predios del Contribuyente AQUI</caption>
                  <thead>
                    <tr>
                      <th class="text-center">N°</th>
                      <th class="text-center">Tipo</th>
                      <th class="text-center">Ubicación del Predio</th>
                      <th class="text-center">Id.Catastro</th>
                    </tr>
                  </thead>
                  <?php
                  $year = date("Y");
                  $listaPredio = ControladorPredio::ctrListarPredioAgua($idArray,$year);
                  ?>
                </table>
            </div> 
            <!--DETALLE LICENCIAS-->
            <div class="col-md-6 table-responsive divDetallePredio">
              <div class="row">
                <table class="table-container" id="tablalistaLicences">
                  <caption>Licencia de Agua</caption>
                  <thead>
                    <tr>
                      <th class="text-center">Nro Licencia</th>
                      <th class="text-center">Fecha Expedicion</th>
                      <th class="text-center">Monto</th>
                      <th class="text-center">Estado Cuenta</th>
                    </tr>
                  </thead>
                  <tbody id="listaLicenciasAgua_deuda">
                    <!-- Aqui Aparecen los Licencias del Piso-->
                  </tbody>
                </table>
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


<!-- modal de estado de cuenta agua-->
<div class="container-fluid">
            <div class="modal in" id="ModalEstado_cuentaAgua"  data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-fullscreen">
                      <div class="modal-content">
                      <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>

        <label class="modal-title"> Estado de Cuenta Agua</label>
      </div>
                        
                        <div class="modal-body estado_cuentaAgua_mostrar">
                         <div class="row divDetallePredio">
                            <table class="table table-bordered miprimeratabla_agua_caja" id="primeraTabla_agua">
                              <thead>
                                <tr>
                                  <th class="text-center">Cod.</th>
                                  <th class="text-center">Servicio</th>
                                  <th class="text-center">Año</th>
                                  <th class="text-center">Periodo</th>
                                  <th class="text-center">Importe</th>
                                  <th class="text-center">Gastos</th>
                                  <th class="text-center">Subtotal</th>
                                  <th class="text-center">Desc.</th>
                                  <th class="text-center">Total</th>
                                  <th class="seleccionado text-center" style="width:40px;">S</th>
                                </tr>
                              </thead>
                              <tbody id="listaLicenciasAgua_estadocuenta">
                                <!-- Aqui Aparecen el estado de cuenta Agua-->
                              </tbody>
                            </table>
                          </div>
                        <div class="modal-footer"> 
                         <div class="row">
                            <!-- segunda tabla donde muestra el boton imprimir y el total del estado de cuenta-->
                            <table id="segundaTabla_agua_caja">
                              <tbody>
                                <td>
                                  <div class="col-md-1">
                                    <div class="form-group">
                                      <div class="input-group">
                                        <i class="fas fa-print fa-3x" title="Imprimir Estado Cuenta Agua" id="popimprimir_agua" data-target="#Modalimprimir_cuentaagua"></i>
                                      </div>
                                    </div>
                                  </div>
                                </td>
                                <!-- no eliminar los Td-->
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
            </div>
  </div>
<!--  Fin del modal de mostrar el estado de cuenta de agua -->

<!-- modal de imprimir estado cuenta agua-->
<div class="container-fluid">
            <div class="modal in" id="Modalimprimir_cuentaagua"  data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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


<div class="resultados"></div>
<div id="errorLicence"><!--CONTENIDO DINAMICO  --></div>
<div id="respuestaAjax_correcto"></div>

*/