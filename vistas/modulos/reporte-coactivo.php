<?php
use Controladores\ControladorEmpresa;
use Controladores\ControladorPredio;
use Controladores\ControladorContribuyente;
?>

<div class="content-wrapper panel-medio-principal">
  <section class="container-fluid panel-medio">
      <div class="box"><h6>Pagos coactivo</h6></div> 
  </section>
<!-- seccion de la Id-->
  <section class="container-fluid panel-medio">
        <div class="row">
            <div class="col">
                <div class="table-responsive col-md-8 div-background">
                            <div class="col-md-12"> 
                                    <span class="caption_"> 
                                        Reporte de Ingresos tributario coactivo
                                    </span>   

                                   

                                    <div class="pull-right" style="margin-left: 10px;">
                                      <label for="fecha_filtro_fin" style="margin-right: 5px;">Fecha fin:</label>
                                      <input class="busqueda_filtros_anio" type="date" id="fecha_filtro_fin" name="fecha_filtro_fin">
                                    </div>

                                    <div class="pull-right" style="margin-left: 10px;">
                                    <label for="fecha_filtro_inicio" style="margin-right: 5px;">Fecha inicio:</label>
                                    <input class="busqueda_filtros_anio" type="date" id="fecha_filtro_inicio" name="fecha_filtro_inicio">
                                  </div>

                                    
                            </div>
                            <div class="box div_1">
                            <table class="table-container" id="tabla_extorno">
                              <thead>
                                <tr>
                                  <th class="text-center" style="width: 80px;">Fecha de Pago</th> 
                                  <th class="text-center" style="width: 50px;">N° Recibo</th>
                                  <th class="text-center" style="width: 50px;">Total</th>
                                 
                                
                                </tr>
                              </thead>

                              <tbody id="reporte_ingreso_coactivo">
                                <!-- Aqui Aparecen el estado de cuenta Agua-->
                              </tbody>
                             <tfoot>
                                <tr>
                                  <td colspan="2" class="text-right total-text"><strong>Total:</strong></td>
                                  <td id="total_ingreso_coactivo" class="text-center total-text"><strong>0.00</strong></td>
                                </tr>
                              </tfoot>


                            </table>
                            </div>
                </div>
            </div>
      </div>
        
        </div>
      </div>
    </div>
  </section>
</div>

<!-- modal cargando -->
<?php include_once "modalcargar.php";  ?>
<!-- fin de modal cargando-->

<!-- MODAL CONFIRMAR EL EXTORNO-->
<div class="modal fade" id="modalExtornar_si_no" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="staticBackdropLabel">EXTORNAR RECIBO</h5>
      </div>
      <div class="modal-body">
        <h7>Estas Seguro de Extornar el N° Recibo  <b><span id="nr_extorno"><!-- CONTENIDO DINAMICO--></span></b>?</h7>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-primary extornar_si">si</button>
      </div>
    </div>
  </div>
</div>
<!-- FIN MODAL CONFIRMAR EXTORNO-->