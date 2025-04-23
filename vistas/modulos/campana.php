<?php

use Controladores\ControladorCampana;
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
            <div class="col-mod-12">
                <span class="caption_">Administración de Campañas Tributarias y Abitrios Municipales</span>
                <?php
                if ($_SESSION['perfil'] == 'Administrador') {
                ?>
                  <button class="btn-1 btn btn-secundary pull-right" data-toggle="modal" data-target="#modalAgregarCampana">Nueva Campaña</button>
                  </button>
                <?php } ?>
            </div>
            <br>
            <div class="box div_1">
              <table class="table-container" width="100%">
                <thead>
                  <tr>
                    <th class="text-center" style="width:10px;">N°</th>
                    <th class="text-center">Descipcion</th>
                    <th class="text-center">Nro. Ordenanza</th>
                    <th class="text-center">Descuento - Año Aplicacion</th>
                    <th class="text-center">% Descuento</th>
                    <th class="text-center">Fecha Inicio</th>
                    <th class="text-center">Fecha Fin</th>
                    <th class="text-center">Estado</th>
                    <th class="text-center">Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $item = null;
                  $valor = null;
                  $especie = ControladorCampana::ctrMostrarData($item, $valor);
                  foreach ($especie as $key => $value) :
                  ?>
                    <tr>
                      <td class="text-center"><?php echo ++$key; ?></td>
                      <td><?php echo $value['descripcion_descuento']; ?></td>
                      <td><?php echo $value['Documento']; ?></td>
                      <td><?php if ($value['tipo_descuento'] == 1) {
                            echo "ARBITRIOS- GENERALIZADO"." --> ".$value['NomAnio'];
                          }
                          if ($value['tipo_descuento'] == 2) {
                            echo "IMPUESTO PREDIAL-TIM"." --> ".$value['NomAnio'];
                          }
                          if ($value['tipo_descuento'] == 3) {
                            echo "ARBITRIOS - POR USO "." - ".$value['Id_Uso_Predio']." --> ".$value['NomAnio'];
                          } ?></td>
                      <td class="text-center"><?php echo $value['Porcentaje']; ?></td>
                      <td class="text-center"><?php echo $value['Fecha_Inicio']; ?></td>
                      <td class="text-center"><?php echo $value['Fecha_Fin']; ?></td>
                      <td class="text-center">
                        <div class="modo-contenedor-selva">
                          <input type="checkbox" data-toggle="toggle" data-on="Activado" data-off="Desactivado" data-onstyle="success" data-offstyle="danger" id="descuentoEstado" name="descuentoEstado<?php $value['estado_descuento'] ?>" value="<?php $value['estado_descuento'] ?>" data-size="mini" data-width="110" iddescuento="<?php echo $value['Id_Descuento'] ?>" <?php if ($value['estado_descuento'] == 0) {                                                                                                                                                                                                                                                                                                                                        } else { ?>checked <?php } ?>>
                        </div>
                      </td>
                      <td>
                        <div class="btn-group">
                          <img src='./vistas/img/iconos/editar1.png'  class="t-icon-tbl-p btnEditarCampana" title='Editar' idEspecie="<?php echo $value['Id_Descuento'] ?>" data-toggle="modal" data-target="#modalEditarCampana">
                          <?php
                          if ($_SESSION['perfil'] == 'Administrador') {
                          ?>
                            <img src='./vistas/img/iconos/eliminar.png' class="t-icon-tbl-p btnEliminarCampana" title='Eliminar' idUsuario="<?php echo $value['Id_Descuento'] ?>" usuario="<?php echo $value['descripcion_descuento'] ?>">
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
<!--========= MODAL AGREGAR  ==========-->
<div id="modalAgregarCampana" class="modal fade modal-forms fullscreen-modal" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <form role="form" id="formCampana" class="" method="POST">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <caption>NUEVA CAMPAÑA TRIBUTARIA - ARBITRIOS</caption>
        </div>
        <div class="modal-body">
          <div class="box-body">
            <!-- Entrada Nombre-->
            <div class="row">
              <div class="col-md-8">
                <div class="form-group">
                  <label for="">Descripcion de Campaña</label>
                  <input type="text" class="form-control" name="nombreCampana" id="nombreCampana" placeholder="Descripcion de Campaña" required>
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                  <label for="">Ordenanza Municipal</label>
                  <input type="text" class="form-control nuevoUser" name="numInstrumentoCampana" id="numInstrumentoCampana" placeholder="Numero de Ordenanza" required>
                </div>
              </div>

            </div>
            <!-- Entrada Intrumentos-->
            <div class="row">
              <!--<div class="col-md-5">
                <div class="form-group">
                   <label for="">Ordenanza Municipal</label>
                  <select class="form-control " name="idInstrumentoCampana" id="idInstrumentoCampana">
                    <option value="" disabled="" selected="">Instrumento Gestion</option>
                    <?php
                    $tabla = 'instrumento_gestion';
                    $preso = ControladorEspecievalorada::ctrMostrarData($tabla);
                    foreach ($preso as $data) {
                      echo "<option value='" . $data['Id_Instrumento_Gestion'] . "'>" . $data['Instrumento_Gestion'] . '</option>';
                    }
                    ?>
                  </select>
                </div>
              </div>-->
            </div>
            <!-- Entrada Tipo Descuento-->
            <div class="row">
              <legend class="text-bold" style="margin-left:15px; font-size:1em; letter-spacing: 1px;">DESCUENTOS DE CAMPAÑA</legend>
              <div class="col-md-6">
                <label for="">Tipo Descuento:</label>
                <select class="form-control " name="tipoCampana" id="tipoCampana">
                  <option value="" disabled="" selected="">Seleccione</option>
                  <option value="1">ARBITRIOS - GENERALIZADO </option>
                  <option value="2">TIM - IMPUESTO PREDIAL</option>
                  <option value="3">ARBITRIOS - POR USO DEL PREDIO</option>
                </select>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="">Año Aplicacion</label>
                  <select class="form-control " name="anioCampana" id="anioCampana">
                    <option value="" disabled="" selected="">Selecionar Año</option>
                    <?php
                    $tabla = 'anio';
                    $area = ControladorEspecievalorada::ctrMostrarData($tabla);
                    foreach ($area as $data) {
                      echo "<option value='" . $data['Id_Anio'] . "'>" . $data['NomAnio'] . '</option>';
                    }
                    ?>
                  </select>
                </div>
              </div>
            </div>
            <!-- Entrada Monto Descuento Por Uso-->
            <div class="row">
              <div class="col-md-6" id="camapiaPorUso">
                <div class="form-group">
                  <label for="">Uso Predio</label>
                  <select class="form-control " name="usoPredioCampana" id="usoPredioCampana">
                    <option value="" disabled="" selected="">Selecionar Uso</option>
                    <?php
                    $tabla = 'uso_predio';
                    $area = ControladorEspecievalorada::ctrMostrarData($tabla);
                    foreach ($area as $data) {
                      echo "<option value='" . $data['Id_Uso_Predio'] . "'>" . $data['Uso'] . '</option>';
                    }
                    ?>
                  </select>
                </div>
              </div>
              <!-- <div class="col-md-3">
                  <div class="form-group">
                    <label for="">% Decuento</label>
                    <input type="text" class="form-control" name="porcentajeDescuentoU" id="porcentajeDescuentoU" placeholder="%" required>
                  </div>
                </div>-->
              <!-- Entrada Monto Descuento General-->
              <div class="col-md-3" id="campaniaGeneral">
                <div class="form-group">
                  <label for="">% Decuento</label>
                  <input type="number" class="form-control" name="porcentajeDescuento" id="porcentajeDescuento" placeholder="%" required>
                </div>
              </div>
            </div>
            <!-- Entrada Monto Descuento tim
            <div class="row" id="campaniaTim">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="">% Decuento</label>
                  <input type="text" class="form-control" name="porcentajeDescuentoTim" id="porcentajeDescuentoTim" placeholder="%" required>
                </div>
              </div>
            </div>-->
            <!-- Entrada Fecchas-->
            <div class="row">
              <div class="col-md-6">
                <label for="">Fecha Inico </label>
                <input type="date" class="form-control" placeholder="Fecha Inicio" id="fechaIniCampana" name="fechaIniCampana">
              </div>
              <div class="col-md-6">
                <label for="">Fecha Fin </label>
                <input type="date" class="form-control" placeholder="Fecha Fin" id="fechaFinCampana" name="fechaFinCampana">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Salir</button>
          <button type="button" id="btnRegistrarCampana" class="btn btn-primary btnusuario">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!--======== MODAL EDITAR  ========-->
<div id="modalEditarCampana" class="modal fade modal-forms fullscreen-modal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="POST">
        <!--===========  CABEZA DEL MODAL ================-->
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <caption>EDITAR CAMPAÑA TRIBUTARIA - ARBITRIOS</caption>
        </div>
        <!--========== CUERPO DEL MODAL ==============-->
        <div class="modal-body">
          <div class="box-body">
            <input type="hidden" class="form-control" id="idEsp" name="idEsp" value="">
            <input type="hidden" class="form-control" id="editar_descuento" name="editar_descuento" value="true">

            <div class="row">
              <legend class="text-bold" style="margin-left:15px; font-size:1em; letter-spacing: 1px;">DETALLE DE CAMPAÑA</legend>
              <!-- Entrada Nombre y año-->
              <div class="col-md-8">
                <div class="form-group">
                  <label for="">Descripcion de Campaña</label>
                  <input type="text" class="form-control" name="edit_nombreCampana" id="edit_nombreCampana" placeholder="Nombre Campaña" required>
                </div>
              </div>
              <!-- Entrada Ordenanza-->
              <div class="col-md-4">
                <div class="form-group">
                  <label for="">Numero Ordenanza</label>
                  <input type="text" class="form-control nuevoUser" name="edit_numInstrumentoCampana" id="edit_numInstrumentoCampana" placeholder="Numero de Ordenanza" required>
                </div>
              </div>
              <!-- Año Aplicacion-->
            </div>
            <!-- Entrada Intrumentos-->
            <div class="row">
            </div>
            <!-- Entrada Formato-->
            <div class="row">
              <legend class="text-bold" style="margin-left:15px; font-size:1em; letter-spacing: 1px;">DESCUENTOS DE CAMPAÑA</legend>
              <div class="col-md-6">
                <label for="">Tipo Descuento:</label>
                <select class="form-control " name="edit_tipoCampana" id="edit_tipoCampana">
                  <option value="" disabled="" selected="">Seleccione</option>
                  <option value="1">ARBITRIOS - GENERALIZADO </option>
                  <option value="2">TIM - IMPUESTO PREDIAL</option>
                  <option value="3">ARBITRIOS - POR USO DEL PREDIO</option>
                </select>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="">Año Aplicacion</label>
                  <select class="form-control " name="edit_anioCampana" id="edit_anioCampana">
                    <option value="" disabled="" selected="">Selecionar Año</option>
                    <?php
                    $tabla = 'anio';
                    $area = ControladorEspecievalorada::ctrMostrarData($tabla);
                    foreach ($area as $data) {
                      echo "<option value='" . $data['Id_Anio'] . "'>" . $data['NomAnio'] . '</option>';
                    }
                    ?>
                  </select>
                </div>
              </div>
            </div>
            <!-- Entrada Monto Descuento Por Uso-->
            <div class="row">
              <div class="col-md-6" id="edit_camapiaPorUso">
                <div class="form-group">
                  <label for="">Uso Predio</label>
                  <select class="form-control " name="edit_usoPredioCampana" id="edit_usoPredioCampana">
                    <option value="" disabled="" selected="">Selecionar Uso</option>
                    <?php
                    $tabla = 'uso_predio';
                    $area = ControladorEspecievalorada::ctrMostrarData($tabla);
                    foreach ($area as $data) {
                      echo "<option value='" . $data['Id_Uso_Predio'] . "'>" . $data['Uso'] . '</option>';
                    }
                    ?>
                  </select>
                </div>
              </div>
              <div class="col-md-3" id="edit_campaniaGeneral">
                <div class="form-group">
                  <label for="">% Decuento</label>
                  <input type="number" class="form-control" name="edit_porcentajeDescuentoG" id="edit_porcentajeDescuentoG" placeholder="%">
                </div>
              </div>
            </div>
            <!-- Entrada Fecchas-->
            <div class="row">
              <div class="col-md-6">
                <label for="">Fecha Inico </label>
                <input type="date" class="form-control" placeholder="Fecha Inicio" id="edit_fechaIniCampana" name="edit_fechaIniCampana">
              </div>
              <div class="col-md-6">
                <label for="">Fecha Fin </label>
                <input type="date" class="form-control" placeholder="Fecha Fin" id="edit_fechaFinCampana" name="edit_fechaFinCampana">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Salir</button>
            <button type="submit" id="btnModicarCampana" class="btn btn-primary">Modificar</button>
          </div>
          <?php
          $editarCampana = new ControladorCampana();
          $editarCampana->ctrEditarCampana();
          ?>
        </div>
      </form>
    </div>
  </div>
</div>


<!-- MODAL CONFIRMAR LA APLICAR DESCUENTO -->
<div class="modal fade" id="modal_confirmar_descuento" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
       
        </button>
        <h6 class="modal-title" id="staticBackdropLabel">Aplicar campaña descuento</h6>
      </div>
      <div class="modal-body">
        <h7>Estas seguro de aplicar descuento ?</h7>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary no_aplicar_descuento" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-primary aplicar_descuento">si</button>
      </div>
    </div>
  </div>
</div>
<!--FIN  MODAL CONFIRMAR LA APLICAR DESCUENTO -->




<?php
$borrarUsuarios =  ControladorCampana::ctrBorrarCampana();
?>
<div class="resultados"></div>
<!-- modal cargando -->
<?php include_once "modalcargar.php";  ?>
<!-- fin de modal cargando-->