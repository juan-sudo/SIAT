<?php
use Controladores\ControladorContribuyente;
use Controladores\ControladorCategorias;
?>

<div class="content-wrapper panel-medio-principal">
   <section class="container-fluid panel-medio">
      <div class="box rounded">
         <div class="box-body row col-mod-12">
           <span class="caption_">Administración de Predios por Contribuyente m</span>
           <button class="bi bi-person-fill-add btn btn-secundary btn-1 pull-right" onclick="window.location.href='registrar-contribuyente'">Nuevo Contribuyente</button>
         </div>

         <div class="box-body table-user">
            <div class="contenedor-busqueda">
               <div class="input-group-search">
                  <div class="input-search">
                     <input type="search" class="search_codigo" id="searchContribuyente" name="searchContribuyente" placeholder="Codigo" onkeyup="loadContribuyente(1,'search_codigo','')">
                     <input type="search" class="search_dni" id="searchContribuyente" name="searchContribuyente" placeholder="Documento DNI" onkeyup="loadContribuyente(1,'search_dni','')">
                     <input type="search" class="search_nombres" id="searchContribuyente" name="searchContribuyente" placeholder="Nombres y Apellidos" onkeyup="loadContribuyente(1,'search_nombres','')">
                     <input type="search" class="search_codigo_sa" id="searchContribuyente_caja" name="searchContribuyente_caja" placeholder="Codigo Carpeta" onkeyup="loadContribuyente(1,'search_codigo_sa','caja')">
                     <input type="search" class="search_direccion" id="searchContribuyente_direccion" name="searchContribuyente_direccion" placeholder="direccion" onkeyup="loadContribuyente(1,'search_direccion','')">
                     <input type="hidden" id="perfilOculto_c" value="<?php echo $_SESSION['perfil'] ?>">
                  </div>
                  <br>
               </div>
         </div>

               <!-- table-bordered table-striped  -->
               <div class="row divLista_contribuyente_p">
               <table class="table-container" width="100%">
                  <thead>
                     <tr>
                        <th class="text-center" style="width:10px;">N°</th>
                        <th class="text-center">Codigo m</th>
                        <th class="text-center">Tipo</th>
                        <th class="text-center">DNI</th>
                        <th class="text-center">Nombres</th>
                        <th class="text-center">Direccion Fiscal</th>
                        <th class="text-center">Coactivo</th>
                        <th class="text-center">Predio</th>
                        <th class="text-center" >Estado</th>
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
</div>
<!--=============== MODAL EDITAR CONTRIBUYENTE===============-->
<div id="modalEditarcontribuyente" class="modal fade modal-forms  fullscreen-modal" role="dialog">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <form role="form" id="formEmpresa" method="post" enctype="multipart/form-data">
            <input type="hidden" name="idc" id="idc">
            <input type="hidden" name="iduc" id="iduc">
            <input type="hidden" name="idrc" id="idrc" value="true"> 
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <caption>EDITAR CONTRIBUYENTE</caption>
            </div>
            <div class="modal-body">
               <div class="box-body">
                     <div class="text-bordeada">
                           <caption>Datos del Contribuyente</caption>
                     </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="" class="lbl-text">Tipo Contribuyente</label>
                        <div class="input-group">
                           <select class="form-control" name="e_tipoContribuyente" id="e_tipoContribuyente" value="">
                              <?php
                              $tabla_tipo = 'tipo_contribuyente';
                              $tipo = ControladorContribuyente::ctrMostrarData($tabla_tipo);
                              foreach ($tipo as $data_tipo) {
                                 echo "<option value='" . $data_tipo['Id_Tipo_Contribuyente'] . "'>" . $data_tipo['Tipo'] . '</option>';
                              }
                              ?>
                           </select>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="form-group">
                        <label for="" class="lbl-text">Tipo Documento</label>
                        <div class="input-group">
                           <select class="form-control" name="e_tipoDoc" id="e_tipoDoc">
                              <?php
                              $tabla_documento = 'tipo_documento_siat';
                              $documento = ControladorContribuyente::ctrMostrarData($tabla_documento);
                              foreach ($documento as $data_d) {
                                 echo "<option value='" . $data_d['Id_Tipo_Documento'] . "'>" . $data_d['descripcion'] . '</option>';
                              }
                              ?>
                           </select>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-2">
                     <div class="form-group">
                        <label for="" class="lbl-text">N° Documento</label>
                        <div class="input-group">
                           <input type="text" class="form-control" id="e_docIdentidad" name="e_docIdentidad" placeholder="Número de documento...">
                        </div>
                     </div>
                  </div>
                  <div class="col-md-2">
                     <div class="form-group">
                        <label for="" class="lbl-text">Cod. Antiguo</label>
                        <div class="input-group">
                           <input type="text" class="form-control" id="e_codigo_sa" name="e_codigo_sa" placeholder="Codigo antiguo">
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="" class="lbl-text">Nombre o Razon social</label>
                        <div class="input-group-adddon">
                           <input type="text" class="form-control" id="e_razon_social" name="e_razon_social" placeholder="Ingrese nombre o razón social...">
                        </div>
                     </div>
                  </div>
                  <div class="col-md-5">
                     <div class="form-group">
                        <label for="e_clasificacion" class="lbl-text">Clasificacion</label>
                        <div class="input-group">
                           <select class="form-control" name="e_clasificacion" id="e_clasificacion" value="">
                              <?php
                              $tabla_cla = 'clasificacion_contribuyente';
                              $clasificacion = ControladorContribuyente::ctrMostrarData($tabla_cla);
                              foreach ($clasificacion as $data_cla) {
                                 echo "<option value='" . $data_cla['Id_Clasificacion_Contribuyente'] . "'>" . $data_cla['Clasificacion'] . '</option>';
                              }
                              ?>
                           </select>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="" class="lbl-text">Apellido Paterno</label>
                        <div class="input-group-adddon">
                           <input type="text" class="form-control" id="e_apellPaterno" name="e_apellPaterno" placeholder="Ingrese Apellido Paterno ...">
                           <!-- <span class="input-group-addon"></span>  -->
                        </div>
                     </div>
                  </div>
                  <div class="col-md-5">
                     <div class="form-group">
                        <label for="e_condicionContri" class="lbl-text">Condicion Contribuyente</label>
                        <div class="input-group">
                           <select class="form-control" name="e_condicionContri" id="e_condicionContri" value="">
                              <?php
                              $tabla_cla = 'condicion_contribuyente';
                              $clasificacion = ControladorContribuyente::ctrMostrarData($tabla_cla);
                              foreach ($clasificacion as $data_cla) {
                                 echo "<option value='" . $data_cla['Id_Condicion_Contribuyente'] . "'>" . $data_cla['Condicion_Contribuyente'] . '</option>';
                              }
                              ?>
                           </select>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="e_apellMaterno" class="lbl-text">Apellido Materno</label>
                        <div class="input-group-adddon">
                           <input type="text" class="form-control" id="e_apellMaterno" name="e_apellMaterno" placeholder="Ingrese Apellido Materno ...">
                        </div>
                     </div>
                  </div>
               </div>
               <div class="box-body">
                  <div class="row nuevoVia">
                     
                     <div class="text-bordeada">
                     <caption>Domicilo Fiscal del Contribuyente</caption>
                     <button type="button" class="pull-right boton-direccion" data-toggle="modal" data-target="#modalViascalles">Direccion<img src='./vistas/img/iconos/direccion4.png'  class="icon-direccion pull-right"></button>
                     </div>
                  </div>
                  <div class="row">
                     <div class="items-c">
                        <table class="table-container" style="box-sizing: border-box;">
                           <thead>
                              <tr>
                                 <th class="text-center">Nombre Via</th>
                                 <th class="text-center">Manzana</th>
                                 <th class="text-center">Cuadra</th>
                                 <th class="text-center">Lado</th>
                                 <th class="text-center">Zona</th>
                                 <th class="text-center">Habilitacion</th>
                                 <th class="text-center">Cod. Via</th>
                              </tr>
                           </thead>
                           <tbody id="itemsRC">
                           </tbody>
                        </table>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-2">
                        <label for="" class="lbl-text">Numeracion</label>
                        <div class="form-group">
                           <input type="text" class="form-control" id="e_nroUbicacion" name="e_nroUbicacion" placeholder="Nro. Ubicacion...">
                        </div>
                     </div>
                     <div class="col-md-2">
                        <label for="" class="lbl-text">N° Lote</label>
                        <div class="form-group">
                           <input type="text" class="form-control" id="e_nroLote" name="e_nroLote" placeholder="Nro. Lote ...">
                        </div>
                     </div>
                     <div class="col-md-2">
                        <label for="e_nroDepartamento" class="lbl-text">N° Dept.</label>
                        <div class="form-group">
                           <input type="text" class="form-control" id="e_nroDepartamento" name="e_nroDepartamento" placeholder="Nro. Departamento...">
                        </div>
                     </div>
                     <div class="col-md-2">
                        <label for="e_nrobloque" class="lbl-text">N° Bloque</label>
                        <div class="form-group">
                           <input type="text" class="form-control" id="e_nrobloque" name="e_nrobloque" placeholder="Nro. Bloque...">
                        </div>
                     </div>
                     <div class="col-md-2">
                        <label for="e_nroLuz" class="lbl-text">N° Luz</label>
                        <div class="form-group">
                           <input type="text" class="form-control" id="e_nroLuz" name="e_nroLuz" placeholder="Nro. Recibo Luz...">
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <label for="e_referencia" class="lbl-text">Referencia</label>
                     <div class="form-group">
                        <input type="text" class="form-control" id="e_referencia" name="e_referencia" placeholder="Referencia...">
                     </div>
                  </div>
                  <div class="col-md-4 col-xs-3">
                     <div class="form-group">
                        <label for="e_condicionpredio" class="lbl-text">Cond. Propietario</label>
                        <div class="input-group">
                           <select class="form-control" name="e_condicionpredio" id="e_condicionpredio" value="">
                              <?php
                              $tabla = 'condicion_predio_fiscal';
                              $condicion = ControladorContribuyente::ctrMostrarData($tabla);
                              foreach ($condicion as $data_c) {
                                 echo "<option value='" . $data_c['Id_Condicon_Predio_Fiscal'] . "'>" . $data_c['Descripcion'] . '</option>';
                              }
                              ?>
                           </select>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="box-body">
                  
                  <div class="text-bordeada">
                     <caption>Datos de Contacto</caption>
                     </div>
                  <div class="col-md-2">
                     <div class="form-group">
                        <label for="" class="lbl-text">N° Celular</label>
                        <div class="input-group-adddon">
                           <input type="text" class="form-control" id="e_telefono" name="e_telefono" placeholder="Nro  Celular/Telefono...">
                        </div>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="form-group">
                        <label for="" class="lbl-text">Correo</label>
                        <div class="input-group-adddon">
                           <input type="text" class="form-control" id="e_correo" name="e_correo" placeholder="Correo Electronico...">
                        </div>
                     </div>
                  </div>
                  <div class="col-md-7">
                     <div class="form-group">
                        <label for="" class="lbl-text">Observaciones</label>
                        <div class="input-group-adddon">
                           <input type="text" class="form-control" id="e_observacion" name="e_observacion" placeholder="Observacioenes...">
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <label class="btn btn-danger pull-left" data-dismiss="modal">Salir</label>
               <button type="sudmit" class="btn btn-primary">Guardar cambios</button>
            </div>
            <?php
         //   $editarProducto = new ControladorContribuyente();
         //  $editarProducto->ctrEditarContribuyente();
            ?>
         </form>
      </div>
   </div>
</div>
<?php
$eliminarProducto = new ControladorContribuyente();
$eliminarProducto->ctrEliminarContribuyente();
?>

<div class="modal fade bd-example-modal-lg" id="modalViascalles" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <caption>DIRECCION FISCAL</caption>
            </div>
         <div class="modal-body table-responsive">
            <div class="row">
                  <div class="contenedor-busqueda">
                        <div class="input-group-search">
                           <div class="input-search">
                              <input type="search" class="search_direccion" id="searchViacalle" name="searchViacalle" placeholder="Ingrese Nombre de Via o Calle..." onkeyup="loadViacalle(1,'#itemsRC')">
                              <input type="hidden" id="perfilOculto_v" value="<?php echo $_SESSION['perfil'] ?>">
                           </div>
                        </div>
                  </div>
            </div>
            <div class="col-12 divDetallePredio">
               <?php include_once "table-viacalle.php";  ?>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-danger" data-dismiss="modal">Salir</button>
               <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>

         </div>
      </div>
   </div>
</div>

                           <!-- modal de estado de cuenta para impresion de notificadores-->
<div class="modal fade bd-example-modal-lg" id="modalEstadoCuenta_notificacion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
 <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        Estado de Cuenta
      </div>
      <div class="modal-body">

        <section class="container-fluid panel-medio ">
          <div class="box-body table-responsive">

            <div class="col-md-12">
              Estdo de Cuenta + Tasa de Interes Moratorio (TIM)
            </div>

            <div class="box divDetallePredio">
              <table class="table-container" id="primeraTabla">
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
                <tbody id="estadoCuenta" class="scrollable">
                  <!-- Aqui Aparecen los estado de cuenta-->

                </tbody>
              </table>
            </div>
          </div>
          <!-- segunda tabla donde muestra el boton imprimir y el total del estado de cuenta-->
          <table class="table-container" id="segundaTabla">
            <tbody>
              <th class="text-center" style="width:50px;">
              </th>
              <!-- no eliminar los Td-->
              <th class="text-right td-round total_c" style="width:200px;">Total Deuda =</th>
              <th class="text-center td-round total_c" style="width:50px;"></th>
              <th class="text-center td-round" style="width:50px;"></th>
              <th class="text-center td-round" style="width:50px;"></th>
              <th class="text-center td-round" style="width:50px;"></th>
              <th class="text-center td-round" style="width:50px;"></th>
              <th class="text-center rd-round" style="width:50px;"></th>
              <th class="text-center rd-round" style="width:30px;"></th>
            </tbody>
          </table>




        </section>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
        <button type="button" class="btn btn-primary" id="popimprimir">Imprimir Estado Cuenta</button>
      </div>
    </div>
  </div>
</div>
<!--FIN DETALLE ESTADO CUENTA de propietarios-->

<!-- Modal Seleccionar propietario -->
<?php include_once "modal_predio_propietario.php";  ?>
<!-- Modal Seleccionar propietario -->