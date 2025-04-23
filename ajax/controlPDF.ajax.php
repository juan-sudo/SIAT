<?php
$directorio = '../vistas/print/pdfs'; // Reemplaza 'ruta_de_la_carpeta' por la ruta de la carpeta que deseas limpiar

$archivos = glob($directorio . '/*'); // Obtén una lista de todos los archivos en la carpeta

foreach ($archivos as $archivo) {
    if (is_file($archivo)) {
        unlink($archivo); // Elimina el archivo
    }
}
http_response_code(200); // Responde con un código 200 (éxito)
?>
