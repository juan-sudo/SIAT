 <?php 
  use Controladores\ControladorConfiguracion;
  $configuracion = ControladorConfiguracion::ctrConfiguracion();
  
  ?>
  
  <header class="main-header cabecera-m">
 
    <!-- Logo -->
    <a href="inicio" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <!-- <span class="logo-mini"><b>B</b>MM</span> -->
      <span class="logo-mini"><img src="vistas/img/logo/<?php echo $configuracion['logo'] ?>" alt="" width="50px"></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b><?php echo $configuracion['Nombre_Comercial'] ?></b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top cabecera-m">
      <!-- Sidebar toggle button-->
      <button class="btn btn-success-edit  btn-menup" data-toggle="push-menu" role="button">
      <i class="fas fa-align-justify fa-lg"></i>
      </button>        
       
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">

        
          <!-- fin notification ===================== -->
    
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu color_letra_blanco" >
              <div class="space_h6_header_muni"><!---->
                <small> <?php echo  $configuracion['Codigo_eje']. ' - ' . $configuracion['Nombre_Empresa']; ?></small>
                <h6 class="space_h6_header"> <?php echo  $_SESSION['dni']. ' - ' . $_SESSION['nombre']; ?></h6>
              </div>
          </li>

          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-angle-down"></i>
              <span class="label label-warning no-enviados"></span>
            </a>
            <ul class="dropdown-menu menu-user" style="width: 200px; color:black;">
              <?php if($_SESSION['usuario']=='Administrador'){

            ?>
              
              <li class="">
                  <a href="usuarios">
                  <i class="fas fa-user fa-lg" style="color:royalblue"> </i> <span class="mg-menu">Mi perfil</span>               
                  </a>
              </li> 
              <li class="">
                <a href="empresa">
                <i class="fas fa-cog  fa-lg" style="color:royalblue"> </i> <span class="mg-menu">Configurar empresa</span>
                </a>
              </li> 
           <?php } ?>
              <li class="">
                  <a href="salir" class="">
                  <i class="fas fa-sign-out-alt fa-lg" style="color:tomato"></i><span class="mg-menu"> Salir </span>
                  </a>
              
              </li>
            </ul>
          </li>
          
          <!-- Control Sidebar Toggle Button -->
          <!-- <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li> -->
        </ul>
      </div>
    </nav>
  </header>