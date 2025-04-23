<?php
$carpeta = '../modulos/print/pdfs';
if (!file_exists($carpeta)) {
    mkdir($carpeta, 0777, true);
}
use Controladores\ControladorPredio;
use Controladores\ControladorContribuyente;
use Controladores\ControladorEstadoCuenta;
$idParam = $_GET['id'];
// Divide el valor en un array utilizando el guion (-) como delimitador
$idArray = explode('-', $idParam);
// Elimina elementos vacíos (por ejemplo, si hay varios guiones juntos)
$idArray = array_filter($idArray);
// Ahora $idArray contiene los valores sin guiones
?>
<div class="content-wrapper panel-medio-principal">
      <section class="container-fluid panel-medio">
        <div class="box container-fluid table-responsive"  style="border:0px; margin-bottom:3px; padding:0px;">
          <div class="col-lg-7 col-xs-7">
            <?php
            $datos_contribuyente = ControladorContribuyente::CntrVerificar_Parametro($idArray);
            if (count($datos_contribuyente) > 0) {
            ?>
           
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
        <div class="box rounded">
          <div class="box-body table-user">
              <div class="row" >
                      <!--estado de cuenta-->
                    <div class="col-md-12 table-responsive">
                        <div class="row divDetallePredio">
                            <table class="table-container" id="primeraTabla_reporte_pagados_IA">
                              <caption>Estado Cuenta Pagos de Impuesto - Arbitrios</caption>
                              <thead>
                                <tr>
                                  <th class="text-center">Cod.</th>
                                  <th class="text-center">Tributo</th>
                                  <th class="text-center">Año</th>
                                  <th class="text-center">Periodo</th>
                                  <th class="text-center">Fecha Pago</th>
                                  <th class="text-center">Estado</th>
                                  <th class="text-center">Importe</th>
                                  <th class="text-center">Gasto</th>
                                  <th class="text-center">Subtotal</th>
                                  <th class="text-center">T.I.M</th>
                                  <th class="text-center">Total</th>
                                  <th class="seleccionado text-center">S</th>
                                </tr>
                              </thead>
                              <tbody id="estadoCuenta" class="scrollable">
                                <!-- Aqui Aparecen los estado de cuenta-->
                                <?php
                                $estado_cuenta = ControladorEstadoCuenta::ctrEstadoCuenta_Pagado($idArray,"estadocuenta"); ?>
                              </tbody>
                            </table>
                        </div>

                      
                        <div class="row">
                          <!-- segunda tabla donde muestra el boton imprimir y el total del estado de cuenta-->
                          <table class="table-container" id="segundaTabla_reporte_pagados_IA">
                            <tbody>
                              <th class="text-center">
                                      <img src="./vistas/img/iconos/print1.png" class="t-icon-tbl-imprimi_b" title="Imprimir Estado Cuenta" id="popimprimir_pagados" data-target="#Modalimprimir_cuenta" >
                              </th>
                              <!-- no eliminar los Td-->
                              <th class="text-center total_c"></th>
                              <th class="text-center"></th>
                             
                              <th class="text-center td-round total_c"></th>
                              <th class="text-center td-round"></th>
                              <th class="text-center td-round total_c">Total Pagado =</th>
                              <th class="text-center td-round"></th>
                              <th class="text-center td-round"></th>
                              <th class="text-center td-round"></th>
                              <th class="text-center"></th>
                              <th class="text-center"></th>
                            </tbody>
                          </table>
                        </div>
                    </div>

                   
              </div>  
          </div>
        </div>
      </section>
</div>

  <!-- modal de imprimir estado cuenta -->
  <div class="container-fluid">
            <div class="modal in" id="Modalimprimir_cuenta"  data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-fullscreen">
                      <div class="modal-content">
                        <div class="modal-header">
                        </div>
                        <div class="modal-body printerhere">
                          <iframe id="iframe_pagados" class="iframe-full-height"></iframe>


                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                      </div>
                    </div>
            </div>
  </div>
<!-- fin de imprimir estado de cuenta-->
<?php
        } else {
          echo "<div>error al cargar la pagina</div>";
        } ?>
