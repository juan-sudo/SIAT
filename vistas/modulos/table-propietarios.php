<?php
use Controladores\ControladorContribuyente;
?>

<div class="row">
 <!-- BUSQUEDA NOMBRE DE CALLE-->
 <div class="contenedor-busqueda">
  <div class="input-group-search">
   <div class="input-search">
    <input type="search" class="search_direccion" id="searchPropietario" name="searchPropietario" placeholder="Ingrese Codigo, DNI o Nombres" onkeyup="loadPropietario(1)">
    <input type="hidden" id="perfilOculto_p" value="<?php echo $_SESSION['perfil'] ?>">
   </div>
  </div>
 </div>
</div>

 <table class="table-container" id="registro_propietario_modal">
  <thead>

   <tr>
    <th class="text-center">#</th>
    <!-- <th>Imagen</th> -->
    <th class="text-center">Codigo</th>
    <th class="text-center">Documento</th>
    <th class="text-center">Nombres</th>
    <th class="btn-prod text-center">Acción</th>
   </tr>
  </thead>


  <?php
  //  $clasificacion = ControladorViascalles::ctrMostrarViascalles();
  $listaProductoss = new ControladorContribuyente();
  $listaProductoss-> ctrListarContribuyente_modal();
  ?> 
 </table>
