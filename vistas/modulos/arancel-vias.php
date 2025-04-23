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
      <div class="box container-fluid">
        <div class="col-mod-12">
            <h6>Administracion de Arancel por Via</h6>
        </div>
      </div>
    </section>

    <section class="container-fluid panel-medio">
      <div class="box rounded">
        <div class="row">
          <div class="box-body table-user">
            <div class="col-md-7 table-responsive">
                <input type="hidden" id="perfilOculto" value="<?php echo $_SESSION['perfil'] ?>">
              <div class="div_2">
                <table id="listaViasCallesArancel" class="table-container" width="100%">
                  <caption> Nombre de la via <?php
                                              if (isset($_GET['Viascalles'])) {
                                                $viascalles = $_GET['Viascalles'];
                                              }
                                              ?>
                    <select name="Id_NombreVia1" class="form2" id="Id_NombreVia1">
                      <option>Seleccione</option>
                      <?php
                     // $tabla = 'nombre_via';
                      $registros = ControladorDireccion::ctrMostrarDatos_via_calle();
                      foreach ($registros as $data_d) {
                        echo "<option value='" . $data_d['Id_Direccion'] . "'";
                        if (isset($viascalles) && $viascalles == $data_d['Id_Direccion']) {
                          echo " selected";
                        }
                        echo ">" . $data_d['Nombre_Via'] . '</option>';
                      }
                      ?>
                    </select>
                  </caption>
                  <thead>
                    <tr>
                      <th class="text-center" style="width:10px;">N°</th>
                      <th class="text-center">Via</th>
                      <th class="text-center">Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if (isset($_GET['Viascalles'])) {
                      $valor = $_GET['Viascalles'];
                    } else {
                      $valor = 1;
                    }
                    $item = 'Id_Direccion';
                    $usuarios = ControladorViascalles::ctrMostrarViascalles($item, $valor);
                    if ($usuarios != 'vacio') {
                      foreach ($usuarios as $key => $value) :
                    ?>
                        <tr>
                          <td class="text-center"><?php echo ++$key; ?></td>
                          <td class="text-center"><?php echo $value['TipoVia'] . ' ' . $value['Nombre_Via'] . ' Cuadra:' . $value['Numero_Cuadra'] . ' Lado: ' . $value['Id_Lado'] . ' ' . $value['Habilitacion_Urbana'] . ' ' . $value['Zona']; ?></td>
                          <td class="text-center">
                            <div class="btn-group">
                              <img src='./vistas/img/iconos/agregar.png' class="t-icon-tbl btnEditarViascalles1" title='Nuevo' idUsuario="<?php echo $value['Id_Ubica_Vias_Urbano'] ?>" data-toggle="modal" data-target="#modalAgregarArancel">
                              </button>
                            </div>
                          </td>
                        </tr>
                      <?php endforeach;
                    } else { ?> <tr>
                        No Existen Vias Registradas
                      </tr>
                    <?php } ?>
                  <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="col-md-5 table-responsive">
                <div class="row detalleFila">
                <div class="col-mod-12">  
                <span class="caption_">Valores Aranceles vias</span>
                </div>
                <div class="div_2">
                  <table class="table-container" id="listaDesubFilas">
                    <thead>
                      <tr>
                        <th class="text-center">N°</th>
                        <th class="text-center">Año</th>
                        <th class="text-center">Arancel</th>
                        <th class="text-center">Accion</th>
                      </tr>
                    </thead>
                    <tbody id="listaAranceles">
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
    </section>
</div>

<div id="modalAgregarArancel" class="modal fade modal-forms fullscreen-modal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" id="formRegArancel" class="form-inserta" enctype="multipart/form-data">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <caption>NUEVO ARANCEL POR VIA </caption>
        </div>
        <div class="modal-body">
          <div class="box-body">
            <div class="col-md-8">
              <div id="respuestaAjax"></div>
              <div class="form-group">
                <input type="hidden" class="form-control " id="idViau" name="idViau" value="true">
                <input type="hidden" class="form-control " id="idViaub" name="idViaub" value="">
              </div>
              <div class="form-group">
                <label for="">Año</label>
                <select class="form-control " name="id_AnioArancel" id="id_AnioArancel">
                  <option value="" disabled="" selected="">Selecionar Anio</option>
                  <?php
                  $tabla = 'anio';
                  $financiamiento = Controladorviascalles::ctrMostrarData($tabla);
                  foreach ($financiamiento as $data) {
                    echo "<option value='" . $data['Id_Anio'] . "'>" . $data['NomAnio'] . '</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label for="">Arancel</label>
                <select class="form-control " name="idArancelVia" id="idArancelVia">
                  <option value="" disabled="" selected="">Selecionar Arancel</option>
                  <?php
                  $tabla = 'arancel';
                  $financiamiento = Controladorviascalles::ctrMostrarData($tabla);
                  foreach ($financiamiento as $data) {
                    echo "<option value='" . $data['Id_Arancel'] . "'>" . $data['Importe'] . '</option>';
                  }
                  ?>
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Salir</button>
          <button id="btnRegistrarArancelVia" name="btnRegistrarArancelVia" type="button" class="btn btn-primary btnusuario" data-dismiss="modal">Registrar</button>
        </div>
        <?php
        // $crearUsuario = ControladorUsuarios::ctrCrearUsuario();
        ?>
      </form>
    </div>
  </div>
</div>
<div id="modalEditarArancelVia" class="modal fade modal-forms fullscreen-modal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" id="formRegArancel_e" class="form-inserta" enctype="multipart/form-data">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <caption>NUEVO ARANCEL POR VIA </caption>
        </div>
        <div class="modal-body">
          <div class="box-body">
            <div class="col-md-8">

              <div id="respuestaAjax"></div>

              <div class="form-group">
                <input type="hidden" class="form-control " id="idarancelVia_e" name="idarancelVia_e">
                <input type="hidden" class="form-control " id="idaranceViaEdi" name="idaranceViaEdi" value="true">
              </div>

              <div class="form-group">
                <label for="">Año</label>
                <select class="form-control " name="id_AnioArancel_e" id="id_AnioArancel_e">
                  <option value="" disabled="" selected="">Selecionar Anio</option>
                  <?php
                  $tabla = 'anio';
                  $financiamiento = Controladorviascalles::ctrMostrarData($tabla);
                  foreach ($financiamiento as $data) {
                    echo "<option value='" . $data['Id_Anio'] . "'>" . $data['NomAnio'] . '</option>';
                  }
                  ?>
                </select>
              </div>

              <div class="form-group">
                <label for="">Arancel</label>
                <select class="form-control " name="idArancel_e" id="idArancel_e">
                  <option value="" disabled="" selected="">Selecionar Arancel</option>
                  <?php
                  $tabla = 'arancel';
                  $financiamiento = Controladorviascalles::ctrMostrarData($tabla);
                  foreach ($financiamiento as $data) {
                    echo "<option value='" . $data['Id_Arancel'] . "'>" . $data['Importe'] . '</option>';
                  }
                  ?>
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Salir</button>
          <button id="btnRegistrarArancelVia_e" name="btnRegistrarArancelVia_e" type="button" class="btn btn-primary btnusuario" data-dismiss="modal">Registrar</button>
        </div>
        <?php
        // $crearUsuario = ControladorUsuarios::ctrCrearUsuario();
        ?>
      </form>
    </div>
  </div>
</div>



<?php
//$borrarDireccion =  ControladorViascalles::ctrBorrarViascalles();
?>
<div class="resultados"></div>