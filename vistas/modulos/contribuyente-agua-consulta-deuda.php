<?php

use Controladores\ControladorEmpresa;
use Controladores\ControladorPredio;
use Controladores\ControladorContribuyente;

$empresa_igv = ControladorEmpresa::ctrEmisor();
?>
<?php
$idParam = $_GET['id'];
// Divide el valor en un array utilizando el guion (-) como delimitador
$idArray = explode('-', $idParam);
// Elimina elementos vacíos (por ejemplo, si hay varios guiones juntos)
$idArray = array_filter($idArray);
// Ahora $idArray contiene los valores sin guiones
?>
<div class="content-wrapper panel-medio-principal">
  <section class="container-fluid panel-medio">
    <div class="box container-fluid" style="border:0px; margin:0px; padding:0px;">
      <div class="col-lg-12 col-xs-12" style="border:0px; margin:0px; padding:0px;  border-radius:10px;">
        <?php
        $datos_contribuyente = ControladorContribuyente::CntrVerificar_Parametro($idArray);
        if (count($datos_contribuyente) > 0) {
        ?>
          <div class="col-md-6">
            <div id="respuestaAjax_correcto"></div>
            <legend>P R O P I E T A R I O (S)</legend>
            <div id="div_propietarios">
              <table class="table-bordered">
                <thead>
                  <tr>
                    <th>Código</th>
                    <th>Documento</th>
                    <th>Nombres</th>
                  </tr>
                </thead>
                <tbody id="id_propietarios">
                  <?php foreach ($datos_contribuyente as $valor => $filas) {
                    foreach ($filas as $fila) {
                      echo '<tr id="fila" id_contribuyente="' . $fila['Id_Contribuyente'] . '">
                      <td class="text-center">' . $fila['Id_Contribuyente'] . '</td>
                      <td class="text-center">' . $fila['Documento'] . '</td>
                      <td class="text-center">' . $fila['Nombres'] . ' ' . $fila['Apellido_Paterno'] . ' ' . $fila['Apellido_Materno'] . '</td>';
                    }
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
      </div>
    </div>
  </section>
  <section class="container-fluid panel-medio">
    <div class="box rounded">
      <div class="box-header ">
      </div>
      <div class="box-body table-user">
        <div class="row">
          <div class="row">
            <!-- ENTRADA FILTRO AÑO -->
            <div class="col-md-2">
              <div class="form-group">
                <div class="input-group">
                  <input type="hidden" id="perfilOculto_p" value="<?php echo $_SESSION['perfil'] ?>">
                  <span class="input-group-addon"><i class="fas fa-home"></i></span>
                  <select class="busqueda_filtros" id="selectnum" name="selectnum" onchange="loadPredio()" disabled>
                    <?php
                    $tabla_anio = 'anio';
                    $anio = ControladorPredio::ctrMostrarData($tabla_anio);
                    foreach ($anio as $data_anio) {
                      echo "<option value='" . $data_anio['Id_Anio'] . "'>" . $data_anio['NomAnio'] . '</option>';
                    }
                    ?>
                  </select>
                </div>
              </div>
            </div>
            <!-- ENTRADA DATOS CONTRIBUYENTE -->
            <?php
            ?>
            <div class="col-md-4">
              <div class="form-group">
                <div class="input-group">
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <!--TABLA DE PREDIOS-->
            <div class="col-md-6" style=" border: 1px dotted gray;">
              <legend class="text-bold" style="margin-left:15px; font-size:1.3em; letter-spacing: 1px;">
                LISTA CONTRIBUYENTES AGUA - CONSULTA DEUDA:</legend>
              <div class="row divDetallePredio">
                <table class="table table-bordered" id="tablalistaprediosAgua">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>TIPO</th>
                      <th>UBICACION DEL PREDIO</th>
                      <th>ID.CATASTRO</th>
                    </tr>
                  </thead>
                  <?php
                  //$listaProductos = new ControladorPredio();
                  //$listaProductos->ctrListarPredio($_GET['id']);
                  $listaPredio = ControladorPredio::ctrListarPredioAgua($idArray);
                  ?>
                </table>
              </div>
              <!--======== CONTADOR PREDIOS ===========-->
              <div class="row">
                <div class="col-md-2">
                  <div class="form-group">
                    <div class="input-group">
                      <!--    <i class="fas fa-file-invoice fa-3x" id="abrirPopupButton_copiar" data-target="#modalCopiarPredio"></i>-->
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!--DETALLE LICENCIAS-->
            <div class="col-md-6" style=" border: 1px dotted gray;">
              <legend class="text-bold" style="margin-left:15px; font-size:1.3em; letter-spacing: 1px;">
                LICENCIA AGUA:</legend>
              <div class="row divDetallePredio">
                <table class="table table-bordered" id="tablalistaLicences">
                  <thead>
                    <tr>
                      <th>Nro Licencia</th>
                      <th>Fecha Expedicion</th>
                      <th>Accion</th>
                    </tr>
                  </thead>
                  <tbody id="listaLicenciasAgua">
                    <!-- Aqui Aparecen los Licencias del Piso-->
                  </tbody>
                </table>
              </div>
              <div class="row">
                <!-- Boton Casita Registrar Piso-->
                <div class="col-md-2">
                  <div class="form-group">
                    <div class="input-group">
                      <i id="btnAbrirModalNuevaLicencia" class="fas fa-home fa-3x" data-target="#modalAgregarLicencia" title="Nueva Licencia"></i>
                    </div>
                  </div>
                </div>
                <!-- Boton Tarjeta Editar-->
                <div class="col-md-2">
                  <div class="form-group">
                    <div class="input-group">
                      <i id="btnCambioRazonZocial" class="fas fa-id-card fa-3x" title="Cambio Razon Social"></i>
                    </div>
                  </div>
                </div>
                <!-- Boton calcular estado de cuenta-->
                <div class="col-md-2">
                  <div class="form-group">
                    <div class="input-group">
                      <i id="btnProcesarDeuda" class="fas fa-id-card fa-3x" title="Calcular Estado de Cuenta"></i>
                    </div>
                  </div>
                </div>
               
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<?php
        } else {
          echo "<div>error al cargar la pagina</div>";
        } ?>
<!--====== MODAL AGREGAR ALICENCIA ===========-->
<div class="modal" id="modalAgregarLicencia">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <label class="modal-title"> REGISTRO LICENCIAS</label>
      </div>
      <div class="modal-body">
        <form role="form" method="POST" id="formRegistrarLicenciaAgua">
          <div class="row2">
            <label class="cajalabel2">Licencia de:</label>
            <select name="licAguaDesague" class="form2" id="licAguaDesague">
              <option value="0" selected>Seleccione</option>
              <option value="1">Agua</option>
            </select>
            <label class="cajalabel2" for="">Nro Licencia</label>
            <input type="text" class="form" name="numLicenciaAd" id="numLicenciaAd">
          </div>
          <section id="datosLicencia">
            <div class="row2"> <!-- Otorgado a-->
              <legend> Otorgado a</legend>
              <label class="cajalabel2">Propietarios:</label>
              <select name="propietarioLic" class="form5" id="propietarioLic">
                <?php foreach ($datos_contribuyente as $valor => $filas) {
                  foreach ($filas as $fila) {
                    echo "<option value='" . $fila['Id_Contribuyente'] . "' dniatri='" . $fila['Documento'] . "'>" . $fila['Nombres'] . ' ' . $fila['Apellido_Paterno'] . ' ' . $fila['Apellido_Materno'] . '</option>';
                  }
                }
                ?>
                <option value='OTROS'>OTROS</option>
              </select>
            </div>
            <div class="row2" id="otrosPropietarios">
              <div class="row">
                <label class="cajalabel2" for="">Nro DNI:</label>
                <input type="text" class="form" name="numDniOtros" id="numDniOtros">
              </div>
              <div class="row">
                <label class="cajalabel2" for="">Nombres :</label>
                <input type="text" class="form" name="nombOtros" id="nombOtros">
                <label class="cajalabel2" for="">Ape. Paterno:</label>
                <input type="text" class="form" name="apePatOtros" id="apePatOtros">
                <label class="cajalabel2" for="">Ape. Materno:</label>
                <input type="text" class="form" name="apeMatOtros" id="apeMatOtros">
              </div>
            </div>
            <div class="row2"> <!-- info Expediente-->
              <legend> Informacion Expediente</legend>
              <div class="row">
                <label class="cajalabel2"># Expediente: </label>
                <input type="text" name="numExpedienteLic" id="numExpedienteLic" class="form2">
                <label class="cajalabel2"> Fecha Exp.: </label>
                <input type="date" id="fechaExpediente" name="fechaExpediente" class="form2">
              </div>
            </div>
            <div class="row2"> <!-- Recibo Pago-->
              <legend> Informacion Pago</legend>
              <div class="row">
                <label class="cajalabel2"># Recibo Caja: </label>
                <input type="text" name="numReciboCaja" id="numReciboCaja" class="form2">
                <label class="cajalabel2"># Provedio: </label>
                <input type="text" id="numProvedio" name="numProvedio" class="form2">
                <input type="hidden" id="idproveidor" name="idproveidor" class="form2">
              </div>
              <div class="row" style="padding-left: 115px !important;">
                <input id="buscarReciboPago" name="buscarReciboPago" type="button" value="Validar Recibo" class="form2">
                <label class="cajalabel2" id="respuestaRecibo" name="respuestaRecibo"> - </label>
              </div>
            </div>
            <div class="row2"> <!-- Ubicacion-->
              <legend> Ubicacion</legend>
              <div>
                <label for="">Ubicacion Predio : </label>
                <label for="" id="labelUbicacionLic">-</label>
              </div>
              <div>
                <label for="">Catastro predio : </label>
                <label for="" id="labelCatastroLic">-</label>
                <input type="hidden" id="codigoCatastral" name="codigoCatastral">
              </div>
            </div>
            <div class="row2"> <!-- Detalle Licencia-->
              <legend> Detalle Licencia </legend>
              <div class="row">
                <div class="col-lg-5 col-md-6"><!-- Tipo Instalacion-->
                  <label class="cajalabel2">Tipo:</label>
                  <select name="tipoLicenciaAd" class="form2" id="tipoLicenciaAd">
                    <option selected>Seleccione</option>
                    <option>PERMANENTE</option>
                    <option>TEMPORAL</option>
                  </select>
                </div>
                <div class="col-lg-5 col-md-6"><!-- Medida tuberia-->
                  <label class="cajalabel2">Tuberia(m):</label>
                  <select name="tuberiaAd" class="form2" id="tuberiaAd">
                    <option selected>Seleccione</option>
                    <option>1/2"</option>
                    <option>3/4"</option>
                    <option> 1"</option>
                  </select>
                </div>
                <div class="col-lg-5 col-md-6"><!-- Categoria Licencia-->
                  <label class="cajalabel2">Categoria: </label>
                  <select name="categoriaLicAd" class="form2" id="categoriaLicAd">
                    <option selected>Seleccione</option>
                    <option value="1">A</option>
                    <option value="2">B</option>
                    <option value="3">C</option>
                  </select>
                </div>
                <div class="col-lg-5 col-md-6"><!-- Tamaño suministro-->
                  <label class="cajalabel2">Ext. Suministro: </label>
                  <select name="extSuministriAd" class="form2" id="extSuministriAd">
                    <option selected>Seleccione</option>
                    <option> 2 ML</option>
                    <option> 5 ML</option>
                    <option> 8 ML</option>
                  </select>
                </div>
                <div class="col-lg-5 col-md-6"><!-- Prueba Instalacion-->
                  <label class="cajalabel2">Prueba Insp.: </label>
                  <label>
                    <input type="radio" id="pruebaCheckbox" name="pruebaCheckbox" value="SI"> SI
                  </label>
                  <label>
                    <input type="radio" id="pruebaCheckbox" name="pruebaCheckbox" value="NO"> NO
                  </label>
                </div>
                <div class="col-lg-5 col-md-6"><!-- Rotura Vereda-->
                  <label class="cajalabel2">Rotura Vereda: </label>
                  <label>
                    <input type="radio" id="roturaCheckbox" name="roturaCheckbox" value="SI"> SI
                  </label>
                  <label>
                    <input type="radio" id="roturaCheckbox" name="roturaCheckbox" value="NO"> NO
                  </label>
                </div>
                <div class="col-lg-5 col-md-6"><!-- Rotura Vereda-->
                  <label class="cajalabel2">Feccha Exp:</label>
                  <input type="date" id="fechaExpedLic" name="fechaExpedLic">
                </div>
              </div>
            </div>
            <div class="row2"> <!-- Obsercacion-->
              <legend> Observaciones</legend>
              <input class="form5" type="text" name="obsLicAd" id="obsLicAd">
            </div>
          </section>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" id="salirRegistroLicenAguaModal" class="btn btn-secondary btn-cancelar">Salir</button>
        <button type="button" class="btn btn-primary" id="btnRegistrarLicenAgua">Registrar</button>
      </div>
      <div class="row2 col-md-12" id="errorLicenciaAgua">
        <!--CONTENIDO DINAMICO DE MENSAJE POR NO COMPLETAR CAMPOS -->
      </div>
    </div>
  </div>
  <div class="resultados"></div>
</div>
<!--====== MODAL EDITAR ALICENCIA ===========-->
<div class="modal" id="modalEditarLicencia">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <label class="modal-title"> EDITAR LICENCIA</label>
      </div>
      <div class="modal-body">
        <form role="form" method="POST" id="formRegistrarLicenciaAguaEdit">
          <div class="row2">
            <label class="cajalabel2">Licencia de:</label>
            <select name="licAguaDesagueEdit" class="form2" id="licAguaDesagueEdit">
              <option value="0">Seleccione</option>
              <option value="1" selected>Agua</option>
            </select>
            <label class="cajalabel2" for="">Nro Licencia</label>
            <input type="text" class="form" name="numLicenciaAdEdit" id="numLicenciaAdEdit">
          </div>
          <section id="datosLicencia">
            <div class="row2"> <!-- Otorgado a-->
              <legend> Otorgado a</legend>
              <div class="row">
                <label class="cajalabel2" for="">Nro DNI:</label>
                <input type="text" class="form" name="numDniOtrosEdit" id="numDniOtrosEdit">
              </div>
              <label class="cajalabel2">Propietarios:</label>
              <input name="propietarioLicEdit" class="form5" id="propietarioLicEdit">
            </div>
            <div class="row2"> <!-- info Expediente-->
              <legend> Informacion Expediente</legend>
              <div class="row">
                <label class="cajalabel2"># Expediente: </label>
                <input type="text" name="numExpedienteLicEdit" id="numExpedienteLicEdit" class="form2">
                <label class="cajalabel2"> Fecha Exp.: </label>
                <input type="date" name="fechaExpedienteEdit" id="fechaExpedienteEdit" class="form2">
              </div>
            </div>
            <div class="row2"> <!-- Recibo Pago-->
              <legend> Informacion Pago</legend>
              <div class="row">
                <label class="cajalabel2"># Recibo Caja: </label>
                <input type="text" name="numReciboCajaEdit" id="numReciboCajaEdit" class="form2">
                <label class="cajalabel2"># Provedio: </label>
                <input type="text" id="numProvedioEdit" name="numProvedioEdit" class="form2">
              </div>
            </div>
            <div class="row2"> <!-- Ubicacion-->
              <legend> Ubicacion</legend>
              <div>
                <label for="">Ubicacion Predio : </label>
                <label for="" id="labelUbicacionLicEdit">-</label>
              </div>
              <div>
                <label for="">Catastro predio : </label>
                <label for="" id="labelCatastroLicEdit">-</label>
                <input type="hidden" class="form" id="idLicenciEdit" name="idLicenciEdit">
              </div>
            </div>
            <div class="row2"> <!-- Detalle Licencia-->
              <legend> Detalle Licencia </legend>
              <div class="row">
                <div class="col-lg-5 col-md-6"><!-- Tipo Instalacion-->
                  <label class="cajalabel2">Tipo:</label>
                  <select name="tipoLicenciaAdEdit" class="form2" id="tipoLicenciaAdEdit">
                    <option selected>Seleccione</option>
                    <option>PERMANENTE</option>
                    <option>TEMPORAL</option>
                  </select>
                </div>
                <div class="col-lg-5 col-md-6"><!-- Medida tuberia-->
                  <label class="cajalabel2">Tuberia(m):</label>
                  <select name="tuberiaAdEdit" class="form2" id="tuberiaAdEdit">
                    <option selected>Seleccione</option>
                    <option>1/2"</option>
                    <option>3/4"</option>
                    <option> 1"</option>
                  </select>
                </div>
                <div class="col-lg-5 col-md-6"><!-- Categoria Licencia-->
                  <label class="cajalabel2">Categoria: </label>
                  <select name="categoriaLicAdEdit" class="form2" id="categoriaLicAdEdit">
                    <option selected>Seleccione</option>
                    <option value="1">A</option>
                    <option value="2">B</option>
                    <option value="3">C</option>
                  </select>
                </div>
                <div class="col-lg-5 col-md-6"><!-- Tamaño suministro-->
                  <label class="cajalabel2">Ext. Suministro: </label>
                  <select name="extSuministriAdEdit" class="form2" id="extSuministriAdEdit">
                    <option selected>Seleccione</option>
                    <option> 2 ML</option>
                    <option> 5 ML</option>
                    <option> 8 ML</option>
                  </select>
                </div>
                <div class="col-lg-5 col-md-6"><!-- Prueba Instalacion-->
                  <label class="cajalabel2">Prueba Insp.: </label>
                  <input type="radio" id="pruebaCheckboxEdit" name="pruebaCheckboxEdit" value="1"> SI
                  <input type="radio" id="pruebaCheckboxEdit" name="pruebaCheckboxEdit" value="0"> NO
                </div>
                <div class="col-lg-5 col-md-6"><!-- Rotura Vereda-->
                  <label class="cajalabel2">Rotura Vereda: </label>
                  <input type="radio" id="roturaCheckboxEdit" name="roturaCheckboxEdit" value="1"> SI
                  <input type="radio" id="roturaCheckboxEdit" name="roturaCheckboxEdit" value="0"> NO
                </div>
                <div class="col-lg-5 col-md-6"><!-- Rotura Vereda-->
                  <label class="cajalabel2">Feccha Exp:</label>
                  <input type="date" id="fechaExpedLicEdit" name="fechaExpedLicEdit">
                </div>
              </div>
            </div>
            <div class="row2"> <!-- Obsercacion-->
              <legend> Observaciones</legend>
              <input class="form5" type="text" name="obsLicAdEdit" id="obsLicAdEdit">
            </div>
          </section>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" id="salirRegistroLicenAguaEdit" class="btn btn-secondary btn-cancelar">Salir</button>
        <button type="button" class="btn btn-primary" id="btnRegistrarLicenAguaEdit">Modificar</button>
      </div>
      <div class="row2 col-md-12" id="errorLicenciaAguaEdit">
        <!--CONTENIDO DINAMICO DE MENSAJE POR NO COMPLETAR CAMPOS -->
      </div>
    </div>
  </div>
  <div class="resultados"></div>
</div>
<!--====== MODAL TRANSFERIR ===========-->
<div class="modal" id="modalTranferirLicence">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <label class="modal-title"> TRANSFERIR LICENCIA</label>
      </div>
      <div class="modal-body">
        <form role="form" method="POST" id="formTransferirLicenciaAguaEdit">
          <div class="row2">
            <label class="cajalabel2">Licencia de:</label>
            <select name="licAguaDesagueEdit" class="form2" id="licAguaDesagueEdit">
              <option value="0">Seleccione</option>
              <option value="1" selected>Agua</option>
            </select>
            <label class="cajalabel2" for="">Nro Licencia</label>
            <input type="text" class="form" name="numLicenciaAdEditt" id="numLicenciaAdEditt">
            <input type="hidden" class="form" name="idlicencet" id="idlicencet">
          </div>
          <section id="datosLicencia">
            <div class="row2"> <!-- licencia de-->
              <legend> De</legend>
              <div class="row">
                <label class="cajalabel2" for="">Nro DNI:</label>
                <input type="text" class="form" name="numDniOtrosEditt" id="numDniOtrosEditt">
              </div>
              <div class="row">
                <label class="cajalabel2" for="">Nombres:</label>
                <input name="propietarioLicEditt" class="form5" id="propietarioLicEditt">
              </div>
            </div>
            <div class="row2"> <!-- transfiere a-->
              <legend> Para:</legend>
              <label class="cajalabel2">Propietarios:</label>
              <select name="propietarioLictt" class="form5" id="propietarioLictt">
                <?php foreach ($datos_contribuyente as $valor => $filas) {
                  foreach ($filas as $fila) {
                    echo "<option value='" . $fila['Id_Contribuyente'] . "' dniatri='" . $fila['Documento'] . "'>" . $fila['Nombres'] . ' ' . $fila['Apellido_Paterno'] . ' ' . $fila['Apellido_Materno'] . '</option>';
                  }
                }
                ?>
                <option value='OTROS'>OTROS</option>
              </select>
            </div>
            <div class="row2" id="otrosPropietariost">
              <div class="row">
                <label class="cajalabel2" for="">Nro DNI:</label>
                <input type="text" class="form" name="numDniOtrost" id="numDniOtrost">
              </div>
              <div class="row">
                <label class="cajalabel2" for="">Nombres :</label>
                <input type="text" class="form" name="nombOtrost" id="nombOtrost">
                <label class="cajalabel2" for="">Ape. Paterno:</label>
                <input type="text" class="form" name="apePatOtrost" id="apePatOtrost">
                <label class="cajalabel2" for="">Ape. Materno:</label>
                <input type="text" class="form" name="apeMatOtrost" id="apeMatOtrost">
              </div>
            </div>
            <div class="row2"> <!-- Obsercacion-->
              <legend> Observaciones</legend>
              <label class="cajalabel2" for="">Observacion:</label>
              <input class="form5" type="text" name="obsLicAdEditt" id="obsLicAdEditt">
            </div>
          </section>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" id="salirTransferenLicenAguaEdit" class="btn btn-secondary btn-cancelar">Salir</button>
        <button type="button" class="btn btn-primary" id="btnTranferenLicenAguaEdit">Modificar</button>
      </div>
      <div class="row2 col-md-12" id="errorLicenciaAguaEdit">
        <!--CONTENIDO DINAMICO DE MENSAJE POR NO COMPLETAR CAMPOS -->
      </div>
    </div>
  </div>
  <div class="resultados"></div>
</div>

<!--====== MODAL CALCULAR ESTADO DE CUENTA ===========-->
<div class="modal" id="modalEstadoCuentaAgua">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <label class="modal-title"> Calcular Estado de Cuenta Agua</label>
      </div>
      <div class="modal-body">
        <form role="form" method="POST" id="formRegistrarLicenciaAguaEdit">
          <div class="row2">
            <label class="cajalabel2">Licencia de:</label>
            <select name="licAguaDesagueEditCalcular" class="form2" id="licAguaDesagueEdit">
              <option value="0">Seleccione</option>
              <option value="1" selected>Agua</option>
            </select>
            <label class="cajalabel2" for="">Nro Licencia</label>
            <input type="text" class="form" name="numLicenciaAdEditCalcular" id="numLicenciaAdEditCalcular" readonly>
            
           
            <label class="cajalabel2" for="" id="div_condicion_anio">Año</label>
            <span id="anio_agua"></span>
          
          
          </div>
          <section id="datosLicencia">
            <div class="row2"> <!-- Otorgado a-->
              <legend> Otorgado a</legend>
              <div class="row">
                <label class="cajalabel2" for="">Nro DNI:</label>
                <input type="text" class="form" name="numDniOtrosEditCalcular" id="numDniOtrosEditCalcular" readonly>
              </div>
              <label class="cajalabel2">Propietarios:</label>
              <input name="propietarioLicEditCalcular" class="form5" id="propietarioLicEditCalcular" readonly>
            </div>
            <div class="row2"> <!-- Ubicacion-->
              <legend> Ubicacion</legend>
              <div>
                <label for="">Ubicacion Predio : </label>
                <label for="" id="labelUbicacionLicEditCalcular">-</label>
              </div>
              <div>
                <label for="">Catastro predio : </label>
                <label for="" id="labelCatastroLicEditCalcular">-</label>
                <input type="hidden" class="form" id="idLicenciEditCalcular" name="idLicenciEditCalcular">
              </div>
            </div>
            <div class="row2"> <!-- Detalle Licencia-->
              <legend> Detalle Licencia </legend>
              <div class="row">
                <div class="col-lg-5 col-md-6"><!-- Tipo Instalacion-->
                  <label class="cajalabel2">Tipo:</label>
                  <select name="tipoLicenciaAdEditCalcular" class="form2" id="tipoLicenciaAdEditCalcular">
                    <option selected>Seleccione</option>
                    <option>PERMANENTE</option>
                    <option>TEMPORAL</option>
                  </select>
                </div>
                
                <div class="col-lg-5 col-md-4"><!-- Categoria Licencia-->
                  <label class="cajalabel2">Categoria: </label>
                  <select name="categoriaLicAdEditCalcular" class="form2" id="categoriaLicAdEditCalcular">
                    <option selected>Seleccione</option>
                    <option value="1">A</option>
                    <option value="2">B</option>
                    <option value="3">C</option>
                  </select>
                </div>

                <div class="col-lg-5 col-md-4"><!-- Categoria Licencia-->
                  <label class="cajalabel2">Monto: </label>
                  <span id="MontoLicEditCalcular" name="MontoLicEditCalcular"><span>
                </div>
               
                <div class="col-lg-5 col-md-6"><!-- Rotura Vereda-->
                  <label class="cajalabel2">Fecha Exp:</label>
                  <span id="fechaExpedLicEditCalcular" name="fechaExpedLicEditCalcular"></span>
                </div>
            
          </section>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" id="salirEstadoCuentaAgua" class="btn btn-secondary btn-cancelar">Salir</button>
        <button type="button" class="btn btn-primary" id="btnRegistrarEstadoCuentAgua">Calcular</button>
      </div>
      <div class="row2 col-md-12" id="errorLicenciaAguaEdit">
        <!--CONTENIDO DINAMICO DE MENSAJE POR NO COMPLETAR CAMPOS -->
      </div>
    </div>
  </div>
  <div class="resultados"></div>
</div>

<!-- MODAL CONFIRMAR PARA CALCULAR EL ESTADO DE CUENTA DEL AGUA -->
<div class="modal fade" id="modalGenerarAgua_si_no" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="staticBackdropLabel">Calcular Estado Cuenta Agua</h5>
      </div>
      <div class="modal-body">
        <h7>Estas Seguro de calcular el estado de cuenta de agua  del año <span id="anio_formato_la"><!-- CONTENIDO DINAMICO--></span>?</h7>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-primary generardeudaagua">si</button>
      </div>
    </div>
  </div>
</div>
<!-- FIN MODAL CONFIRMAR PARA CALCULAR EL ESTADO DE CUENTA DEL AGUA -->

<!-- MODAL CONFIRMAR PARA RECALCULAR EL ESTADO DE CUENTA DEL AGUA -->
<div class="modal fade" id="modalGenerarRecalculoAgua_si_no" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="staticBackdropLabel">Recalcular Estado Cuenta Agua</h5>
      </div>
      <div class="modal-body">
        <h7>Estas Seguro de Recalcular el estado de cuenta de agua  del año <span id="anio_formato_la"><!-- CONTENIDO DINAMICO--></span>?</h7>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-primary generarRecalculodeudaagua">si</button>
      </div>
    </div>
  </div>
</div>
<!-- FIN MODAL CONFIRMAR PARA RECALCULAR EL ESTADO DE CUENTA DEL AGUA -->


<div class="resultados"></div>
<div id="errorLicence"><!--CONTENIDO DINAMICO  --></div>
<div id="respuestaAjax_correcto"></div>

