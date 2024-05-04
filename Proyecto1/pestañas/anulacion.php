<?php require "../conexion/conciliacion.php" ?>


<?php
 
// Consulta SQL para desplegar el nombre del beneficiario
$proveedores = $conexion->query("SELECT * FROM proveedores");

$numero_cheque = "";
$fecha = "";
$beneficiario = "";
$monto = "";
$descripcion = "";
$fecha_anulado = "";
$detalle_anulado = "";
$error = null;
$correcto = null;

// Manejo del formulario de anulación
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $default_date = "0000-00-00";

  if (isset($_POST["numeroCheque"]) && isset($_POST['anular'])) {
    $numero_cheque = $_POST["numeroCheque"];
    $fecha_anulado = $_POST["fechaAnulado"];
    $detalle_anulado = $_POST["detalle_anulado"];

    try {
      // Actualizar la base de datos
      $stmt = $conexion->prepare("UPDATE cheques SET fecha_anulado = :fecha_anulado, detalle_anulado = :detalle_anulado WHERE numero_cheque = :numero_cheque");
      $stmt->bindParam(':fecha_anulado', $fecha_anulado);
      $stmt->bindParam(':detalle_anulado', $detalle_anulado);
      $stmt->bindParam(':numero_cheque', $numero_cheque);

      if ($stmt->execute()) {
        $correcto = "El cheque se ha anulado correctamente.";
      } else {
        $error = "Error al anular el cheque.";
      }
    } catch(PDOException $e) {
      $error = "Error al anular el cheque: " . $e->getMessage();
    }
  }
}

// Manejo del formulario principal
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['anular'])) {
  if (isset($_POST["numeroCheque"])) {
    $numero_cheque = $_POST["numeroCheque"];
    $statement = $conexion->prepare("SELECT * FROM cheques WHERE numero_cheque = :numero_cheque");
    $statement->bindParam(':numero_cheque', $numero_cheque);
    $statement->execute();

    if ($statement->rowCount() > 0) {
      $ckRow = $statement->fetch(PDO::FETCH_ASSOC);
      $fecha = $ckRow["fecha"];
      $beneficiario = $ckRow["beneficiario"];
      $monto = $ckRow["monto"];
      $descripcion = $ckRow["descripcion"];

      // Validar la fecha de circulación
      $row_circulacion = $ckRow["fecha_circulacion"];
      if (is_null($row_circulacion) || $row_circulacion == $default_date) {
        $correcto = "✅ El cheque es válido.";
      } else {
        $error = "❗El cheque está fuera de circulación";
      }

      // Obtener la fecha de anulación
      $row_anulado = $ckRow["fecha_anulado"];
      if (is_null($row_anulado) || $row_anulado == $default_date) {
        $correcto = "✅ El cheque es válido.";
      } else {
        $error = "❗El cheque está anulado";
        $fecha_anulado = $row_anulado;
      }
    } else {
      $error = "❌ El número de cheque no existe.";
    }
  }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cheque</title>
    <link rel="stylesheet" href="../CSS/styles.css">
    <link rel="stylesheet" href="../CSS/stylesAnul.css">


    <style>
    
    </style>
</head>
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
        <header class="container-header">
        <form action="" class="border border-secondary-subtle rounded" method="POST">
            <h1 class="container-title">Anulación de Cheques</h1>
        </header>
        <div class="cheque-form">
            
            <div class="form-group1">
            <label for="num_cheque" class="numero_cheque">Número de Cheque:</label>
            
            <input type="text" class="form-control" autocomplete="off" name="numeroCheque" id="numeroCheque" value="<?= $numero_cheque ?>" onkeypress="return soloNumeros(event)" maxlength="7">

            <button type="submit" class="btn button-custom" id="buscar" name="buscar">Buscar</button>

            </div>

            <div>
                <label for="fecha"class="fecha">Fecha:</label>
                <input type="date" name="fecha" id="fecha" class="form-control" value="<?= $fecha ?>" disabled>
            </div>

            <div class="form-group1paguese">
                <label for="paguese"class="paguese">Páguese a la orden de:</label>
                <select class="form-select" id="paguese" name="paguese" disabled>

              <?php if($proveedores->rowCount() > 0):?>

                <?php while ($consultaProveedores = $proveedores->fetch(PDO::FETCH_ASSOC)): 

                  $codigo = $consultaProveedores["codigo"];

                  $nombre = $consultaProveedores["nombre"];
                ?>
                  <?php if($codigo == $beneficiario):?>

                    <option><?= $nombre ?></option>

                  <?php endif ?>
                <?php endwhile ?>
              <?php endif ?>

            </select>
            </div>
            <div class="form-group1suma">
                <label for="suma"class="suma">La suma de:</label>
                <input type="text" aria-label="First name" class="form-control" name="suma" id="suma" placeholder="$" value="<?= $monto ?>" disabled>
                
            </div>
            <div class="form-group1gasto">
                <label for="Descripcion" class="Descripcion">Descripción :</label>
                <input type="text" class="form-control" id="Descripcion" name="Descripcion" placeholder="" disabled value="<?= $descripcion ?>">
            </div>
        </div>


        <div class="detalle-form">
        <div class="form-group2">
        <div class="field-group">
            <label for="fecha-input" class="form-label">Fecha de Anulación</label>
            <?php if($error): ?>
                <input type="date" name="fechaAnulado" id="fecha_a" class="form-control" value="<?= $fecha_anulado ?>" disabled> 
            <?php else: ?>
                <input type="date" name="fechaAnulado" id="fecha_a" class="form-control" >
            <?php endif ?>
        </div>

        <div class="field-group">
            <label for="floatingTextarea2" class="form-label">Detalle de la Anulación</label>
            <?php if($error): ?>
                <input class="form-control" placeholder="" id="d_anulacion" name="detalle_anulado"  disabled>
            <?php else: ?>
                <input class="form-control" placeholder="" id="d_anulacion" name="detalle_anulado" ></input>
            <?php endif ?>
    </div>
</div>

        <div class="d-grid gap-2 d-md-flex justify-content-md-center pt-5" id="btn-custom-container">
        <?php if(!empty($fecha_anulado) || $error): ?>
        <button type="submit" class="btn button-custom" id="anular" name="anular" disabled>Anular</button>
    <?php else: ?>
        <button type="submit" class="btn button-custom" id="anular" name="anular">Anular</button>
    <?php endif ?>
         <br> 




          <!-- Mensaje de error al usuario -->
      <?php if ($error): ?>

<div class="error-container alert alert-danger" role="alert"><?= $error ?></div>
<?php elseif ($correcto): ?>

<div class="correcto-container alert alert-success" role="alert"><?= $correcto ?></div>
<?php endif ?>


                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</body>

<script>

function soloNumeros(evento) {
    var code = (evento.which) ? evento.which : evento.keycode;
    if (code == 8) {
        return true;
    } else if (code >= 48 && code <= 57) {
        return true;
    } else {
        return false;
    }
}




</script>





</html>