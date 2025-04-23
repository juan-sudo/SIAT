<?php

use Controladores\ControladorClasificador;
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

    <!-- <section class="content"> -->
    <section class="container-fluid panel-medio">
      <!-- BOX INI -->
      <div class="box rounded">
        <div class="box-body table-responsive">
          <input type="hidden" id="perfilOculto" value="<?php echo $_SESSION['perfil'] ?>">
          <div class="col-md-10">
            <span class="caption_">Administración de Espcies Valoradas</span>
            <input type="text" class="filtro_tabla" id="searchInput" placeholder="Buscar el nombre de la especie valorada..." onkeyup="searchTable('especie_valorada')">
          </div>
            <?php
            if ($_SESSION['perfil'] == 'Administrador') {
            ?>
             <div class="col-md-2">
              <button class="btn btn-secundary btn-1 pull-right" data-toggle="modal" data-target="#modalAgregarEspecie">Nuevo Especie val.
              </button>
             </div>
            <?php } ?>
          </div>
          <div class="box div_1">
            <table class="table-container" id="tbespecie_valorada" width="100%">
              <thead>
                <tr>
                  <th class="text-center" style="width:10px;">#</th>
                  <th class="text-center">Nombre Especie</th>
                  <th class="text-center">Area</th>
                  <th class="text-center">Clasif. Presupuesto</th>
                  <th class="text-center">Instrumento</th>
                  <th class="text-center">Monto</th>
                  <th class="text-center">Estado</th>
                  <th class="text-center">Requisitos</th>
                  <th class="text-center">Acciones</th>
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
                    <td class="text-center"><?php echo ++$key; ?></td>
                    <td><?php echo $value['Nombre_Especie']; ?></td>
                    <td><?php echo $value['Nombre_Area']; ?></td>
                    <td><?php echo $value['Descripcion']; ?></td>
                    <td><?php echo $value['Instrumento_Gestion'] . ' - Pag:' . $value['Numero_Pagina']; ?></td>
                    <td class="text-center"><?php echo $value['Monto']; ?></td>
                    <td class="text-center">
                      <div class="modo-contenedor-selva">
                        <input type="checkbox" data-toggle="toggle" data-on="Activado" data-off="Desactivado" data-onstyle="success" data-offstyle="danger" id="usuarioEstado" name="usuarioEstado" <?php $value['estado_especie'] ?> value="<?php $value['estado_especie'] ?>" data-size="mini" data-width="110" idUsuario="<?php echo $value['Id_Especie_Valorada'] ?>" <?php if ($value['estado_especie'] == 0) {
                                                                                                                                                                                                                                                                                                                                                                          } else { ?>checked <?php } ?>>
                      </div>
                    </td>
                    <!-- requsitos -->
                    <td class="text-center">
                      <div class="btn-group">
                        <img src='./vistas/img/iconos/editar1.png' class="t-icon-tbl-p btnRequisitos" title='requisitos' idEspecie="<?php echo $value['Id_Especie_Valorada'] ?>" data-toggle="modal" data-target="#modalrequisitos">
                      </div>
                    </td>
                    <td class="text-center">
                      <div class="btn-group">
                        <img src='./vistas/img/iconos/editar1.png' class="t-icon-tbl-p btnEditarEspecie" title='Editar' idEspecie="<?php echo $value['Id_Especie_Valorada'] ?>" data-toggle="modal" data-target="#modalEditarEspecie">
                        <?php
                        if ($_SESSION['perfil'] == 'Administrador') {
                        ?>
                          <img src='./vistas/img/iconos/eliminar.png' class="t-icon-tbl-p btnEliminarEspecie" title='Eliminar' idUsuario="<?php echo $value['Id_Especie_Valorada'] ?>" usuario="<?php echo $value['Nombre_Especie'] ?>"></img>
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
<!-- MODAL AGREGAR USUARIO -->
<div id="modalAgregarEspecie" class="modal fade modal-forms fullscreen-modal" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <form role="form" id="formEspecie" class="form-inserta2" method="POST">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <caption>AGREGAR ESPECIE VALORADA</caption>

        </div>
        <div class="modal-body">
          <div class="box-body">
            <div class="row">
              <div class="col-md-6">
                <div id="respuestaAjax"></div>
                <div class="form-group">
                  <label class="" for="">Area</label>
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
              <div class="col-md-6">
                <div class="form-group">
                  <label class="" for="">Clasificador Presupuestal</label>
                  <select class="form-control " name="id_presupuesto" id="id_presupuesto">
                    <option value="" disabled="" selected="">Selecionar Clasificador Prosupuestal</option>
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
              <div class="col-md-6">
                <div class="form-group">
                  <label class="" for="">Nombre Especie Valorada</label>
                  <input type="text" class="form-control nuevoUser" name="nombre_especie" id="nombre_especie" placeholder="Ingrese Nombre Especie Valorada" required>
                </div>
              </div>
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
              <div class="col-md-2">
                <div class="form-group">
                  <label for="">Numero Pagina</label>
                  <input type="number" class="form-control nuevoUser" name="numPagina" id="numPagina" placeholder="N° Pagina" required>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="">Detalle</label>
                  <input type="text" class="form-control nuevoUser" name="detalle_instrumento" id="detalle_instrumento" placeholder="Ingrese Detalle de Instrumento Gestion" required>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="">Valor Especie</label>
                  <input type="number" class="form-control nuevoUser" name="monto_especie" id="monto_especie" placeholder="Monto S/." required>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="">Requisitos</label>
                  <textarea type="text are" class="form-control nuevoUser" name="requisitos" id="requisitos" placeholder="ingrese requisitos"  cols="20" rows="5"></textarea>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Salir</button>
          <button type="button" id="btnRegistrarEspecie" class="btn btn-primary btnusuario">Guardar</button>
        </div>
        <?php
        // $crearUsuario = ControladorUsuarios::ctrCrearUsuario();
        ?>
      </form>
    </div>
  </div>
</div>
<!-- MODAL EDITAR USUARIO -->
<div id="modalEditarEspecie" class="modal fade modal-forms fullscreen-modal" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form role="form" method="POST" enctype="multipart/form-data">
        <!--===========  CABEZA DEL MODAL ================-->
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <caption>EDITAR ESPECIE VALORADA</caption>
        </div>
        <!--========== CUERPO DEL MODAL ==============-->
        <div class="modal-body">
          <div class="box-body">
            <div class="row">
              <input type="hidden" class="form-control " id="idEsp" name="idEsp" value="">
              <input type="hidden" class="form-control " id="editar_especie" name="editar_especie" value="true">
              <div class="col-md-6">
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
              <div class="col-md-6">
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
              <div class="col-md-6">
                <div class="form-group">
                  <label for="">Nombre Especie Valorada</label>
                  <input type="text" class="form-control nuevoUser" name="nombre_especieEdit" id="nombre_especieEdit" placeholder="Nombre Especie Valorada" required>
                </div>
              </div>
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
              <div class="col-md-2">
                <div class="form-group">
                  <label for="">Numero Pagina</label>
                  <input type="text" class="form-control nuevoUser" name="numPaginaEdit" id="numPaginaEdit" placeholder="N° Pagina" required>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="">Detalle</label>
                  <input type="text" class="form-control nuevoUser" name="detalle_instrumentoEdit" id="detalle_instrumentoEdit" placeholder="Detalle Instrumento" required>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="">Valor Especie</label>
                  <input type="text" class="form-control nuevoUser" name="monto_especieEdit" id="monto_especieEdit" placeholder="Monto S/." required>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="">Requisitos</label>
                  <textarea type="text are" class="form-control nuevoUser" name="requisitosEdit" id="requisitosEdit" placeholder="ingrese requisitos" cols="20" rows="15"></textarea>
                </div>
              </div>
            </div>
          </div>
          <!--================  PIE DEL MODAL ================-->
          <div class="modal-footer">
            <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Salir</button>
            <button type="submit" class="btn btn-primary">Modificar</button>
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
<!-- MODAL REQUISITOS -->
<div id="modalrequisitos" class="modal fade modal-forms fullscreen-modal" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form role="form" method="POST" enctype="multipart/form-data">
        <!--===========  CABEZA DEL MODAL ================-->
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <caption>Requisitos</caption>
        </div>
        <!--========== CUERPO DEL MODAL ==============-->
        <div class="modal-body">
          <div class="box-body">

            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="">Requisitos</label>
                  <textarea type="text are" class="form-control nuevoUser" name="requisitosV" id="requisitosV" placeholder="ingrese requisitos"  cols="20" rows="15"></textarea>
                </div>
              </div>
            </div>
            <!--================  PIE DEL MODAL ================-->
            <div class="modal-footer">
              <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Salir</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>


<?php
$borrarUsuarios =  ControladorEspecievalorada::ctrBorrarEspecievalorada();
?>
<div class="resultados"></div>