<?php
use Controladores\ControladorEmpresa;
use Controladores\ControladorPredio;
use Controladores\ControladorContribuyente;
?>

<div class="content-wrapper panel-medio-principal">
  <section class="container-fluid panel-medio">
      <div class="box"><h6>Reporte general</h6></div> 
  </section>



<!-- seccion de la Id-->

 <section class="container-fluid panel-medio" style="margin-bottom: 0.5rem;">
        <div class="row">
            <div class="col">


               <div class="col-md-3  shadow-sm rounded"  >
                  <div class="card div-background">

                      <div class="card-body text-center" style="padding: 1rem; background: linear-gradient(to right, #07472d, #23a16e);">
  
                      <div class="row" style="border-bottom: 1px solid #d5d8de; margin: 0 auto;">
                         <div class="col-12">

                              <div class="col-md-3">
                              <!-- Icono de la carpeta -->
                                       <img src="http://localhost/SIAT/vistas/img/iconos/carpeta1.png" alt="Carpeta" style="width: 40px; height: 40px;">
                              </div>

                               <div class="col-md-9">
                                  <!-- Título -->
                                  <p class="text-muted  text-left" style="margin: 0; color:#d5d8de; font-weight: 600;">Total Carpetas</p>
                                
                                  <!-- Valor Total Carpetas -->
                                <p class="card-text text-primary text-left font-weight-bold" style="font-size: 22px; color:#d5d8de; font-weight: 600; " id="totalCarpetas"></p>


                                </div>


                          </div>


                       

                          </div>

                         <div class="row">

                              <div class="col-12" style="display: flex; justify-content: space-between; align-items: center; ">
                                  <span class="text-muted text-left" style="margin: 0; color:#d5d8de"></span>
                                  <span class="card-text text-primary text-left font-weight-bold" style="font-weight: 600; color:#d5d8de" id="totalCarpetas">.</span>
                              </div>



                              <div class="col-12" style="display: flex; justify-content: space-between; align-items: center;  font-size: 18px;">
                                    <span class="text-muted" style="margin: 0; color:#d5d8de ;font-weight: 600;">Ultima carpeta </span>
                                    <span class="card-text text-primary font-weight-bold" style="font-weight: 600; color:#d5d8de" id="ultimaCarpeta"></span>
                                </div>


                       </div>



                         

                          
                          <!-- Línea de separación -->
                       
                      </div>



                  </div>
              </div>



              

               <div class="col-md-3  shadow-sm rounded"  >
                  <div class="card div-background">

                      <div class="card-body text-center" style="padding: 1rem; background: linear-gradient(to right, #09282e, #1b7a8c);">
  
                      <div class="row" style="border-bottom: 1px solid #d5d8de; margin: 0 auto;">
                         <div class="col-12">

                              <div class="col-md-3">
                              <!-- Icono de la carpeta -->
                                       <img src="http://localhost/SIAT/vistas/img/iconos/transferir.png" alt="Carpeta" style="width: 40px; height: 40px;">
                              </div>

                               <div class="col-md-9">
                                  <!-- Título -->
                                  <p class="text-muted  text-left" style="margin: 0; color:#d5d8de; font-weight: 600;">Total Contribuyentes</p>
                                
                                  <!-- Valor Total Carpetas -->
                                <p class="card-text text-primary text-left font-weight-bold" style="font-size: 22px; color:#d5d8de; font-weight: 600; " id="totalContribuyentes"></p>


                                </div>


                          </div>


                       

                          </div>

                         <div class="row">

                              <div class="col-12" style="display: flex; justify-content: space-between; align-items: center; ">
                                  <span class="text-muted text-left" style="margin: 0; color:#d5d8de">Contribuyenetes fallecidos</span>
                                  <span class="card-text text-primary text-left font-weight-bold" style="font-weight: 600; color:#d5d8de" id="totalFallecidas"></span>
                              </div>



                              <div class="col-12" style="display: flex; justify-content: space-between; align-items: center;  font-size: 18px;">
                                    <span class="text-muted" style="margin: 0; color:#d5d8de ;font-weight: 600;"> Ultimo codigo </span>
                                    <span class="card-text text-primary font-weight-bold" style="font-weight: 600; color:#d5d8de" id="totalContribuyente"></span>
                                </div>


                       </div>



                         

                          
                          <!-- Línea de separación -->
                       
                      </div>



                  </div>
              </div>



              

               <div class="col-md-3  shadow-sm rounded"  >
                  <div class="card div-background">

                      <div class="card-body text-center" style="padding: 1rem; background: linear-gradient(to right, #692a13, #b85f3e);">
  
                      <div class="row" style="border-bottom: 1px solid #d5d8de; margin: 0 auto;">
                         <div class="col-12">

                              <div class="col-md-3">
                              <!-- Icono de la carpeta -->
                                       <img src="http://localhost/SIAT/vistas/img/iconos/predio5.png" alt="Carpeta" style="width: 60px; height: 60px;">
                              </div>

                               <div class="col-md-9">
                                  <!-- Título -->
                                  <p class="text-muted  text-left" style="margin: 0; color:#d5d8de; font-weight: 600;">Total predios</p>
                                
                                  <!-- Valor Total Carpetas -->
                                <p class="card-text text-primary text-left font-weight-bold" style="font-size: 22px; color:#d5d8de; font-weight: 600; " id="totalPredios"></p>


                                </div>


                          </div>


                       

                          </div>

                         <div class="row">

                              <div class="col-12" style="display: flex; justify-content: space-between; align-items: center; ">
                                  <span class="text-muted text-left" style="margin: 0; color:#d5d8de">Predios rustico</span>
                                  <span class="card-text text-primary text-left font-weight-bold" style="font-weight: 600; color:#d5d8de" id="totalPrediosr">42</span>
                              </div>



                              <div class="col-12" style="display: flex; justify-content: space-between; align-items: center;  font-size: 18px;">
                                    <span class="text-muted" style="margin: 0; color:#d5d8de ;font-weight: 600;"> Predios urbanos </span>
                                    <span class="card-text text-primary font-weight-bold" style="font-weight: 600; color:#d5d8de" id="totalPrediosu">42</span>
                                </div>


                       </div>



                         

                          
                          <!-- Línea de separación -->
                       
                      </div>



                  </div>
              </div>



                            

               <div class="col-md-3  shadow-sm rounded"  >
                  <div class="card div-background">

                      <div class="card-body text-center" style="padding: 1rem; background: linear-gradient(to right, #262629, #686875);">
  
                      <div class="row" style="border-bottom: 1px solid #d5d8de; margin: 0 auto;">
                         <div class="col-12">

                              <div class="col-md-3">
                              <!-- Icono de la carpeta -->
                                       <img src="http://localhost/SIAT/vistas/img/iconos/FORMATO.png" alt="Carpeta" style="width: 60px; height: 60px;">
                              </div>

                               <div class="col-md-9">
                                  <!-- Título -->
                                  <p class="text-muted  text-left" style="margin: 0; color:#d5d8de; font-weight: 600;">Total licencias</p>
                                
                                  <!-- Valor Total Carpetas -->
                                <p class="card-text text-primary text-left font-weight-bold" style="font-size: 22px; color:#d5d8de; font-weight: 600; " id="totalLicencias"></p>


                                </div>


                          </div>


                       

                          </div>

                         <div class="row">

                              <div class="col-12" style="display: flex; justify-content: space-between; align-items: center; ">
                                  <span class="text-muted text-left" style="margin: 0; color:#d5d8de"></span>
                                  <span class="card-text text-primary text-left font-weight-bold" style="font-weight: 600; color:#d5d8de" id="totalCarpetas">.</span>
                              </div>



                              <div class="col-12" style="display: flex; justify-content: space-between; align-items: center;  font-size: 18px;">
                                    <span class="text-muted" style="margin: 0; color:#d5d8de ;font-weight: 600;"> Ultima licencia </span>
                                    <span class="card-text text-primary font-weight-bold" style="font-weight: 600; color:#d5d8de" id="ultimaLicencia"></span>
                                </div>


                       </div>



                         

                          
                          <!-- Línea de separación -->
                       
                      </div>



                  </div>
              </div>

            

             
                 
              

               
            </div>
      </div>
        
       
  </section>

  <!-- REPORTE ESTADISTICO -->
  <section class="container-fluid panel-medio">
        <div class="row">
            <div class="col">
                <div class="table-responsive col-md-6 div-background">
                    <p>Reporte actualizacion carpetas</p>
                    <canvas id="myChart" width="400" height="200"></canvas>
                </div>


               <div class="table-responsive col-md-6 div-background">
                          <p>Reporte actualizacion licencia agua</p>
                    <canvas id="myChartl" width="400" height="200"></canvas>
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