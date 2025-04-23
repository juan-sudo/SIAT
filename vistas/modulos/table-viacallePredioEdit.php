<?php
use Controladores\Controladorviascalles;
?>
<div class="row">
 <!-- BUSQUEDA NOMBRE DE CALLE-->
 <div class="contenedor-busqueda">
  <div class="input-group-search">
   <div class="input-search">
    <input type="search" class="search" id="searchViacallePredio" name="searchViacallePredio" placeholder="Ingrese Nombre de Via o Calle..." onkeyup="loadViacallePredioE()">
    <span class="input-group-addo"><i class="fa fa-search"></i></span>
    <input type="hidden" id="perfilOculto_predio" value="<?php echo $_SESSION['perfil'] ?>">
   </div>
  </div>
 </div>
</div>
<div class="table-responsive">
 <table class="table-container" id="registro_vias_modalPredio">
  <thead>
   <tr>
    <th class="text-center">N°</th>
    <th class="text-center">Tipo Via</th>
    <th class="text-center">Nombre Via</th>
    <th class="text-center">Manzana</th>
    <th class="text-center">Cuadra</th>
    <th class="text-center">Zona</th>
    <th class="text-center">Habilitacion</th>
    <th class="text-center">Arancel</th>
    <th class="text-center">Id Via</th>
    <th class="text-center">Condición</th>
    <th class="btn-prod" style="border: 1px solid gray;">Accion</th>
   </tr>
  </thead>
  <?php
      $listaViaCalle_predio = new ControladorViascalles();
      $listaViaCalle_predio-> ctrListarViascallesPredio();
  ?> 
<!-- <tbody class='body-viascallesPredio'></tbody>-->
 </table>
</div>