<?php

use Controladores\ControladorDireccion;
?>
<div class="content-wrapper panel-medio-principal">
   <?php
   if ($_SESSION['perfil'] == 'Vendedorr' || $_SESSION['perfil'] == 'Especiall') {
      echo '
      <section class="container-fluid panel-medio">
        <div class="box alert-dangers text-center">
          <div>
          <h3> Área restringida, solo el administrador puede tener acceso</h3>
          </div>
          <div class="img-restringido">
          </div>
        </div>
      </div>';
   } else {
   ?>

      <!-- <section class="content"> -->
      <section class="container-fluid panel-medio">
         <div class="box rounded">
            <div class="box-body table-responsive">
               <div class="col-mod-12">
                 <span class="caption_">Administración de Dirección</span>
                 <button class="btn btn-secundary btn-1 pull-right" data-toggle="modal" data-target="#modalAgregarDireccion">Nueva Dirección</button>
               </div>
               <br>
               <div class="box div_1">
                     <table class="table-container" width="100%">
                        <thead>
                           <tr>
                              <th class="text-center" style="width:10px;">#</th>
                              <th class="text-center">Denominacion Urb.</th>
                              <th class="text-center">Nombre Zona</th>
                              <th class="text-center">Tipo Via</th>
                              <th class="text-center">Nombre Via</th>
                              <th class="text-center">Acciones</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php
                           $item = null;
                           $valor = null;
                           $direcciones = ControladorDireccion::ctrMostrarDirecciones($item, $valor);
                           foreach ($direcciones as $key => $value) :
                           ?>
                              <tr>
                                 <td class="text-center"><?php echo ++$key; ?></td>
                                 <td class="text-center"><?php echo $value['Habilitacion_Urbana']; ?></td>
                                 <td class="text-center"><?php echo $value['Nombre_Zona']; ?></td>
                                 <td class="text-center"><?php echo $value['Nomenclatura']; ?></td>
                                 <td class="text-center"><?php echo $value['Nombre_Via']; ?></td>
                                 <td class="text-center">
                                    <div class="btn-group">
                                       <img src='./vistas/img/iconos/editar1.png' class="t-icon-tbl-p btnEditarDireccion" title='Editar' idDireccion="<?php echo $value['Id_Direccion'] ?>" data-toggle="modal" data-target="#modalEditarDireccion">
                                       <img src='./vistas/img/iconos/eliminar.png' class="t-icon-tbl-p btnEliminarDireccion" title='Eliminar' idDireccion="<?php echo $value['Id_Direccion'] ?>" usuario="<?php echo $value['Id_Direccion'] ?>">
                                    </div>
                                 </td>
                              </tr>
                        <?php
                           endforeach;
                        } ?>
                        </tbody>
                     </table>
               </div>
            </div>
         </div>
      </section>
</div>

<!--=========== MODAL AGREGAR DIRECCION===================-->
<div id="modalAgregarDireccion" class="modal fade modal-forms fullscreen-modal" role="dialog">
   <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
         <form role="form" method="POST" enctype="multipart/form-data" class="formRegistroDireccion" id="formRegistroDireccion">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <caption>NUEVA DIRECCION</caption>
            </div>
            <div class="modal-body">
               <div class="box-body">
                  <div class="row">
                     <!--// ENTRADA NOMBRE DE LA VIA-->
                     <div class="col-lg-5 col-md-6">
                        <label class="cajalabel2" for=""> Nombre Via: </label>
                        <select name="nombreVia" class="form-control" id="nombreVia">
                           <option>Seleccione</option>
                           <?php
                           $tabla = 'nombre_via';
                           $registros = ControladorDireccion::ctrMostrarDatos($tabla);
                           foreach ($registros as $data_d) {
                              echo "<option value='" . $data_d['Id_Nombre_Via'] . "'>" . $data_d['Nombre_Via'] . '</option>';
                           }
                           ?>
                        </select>
                     </div>
                     <!--//ENTRADA TIPO VIA-->
                     <div class="col-lg-5 col-md-6">
                        <label class="cajalabel2">Tipo Via:</label>
                        <select name="tipoVia" class="form-control" id="tipoVia">
                           <option>Seleccione</option>
                           <?php
                           $tabla = 'tipo_via';
                           $registros = ControladorDireccion::ctrMostrarDatos($tabla);
                           foreach ($registros as $data_d) {
                              echo "<option value='" . $data_d['Id_Tipo_Via'] . "'>" . $data_d['Codigo'] . '</option>';
                           }
                           ?>
                        </select>
                     </div>
                     <!--// ENTRADA DE LA ZONA-->
                     <!-- <div class="col-lg-5 col-md-6">
                        <label class="cajalabel2">Zona:</label>
                        <select name="zonaSel" class="form-control" id="zonaSel">
                           <option>Seleccione</option>
                           <?php
                           /*$tabla = 'zona';
                           $registros = ControladorDireccion::ctrMostrarDatos($tabla);
                           foreach ($registros as $data_d) {
                              echo "<option value='" . $data_d['Id_Zona'] . "'>" . $data_d['Nombre_Zona'] . '</option>';
                           }*/
                           ?>
                        </select>
                     </div> -->
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Salir</button>
               <button type="button" class="btn btn-primary" id="btnGuardarDireccion">Registrar</button>
            </div>
         </form>
      </div>
   </div>
</div>

<!-- MODAL EDITAR  -->
<div id="modalEditarDireccion" class="modal fade modal-forms fullscreen-modal" role="dialog">
   <div class="modal-dialog">
      <div class="modal-content">
         <form role="form" method="POST" enctype="multipart/form-data">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <caption>EDITAR DIRECCION</caption>
            </div>
            <div class="modal-body">
               <div class="box-body">
                  <div class="row">
                     <!--// ENTRADA NOMBRE DE LA VIA-->
                     <input type="hidden" class="form-control " id="ide" name="ide" value="">
                     <input type="hidden" class="form-control " id="editar_direc" name="editar_direc" value="true">
                     <div class="col-lg-5 col-md-6">
                        <label class="cajalabel2" for=""> Nombre Via: </label>
                        <select name="nombreVia_edit" class="form2" id="nombreVia_edit">
                           <option>Seleccione</option>
                           <?php
                           $tabla = 'nombre_via';
                           $registros = ControladorDireccion::ctrMostrarDatos($tabla);
                           foreach ($registros as $data_d) {
                              echo "<option value='" . $data_d['Id_Nombre_Via'] . "'>" . $data_d['Nombre_Via'] . '</option>';
                           }
                           ?>
                        </select>
                     </div>
                     <!--//ENTRADA TIPO VIA-->
                     <div class="col-lg-5 col-md-6">
                        <label class="cajalabel2">Tipo Via:</label>
                        <select name="tipoVia_edit" class="form2" id="tipoVia_edit">
                           <option>Seleccione</option>
                           <?php
                           $tabla = 'tipo_via';
                           $registros = ControladorDireccion::ctrMostrarDatos($tabla);
                           foreach ($registros as $data_d) {
                              echo "<option value='" . $data_d['Id_Tipo_Via'] . "'>" . $data_d['Codigo'] . '</option>';
                           }
                           ?>
                        </select>
                     </div>
                     <!--// ENTRADA DE LA ZONA-->
                     <!-- <div class="col-lg-5 col-md-6">
								<label class="cajalabel2">Zona:</label>
								<select name="zonaSel_edit" class="form2" id="zonaSel_edit">
									<option>Seleccione</option>
									<?php
                           /*$tabla = 'zona';
									$registros = ControladorDireccion::ctrMostrarDatos($tabla);
									foreach ($registros as $data_d) {
										echo "<option value='" . $data_d['Id_Zona'] . "'>" . $data_d['Nombre_Zona'] . '</option>';
									}*/
                           ?>
								</select>
							</div> -->
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Salir</button>
               <button type="submit" class="btn btn-primary">Modificar</button>
            </div>
            <?php
            $editarDir = new ControladorDireccion();
            $editarDir->ctrEditarDireccion();
            ?>
         </form>
      </div>
   </div>
</div>

<?php
$borrarUsuarios =  ControladorDireccion::ctrBorrarDireccion();
?>

<div class="resultados"></div>