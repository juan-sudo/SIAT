<?php
use Controladores\ControladorEmpresa;
use Controladores\ControladorPredio;
use Controladores\ControladorContribuyente;
?>

<div class="content-wrapper panel-medio-principal">
<section class="container-fluid panel-medio">
      <div class=""><h6>Cuadre de Ingresos Tributos - Agua</h6></div> 
  </section>
<!-- seccion de la Id-->
  <section class="container-fluid panel-medio">
        <div class="row">
            <div class="col">
                <div class="table-responsive box rounded col-xs-12 divDetallePredio_agua">
                            <div class="col-md-12"> 
                                    <span class="caption_"> 
                                        Reporte de Ingresos Tributos - Agua Potable
                                    </span>   
                                    <div class="pull-right">
                                      <input class="form-control-date" type="date" id="fecha" name="fecha">
                                      <img src="./vistas/img/iconos/print1.png" class="t-icon-tbl-imprimi_b generar_boleta_agua"  title="Imprimir Cuadre"  id="liveToastBtn" data-target="#modalPagar_si_no_agua" >
                                      </div>
                            </div>
                            <table class="table-container" id="primeraTabla_cuadre">
                              <thead>
                                <tr>
                                  <th class="text-center" style="width: 20px;">Cod.</th> 
                                  <th class="text-center" style="width: 490px;">Apellidos y Nombres</th>
                                  <th class="text-center" style="width: 40px;">tributo</th>
                                  <th class="text-center" style="width: 40px;">Año</th>
                                  <th class="text-center" style="width: 40px;">Periodo</th>
                                  <th class="text-center" style="width: 90px;">N° Recibo</th>
                                  <th class="text-center" style="width: 50px;">Importe</th>
                                  <th class="text-center" style="width: 50px;">Gastos</th>
                                  <th class="text-center" style="width: 50px;">Subtotal</th>
                                  <th class="text-center" style="width: 50px;">Des.</th>
                                  <th class="text-center" style="width: 50px;">TIM</th>
                                  <th class="text-center" style="width: 50px;">Total</th>
                                  <th class="text-center" style="width: 50px;">Estado</th>
                                </tr>
                              </thead>
                              <tbody id="reporte_tributosagua">
                                <!-- Aqui Aparecen el estado de cuenta Agua-->
                              </tbody>
                           
                            </table>
                        
                            
            </div>
        </div>
                         <div class=" col-xs-12">
                            <!-- segunda tabla donde muestra el boton imprimir y el total del estado de cuenta-->
                            <table class="table-container" id="segundaTabla_cuadre">
                              <tbody>
                                <tr>
                                <td class="text-center" style="width: 20px;"></td>
                                <td class="text-center" style="width: 490px;"></td>
                                <td class="text-center" style="width: 40px;"></td>
                                <td class="text-center" style="width: 40px;"></td>
                                <td class="text-center" style="width: 40px;"></td>
                                <td class="text-center" style="width: 90px;"></td>
                                <td class="text-center" style="width: 50px;" id="importe"></td>
                                <td class="text-center" style="width: 50px;" id="gasto"></td>
                                <td class="text-center" style="width: 50px;" id="subtotal"></td>
                                <td class="text-center" style="width: 50px;" id="desc"></td>
                                <td class="text-center" style="width: 50px;" id="tim"></td>
                                <td class="text-center" style="width: 50px;" id="total"></td>
                                <td class="text-center" style="width: 50px;"></td>
                                </tr>
                              </tbody>
                            </table>
                          </div>

</div>
        


          <div class="row box rounded">
            <!--TABLA DE PREDIOS-->
            <div class="col-md-6 table-responsive">
              <div class="row divIngresosAgua_cuadre">
                <table class="table-container" id="tablalistaprediosAgua_consulta_caja">
                <caption>Reporte Ingresos Tributos</caption>
                  <thead>
                    <tr>
                      <th class="text-center" style="width:250px;">Nombre del Tributo</th>
                      <th class="text-center" style="width: 40px;">Registros</th>
                      <th class="text-center" style="width: 40px;">Importe</th>
                      <th class="text-center" style="width: 40px;">Gastos</th>
                      <th class="text-center" style="width: 20px;">T.I.M</th>
                      <th class="text-center" style="width: 40px;">Total</th>
                    </tr>
                  </thead>
                   <tbody id="reporte_ingresos_cuadre">

                   </tbody> 
                </table>
              </div>
            </div>


              <div class="col-md-6 table-responsive">
              <div class="row divIngresosAgua_cuadre">
                            <table class="table-container miprimeratabla_agua_caja" id="primeraTabla_agua_caja">
                             <caption>Reporte Consolidado Ingreso Presupuestal</caption>
                              <thead>
                                <tr>
                                  <th class="text-center" style="width:40px;">Presupuesto</th>
                                  <th class="text-center" style="width:220px;">Nombre Presupuesto</th>
                                  <th class="text-center" style="width:40px;">Item</th>
                                  <th class="text-center" style="width:40px;">Importe</th>
                                </tr>
                              </thead>
                              <tbody id="reporte_ingresos_presu">
                                <!-- Aqui Aparecen el estado de cuenta Agua-->
                              </tbody>
                            </div>
                            </table>
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




<div class="resultados"></div>
<div id="errorLicence"><!--CONTENIDO DINAMICO  --></div>
<div id="respuestaAjax_correcto"></div>

