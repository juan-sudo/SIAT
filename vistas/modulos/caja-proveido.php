<?php
use Controladores\ControladorPredio;
$carpeta = '../modulos/print/pdfs';
if (!file_exists($carpeta)) {
    mkdir($carpeta, 0777, true);
}

?>
<div class="content-wrapper panel-medio-principal">

  <section class="container-fluid panel-medio ">
    <div class="box rounded">
          <div class="row " >
              
           
                    

             <!--DETALLE ESTADO CUENTA-->
            <div class="col-md-8 table-responsive">
                  <div class="row table-responsive">
                      <div class="col-md-12">
                      <span class="caption_ pull-left">Proveidos a cobrar</span>  
                      <div class="pull-right">
                                      <input class="busqueda_filtros_anio" type="date" id="fecha_caja_proveido" name="fecha_caja_proveido">
                      </div>
                      </div>
                  </div>
                  <br>
            <div class="divcaja_proveido">
                  <table class="table-container tablaproveidos" id="tablaproveidos">
                    <thead>
                      <tr>
                        <th class="text-center" style="width:80px;">N° Proveido</th>
                        <th class="text-center" style="width:200px;">Área</th>
                        <th class="text-center" style="width:200px;">Concepto</th>
                        <th class="text-center" style="width:100px;">Solicitante</th>
                        <th class="text-center" style="width:80px;">Costo Unit.</th>
                        <th class="text-center" style="width:80px;">Cantidad</th>
                        <th class="text-center" style="width:80px;">Valor Total</th>
                      
                      </tr>
                    </thead>
                    <tbody id="estadoCuenta" class="scrollable listaproveidoscaja">
                      <!-- qui Aparecen los estado de cuenta-->
                    </tbody>
                  </table>
            </div>
            </div>
             
    
            <div class="col-md-4 table-responsive">
                <div class="table-responsive"> <caption>Resumen a Cobrar</caption></div>
                <table class="table-container" width="100%" id="tablaResumen">
                  <thead>
                    <tr>
                      <td style="width:200px" class="text-right" >N° correlativo</td>
                      <td id="nc">0</td>
                    </tr>
                    <tr>
                      <td style="width:250px" class="text-right" >Total del Proveido</td>
                      <td id='total_proveido'>0.00</td>
                    </tr>
                    <tr>
                      <td class="text-right">Efectivo S/.</td>
                      <td><input type="text" placeholder="0.00" class="form3" id="efectivo_proveido" oninput="sumarValores_proveido()"></input></td>
                    </tr>
                    <tr>
                      <td class="text-right">Vuelto S/.</td>
                      <td><input type="text" placeholder="0.00" class="form3" id="vuelto_proveido"></input></td>
                    </tr>
                    <tr>
                      <td class="text-right" >Total S/.</td>
                      <td id="total_caja_proveido">0.00</td>
                    </tr>
                    <tr>
                      <td>
                      <div class="col-md-1">
                        <div class="form-group">
                          <div class="input-group">
                            <img src="./vistas/img/iconos/imprimir.png" class="t-icon-tbl-imprimir generar_boleta_proveido" title="Generar Boleta Proveido"  id="liveToastBtn" data-target="#modalPagar_si_no">
                     
                          </div>
                        </div>
                       </div>
                      </td>
                    </tr>
                  </thead>
                </table>
              </div>
         
   <!--fin TABLA DE PREDIOS-->
        </div>
      </div>
      
    </div>
  
  </section>
</div>
  <!-- modal de imprimir estado cuenta -->
  <div class="container-fluid">
            <div class="modal in" id="Modalimprimir_boleta_proveido"  data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-fullscreen">
                      <div class="modal-content">
                        <div class="modal-header">
                        </div>
                        <div class="modal-body printerhere_proveido">
                          <iframe id="iframe_proveido_A4" class="iframe-full-height"></iframe>


                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                      </div>
                    </div>
            </div>
  </div>
<!-- fin de imprimir estado de cuenta-->

<!-- Modal confirma si pagar o no -->
<div class="modal fade" id="modalPagar_proveido_si_no" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="staticBackdropLabel">Recaudación</h5>
      </div>
      <div class="modal-body">
        <h7>Estas Seguro de Generar la Boleta del N° <span id="numero_proveido"> de proveido<span>como Cancelado de un total de <b><span id="total_confirmar"><!-- CONTENIDO DINAMICO--></span></b> &nbsp;?</h7>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-primary print_boleta_proveido">si</button>
      </div>
    </div>
  </div>
</div>


<!--Fin Modal confirma si pagar o no -->
