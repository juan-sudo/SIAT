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

$id_proveido=$_POST['id_proveido'];
$configuracion = ControladorConfiguracion::ctrConfiguracion();
$proveido = ModeloCaja::ctrProveido_caja_pdf($id_proveido);
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
                       <th colspan="4"><h4>'.$configuracion['Nombre_Empresa'].'</h4></th>
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
$pdf->SetX(10);
$html_propietario='<table align="center" style=" border-bottom: 0.1px solid black; border-left: 0.1px solid black;
                    border-right: 0.1px solid black; border-top: 0.1px solid black;" >
                     <tr><td width="330" style="background-color: #a3e4d7;"></td></tr>
                     <tr style="background-color: #a3e4d7;">
                       <td width="80" style=" border-bottom: 0.1px solid black; font-size: 7px;" >DNI<br></td>
                       <td width="250" style=" border-bottom: 0.1px solid black; font-size: 7px;" >Usuario(s)</td>
                     </tr>';
                    
$html_propietario .='<tr><th width="330"></th></tr><tr>';
$html_propietario .='<th width="80">'.$proveido['dni'].'</th>';
$html_propietario .='<th width="250"><br>'.$proveido['nombres']. '<br></th>';
$html_propietario .='</tr>';
                    
$html_propietario .='</table>';
             $pdf->writeHTML($html_propietario, true, false, false, false, '');
$conx=$pdf->GetX()+15;
$cony=$pdf->GetY();
// Establecer las coordenadas x, y manualmente para 'Nivel'
$x=$pdf->GetX()+120;
$y=$pdf->GetY()-20;
//$x = 11; // ajusta según tus necesidades
//$y = 135; // ajusta según tus necesidades
$pdf->SetXY($x, $y);
             $html_propietario='<table align="center" style=" border-bottom: 0.1px solid black; border-top: 0.1px solid black;border-left: 0.1px solid black;border-right: 0.1px solid black;" >
                     <tr><td width="200"></td></tr>
                     <tr>
                       <td width="100" align="right" style="font-size: 7px;">Fecha Emisión:</td>
                       <td width="100" align="left" style="font-size: 7px;">'.$fechaActual.'</td>
                     </tr>
                     <tr>
                       <td width="100" align="right" style="font-size: 7px;">Moneda:</td>
                       <td width="100" align="left" style="font-size: 7px;">Soles</td>
                     </tr>
                     <tr>
                       <td width="100" align="right" style="font-size: 7px;">N° Proveido:</td>
                       <td width="100" align="left" style="font-size: 7px;">'.$proveido['numero_proveido'].'</td>
                     </tr>
                     <tr>
                       <td width="100" align="right" style="font-size: 7px;">User:</td>
                       <td width="100" align="left" style="font-size: 7px;">CAJA-MPLP <br></td>
                     </tr>
                     </table>';
$pdf->writeHTML($html_propietario, true, false, false, false, '');

$pdf->SetXY($conx, $cony+3);
$pdf->SetX(10);
//tabla del proveido
$html_propietario='<table  align="center" style="border-right: 0.1px solid black; border-top: 0.1px solid black;" >
                    <tr><td style="background-color: #a3e4d7;border-left: 0.1px solid black;" width="540"></td></tr>
                     <tr style="background-color: #a3e4d7;">
                       <td style=" border-bottom: 0.1px solid black; font-size: 7px; border-left: 0.1px solid black;" width="40">Codigo<br></td>
                       <td style=" border-bottom: 0.1px solid black;font-size: 7px;" width="90">Área</td>
                       <td style=" border-bottom: 0.1px solid black;font-size: 7px;" width="175">Especie Valorada</td>
                       <td style=" border-bottom: 0.1px solid black;font-size: 7px;" width="120">Observaciones</td>
                       <td style=" border-bottom: 0.1px solid black;font-size: 7px;" width="40">Costo Unit.</td>
                       <td style=" border-bottom: 0.1px solid black;font-size: 7px;" width="35">Cantidad</td>
                       <td style=" border-bottom: 0.1px solid black;font-size: 7px;" width="40">Valor Total</td>
                     </tr>
                    
                     <tr><td width="540" style="border-left: 0.1px solid black;"></td></tr>
                     <tr>
                     <td width="40" style="border-left: 0.1px solid black;"><br>'.$proveido['codigo'].'<br></td>
                     <td width="90"><br>'.$proveido['nombre_area'].'<br></td>
                     <td width="175">'.$proveido['nombre_especie'].'</td>
                     <td width="120">'.$proveido['observaciones'].'</td>
                     <td width="40">'.$proveido['monto'].'</td>
                     <td width="35">'.$proveido['cantidad'].'</td>
                     <td width="40">'.$proveido['valor_total'].'</td>
                     </tr>
                     <tr>
                     <td width="420" style="border-top: 0.1px solid black;"></td>
                     <td width="80" align="right" style="border-bottom: 0.1px solid black;border-left: 0.1px solid black;">Total Cencelado S/.</td>
                     <td width="40" style="border-bottom: 0.1px solid black;">'.$proveido['valor_total'].'<br></td>
                     </tr>
                     ';
                     
$html_propietario .='</table>';
             $pdf->writeHTML($html_propietario, true, false, false, false, '');
//fin de la tabla tabla del proveido
function traducirMes($nombreMesIngles) {
  $meses = [
      'January' => 'enero',
      'February' => 'febrero',
      'March' => 'marzo',
      'April' => 'abril',
      'May' => 'mayo',
      'June' => 'junio',
      'July' => 'julio',
      'August' => 'agosto',
      'September' => 'septiembre',
      'October' => 'octubre',
      'November' => 'noviembre',
      'December' => 'diciembre',
  ];

  return $meses[$nombreMesIngles] ?? $nombreMesIngles;
}



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
$total=$proveido['valor_total'];
$letras = montoALetras($total);


$pdf->SetX(25);
$pdf->SetFont('helvetica', '', 7);
$html_propietario='<table align="center">
                     <tr>
                       <td align="right" width="208"><b><br>Importe en Letras:</b><br></td>
                       <td width="250" align="left"><b><br>S/.'.$letras.'</b><br></td>
                     </tr>
                    ';
                    
                       $html_propietario .='</table>';   
                       $pdf->writeHTML($html_propietario, true, false, false, false, ''); 


                       
// Establecer el idioma local en inglés
setlocale(LC_TIME, 'en_US.utf8');
// Capturar la fecha actual
$fechaActual = new DateTime();
// Obtener el nombre del mes en inglés
$nombreMesIngles = strftime('%B', $fechaActual->getTimestamp());
// Traducir el nombre del mes al español
$nombreMesEspanol = traducirMes($nombreMesIngles);
// Formatear la fecha con el nombre del mes en español
$fechaActual_formato = strftime('%d de ') . $nombreMesEspanol . strftime(' del %Y', $fechaActual->getTimestamp());
$html_propietario='<table align="right">
                    <tr><td style="" width="540"></td>'.$configuracion['Lugar'].','.$fechaActual_formato.'</tr>';
$html_propietario .='</table>';
$pdf->writeHTML($html_propietario, true, false, false, false, '');                       
// Generar el PDF en memoria


$pdfData = $pdf->Output('', 'S'); // 'S' para obtener los datos en una variable
$rutaPDF = 'HR_pdf/Hr_'.uniqid().'.pdf';
// Guardar el PDF en la ruta especificada
file_put_contents($rutaPDF, $pdfData);
// Devolver la ruta del PDF guardado
echo $rutaPDF;