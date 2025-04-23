<?php 
  use Controladores\ControladorConfiguracion;
  $configuracion = ControladorConfiguracion::ctrConfiguracion();
  
  ?><footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version </b><?php echo $configuracion['Version'];?>
    </div>
    <strong>Copyright &copy; <?php echo date('Y'); ?> <a class="enlace_footer" href="https://munipuquio.gob.pe/"><?php echo $configuracion['Nombre_Empresa'];?></a>.</strong> - 
    <span><?php echo $configuracion['Nombre_Sistema'] ?></span>
  </footer>