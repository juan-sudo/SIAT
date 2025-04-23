<?php

use Controladores\ControladorPredio;

error_reporting(0);
?>

<!--
<div class="content-wrapper panel-medio-principal">
  <section class="container-fluid panel-medio">
    <div class="box container-fluid" style="border:0px; margin:0px; padding:0px;">
      <div class="col-lg-12 col-xs-12">

        <div>
          <h6>Contribuyente para Calcular Impuesto</h6>
        </div>
      </div>
    </div>
  </section>

  <section class="container-fluid panel-medio">
    <div class="box rounded">
      <div class="box-body table-user">
        <div class="contenedor-busqueda">
          <div class="input-group-search">
            <div class="input-search">
              <input type="search" class="search_codigo" id="searchContribuyente" name="searchContribuyente" placeholder="Codigo" onkeyup="loadContribuyente_impuesto_(1,'search_codigo')">
              <input type="search" class="search_dni" id="searchContribuyente" name="searchContribuyente" placeholder="Documento DNI" onkeyup="loadContribuyente_impuesto_(1,'search_dni')">
              <input type="search" class="search_nombres" id="searchContribuyente" name="searchContribuyente" placeholder="Nombres y Apellidos" onkeyup="loadContribuyente_impuesto_(1,'search_nombres')">
              <input type="search" class="search_codigo_sa" id="searchContribuyente" name="searchContribuyente" placeholder="Codigo SIAT" onkeyup="loadContribuyente_impuesto_(1,'search_codigo_sa')">
                   
              <input type="hidden" id="perfilOculto_c" value="<?php echo $_SESSION['perfil'] ?>">
            </div>
            <br>
          </div>
        </div>

      
        <div class="row divLista_contribuyente_p">
          <table class="table-container" width="100%">
            <thead>
              <tr>
                <th class="text-center" style="width:10px;">N°</th>
                <th class="text-center">Codigo</th>
                <th class="text-center">Tipo</th>
                <th class="text-center">DNI</th>
                <th class="text-center">Nombres</th>
                <th class="text-center">Direccion Fiscal</th>
                <th class="text-center">Estado</th>
                <th class="text-center">SIAT</th>
                <th class="text-center" width="150px">Acciones</th>
              </tr>
            </thead>
            <tbody class="body-contribuyente"></tbody>
          </table>
        </div>
      </div>
    </div>
</div>
</section>
</div>


-->

<!-- MODAL CALCULAR TIM -->
<div class="modal" id="modalCalcularTim">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <label class="modal-title"> CALCULAR TIM</label>
      </div>
      <div class="modal-body">
        <form role="form" method="POST" enctype="multipart/form-data" class="formRegistrarPiso" id="formRegistrarPiso">

          <div class="row">
            <table class="table-container">
              <caption>Contribuyentes </caption>
              <thead>
                <tr>
                  <th class="text-center">Código</th>
                  <th class="text-center">DNI</th>
                  <th class="text-center" colspan="4">Nombres</th>
                </tr>
              </thead>
              <tbody id="contribuyentes-calcularTim">
              </tbody>
            </table>
          </div>
          <div class="row">
            <div class="col-lg-12 col-md-12">
              <label class="cajalabel">Año Fiscal: </label>
              <select id="anioFiscalTim" class="form2" name="anioFiscalTim">
                <option selected="" disabled="">Seleccione</option>
                <?php
                $registros = ControladorPredio::ctrMostrarDataAnio();
                foreach ($registros as $key => $data_d) {
                  $disabled = ($key == 0) ? 'disabled' : ''; // Deshabilita la primera opción
              
                  echo "<option value='" . $data_d['Id_Anio'] . "' $disabled>" . $data_d['NomAnio'] . '</option>';
              }
                ?>
              </select>

              <label class="cajalabel">Tim</label>
              <input id="tasaTim" name="tasaTim" type="number" class="form2">
            </div>
          </div>
          <div class="row">

            <table>
              <thead>
                <th class="text-center">Codigo</th>
                <th class="text-center">Tributo</th>
                <th class="text-center">Año</th>
                <th class="text-center">Periodo</th>
                <th class="text-center">Importe</th>
                <th class="text-center">Gastos</th>
                <th class="text-center">TIM</th>
                <th class="text-center">Subtotal</th>
                <th class="text-center">Descuento</th>
                <th class="text-center">Total</th>
              </thead>
              <tbody id="tbEstadoCuentaContribuyente">
              </tbody>
            </table>

          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" id="salirModalTim" class="btn btn-secondary btn-cancelar">Salir</button>
        <button type="button" class="btn btn-primary" id="btnCalcularTim">Calcular Tim</button>
      </div>
    </div>
  </div>
</div>
<!-- FIN MODAL DE CALCULAR IMPUESTO -->
<!-- MODAL DE CALCULAR IMPUESTO -->
<div class="modal fade" id="modalCalcularImpuesto" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Calcular Impuesto Predial - Arbitrios Municipales</h5>

      </div>
      <div class="table-responsive modal-body">

        <div class="col-md-12 text-right">
          <label>Anio</label>
          <select class="busqueda_filtros" id="selectnum_impuesto" name="selectnum_impuesto" onchange="loadPredio_impuesto(1)">
            <?php
            $anio = ControladorPredio::ctrMostrarDataAnio();
            foreach ($anio as $data_anio) {
              echo "<option value='" . $data_anio['Id_Anio'] . "'>" . $data_anio['NomAnio'] . '</option>';
            }
            ?>
          </select>
        </div>


        <table class="table-container">
          <caption>Contribuyentes </caption>
          <thead>
            <tr>
              <th class="text-center">Código</th>
              <th class="text-center">DNI</th>
              <th class="text-center" colspan="4">Nombres</th>
            </tr>
          </thead>
          <tbody id="contribuyentes-calcular">
          </tbody>
          <br>
          <!-- CONTENIDO DE FORMA DINAMICO DE PROPIETARIOS-->
          <tr>
            <th class="ancho-im-th">Total Predio</th>
            <td class="ancho-im-th-total" id='total_predio'></td>
            <th class="ancho-im-th">Predio Afectos</th>
            <td class="ancho-im-th-total" id="predio_afecto" colspan=""></td>
          </tr>
          <tr>
            <th class="ancho-im-th">Total Valor Afecto</th>
            <td id='base_imponible' class="ancho-im-th-total"></td>
            <th class="ancho-im-th">Impuesto Anual</th>
            <td id='impuesto_anual' class="ancho-im-th-total"></td>
            <th class="ancho-im-th">Cuota Trimestral</th>
            <td id='impuesto_trimestral' class="ancho-im-th-total"></td>
          </tr>
          <tr>
            <th class="ancho-im-th">Gastos de Emisión</th>
            <td id='gasto_emision' class="ancho-im-th-total"></td>
            <th class="ancho-im-th">Total a Pagar S/.</th>
            <td id='total_pagar' colspan="" class="ancho-im-th-total"></td>
          </tr>
        </table>
        </CENTER>
      </div>

      <div class="table-responsive modal-body">
        <div class="row">
          <div class="col-md-6">
            <span class="caption_">Lista de Predios afectos al impuesto y arbitrios</span>
          </div>
          <div class="col-md-6 text-right">
          <span class="caption_ ">Calcular Predios Seleccionados               
          <input type="checkbox" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" id="calculo_predio_select" data-size="mini" data-width="110">  </span>
          </div>
        </div>
        <div class="row divPredio_impuesto">
          <table class="table-container" width="100%">
            <thead>
              <th class="text-center">Codigo</th>
              <th class="text-center">Tipo</th>
              <th class="text-center">Direccion</th>
              <th class="text-center">Condicion</th>
              <th  class="text-center action-column">Accion</th>
            </thead>
            <tbody id="predios_impuesto">
              <!-- Lista de Predios -->
            </tbody>
          </table>
        </div>
      </div>
      <div class="row2 col-md-12" id="respuestaAjax">
        <!--CONTENIDO DINAMICO DE MENSAJE POR NO COMPLETAR CAMPOS -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary boton_calcular_no" data-dismiss="modal">Salir</button>
        <button type="button" data-target="#modalCalcularImpuesto_si_no" class="btn btn-primary boton_calcular">Calcular</button>
      </div>
    </div>
  </div>
</div>
<!-- FIN MODAL DE CALCULAR IMPUESTO -->

<!-- MODAL PARA CUARGAR SI O NO ELÑ CALCULO IMPUESTO -->
<div class="modal fade" id="modalCalcularImpuesto_si_no" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <span>Estas Seguro de Calcular Impuesto y Arbitrios del <span id="anio_calcular"><!-- CONTENIDO DINAMICO--></span> ?</span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-primary registrar_impuesto_arbitrios">si</button>
      </div>
    </div>
  </div>
</div>
<!-- FIN MODAL PARA CUARGAR SI O NO ELÑ CALCULO IMPUESTO -->

<!-- MODAL PARA RECALCULAR SI O NO ELÑ CALCULO IMPUESTO -->
<div class="modal fade" id="modalRecalcularImpuesto_si_no" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <span>Estas seguro de recalcular su estado de cuenta del año <span id="anio_recalcular"><!-- CONTENIDO DINAMICO--></span> ?</span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-primary recalcular_impuesto_arbitrios">Recalcular</button>
      </div>
    </div>
  </div>
</div>
<!-- FIN MODAL PARA RECALCULAR SI O NO ELÑ CALCULO IMPUESTO -->

<!-- MODAL PARA IMPRIMIR FORMATOS -->
<div class="modal fade" id="modalImprimirFormato" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-fullscreen">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="staticBackdropLabel">Imprimir Formatos</h5>

      </div>
      <div class="table-responsive modal-body">

        <div class="row">
          <div class="col-md-3">
            <div class="list-group" id="list-tab" role="tablist">
              <a class="list-group-item list-group-item-action" id="list-home-list" data-toggle="list" href="#list-hr" role="tab" aria-controls="home"><B>HR</B> (Hoja de Resumen)</a>
              <a class="list-group-item list-group-item-action" id="list-profile-list" data-toggle="list" href="#list-dj" role="tab" aria-controls="profile"><B>DJ</B> (Declaracion Jurada)</a>
              <a class="list-group-item list-group-item-action" id="list-messages-list" data-toggle="list" href="#list-la" role="tab" aria-controls="messages"><B>LA</B> (Liquidacion Arbitrios)</a>
            </div>
          </div>


          <div class="col-md-8 border border-primary">

            <div class="col-md-12 text-right">
              <label>Año</label>
              <select class="busqueda_filtros" id="selectnum_formato" name="selectnum_formato" onchange="loadPredio_formato(1)">
                <?php
                $anio = ControladorPredio::ctrMostrarDataAnio();
                foreach ($anio as $data_anio) {
                  echo "<option value='" . $data_anio['Id_Anio'] . "'>" . $data_anio['NomAnio'] . '</option>';
                }
                ?>
              </select>
            </div>
            <div class="table-responsive modal-body">
              <table class="table-container" width="100%">
                <caption>Contribuyente(s)</caption>
                <thead>
                  <tr>
                    <th class="text-center">Código</th>
                    <th class="text-center">DNI</th>
                    <th class="text-center" colspan='2'>Nombres</th>
                  </tr>
                </thead>
                <tbody id="contribuyentes-calcular-formato">
                  <!-- Lista de Contribuyentes  -->
                </tbody>
                <tr>
                  <th style="display:none;">Total Predio</th> <!--No eliminar-->
                </tr>
              </table>
            </div>

            <div class="tab-content" id="nav-tabContent">

              <div class="tab-pane fade show active" id="list-hr" role="tabpanel" aria-labelledby="list-hr-list">
                <div class="table-responsive modal-body">
                  <span class="caption_">Lista de Predios HR (Hoja de Resumen)</span>
                  <div class="row divPredio_impuesto">
                    <table class="table-container" width="100%">

                      <thead>
                        <th>Codigo</th>
                        <th>Tipo</th>
                        <th>Direccion</th>
                      
                        <th>Condicion</th>
                      </thead>
                      <tbody id="predios_hr">
                        <!-- CONTENIDO DINAMICO DE PREDIOS-->
                      </tbody>

                    </table>
                  </div>
                </div>
              </div>

              <div class="tab-pane fade" id="list-dj" role="tabpanel" aria-labelledby="list-profile-list">
                <div class="table-responsive modal-body">
                  <span class="caption_">Lista de Predios DJ (Declaracion Jurada)</span>
                  <div class="row divPredio_impuesto_dj">
                    <table class="table-container" width="100%" id="predio_dj_table">
                      <thead>
                        <th class="text-center">Codigo</th>
                        <th class="text-center">Tipo</th>
                        <th class="text-center">Direccion</th>
                       
                        <th class="text-center">Condicion</th>
                      </thead>
                      <tbody id="predios_dj">
                        <!-- CONTENIDO DINAMICO DE PREDIOS-->
                      </tbody>
                    </table>
                  </div>
                </div>
                <div id="tablapisos" class="table-responsive modal-body">
                  <!-- contenido dinamico de pisos -->
                </div>

              </div>
              <div class="tab-pane fade" id="list-la" role="tabpanel" aria-labelledby="list-messages-list">
                <div class="table-responsive modal-body">
                  <span class="caption_">Lista de Predios LA (Liquidacion de Arbitrio)</span>
                  <div class="row divPredio_impuesto_dj">
                    <table class="table-container" width="100%" id="predio_la_table">
                      <thead>
                        <th class="text-center">Codigo</th>
                        <th class="text-center">Tipo</th>
                        <th class="text-center">Direccion</th>
                       
                        <th class="text-center">Condicion</th>
                      </thead>
                      <tbody id="predios_la">
                        <!-- CONTENIDO DINAMICO DE PREDIOS-->
                      </tbody>
                    </table>
                  </div>
                </div>
                <div id="tablacuotas" class="table-responsive modal-body">
                  <!-- contenido dinamico de pisos -->
                </div>

              </div>
            </div>
          </div>
        </div>
        <div class="row2 col-md-12" id="respuestaAjax">
          <!--CONTENIDO DINAMICO DE MENSAJE POR NO COMPLETAR CAMPOS -->
        </div>
      </div>
      

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
      </div>

    </div>
  </div>
</div>
<!-- FIN MODAL IMPRIMIR FORMATO -->

<!-- MODAL CONFIRMAR LA IMPRESION DEL FORMATO HR -->
<div class="modal fade" id="modalImprimirFormato_hr_si_no" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="staticBackdropLabel">Imprimir HR</h5>
      </div>
      <div class="modal-body">
        <h7>Estas Seguro de Imprimir formato HR (Hoja de Resumen) del año <span id="anio_formato"><!-- CONTENIDO DINAMICO--></span>?</h7>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-primary print_formato_hr">si</button>
      </div>
    </div>
  </div>
</div>
<!-- FIN MODAL PARA CUARGAR SI O NO ELÑ CALCULO IMPUESTO -->

<!-- MODAL CONFIRMAR LA IMPRESION DEL FORMATO DJ -->
<div class="modal fade" id="modalImprimirFormato_dj_si_no" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="staticBackdropLabel">Imprimir DJ</h5>
      </div>
      <div class="modal-body">
        <h7>Estas Seguro de Imprimir formato DJ (declaracion juarada) del año <span id="anio_formato"><!-- CONTENIDO DINAMICO--></span>?</h7>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-primary print_formato_dj">si</button>
      </div>
    </div>
  </div>
</div>
<!-- FIN MODAL PARA CUARGAR SI O NO ELÑ CALCULO IMPUESTO -->

<!-- MODAL CONFIRMAR LA IMPRESION DEL FORMATO LA -->
<div class="modal fade" id="modalImprimirFormato_la_si_no" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="staticBackdropLabel">Imprimir LA</h5>
      </div>
      <div class="modal-body">
        <h7>Estas Seguro de Imprimir formato LA (Liquidación de Arbitrios) del año <span id="anio_formato_la"><!-- CONTENIDO DINAMICO--></span>?</h7>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-primary print_formato_la">si</button>
      </div>
    </div>
  </div>
</div>
<!-- FIN MODAL PARA CUARGAR SI O NO ELÑ CALCULO IMPUESTO -->

<!-- modal donde se genera el pdf HR -->
<div class="container-fluid">
  <div class="modal in" id="Modalimprimir_HR" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-fullscreen">
      <div class="modal-content">
        <div class="modal-body printerhere">
          <iframe id="iframe_hr" class="iframe-full-height"><!-- Muestra el PDF --></iframe>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- fin de generar pdf HR-->

<!-- modal donde se genera el PDF DJ -->
<div class="container-fluid">
  <div class="modal in" id="Modalimprimir_DJ" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-fullscreen">
      <div class="modal-content">
        <div class="modal-body printerhere">
          <iframe id="iframe_dj" class="iframe-full-height"><!-- Muestra el PDF --></iframe>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- fin de generar pdf DJ-->

<!-- modal donde se genera el PDF LA -->
<div class="container-fluid">
  <div class="modal in" id="Modalimprimir_LA" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-fullscreen">
      <div class="modal-content">
        <div class="modal-header">
        </div>
        <div class="modal-body printerhere">
          <iframe id="iframe_la" class="iframe-full-height"><!-- Muestra el PDF --></iframe>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- fin de generar pdf LA-->


<!-- MODAL CONFIRMAR LA CALCULO DE PREDIOS SELECCIONADOS -->
<div class="modal fade" id="modal_seleccion_predio_select" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
       
        </button>
        <h6 class="modal-title" id="staticBackdropLabel">Calcular Predios Seleccionados</h6>
      </div>
      <div class="modal-body">
        <h7>Estas Seguro de calcular predios que seleccionara ?</h7>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary mostrar_predios_seleccionados_no" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-primary mostrar_predios_seleccionados">si</button>
      </div>
    </div>
  </div>
</div>
<!-- FIN MODAL PARA CUARGAR SI O NO ELÑ CALCULO IMPUESTO -->


<!-- Modal Seleccionar propietario -->
<?php include_once "modal_predio_propietario.php";  ?>
<!-- Modal Seleccionar propietario -->

<!-- modal cargando -->
<?php include_once "modalcargar.php";  ?>
<!-- fin de modal cargando-->