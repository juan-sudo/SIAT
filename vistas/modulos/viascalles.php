<?php

use Controladores\Controladorviascalles;
use Controladores\ControladorDireccion;
?>
<div class="content-wrapper panel-medio-principal">
   <?php
   if ($_SESSION['perfil'] == 'Vendedor' || $_SESSION['perfil'] == 'Especiall') {
      echo '
     <section class="container-fluid panel-medio">
						<div class="box alert-dangers text-center">
							<div><h3> Área restringida, solo el administrador puede tener acceso</h3></div>
							<div class="img-restringido"></div>
						</div>
     </section>';
   } else {
   ?>

      <section class="container-fluid panel-medio">
         <div class="box rounded">
            <div class="box-body table-responsive">
               <input type="hidden" id="perfilOculto" value="<?php echo $_SESSION['perfil'] ?>">
               <div class="col-mod-12">
                     <span class="caption_">Administración de Vias y Calles</span>
                     <?php
                     if ($_SESSION['perfil'] == 'Administrador') {
                     ?>
                        <button class="btn btn-secundary btn-1 pull-right" data-toggle="modal" data-target="#modalAgregarDireccion">Nueva via-calle</button>
                     <?php } ?>
               </div>
               <br>
               <div class="box div_1">
                     <table class="table-container" width="100%">
                        <thead>
                           <tr>
                              <th class="text-center" style="width:10px;">N°</th>
                              <th class="text-center">Hab. Urbana</th>
                              <th class="text-center">Denominacion</th>
                              <th class="text-center">Tipo Via</th>
                              <th class="text-center">Nombre Via</th>
                              <th class="text-center">Nro. Cuadra</th>
                              <th class="text-center">Lado</th>
                              <th class="text-center">Acciones</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php
                           $item = null;
                           $valor = null;
                           $usuarios = ControladorViascalles::ctrMostrarViascalles($item, $valor);
                           foreach ($usuarios as $key => $value) :
                           ?>
                              <tr>
                                 <td class="text-center"><?php echo ++$key; ?></td>
                                 <td class="text-center"><?php echo $value['Habilitacion_Urbana']; ?></td>
                                 <td class="text-center"><?php echo $value['Zona']; ?></td>
                                 <td class="text-center"><?php echo $value['TipoVia']; ?></td>
                                 <td class="text-center"><?php echo $value['Nombre_Via']; ?></td>
                                 <td class="text-center"><?php echo $value['Numero_Cuadra']; ?></td>
                                 <td class="text-center"><?php echo $value['Id_Lado']; ?></td>
                                 <td class="text-center">
                                    <div class="btn-group">
                                       <!-- <button class="btn btn-warning btnEditarViascalles" idUsuario="<?php echo $value['Id_Ubica_Vias_Urbano'] ?>" data-toggle="modal" data-target="#modalEditarDireccion"><i class="fas fa-user-edit"></i>
                                    </button>-->
                                       <?php
                                       if ($_SESSION['perfil'] == 'Administrador') {
                                       ?>

                                          <img src='./vistas/img/iconos/eliminar.png' class="t-icon-tbl-p btnEliminarViascalles" idUsuario="<?php echo $value['Id_Ubica_Vias_Urbano'] ?>">
                                       <?php } ?>
                                    </div>
                                 </td>
                              </tr>
                        <?php endforeach;
                        }   ?>
                        </tbody>
                     </table>
               </div>
            </div>
         </div>
      </section>
</div>
<!--============= MODAL AGREGAR VIA CALLES ===================-->
<div id="modalAgregarDireccion" class="modal fade modal-forms fullscreen-modal" role="dialog">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <form role="form" id="formUser" class="form-insert" enctype="multipart/form-data">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <caption> REGISTRO DE VIAS Y CALLES</caption>
            </div>
            <div class="modal-body">
               <!--// ENTRADA DIRECCION-->
               <div class="row">
                  <div class="col-lg-8 col-md-8">
                     <div class="col-lg-4 col-md-4">
                        <label class="cajalabel2">Nombre de la Via</label>
                     </div>
                     <div class="col-lg-4 col-md-4">
                        <select name="Id_NombreVia" class="form-control" id="Id_NombreVia">
                           <option>Seleccione via</option>
                           <?php
                           $registros = ControladorDireccion::ctrMostrarDatos_via_calle();
                           foreach ($registros as $data_d) {
                              echo "<option value='" . $data_d['Id_Direccion'] . "'>" . $data_d['Nombre_Via'] . '</option>';
                           }
                           ?>
                        </select>
                     </div>
                  </div>
               </div>
               <!--// ENTRADA DE LA ZONA-->
               <!-- <div class="row">
                  <div class="col-lg-8 col-md-8">
                     <div class="col-lg-4 col-md-4">
                        <label class="cajalabel2">Zona:</label>
                     </div>
                     <div class="col-lg-4 col-md-4">
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
                     </div>
                  </div>
               </div>  -->

               <div class="row">

                  <!-- <div class="row">
                        <caption>Ubicacion de la Via</caption>
                     </div> -->
                  <!-- <div class="row">

                        <div class="divDetalleVia">
                           <table class="table-container" id="tablalistaDeSubVias">
                              <thead>
                                 <tr>
                                    <th class="text-center">Via</th>
                                    <th class="text-center">Zona</th>
                                    <th class="text-center">#Cuadras</th>
                                    <th class="text-center">#Accion</th>
                                 </tr>
                              </thead>
                              <tbody id="listaSubVias">
                                  Aqui Aparecen los Sub Vias de la via
                              </tbody>
                           </table>
                        </div>

                     </div> -->
                  <div class="col-lg-5 col-md-5">
                     <div class="row">
                        <div class="col-lg-12 col-md-12" id="divCamposCuadra">
                           <caption>Nueva Cuadra</caption>
                           <!--// ZONA-->
                           <div class="col-lg-12 col-md-12">
                              <label class="cajalabel31">Zona:</label>
                              <select class="form2" name="zonaSel" id="zonaSel">
                                 <option>Seleccione</option>
                                 <?php
                                 $tabla = 'zona';
                                 $registros = ControladorDireccion::ctrMostrarDatos($tabla);
                                 foreach ($registros as $data_d) {
                                    echo "<option value='" . $data_d['Id_Zona'] . "'>" . $data_d['Nombre_Zona'] . '</option>';
                                 }
                                 ?>
                              </select>
                           </div>
                           <!--// CUADRA-->
                           <div class="col-lg-12 col-md-12">
                              <label class="cajalabel31">Nro. Cuadra:</label>
                              <select name="numeroCuadra" class="form3" id="numeroCuadra">
                                 <option>Seleccione</option>
                                 <?php
                                 $tabla = 'cuadra';
                                 $registros = ControladorDireccion::ctrMostrarDatos($tabla);
                                 foreach ($registros as $data_d) {
                                    echo "<option value='" . $data_d['Numero_Cuadra'] . "'>" . $data_d['Id_cuadra'] . '</option>';
                                 }
                                 ?>
                              </select>
                           </div>
                           <!-- LADO DE LA CUADRA -->
                           <div class="col-lg-12 col-md-12">
                              <label class="cajalabel31" for="id_zona_c">Lado Cuadra</label>
                              <select class="form3" name="idLadoCuadra" id="idLadoCuadra">
                                 <option value="" disabled="" selected="">Selecionar </option>
                                 <?php
                                 $tabla_catastro = 'lado';
                                 $catastro = ControladorViascalles::ctrMostrarData($tabla_catastro);
                                 foreach ($catastro as $data_catastro) {
                                    echo "<option value='" . $data_catastro['Id_Lado'] . "'>" . $data_catastro['Lado'] . '</option>';
                                 }
                                 ?>
                              </select>
                           </div>
                           <!--// ZONA SEGUN CATASTRO-->
                           <div class="col-lg-12 col-md-12">
                              <label class="cajalabel31">Zona Catastro:</label>
                              <select name="idZonaCatastro" class="form3" id="idZonaCatastro">
                                 <option>Seleccione</option>
                                 <?php
                                 $tabla = 'zona_catastro';
                                 $registros = ControladorDireccion::ctrMostrarDatos($tabla);
                                 foreach ($registros as $data_d) {
                                    echo "<option value='" . $data_d['id_zona_catastro'] . "'>" . $data_d['nombre_zona_catastro'] . '</option>';
                                 }
                                 ?>
                              </select>
                           </div>
                           <!-- CONDICION CATASATRAL -->
                           <div class="col-lg-12 col-md-12">
                              <label class="cajalabel31" for="">Cond. Catastral</label>
                              <select class="form2" name="idCondCatastral" id="idCondCatastral">
                                 <option value="" disabled="" selected="">Selecionar Condicion</option>
                                 <?php
                                 $tabla_tipo_via = 'condicion_catastral';
                                 $tipo_via = ControladorViascalles::ctrMostrarData($tabla_tipo_via);
                                 foreach ($tipo_via as $data_tipo_via) {
                                    echo "<option value='" . $data_tipo_via['Id_Condicion_Catastral'] . "'>" . $data_tipo_via['Condicion_Catastral'] . '</option>';
                                 }
                                 ?>
                              </select>
                           </div>
                           <!-- SITUACION DE LA CUADRA -->
                           <div class="col-lg-12 col-md-12">
                              <label class="cajalabel31" for="">Situacion</label>
                              <select class="form2" name="idSituacionCuadra" id="idSituacionCuadra">
                                 <option value="" disabled="" selected="">Selecionar Situacion</option>
                                 <?php
                                 $tabla_zona = 'situacion_cuadra';
                                 $zona = ControladorViascalles::ctrMostrarData($tabla_zona);
                                 foreach ($zona as $data_zona) {
                                    echo "<option value='" . $data_zona['Id_Situacion_Cuadra'] . "'>" . $data_zona['Situacion_Cuadra'] . '</option>';
                                 }
                                 ?>
                              </select>
                           </div>
                           <!-- DISTANCIA PARQUE -->
                           <div class="col-lg-12 col-md-12">
                              <label class="cajalabel31" for="">Distancia Parque</label>
                              <select class="form2" name="idDistanciaParque" id="idDistanciaParque">
                                 <option value="" disabled="" selected="">Selecionar distancia</option>
                                 <?php
                                 $tabla_tipo_via = 'parque_distancia';
                                 $tipo_via = ControladorViascalles::ctrMostrarData($tabla_tipo_via);
                                 foreach ($tipo_via as $data_tipo_via) {
                                    echo "<option value='" . $data_tipo_via['Id_Parque_Distancia'] . "'>" . $data_tipo_via['Parque_Distancia'] . '' . $data_tipo_via['Condicion'] . '</option>';
                                 }
                                 ?>
                              </select>
                           </div>
                           <!-- MANZANA -->
                           <div class="col-lg-12 col-md-12">
                              <label class="cajalabel31" for="">Manzana</label>
                              <select class="form2" name="idManzana" id="idManzana">
                                 <option value="" disabled="" selected="">Selecionar Manzana</option>
                                 <?php
                                 $tabla_tipo_via = 'manzana';
                                 $tipo_via = ControladorViascalles::ctrMostrarData($tabla_tipo_via);
                                 foreach ($tipo_via as $data_tipo_via) {
                                    echo "<option value='" . $data_tipo_via['Id_Manzana'] . "'>" . $data_tipo_via['NumeroManzana'] . ' - ' . $data_tipo_via['Condicion'] . '</option>';
                                 }
                                 ?>
                              </select>
                           </div>
                           <div class="col-lg-12 col-md-12">
                              <div class="col-md-4"> </div>
                              <div class="col-md-4"> </div>
                              <div class="col-md-4"> <button type="button" id="btnRegistrarCuadra" class="btn btn-primary">Registrar</button> </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!--==== LISTA CUADRAS =======-->
                  <div class="col-lg-7 col-md-7">
                     <div class="row">
                        <caption>Lista de Cuadras</caption>
                     </div>
                     <div class="row">
                        <div class="col-md-12">
                           <div class="row divDetalleVia" id="divCuadras">
                              <table class="table-container" id="listaDePisosContainer">
                                 <thead>
                                    <tr>
                                       <th class="text-center">N° Cuadra</th>
                                       <th class="text-center">Lado</th>
                                       <th class="text-center">Condicion</th>
                                       <th class="text-center">Situacion</th>
                                       <th class="text-center">N° Mz.</th>
                                       <th class="text-center">Zona</th>
                                    </tr>
                                 </thead>
                                 <tbody id="listaUbicaViaUrbano">
                                    <!-- Aqui Aparecen los Sub Vias de la via-->
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <!-- =====INFO VIA ======= -->
            <div class="modal-footer">
            </div>
         </form>
      </div>
   </div>
</div>
<!--============= FIN MODAL AGREGAR VIA CALLES ===============-->
<!--============= MODAL EDITAR VIAS Y CALLES =================-->
<div id="modalEditarDireccion" class="modal fade modal-forms fullscreen-modal" role="dialog">
   <div class="modal-dialog">
      <div class="modal-content">
         <form role="form" method="post" enctype="multipart/form-data">
            <!--==============   CABEZA DEL MODAL  ===================-->
            <div class="modal-header" style="background:#3c8dbc; color:white">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <h4 class="modal-title">EDITAR DIRECCION</h4>
            </div>
            <!--============     CUERPO DEL MODAL  ===================-->
            <div class="modal-body">
               <div class="box-body">
                  <div class="row">
                     <!-- ENTRADA PARA EL NOMBRE -->
                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group">
                              <input type="hidden" class="form-control nuevoUser" name="idd" id="idd" required>
                              <span class="input-group-addonn">Seleccionar Barrio</span>
                              <select class="form-control " name="editar_id_barrio" id="editar_id_barrio">
                                 <?php
                                 //	foreach ($barrio as $data_barrio) {
                                 //		echo "<option value='" . $data_barrio['Id_Barrio'] . "'>" . $data_barrio['Nombre'] . '</option>';
                                 //		}
                                 ?>
                              </select>
                           </div>
                        </div>
                     </div>

                     <div class="row">
                        <div class="col-md-6">
                           <div id="respuestaAjax"></div>
                           <div class="form-group">
                              <span class="input-group-addonn">Seleccionar Zona</span>
                              <select class="form-control" name="editar_id_zona_c" id="editar_id_zona_c">
                                 <?php
                                 //			foreach ($catastro as $data_catastro) {
                                 //			echo "<option value='" . $data_catastro['id_zona_catastro'] . "'>" . $data_catastro['nombre_zona_catastro'] . '</option>';
                                 //	}
                                 ?>
                              </select>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <span class="input-group-addonn">Seleccionar Tipo Via</span>
                              <select class="form-control" name="e_id_tipovia" id="e_id_tipovia">
                                 <?php
                                 //			foreach ($tipo_via as $data_tipo_via) {
                                 //				echo "<option value='" . $data_tipo_via['Id_Tipo_Via'] . "'>" . $data_tipo_via['Codigo'] . '</option>';
                                 //			}
                                 ?>
                              </select>
                           </div>
                        </div>
                     </div>

                     <div class="row">
                        <div class="col-md-6">
                           <div id="respuestaAjax"></div>
                           <div class="form-group">
                              <span class="input-group-addonn">Seleccionar la Manzana</span>
                              <select class="form-control " name="editar_id_manzana" id="editar_id_manzana">
                                 <?php
                                 //			foreach ($manzana as $data_manzana) {
                                 //				echo "<option value='" . $data_manzana['Id_Manzana'] . "'>" . $data_manzana['NumeroManzana'] . '</option>';
                                 //		}
                                 ?>
                              </select>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <span class="input-group-addonn">Insertar la Dirección</span>
                              <input type="text" class="form-control nuevoUser" name="editar_nombre_direccion" id="editar_nombre_direccion" placeholder="Nombre de la direccion" required>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <!--===============   PIE DEL MODAL    ======================================-->
            <!--=============    PIE DEL MODAL     ======================================-->
            <div class="modal-footer">
               <button type="button" class="btn btn-danger pull-left" data-dismiss="modal"><i class="far fa-times-circle fa-lg"></i> Salir</button>
               <button type="submit" class="btn btn-primary">Modificar direccion</button>
            </div>
            <?php
            //  $editarClasificador = new ControladorViascalles();
            //  $editarClasificador -> ctrEditarViascalles();
            ?>
         </form>
      </div>
   </div>
</div>
<!--============= FIN MODAL AGREGAR VIA CALLES ==============-->
<?php
$borrarDireccion =  ControladorViascalles::ctrBorrarViascalles();
?>
<div class="resultados"></div>