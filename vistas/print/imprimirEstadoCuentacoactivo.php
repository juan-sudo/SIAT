<?php
require_once("../../vendor/autoload.php");
require_once('./TCPDFmain/pdf/tcpdf_include.php');
use Conect\Conexion;
use Controladores\ControladorPredio;
use Controladores\ControladorEstadoCuenta;
use Controladores\ControladorConfiguracion;
use Modelos\ModeloContribuyente;
use Modelos\ModeloEstadoCuenta;

class MYPDFC extends TCPDF {

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
        $this->Cell(0, 10, $configuracion['Nombre_Empresa'] . " - Consulta: 966004730", 0, 0, 'C');

    }
}
$pdf = new MYPDFC(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Establecer la información del PDF
$pdf->SetCreator('TuNombre');
$pdf->SetAuthor('TuNombre');
$pdf->SetTitle('Mi PDF');
// Agregar una página
$pdf->AddPage();

$id_usuario=$_POST['id_usuario'];
$carpeta=$_POST['carpeta'];
$id_area=$_POST['id_area']; 
$id_cuenta=$_POST['id_cuenta']; //Viene un array pero se convierte en un string ('36,37') -> convertir en un array en el servidor

$propietarios=$_POST['propietarios']; //Viene un array pero se convierte en un string ('36,37') -> convertir en un array en el servidor


//   echo "<pre>"; // Mejor legibilidad al imprimir datos complejos
//             print_r($id_cuenta); // Imprime la respuesta de manera estructurada
//             echo "</pre>";


//$estado_cuenta = ModeloEstadoCuenta::mdlEstadoCuenta_pdf($propietarios,$id_cuenta,"null","null",'null');

$estado_cuenta = ModeloEstadoCuenta::mdlEstadoCuenta_pdfcaI($propietarios,$id_cuenta,null,null,null);



$estado_cuentaA = ModeloEstadoCuenta::mdlEstadoCuenta_pdfcaA($propietarios,$id_cuenta,null,null,null);


$propietarios = ModeloEstadoCuenta::mdlPropietarios_pdf($propietarios);

$configuracion = ControladorConfiguracion::ctrConfiguracion();



// Inicio de la tabla HTML
$html="<style>
th {
    font-size: 9px;
    font-family: Arial, sans-serif;
    font-weight: bold;
}
.totales{
    font-family: Arial, sans-serif;
    font-weight: bold;
    font-size: 9px;
}


td {
    font-size: 8px;
}
.mi-tabla thead {
    border-bottom: 3px solid black; /* Agrega una línea sólida debajo de la fila thead */
}
.espacio{
    margin-top:-10px;
    margin-bottom: 50px;
}
div{
    justify-content: center; /* Centra horizontalmente */
        align-items: center;
}


</style>";

$fechaActual = date('d/m/Y');
$numeroPagina = $pdf->PageNo();
$pdf->SetFont('helvetica', '', 7);


// Logo
$file = 'C:/xampp/htdocs/SIAT/vistas/img/logo/logou.jpg'; 
$imageData = base64_encode(file_get_contents($file));
$imgBase64 = 'data:image/jpeg;base64,' . $imageData;
$pdf->Image($file, 10, 5, 25, 25, 'JPG', '', '', true);

// Resolución
$pdf->MultiCell(0, 5, '', 0, 'C');

$pdf->SetX(40); 
$pdf->SetFont('helvetica', 'B', 16);  
$pdf->Cell(120, 0, 'Oficina de ejecucion coactiva', 0, 1, 'C');
$pdf->Ln(2); // También reducido a 1
$pdf->SetX(40); 
$pdf->SetFont('helvetica', 'B', 10);  
$pdf->Cell(120, 0, 'RESOLUCIÓN DE EJECUCIÓN COACTIVA N° 001', 0, 1, 'C');
$pdf->Ln(4); // También reducido a 1


$pdf->SetFont('helvetica', '', 8);
$html_propietario='<br>';

$width = $pdf->getPageWidth();
$tableWidth = 390; // Ancho de la tabla
$x = ($width - $tableWidth) / 2;
$pdf->setX($x);
$pdf->SetFont('helvetica', '', 7); 




$html_propietario .= '<table align="center" width="100%" border="0.5" cellspacing="0" cellpadding="2">';

foreach ($propietarios as $valor => $filas) {
    foreach ($filas as $fila) {
        $html_propietario .= '<tr>';
        $html_propietario .= '<td width="60%" align="left">Contribuyente: ' . $imgBase64 . '</td>';
        $html_propietario .= '<td width="20%" align="left">Dni: ' . ($fila['documento'] ?: '-') . '</td>';
        $html_propietario .= '<td width="20%" align="left fontZise">Codigo: ' . $fila['id_contribuyente'] . '</td>';
        $html_propietario .= '</tr>';
    }
}

$html_propietario .= '</table>';



$pdf->SetFont('helvetica', '', 8);
$html_propietario='<br>';


//contribuyente

$width = $pdf->getPageWidth();
$tableWidth = 390; // Ancho de la tabla
$x = ($width - $tableWidth) / 2;
$pdf->setX($x);
$pdf->SetFont('helvetica', '', 8); 






$html_propietario .= '<table align="center" width="100%" border="0.5" cellspacing="0" cellpadding="2">';

$totalPropietarios = count($propietarios);

if ($totalPropietarios > 1) {
    // Mostrar el primer propietario como "Contribuyente"
    $primerPropietario = array_shift($propietarios); // Obtiene y elimina el primer elemento del array
    foreach ($primerPropietario as $fila) {
        $html_propietario .= '<tr>';
        $html_propietario .= '<td width="60%" align="left"><strong>Contribuyente:</strong> ' . $fila['nombre_completo'] . '</td>';
        $html_propietario .= '<td width="20%" align="left"> <strong>Dni:</strong> ' . ($fila['documento'] ?: '-') . '</td>';
        $html_propietario .= '<td width="20%" align="left"><strong>Codigo:</strong> ' . $fila['id_contribuyente'] . '</td>';
        $html_propietario .= '</tr>';
    }

    // Mostrar el resto como "Parentesco"
    foreach ($propietarios as $valor => $filas) {
        foreach ($filas as $fila) {
            $html_propietario .= '<tr>';
            $html_propietario .= '<td width="60%" align="left"><strong>Parentesco:</strong> ' . $fila['nombre_completo'] . '</td>';
            $html_propietario .= '<td width="20%" align="left"> <strong>Dni:</strong> ' . ($fila['documento'] ?: '-') . '</td>';
            $html_propietario .= '<td width="20%" align="left"><strong>Codigo:</strong> ' . $fila['id_contribuyente'] . '</td>';
            $html_propietario .= '</tr>';
        }
    }
} else {
    // Si solo hay un propietario o ninguno
    foreach ($propietarios as $valor => $filas) {
        foreach ($filas as $fila) {
            $html_propietario .= '<tr>';
            $html_propietario .= '<td width="60%" align="left"><strong>Contribuyente:</strong>  ' . $fila['nombre_completo'] . '</td>';
            $html_propietario .= '<td width="20%" align="left"> <strong>Dni:</strong>  ' . ($fila['documento'] ?: '-') . '</td>';
            $html_propietario .= '<td width="20%" align="left"><strong>Codigo:</strong>: ' . $fila['id_contribuyente'] . '</td>';
            $html_propietario .= '</tr>';
        }
    }
}

$html_propietario .= '</table>';

$html_propietario .= '<br><br>'; 
$html_propietario .= '<table align="center" width="100%" border="0.2" cellspacing="0" cellpadding="2">';

if (count($propietarios) > 1) {
    // Mostrar solo el primer propietario si hay más de uno
    $primerPropietario = reset($propietarios); // Obtiene el primer elemento del array
    foreach ($primerPropietario as $fila) {
        $html_propietario .= '<tr>';
        $html_propietario .= '<td width="60%" align="left"> <strong>Direccion Fiscal:</strong>  ' . $fila['direccion_completo'] . '</td>';
        $html_propietario .= '<td width="40%" align="left"> <strong>Distrito:</strong>  ' . 'PUQUIO'. '</td>';

        $html_propietario .= '</tr>';
    }
} else {
    // Si solo hay un propietario o ningunox
    foreach ($propietarios as $valor => $filas) {
        foreach ($filas as $fila) {
            $html_propietario .= '<tr>';
            $html_propietario .= '<td width="60%" align="left"> <strong>Direccion Fiscal:</strong>  ' . $fila['direccion_completo'] . '</td>';
            $html_propietario .= '<td width="40%" align="left"> <strong>Distrito:</strong>  ' . 'PUQUIO'. '</td>';
    
            $html_propietario .= '</tr>';
        }
    }
}

$html_propietario .= '</table>';

$html_propietario .= '<br><br>'; 



$html_propietario .= '<table align="center" width="100%" border="0.5" cellspacing="0" cellpadding="2">';

if (count($propietarios) > 1) {
    // Mostrar solo el primer propietario si hay más de uno
    $primerPropietario = reset($propietarios); // Obtiene el primer elemento del array
    foreach ($primerPropietario as $fila) {
        $html_propietario .= '<tr>';
        $html_propietario .= '<td width="60%" align="left"> <strong>Numero expediente:</strong>  ' . ' ' . '</td>';
        $html_propietario .= '<td width="40%" align="left" style="font-size: 24px;"> <strong>Carpeta:</strong> <strong style="font-size: 24px;">'.$_POST['carpeta']. '</strong>  </td>';

        $html_propietario .= '</tr>';
    }
} else {
    // Si solo hay un propietario o ningunox
    foreach ($propietarios as $valor => $filas) {
        foreach ($filas as $fila) {
            $html_propietario .= '<tr>';
        $html_propietario .= '<td width="60%" align="left"> <strong>Numero expediente:</strong>  ' . ' ' . '</td>';
        $html_propietario .= '<td width="20%" align="center" style="background-color:#ab851f; color:white"> <strong>Carpeta:</strong> <strong style="font-size: 10px;">'.$_POST['carpeta']. '</strong>  </td>';

        $html_propietario .= '</tr>';
        }
    }
}

$html_propietario .= '</table>';

 $pdf->writeHTML($html_propietario, true, false, false, false, '');





//TABLA IMPUESTO PREDIAL

$pdf->SetX(20); // Margen izquierdo
$textoLargo = "Impuesto predial";

$pdf->SetFont('helvetica', '', 9); // Tamaño de fuente más legible
$pdf->MultiCell(190, 6, $textoLargo, 0, 'L'); // Ancho correcto para una hoja A

  //SEGUNDO REGISTRO


// Variables para acumular los totales
// $totalImportee = 0;
// $totalGastoEmisione = 0;
// $totalSaldoe = 0;
// $totalDescuentoe = 0;
// $totalTIMe = 0;
// $totalPagadoe = 0;



             $pdf->Line(20, $pdf->getY(),200, $pdf->getY());
             $pdf->SetFont('helvetica', '', 7.5);  
             $pdf->SetX(15); // Margen izquierdo

$html_estado= '<table align="center">
            <thead>
            <tr>
             
                <th><b>Año</b></th>
               <th><b>Importe</b></th>
               <th><b>Gasto</b></th>
                <th><b>Subtotal</b></th>
                <th><b>Descuento</b></th>
        
                <th><b>T.I.M</b></th>
                <th><b>Total</b></th>
            </tr>
            </thead></table>';

            $pdf->writeHTML($html_estado, true, false, false, false, '');
            $pdf->Line(20, $pdf->getY()-3,200, $pdf->getY()-3);

            
            $pdf->SetX(15); // Margen izquierdo

            $html= '<table align="center">';  

            $sin_descuento=0; 
            $tim=0;        
            
            
           
            foreach ($estado_cuenta as $row) {
               
              
                $html .= "<tr>";
               

                $html .= "<th>".$row['Anio']."</th>";
                $html .= "<th>".$row['Total_Importe']."</th>";
                $html .= "<th>".$row['Total_Gasto_Emision']."</th>";
                $html .= "<th>".$row['Total_Saldo']."</th>";
             
                $html .= "<th>".$row['Total_Descuento']."</th>"; //CAMBIO 1
                
                $html .= "<th>".$row['Total_TIM']."</th>";
                $html .= "<th>".$row['Total_Pagado']."</th>";
                $html .= "</tr>";
            }
            
            $html .= '</table>'; // Cerramos la tabla




            
           // Línea separadora
           // 🔹 Ahora dibujamos la línea DESPUÉS de terminar la tabla
$pdf->writeHTML($html, true, false, false, false, '');



//prueba de linia ////////////////////////////////////////////
// $estado_cuenta1 = []; // Este será nuestro arreglo final para las filas

// // Recorrer las claves de los datos POST y organizarlos por índice de fila
// foreach ($_POST as $key => $value) {
//     // Extraer el índice de la fila (por ejemplo, 'fila_0_totalImporte')
//     preg_match('/fila_(\d+)_/', $key, $matches);
//     if (!empty($matches)) {
//         $index = $matches[1]; // El índice de la fila

//         // Inicializar el arreglo de la fila si no existe
//         if (!isset($estado_cuenta1[$index])) {
//             $estado_cuenta1[$index] = [];
//         }

//         // Extraer el campo (por ejemplo, 'totalImporte')
//         preg_match('/_(.*)$/', $key, $fieldMatches);
//         if (!empty($fieldMatches)) {
//             $field = $fieldMatches[1]; // El nombre del campo, como 'totalImporte'

//             // Agregar el valor al arreglo de la fila
//             $estado_cuenta1[$index][$field] = $value;
//         }
//     }
// }



// Imprimir el arreglo de estado de cuenta

// $pdf->SetX(15); // Margen izquierdo
// $html = '<table border="1" align="center">';
// $html .= "<tr><th>Año</th><th>Total Importe</th><th>Total Gasto Emision</th><th>Total Saldo</th><th>Total Descuento</th><th>Total TIM Aplicar</th><th>Total Aplicar Anual</th></tr>";
// foreach ($estado_cuenta1 as $row) {
//     $html .= "<tr>";
//     $html .= "<td>" . htmlspecialchars($row['anio']) . "</td>";
//     $html .= "<td>" . htmlspecialchars($row['totalImporte']) . "</td>";
//     $html .= "<td>" . htmlspecialchars($row['totalGastoEmision']) . "</td>";
//     $html .= "<td>" . htmlspecialchars($row['totalSaldo']) . "</td>";
//     $html .= "<td>" . htmlspecialchars($row['totalDescuento']) . "</td>";
//     $html .= "<td>" . htmlspecialchars($row['totalTIMAplicar']) . "</td>";
//     $html .= "<td>" . htmlspecialchars($row['totalAplicarAnual']) . "</td>";
//     $html .= "</tr>";
// }
// $html .= '</table>';
// $pdf->writeHTML($html);  // Suponiendo que usas la librería TCPDF
// $pdf->Output();






// Línea separadora
// 🔹 Ahora dibujamos la línea DESPUÉS de terminar la tabla
//$pdf->writeHTML($html, true, false, false, false, '');

////////////////////////////////////



$pdf->Line(20, $pdf->getY(), 198, $pdf->getY());
$pdf->Ln(1);
$pdf->SetX(15); // AGREGADO




// // Sumamos los valores de $estado_cuenta
// foreach ($estado_cuenta as $row) {
//     $totalImportee += floatval($row['Total_Importe']);
//     $totalGastoEmisione += floatval($row['Total_Gasto_Emision']);
//     $totalSaldoe += floatval($row['Total_Saldo']);
//     $totalDescuentoe += floatval($row['Total_Descuento']); // CAMBIO 1
//     $totalTIMe+= floatval($row['Total_TIM']);
//     $totalPagadoe += floatval($row['Total_Pagado']);
// }


  // 🔹 Agregamos la tabla con la fila de totales (en una nueva tabla para evitar problemas de formato)
  $html_totales = '<table align="center" style=" " cellspacing="0" cellpadding="0" >'; // Sin bordes en la tabla general
  $html_totales .= '<tr>'; // Solo borde arriba
  $html_totales .= "<td><b>Total </b></td>";
  $html_totales .= "<td><b>" . number_format($_POST['totalImporteI'], 2, '.', ',') . "</b></td>";
  $html_totales .= "<td><b>" . number_format($_POST['totalGastoI'], 2, '.', ',') . "</b></td>";
  $html_totales .= "<td><b>" . number_format($_POST['totalSubtotalI'], 2, '.', ',') . "</b></td>";
  $html_totales .= "<td><b>" . number_format($_POST['totaldescuentoI'], 2, '.', ',') . "</b></td>";
  $html_totales .= "<td><b>" . number_format($_POST['totalTIMI'], 2, '.', ',') . "</b></td>";
  $html_totales .= "<td><b>" . number_format($_POST['totalTotalI'], 2, '.', ',') . "</b></td>";
  $html_totales .= "</tr>";
  
  $html_totales .= '</table>';
  

$pdf->writeHTML($html_totales, true, false, false, false, '');


//PARA LA SUNFAA


// Variables para acumular los totales
// $totalImportea = 0;
// $totalGastoEmisiona = 0;
// $totalSaldoa = 0;
// $totalDescuentoa = 0;
// $totalTIMa = 0;
// $totalPagadoa = 0;

// Sumamos los valores de $estado_cuenta
// foreach ($estado_cuentaA as $row) {
//     $totalImportea += $row['Total_Importe'];
//     $totalGastoEmisiona += $row['Total_Gasto_Emision'];
//     $totalSaldoa += $row['Total_Saldo'];
//     $totalDescuentoa += $row['Total_Descuento'];
//     $totalTIMa += $row['Total_TIM'];
//     $totalPagadoa += $row['Total_Pagado'];
// }

//TABLA ARBITRIO

$textoLargo = "Arbitrio municipal";

$pdf->SetX(20); // Margen izquierdo
$pdf->SetFont('helvetica', ' ', 9); // Tamaño de fuente más legible
$pdf->MultiCell(190, 6, $textoLargo, 0, 'L'); // Ancho correcto para una hoja A

  //SEGUNDO REGISTRO ARBITRIO MUNICIAPAL


$pdf->Line(20, $pdf->getY(),200, $pdf->getY());
$pdf->SetFont('helvetica', '', 7.5);  

$pdf->SetX(15); // AGREGADO
$html_estado= '<table align="center">
<thead>
<tr>

   <th><b>Año</b></th>
  <th><b>Importe</b></th>
  <th><b>Gasto</b></th>
   <th><b>Subtotal</b></th>
   <th><b>Descuento</b></th>

   <th><b>T.I.M</b></th>
   <th><b>Total</b></th>
</tr>
</thead></table>';

$pdf->writeHTML($html_estado, true, false, false, false, '');
$pdf->Line(20, $pdf->getY()-3,200, $pdf->getY()-3);

$pdf->SetX(15); // AGREGADO

$html= '<table align="center">';  

$sin_descuento=0; 
$tim=0;        



foreach ($estado_cuentaA as $row) {
  
 
   $html .= "<tr>";
  

   $html .= "<th>".$row['Anio']."</th>";
   $html .= "<th>".$row['Total_Importe']."</th>";
   $html .= "<th>".$row['Total_Gasto_Emision']."</th>";
   $html .= "<th>".$row['Total_Saldo']."</th>";

   $html .= "<th>".$row['Total_TIM_Descuento']."</th>";
   
   $html .= "<th>".$row['Total_TIM']."</th>";
   $html .= "<th>".$row['Total_Pagado']."</th>";
   $html .= "</tr>";
}

$html .= '</table>'; // Cerramos la tabla





// Línea separadora
// 🔹 Ahora dibujamos la línea DESPUÉS de terminar la tabla
$pdf->writeHTML($html, true, false, false, false, '');






//AGREGADO INICIO


$pdf->Line(20, $pdf->getY(), 198, $pdf->getY());
$pdf->Ln(1);
$pdf->SetX(15); // AGREGADO




  // 🔹 Agregamos la tabla con la fila de totales (en una nueva tabla para evitar problemas de formato)
  $html_totales = '<table align="center" style=" " cellspacing="0" cellpadding="0" >'; // Sin bordes en la tabla general
  $html_totales .= '<tr>'; // Solo borde arriba
  $html_totales .= "<td><b>Total </b></td>";
  $html_totales .= "<td><b>" . number_format($_POST['totalImporteA'], 2, '.', ',') . "</b></td>";
  $html_totales .= "<td><b>" . number_format($_POST['totalGastoA'], 2, '.', ',') . "</b></td>";
  $html_totales .= "<td><b>" . number_format($_POST['totalSubtotalA'], 2, '.', ',') . "</b></td>";
  $html_totales .= "<td><b>" . number_format($_POST['totaldescuentoA'], 2, '.', ',') . "</b></td>";
  $html_totales .= "<td><b>" . number_format($_POST['totalTIMA'], 2, '.', ',') . "</b></td>";
  $html_totales .= "<td><b>" . number_format($_POST['totalTotalA'], 2, '.', ',') . "</b></td>";
  $html_totales .= "</tr>";
  
  $html_totales .= '</table>';
  

$pdf->writeHTML($html_totales, true, false, false, false, '');



//FIN INCIO
//linia

$pdf->SetDrawColor(0, 0, 0); // Color negro (RGB)
$pdf->SetLineWidth(0.2); // Grosor más delgado



$pdf->Line(105, $pdf->getY(), 200, $pdf->getY());

          
            $pdf->SetFont('helvetica', 'B', 6);  // Establecer el tamaño de letra a 8

           // $pdf->MultiCell(0, 1, '', 0, 'L');

           
            $totalFormateado = number_format($_POST['totalTotal'], 2, '.', ',');

         $text = str_replace('  ', ' ', 'T O T A L   D E U D A'); 

         // Configurar fuente más grande
        $pdf->SetFont('Helvetica', 'B', 12); // Fuente en negrita y tamaño 14

      // Definir un margen derecho manualmente restando unos píxeles
        $margenDerecho = 25; // Ajusta este valor según tu necesidad
        $anchoPagina = $pdf->GetPageWidth(); // Obtiene el ancho de la página
        $anchoCelda = $anchoPagina - $margenDerecho; // Reduce el ancho para dejar margen

        $pdf->Cell($anchoCelda, 10, $text . ' S/. = ' . $totalFormateado, 0, 1, 'R');
            
           
           

            
            // $pdf->MultiCell(0, 1, '', 0, 'L');
         //   $sin_descuento_formateado = number_format($sin_descuento, 2, '.', ',');
         //   $tim_formateado = number_format($tim, 2, '.', ',');
          //  $pdf->SetFont('helvetica', 'B', 8);  // Establecer el tamaño de letra a 8
          //  $pdf->Cell(323, 0, 'T . I . M    S/.   =               '.$tim_formateado, 0, 1, 'C', 0, '', 0);
          //  $pdf->Line(10, $pdf->getY(),200, $pdf->getY());
           
           // $pdf->Cell(260, 0, 'T O T A L   D E U D A   S I N   D E S C U E N T O   + T.I.M    S/.   =               '.$sin_descuento_formateado, 0, 1, 'C', 0, '', 0);
           
           
           
           
           // $pdf->MultiCell(0, 0, '', 0, 'L');

          


          
         //PRIMER REGISTRO
$pdf->SetX(45); 
$pdf->SetFont('helvetica', '', 8);  // Establecer el tamaño de letra a 8


$pdf->Ln(5); // Salto de línea
// Obtener la fecha actual
$fechaActual = date('d/m/Y'); // Formato día/mes/año

$textoLargo = "De conformidad con el artículo 29° del T.U.O. de la Ley N° 26979, notifíquese al obligado para que, en el plazo de siete (7) días hábiles contados desde el día siguiente de su recepción, se sirva cancelar la suma de $totalFormateado, actualizada al $fechaActual, más las costas procesales y gastos administrativos que devenguen hasta la total cancelación de la deuda, sin perjuicio de los intereses de ley. Si el pago no se realiza dentro del plazo establecido, se dictarán las medidas cautelares correspondientes. El presente acto tiene vigencia desde el día de su notificación y contra el mismo no cabe la interposición de recurso impugnativo alguno. Cabe indicar que el interés moratorio a cancelar será calculado hasta la fecha de pago, de acuerdo al Art. 33° del TUO del Código Tributario y sus modificatorias.";

$pdf->SetX(20); // Margen izquierdo
$pdf->SetFont('helvetica', '', 10); // Tamaño de fuente más legible


$textoLargo .= "\n";
$pdf->MultiCell(180, 6, $textoLargo, 0, 'J'); // Ancho correcto para una hoja A

  //SEGUNDO REGISTRO

$pdf->SetX(45); 
$pdf->SetFont('helvetica', '', 8);  // Establecer el tamaño de letra a 8


$pdf->Ln(5); // Salto de línea

$textoLargo = "Base legal: Art. 15°, 25°, 29°, 30° y 32° del T.U.O. de la Ley de Procedimiento de Ejecución Coactiva aprobado por D.S. 018-2008-JUS y modificatorias y su reglamento aprobado por D.S. 069-2003-EF y modificatorias. Ordenanza u otra norma N° 001 que aprueba los aranceles del Procedimiento de Ejecución Coactiva.";

$pdf->SetX(20); // Margen izquierdo
$pdf->SetFont('helvetica', '', 10); // Tamaño de fuente más legible
$textoLargo .= "\n";
$pdf->MultiCell(180, 6, $textoLargo, 0, 'J'); // Ancho correcto para una hoja A

//TERCER REGISTRO

$pdf->SetX(45); 
$pdf->SetFont('helvetica', '', 8);  // Establecer el tamaño de letra a 8


$pdf->Ln(5); // Salto de línea

$textoLargo = "Se adjunta copia de el(los) acto(s) administrativo(s) generador(es) de la obligación así como su(s) cargo(s) de notificación y/o acuse(s) de recibo electrónico y constancia de haber quedado consentido o causado estado según lo establecido en el numeral 15.2 del Art. 15° de la Ley N° 26979 Ley de Procedimiento de Ejecución Coactiva, cuyo T.U.O. se aprobó por D.S. 018-2008-JUS.";

$pdf->SetX(20); // Margen izquierdo
$pdf->SetFont('helvetica', '', 10); // Tamaño de fuente más legible
$textoLargo .= "\n";
$pdf->MultiCell(180, 6, $textoLargo, 0, 'J'); // Ancho correcto para una hoja A


// Verificar si hay 4 o más registros en $estado_cuenta
// if (count($estado_cuentaA) >= 6) {
//     $pdf->AddPage(); // Añadir una nueva página
//     $pdf->Ln(10);    // Añadir una separación de 10 unidades para evitar superposición con el encabezado
// }
// Verificar si hay suficiente espacio en la página para las siguientes celdas
// Verificar si hay suficiente espacio para el siguiente contenido
// Verificar si hay suficiente espacio para el siguiente contenido
$pdf->Ln(20);  
// Verificar si se necesita nueva página
if ($pdf->GetY() > 250) {
    $pdf->AddPage(); // Añadir nueva página si está muy abajo
    $pdf->SetY(35); // Ajustar el margen superior en la nueva página
}


//$pdf->AddPage();
//LINIASUSPENDIDA

// Definir ancho de cada columna para centrar el contenido
// Definir ancho de cada columna para centrar el contenido
$ancho_columna = 95; // Mitad del ancho de la página con márgenes

$pdf->SetFont('helvetica', '', 10);  // Tamaño de letra más legible

// Línea de firma
// Verificar si la posición actual está demasiado cerca de la cabecera

// Obtener la posición actual
// Obtener la posición actual

//$pdf->Ln(90);

// Añadir la segunda página
// Comprobar si la posición actual está cerca del final de la página
// Verificar si hay suficiente espacio en la página antes de añadir más contenido


//$pdf->Ln(30); // Agregar margen superior de 5 unidades antes de la tabla

$pdf->SetX( (210 - 180) / 2 ); // Centrar contenido dentro del margen

$pdf->Cell($ancho_columna, 6, "______________________________", 0, 0, 'C'); // Firma izquierda
$pdf->Cell($ancho_columna, 6, "__________________________________", 0, 1, 'C'); // Firma derecha

// Comprobamos si hay suficiente espacio en la página para las siguientes celdas
// Verificar si las firmas están muy abajo en la página

// Nombres debajo de las firmas
$pdf->SetX( (210 - 180) / 2 ); // Centrar contenido
$pdf->Cell($ancho_columna, 6, "HECTOR A. HUARCAYA COTAQUISPE", 0, 0, 'C'); // Nombre izquierdo
$pdf->Cell($ancho_columna, 6, "DAVID E. JALIXTO HUASCO", 0, 1, 'C'); // Nombre derecho

// Cargos debajo de los nombres (nueva línea)
$pdf->SetX( (210 - 180) / 2 ); // Centrar contenido
$pdf->Cell($ancho_columna, 6, "Ejecutor coactivo", 0, 0, 'C'); // Cargo izquierdo
$pdf->Cell($ancho_columna, 6, "Auxiliar coactivo", 0, 1, 'C'); // Cargo derecho





//---------------------------------
$pdf->Ln(10); // Agregar margen superior de 5 unidades antes de la tabla

$pdf->SetX(20); // Margen izquierdo


$fechaActual = date('d/m/Y');
$numeroPagina = $pdf->PageNo();

$pdf->SetFont('helvetica', '', 7);
$html_head ='<table cellpadding="2" ><tr>
                       <th colspan="8" style="text-transform: lowercase;"> <strong>Oficinas de atencion:</strong> '.$configuracion['Nombre_Empresa'].'</th>
                      
                       <th colspan="2"><strong>TOTAL (s/.)</strong></th>
                       
                    </tr>
                    <tr>
                       <th colspan="8"> <strong>Pagos en:</strong>'.$id_area.'</th>
                          <th width="70" border="0.5" style="text-align: center; font-size:11px; "> <b>'.$totalFormateado.'</b></th>
                  
                    </tr>
                   
                 
             </table>';
$pdf->writeHTML($html_head);


// if (count($estado_cuenta) <=6) {
//    // $pdf->AddPage(); // Añadir una nueva página
//     $pdf->Ln(40);    // Añadir una separación de 10 unidades para evitar superposición con el encabezado
// }

// if (count($estado_cuenta) ==8) {
//     // $pdf->AddPage(); // Añadir una nueva página
//      $pdf->Ln(10);    // Añadir una separación de 10 unidades para evitar superposición con el encabezado
//  }
 
// if (count($estado_cuenta) ==9) {
//     // $pdf->AddPage(); // Añadir una nueva página
//      $pdf->Ln(10);    // Añadir una separación de 10 unidades para evitar superposición con el encabezado
//  }


if ($pdf->GetY() > 250) {
    $pdf->AddPage(); // Añadir nueva página si está muy abajo
    $pdf->SetY(10); // Ajustar el margen superior en la nueva página
}
$anio_impresion = date('Y');
$sector_2 = '<table width="80%" align="center" border="0" cellspacing="2" cellpadding="4">
                 <tr>
                     <th colspan="2" align="center"><span style="font-size:14px;  "><b>CONSTANCIA DE NOTIFICACIÓN</b></span></th> 
                 </tr>
                <tr>
                     <th width="25%" align="left"><span style="font-size:9px;; font-weight:bold;">Fecha de Recepción</span></th> 
                     <th width="75%" align="left"><span style="font-size:9px;">: Puquio, ........ de ............................................................. del '.$anio_impresion.'</span></th> 
                
                     </tr>
                 <tr>
                     <th width="25%" align="left"><span style="font-size:9px; font-weight:bold;">Domicilio</span></th>
                     <th width="75%"align="left"><span style="font-size:9px;">: ..........................................................................................................................</span></th>
                 </tr>
                 <tr>
                     <th width="25%" align="left"><span style="font-size:9px; font-weight:bold;">Apellidos y Nombres</span></th>
                     <th width="75%" align="left"><span style="font-size:9px;">: ..........................................................................................................................</span></th>
                 </tr>
                 <tr>
                     <th width="25%" align="left"><span style="font-size:9px;font-weight:bold;">Parentesco</span></th>
                     <th width="75%"align="left"><span style="font-size:9px;">: ...................................................................................... DNI:...........................</span></th>
                 </tr>
                  <tr>
                     <th width="25%" align="left"><span style="font-size:9px; font-weight:bold;"></span></th>
                     <th width="75%"><span style="font-size:9px;"></span></th>
                 </tr>
                 <tr>   
                     <th width="25%" align="left"><span style="font-size:9px; font-weight:bold;">Firma de Recepción</span></th>
                     <th width="75%"><span style="font-size:9px;">: ..........................................................................................................................</span></th>
                 </tr>
                 <tr>
                     <th width="25%" align="left"><span style="font-size:9px; font-weight:bold;">Notificado Por</span></th>
                     <th width="75%"><span style="font-size:9px;">: ...................................................................................... DNI:...........................</span></th>
                 </tr>
                  <tr>
                     <th width="25%" align="left"><span style="font-size:9px;"></span></th>
                     <th width="75%"><span style="font-size:9px;"></span></th>
                 </tr>
                 <tr>
                     <th width="25%" align="left"><span style="font-size:9px; font-weight:bold;">Firma Notificador</span></th>
                     <th width="75%" align="center"><span style="font-size:9px;">: ..........................................................................................................................</span></th>
                 </tr>
                 <tr>
                     <th width="25%" align="left"><span style="font-size:9px; font-weight:bold;">Referencia</span></th>
                     <th width="75%"><span style="font-size:9px;">: ..........................................................................................................................</span></th>
                 </tr>
                 <tr>
                     <th width="25%" align="left"><span style="font-size:9px; font-weight:bold;">N° de suministro de Luz</span></th>
                     <th width="75%"><span style="font-size:9px;">: ..........................................................................................................................</span></th>
                 </tr>
                 <tr>
                     <th width="25%" align="left"><span style="font-size:9px; font-weight:bold;">Correo Electrónico</span></th>
                     <th width="75%" align="left"><span style="font-size:9px;">: .................................................................................... Celular:........................</span></th>
                 </tr>
            </table>';


$pdf->writeHTML($sector_2, true, false, false, false, '');


// Generar el PDF en memoria
$pdfData = $pdf->Output('', 'S'); // 'S' para obtener los datos en una variable
//$ids = implode("-", $_POST['propietarios']);//CONVIERTE EN UN STRING
//$a=$propietarios;
// Ruta donde guardar el PDF (ajusta la ruta según tu proyecto)
$rutaPDF = 'pdfs/mi'.uniqid().'.pdf';

// Guardar el PDF en la ruta especificada
file_put_contents($rutaPDF, $pdfData);

// Devolver la ruta del PDF guardado
echo $rutaPDF;
