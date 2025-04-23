<?php
use Controladores\ControladorCategorias;
?>

<div class="content-wrapper panel-medio-principal">
   <!-- ----------------------------BUSQUEDA POR CODIGO, DNI, APELLIDO Y NOMBRE Y CARPETA------------- -->
   <section class="container-fluid panel-medio">
      <div class="box rounded">
         <div class="box-body row col-mod-12">
           <span class="caption_">Administración de contribuyentes para prescripciones</span>
         </div>

         <div class="box-body table-user">
            <div class="contenedor-busqueda">
               <div class="input-group-search">
                  <div class="input-search">
                     <input type="search" class="search_codigo" id="search_codigo" name="search_codigo" placeholder="Codigo" onkeyup="loadContribuyente_prescripcion(1,'search_codigo','')">
                     <input type="search" class="search_dni" id="search_dni" name="search_dni" placeholder="Documento DNI" onkeyup="loadContribuyente_prescripcion(1,'search_dni','')">
                     <input type="search" class="search_nombres" id="search_nombres" name="search_nombres" placeholder="Nombres y Apellidos" onkeyup="loadContribuyente_prescripcion(1,'search_nombres','')">
                     <input type="search" class="search_codigo_sa" id="search_codigo_sa" name="search_codigo_sa" placeholder="Codigo Carpeta" onkeyup="loadContribuyente_prescripcion(1,'search_codigo_sa','caja')">
                     <input type="hidden" id="perfilOculto_c" value="<?php echo $_SESSION['perfil'] ?>">
                  </div>
                  <br>
               </div>
            </div>

               <div class="row divLista_contribuyente_p">
                  <table class="table-container" width="100%">
                     <thead>
                        <tr>
                           <th class="text-center" style="width:10px;">N°</th>
                           <th class="text-center">Codigo</th>
                           <th class="text-center">Tipo</th>
                           <th class="text-center">DNI</th>
                           <th class="text-center">Nombres</th>
                           <th class="text-center">Direccion Fiscal</th>
                           <th class="text-center" width="150px">Acciones</th>
                        </tr>
                     </thead>
                     <tbody class='body-contribuyente'>
                     </tbody>
                  </table>
               </div>
           
         </div>
      </div>

   </section>

   <!-- ---------------------------MODAL REPORTE DE ESTADO DE CUENTA Y DEUDAS PRESCRITAS-------------------- -->
   <div class="modal fade " id="modalEstadoCuentaPrescripcion" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" style="display:none;">
      <div class="modal-dialog modal-lg" role="document">
         <div class="modal-content">
            <div class="modal-header">
            <h3 id="titulo_Deuda" style="font-size: 13px;">Estado de cuenta</h3>
            <h3 id="titulo_prescripcion" style="font-size: 13px;">Deudas Prescritas</h3>
            </div>
            <div class="modal-body">

            <section class="container-fluid panel-medio ">
               <div class="box-body table-responsive">

                  <div class="box divDetallePredio">
                  <table class="table-container" id="tablaPrescripcion">
                     <thead>
                        <tr>
                        <th class="text-center" style="width:50px;">Cod.</th>
                        <th class="text-center" style="width:100px;">Tributo</th>
                        <th class="text-center" style="width:50px;">Año</th>
                        <th class="text-center" style="width:50px;">Periodo</th>
                        <th class="text-center" style="width:50px;">Importe</th>
                        <th class="text-center" style="width:50px;">Gasto</th>
                        <th class="text-center" style="width:50px;">Subtotal</th>
                        <th class="text-center" style="width:50px;" id="des_es">Descuento</th>
                        <th class="text-center" style="width:50px;">T.I.M</th>
                        <th class="text-center" style="width:50px;">Total</th>
                        <th class="seleccionado text-center" style="width:30px;">S</th>
                        </tr>
                     </thead>
                     <tbody id="estadoCuentaPrescripcion" class="scrollable">
                     </tbody>
                  </table>
                  </div>
               </div>
            </section>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
            <button type="button" class="btn btn-primary" id="prescribirDeuda">Prescribir</button>
            <button type="button" id="imprimirPrescripcion" class="btn btn-primary btnusuario">Imprimir</button>
            </div>
         </div>
      </div>
   </div>

   <!-- -----------------------------------------------MODAL PARA PRESCRIBIR DEUDAS----------------------------- -->
   <div id="modalAgregarPrescripcion" class="modal fade modal-forms fullscreen-modal" role="dialog">
      <div class="modal-dialog modal-lg">
         <div class="modal-content">
            <form role="form" id="formPrescripcion" class="form-inserta2" method="POST">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <caption>PRESCRIBIR DEUDA</caption>
               </div>
               <div class="modal-body">
                  <div class="box-body">
                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group">
                              <label class="" for="">Codigo de Prescripcion</label>
                              <input type="text" class="form-control nuevoUser" name="codigo_prescripcion" id="codigo_prescripcion" placeholder="Ingrese Codigo de la Prescripcion" required>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group">
                              <label for="">Expediente</label>
                              <input type="text" class="form-control nuevoUser" name="expediente_prescripcion" id="expediente_prescripcion" placeholder="Ingrese el Expediente de la Prescripcion" required>
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group">
                              <label for="">Resolucion</label>
                              <input type="text" class="form-control nuevoUser" name="resolucion_prescripcion" id="resolucion_prescripcion" placeholder="Ingrese la Resolucion de la Prescripcion" required>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-12">
                           <div class="form-group">
                              <label for="">Asunto</label>
                              <textarea type="text are" class="form-control nuevoUser" name="asunto_prescripcion" id="asunto_prescripcion" placeholder="Ingrese el asunto de la Prescripcion"  cols="20" rows="5"></textarea>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-danger retroceder_prescripcion" data-dismiss="modal">Retroceder</button>
                  <button type="button" id="btnRegistrarPrescripcion" class="btn btn-primary btnusuario">Guardar</button>
               </div>
            </form>
         </div>
      </div>
   </div>
   <!-- --------------------------------------MODAL DEL PDF DE REPORTE DE PRESCRIPCIONES------------------------------ -->
   <div class="container-fluid">
      <div class="modal in" id="Modalimprimir_cuenta" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
         <div class="modal-dialog modal-lg modal-dialog-fullscreen">
            <div class="modal-content">
            <div class="modal-header">
            </div>
            <div class="modal-body printerhere">
               <iframe id="iframePrescripcion" class="iframe-full-height"></iframe>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </div>
         </div>
      </div>
   </div>
</div>


<?php include_once "modal_predio_propietario_prescripcion.php";  ?>