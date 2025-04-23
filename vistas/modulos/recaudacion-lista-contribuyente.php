<?php
use Controladores\ControladorPredio;
use Controladores\ControladorContribuyente;
?>
<div class="content-wrapper panel-medio-principal">
    <section class="container-fluid panel-medio">
          <div class="box container-fluid" style="border:0px; margin:0px; padding:0px;">
            <div class="col-lg-12 col-xs-12">
                        <div>
                        <h6>Administración de Estado Cuenta por Contribuyente</h6>
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
            <input type="search" class="search_codigo" id="searchContribuyente_impuesto" name="searchContribuyente_impuesto" placeholder="Codigo" onkeyup="recaudar_loadContribuyente_impuesto(1,'search_codigo','')">
            <input type="search" class="search_dni" id="searchContribuyente_impuesto" name="searchContribuyente_impuesto" placeholder="Documento DNI" onkeyup="recaudar_loadContribuyente_impuesto(1,'search_dni','')">
            <input type="search" class="search_nombres" id="searchContribuyente_impuesto" name="searchContribuyente_impuesto" placeholder="Apellidos y Nombres" onkeyup="recaudar_loadContribuyente_impuesto(1,'search_nombres','')">
            <input type="search" class="search_codigo_sa" id="searchContribuyente_impuesto" name="searchContribuyente_impuesto" placeholder="Codigo SIAT" onkeyup="recaudar_loadContribuyente_impuesto(1,'search_codigo_sa','')">
                   
            <input type="hidden" id="perfilOculto_c" value="<?php echo $_SESSION['perfil'] ?>">
						</div>
            <br>
					</div>
				</div>
			
					<table class="table-container" width="100%">
						<thead>
							<tr>
								<th class="text-center" style="width:10px;">#</th>
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
	</section>
</div>

<!-- MODAL DE CALCULAR IMPUESTO -->
<div class="modal fade" id="modalCalcularImpuesto" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
      	  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="staticBackdropLabel">Calcular Impuesto Predial - Arbitrios Municipales</h5>
      
      </div>
      <div class="table-responsive modal-body">
        <CENTER>
        <table class="table-bordered">
        <tr>
            <td colspan="4"></td>
            
            <th>Año</th>
            <td colspan="2"><select class="busqueda_filtros" id="selectnum_impuesto" name="selectnum_impuesto" onchange="loadPredio_impuesto(1)">
                    <?php
                    $tabla_anio = 'anio';
                    $anio = ControladorPredio::ctrMostrarData($tabla_anio);
                    foreach ($anio as $data_anio) {
                      echo "<option value='" . $data_anio['Id_Anio'] . "'>" . $data_anio['NomAnio'] . '</option>';
                    }
                    ?>
                  </select>
            </td>
        </tr>
        <tr>
            <th>Contribuyente(s)</th>
            <th>Código</th>
            <th>DNI</th>
            <th>Nombres</th>
        </tr>
        <!-- CONTENIDO DE FORMA DINAMICO DE PROPIETARIOS-->
        <tr>
            <th>Total Predio</th>
            <td id='total_predio'></td>
            <th>Predio Afectos</th>
            <td id="predio_afecto"></td>
        </tr>
        <tr>
            <th>Total Valor Afecto</th>
            <td id='base_imponible'></td>
            <th>Impuesto Anual</th>
            <td id='impuesto_anual'></td>
            <th>Cuota Trimestral</th>
            <td id='impuesto_trimestral'></td>
        </tr>
        <tr>
            <th>Gastos de Emisión</th>
            <td id='gasto_emision'></td>
            <th>Total a Pagar S/.</th>
            <td id='total_pagar'></td>
        </tr>
    </table>
     </CENTER>
      </div>
      
      <div class="table-responsive modal-body">
        <CENTER>
	        <table class="table-bordered" width="100%">
		        	<caption>Lista de Predios afectos al impuesto y arbitrios</caption>
		         <thead>
		         	<th>Codigo</th>
		         	<th>Tipo</th>
		         	<th>Direccion</th>
		         	<th>Catastro</th>
		         	<th>Condicion</th>
		         </thead>
		         <tbody id="predios_impuesto">
		         	
		         </tbody>
	        </table>
        </CENTER>
      </div>
      <div class="row2 col-md-12" id="respuestaAjax">
        <!--CONTENIDO DINAMICO DE MENSAJE POR NO COMPLETAR CAMPOS -->
      </div>
      

      <div class="modal-footer">
        
        <button  type="button" data-toggle="modal" data-target="#modalCalcularImpuesto_si_no" class="btn btn-primary boton_calcular">Calcular</button>
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

<?php
$eliminarProducto = new ControladorContribuyente();
$eliminarProducto->ctrEliminarContribuyente();
?>
<!-- Modal AGGREGAR DOMICILIO -->
<div class="modal fade bd-example-modal-lg" id="modalViascalles" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">

			<div class="modal-body">
				<div class="col-12">
					<?php include_once "table-viacalle.php";  ?>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="far fa-times-circle fa-lg"></i> Cerrar</button>
					<!-- <button type="button" class="btn btn-primary">Save changes</button> -->
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Modal fin AGGREGAR DOMICILIO -->

<!-- Modal Seleccionar propietario -->
<?php include_once "modal_predio_propietario.php";  ?>
<!-- Modal Seleccionar propietario -->