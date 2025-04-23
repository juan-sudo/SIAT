<?php
use Controladores\ControladorContribuyente;
use Controladores\ControladorCategorias;
?>

<div class="content-wrapper panel-medio-principal">
   <section class="container-fluid panel-medio">
      <div class="box container-fluid" style="border:0px; margin:0px; padding:0px;">
         <div class="col-lg-12 col-xs-12">

                     <div>
                     <h6>Administración de Licencia de Agua</h6>
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
                     <input type="search" class="search_codigo" id="searchUsuarioAgua" name="searchUsuarioAgua" placeholder="Codigo" onkeyup="loadContribuyenteAgua(1,'search_codigo')">
                     <input type="search" class="search_dni" id="searchUsuarioAgua" name="searchUsuarioAgua" placeholder="Documento DNI" onkeyup="loadContribuyenteAgua(1,'search_dni')">
                     <input type="search" class="search_nombres" id="searchUsuarioAgua" name="searchUsuarioAgua" placeholder="Nombres y Apellidos" onkeyup="loadContribuyenteAgua(1,'search_nombres')">
                     <input type="hidden" id="perfilOculto_c" value="<?php echo $_SESSION['perfil'] ?>">
                  </div>
                  <br>
               </div>
         </div>
         
               <!-- table-bordered table-striped  -->
               <table class="table-container" width="100%">
                  <thead>
                     <tr>
                        <th class="text-center" style="width:10px;">N°</th>
                        <th class="text-center">Codigo</th>
                        <th class="text-center">Tipo</th>
                        <th class="text-center">DNI</th>
                        <th class="text-center">Nombres</th>
                        <th class="text-center">Direccion Fiscal</th>
                        <th class="text-center" >Estado</th>
                        <th class="text-center" width="150px">Acciones</th>
                     </tr>
                  </thead>
                  <tbody class="body-contribuyente">
                  </tbody>
               </table>
           
         </div>
      </div>

   </section>
</div>

<!-- Modal Seleccionar propietario -->
<?php include_once "modal_predio_propietario.php";  ?>
<!-- Modal Seleccionar propietario -->