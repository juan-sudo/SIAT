<?php
$carpeta = '../modulos/print/pdfs';
if (!file_exists($carpeta)) {
  mkdir($carpeta, 0777, true);
}

use Controladores\ControladorPredio;
use Controladores\ControladorContribuyente;
use Controladores\ControladorEstadoCuenta;

?>
<div class="content-wrapper panel-medio-principal">
  

  <section class="container-fluid panel-medio ">
    <div class="box rounded table-responsive">
      <div class="row">

        <div class="col-md-8 table-responsive">
          <div class="row divDetallePredio">
            <div class="row">
              <div class="col-md-12 table-responsive">
                <div class="col-md-6">
                  Reimprimir Pagos
                </div>
                
                <div class="col-md-6 text-right">
                  <input type="text" class="busqueda_filtros n_recibo_reimprimir"  placeholder="N° Recibo">
                  <select class="busqueda_filtros" id="select_reimprimir" name="select_tributo" onchange="load_tributo(1)">
                    <option value='006'>Predial-Arbitrios</option>';
                    <option value='009'>Especies Valoradas</option>';
                    <option value='005'>Agua</option>';
                    ?>
                  </select>
                </div>
              </div>


              <table class="table-container" id="reimrprimir_tabla_tributo">
                <thead>
                  <tr>
                    <th class="text-center" style="width:100px;">N° Caja</th>
                    <th class="text-center" style="width:200px;">Tributo</th>
                    <th class="text-center" style="width:100px;">Año</th>
                    <th class="text-center" style="width:100px;">Periodo</th>
                    <th class="text-center" style="width:200px;">Fecha Pago</th>
                    <th class="text-center" style="width:100px;">Importe</th>
                    <th class="text-center" style="width:100px;">Gasto</th>
                    <th class="text-center" style="width:100px;">Subtotal</th>
                    <th class="text-center" style="width:100px;">T.I.M</th>
                    <th class="text-center" style="width:100px;">Total</th>

                  </tr>
                </thead>
                <tbody class="scrollable reimprimir_tributo">
                  <!-- Aqui Aparecen los estado de cuenta-->

                </tbody>
              </table>

              <table class="table-container" id="reimrprimir_tabla_especie" style="display:none;">
                <thead>
                  <tr>
                    <th class="text-center" style="width:100px;">N° Caja</th>
                    <th class="text-center" style="width:200px;">N° Proveido</th>
                    <th class="text-center" style="width:100px;">Concepto</th>
                    <th class="text-center" style="width:100px;">Solicitante</th>
                    <th class="text-center" style="width:100px;">Fecha Pago</th>
                    <th class="text-center" style="width:100px;">Cantidad</th>
                    <th class="text-center" style="width:100px;">Total</th>

                  </tr>
                </thead>
                <tbody class="scrollable reimprimir_especie">
                  <!-- Aqui Aparecen los estado de cuenta-->

                </tbody>
              </table>


              <table class="table-container" id="reimrprimir_tabla_agua" style="display:none;">
                <thead>
                  <tr>
                    <th class="text-center" style="width:100px;">N°</th>
                    <th class="text-center" style="width:200px;">Tributo</th>
                    <th class="text-center" style="width:100px;">Año</th>
                    <th class="text-center" style="width:100px;">Periodo</th>
                    <th class="text-center" style="width:100px;">Fecha Pago</th>
                    <th class="text-center" style="width:100px;">Subtotal</th>
                    <th class="text-center" style="width:100px;">Total</th>

                  </tr>
                </thead>
                <tbody class="scrollable reimprimir_agua">
                  <!-- Aqui Aparecen los estado de cuenta-->

                </tbody>
              </table>


            </div>
          </div>
          

        </div>
        <!--FIN DETALLE ESTADO CUENTA-->


        <!--TABLA DE PREDIOS-->
        <div class="col-md-4 table-responsive">
          <div class="row table-responsive">
            <caption>Resumen a Cobrar</caption>
          </div>
          <table class="table-container" width="100%" id="tablaResumen">
            <thead>
              <tr>
                <td style="width:200px" class="text-right">N° correlativo</td>
                <td id="nc">0</td>
              </tr>
              <tr>
                <td class="text-right">Total S/.</td>
                <td id="total_reimprimir">0.00</td>
              </tr>
              <tr>
                <td>
                  <div class="col-md-1">
                    <div class="form-group">
                      <div class="input-group">
                        <img src="./vistas/img/iconos/imprimir.png" class="t-icon-tbl-imprimir print_impresora" title="Generar Boleta" id="liveToastBtn" data-target="#modalPagar_si_no">
                      </div>
                    </div>
                  </div>
                </td>
              </tr>
            </thead>
          </table>

          <div>
          <table class="miTabla_propietarios">
                <thead>
                  <th class="text-center">Codigo</th>
                  <th class="text-center">Nombres</th>
                  <th class="text-center">Carpeta</th>
                </thead>
                  <tbody id="propietarios_reimprimir">
    
                  <tbody>
              </table>
          </table>
          </div>

        </div>




      </div>
    </div>
  </section>
</div>


<!-- modal de imprimir estado cuenta -->
<div class="container-fluid">
  <div class="modal in" id="Modalimprimir_boleta" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-fullscreen">
      <div class="modal-content">
        <div class="modal-header">
        </div>
        <div class="modal-body printerhere">
          <iframe id="iframe_A4" class="iframe-full-height"></iframe>


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
<div class="modal fade" id="modalReimprimir_si_no" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="staticBackdropLabel">Reimprimir</h5>
      </div>
      <div class="modal-body">
        <h7>Estas Seguro de Reimprimir la Boleta como Cancelado de un total de <b><span id="total_confirmar"><!-- CONTENIDO DINAMICO--></span></b> &nbsp;?</h7>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-primary reimprimir_boleta">si</button>
      </div>
    </div>
  </div>
</div>
<!--Fin Modal confirma si pagar o no -->

       