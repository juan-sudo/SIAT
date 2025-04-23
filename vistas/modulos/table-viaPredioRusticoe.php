<?php

use Controladores\Controladorviascalles;
?>
<div class="row">
	<!-- BUSQUEDA NOMBRE DE CALLE-->
	<div class="contenedor-busqueda">
		<div class="input-group-search">
			<div class="input-search">
				<input type="search" class="search_direccion" id="searchPredioRustico" name="searchPredioRustico" placeholder="Ingrese Nombre de la Zona ..." onkeyup="loadViacallePredioRusticoe()">
				<input type="hidden" id="perfilOculto_predio" value="<?php echo $_SESSION['perfil'] ?>">
			</div>
		</div>
	</div>
</div>
<div class="table-responsive">
	<table class="table-container"  id="registro_rustico_modalPredio">
		<thead>
			<tr>
				<th class="text-center">#</th>
				<th class="text-center">Nombre Zona</th>
				<th class="text-center">id_zona</th>
				<th class="text-center">Grupo Tierra</th>
				<th class="text-center">Categoria</th>
				<th class="text-center">Calidad Agricola</th>
				<th class="text-center">Valor x Hectarea</th>
				<th class="text-center">Año</th>
				<th class="text-center">Id</th>
				<th class="btn-prod text-center">Accion</th>
			</tr>
		</thead>
		<tbody class='body-prediosRusticos'>

		</tbody>
	</table>
</div>