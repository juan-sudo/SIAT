<?php
use Controladores\ControladorEmpresa;
use Controladores\ControladorPredio;
use Controladores\ControladorContribuyente;
?>

<div class="content-wrapper panel-medio-principal">
<section class="container-fluid panel-medio">
   
      <div class="box table-responsive">
         <div class="row">
              <div class="col-md-3">
                <table class="table-container" id="tablalistaprediosAgua_consulta_caja">
                        <caption>Cierre Caja</caption>
                          <thead>
                            <tr>
                              <td class="text-right">Fecha Emision</td>
                              <td><input type="date" id="fecha_cierre" name="fecha_cierre" class="form-control-date"></td>
                              <td><button class="custom-btn btn-1" id="cierre_caja">Cerrar caja</button></td>
                            </tr>
                          </thead>
                </table>
              </div>
        </div>     
      </div>
   
    
  </section>
<!-- seccion de la Id-->
  <section class="container-fluid panel-medio">
    <div class="row">
        <div class="col-md-6 table-responsive cierre_div">
                <div class="divReport_finan">
                              <table class="table-container miprimeratabla_cierre" id="primeraTabla_cierre">
                              <caption>Reporte Consolidado de Ingresos</caption>
                                <thead>
                                  <tr>
                                    <th class="text-center" style="width: 40px;">Presupuesto</th> 
                                    <th class="text-center" style="width: 310px;">Clasificador de Ingreso</th>
                                    <th class="text-center" style="width: 40px;">Subtotal</th>
                                    <th class="text-center" style="width: 40px;">F.Finan.</th>
                                  </tr>
                                </thead>
                                <tbody id="reporte_financiamiento">
                                  <!-- Aqui Aparecen el valores de cierre de caja-->
                                </tbody>
                              </table>
                </div>
                            <!-- segunda tabla donde muestra el boton imprimir y el total del estado de cuenta-->
                            <table id="segundaTabla_cierre" class="table-container">
                              <tbody>
                                <tr>
                                <th class="text-center" style="width: 40px;"></th>
                                <th class="text-right td-round total_c" style="width: 310px;" >Total Ingresos S/.</th>
                                <th class="text-center td-round total_c" style="width: 40px;" id="total_reporte_cierre"></th>
                                <th class="text-center" style="width: 40px;"></th>
                                </tr>
                              </tbody>
                            </table>
        </div>
       
            <!--TABLA DE proceso de cierre de caja-->
        <div class="col-md-6  divcierre_caja table-responsive cierre_div" id="midiv">
              <div class="row">
                  <caption>progreso de cierre caja (tributos-agua-especies valoradas)</caption>
                        <div class="col-md-cierre-caja">
                            <div class="progress">
                              <b class="progress__bar">
                                <span class="progress__text">
                                  Proceso: <em>0%</em>
                                </span>
                              </b>
                            </div>
                        </div>
              </div>
        </div>
      
    </div>
  </section>
</div>

      




<!-- modal de imprimir estado cuenta agua-->
<div class="container-fluid">
            <div class="modal in" id="Modalimprimir_cuentaagua_caja"  data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-fullscreen">
                      <div class="modal-content">
                        <div class="modal-header">
                        </div>
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

<!-- Modal confirma si o no cierre caja -->
<div class="modal fade" id="modalcierrecaja_si_no" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="staticBackdropLabel">Cierre caja</h5>
      </div>
      <div class="modal-body">
        <h7>Estas Seguro de Cerrar caja de fecha <b><span id="fecha_cierre_caja"><!-- CONTENIDO DINAMICO--></span></b> &nbsp;?</h7>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-primary print_cierre_caja">si</button>
      </div>
    </div>
  </div>
</div>
<!-- fin Modal confirma si o no cierre caja -->








<div class="resultados"></div>
<div id="errorLicence"><!--CONTENIDO DINAMICO  --></div>
<div id="respuestaAjax_correcto"></div>

