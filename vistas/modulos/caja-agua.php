<?php

use Controladores\ControladorEmpresa;
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
      <div class="col-lg-6 col-xs-6">
        <?php
        $datos_contribuyente = ControladorContribuyente::CntrVerificar_Parametro($idArray);
        if (count($datos_contribuyente) > 0) {
        ?>
            <div id="respuestaAjax_correcto"></div>
            <div id="div_propietarios">
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
    </div>
  </section>
  <section class="container-fluid panel-medio">
    <div class="box rounded">
  
      <div class="box-body table-user">
          <div class="row">
            <!--TABLA DE PREDIOS-->
            <div class="col-md-6 table-responsive">
              <div class="row divDetallePredio_agua ">
                <table class="table-container" id="tablalistaprediosAgua_consulta_caja">
                <caption>Predios con Licencia de Agua</caption>
                  <thead>
                    <tr>
                      <th class="text-center">N°</th>
                      <th class="text-center">Ubicacion del Predio</th>
                      <th class="text-center">N° Licencia</th>
                    </tr>
                  </thead>
                  <?php
                  $year = date("Y");
                  $listaPredio = ControladorPredio::ctrListarPredioAgua_caja($idArray,$year);
                  ?>
                </table>
              </div>

             <!-- SECCION DE RESUMEN A COBRAR AGUA-->
            <div class="" >
                <table class="table-container" id="tablaResumen">
                <caption>Resumen a Cobrar</caption>
                  <thead>
                    <tr>
                      <td style="width:200px" class="text-right" >N° correlativo</td>
                      <td id="nc"></td>
                      
                    </tr>
                    <tr>
                      <td style="width:250px" class="text-right" >Total de Agua S/.</td>
                      <td id='total_agua'>0.00</td>
                      
                    </tr>
                    <tr>
                      <td class="text-right">Efectivo S/.</td>
                      <td><input type="text" placeholder="0.00" class="form3" id="efectivo" oninput="sumarValores_agua()"></input></td>
                      
                    </tr>
                    <tr>
                      <td class="text-right">Vuelto S/.</td>
                      <td><input type="text" placeholder="0.00" class="form3" id="vuelto"></input></td>
                    </tr>

                    <tr>
                      <td class="text-right td-round total_c" >Total S/.</td>
                      <td id="total_caja">0.00</td>
                    </tr>
                    <tr>
                      <td colspan="2" class="text-left"> 
                            <img src="./vistas/img/iconos/print1.png" class="t-icon-tbl-imprimi_b generar_boleta_agua"  title="Imprimir Boleta"  id="liveToastBtn" data-target="#modalPagar_si_no_agua">
                      </td>
                    </tr>
                  </thead>
                </table>
            </div>
              <!--======== CONTADOR PREDIOS ===========-->
              <div class="row">
                <div class="col-md-2">
                  <div class="form-group">
                    <div class="input-group">
                      <!--    <i class="fas fa-file-invoice fa-3x" id="abrirPopupButton_copiar" data-target="#modalCopiarPredio"></i>-->
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!--DETALLE LICENCIAS-->
            <div class="col-md-6 table-responsive">
              <div class="row divDetallePredio">
                            <table class="table-container miprimeratabla_agua_caja" id="primeraTabla_agua_caja">
                             <caption>Estado de Cuenta Agua</caption>
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
                              <tbody id="listaLicenciasAgua_estadocuenta_caja">
                                <!-- Aqui Aparecen el estado de cuenta Agua-->
                              </tbody>
                            </div>
                            </table>
                          </div>
                          <div class="">       
                        <div class="modal-footer"> 
                         
                            <!-- segunda tabla donde muestra el boton imprimir y el total del estado de cuenta-->
                            <table class="table-container" id="segundaTabla_agua_caja">
                              <tbody>
                                <th class="text-center"></th>
                                <!-- no eliminar los Td-->
                                <th class="text-center"></th>
                                <th class="text-center"></th>
                                <th class="text-center td-round total_c">Total S/.</th>
                                <th class="text-center td-round total_c"></th>
                                <th class="text-center td-round total_c"></th>
                                <th class="text-center td-round total_c"></th>
                                <th class="text-center td-round total_c"></th>
                                <th class="text-center td-round total_c"></th>
                                <th class="text-center"></th>
                              </tbody>
                            </table>
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




<!-- modal de imprimir estado cuenta agua-->
<div class="container-fluid">
            <div class="modal in" id="Modalimprimir_cuentaagua_caja"  data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-fullscreen">
                      <div class="modal-content">
                       
                        <div class="modal-body printerhereagua">
                          <iframe id="iframe_agua_caja" class="iframe-full-height"></iframe>
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

<!-- Modal confirma si pagar o no - agua -->
<div class="modal fade" id="modalPagar_si_no_agua" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="staticBackdropLabel">Recaudación Agua</h5>
      </div>
      <div class="modal-body">
        <h7>Estas Seguro de Generar la Boleta como Cancelado de un total de <b><span id="total_confirmar_agua"><!-- CONTENIDO DINAMICO--></span></b> &nbsp;?</h7>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-primary print_boleta_agua">si</button>
      </div>
    </div>
  </div>
</div>
<!--Fin Modal confirma si pagar o no  agua-->


<div class="resultados"></div>
<div id="errorLicence"><!--CONTENIDO DINAMICO  --></div>
<div id="respuestaAjax_correcto"></div>

