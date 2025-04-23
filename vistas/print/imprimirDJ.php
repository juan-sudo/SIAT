<?php
require_once("../../vendor/autoload.php");
require_once('./TCPDFmain/pdf/tcpdf_include.php');
use Conect\Conexion;
use Controladores\ControladorPredio;
use Controladores\ControladorEstadoCuenta;
use Controladores\ControladorConfiguracion;
use Modelos\ModeloContribuyente;
use Modelos\ModeloEstadoCuenta;
use Modelos\ModeloImprimirFormato;
use Modelos\ModeloCalcular;


class MYPDF extends TCPDF {

    //Page header
    // Page footer
    public function Footer() {
        $configuracion = ControladorConfiguracion::ctrConfiguracion();
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->SetX(-5); // Ajusta el valor para mover el número de página a la derecha
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, 0, 'C');
        // Para agregar contenido en el centro
        $this->SetX(10); // Ajusta el valor para centrar tu contenido en el medio de la página
        $this->Cell(0, 10,$configuracion['Nombre_Empresa'] , 0, 0, 'C');
    }
}
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->setPrintHeader(false);
$pdf->AddPage('P','A4');
// Establecer la información del PDF

$carpeta=$_POST['carpeta'];
$propietarios_=$_POST['propietarios']; //Viene un array pero se convierte en un string ('36,37') -> convertir en un array en el servidor
$anio=$_POST['anio'];
$catastro=$_POST['catastro'];
$id_predio=$_POST['id_predio'];
$tipopredio=$_POST['tipopredio'];
$tipoprediohead=$_POST['tipopredio'];
$id_predio=$_POST['id_predio'];
$propietarios = ModeloEstadoCuenta::mdlPropietarios_pdf($propietarios_);
$configuracion = ControladorConfiguracion::ctrConfiguracion();
$predio =ModeloImprimirFormato::mdlListarPredio_DJ($propietarios_,$anio,$id_predio,$tipopredio);
$pisos =ModeloImprimirFormato::mdlListarPisos_dj($id_predio);
$colindantes =ModeloImprimirFormato::mdlColindantes($id_predio);
$condicion =ModeloImprimirFormato::mdlCondicion($id_predio);

if($tipopredio=='U'){
  $arancel =ModeloImprimirFormato::mdlArancel_Urbano($catastro,'urbano',$anio);
}else{
  $arancel =ModeloImprimirFormato::mdlArancel_Urbano($catastro,'rustico',$anio);
}
// Inicio de la tabla HTML
$pdf->SetCreator($configuracion['Nombre_Empresa']);
$pdf->SetAuthor('GRUPO HANCCO');
$pdf->SetTitle('HR');

$fechaActual = date('d/m/Y');
$numeroPagina = $pdf->PageNo();
$pdf->SetFont('helvetica', '', 8);
$pdf->Image('logo.jpg', 15, 6, 32, 40, 'JPG', 'https://perudigitales.com/', '', true, 150, '', false, false, 0, false, false, false);
$html_head='<table align="center"><tr>
                       <th colspan="2" rowspan="4"></th>
                       <th colspan="6"><h2>'.$configuracion['Nombre_Empresa'].'</h2></th>
                       <th colspan="2" style="font-size: 40px;background-color: #d4e6f1;" rowspan="3" border="0.1;" >DJ</th>
                    </tr>
                    <tr>
                       <th colspan="6"><H2>IMPUESTO PREDIAL</H2></th>
                    </tr>
                    <tr>
                    <th colspan="6">T.U.O LEY DE TRIBUTACION MUNICIPAL</th>
                    </tr>
                    <tr>
                    <th colspan="6">D.S 158-2004-EF</th>
                    <th colspan="2">DECLARACIÓN JURADA</th>  
                    </tr>
                    <tr>
                    <th colspan="2"></th>
                    <th colspan="6"><h2>AÑO '.$anio.'</h2></th>
                    <th colspan="2" style="font-size:7px;">FECHA DE EMISION</th>  
                    </tr>
                    <tr>
                    <th colspan="8"></th>
                    <th colspan="2" border="0.1">'.$fechaActual.'</th>  
                    </tr>
                    <tr>
                    <th colspan="8"></th>
                    <th colspan="2" border="0.1" style="background-color: #ffd439; " border="0.1">&nbsp;Carpeta : '.$carpeta.'</th>  
                    </tr>
                    <tr>
                    <th colspan="4"></th>
                    <th colspan="1" style="font-size: 8px;">PREDIO</th>';
                   
                    if($tipoprediohead=='U'){
                      $html_head.='<th colspan="1" border="0.1" style="font-size: 10px;background-color: #d4e6f1;">URBANO</th>';
                    }
                    else{
                      $html_head.='<th colspan="1" border="0.1" style="font-size: 10px;background-color: #d4e6f1;">RUSTICO</th>';
                    } 
                    $html_head.='<th colspan="4"></th>
                    
                    </tr>
             </table>';
$pdf->writeHTML($html_head);
$pdf->Ln(0);
$pdf->SetX(5); 
$pdf->SetFont('helvetica', '', 6.5);  // Establecer el tamaño de letra a 8
$pdf->Cell(0, 2, 'I. PROPIETARIO(S)', 0, 1, 'L');
$pdf->Ln(1);
$pdf->SetFont('helvetica', '', 6.5);
$html_propietario='<table align="center" >
                     <tr style="background-color:#d4e6f1;">
                       <td border="0.1" width="40"><h4>Codigo</h4></td>
                       <td border="0.1" width="50"><h4>Dni</h4></td>
                       <td border="0.1" width="150"><h4>Propietario(s)</h4></td>
                       <td border="0.1" width="300"><h4>Direccion Fiscal</h4></td>
                     </tr>';
                     foreach ($propietarios as $valor => $filas) {
                        foreach ($filas as $fila) {
$html_propietario .='<tr>';
$html_propietario .='<td style=" border-left: 0.1px solid black; border-bottom: 0.1px solid black;" width="40">'.$fila['id_contribuyente'].'</td>';
$html_propietario .='<th style=" border-bottom: 0.1px solid black;" width="50">'.$fila['documento'].'</th>';
$html_propietario .='<th style=" border-bottom: 0.1px solid black;" width="150">'.$fila['nombre_completo'] . '</th>';
$html_propietario .='<th style=" border-right: 0.1px solid black; border-bottom: 0.1px solid black;" width="300">'. $fila['direccion_completo'] .'</th>';
$html_propietario .='</tr>';
                    }
                }
$html_propietario .='</table>';
             $pdf->writeHTML($html_propietario, true, false, false, false, '');


//=========SECTOR DATOS DEL PREDIO=========  
$pdf->SetFont('helvetica', '', 6.5); 
$pdf->Ln(1);
$pdf->SetX(5);          
$pdf->Cell(0, 2, 'II. DATOS DEL PREDIO', 0, 1, 'L');
$pdf->Ln(1);

$html_propietario='
                     <table style="border-bottom: 1px solid black;" align="center">
                     <tr style="background-color:#d4e6f1;">
                       <td border="0.1" width="460"><h4>Ubicación (Via,Nro,Int,Letra,Mz,Lote-Block-Zona/Centro Poblado)</h4></td>
                       <td border="0.1" width="80"><h4>Codigo de Predio</h4></td>
                     </tr>';
                       
$html_propietario .='<tr valign="center">';
                  
$html_propietario .='<th  width="460" align="center"  style="border-left: 1px solid black;">' . $predio['direccion_completo'] . '</th>';

                    
$html_propietario .='<th  style=" border-right: 0.1px solid black;" width="80">'.$catastro.'</th>';
$html_propietario .='</tr></table>';
$pdf->writeHTML($html_propietario, true, false, false, false, '');
$pdf->Ln(0.5);
$html_propietario='<table style="border-bottom: 1px solid black;" align="center">
                     <tr style="background-color:#d4e6f1;">
                       <td border="0.1" width="80"><h4>Estado</h4></td>
                       <td border="0.1" width="110"><h4>Tipo Propiedad/Posesión</h4></td>
                       <td border="0.1" width="90"><h4>Uso del Predio</h4></td>
                       <td border="0.1" width="100"><h4>Cóndicion de Propiedad</h4></td>
                       <td border="0.1" width="80"><h4>% Prop./Posesión</h4></td>
                       <td border="0.1" width="80"><h4>Inafec / Exoner</h4></td>
                     </tr>';
                       
$html_propietario .='<tr valign="center">';
$html_propietario .='<td style=" border-left: 0.1px solid black; vertical-align: middle;" width="80" height="10">'.$condicion['estado'].'</td>';
$html_propietario .='<th  width="110">'.$condicion['tipo'].'</th>';
$html_propietario .='<th  width="90">'.$condicion['uso'].'</th>';
$html_propietario .='<th  width="100">'.$condicion['condicion'].'</th>';
$html_propietario .='<th  width="80">100.00</th>';
$html_propietario .='<th  style=" border-right: 0.1px solid black;" width="80">'.$condicion['regimen'].'</th>';
$html_propietario .='</tr>';
                    
                
$html_propietario .='</table>';
             $pdf->writeHTML($html_propietario, true, false, false, false, '');

//========FIN DEL SECTOR DE PREDIO ============

//=========SECTOR DATOS DEL TERRENO RUSTICO=========  
$pdf->SetFont('helvetica', '', 6.5); 
$pdf->Ln(1);
$pdf->SetX(5);          
$pdf->Cell(0, 2, 'III. DATOS DEL TERRENO (solo predios rústico)', 0, 1, 'L');
$pdf->Ln(1);
$html_propietario=' <table style="border-bottom: 1px solid black;" align="center">
                     <tr style="background-color: #d4e6f1;">
                       <td border="0.1" width="80"><h4>Tipo</h4></td>
                       <td border="0.1" width="80"><h4>Uso</h4></td>
                       <td width="25" style=" border-left: 0.1px solid black;border-top: 0.1px solid black;border-bottom: 0.1px solid black;"><h4></h4></td>
                       <td style=" border-top: 0.1px solid black;border-bottom: 0.1px solid black;" width="177.5"><h4>Propietarios Colindantes</h4></td>
                       <td border="0.1" width="177.5"><h4>Predios Colindantes</h4></td>
                     </tr>';
                       
$html_propietario .='<tr valign="center">';
$html_propietario .='<td style=" border-left: 0.1px solid black;border-bottom: 0.1px solid black; vertical-align: middle;" width="80">';
                  if($tipopredio=='R'){
                    $html_propietario .=$predio['tipo_terreno'].'</td>';
                  }else{
                    $html_propietario .='</td>';
                  }
                   
$html_propietario .='<th style=" border-bottom: 0.1px solid black;" width="80">';
                if($tipopredio=='R'){
                  $html_propietario .=$predio['uso_terreno'].'</th>';
                }else{
                  $html_propietario .='</th>';
                }
$html_propietario .='<th  width="25" style="background-color: #d4e6f1;border-left: 0.1px solid black;border-right: 0.1px solid black;">Norte</th>';
$html_propietario .='<th  width="177.5">';
                    if($tipopredio=='R'){
                      $html_propietario .=$predio['colindante_norte_nombre'].'</th>';
                    }else{
                      $html_propietario .='</th>';
                    }
$html_propietario .='<th  style=" border-right: 0.1px solid black;" width="177.5">';
                    if($tipopredio=='R'){
                      $html_propietario .=$predio['colindante_norte_denominacion'].'</th>';
                    }else{
                      $html_propietario .='</th>';
                    }
$html_propietario .='</tr>';

$html_propietario.='<tr>
                       <td width="80"><h4></h4></td>
                       <td width="80"><h4></h4></td>
                       <td style="background-color: #d4e6f1;" border="0.1" width="25">Sur</td>
                       <td width="177.5">';
                       if($tipopredio=='R'){
                        $html_propietario .=$predio['colindante_sur_nombre'].'</td>';
                      }else{
                        $html_propietario .='</td>';
                      }
$html_propietario .='<td  style=" border-right: 0.1px solid black;" width="177.5">';
                      if($tipopredio=='R'){
                        $html_propietario .=$predio['colindante_sur_denominacion'].'</td>';
                      }else{
                        $html_propietario .='</td>';
                      }
$html_propietario .='</tr>';

$html_propietario.='  <tr>
                       <td style="background-color: #d4e6f1;" border="0.1" width="105"><h4>Clasificación</h4></td>
                       <td style="background-color: #d4e6f1;" border="0.1" width="55"><h4>Categoria</h4></td>
                       <td style="background-color: #d4e6f1;" border="0.1" width="25">Este</td>
                       <td width="177.5">';
                       if($tipopredio=='R'){
                        $html_propietario .=$predio['colindante_este_nombre'].'</td>';
                      }else{
                        $html_propietario .='</td>';
                      }
$html_propietario.='<td  style=" border-right: 0.1px solid black;" width="177.5">';
                    if($tipopredio=='R'){
                      $html_propietario .=$predio['colindante_este_denominacion'].'</td>';
                    }else{
                      $html_propietario .='</td>';
                    }
$html_propietario.= '</tr>';
                    
$html_propietario .='<tr valign="center">';
$html_propietario .='<td style=" border-left: 0.1px solid black; vertical-align: middle;" width="105" height="10">';
                if($tipopredio=='R'){
                  $html_propietario .=$predio['nombre_tierra'].'</td>';
                }else{
                  $html_propietario .='</td>';
                }
$html_propietario .='<th  width="55">';
                        if($tipopredio=='R'){
                          $html_propietario .=$predio['categoria_calidad'].'</th>';
                        }else{
                          $html_propietario .='</th>';
                        }
$html_propietario .='<th  width="25" style="background-color: #d4e6f1;border-left: 0.1px solid black;border-right: 0.1px solid black;">Oeste</th>';
$html_propietario .='<th  width="177.5">';
                        if($tipopredio=='R'){
                          $html_propietario .=$predio['colindante_oeste_nombre'].'</th>';
                        }else{
                          $html_propietario .='</th>';
                        }
$html_propietario .='<th  style=" border-right: 0.1px solid black;" width="177.5">';
                        if($tipopredio=='R'){
                          $html_propietario .=$predio['colindante_oeste_denominacion'].'</th>';
                        }else{
                          $html_propietario .='</th>';
                        }
$html_propietario .='</tr>';                
$html_propietario .='</table>';
$pdf->writeHTML($html_propietario, true, false, false, false, '');
//FIN DEL SECTOR DE TRRENO RUSTICO

$conx=$pdf->GetX();
$cony=$pdf->GetY();
// Establecer las coordenadas x, y manualmente para 'Nivel'
$x=$pdf->GetX()+1;
$y=$pdf->GetY()+16;
//$x = 11; // ajusta según tus necesidades
//$y = 135; // ajusta según tus necesidades
$pdf->SetXY($x, $y);
$texto_vertical = 'Nivel';
$x_antes_rotacion = $pdf->GetX();
$y_antes_rotacion = $pdf->GetY();
if ($texto_vertical == 'Nivel') {
    $pdf->StartTransform();
    $pdf->Rotate(90, $x_antes_rotacion, $y_antes_rotacion);
}
$pdf->Text($x_antes_rotacion, $y_antes_rotacion, $texto_vertical);
if ($texto_vertical == 'Nivel') {
    $pdf->StopTransform();
}

// Establecer las coordenadas x, y manualmente para 'clasificacion'

$pdf->SetXY($x+5.5, $y+4);
$texto_vertical = 'Clasificación';
$x_antes_rotacion = $pdf->GetX();
$y_antes_rotacion = $pdf->GetY();
if ($texto_vertical == 'Clasificación') {
    $pdf->StartTransform();
    $pdf->Rotate(90, $x_antes_rotacion, $y_antes_rotacion);
}
$pdf->Text($x_antes_rotacion, $y_antes_rotacion, $texto_vertical);
if ($texto_vertical == 'Clasificación') {
    $pdf->StopTransform();
}
// Establecer las coordenadas x, y manualmente para 'Material'
$pdf->SetXY($x+11, $y+2.5);
$texto_vertical = 'Material';
$x_antes_rotacion = $pdf->GetX();
$y_antes_rotacion = $pdf->GetY();
if ($texto_vertical == 'Material') {
    $pdf->StartTransform();
    $pdf->Rotate(90, $x_antes_rotacion, $y_antes_rotacion);
}
$pdf->Text($x_antes_rotacion, $y_antes_rotacion, $texto_vertical);
if ($texto_vertical == 'Material') {
    $pdf->StopTransform();
}
// Establecer las coordenadas x, y manualmente para 'Conservacion'

$pdf->SetXY($x+16.5, $y+5.3);
$texto_vertical = 'Conservación';
$x_antes_rotacion = $pdf->GetX();
$y_antes_rotacion = $pdf->GetY();
if ($texto_vertical == 'Conservación') {
    $pdf->StartTransform();
    $pdf->Rotate(90, $x_antes_rotacion, $y_antes_rotacion);
}
$pdf->Text($x_antes_rotacion, $y_antes_rotacion, $texto_vertical);
if ($texto_vertical == 'Conservación') {
    $pdf->StopTransform();
}
// Establecer las coordenadas x, y manualmente para 'antiguedad'
$pdf->SetXY($x+21.3, $y+4);
$texto_vertical = 'Antiguedad';
$x_antes_rotacion = $pdf->GetX();
$y_antes_rotacion = $pdf->GetY();
if ($texto_vertical == 'Antiguedad') {
    $pdf->StartTransform();
    $pdf->Rotate(90, $x_antes_rotacion, $y_antes_rotacion);
}
$pdf->Text($x_antes_rotacion, $y_antes_rotacion, $texto_vertical);
if ($texto_vertical == 'Antiguedad') {
    $pdf->StopTransform();
}
$pdf->SetXY($conx, $cony);
//=========SECTOR DETERMINACION DE AUTOVALUO PISOS=========  
$pdf->SetFont('helvetica', '', 6.5); 
// Generar el PDF
$pdf->SetX(5);
$pdf->Cell(20, 5, 'IV. DETERMINACION DE AUTOVALUO', 0, 1, 'L');   
$html_propietario='<table style=""align="center">
                     <tr style="background-color: #d4e6f1;">
                       <th border="0.1" width="15" rowspan="4"><h4></h4></th>
                       <td border="0.1" width="15" rowspan="4"><h4></h4></td>
                       <td border="0.1" width="15" rowspan="4"><h4></h4></td>
                       <td border="0.1" width="15" rowspan="4"><h4></h4></td>
                       <td border="0.1" width="15" rowspan="4"><h4></h4></td>
                       <td border="0.1" width="55" rowspan="4"><h4><br><br>Categorias</h4></td>
                       <td border="0.1" width="50" rowspan="4"><h4><br><br>Valor <br>Unitario M2</h4></td>
                       <td border="0.1" width="50" rowspan="4"><h4><br><br>Incremto<br>5%</h4></td>
                       <td border="0.1" width="60" colspan="2"><h4><br>Depreciación</h4></td>
                       <td border="0.1" width="60" rowspan="4"><h4><br><br>Valor Unitario<br> Depreciafdo M2</h4></td>
                       <td border="0.1" width="70" colspan="2"><h4><br>Area Construida</h4></td>
                       <td border="0.1" width="60" colspan="2"><h4><br>Area Común</h4></td>
                       <td border="0.1" width="60" style="vertical-align: bottom;" rowspan="4"><h4><br><br>Valor de la construcción</h4></td>
                     </tr>'; 
$html_propietario.='<tr style="background-color: #d4e6f1;">               
                       <td border="0.1" width="20" rowspan="3"><h4><br>%</h4></td>
                       <td border="0.1" width="40" rowspan="3"><h4><br>Monto</h4></td>
                       <td border="0.1" width="35" rowspan="3"><h4><br>M2</h4></td>
                       <td border="0.1" width="35" rowspan="3"><h4><br>Valor</h4></td>
                       <td border="0.1" width="30" rowspan="3"><h4><br>M2</h4></td>
                       <td border="0.1" width="30" rowspan="3"><h4><br>Valor</h4></td>                       
                     </tr>'; 
$html_propietario.='<tr style="background-color: #ffffee;">       
                     <td border="0" width="0" style="vertical-align: bottom;"></td>
                     </tr>';
$html_propietario.='<tr style="background-color: #ffffee;">           
                     <td border="0" width="0" style="vertical-align: bottom;"></td>
                     </tr>'; 

                     $areas_comunes=0;
                    $total_pisos=0;
                     foreach ($pisos as $fila_p) { 
                      $total_pisos +=1;
                      $areas_comunes +=$fila_p['Areas_Comunes'];
                      $html_propietario .='<tr><td style=" border-left: 0.1px solid black; border-right: 0.1px solid black;" colspan="16"></td></tr>';
                      $html_propietario .='<tr valign="center" height="110">';
                      $html_propietario .='<td style=" border-left: 0.1px solid black; vertical-align: middle;">'.$fila_p['Numero_Piso'].'</td>';
                      $html_propietario .='<th width="15">'.$fila_p['Id_Clasificacion_Piso'].'</th>';
                      $html_propietario .='<th width="15" >'. $fila_p['Id_Material_Piso'].'</th>';
                      $html_propietario .='<th width="15" >'. $fila_p['Id_Estado_Conservacion'].'</th>';
                      $html_propietario .='<th width="15" >'. $fila_p['Cantidad_Anios'].'</th>';
                      $html_propietario .='<th width="55" >'. $fila_p['Categorias_Edificacion'].'</th>';
                      $html_propietario .='<th width="50" >'. $fila_p['Valores_Unitarios'].'</th>';
                      $html_propietario .='<th width="50" >'. $fila_p['Incremento'].'</th>';
                      $html_propietario .='<th width="20" >'. $fila_p['Porcentaje_Depreciacion'].'</th>';
                      $html_propietario .='<th width="40" >'. round(($fila_p['Valores_Unitarios']*($fila_p['Porcentaje_Depreciacion']/100)),2).'</th>';
                      $html_propietario .='<th width="60" >'. $fila_p['Valor_Unitario_Depreciado'].'</th>';
                      $html_propietario .='<th width="35" >'. $fila_p['Area_Construida'].'</th>';
                      $html_propietario .='<th width="35" >'. $fila_p['Valor_Construida'].'</th>';
                      $html_propietario .='<th width="30" >'. $fila_p['Areas_Comunes'].'</th>';
                      $html_propietario .='<th width="30" >'. $fila_p['Valor_Areas_Comunes'].'</th>';
                      $html_propietario .='<th width="60" style="border-right: 0.1px solid black;" >'. $fila_p['Valor_Construida'].'</th>';
                      $html_propietario .='</tr>';                         
                                      }
                                      
                                      $hasta=10-$total_pisos;
                                      for ($i = 1; $i <= $hasta; $i++) {
                                        $html_propietario .='<tr><th  style="  border-left: 0.1px solid black; border-right: 0.1px solid black;" width="540"></th></tr>';
                                      } 
                                      
                      $html_propietario.='<tr>
                      <td border="0" width="40" style="vertical-align: bottom;border-top: 0.1px solid black;"></td>
                      <td border="0" width="20" style="vertical-align:Top-Center;font-size: 23px;border-top: 0.1px solid black;" rowspan="4">(</td>
                      <td border="0" width="80" style="vertical-align: bottom;border-top: 0.1px solid black;" ></td>
                      <td border="0" width="20" style="vertical-align: bottom;border-top: 0.1px solid black;"></td>
                      <td border="0" width="80" style="vertical-align: bottom;border-top: 0.1px solid black;"></td>
                      <td border="0" width="20" style="vertical-align:Top-Center;font-size: 23px;border-top: 0.1px solid black;" rowspan="4">)</td>
                      <td border="0" width="20" style="vertical-align: bottom;border-top: 0.1px solid black;"></td>
                      <td border="0" width="80" style="vertical-align: bottom;border-top: 0.1px solid black;"></td>
                      <td border="0" width="20" style="vertical-align: bottom;border-top: 0.1px solid black;"></td>
                      <td border="0" width="100" style="margin right; bottom;border-top: 0.1px solid black;" align="right">Total Autovaluo &nbsp;</td>
                      <td border="0" width="60" style="vertical-align: bottom; border-left: 0.1px solid black;border-right: 0.1px solid black;border-top: 0.1px solid black;">'.$predio['valor_construccion'].'</td>
                      </tr>';
                    $html_propietario.='<tr>
                     <td border="0" width="60" style="vertical-align: bottom;"  ></td>           
                     <td border="0" width="80" style="vertical-align: bottom;background-color: #d4e6f1;" border="0.1">Area Terreno</td>
                     <td border="0" width="20" style="vertical-align: bottom; font-size: 10px;"  rowspan="2"><br>+</td>
                     <td border="0" width="80" style="vertical-align: bottom;background-color: #d4e6f1;" border="0.1">Area Comun Terreno</td>
                     <td border="0" width="20" style="vertical-align: bottom; font-size: 10px;"  rowspan="2">x</td>
                     <td width="80" style="vertical-align: bottom;background-color: #d4e6f1;" border="0.1">Arancel</td>
                     <td border="0" width="20" style="vertical-align: bottom;font-size: 10px;"  rowspan="2"><br>=</td>
                     <td border="0" width="100" style="vertical-align: bottom;" align="right">Valor de otras instalaciones &nbsp;</td>
                     <td border="0" width="60" style="vertical-align: bottom; border-left: 0.1px solid black;border-right: 0.1px solid black;">0.00</td>
                    </tr>'; 
                    $html_propietario.='<tr>
                     <td border="0" width="60" style="vertical-align: bottom;" ></td>           
                     <td border="0" width="80" style="vertical-align: bottom;" border="0.1">'.$predio['a_terreno'];
                     if($tipopredio=='U'){
                     }
                     else{
                      $html_propietario.=' Ha';
                     }
                     $html_propietario.='</td>
                     <td border="0" width="80" style="vertical-align: bottom;" border="0.1">'.$areas_comunes.'.00</td>';
                    
                    $html_propietario.='<td border="0" width="80" style="vertical-align: bottom;" border="0.1">'.$arancel['arancel'].'</td>';
                    

                     $html_propietario.='<td border="0" width="100" style="vertical-align: bottom;" align="right">Valor total del Terrano &nbsp;</td>
                     <td border="0" width="60" style="vertical-align: bottom; border-left: 0.1px solid black;border-right: 0.1px solid black;">'.$predio['valor_terreno'].'</td>
                    </tr>';
                    $html_propietario.='<tr>
                     <td border="0" width="60" style="vertical-align: bottom;"></td>           
                     <td border="0" width="80" style="vertical-align: bottom;"></td>
                     <td border="0" width="20" style="vertical-align: bottom;"></td>
                     <td border="0" width="80" style="vertical-align: bottom;"></td>
                     <td border="0" width="20" style="vertical-align: bottom;"></td>
                     <td border="0" width="80" style="vertical-align: bottom;"></td>
                     <td border="0" width="20" style="vertical-align: bottom;"></td>
                     <td border="0" width="100" style="vertical-align: bottom;" align="right"><b>Total Autovaluo &nbsp;</b></td>
                     <td border="0" width="60" style="vertical-align: bottom;border-bottom: 0.1px solid black; border-left: 0.1px solid black;border-right: 0.1px solid black;"><b>'.$predio['valor_predio'].'</b></td>
                    </tr>';                                       
                                     
$html_propietario .='</table>';

             $pdf->writeHTML($html_propietario, true, false, false, false, '');

//========FIN DE MONTOS A PAGAR FRACIONADO ============

//=========SECTOR FIRMA=========  
$pdf->SetFont('helvetica', '', 6.5); 
$pdf->Ln(1);
$pdf->SetX(5);          
$pdf->Cell(0, 2, '', 0, 1, 'L');
$pdf->Ln(1);
$html_firma='<table align="center" ><tr>
                       <th  colspan="4">BASE IMPONIBLE:(Art.11° D.S N° 156-2004-EF)<br><br>
                       La base imponible para la determinacion del impuesto predial, esta constituido por el valor total de los predios del contribuyente ubicados en cada jurisdiccion</th>
                       <th border="0.1" colspan="4"><br>DECLARO QUE LOS DATOS CONSIGNADOS EN LA PRESENTE DECLARACION SON VERDADERO<br><br><br><br><br>
                       ....................................................................................<br>
                       Firma del Contribuyente o Representante Legal<br>
                       N° Dni:<br><br>
                       Fecha:'.$fechaActual.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Distrito:'.$configuracion['Lugar'].'</th>
                    </tr> 
             </table>';
             $pdf->writeHTML($html_firma, true, false, false, false, '');
//========FIN DEL SECTOR FIRMA ============

// Generar el PDF en memoria
$pdfData = $pdf->Output('', 'S'); // 'S' para obtener los datos en una variable
// Ruta donde guardar el PDF (ajusta la ruta según tu proyecto)
$rutaPDF = 'HR_pdf/Hr_'.uniqid().'.pdf';
// Guardar el PDF en la ruta especificada
file_put_contents($rutaPDF, $pdfData);
// Devolver la ruta del PDF guardado
echo $rutaPDF;