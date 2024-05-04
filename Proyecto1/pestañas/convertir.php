<?php
// Función para convertir números a letras
function convertirNumeroALetras($numero) {
    $unidades = array('', 'UNO', 'DOS', 'TRES', 'CUATRO', 'CINCO', 'SEIS', 'SIETE', 'OCHO', 'NUEVE', 'DIEZ', 'ONCE', 'DOCE', 'TRECE', 'CATORCE', 'QUINCE', 'DIECISEIS', 'DIECISIETE', 'DIECIOCHO', 'DIECINUEVE');
    $decenas = array('', '', 'VEINTI', 'TREINTA', 'CUARENTA', 'CINCUENTA', 'SESENTA', 'SETENTA', 'OCHENTA', 'NOVENTA');
    $centenas = array('', 'CIENTO', 'DOSCIENTOS', 'TRESCIENTOS', 'CUATROCIENTOS', 'QUINIENTOS', 'SEISCIENTOS', 'SETECIENTOS', 'OCHOCIENTOS', 'NOVECIENTOS');

    $numero = (int)$numero;

    if ($numero < 20) {
        return $unidades[$numero];
    } elseif ($numero < 100) {
        return $decenas[$numero / 10] . (($numero % 10 != 0) ? ' Y ' . $unidades[$numero % 10] : '');
    } elseif ($numero < 1000) {
        return $centenas[$numero / 100] . (($numero % 100 != 0) ? ' ' . convertirNumeroALetras($numero % 100) : '');
    } elseif ($numero < 1000000) {
        return convertirNumeroALetras($numero / 1000) . ' MIL' . (($numero % 1000 != 0) ? ' ' . convertirNumeroALetras($numero % 1000) : '');
    } elseif ($numero < 1000000000) {
        return convertirNumeroALetras($numero / 1000000) . ' MILLON' . (($numero % 1000000 != 0) ? ' ' . convertirNumeroALetras($numero % 1000000) : '');
    }
}

// Verifica si se ha enviado un monto a convertir
if(isset($_GET['monto'])) {
    $monto = $_GET['monto'];
    // Convierte el monto a letras
    $montoEnLetras = convertirNumeroALetras($monto);
    // Devuelve el resultado
    echo $montoEnLetras;
}
?>