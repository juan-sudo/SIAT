<?php

use Controladores\ControladorClasificador;
?>
<div class="content-wrapper panel-medio-principal">
  <?php
  if ($_SESSION['perfil'] == 'Vendedorr' || $_SESSION['perfil'] == 'Especiall') {
    echo '
      <section class="container-fluid panel-medio">
        <div class="box alert-dangers text-center">
          <div><h3> Área restringida, solo el administrador puede tener acceso</h3></div>
          <div class="img-restringido"></div>
      </div>
     </section>';
  } else {
  ?>
    
   
    <!--=====================-->
    <section class="container-fluid panel-medio">
      <div class="box rounded">
        <div class="box-body table-responsive">
          <input type="hidden" id="perfilOculto" value="<?php echo $_SESSION['perfil'] ?>">
          <!--< table-bordered table-striped  -->
                <div class="col-md-10">
                      <span class="caption_">Administración de clasificadores MEF</span>
                      <input type="text" class="filtro_tabla" id="searchInput" placeholder="Buscar el nombre del clasificador..." onkeyup="searchTable('clasificador')">
          
                      <?php
                      if ($_SESSION['perfil'] == 'Administrador') {
                      ?>
                </div>
                <div class="col-md-2">
                      <span class="pull-right"><button class="btn btn-secundary btn-1" data-toggle="modal" data-target="#modalAgregarUsuario">Nuevo Clasificador</button></span>  
                      <?php } ?>
                </div>
                <br>
          <div class="box div_1">
          <table class="table-container" id="tbclasificador">
            <thead>
              <tr>
                <th class="text-center" style="width:10px;">N°</th>
                <th class="text-center">Codigo Clasificador</th>
                <th class="text-center">Nombre Clasificador</th>
                <th class="text-center">Estado</th>
                <th class="text-center">Financiamiento</th>
                <th class="text-center">Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $item = null;
              $valor = null;
              $usuarios = ControladorClasificador::ctrMostrarClasificador($item, $valor);
              foreach ($usuarios as $key => $value) :
              ?>
                <tr>
                  <td class="text-center"><?php echo ++$key; ?></td>
                  <td class=""><?php echo $value['Codigo']; ?></td>
                  <td class=""><?php echo $value['Descripcion']; ?></td>
                  <td class="text-center">
                    <div class="modo-contenedor-selva text-center" >
                      <input type="checkbox"  data-on="Activado" data-off="Desactivado" id="usuarioEstado" name="usuarioEstado<?php $value['Estado'] ?>" value="<?php $value['Estado'] ?>" data-size="mini" data-width="110" idUsuario="<?php echo $value['Id_Presupuesto'] ?>" <?php if ($value['Estado'] == 0) {   } else { ?>checked <?php } ?>>
                    </div>
                  </td>
                  <td class="text-center"><?php echo $value['Id_financiamiento']; ?></td>
                  <td class="text-center">
                    <div class="btn-group">
                     
                        <img src='./vistas/img/iconos/editar1.png'  class="t-icon-tbl-p btnEditarClasificador" title='Editar' idUsuario="<?php echo $value['Id_Presupuesto'] ?>" data-toggle="modal" data-target="#modalEditarUsuario">
                      <?php
                      if ($_SESSION['perfil'] == 'Administrador') {
                      ?>
                        <img src='./vistas/img/iconos/eliminar.png' class="t-icon-tbl-p btnEliminarCladificador" title='Eliminar' idUsuario="<?php echo $value['Id_Presupuesto'] ?>" usuario="<?php echo $value['Codigo'] ?>">
                      <?php } ?>
                    </div>
                  </td>
                </tr>
            <?php
              endforeach;
            }
            ?>
            </tbody>
          </table>
          </div>      
          
        </div>

      </div>
      <!-- BOX FIN -->
      <!-- /.box-footer -->
    </section>

</div>

<div id="modalAgregarUsuario" class="modal fade modal-forms fullscreen-modal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" id="formRegClasificador" class="form-inserta" enctype="multipart/form-data">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <caption>AGREGAR CLASIFICADOR MEF</caption>
        </div>

        <div class="modal-body">
          <div class="box-body">
            <div class="col-md-8">
              <div id="respuestaAjax"></div>
              <div class="form-group">
                <label for=""> Codigo Clasificador</label>
                <input type="number" class="form-control " name="codigo" id="codigo" placeholder="codigo clasificador">
              </div>
              <div class="form-group">
                 <label for="">Nombre Clasificador</label> 
                <input type="text" class="form-control nuevoUser" name="descripcion" id="descripcion" placeholder="decripcion clasificador" pattern="[A-Za-z]+" title="Solo se permiten letras." required>
              </div>
              <div class="form-group">
                <label for="">Fuente Financimiento</label>  
                <select class="form-control " name="id_financiamiento" id="id_financiamiento">
                  <option value="" disabled="" selected="">Selecionar financiamiento</option>
                  <?php
                  $tabla = 'financiamiento';
                  $financiamiento = ControladorClasificador::ctrMostrarData($tabla);
                  foreach ($financiamiento as $data) {
                    echo "<option value='" . $data['Id_financiamiento'] . "'>" . $data['Nombre_Financiamiento'] . '</option>';
                  }
                  ?>
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary btnusuario">Guardar</button>
        </div>
        <?php
        // $crearUsuario = ControladorUsuarios::ctrCrearUsuario();
        ?>
      </form>
    </div>
  </div>
</div>
<div id="modalEditarUsuario" class="modal fade modal-forms fullscreen-modal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post" enctype="multipart/form-data">
        <!--============  CABEZA DEL MODAL  ==============-->
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <caption>EDITAR CLASIFICADOR MEF</caption>
        </div>
        <!--==========    CUERPO DEL MODAL ==========-->
        <div class="modal-body">
          <div class="box-body">
            <div class="col-md-8">
              <!-- ENTRADA PARA EL NOMBRE -->
              <div class="form-group">
                <input type="hidden" class="form-control " id="clasificador_editar" name="clasificador_editar" value="true">
                <input type="hidden" class="form-control " id="idp" name="idp" value="">
              </div>
              <div class="form-group">
                <label for="">Codigo Clasificador</label>
                <input type="text" class="form-control " id="editarCodigoCla" name="editarCodigoCla" value="" required>
              </div>
              <div class="form-group">
                <label for="">Nombre Clasificador</label>
                <input type="text" class="form-control " id="editarNombreCla" name="editarNombreCla" value="" required>
              </div>
              <div class="form-group">
                <?php
                if ($_SESSION['perfil'] == 'Administrador') {
                ?>
                  <label for="">Financiamiento</label>
                  <select class="form-control " name="editarFinanciamiento" id="editarFinanciamiento">
                    <?php
                    foreach ($financiamiento as $value) {
                      echo "<option value='" . $value['Id_financiamiento'] . "'>" . $value['Nombre_Financiamiento'] . "</option>";
                    }
                    ?>
                  </select>
                <?php } else { ?>
                  <label for="">Financiamiento</label>
                  <select class="form-control " name="editarFinanciamiento">
                    <option value="<?php echo $_SESSION['perfil'] ?>"><?php echo $_SESSION['perfil'] ?></option>
                  </select>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>
        <!--===========   PIE DEL MODAL ===========-->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger pull-left" data-dismiss="modal"> Salir</button>
          <button type="submit" class="btn btn-primary">Modificar Clasificador</button>
        </div>
        <?php
        $editarClasificador = new ControladorClasificador();
        $editarClasificador->ctrEditarClasificador();
        ?>
      </form>
    </div>
  </div>
</div>
<?php
$borrarUsuarios =  ControladorClasificador::ctrBorrarClasificador();
?>
<div class="resultados">
</div>