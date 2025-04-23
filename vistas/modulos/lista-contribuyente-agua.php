<?php
use Controladores\ControladorContribuyente;
use Controladores\ControladorCategorias;
?>
<div class="content-wrapper panel-medio-principal">
    <section class="container-fluid panel-medio">
      <div class="box container-fluid" style="border:0px; margin:0px; padding:0px;">
         <div class="col-lg-12 col-xs-12">

                     <div>
                     <h6>Lista Contribuyente Agua</h6>
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
                     <input type="search" class="search_codigo" id="searchUsuarioAgua_lista" name="searchUsuarioAgua_lista" placeholder="Codigo" onkeyup="lista_contribuyente_agua(1,'search_codigo')">
                     <input type="search" class="search_dni" id="searchUsuarioAgua_lista" name="searchUsuarioAgua_lista" placeholder="Documento DNI" onkeyup="lista_contribuyente_agua(1,'search_dni')">
                     <input type="search" class="search_nombres" id="searchUsuarioAgua_lista" name="searchUsuarioAgua_lista" placeholder="Nombres y Apellidos" onkeyup="lista_contribuyente_agua(1,'search_nombres')">
                     <input type="hidden" id="perfilOculto_c" value="<?php echo $_SESSION['perfil'] ?>">
                  </div>
                  <br>
               </div>
        </div>

        <div class="table-responsive">
          <table class="table-container" width="100%">
            <thead>
              <tr>
                <th class="text-center" style="width:10px;">N°</th>
                <th class="text-center">ID</th>
                <th class="text-center">DNI</th>
                <th class="text-center">Nombres</th>
                <th class="text-center">Direccion Fiscal</th>
                <th class="text-center">Espacio</th>
                <th class="text-center">Estado</th>
                <th class="text-center" width="150px">Acciones</th>
              </tr>
            </thead>
            <tbody class='body-contribuyente_agua_lista'>
            <!-- Lista de Contribuyente de licencia de agua -->
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- Modal Seleccionar propietario -->
<?php include_once "modal_predio_propietario.php";  ?>
<!-- Modal Seleccionar propietario -->