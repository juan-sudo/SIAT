<?php
use Controladores\ControladorEmpresa;
use Controladores\ControladorPredio;
use Controladores\ControladorContribuyente;
?>

<div class="content-wrapper panel-medio-principal">
  <section class="container-fluid panel-medio">
      <div class="box"><h6>Compensacion de pagos</h6></div> 
  </section>
<!-- seccion de la Id-->
  <section class="container-fluid panel-medio">
        <div class="row">
            <div class="col">



                <div class="table-responsive col-md-5 div-background">
                            <div class="col-md-12"> 

                            <div class="row">
                                <span class="caption_"> 
                                        Origen
                                    </span>   

                                    
                                   

                                   

                                    <div class="pull-right" style="margin-left: 10px;">


                                   <button>Bucar contribuyente</button>
                                
                                </div>

                            </div>
                                   

                                  <div class="table-responsive">
                                        <table class="miTabla_propietarios  " >
                                    
                                        <thead>
                                            <th class="text-center">Codigo</th>
                                            <th class="text-center">Documento</th>
                                            <th class="text-center">Nombres</th>
                                            <th class="text-center">Carpeta</th>
                                          
                                        </thead>

                                        <tbody id="tabla_propietarios ">
                                           
                                            <tr>
                                                <td class="text-center">21</td>
                                                <td class="text-center">705023</td>
                                                <td class="text-center">JUAN DE LA CRUZ HUAMANI</td>
                                                <td class="text-center">2451</td>

                                            </tr>
                                                 <tr>
                                                <td class="text-center">21</td>
                                                <td class="text-center">705023</td>
                                                <td class="text-center">JUAN DE LA CRUZ HUAMANI</td>
                                                <td class="text-center">2451</td>

                                            </tr>
                                           
                                            



                                        </table>
                                        
                               </div>
                                    
                            </div>
                            <div class="box div_1">
                            <table class="table-container scrollable-table" id="tabla_extorno">
                              <thead>
                                <tr>
                                  <th class="text-center" style="width: 80px;">Cod.</th> 
                                  <th class="text-center" style="width: 80px;">Tributo</th> 
                                  <th class="text-center" style="width: 80px;">Año</th> 
                                  <th class="text-center" style="width: 80px;">Periodo</th> 
                                  <th class="text-center" style="width: 80px;">Importe</th> 
                                  <th class="text-center" style="width: 80px;">Gasto</th> 
                                  <th class="text-center" style="width: 80px;">Subtotal</th> 
                                  <th class="text-center" style="width: 80px;">Tim</th> 
                                  <th class="text-center" style="width: 80px;">Total</th> 
                                
                                 
                                
                                </tr>
                              </thead>

                              <tbody>
                                <tr>
                                  <td class="text-center">001</td>
                                  <td class="text-center">Impuesto Predial</td>
                                  <td class="text-center">2023</td>
                                  <td class="text-center">1</td>
                                  <td class="text-center">100.00</td>
                                  <td class="text-center">5.00</td>
                                  <td class="text-center">105.00</td>
                                  <td class="text-center">0.00</td>
                                  <td class="text-center">105.00</td>
                                </tr>
                                  <tr>
                                  <td class="text-center">001</td>
                                  <td class="text-center">Impuesto Predial</td>
                                  <td class="text-center">2023</td>
                                  <td class="text-center">1</td>
                                  <td class="text-center">100.00</td>
                                  <td class="text-center">5.00</td>
                                  <td class="text-center">105.00</td>
                                  <td class="text-center">0.00</td>
                                  <td class="text-center">105.00</td>
                                </tr>
                                  <tr>
                                  <td class="text-center">001</td>
                                  <td class="text-center">Impuesto Predial</td>
                                  <td class="text-center">2023</td>
                                  <td class="text-center">1</td>
                                  <td class="text-center">100.00</td>
                                  <td class="text-center">5.00</td>
                                  <td class="text-center">105.00</td>
                                  <td class="text-center">0.00</td>
                                  <td class="text-center">105.00</td>
                                </tr>
                                  <tr>
                                  <td class="text-center">001</td>
                                  <td class="text-center">Impuesto Predial</td>
                                  <td class="text-center">2023</td>
                                  <td class="text-center">1</td>
                                  <td class="text-center">100.00</td>
                                  <td class="text-center">5.00</td>
                                  <td class="text-center">105.00</td>
                                  <td class="text-center">0.00</td>
                                  <td class="text-center">105.00</td>
                                </tr>
                                  <tr>
                                  <td class="text-center">001</td>
                                  <td class="text-center">Impuesto Predial</td>
                                  <td class="text-center">2023</td>
                                  <td class="text-center">1</td>
                                  <td class="text-center">100.00</td>
                                  <td class="text-center">5.00</td>
                                  <td class="text-center">105.00</td>
                                  <td class="text-center">0.00</td>
                                  <td class="text-center">105.00</td>
                                </tr>
                                 <tr>
                                  <td class="text-center">001</td>
                                  <td class="text-center">Impuesto Predial</td>
                                  <td class="text-center">2023</td>
                                  <td class="text-center">2</td>
                                  <td class="text-center">100.00</td>
                                  <td class="text-center">5.00</td>
                                  <td class="text-center">105.00</td>
                                  <td class="text-center">0.00</td>
                                  <td class="text-center">105.00</td>
                                </tr>
                                  <tr>
                                  <td class="text-center">001</td>
                                  <td class="text-center">Impuesto Predial</td>
                                  <td class="text-center">2023</td>
                                  <td class="text-center">2</td>
                                  <td class="text-center">100.00</td>
                                  <td class="text-center">5.00</td>
                                  <td class="text-center">105.00</td>
                                  <td class="text-center">0.00</td>
                                  <td class="text-center">105.00</td>
                                </tr>
                                  <tr>
                                  <td class="text-center">001</td>
                                  <td class="text-center">Impuesto Predial</td>
                                  <td class="text-center">2023</td>
                                  <td class="text-center">2</td>
                                  <td class="text-center">100.00</td>
                                  <td class="text-center">5.00</td>
                                  <td class="text-center">105.00</td>
                                  <td class="text-center">0.00</td>
                                  <td class="text-center">105.00</td>
                                </tr>
                                  <tr>
                                  <td class="text-center">001</td>
                                  <td class="text-center">Impuesto Predial</td>
                                  <td class="text-center">2023</td>
                                  <td class="text-center">2</td>
                                  <td class="text-center">100.00</td>
                                  <td class="text-center">5.00</td>
                                  <td class="text-center">105.00</td>
                                  <td class="text-center">0.00</td>
                                  <td class="text-center">105.00</td>
                                </tr>
                                  <tr>
                                  <td class="text-center">001</td>
                                  <td class="text-center">Impuesto Predial</td>
                                  <td class="text-center">2023</td>
                                  <td class="text-center">2</td>
                                  <td class="text-center">100.00</td>
                                  <td class="text-center">5.00</td>
                                  <td class="text-center">105.00</td>
                                  <td class="text-center">0.00</td>
                                  <td class="text-center">105.00</td>
                                </tr>
                                <!-- Agregar más filas según sea necesario -->


                              </tbody>

                           


                            </table>
                            </div>
                </div>




                  <div class="table-responsive col-md-2 div-background" style="text-align: center;  height: 100vh;display: flex;justify-content: center;align-items: center;">
                            <div class="col-md-12"> 
                                 <button style="margin-bottom: 10px;">
                                   Agregar a destino   <i class="bi bi-arrow-return-right"></i>
                                  </button>

                                <button>
                                        <i class="bi bi-arrow-return-left"></i> Volver a destino
                                      </button>
                              
                        </div>
                         
                </div>



               
                 <div class="table-responsive col-md-5 div-background">
                            <div class="col-md-12"> 

                            <div class="row">
                                <span class="caption_"> 
                                        Origen
                                    </span>   

                                    
                                   

                                   

                                    <div class="pull-right" style="margin-left: 10px;">


                                   <button>Bucar contribuyente</button>
                                
                                </div>

                            </div>
                                   

                                  <div class="table-responsive">
                                        <table class="miTabla_propietarios " >
                                    
                                        <thead>
                                            <th class="text-center">Codigo</th>
                                            <th class="text-center">Documento</th>
                                            <th class="text-center">Nombres</th>
                                            <th class="text-center">Carpeta</th>
                                          
                                        </thead>

                                        <tbody id="tabla_propietarios">
                                           
                                            <tr>
                                                <td class="text-center">21</td>
                                                <td class="text-center">705023</td>
                                                <td class="text-center">JUAN DE LA CRUZ HUAMANI</td>
                                                <td class="text-center">2451</td>

                                            </tr>
                                                 <tr>
                                                <td class="text-center">21</td>
                                                <td class="text-center">705023</td>
                                                <td class="text-center">JUAN DE LA CRUZ HUAMANI</td>
                                                <td class="text-center">2451</td>

                                            </tr>
                                            <tr>
                                                <td class="text-center">21</td>
                                                <td class="text-center">705023</td>
                                                <td class="text-center">JUAN DE LA CRUZ HUAMANI</td>
                                                <td class="text-center">2451</td>

                                            </tr>
                                           
                                            



                                        </table>
                                        
                               </div>
                                    
                            </div>
                            <div class="box div_1" >

                            <table class="table-container scrollable-table " id="tabla_extorno" >
                              <thead>
                                <tr>
                                  <th class="text-center" style="width: 80px;">Cod.</th> 
                                  <th class="text-center" style="width: 80px;">Tributo</th> 
                                  <th class="text-center" style="width: 80px;">Año</th> 
                                  <th class="text-center" style="width: 80px;">Periodo</th> 
                                  <th class="text-center" style="width: 80px;">Importe</th> 
                                  <th class="text-center" style="width: 80px;">Gasto</th> 
                                  <th class="text-center" style="width: 80px;">Subtotal</th> 
                                  <th class="text-center" style="width: 80px;">Tim</th> 
                                  <th class="text-center" style="width: 80px;">Total</th> 
                                
                                 
                                
                                </tr>
                              </thead>

                              <tbody >
                                <tr>
                                  <td class="text-center">001</td>
                                  <td class="text-center">Impuesto Predial</td>
                                  <td class="text-center">2023</td>
                                  <td class="text-center">1</td>
                                  <td class="text-center">100.00</td>
                                  <td class="text-center">5.00</td>
                                  <td class="text-center">105.00</td>
                                  <td class="text-center">0.00</td>
                                  <td class="text-center">105.00</td>
                                </tr>
                                 <tr>
                                  <td class="text-center">001</td>
                                  <td class="text-center">Impuesto Predial</td>
                                  <td class="text-center">2023</td>
                                  <td class="text-center">2</td>
                                  <td class="text-center">100.00</td>
                                  <td class="text-center">5.00</td>
                                  <td class="text-center">105.00</td>
                                  <td class="text-center">0.00</td>
                                  <td class="text-center">105.00</td>
                                </tr>
                                     <tr>
                                  <td class="text-center">001</td>
                                  <td class="text-center">Impuesto Predial</td>
                                  <td class="text-center">2023</td>
                                  <td class="text-center">2</td>
                                  <td class="text-center">100.00</td>
                                  <td class="text-center">5.00</td>
                                  <td class="text-center">105.00</td>
                                  <td class="text-center">0.00</td>
                                  <td class="text-center">105.00</td>
                                </tr>
                                     <tr>
                                  <td class="text-center">001</td>
                                  <td class="text-center">Impuesto Predial</td>
                                  <td class="text-center">2023</td>
                                  <td class="text-center">2</td>
                                  <td class="text-center">100.00</td>
                                  <td class="text-center">5.00</td>
                                  <td class="text-center">105.00</td>
                                  <td class="text-center">0.00</td>
                                  <td class="text-center">105.00</td>
                                </tr>
                                     <tr>
                                  <td class="text-center">001</td>
                                  <td class="text-center">Impuesto Predial</td>
                                  <td class="text-center">2023</td>
                                  <td class="text-center">2</td>
                                  <td class="text-center">100.00</td>
                                  <td class="text-center">5.00</td>
                                  <td class="text-center">105.00</td>
                                  <td class="text-center">0.00</td>
                                  <td class="text-center">105.00</td>
                                </tr>
                                     <tr>
                                  <td class="text-center">001</td>
                                  <td class="text-center">Impuesto Predial</td>
                                  <td class="text-center">2023</td>
                                  <td class="text-center">2</td>
                                  <td class="text-center">100.00</td>
                                  <td class="text-center">5.00</td>
                                  <td class="text-center">105.00</td>
                                  <td class="text-center">0.00</td>
                                  <td class="text-center">105.00</td>
                                </tr>
                                  <tr>
                                  <td class="text-center">001</td>
                                  <td class="text-center">Impuesto Predial</td>
                                  <td class="text-center">2023</td>
                                  <td class="text-center">2</td>
                                  <td class="text-center">100.00</td>
                                  <td class="text-center">5.00</td>
                                  <td class="text-center">105.00</td>
                                  <td class="text-center">0.00</td>
                                  <td class="text-center">105.00</td>
                                </tr>
                                  <tr>
                                  <td class="text-center">001</td>
                                  <td class="text-center">Impuesto Predial</td>
                                  <td class="text-center">2023</td>
                                  <td class="text-center">2</td>
                                  <td class="text-center">100.00</td>
                                  <td class="text-center">5.00</td>
                                  <td class="text-center">105.00</td>
                                  <td class="text-center">0.00</td>
                                  <td class="text-center">105.00</td>
                                </tr>
                                  <tr>
                                  <td class="text-center">001</td>
                                  <td class="text-center">Impuesto Predial</td>
                                  <td class="text-center">2023</td>
                                  <td class="text-center">2</td>
                                  <td class="text-center">100.00</td>
                                  <td class="text-center">5.00</td>
                                  <td class="text-center">105.00</td>
                                  <td class="text-center">0.00</td>
                                  <td class="text-center">105.00</td>
                                </tr>
                                  <tr>
                                  <td class="text-center">001</td>
                                  <td class="text-center">Impuesto Predial</td>
                                  <td class="text-center">2023</td>
                                  <td class="text-center">2</td>
                                  <td class="text-center">100.00</td>
                                  <td class="text-center">5.00</td>
                                  <td class="text-center">105.00</td>
                                  <td class="text-center">0.00</td>
                                  <td class="text-center">105.00</td>
                                </tr>
                                <!-- Agregar más filas según sea necesario -->


                              </tbody>

                           


                            </table>


                             <button>
                                        Registrar compensacion
                                      </button>
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