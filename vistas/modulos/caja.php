<?php
$carpeta = '../modulos/print/pdfs';
if (!file_exists($carpeta)) {
  mkdir($carpeta, 0777, true);
}

use Controladores\ControladorPredio;
use Controladores\ControladorContribuyente;
use Controladores\ControladorEstadoCuenta;

$idParam = $_GET['id'];
$idArray = explode('-', $idParam);
$idArray = array_filter($idArray);
?>
<div class="content-wrapper panel-medio-principal">
  <section class="container-fluid panel-medio">
    <div class="box container-fluid table-responsive" style="border:0px; margin-bottom:3px; padding:0px;">
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

  <section class="container-fluid panel-medio ">
    <div class="box rounded table-responsive">
      <div class="row">

        <div class="col-md-8 table-responsive">
          <div class="row divDetallePredio">
            <div class="row">
              <div class="col-md-12 table-responsive">
                <div class="col-md-9">
                  Estdo de Cuenta + Tasa de Interes Moratorio (TIM)
                </div>
                <div class="col-md-3">
                  <select class="form-control" id="select_tributo" name="select_tributo" onchange="load_tributo(1)">
                    <option value='006'>Impuesto Predial</option>';
                    <option value='742'>Arbitrio Municipal</option>';
                    ?>
                  </select>
                </div>
              </div>
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
                    <th class="seleccionado text-center" style="width:50px;">S</th>

                  </tr>
                </thead>
                <tbody id="estadoCuenta" class="scrollable estadocuentacaja">
                  <!-- Aqui Aparecen los estado de cuenta-->

                </tbody>
              </table>
            </div>
          </div>
          <div class="row">
            <!-- segunda tabla donde muestra el boton imprimir y el total del estado de cuenta-->
            <table class="table-container" id="segundaTabla_caja" class="table table-bordered">
              <tbody>
                <tr>
                  <th class="text-center td-round" style="width:600px;" colspan="4">Total Deuda = </th>
                  <th class="text-center td-round" style="width:100px;"></th>
                  <th class="text-center td-round" style="width:100px;"></th>
                  <th class="text-center td-round" style="width:100px;"></th>
                  <th class="text-center td-round" style="width:100px;"></th>
                  <th class="text-center td-round" style="width:100px;"></th>
                  <th class="text-center" style="width:50px;"></th>
                </tr>
              </tbody>
            </table>
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
                <td style="width:250px" class="text-right">Total de Impuesto Predial S/.</td>
                <td id='total_impuesto'>0.00</td>

              </tr>
              <tr>
                <td class="text-right">Total de Arbitrios Municipales S/.</td>
                <td id='total_arbitrios'>0.00</td>
              </tr>

              <tr>
                <td class="text-right">Efectivo S/.</td>
                <td><input type="text" placeholder="0.00" class="form3" id="efectivo" oninput="sumarValores()"></input></td>

              </tr>
              <tr>
                <td class="text-right">Vuelto S/.</td>
                <td><input type="text" placeholder="0.00" class="form3" id="vuelto"></input></td>
              </tr>

              <tr>
                <td class="text-right">Total S/.</td>
                <td id="total_caja">0.00</td>
              </tr>
              <tr>
                <td>
                  <div class="col-md-1">
                    <div class="form-group">
                      <div class="input-group">
                        <img src="./vistas/img/iconos/imprimir.png" class="t-icon-tbl-imprimir generar_boleta" title="Generar Boleta" id="liveToastBtn" data-target="#modalPagar_si_no">
                      </div>
                    </div>
                  </div>
                </td>
              </tr>
            </thead>
          </table>
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
<div class="modal fade" id="modalPagar_si_no" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="staticBackdropLabel">Recaudación</h5>
      </div>
      <div class="modal-body">
        <h7>Estas Seguro de Generar la Boleta como Cancelado de un total de <b><span id="total_confirmar"><!-- CONTENIDO DINAMICO--></span></b> &nbsp;?</h7>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-primary print_boleta_impuestoarbitrios">si</button>
      </div>
    </div>
  </div>
</div>
<!--Fin Modal confirma si pagar o no -->
<?php
        } else {
          echo "<div>error al cargar la pagina</div>";
        } ?>