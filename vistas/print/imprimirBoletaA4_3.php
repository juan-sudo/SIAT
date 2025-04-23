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
use Modelos\ModeloCaja;


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


$propietario_convert=$_POST['propietarios'];
$propietario_convert_2= explode('-', $propietario_convert);
$propietarios_ = implode(',', $propietario_convert_2); //Viene un array pero se convierte en un string ('36,37') -> convertir en un array en el servidor
$id_cuenta=$_POST['id_cuenta'];
$propietarios = ModeloEstadoCuenta::mdlPropietarios_pdf($propietarios_);
$configuracion = ControladorConfiguracion::ctrConfiguracion();
$cuenta = ModeloCaja::ctrCuenta_caja_pdf($id_cuenta);
// Inicio de la tabla HTML
$pdf->SetCreator($configuracion['Nombre_Empresa']);
$pdf->SetAuthor('GRUPO HANCCO');
$pdf->SetTitle('HR');

$fechaActual = date("Y-m-d H:i:s");
$numeroPagina = $pdf->PageNo();
$pdf->SetFont('helvetica', '', 8);
$pdf->Image('logo.jpg', 10, 4, 30, 35, 'JPG', 'https://perudigitales.com/', '', true, 150, '', false, false, 0, false, false, false);
$html_head='<br><table align="center" >
                       <tr>
                       <th colspan="2" rowspan="5"></th>
                       <th colspan="4"><h5>'.$configuracion['Nombre_Empresa'].'</h5></th>
                       <th style=" border-left: 0.1px solid black; border-right: 0.1px solid black; border-top: 0.1px solid black;" colspan="3" rowspan="2"><H2>RUC:'.$configuracion['RUC_empresa'].'</H2></th>
                    </tr>
                    <tr>
                       <th colspan="4">'.$configuracion['Direccion'].'</th>
                      
                    </tr>
                    <tr>
                    <th colspan="4">'.$configuracion['Telefono_uno'].'/'.$configuracion['Telefono_dos'].'</th>
                    <th colspan="3" rowspan="2" style="background-color: #a3e4d7; border-left: 0.1px solid black; border-right: 0.1px solid black;"><H3>BOLETA DE PAGO</H3></th>  
                    </tr>
                    <tr>
                    <th colspan="4">'.$configuracion['Correo'].'</th>
                    
                    </tr>
                    <tr>
                    <th colspan="4">'.$configuracion['Pagina'].'</th>
                    <th colspan="3" rowspan="2" style=" border-left: 0.1px solid black; border-right: 0.1px solid black; border-bottom: 0.1px solid black;"><h3>N° - '.$configuracion['Numero_Recibo'].'</h3></th>    
                    </tr>
             </table>';
$pdf->writeHTML($html_head); 
$pdf->Ln(10);
$pdf->SetFont('helvetica', '', 6.5);
$pdf->SetX(25);
$html_propietario='<table align="center" style=" border-bottom: 0.1px solid black; border-left: 0.1px solid black;
                    border-right: 0.1px solid black; border-top: 0.1px solid black;" >
                     <tr style="background-color: #a3e4d7;">
                       <td width="40"><h4>Codigo</h4></td>
                       <td width="50"><h4>Dni</h4></td>
                       <td width="200"><h4>Propietario(s)</h4></td>
                     </tr>';
                     foreach ($propietarios as $valor => $filas) {
                        foreach ($filas as $fila) {
$html_propietario .='<tr>';
$html_propietario .='<td width="40">'.$fila['id_contribuyente'].'</td>';
$html_propietario .='<th width="50">'.$fila['documento'].'</th>';
$html_propietario .='<th width="200">'.$fila['nombre_completo'].'</th>';
$html_propietario .='</tr>';
                    }
                }
$html_propietario .='</table>';
             $pdf->writeHTML($html_propietario, true, false, false, false, '');

$conx=$pdf->GetX()+15;
$cony=$pdf->GetY();
// Establecer las coordenadas x, y manualmente para 'Nivel'
$x=$pdf->GetX()+120;
$y=$pdf->GetY()-11.5;
//$x = 11; // ajusta según tus necesidades
//$y = 135; // ajusta según tus necesidades
$pdf->SetXY($x, $y);
             $html_propietario='<table align="center" style=" border-bottom: 0.1px solid black; border-top: 0.1px solid black;border-left: 0.1px solid black;border-right: 0.1px solid black;" >
                     <tr>
                       <td width="80" align="right">Fecha Emisión:</td>
                       <td width="80" align="left">'.$fechaActual.'</td>
                     </tr>
                     <tr>
                       <td width="80" align="right">Moneda:</td>
                       <td width="80" align="left">Soles</td>
                     </tr>
                     <tr>
                       <td width="80" align="right">N° Orden:</td>
                       <td width="80"></td>
                     </tr>
                     <tr>
                       <td width="80" align="right">User:</td>
                       <td width="80" align="left">CAJA-MPLP</td>
                     </tr>
                     </table>';
$pdf->writeHTML($html_propietario, true, false, false, false, '');

$pdf->SetXY($conx, $cony+3);
$html_propietario='<table style="border-bottom: 0.1px solid black;border-top: 0.1px solid black;border-left: 0.1px solid black;border-right: 0.1px solid black; height:100px"align="center">
                     <tr style="background-color: #a3e4d7;">
                       <td width="68" style="border-bottom: 0.1px solid black;"><h3><br>Periodo<br></h3></td>
                       <td width="65" style="border-bottom: 0.1px solid black;"><h3><br>Importe<br></h3></td>
                       <td width="65" style="border-bottom: 0.1px solid black;"><h3><br>Gastos<br></h3></td>
                       <td width="65" style="border-bottom: 0.1px solid black;"><h3><br>TIM<br></h3></td>
                       <td width="65" style="border-bottom: 0.1px solid black;"><h3><br>Subtotal<br></h3></td>
                       <td width="65" style="border-bottom: 0.1px solid black;"><h3><br>Descuentos<br></h3></td>
                       <td width="65" style="border-bottom: 0.1px solid black;"><h3><br>Total<br></h3></td>
                     </tr>';
                     $html_propietario.='<tr>
                       <td width="458"></td>
                     </tr>';
                     $total_ingresos=0;
                     $subtotal=0;
                     $descuento=0;
                     $total=0;
                     foreach ($cuenta as $fila_p) { 
                      $total_ingresos +=1;
                      $subtotal+=$fila_p['Total'];
                      $descuento+=$fila_p['Descuento'];
                      $total+=$fila_p['Total_Pagar'];
                      $html_propietario .='<tr>';  
                      $html_propietario .='<th width="68" >'. $fila_p['Anio'].'- '.$fila_p['Periodo'].'</th>';
                      $html_propietario .='<th width="65" >'. $fila_p['Importe'].'</th>';
                      $html_propietario .='<th width="65" >'. $fila_p['Gasto_Emision'].'</th>';
                      $html_propietario .='<th width="65" >'. $fila_p['TIM'].'</th>';
                      $html_propietario .='<th width="65" >'. $fila_p['Total'].'</th>';
                      $html_propietario .='<th width="65" >'. $fila_p['Descuento'].'</th>';
                      $html_propietario .='<th width="65" >'. $fila_p['Total_Pagar'].'</th>';
                      $html_propietario .='</tr>';                         
                                      }
                                      
                                      $hasta=62-$total_ingresos;
                                      for ($i = 1; $i <= $hasta; $i++) {
                                        $html_propietario .='<tr><th width="458"></th></tr>';
                                      } 
                       $html_propietario .='</table>';                  
$pdf->writeHTML($html_propietario, true, false, false, false, '');
$pdf->SetX(25);
$pdf->SetFont('helvetica', '', 7);
$html_propietario='<table style="border-bottom: 0.1px solid black;border-top: 0.1px solid black;border-left: 0.1px solid black;border-right: 0.1px solid black; height:100px"align="center">
                     <tr>
                       <td align="right" width="400"><b>Subtotal</b></td>
                       <td width="58">S/.'.number_format($subtotal,2).'</td>
                     </tr>
                     <tr>
                       <td align="right" width="400"><b>Descuento</b></td>
                       <td width="58">S/.'.number_format($descuento,2).'</td>
                     </tr>
                     <tr>
                       <td align="right" width="400"><b>Total</b></td>
                       <td width="58">S/.'.number_format($total,2).'</td>
                     </tr>';
                    
                       $html_propietario .='</table>';                  
$pdf->writeHTML($html_propietario, true, false, false, false, '');

function montoALetras($monto) {
  // Definir arrays para las unidades, decenas y centenas
  $unidades = array('', 'un', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho', 'nueve');
  $decenas = array('', 'diez', 'veinte', 'treinta', 'cuarenta', 'cincuenta', 'sesenta', 'setenta', 'ochenta', 'noventa');
  $centenas = array('', 'cien', 'doscientos', 'trescientos', 'cuatrocientos', 'quinientos', 'seiscientos', 'setecientos', 'ochocientos', 'novecientos');

  // Dividir el monto en partes enteras y decimales
  $partes = explode('.', number_format($monto, 2, '.', ''));

  // Obtener las partes enteras y decimales
  $entero = (int)$partes[0];
  $decimal = isset($partes[1]) ? (int)$partes[1] : 0;

  // Convertir la parte entera a letras
  $letras = '';

  // Procesar centenas
  if ($entero >= 100) {
      $letras .= $centenas[floor($entero / 100)];
      $entero %= 100;

      if ($entero > 0) {
          $letras .= 'to';
      }
  }

  // Procesar decenas
  if ($entero >= 10) {
      if ($entero == 10 || $entero == 20) {
          $letras .= $decenas[$entero / 10];
      } else {
          $letras .= $decenas[floor($entero / 10)];
          $entero %= 10;

          if ($entero > 0) {
              $letras .= 'y';
          }
      }
  }

  // Procesar unidades
  if ($entero > 0) {
      $letras .= $unidades[$entero];
  }

  // Convertir la parte decimal a letras
  $letras .= ' con ' . ($decimal > 0 ? montoALetras($decimal) : ' cero') . ' centavos';

  return $letras;
}

// Ejemplo de us
$letras = montoALetras($total);


$pdf->SetX(25);
$pdf->SetFont('helvetica', '', 7);
$html_propietario='<table style="border-bottom: 0.1px solid black;border-top: 0.1px solid black;border-left: 0.1px solid black;border-right: 0.1px solid black; height:100px"align="center">
                     <tr>
                       <td align="right" width="208"><b><br>Importe en Letras:</b><br></td>
                       <td width="250" align="left"><b><br>S/.'.$letras.'</b><br></td>
                     </tr>
                    ';
                    
                       $html_propietario .='</table>';   
                       $pdf->writeHTML($html_propietario, true, false, false, false, ''); 
// Generar el PDF en memoria
$pdfData = $pdf->Output('', 'S'); // 'S' para obtener los datos en una variable
$rutaPDF = 'HR_pdf/Hr_'.uniqid().'.pdf';
// Guardar el PDF en la ruta especificada
file_put_contents($rutaPDF, $pdfData);
// Devolver la ruta del PDF guardado
echo $rutaPDF;