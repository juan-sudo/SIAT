<?php
use Controladores\ControladorEspecievalorada;
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
     </div>';
  } else {
  ?>
    <div style="padding:5px"></div>
    <section class="container-fluid">
      <section class="content-header dashboard-header">
        <div class="box container-fluid" style="border:0px; margin:0px; padding:0px;">
          <div class="col-lg-12 col-xs-12" style="border:0px; margin:0px; padding:0px; border-radius:10px;">
            <div class="col-md-3 hidden-sm hidden-xs">
            </div>
            <div class="col-md-9  col-sm-12 btns-dash">
            </div>
          </div>
        </div>
      </section>
    </section>
    <section class="container-fluid panel-medio">
      <div class="box rounded">
        <div class="box-header ">
          <h3 class="box-title">Administración de Especie Valoradas</h3>    
        </div>
        <div class="box-body table-user">
          <input type="hidden" id="perfilOculto" value="<?php echo $_SESSION['perfil'] ?>">
          <table class="table  dt-responsive tablas tbl-t" width="100%">
            <thead>
              <tr>
                <th style="width:10px;">#</th>
                <th>Nombre Especie</th>
                <th>Area</th>
                <th>Presupuesto</th>
                <th>Monto</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $item = null;
              $valor = null;
              $especie = ControladorEspecievalorada::ctrMostrarEspecievalorada($item, $valor);
              foreach ($especie as $key => $value) :
              ?>
                <tr>
                  <td><?php echo ++$key; ?></td>
                  <td><?php echo $value['Nombre_Especie']; ?></td>
                  <td><?php echo $value['Nombre_Area']; ?></td>
                  <td><?php echo $value['Descripcion']; ?></td>
                  <td><?php echo $value['Monto']; ?></td>
                  <td>
                    <div class="btn-group">
                      <button class="btn btn-warning btnAbrirProveidos" idEspecie="<?php echo $value['Id_Especie_Valorada'] ?>"><i class="fas fa-user-edit"></i></button>
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
    </section>
</div>

<div id="modalAgregarEspecie" class="modal fade modal-forms fullscreen-modal" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <form role="form" id="formEspecie" class="form-inserta2" method="POST">
        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">AGREGAR ESPECIE VALORADA</h4>
        </div>
        <div class="modal-body">
          <div class="box-body">
            <div class="row">
              <div class="col-md-4">
                <div id="respuestaAjax"></div>
                <div class="form-group">
                  <label for="">Area</label>
                  <select class="form-control " name="id_area" id="id_area">
                    <option value="" disabled="" selected="">Selecionar Area</option>
                    <?php
                    $tabla = 'area';
                    $area = ControladorEspecievalorada::ctrMostrarData($tabla);
                    foreach ($area as $data) {
                      echo "<option value='" . $data['Id_Area'] . "'>" . $data['Nombre_Area'] . '</option>';
                    }
                    ?>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="">Clasificador Presupuestal</label>
                  <select class="form-control " name="id_presupuesto" id="id_presupuesto">
                    <option value="" disabled="" selected="">Selecionar Clasificador</option>
                    <?php
                    $tabla = 'presupuesto';
                    $preso = ControladorEspecievalorada::ctrMostrarData($tabla);
                    foreach ($preso as $data) {
                      echo "<option value='" . $data['Id_Presupuesto'] . "'>" . $data['Descripcion'] . '</option>';
                    }
                    ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="">Instrumento Gestion</label>
                  <select class="form-control " name="id_instrumento" id="id_instrumento">
                    <option value="" disabled="" selected="">Selecionar Instrumento Gestion</option>
                    <?php
                    $tabla = 'instrumento_gestion';
                    $preso = ControladorEspecievalorada::ctrMostrarData($tabla);
                    foreach ($preso as $data) {
                      echo "<option value='" . $data['Id_Instrumento_Gestion'] . "'>" . $data['Instrumento_Gestion'] . '</option>';
                    }
                    ?>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="">Detalle Insttrumentto</label>
                  <input type="text" class="form-control nuevoUser" name="detalle_instrumento" id="detalle_instrumento" placeholder="Detalle Instrumento" required>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="">Nombre Especie Valorada</label>
                  <input type="text" class="form-control nuevoUser" name="nombre_especie" id="nombre_especie" placeholder="Nombre Especie Valorada" required>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="">Valor Especie</label>
                  <input type="number" class="form-control nuevoUser" name="monto_especie" id="monto_especie" placeholder="Monto S/." required>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!--=====================================
        PIE DEL MODAL
        ======================================-->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger pull-left" data-dismiss="modal"><i class="far fa-times-circle fa-lg"></i> Salir</button>
          <button type="button" id="btnRegistrarEspecie" class="btn btn-primary btnusuario">Guardar</button>
        </div>
        <?php
        // $crearUsuario = ControladorUsuarios::ctrCrearUsuario();
        ?>
      </form>
    </div>
  </div>
</div>

<div id="modalEditarEspecie" class="modal fade modal-forms fullscreen-modal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="POST" enctype="multipart/form-data">
        <!--===========  CABEZA DEL MODAL ================-->
        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">EDITAR CLASIFICADOR</h4>
        </div>
        <!--========== CUERPO DEL MODAL ==============-->
        <div class="modal-body">
          <div class="box-body">
            <div class="row">
              <input type="hidden" class="form-control " id="idEsp" name="idEsp" value="">
              <input type="hidden" class="form-control " id="editar_especie" name="editar_especie" value="true">

              <div class="col-md-4">
                <div id="respuestaAjax"></div>
                <div class="form-group">
                  <label for="">Area</label>
                  <select class="form-control " name="id_areaEdit" id="id_areaEdit">
                    <option value="" disabled="" selected="">Selecionar Area</option>
                    <?php
                    $tabla = 'area';
                    $area = ControladorEspecievalorada::ctrMostrarData($tabla);
                    foreach ($area as $data) {
                      echo "<option value='" . $data['Id_Area'] . "'>" . $data['Nombre_Area'] . '</option>';
                    }
                    ?>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="">Clasificador Presupuestal</label>
                  <select class="form-control " name="id_presupuestoEdit" id="id_presupuestoEdit">
                    <option value="" disabled="" selected="">Selecionar Clasificador</option>
                    <?php
                    $tabla = 'presupuesto';
                    $preso = ControladorEspecievalorada::ctrMostrarData($tabla);
                    foreach ($preso as $data) {
                      echo "<option value='" . $data['Id_Presupuesto'] . "'>" . $data['Descripcion'] . '</option>';
                    }
                    ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="">Instrumento Gestion</label>
                  <select class="form-control " name="id_instrumentoEdit" id="id_instrumentoEdit">
                    <option value="" disabled="" selected="">Selecionar Instrumento Gestion</option>
                    <?php
                    $tabla = 'instrumento_gestion';
                    $preso = ControladorEspecievalorada::ctrMostrarData($tabla);
                    foreach ($preso as $data) {
                      echo "<option value='" . $data['Id_Instrumento_Gestion'] . "'>" . $data['Instrumento_Gestion'] . '</option>';
                    }
                    ?>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="">Detalle Instrumentto</label>
                  <input type="text" class="form-control nuevoUser" name="detalle_instrumentoEdit" id="detalle_instrumentoEdit" placeholder="Detalle Instrumento" required>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="">Nombre Especie Valorada</label>
                  <input type="text" class="form-control nuevoUser" name="nombre_especieEdit" id="nombre_especieEdit" placeholder="Nombre Especie Valorada" required>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="">Valor Especie</label>
                  <input type="text" class="form-control nuevoUser" name="monto_especieEdit" id="monto_especieEdit" placeholder="Monto S/." required>
                </div>
              </div>
            </div>
          </div>
          <!--================  PIE DEL MODAL ================-->
          <div class="modal-footer">
            <button type="button" class="btn btn-danger pull-left" data-dismiss="modal"><i class="far fa-times-circle fa-lg"></i>Salir</button>
            <button type="submit" class="btn btn-primary">Modificar usuario</button>
          </div>
          <?php
          $editarClasificador = new ControladorEspecievalorada();
          $editarClasificador->ctrEditarEspecievalorada();
          ?>
        </div>
      </form>
    </div>
  </div>
</div>
<?php
$borrarUsuarios =  ControladorEspecievalorada::ctrBorrarEspecievalorada();
?>


<div class="resultados"></div>