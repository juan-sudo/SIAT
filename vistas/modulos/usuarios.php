<?php

use Controladores\ControladorUsuarios;
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
        <div class="box-header ">
          <h3 class="box-title">Administración de usuarios</h3>
          <?php
          if ($_SESSION['perfil'] == 'Administrador') {
          ?>
            <button class="btn btn-success  pull-right btn-radius" data-toggle="modal" data-target="#modalAgregarUsuario"><i class="fas fa-plus-square"></i>Nuevo usuario <i class="fas fa-user-plus"></i>
            </button>
          <?php } ?>

        </div>
        <!-- /.box-header -->
        <div class="box-body table-user">
          <input type="hidden" id="perfilOculto" value="<?php echo $_SESSION['perfil'] ?>">
          <!-- table-bordered table-striped  -->
          <table class="table  dt-responsive  tbl-t" width="100%">

            <thead>
              <tr>
                <th style="width:10px;">#</th>
                <th>Nombre</th>
                <th>Usuario</th>
                <th>Permiso</th>
                <th>Area</th>
                <th>Estado</th>
                <th>Último login</th>
                <th>Acciones</th>
              </tr>
            </thead>

            <tbody id="lista_de_usuarioss">
              <!-- Lista Contribuyente dinamico-->
            </tbody>

          </table>

        </div>

      </div>
      <!-- BOX FIN -->
      <!-- /.box-footer -->
    </section>

  <?php } ?>
  <!-- <button type="button" class="btn btn-primary printsave">Print</button>
<div class="printerhere" width="100%" style=""></div> -->
  <!-- <embed class="printerhere" src="" type="application/pdf" width="100%" height="600px" class="printerhere" /> -->

</div>

<!-- MODAL AGREGAR USUARIO -->
<!-- Modal -->
<div id="modalAgregarUsuario" class="modal fade modal-forms fullscreen-modal" role="dialog">
  <div class="modal-dialog">

    <div class="modal-content">


      <form role="form" id="formUser" class="form-inserta" enctype="multipart/form-data">


        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">AGREGAR USUARIO</h4>

        </div>

        <div class="modal-body">

          <div class="box-body">
            <div class="col-md-12">
              <div id="respuestaAjax"></div>
              <div class="form-group">
                <input type="number" class="form-control " name="Dni" id="Dni" placeholder="Ingresar D.N.I." maxlength="8" required>
              </div>
              <div class="form-group">
                <input type="text" class="form-control " name="nuevoNombre" id="nuevoNombre" placeholder="Ingresar nombre">
              </div>
              <div class="form-group">
                <input type="mail" class="form-control " name="nuevoEmail" id="nuevoEmail" placeholder="Ingresar correo electrónico" required>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <input type="text" class="form-control nuevoUser" name="nuevoUsuario" id="nuevoUsuario" placeholder="Ingresar usuario" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <input type="password" class="form-control " name="nuevoPassword" id="nuevoPassword" placeholder="Ingresar contraseña" required>
                  </div>
                </div>
              </div>

              <select class="form-control" id="id_area" name="id_area">
                <?php
                $tabla_area = 'area';
                $area = ControladorPredio::ctrMostrarData($tabla_area);
                foreach ($area as $data_area) {
                  echo "<option value='" . $data_area['Id_Area'] . "'>" . $data_area['Nombre_Area'] . '</option>';
                }
                ?>
              </select>
            </div>
          </div>

        </div>


        <div class="modal-footer">

          <button type="button" class="btn btn-danger pull-left" data-dismiss="modal"><i class="far fa-times-circle fa-lg"></i> Salir</button>

          <button type="submit" class="btn btn-primary btnusuario">Guardar</button>

        </div>

      </form>


    </div>
  </div>
</div>

<div id="modalEditarUsuario" class="modal fade modal-forms fullscreen-modal" role="dialog">

  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post" class="form-inserta-editar" enctype="multipart/form-data">

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">EDITAR USUARIO</h4>

        </div>


        <div class="modal-body">

          <div class="box-body">

            <div class="col-md-12">

              <div class="form-group">

                <input type="number" class="form-control " id="editarDni" name="editarDni" value="" required maxlength="8">

              </div>
              <div class="form-group">

                <input type="text" class="form-control " id="editarNombre" name="editarNombre" value="" required>

              </div>


              <div class="form-group">

                <input type="mail" class="form-control " id="editarEmail" name="editarEmail" value="">

              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <input type="text" class="form-control " id="editarUsuario" name="editarUsuario" value="" readonly>

                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">

                    <input type="password" class="form-control " name="editarPassword" placeholder="Escriba la nueva contraseña">

                    <input type="hidden" id="passwordActual" name="passwordActual">

                  </div>
                </div>
              </div>


              <div class="form-group">
                <select class="form-control" id="id_area_e" name="id_area_e">
                  <?php
                  $tabla_area = 'area';
                  $area = ControladorPredio::ctrMostrarData($tabla_area);
                  foreach ($area as $data_area) {
                    echo "<option value='" . $data_area['Id_Area'] . "'>" . $data_area['Nombre_Area'] . '</option>';
                  }
                  ?>
                </select>
              </div>
            </div>
          </div>
        </div>


        <div class="modal-footer">

          <button type="button" class="btn btn-danger pull-left" data-dismiss="modal"><i class="far fa-times-circle fa-lg"></i> Salir</button>

          <button type="submit" class="btn btn-primary">Modificar usuario</button>

        </div>

      </form>

    </div>

  </div>

</div>
<!-- Modal Permisos -->
<div class="modal fade" id="modalPermiso" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="staticBackdropLabel">Permisos a Paginas</h5>

      </div>
      <div class="col-md-12 text-center"><span class="usuario_permiso"></span> con DNI:<span class="dni_permiso"></span></div>
      <div class="modal-body permiso_pagina">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary guardar_permisos">Guardar</button>
      </div>
    </div>
  </div>
</div>



<div class="resultados"></div>