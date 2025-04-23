<?php
use Controladores\ControladorClasificador;
use Controladores\ControladorEspecievalorada;
use Controladores\ControladorGiroComercial;

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
      <!-- BOX INI -->
      <div class="box rounded">
        <div class="box-body table-responsive">
          <input type="hidden" id="perfilOculto" value="<?php echo $_SESSION['perfil'] ?>">
          <div class="col-mod-12">
             <span class="caption_">Administración de Giro Comercial</span>
              <?php
              if ($_SESSION['perfil'] == 'Administrador') {
              ?>
                <button class="btn btn-secundary btn-1 pull-right" data-toggle="modal" data-target="#modalAgregarGiroComercial">Nuevo Giro Comercial</button>
                </button>
              <?php } ?>
          </div>
          <br>
          <div class="box div_1">
            <table class="table-container">
              <thead>
                <tr>
                  <th class="text-center" style="width:10px;">#</th>
                  <th class="text-center">Nombre Giro Comercial</th>
                  <th class="text-center">Estado</th>
                  <th class="text-center">Acciones</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $item = null;
                $valor = null;
                $giroComercial = ControladorGiroComercial::ctrMostrarGiroComercial($item, $valor);
                foreach ($giroComercial as $key => $value) :
                ?>
                  <tr>
                    <td class="text-center"><?php echo ++$key; ?></td>
                    <td><?php echo $value['Nombre']; ?></td>
                    <td class="text-center">
                      <div class="modo-contenedor-selva">
                        <input type="checkbox" data-toggle="toggle" data-on="Activado" data-off="Desactivado" data-onstyle="success" data-offstyle="danger" id="usuarioEstado" name="usuarioEstado<?php $value['Estado'] ?>" value="<?php $value['Estado'] ?>" data-size="mini" data-width="110" idGiro="<?php echo $value['Id_Giro_Establecimiento'] ?>" <?php if ($value['Estado'] == 0) {
                                                                                                                                                                                                                                                                                                                                                    } else { ?>checked <?php } ?>>
                      </div>
                    </td>
                    <td class="text-center">
                      <div class="btn-group">
                        <img src='./vistas/img/iconos/editar1.png'  class="t-icon-tbl-p btnEditarGiroComercial" title='Editar' idGiro="<?php echo $value['Id_Giro_Establecimiento'] ?>" data-toggle="modal" data-target="#modalEditarGiroComercial">
                        <?php
                        if ($_SESSION['perfil'] == 'Administrador') {
                        ?>
                          <img src='./vistas/img/iconos/eliminar.png' class="t-icon-tbl-p btnEliminarGiroComercial" title='Eliminar' idGiro="<?php echo $value['Id_Giro_Establecimiento'] ?>" usuario="<?php echo $value['Nombre'] ?>">
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
    </section>
</div>
<!-- MODAL AGREGAR GIRO COMERCIAL -->
<div id="modalAgregarGiroComercial" class="modal fade modal-forms fullscreen-modal" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <form role="form" id="formUser" class="form-inserta" enctype="multipart/form-data">
        <!--============== CABEZA DEL MODAL ===================-->
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <caption>NUEVO GIRO COMERCIAL</caption>
        </div>
        <!--============== CUERPO DEL MODAL ==================-->
        <div class="modal-body">
          <div class="box-body">
            <div class="row">
              <!-- ENTRADA PARA EL NOMBRE -->
              <div class="form-group">
                <input type="text" class="form-control nuevoUser" name="nombre_giro" id="nombre_giro" placeholder="Nombre Giro Comercial" required>
              </div>
            </div>
          </div>
        </div>
        <!--============= PIE DEL MODAL =======================-->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary btnusuario">
            Guardar
          </button>
        </div>
        <?php
        // $crearUsuario = ControladorUsuarios::ctrCrearUsuario();
        ?>
      </form>
    </div>
  </div>
</div>
<!-- MODAL EDITAR GIRO COMERCIAL -->
<div id="modalEditarGiroComercial" class="modal fade modal-forms fullscreen-modal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post" enctype="multipart/form-data">
        <!--=========== CABEZA DEL MODAL ==========-->
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
         <CAPTIon>EDITAR GIRO COMERCIAL</CAPTIon>
        </div>
        <!--=========== CUERPO DEL MODAL ===========-->
        <div class="modal-body">
          <div class="box-body">
            <div class="row">
              <!-- ENTRADA PARA EL NOMBRE -->
              <div id="respuestaAjax"></div>
              <input type="hidden" class="form-control " id="ide" name="ide" value="">
              <div class="form-group">
                <input type="text" class="form-control nuevoUser" id="editar_nombreGiro" name="editar_nombreGiro" placeholder="Nombre Giro Comercial" required>
              </div>
              <!-- ENTRADA PARA SELECCIONAR SU PERFIL -->
            </div>
          </div>
        </div>
        <!--=====================================
        PIE DEL MODAL
        ======================================-->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Modificar Giro Comercial</button>
        </div>
        <?php
        $editarGiroComercial = new ControladorGiroComercial();
        $editarGiroComercial->ctrEditarGiroComercial();
        ?>
      </form>

    </div>
  </div>
</div>
<?php
$borrarUsuarios =  ControladorGiroComercial::ctrBorrarGiroComercial();
?>
<div class="resultados"></div>