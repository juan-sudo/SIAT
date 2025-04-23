<?php
use Controladores\ControladorEmpresa;
use Controladores\ControladorPredio;
use Controladores\ControladorContribuyente;
?>

<div class="content-wrapper panel-medio-principal">
  

<section class="container-fluid panel-medio">
  <div class=""><h6>Cuadre de Ingresos de Especies Valoradas</h6></div> 
  </section>
<!-- seccion de la Id-->
  <section class="container-fluid panel-medio">
        <div class="row">
            <div class="col">
                <div class="table-responsive box rounded col-xs-12 divDetallePredio_agua">
                            <div class="col-md-12"> 
                                    <span class="caption_"> 
                                    Reporte Venta Especie Valorada
                                    </span>   
                                    <div class="pull-right">
                                      <input class="form-control-date" type="date" id="fecha_especie" name="fecha_especie">
                                      <img src="./vistas/img/iconos/print1.png" class="t-icon-tbl-imprimi_b generar_boleta_agua"  title="Imprimir Cuadre especie"  id="liveToastBtn" data-target="#modalPagar_si_no_agua" >
                                      </div>
                            </div>
                            <table class="table-container miprimeratabla_cuadre" id="primeraTabla_cuadre_especie">
                              <thead>
                                <tr>
                                  <th class="text-center" style="width: 170px;">Area</th> 
                                  <th class="text-center" style="width: 300px;">Descripcion Especie Valorada</th>
                                  <th class="text-center" style="width: 200px;">Nombre - Razon Social</th>
                                  <th class="text-center" style="width: 40px;">N° Recibo</th>
                                  <th class="text-center" style="width: 20px;">Cantidad</th>
                                  <th class="text-center" style="width: 40px;">P.Unit.</th>
                                  <th class="text-center" style="width: 40px;">Total</th>
                                  <th class="text-center" style="width: 30px;">Estado</th>
                                </tr>
                              </thead>
                              <tbody id="reporte_especie">
                                <!-- Aqui Aparecen el estado de cuenta Agua-->
                              </tbody>
                           
                            </table>
                        
                            
            </div>
        </div>
                         <div class=" col-xs-2 pull-right">
                            <!-- segunda tabla donde muestra el boton imprimir y el total del estado de cuenta-->
                            <table class="table-container" id="segundaTabla_cuadre_especie">
                              <tbody>
                                <td class="text-center box rounded"> Total S/. </td>
                                <td class="box" style="width:200px;" id="especie_total"></td>
                                
                                </tr>
                              </tbody>
                            </table>
                          </div>
                          <div class="col-xs-5"></div>

</div>
        


          <div class="row box rounded">
            <!--TABLA DE PREDIOS-->
            <div class="col-md-6 table-responsive">
              <div class="row divIngresosAgua_cuadre">
                <table class="table-container" id="">
                <caption>Consolidado Presupuestal Especie Valoradas</caption>
                  <thead>
                    <tr>
                      <th class="text-center" style="width:30px;">Presupuestal</th>
                      <th class="text-center" style="width: 270px;">Descripcion Especie Valorada</th>
                      <th class="text-center" style="width: 30px;">Items</th>
                      <th class="text-center" style="width: 40px;">P.Unit</th>
                      <th class="text-center" style="width: 40px;">Total</th>
                    </tr>
                  </thead>
                   <tbody id="reporte_especie_cuadre">
                   </tbody> 
                </table>
              </div>
            </div>


              <div class="col-md-6 table-responsive">
              <div class="row divIngresosAgua_cuadre">
                            <table class="table-container miprimeratabla_agua_caja" id="">
                             <caption>Reporte Venta Especies Valoradas por Area</caption>
                              <thead>
                                <tr>
                                  <th class="text-center" style="width:300px;">Area - Oficina</th>
                                  <th class="text-center" style="width:20px;">Cantidad</th>
                                  <th class="text-center" style="width:40px;">Total</th>
                                </tr>
                              </thead>
                              <tbody id="reporte_especie_area">
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

