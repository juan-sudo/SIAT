<?php

use Controladores\ControladorContribuyente;
?>
<div class="content-wrapper panel-medio-principal">
	<section class="container-fluid panel-medio">
		<div class="box container-fluid" style="border:0px; margin:0px; padding:0px;">
			<div class="col-lg-12 col-xs-12">
				<div>
					<h6>Contribuyentes Orden de Pago - Impuesto</h6>
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
							<input type="search" class="search_codigo" id="searchContribuyente_caja" name="searchContribuyente_caja" placeholder="Codigo" onkeyup="loadContribuyente_caja(1,'search_codigo','orden')">
							<input type="search" class="search_dni" id="searchContribuyente_caja" name="searchContribuyente_caja" placeholder="Documento DNI" onkeyup="loadContribuyente_caja(1,'search_dni','orden')">
							<input type="search" class="search_nombres" id="searchContribuyente_caja" name="searchContribuyente_caja" placeholder="Nombres y Apellidos" onkeyup="loadContribuyente_caja(1,'search_nombres','orden')">
							<input type="hidden" id="perfilOculto_c" value="<?php echo $_SESSION['perfil'] ?>">
						</div>
						<br>
					</div>
				</div>
			</div>
			<div class="table-responsive">
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
							<th class="text-center" width="150px">Acciones</th>
						</tr>
					</thead>
					<tbody class='body-contribuyente-caja'>
						<!--contenido dinamico lista contribuyente caja -->
					</tbody>
				</table>
			</div>

	</section>
</div>

<!-- <div id="resultados"></div> -->
<?php
$eliminarProducto = new ControladorContribuyente();
$eliminarProducto->ctrEliminarContribuyente();
?>


<!-- Modal Seleccionar propietario -->
<?php include_once "modal_predio_propietario.php";  ?>
<!-- Modal Seleccionar propietario -->