<?php

use Controladores\ControladorEspecievalorada;
use Controladores\ControladorFormulaimpuesto;
use Controladores\ControladorPredio;
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
          <!-- table-bordered table-striped  -->
          <div class="col-mod-12">
          <span class="caption_">Administración de Formula de Impuesto Predial</span>
              <?php
              if ($_SESSION['perfil'] == 'Administrador') {
              ?>
                <button class="custom-btn btn-1 pull-right" data-toggle="modal" data-target="#modalAgregarUsuario">Nueva Formula</button>
              <?php } ?>
          </div>
          <br>
          <div class="box div_1">
            <table class="table-container" width="100%">
              <thead>
                <tr>
                  <th style="width:10px;">#</th>
                  <th class="text-center">Codigo</th>
                  <th class="text-center">Año</th>
                  <th class="text-center">UIT</th>
                  <th class="text-center">Base Imponible</th>
                  <th class="text-center">Base</th>
                  <th class="text-center">Formula Base</th>
                  <th class="text-center">%</th>
                  <th class="text-center">Atuvaluo</th>
                  <th class="text-center">Fecha Registro</th>
                  <th class="text-center">Acciones</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $item = null;
                $valor = null;
                $especie = ControladorFormulaimpuesto::ctrMostrarFormulaimpuesto($item, $valor);
                foreach ($especie as $key => $value) :
                ?>
                  <tr>
                    <td class="text-center"><?php echo ++$key; ?></td>
                    <td class="text-center"><?php echo $value['Codigo_Calculo']; ?></td>
                    <td class="text-center"><?php echo $value['Id_Anio']; ?></td>
                    <td class="text-center"><?php echo $value['Id_UIT']; ?></td>
                    <td class="text-center"><?php echo $value['Base_imponible']; ?></td>
                    <td class="text-center"><?php echo $value['Base']; ?></td>
                    <td class="text-center"><?php echo $value['FormulaBase']; ?></td>
                    <td class="text-center"><?php echo $value['PorcBase']; ?></td>
                    <td class="text-center"><?php echo $value['Autovaluo']; ?></td>
                    <td class="text-center"><?php echo $value['Fechabase']; ?></td>
                    <td>
                      <div class="btn-group">
                        <img src='./vistas/img/iconos/edit2.png'  class="t-icon-tbl btnEditarClasificador" title='Editar' idUsuario="<?php echo $value['Id_Formula_Impuesto'] ?>" data-toggle="modal" data-target="#modalEditarEspecie">
                        <?php
                        if ($_SESSION['perfil'] == 'Administrador') {
                        ?>
                          <img src='./vistas/img/iconos/eli1.png' class="t-icon-tbl btnEliminarCladificador" title='Eliminar' idUsuario="<?php echo $value['Id_Formula_Impuesto'] ?>" usuario="<?php echo $value['Codigo_Calculo'] ?>">
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

<!-- Modal Agregar nueva formula de impuesto -->
<div id="modalAgregarUsuario" class="modal fade modal-forms fullscreen-modal" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form role="form" id="frmRegFormula" class="form-inserta" enctype="multipart/form-data">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <caption>AGREGAR FORMULA DE IMPUESTO PREDIAL</caption>
        </div>
        <div class="modal-body">
          <div class="box-body">
            <div class="row">
              <div class="row">
                <div class="col-md-3">
                  <div id="respuestaAjax"></div>
                  <div class="form-group">
                    <select class="form-control " name="anio" id="anio">
                      <option value="" disabled="" selected="">Selecionar Año</option>
                      <?php 
                        $anioSiat = 'anio';
                        $registros = ControladorPredio::ctrMostrarData($anioSiat);
                        foreach ($registros as $data_d) {
                          echo "<option value='" . $data_d['NomAnio'] . "'>" . $data_d['NomAnio'] . '</option>';
                        }?>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <input type="text" class="form-control nuevoUser" name="uit" id="uit" placeholder="UIT" required value="">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-1">
                  <div class="form-group">
                    <input type="text" class="form-control nuevoUser" name="codigo_1" id="codigo_1" value="1" required readonly value="1">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <input type="text" class="form-control nuevoUser" name="baseimponible_1" id="baseimponible_1" value="" required placeholder="Base Imponible">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <input type="text" class="form-control nuevoUser" name="base_1" id="base_1" value=" Hasta 3UIT" required readonly value="">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <input type="text" class="form-control nuevoUser" name="formulabase_1" id="formulabase_1" value="" required placeholder="Formula Base">
                  </div>
                </div>
                <div class="col-md-1">
                  <div class="form-group">
                    <input type="text" class="form-control nuevoUser" name="porcentaje_1" id="porcentaje_1" value="" required placeholder="%">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <input type="text" class="form-control nuevoUser" name="autovaluo_1" id="autovaluo_1" value="" required placeholder="Autovaluo">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-1">
                  <div class="form-group">
                    <input type="text" class="form-control nuevoUser" name="codigo_2" id="codigo_2" value="2" required readonly>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <input type="text" class="form-control nuevoUser" name="baseimponible_2" id="baseimponible_2" value="" required placeholder="Base Imponible">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <input type="text" class="form-control nuevoUser" name="base_2" id="base_2" value="De 3 Hasta 15 UIT" required readonly>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <input type="text" class="form-control nuevoUser" name="formulabase_2" id="formulabase_2" value="" required placeholder="Formula Base">
                  </div>
                </div>
                <div class="col-md-1">
                  <div class="form-group">
                    <input type="text" class="form-control nuevoUser" name="porcentaje_2" id="porcentaje_2" value="" required placeholder="%">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <input type="text" class="form-control nuevoUser" name="autovaluo_2" id="autovaluo_2" value="" required placeholder="Autovaluo">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-1">
                  <div class="form-group">
                    <input type="text" class="form-control nuevoUser" name="codigo_3" id="codigo_3" value="3" required readonly>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <input type="text" class="form-control nuevoUser" name="baseimponible_3" id="baseimponible_3" value="" required placeholder="Base Imponible">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <input type="text" class="form-control nuevoUser" name="base_3" id="base_3" value="De 15 Hasta 60 UIT" required readonly>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <input type="text" class="form-control nuevoUser" name="formulabase_3" id="formulabase_3" value="" required placeholder="Formula Base">
                  </div>
                </div>
                <div class="col-md-1">
                  <div class="form-group">
                    <input type="text" class="form-control nuevoUser" name="porcentaje_3" id="porcentaje_3" value="" required placeholder="%">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <input type="text" class="form-control nuevoUser" name="autovaluo_3" id="autovaluo_3" value="" required placeholder="Autovaluo">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-1">
                  <div class="form-group">
                    <input type="text" class="form-control nuevoUser" name="codigo_4" id="codigo_4" value="4" required readonly>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <input type="text" class="form-control nuevoUser" name="baseimponible_4" id="baseimponible_4" value="" required placeholder="Base Imponible">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <input type="text" class="form-control nuevoUser" name="base_4" id="base_4" value="De 60 UIT a Mas" required readonly>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <input type="text" class="form-control nuevoUser" name="formulabase_4" id="formulabase_4" value="" required placeholder="Formula Base">
                  </div>
                </div>
                <div class="col-md-1">
                  <div class="form-group">
                    <input type="text" class="form-control nuevoUser" name="porcentaje_4" id="porcentaje_4" value="" required placeholder="%">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <input type="text" class="form-control nuevoUser" name="autovaluo_4" id="autovaluo_4" value="" required placeholder="Autovaluo">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Salir</button>
          <button type="button" id="btnRegFormula" class="btn btn-primary btnusuario">Guardar</button>
        </div>

        <?php

        ?>

      </form>
    </div>
  </div>
</div>

<!-- MODAL EDITAR USUARIO -->
<div id="modalEditarEspecie" class="modal fade modal-forms fullscreen-modal" role="dialog">

  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form role="form" method="post" enctype="multipart/form-data">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <caption>EDITAR FORMULA IMPUESTO PREDIAL</caption>
        </div>
        <div class="modal-body">
          <div class="box-body">
            <div class="row">
              <!-- ENTRADA PARA EL NOMBRE -->
              <div class="row">
                <div class="col-md-4">
                  <div id="respuestaAjax"></div>
                  <div class="form-group">
                    <input type="hidden" class="form-control nuevoUser" name="idf" id="idf" required>
                    <select class="form-control " name="editar_anio" id="editar_anio">
                      <option value="2020">2020</option>
                      <option value="2021">2021</option>
                      <option value="2022">2022</option>
                      <option value="2023">2023</option>
                    </select>
                  </div>
                </div>

                <div class="col-md-2">
                  <div class="form-group">
                    <input type="text" class="form-control nuevoUser" name="editar_uit" id="editar_uit" placeholder="UIT" required>
                  </div>
                </div>
              </div>

              <div class="row">

                <div class="col-md-1">
                  <div class="form-group">
                    <input type="text" class="form-control nuevoUser" name="editar_codigo" id="editar_codigo" value="" required readonly>
                  </div>
                </div>

                <div class="col-md-2">
                  <div class="form-group">
                    <input type="text" class="form-control nuevoUser" name="editar_baseimponible" id="editar_baseimponible" value="" required placeholder="Base Imponible">
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <input type="text" class="form-control nuevoUser" name="editar_base" id="editar_base" value="" required readonly>
                  </div>
                </div>

                <div class="col-md-2">
                  <div class="form-group">
                    <input type="text" class="form-control nuevoUser" name="editar_formulabase" id="editar_formulabase" value="" required placeholder="Formula Base">
                  </div>
                </div>

                <div class="col-md-1">
                  <div class="form-group">
                    <input type="text" class="form-control nuevoUser" name="editar_porcentaje" id="editar_porcentaje" value="" required placeholder="%">
                  </div>
                </div>

                <div class="col-md-2">
                  <div class="form-group">
                    <input type="text" class="form-control nuevoUser" name="editar_autovaluo" id="editar_autovaluo" value="" required placeholder="Autovaluo">
                  </div>
                </div>

              </div>
              <!-- ENTRADA PARA SELECCIONAR SU PERFIL -->
            </div>
          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Modificar formula</button>
        </div>

        <?php
        $editarClasificador = new ControladorFormulaimpuesto();
        $editarClasificador->ctrEditarFormulaimpuesto();
        ?>

      </form>

    </div>

  </div>

</div>

<?php
$borrarUsuarios =  ControladorFormulaimpuesto::ctrBorrarFormulaimpuesto();


?>

<div class="resultados"></div>