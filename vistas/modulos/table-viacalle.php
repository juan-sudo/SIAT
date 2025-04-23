<?php
use Controladores\Controladorviascalles;
?>


 <table class="table-container" id="registro_vias_modal">
  <thead>
   <tr>
    <th class="text-center">#</th>
    <th class="text-center">Tipo Via</th>
    <th class="text-center">Nombre Via</th>
    <th class="text-center">Manzana</th>
    <th class="text-center">Cuadra</th>
    <th class="text-center">Zona</th>
    <th class="text-center">Habilitacion</th>
    <th class="text-center">Arancel</th>
    <th class="text-center">Id Via</th>
    <th class="text-center">Condición</th>
    <th class="text-center">Accion</th>
   </tr>
  </thead>
  <?php
  $listaProductoss = new ControladorViascalles();
  $listaProductoss-> ctrListarViascalles();
				// <tbody class='body-viascalles'></tbody>
  ?> 
 </table>

