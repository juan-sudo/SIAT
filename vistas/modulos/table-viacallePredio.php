<?php
use Controladores\Controladorviascalles;
?>


 <table class="table-container" id="registro_vias_modalPredio">
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
    <th class="btn-prod text-center">Accion</th>
   </tr>
  </thead>
  <?php
      $listaViaCalle_predio = new ControladorViascalles();
      $listaViaCalle_predio-> ctrListarViascallesPredio();
  ?> 
  <!-- <tbody class='body-viascallesPredio'></tbody>-->
 </table>
