<?php
// Incluir la biblioteca TCPDF
require_once('tcpdf_include.php');

$pdf = new TCPDF();

// Configurar el PDF
$pdf->SetMargins(10, 10, 10);
$pdf->AddPage();

// Capturar la tabla HTML por su clase (en este caso, "miprimeratabla")
$html = '<table>' . file_get_contents('path/to/recaudacion-estadocuenta.php') . '</table';

// Utilizar una biblioteca externa para manipular HTML, por ejemplo, DOMDocument
$dom = new DOMDocument();
$dom->loadHTML($html);

// Buscar la tabla por su clase
$tables = $dom->getElementsByTagName('table');
$capturedTable = null;

foreach ($tables as $table) {
    if ($table->hasAttribute('class') && $table->getAttribute('class') === 'miprimeratabla') {
        $capturedTable = $dom->saveHTML($table);
        break; // Detener la búsqueda una vez que se encuentra la primera tabla con la clase especificada
    }
}

if (!is_null($capturedTable)) {
    // Escribir el contenido HTML en el PDF
    $pdf->writeHTML($capturedTable, true, false, true, false, '');
    
    // Generar el PDF y mostrarlo en el navegador
    $pdf->Output('tabla_datos.pdf', 'I');
} else {
    // No se encontró la tabla con la clase especificada
    echo 'No se encontró una tabla con la clase "miprimeratabla".';
}
?>
