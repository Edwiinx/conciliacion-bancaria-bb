<?php
// Definir una variable para almacenar el mensaje
$mensaje = "";

// Verifica si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica si las claves están presentes en el array $_POST antes de acceder a ellas
    if(isset($_POST['numero_cheque']) && !empty($_POST['numero_cheque'])) {
        $numcheque = $_POST['numero_cheque'];
    } else {
        // Manejo de error si numCheque no está presente en $_POST o está vacío
        $mensaje = "Error: número de cheque no recibido o vacío.";
    }

    if(empty($mensaje)) {
        // Si no hay error con el número de cheque, procede con la inserción en la base de datos
        $fechacheque = isset($_POST['fecha']) ? $_POST['fecha'] : "";
        $ordenpago = isset($_POST['paguese']) ? $_POST['paguese'] : "";
        $suma = isset($_POST['input-monto']) ? $_POST['input-monto'] : "";
        $detallesu = isset($_POST['detalle']) ? $_POST['detalle'] : "";
        $Objetoo1 = isset($_POST['objetoGasto']) ? $_POST['objetoGasto'] : "";
        $Montoo1 = isset($_POST['monto']) ? $_POST['monto'] : "";

        // Realiza la conexión a la base de datos
        include "../conexion/conciliacion.php";

        // Prepara la consulta SQL para insertar los datos en la base de datos
        $insertar = "INSERT INTO cheques(numero_cheque, fecha, beneficiario, monto, descripcion, codigo_objeto1, monto_objeto1) 
        VALUES ('$numcheque','$fechacheque','$ordenpago','$suma','$detallesu','$Objetoo1','$Montoo1')";

        try {
            // Ejecuta la consulta
            if ($conexion->query($insertar)) {
                // Si la inserción fue exitosa, muestra un mensaje de éxito
                $mensaje = "El cheque se ha registrado correctamente.";
            } else {
                // Si hubo un error al insertar, muestra un mensaje de error
                $mensaje = "Error al registrar en la base de datos.";
            }
        } catch (PDOException $e) {
            // Verifica si se produjo una excepción de clave duplicada
            if ($e->getCode() == '23000' && $e->errorInfo[1] == 1062) {
                // Genera un mensaje para clave duplicada
                $mensaje = "El cheque con número $numcheque ya está registrado.";
            } else {
                // Otro tipo de error
                $mensaje = "Error al registrar en la base de datos: " . $e->getMessage();
            }
        }
    }
}
?>

<?php if (!empty($mensaje)) : ?>
   <?php echo $mensaje; ?>
<?php endif; ?>