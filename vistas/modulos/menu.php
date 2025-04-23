<?php
use Controladores\ControladorUsuarios;
?>
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class=" user-panel2">
      <!-- <div class=" image">
          <?php
         //mostrando el menu de acuerdo a la base de datos
        $subpaginas_permisos =ControladorUsuarios::CntrMostrar_menu($_SESSION['id']);
       // $subpaginas_permisos=ControladorUsuarios::CntrMostrar_submenu($_SESSION['id']);
          ?>
        </div> -->
     
    </div>
 
    <?php
    echo '<ul class="sidebar-menu" data-widget="tree">';

   
    $paginas_subpaginas = array();

    // Organizar las páginas y subpáginas en el arreglo
    foreach ($subpaginas_permisos as $item) {
        $id_pagina = $item['id_pagina'];
        if (!isset($paginas_subpaginas[$id_pagina])) {
            // Si la página no existe en el arreglo, la agrega
            $paginas_subpaginas[$id_pagina] = array(
                'nombre_pagina' => $item['nombre_pagina'],
                'ruta_pagina' => $item['ruta_pagina'],
                'subpaginas' => array()
            );
        }
    
        // Agrega la subpágina a la página correspondiente
        $paginas_subpaginas[$id_pagina]['subpaginas'][] = array(
            'nombre_subpagina' => $item['nombre_subpagina'],
            'ruta_subpagina' => $item['ruta_subpagina']
        );
    }
    
    // Itera sobre el arreglo para mostrar las páginas y subpáginas en el menú
    foreach ($paginas_subpaginas as $pagina) {
        echo "<li class='treeview'>
               <a href='{$pagina['ruta_pagina']}'>     
                 <img src='./vistas/img/iconos/carpeta1.png'  class='t-icon-menu'>
                     <span class='mg-menu'>{$pagina['nombre_pagina']}</span> 
                       <span class='pull-right-container'>
        <i class='fa fa-angle-left pull-right'></i>
      </span></a>";
        
        // Muestra las subpáginas si existen
        if (!empty($pagina['subpaginas'])) {
            echo '<ul class="treeview-menu">';
            foreach ($pagina['subpaginas'] as $subpagina) {
                echo "<li><a href='{$subpagina['ruta_subpagina']}'>
                <img src='./vistas/img/iconos/carpeta1.png'  class='t-icon-menu'>{$subpagina['nombre_subpagina']}</a></li>";
            }
            echo '</ul>';
        }
        echo '</li>';
    }
    // Cierre del menú
    echo '</ul>';
?>
  
  <!-- /.sidebar -->
</aside>