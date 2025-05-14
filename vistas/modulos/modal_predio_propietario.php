<?php

use Controladores\ControladorPredio;
?>
<div class="modal fade" id="modal_predio_propietario"  tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" > 
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content modal-content-e">
      <div class="modal-body">
     
          <div class="col-mod-12">
                <span class="caption_">Propietario - Predio m</span>
                <div class="row pull-right">
                <select class="busqueda_filtros_anio" id="anio_propietario" name="anio_propietario">
                                        <?php
                                        $anio = ControladorPredio::ctrMostrarDataAnio();
                                        foreach ($anio as $data_anio) {
                                          echo "<option value='" . $data_anio['Id_Anio'] . "'>" . $data_anio['NomAnio'] . '</option>';
                                        }
                                        ?>
                </select>
                </div>
          </div>
     <br>
      <table class="table-container">
        <thead>
          <th class="text-center">N°</th>
          <th class="text-center">Propietarios</th>
          <th class="text-center">Carpeta</th>
          <th class="text-center">Predios</th>
          <th class="text-center">Deuda</th>
        </thead>
        <tbody class="m_predio_propietario">
        </tbody>
      </table>
      </div>
     
    </div>
  </div>
</div>