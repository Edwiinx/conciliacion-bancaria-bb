<?php
// Incluir el archivo de conexión
require "../conexion/conciliacion.php";

// Consultas SQL para obtener transacciones de la base de datos
$queryTransaccionesLibros = $conexion->query("SELECT * FROM transacciones LIMIT 5");
$queryTransaccionesBanco = $conexion->query("SELECT * FROM transacciones LIMIT 2 OFFSET 5");
$queryTransaccionesTransferencia = $conexion->query("SELECT * FROM transacciones LIMIT 2 OFFSET 7");

// Variables para manejar mensajes de error y éxito
$error = null;
$correcto = null;

// Verificar si la solicitud es de tipo POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger datos del formulario
    $transaccion = $_POST["transaccion"];
    $fecha_transaccion = $_POST["fecha"];
    $monto_transaccion = $_POST["monto_otrasT"];

    // Verificar si algún campo está vacío
    if (empty($transaccion) || empty($fecha_transaccion) || empty($monto_transaccion)) {
        $error = "⚠️ Llene todos los campos";
    } else {
        // Preparar la declaración SQL para insertar datos en la tabla "otros"
        $statement = $conexion->prepare("INSERT INTO otros (transaccion, fecha, monto) VALUES (:transaccion, :fecha_transaccion, :monto_transaccion)");
        $statement->bindParam(':transaccion', $transaccion);
        $statement->bindParam(':fecha_transaccion', $fecha_transaccion);
        $statement->bindParam(':monto_transaccion', $monto_transaccion);
        
        try {
            // Ejecutar la declaración de inserción
            $statement->execute();
            $correcto = "✅ Se registró exitosamente la transacción";
        } catch (PDOException $e) {
            // Capturar y mostrar errores en la inserción
            $error = "❌ Error al registrar transacción: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<hthtjgml Lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatibler" content="IEwedge">
        <meta name ="viewport" content="width=device-width, initial-scale=1.0">
        <title>Otras transacciones</title>
        <link rel="stylesheet" href="../CSS/styles.css">
        <link rel="stylesheet" href="../CSS/stylesOT.css">
      </head>


<!-- PAGINA PRINCIPAL -->
<style>
   
</style>

  <body>
    <header class="header">
        <div class="logo">
            <img src="../img/logopag.jpg" alt="LOGO MARCA">
        </div>
        <nav>
            <ul class="nav-links">
                <li><a href="PaginaG.html" class="btninicio" >Inicio</a></li>
                <li><a href="cheque.php" class="btncheques" >Cheques  </a></li>

               
                <li class="btnoperaciones">
                    Operaciones Cks
                    <ul class="submenu">
                        <li><a href="../pestañas/anulacion.php">Anulación</a></li>
                        <li><a href="../pestañas/sacarCirculacion.php">Sacar de Circulación</a></li>
                       
                    </ul>
                </li>

                <li><a href="otrastransacciones.php" class="btnotrastrans">Otras transacciones</a></li>

                <li><a href="conciliacion.html" class="btnconsiliacion">Conciliación</a></li>

                <li><a href="" class="btnreportes">Reportes</a></li>

                <li><a href="" class="btnmanten">Mantenimiento</a></li>
            </ul>
        </nav>
        <a href="" class="btn"><button>contact</button></a>

    </header>





    <div class="container">
        <form action="" class="border border-secondary-subtle rounded" method="POST">
        <header class="container-header">
            <h1 class="container-title">Otras Transacciones - Depósitos, Ajustes y Notas (Db / Cr)</h1>
        </header>



        <div class="cheque-form">
            <div class="form-group1">
                <label for="transaccion"class="numero_cheque">Transacción:</label>
                <select class="form-select" aria-label="Transacciones" id="transaccion" name="transaccion">
                <option value=""></option>
          <optgroup label="LIBROS">
            <?php while ($row = $queryTransaccionesLibros->fetch(PDO::FETCH_ASSOC)) : ?>
              <option value="<?= $row["codigo"] ?>"> <?= $row["detalle"] ?> </option>
            <?php endwhile ?>
          </optgroup>
          <optgroup label="BANCO">
            <?php while ($row = $queryTransaccionesBanco->fetch(PDO::FETCH_ASSOC)) : ?>
              <option value="<?= $row["codigo"] ?>"> <?= $row["detalle"] ?> </option>
            <?php endwhile ?>
          </optgroup>
          <optgroup label="TRANSFERENCIA">
            <?php while ($row = $queryTransaccionesTransferencia->fetch(PDO::FETCH_ASSOC)) : ?>
              <option value="<?= $row["codigo"] ?>"> <?= $row["detalle"] ?> </option>
            <?php endwhile ?>
          </optgroup>
            </select>
              
            </div>
          
            <div class="form-group1monto_otrasT">
                <label for="fecha"class="fecha">Fecha:</label>
                <input type="date" id="fecha" name="fecha">
                <label for="monto_otrasT"class="monto_otrasT">Monto:</label>
                <input type="text" id="monto_otrasT" name="monto_otrasT" onkeypress="return soloDecimal(event)">
                </div>

              <button type="submit" name="Grabar" id="Grabar">Grabar</button>
              <button type="reset" name="Nuevo" id="Nuevo">Nuevo</button>
  
              <div>
                     </div>
                     <?php if ($error): ?>
        <div class="error-container alert alert-danger" role="alert"><?= $error ?></div>
    <?php elseif ($correcto): ?>
        <div class="correcto-container alert alert-success" role="alert"><?= $correcto ?></div>
    <?php endif ?>
</div>

                                 </div>
                                        </div>
</form>


        
</div>

  </body>

  <script>

// * Función acepta punto decimal en los campos de decimales
function soloDecimal(evento) {
    var code = (evento.which) ? evento.which : evento.keycode;
    if (code == 8) {
        return true;
    } else if (code == 46 || code >= 48 && code <= 57) {
        return true;
    } else {
        return false;
    }
}




</script>

</html>