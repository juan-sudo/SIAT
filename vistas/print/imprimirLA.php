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
$tipopredio=$_POST['tipopredio'];
$tipoprediohead=$_POST['tipopredio'];
$id_predio=$_POST['id_predio'];
$predio_select="si";
$propietarios = ModeloEstadoCuenta::mdlPropietarios_pdf($propietarios_);
$configuracion = ControladorConfiguracion::ctrConfiguracion();
$predio =ModeloImprimirFormato::mdlListarPredio_DJ($propietarios_,$anio,$id_predio,$tipopredio);
$condicion =ModeloImprimirFormato::mdlCondicion($id_predio);
$liquidacion_arbitrio =ModeloImprimirFormato::mdlLiquidacion($anio,$id_predio);
$cuotas =ModeloCalcular::mdlMostrar_cuotas_la('','formato',$anio,$id_predio,$propietarios_); 

if($tipopredio=='U'){
  $arancel =ModeloImprimirFormato::mdlArancel_Urbano($catastro,'urbano',$anio);
}else{
  $arancel =ModeloImprimirFormato::mdlArancel_Urbano($catastro,'rustico',$anio);
}

$determinacion =ModeloCalcular::mdlMostrar_calculo_impuesto($propietarios_,"condicion",$anio,$predio_select);
$estado_cuenta =ModeloEstadoCuenta::mdlEstadoCuenta_pdf($propietarios_,'null',"pdf",$anio,'006');
$estado__cuenta_total =ModeloEstadoCuenta::mdlEstadoCuenta_Total($propietarios_,$anio,'006');
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
                       <th colspan="2" style="font-size: 40px;background-color: #ABEBC6;" rowspan="3" border="0.1;" >LA</th>
                    </tr>
                    <tr>
                       <th colspan="6"><H2>ARBITRIOS MUNICIPALES</H2><br></th>
                    </tr>
                    <tr>
                    <th colspan="6"><br>ORDENANZA MUNICIPAL</th>
                    </tr>
                    <tr>
                    <th colspan="6">Nº 005-2017-MPLP/CM</th>
                    <th colspan="2">LIQUIDACIÓN ARBITRIOS</th>  
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
                    <th colspan="2" border="0.1" style="background-color: #ffd439; " border="0.1">&nbsp;Carpeta :'.$carpeta.'</th>  
                    </tr>
                    <tr>
                    <th colspan="4"></th>
                    <th colspan="1" style="font-size: 8px;">PREDIO</th>';
                   
                    if($tipoprediohead=='U'){
                      $html_head.='<th colspan="1" border="0.1" style="font-size: 10px;background-color: #ABEBC6;">URBANO</th>';
                    }
                    else{
                      $html_head.='<th colspan="1" border="0.1" style="font-size: 10px;background-color: #ABEBC6;">RUSTICO</th>';
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
                     <tr style="background-color:#ABEBC6;">
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
$html_propietario .='<th style=" border-bottom: 0.1px solid black;" width="150">'.$fila['nombre_completo']. '</th>';
$html_propietario .='<th style=" border-right: 0.1px solid black; border-bottom: 0.1px solid black;" width="300">'. $fila['direccion_completo'] . '</th>';
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
                     <tr style="background-color:#ABEBC6;">
                       <td border="0.1" width="460"><h4>Ubicación (Via,Nro,Int,Letra,Mz,Lote-Block-Zona/Centro Poblado)</h4></td>
                       <td border="0.1" width="80"><h4>Codigo de Predio</h4></td>
                     </tr>';
                       
$html_propietario .='<tr valign="center">';
$html_propietario .='<th  width="460" align="center" style="border-left: 1px solid black;">' . $predio['direccion_completo'].'</th>';
                  
$html_propietario .='<th  style=" border-right: 0.1px solid black;" width="80">'.$catastro.'</th>';
$html_propietario .='</tr></table>';
$pdf->writeHTML($html_propietario, true, false, false, false, '');
$pdf->Ln(0.5);
$html_propietario='<table style="border-bottom: 1px solid black;" align="center">
                     <tr style="background-color:#ABEBC6;">
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

//========LIQUIDACION DE ARBITRIOS ============
$pdf->SetFont('helvetica', '', 6.5); 
$pdf->Ln(1);
$pdf->SetX(5);          
$pdf->Cell(0, 2, 'III. LIQUIDACIÓN DE ARBITRIOS', 0, 1, 'L');
$pdf->Ln(1);
$html_propietario='<table style="border-bottom: 1px solid black;" align="center">
                     <tr style="background-color:#ABEBC6;">
                       <td border="0.1" width="110"><h4>Barrido de Calles</h4></td>
                       <td border="0.1" width="110"><h4>Recolección de Residuos Solidos</h4></td>
                       <td border="0.1" width="110"><h4>Parques y Jardines</h4></td>
                       <td border="0.1" width="110"><h4>Seguridad Ciudadana</h4></td>
                       <td border="0.1" width="100"><h4>Total por Predio</h4></td>
                     </tr>';
$html_propietario.='<tr style="background-color:#ABEBC6;">
                       <td border="0.1" width="40"><h4>%</h4></td>
                       <td border="0.1" width="70"><h4>Monto 1</h4></td>
                       <td border="0.1" width="40"><h4>%</h4></td>
                       <td border="0.1" width="70"><h4>Monto 2</h4></td>
                       <td border="0.1" width="40"><h4>%</h4></td>
                       <td border="0.1" width="70"><h4>Monto 3</h4></td>
                       <td border="0.1" width="40"><h4>%</h4></td>
                       <td border="0.1" width="70"><h4>Monto 4</h4></td>
                       <td border="0.1" width="100"><h4>Montos(1+2+3+4)</h4></td>
                     </tr>'; 
                     $html_propietario .='<tr>';
                     $total_liquidacion=0;                    
                     foreach ($liquidacion_arbitrio as $fila_a) {
                      if($fila_a['area']==0){
                        if($fila_a['id_arbitrio']==1 or  $fila_a['id_arbitrio']==4 ){
                          $total_liquidacion+=$fila_a['monto'];
                          $html_propietario .='<td style=" border-left: 0.1px solid black; border-bottom: 0.1px solid black;" width="40">'.number_format($fila_a['monto']).'</td>';
                          $html_propietario .='<th style=" border-bottom: 0.1px solid black;" width="70">'.number_format($fila_a['monto']).'</th>';
                        }
                        else{
                          $html_propietario .='<td style=" border-left: 0.1px solid black; border-bottom: 0.1px solid black;" width="40">0</td>';
                          $html_propietario .='<th style=" border-bottom: 0.1px solid black;" width="70">0.00</th>';
                        }
                      } 
                      else{
                        $total_liquidacion+=$fila_a['monto'];
                        $html_propietario .='<td style=" border-left: 0.1px solid black; border-bottom: 0.1px solid black;" width="40">'.number_format($fila_a['monto']).'</td>';
                        $html_propietario .='<th style=" border-bottom: 0.1px solid black;" width="70">'.number_format($fila_a['monto']).'</th>';
                      }
                      
                      }
                      $html_propietario .='<th style=" border-right: 0.1px solid black;border-left: 0.1px solid black;" width="100">'.$total_liquidacion.'</th>';                         
                      $html_propietario .='</tr>';
                    
$html_propietario .='</table>';
             $pdf->writeHTML($html_propietario, true, false, false, false, '');
             $pdf->Ln(1);
$html_propietario='<table align="center">
                     <tr>
                     <td border="0" width="110"></td>
                     <td border="0" width="110"></td>
                     <td border="0" width="110"></td>
                     <td border="0.1" width="110" style="background-color:#ABEBC6;"><h4>Importe Trimestral</h4></td>
                     <td border="0.1" width="100" style="background-color:#ABEBC6;"><h4>Importe Anual</h4></td>
                     </tr>
                     <tr>
                     <td border="0" width="110"></td>
                     <td border="0" width="110"></td>
                     <td border="0" width="110"></td>
                     <td style=" border-left: 0.1px solid black; border-bottom: 0.1px solid black;" width="110">'.($total_liquidacion*3).'</td>
                     <td style=" border-right: 0.1px solid black; border-bottom: 0.1px solid black;" width="100">'.($total_liquidacion*3*4).'</td>
                     </tr>
                     </table>';
            $pdf->writeHTML($html_propietario, true, false, false, false, '');       
// ======= FIN LIQUIDACION ARBITRIOS ======================
// ===MONTO A PAGAR =========================
$pdf->Ln(1);
$html_propietario='<table align="center">
                     <tr style="background-color:#ABEBC6;">
                     <td border="0.1" width="110"><h4>Cuota</h4></td>
                     <td border="0.1" width="110"><h4>Vencimiento</h4></td>
                     <td border="0.1" width="110"><h4>Monto Absoluto</h4></td>
                     <td border="0.1" width="110"><h4>Derecho Emisión</h4></td>
                     <td border="0.1" width="100"><h4>Total de Pagar</h4></td>
                     </tr>';
                     $total_pagar=0;
                     foreach ($cuotas as $fila_c) {
                     $total_pagar+=$fila_c['Total']; 
$html_propietario.='<tr>
                     <td style=" border-left: 0.1px solid black;" width="110">'.$fila_c['Periodo'].'</td>
                     <td width="110">'.$fila_c['Fecha_Vence'].'</td>
                     <td  width="110">'.$fila_c['Importe'].'</td>
                     <td  width="110">'.$fila_c['Gasto_Emision'].'</td>
                     <td style=" border-right: 0.1px solid black;" width="100">'.$fila_c['Total'].'</td>
                     </tr>';
                     }
$html_propietario.='<tr>
                     <td width="440" align="right" style="border-top: 0.1px solid black;"><h4>Total Anual &nbsp;</h4></td>
                     <td width="100" border="0.1"><h4>'.number_format($total_pagar,2).'</h4></td>
                     </tr>';
$html_propietario.='</table>';

            $pdf->writeHTML($html_propietario, true, false, false, false, '');       
// ======= FIN MONTO A PAGAR ======================

//=========SECTOR FIRMA=========  
$pdf->SetFont('helvetica', '', 6.5); 
$pdf->Ln(20);
$pdf->SetX(5);          
$pdf->Cell(0, 2, '', 0, 1, 'L');
$pdf->Ln(1);
$html_firma='<table align="center" ><tr>
                       <th  colspan="4">BASE LEGAL:(Nº 005-2017-MPLP/CM)<br><br>
                       Ordenanza que aprueba
                       el régimen tributario de los arbitrios
                       de barrido de calles, recolección
                       de residuos sólidos, parques y jardines
                       y seguridad ciudadana en el distrito
                       de Puquio, provincia de Lucanas
                       para el año 2017.
                       </th>
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