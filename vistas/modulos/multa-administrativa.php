<?php
use Controladores\ControladorPredio;
use Controladores\ControladorContribuyente;
use Controladores\ControladorEspecievalorada;
use Controladores\ControladorPisos;
?>
<div class="content-wrapper panel-medio-principal">
  <section class="container-fluid panel-medio">
    <div class="box rounded">
      <div class="row">
        <!-- PROVEIDOS -->
        <div class="col-md-12 table-responsive divDetallePredio">
          <div class="col-md-12">
            <span class="caption_">Multa Administrativa Registrados</span>
            <button class="btn-1 btn btn-secundary pull-right" id="MostrarmodalNuevoProveido">Nueva Multa</button>
          </div>
          <table class="table-container" id="listaDeProveidosEmitidos">
            <thead>
              <tr>
                <th class="text-center">N° Multa</th>
                <th class="text-center">Nombres y apellidos</th>
                <th class="text-center">Monto</th>
                <th class="text-center">Detalle Pago</th>
                <th class="text-center">Accion</th>
              </tr>
            </thead>
            <tbody id="listaProveidos">
              <!-- Aqui Aparecen los Licencias del Piso-->
            </tbody>
          </table>
        </div>
      </div>

    </div>
</div>
</section>
<!--====== MODAL EDITAR PROVEIDO =============-->
<div class="modal fade " id="modalEditarProveido" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="rounded">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <label class="modal-title">Editar Proveido</label>
        </div>
        <div class="modal-body">
          <form role="form" method="POST" class="formRegistrarProveido_e" id="formRegistrarProveido_e">
            <div class="row">
            <div class="col-3 col-md-3"><label>N° Multa:</label></div>
            <div class="col-1 col-md-1">  <input type="text" class="form-control" name="nroProveido_e" id="nroProveido_e" readonly></div>
            </div>
            <div class="row">
              <div class="col-3 col-md-3"><label >DNI/RUC:</label></div>
              <div class="col-3 col-md-3"><input class="form-control" name="dniProveido_e" id="dniProveido_e" required maxlength="11"></div>
            </div>
            <div class="row"> <!-- Otorgado a-->
            <div class="col-3 col-md-3"> <label>Nombres y Apellidos/Rz.social:</label></div>
            <div class="col-8 col-md-8"><input type="text" class="form-control" name="nombreProveido_e" id="nombreProveido_e" required></div>
            </div>
            <div class="row"> <!-- Otorgado a-->
            <div class="col-3 col-md-3"> <label>Direccion</label></div>
            <div class="col-8 col-md-8"><input type="text" class="form-control" name="nombreProveido_e" id="nombreProveido_e" required></div>
            </div>

            <div class="row"> <!-- Otorgado a-->
            <div class="col-3 col-md-3"> <label>Celular:</label></div>
            <div class="col-8 col-md-8"><input type="text" class="form-control" name="nombreProveido_e" id="nombreProveido_e" required></div>
            </div>

            <div class="row"> <!-- Otorgado a-->
            <div class="col-3 col-md-3"> <label>Fecha Multa Impuesta</label></div>
            <div class="col-8 col-md-8"><input type="text" class="form-control" name="nombreProveido_e" id="nombreProveido_e" required></div>
            </div>
            <i class="bi bi-node-plus-fill"><spam class="modalMostrar_EspecieValorada_b link">Agregar Multa Administrativa</spam></i>
            <div>
            </form>
            <div class="row"> <!-- Otorgado a-->
            <span>Sube la multa administrativa</span>
            <input type="file" id="fileInput" multiple accept="image/*, .pdf, .doc, .docx">
            </div>   
            <table class="table-container" id="primeraTabla_caja">
                <thead>
                  <tr>
                    <th class="text-center" style="width:10px;">N°</th>
                    <th class="text-center" style="width:300px;">Nombre Multa</th>
                    <th class="text-center" style="width:100px;">Area</th>
                    <th class="text-center" style="width:40px;">Cantidad</th>
                    <th class="text-center" style="width:100px;">Monto</th>
                    <th class="text-center" style="width:100px;">Total</th>
                    <th class="text-center" style="width:10px;">Accion</th> 
                  </tr>
                </thead>
                <tbody id="especie_valorada_a_e" class="scrollable especievalorad_a">
                  <!-- Aqui Aparecen los estado de cuenta-->
                </tbody>
              </table>
            </div>

            <table class="table-container" id="primeraTabla_caja">
                <thead>
                  <tr>
                    <td class="text-right" style="width:700px;">Total de Pagar=</td>
                    <td class="text-left" ><input type="text" style="width:100px;"  class="text-center form-control" name="totalProveido_e" id="totalProveido_e"  readonly></td>
                    
                  </tr>
                </thead>
                
              </table>
            <div class="modal-footer">
              <button type="button" id="salirRegistroModal" class="btn btn-secondary cerrar_proveido" data-dismiss="modal">Salir</button>
              <button type="button" class="btn btn-primary" id="btnRegistrar_editar_Proveido" data-dismiss="modal">Registrar</button>
            </div>
            <div class="row2 col-md-12" id="errorProveido">
              <!--CONTENIDO DINAMICO DE MENSAJE POR NO COMPLETAR CAMPOS -->
            </div>
        </div>
        <div id="respuestaFecha">
        </div>
      </div>
    </div>
  </div>
</div>

<div class="resultados"></div>
</div>
<!--====== FIN MODAL EDITAR PROVEIDO =============-->


<!--====== MODAL NUEVO PROVEIDO =============-->
<div class="modal fade " id="ModalNuevoProveido" tabindex="-1" role="dialog" data-backdrop="static"  aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="rounded">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <label class="modal-title">Nueva Multa Administrativa</label>
        </div>
        <div class="modal-body">
          <form role="form" method="POST" class="formRegistrarProveido" id="formRegistrarProveido">
            <div class="row">
            <div class="col-3 col-md-3"><label>N° Proveido:</label></div>
            <div class="col-1 col-md-1">  <input type="text" class="form-control" name="nroProveido" id="nroProveido" readonly></div>
            </div>
            <div class="row">
              <div class="col-3 col-md-3"><label >DNI/RUC:</label></div>
              <div class="col-3 col-md-3"><input class="form-control" name="dniProveido" id="dniProveido" maxlength="11" required></div>
            </div>

            <div class="row"> <!-- Otorgado a-->
            <div class="col-3 col-md-3"> <label>Nombres y Apellidos/Rz.social:</label></div> 
            <div class="col-8 col-md-8"><input type="text" class="form-control" name="nombreProveido" id="nombreProveido" required></div>
            </div>

            <div class="row"> <!-- Otorgado a-->
            <div class="col-3 col-md-3"> <label>Dirección</label></div> 
            <div class="col-8 col-md-8"><input type="text" class="form-control" name="nombreProveido" id="nombreProveido" required></div>
            </div>
            
            <div class="row"> <!-- Otorgado a-->
            <div class="row"> <!-- Otorgado a-->
            <div class="col-md-3"> <label>Celular</label></div> 
            <div class="col-8 col-md-3"><input type="text" class="form-control" name="nombreProveido" id="nombreProveido" required></div>
            </div>
            <br>
            <div> <!-- Otorgado a-->
            <div class="col-3 col-md-3"> <label>Fecha Multa Impuesta</label></div> 
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="date" id="fechaProveido" class="busqueda_filtros  ">
            </div>
          
            <div class="row"> <!-- Otorgado a-->
            <div class="col-md-3"> <label>Documento de la Multa</label></div> 
            <div class="col-md-8">
            <input type="file" id="fileInput" multiple accept="image/*, .pdf, .doc, .docx">
            </div>
            </div>   
            <br>
            </div>
           
            <i class="bi bi-node-plus-fill"><spam class="modalMostrar_EspecieValorada_b link">Agregar Multa Administrativa</spam></i>
            <div>

            </form>
               
            <table class="table-container" id="primeraTabla_caja">
                <thead>
                  <tr>
                    <th class="text-center" style="width:10px;">N°</th>
                    <th class="text-center" style="width:300px;">Nombre Especie</th>
                    <th class="text-center" style="width:100px;">Area</th>
                    <th class="text-center" style="width:40px;">Cantidad</th>
                    <th class="text-center" style="width:100px;">Monto</th>
                    <th class="text-center" style="width:100px;">Total</th>
                    <th class="text-center" style="width:10px;">Accion</th> 
                  </tr>
                </thead>
                <tbody id="especie_valorada_a" class="scrollable especievalorad_a">
                  <!-- Aqui Aparecen los estado de cuenta-->
                </tbody>
              </table>
            </div>

          
            <table class="table-container" id="primeraTabla_caja">
                <thead>
                  <tr>
                    <td class="text-right" style="width:700px;">Total de Pagar=</td>
                    <td class="text-left" ><input type="text" style="width:100px;"  class="text-center form-control" name="totalProveido" id="totalProveido" class="form2" readonly></td>
                    
                  </tr>
                </thead>
                
              </table>

            <div class="modal-footer">
              <button type="button" id="salirRegistroModal" class="btn btn-secondary cerrar_proveido" data-dismiss="modal">Salir</button>
              <button type="button" class="btn btn-primary" id="btnRegistrarProveido" data-dismiss="modal">Registrar</button>
            </div>
            <div class="row2 col-md-12" id="errorProveido">
              <!--CONTENIDO DINAMICO DE MENSAJE POR NO COMPLETAR CAMPOS -->
            </div>
        </div>
        <div id="respuestaFecha">
        </div>
      </div>
    </div>
  </div>
</div>

<div class="resultados"></div>
</div>

<!-- modal donde se genera el PDF LA -->
<div class="container-fluid">
  <div class="modal in" id="GenerarProveido" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-fullscreen">
      <div class="modal-content">
        <div class="modal-header">
        </div>
        <div class="modal-body printerhere">
          <iframe id="iframe_proveido" class="iframe-full-height"><!-- Muestra el PDF --></iframe>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- fin de generar pdf LA-->



<!--====== MODAL AGREGAR ESPECIE -->
<div class="modal fade " id="modalAgregarEspecie_valorada" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
       Agregar Especie Valorada
      </div>
      <div class="modal-body">
  

  <section class="container-fluid panel-medio ">
    <div class="box rounded table-responsive">
      <div class="row">
        <div class="col-md-12">
        <input type="text" class="filtro_tabla" id="searchInput" placeholder="Buscar el nombre de la especie valorada ...." onkeyup="searchTable('proveido')">
        <div class="box divproveido"> 
          <table class="table-container" id="tbListaEspeciesV">
            <thead>
              <tr>
                <th class="text-center" style="width:10px;">N°</th>
                <th class="text-center">Nombre Especie</th>
                <th class="text-center">Area</th>
                <th class="text-center">Monto</th>
                <th class="text-center">Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $especie = ControladorEspecievalorada::ctrMostrarEspecievalorada_multa();
              foreach ($especie as $key => $value) :
              ?>
                <tr class="filaEspeciev">
                  <td class="text-center"><?php echo ++$key; ?></td>
                  <td><?php echo $value['Nombre_Especie']; ?> &nbsp&nbsp  <?php echo $value['Detalle']; ?></td>
                  <td><?php echo $value['Nombre_Area']; ?></td>
                  <td class="text-center"><?php echo $value['Monto']; ?></td>
                  <td class="text-center">
                    <div class="btn-group">
                      <img src="./vistas/img/iconos/agregar.png" class="t-icon-tbl-p btnModalNuevoProveido" title="Generar Proveido" idEspecie="<?php echo $value['Id_Especie_Valorada'] ?>" idAreap="<?php echo $value['Id_Area'] ?>" editable="<?php echo $value['editable'] ?>">
                    </div>
                  </td>
                </tr>
              <?php
              endforeach;
              ?>
            </tbody>
          </table>
          </div>


        </div>
    </div>
  </section>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
      </div>
    </div>
  </div>
</div>
<!--FIN DE MODAL GENERAR PROVEIDO-->


<!--======MODAL DE PROVEIDO CANCELADO--> 
<div class="modal fade " id="ModalEstadoPagoProveido" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="rounded">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <label class="modal-title">Estado de Pago del Proveido</label>
        </div>
        <div class="modal-body" style="padding: 20px !important;">     
            <table class="table-container" id="primeraTabla_caja">
                <thead>
                  <tr>
                    <th class="text-center" style="width:10px;">N° Proveido</th>
                    <th class="text-center" style="width:300px;">Nombre Especie</th>
                    <th class="text-center" style="width:100px;">Area</th>
                    <th class="text-center" style="width:40px;">Cantidad</th>
                    <th class="text-center" style="width:100px;">Monto</th>
                    <th class="text-center" style="width:100px;">Total</th>
                    <th class="text-center" style="width:100px;">Estado Pago</th>
                  </tr>
                </thead>
                <tbody id="especie_valorada_estado_caja" class="scrollable especievalorad_a">
                  <!-- Aqui Aparecen los estado de cuenta-->
                </tbody>
              </table>
            </div>

            <div class="modal-footer">
              <button type="button" id="salirRegistroModal" class="btn btn-secondary" data-dismiss="modal">Salir</button>
            </div>
            <div class="row2 col-md-12" id="errorProveido">
              <!--CONTENIDO DINAMICO DE MENSAJE POR NO COMPLETAR CAMPOS -->
            </div>
        </div>
        <div id="respuestaFecha">
        </div>
      </div>
    </div>
  </div>
</div>

<div class="resultados"></div>
</div>
            <!-- FIN DE MODAL DE PROVEIDO CANCELADO-->