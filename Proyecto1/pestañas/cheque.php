
<?php
require "../conexion/conciliacion.php";

// Iniciar la conexión a la base de datos y obtener la lista de proveedores
try {
    $conexion = new PDO("mysql:host=$host;dbname=$db", $usuario, $pass);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consulta para obtener los proveedores
    $consultaProveedores = $conexion->query("SELECT codigo, nombre FROM proveedores");
    $proveedores = $consultaProveedores->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

try {
    $conexion = new PDO("mysql:host=$host;dbname=$db", $usuario, $pass);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consulta para obtener los objetos de gasto
    $consultaObjetosGasto = $conexion->query("SELECT codigo, detalle FROM objeto_gasto");
    $objetosGasto = $consultaObjetosGasto->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}



function convertirNumeroALetras($numero) {
    $unidades = array('', 'UNO', 'DOS', 'TRES', 'CUATRO', 'CINCO', 'SEIS', 'SIETE', 'OCHO', 'NUEVE', 'DIEZ', 'ONCE', 'DOCE', 'TRECE', 'CATORCE', 'QUINCE', 'DIECISEIS', 'DIECISIETE', 'DIECIOCHO', 'DIECINUEVE');
    $decenas = array('', '', 'VEINTE', 'TREINTA', 'CUARENTA', 'CINCUENTA', 'SESENTA', 'SETENTA', 'OCHENTA', 'NOVENTA');
    $centenas = array('', 'CIEN', 'DOSCIENTOS', 'TRESCIENTOS', 'CUATROCIENTOS', 'QUINIENTOS', 'SEISCIENTOS', 'SETECIENTOS', 'OCHOCIENTOS', 'NOVECIENTOS');

    $millones = floor($numero / 1000000);
    $miles = floor(($numero % 1000000) / 1000);
    $resto = $numero % 1000;

    $resultado = '';

    if ($millones > 0) {
        $resultado .= convertirNumeroALetras($millones) . ' MILLONES ';
    }

    if ($miles > 0) {
        if ($miles == 1) {
            $resultado .= ' MIL ';
        } else {
            $resultado .= convertirNumeroALetras($miles) . ' MIL ';
        }
    }

    if ($resto > 0) {
        if ($resto < 100) {
            $resultado .= convertirDecenasALetras($resto);
        } else {
            $centena = floor($resto / 100);
            $resultado .= $centenas[$centena];
            $resto %= 100;
            if ($resto > 0) {
                $resultado .= ' ' . convertirDecenasALetras($resto);
            }
        }
    }

    return $resultado;
}



function convertirDecenasALetras($numero) {
    $unidades = array('', 'UNO', 'DOS', 'TRES', 'CUATRO', 'CINCO', 'SEIS', 'SIETE', 'OCHO', 'NUEVE', 'DIEZ', 'ONCE', 'DOCE', 'TRECE', 'CATORCE', 'QUINCE', 'DIECISEIS', 'DIECISIETE', 'DIECIOCHO', 'DIECINUEVE');
    $decenas = array('', '', 'VEINTE', 'TREINTA', 'CUARENTA', 'CINCUENTA', 'SESENTA', 'SETENTA', 'OCHENTA', 'NOVENTA');
    $resultado = '';
    if ($numero < 20) {
        $resultado .= $unidades[$numero];
    } else {
        $resultado .= $decenas[$numero / 10];
        if ($numero % 10 != 0) {
            $resultado .= ' Y ' . $unidades[$numero % 10];
        }
    }

    return $resultado;
}


function validarTextoSinEspeciales($input) {
    $texto = $input->value;
    $textoSinEspeciales = preg_replace('/[^a-zA-Z\s]/', '', $texto);

    if ($texto !== $textoSinEspeciales) {
        $input->value = $textoSinEspeciales;
    }
}

function validarCampoNumerico($input) {
    $valor = $input->value;

    // Verificar si el valor es un número válido (positivo) con hasta dos decimales
    if (preg_match('/^[+]?\d+(\.\d{1,2})?$/', $valor)) {
        // El valor es válido (número positivo con hasta dos decimales)
        return true;
    } else {
        // El valor no es válido
        echo "<script>alert('Por favor, ingrese un número válido (positivo) con hasta dos decimales.');</script>";
        $input->value = "";
        return false;
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
    <link rel="stylesheet" href="../CSS/stylesCheque.css">



</head>
<body>
    <header class="header">
        <div class="logo">
            <img src="../img/logopag.jpg" alt="LOGO MARCA">
        </div>
        <nav>
            <ul class="nav-links">
                <li><a href="PaginaG.php" class="btninicio" >Inicio</a></li>
                <li><a href="cheque.php" class="btncheques" >Cheques  </a></li>

                <li class="btnoperaciones">
                    Operaciones Cks
                    <ul class="submenu">
                        <li><a href="../pestañas/anulacion.php">Anulación</a></li>
                        <li><a href="../pestañas/sacarCirculacion.php">Sacar de Circulación</a></li>
                    </ul>
                </li>
                <li><a href="otrastransacciones.php" class="btnotrastrans">Otras transacciones</a></li>
                <li><a href="conciliacion.html" class="btncosiliacion">Conciliación</a></li>
                <li><a href="" class="btnreportes">Reportes</a></li>
                <li><a href="" class="btnmanten">Mantenimiento</a></li>
            </ul>
        </nav>
        <a href="../img/gojo.jpg" class="btn"><button>contact</button></a>

    </header>
    <div class="container">
        <header class="container-header">
            <h1 class="container-title">Creación</h1>
        </header>
        <div class="cheque-form">
        <form id="formulario" method="POST" action="">
            <h2 class="form-title">Cheque</h2>
            <div class="form-group1">
                <label for="numero_cheque"class="numero_cheque" >Número de Cheque:</label>
                <input type="text" id="numero_cheque" name="numero_cheque" onkeypress="return soloNumeros(event)" oninput="validarCampoNumerico()" oninput="validarTextoSinEspeciales()" oninput="validarSinNumeros()" oninput="validarSoloNumeros(this)" maxlength="7">
                <label for="fecha"class="fecha">Fecha:</label>
                <input type="date" id="fecha" name="fecha">
            </div>

            <!-- Opción para los proveedores -->
        <div class="form-group1paguese">
            <label for="paguese" class="paguese">Páguese a la orden de:</label>
            <select name="paguese" id="paguese">
        <?php foreach ($proveedores as $proveedor): ?>
            <option value="<?php echo $proveedor['codigo']; ?>"><?php echo $proveedor['nombre']; ?></option>
        <?php endforeach; ?>
            </select>
        </div>


        <div class="form-group1suma">
            <label for="input-monto" class="form-label">La suma de</label>
        <div class="input-group">
            <input type="text" aria-label="Monto" class="form-control" id="input-monto" placeholder="$" name="input-monto" onkeypress="return soloDecimal(event)" onblur="mostrarMontoEnLetras()" oninput="validarMontos()">
            <input type="text" aria-label="Monto en Letras" class="form-control w-50" id="input-monto-letras" disabled>
        </div>
        </div>

        <!-- Opción para el objeto de gasto -->
            <div class="form-group1detalle">
                <label for="detalle" class="detalle">Detalle:</label>
                <input type="text" id="detalle" name="detalle">
            </div>
            <button  type="submit" class="btn button-custom" id="Grabar" onclick="enviarFormulario()">Grabar</button>
        </div>
        <div class="detalle-form">
    <div class="form-group2">
        <h2 class="form-title2">Objeto de Gasto</h2>
        <div class="field-group">
            <label for="objeto" class="objeto">Objeto:</label>
            <select class="objeto" id="objeto" name="objetoGasto">
                <option value=""></option>
                <?php
                $labels = array(
                    "label1" => "SERVICIOS NO PERSONALES",
                    "label2" => "MATERIALES DE SUMINISTRO",
                    "label3" => "MAQUINARIA Y EQUIPOS"
                );
                foreach ($labels as $key => $label) :
                ?>
                <optgroup label="<?= $label ?>">
                    <?php foreach ($objetosGasto as $objeto): ?>
                        <?php
                        $codigo = $objeto["codigo"];
                        $objetoGasto = substr($codigo, 0, 1);
                        if ($objetoGasto == substr($key, -1)) :
                        ?>
                        <option value="<?= $objeto["codigo"] ?>"><?= $objeto["detalle"] ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </optgroup>
                <?php endforeach; ?>

                <div class="error-container"></div>
                
            </select>
            <label for="monto" class="monto">Monto:</label>
            <input type="text" aria-label="Monto" class="form-control w-50" name="monto" id="monto" oninput="validarMontos()"disabled>
            <button type="reset" class="btn button-custom" id="Nuevo">Nuevo</button>
        </form>
        </div>
    </div>
</div>
                        
</body>


<script>


    function enviarFormulario() {
        // Obtener los datos del formulario
        var formData = new FormData(document.getElementById("formulario"));

        // Enviar los datos mediante AJAX
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "registrar.php", true);
        xhr.onload = function () {
            if (xhr.status == 200) {
                // Mostrar el mensaje de respuesta
                alert(xhr.responseText);
            } else {
                // Manejar errores de conexión
                alert("Error al procesar la solicitud.");
            }
        };
        xhr.send(formData);
    }

function mostrarMontoEnLetras() {
    var monto = document.getElementById("input-monto").value;
    convertirALetras(monto);
}

function convertirALetras(monto) {
    // Llamamos a la función PHP mediante AJAX
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("input-monto-letras").value = this.responseText;
        }
    };
    xhttp.open("GET", "convertir.php?monto=" + monto, true);
    xhttp.send();
}
// Validacion de número de cheque

$(document).ready(function () {
    $("#numCkInput").on("blur", function (event) {

        event.preventDefault();

        var numCheque = $(this).val();

        if (numCheque.trim() !== '') {
            $.ajax({
                url: 'cheque.php',
                type: 'POST',
                data: { numCheque: numCheque },
                success: function (response) {
                    if (response.includes('registrada')) {
                        $('.error-container').html('<div class="alert alert-danger" role="alert">Error: El número de cheque ya existe.</div>');
                        disableFields();
                    } else {
                        $('.error-container').html('<div class="alert alert-success" role="alert">El número de cheque es válido.</div>');
                        enableFields();
                    }
                },
                error: function (xhr, status, error) {
                    console.error(error);
                    $('.error-container').html('<div class="alert alert-danger" role="alert">Error al conectar con el servidor</div>');
                }
            });
        } else {
            $('.error-container').html('<div class="alert alert-danger" role="alert">Error: número de cheque no recibido.</div>');
        }
    });
});

// Validación de montos

$(document).ready(function () {
    $("form").submit(function (event) {

        event.preventDefault();

        $.ajax({
            url: 'cheque.php',
            type: 'POST',
            data: $(this).serialize(), // Serializa los datos del formulario
            success: function (response) {
                if (response.includes('diferente')) {
                    $('.error-container').html('<div class="alert alert-danger" role="alert">Error: La suma de y Monto no coinciden.</div>');
                    $('#fecha').attr('disabled', 'disabled'); // Reemplazado 'fecha-input' con 'fecha'
                    $('#paguese').attr('disabled', 'disabled'); // Reemplazado 'inputOrden' con 'paguese'
                    $('#input-monto').val(''); // Vaciar el campo 'input-monto'
                    $('#detalle').attr('disabled', 'disabled'); // Reemplazado 'inputDetalle' con 'detalle'
                    $('#objeto').attr('disabled', 'disabled'); // Reemplazado 'inputObjeto' con 'objeto'
                    $('#monto').val(''); // Vaciar el campo 'monto'
                } else if (response.includes('vacio')) {
                    $('.error-container').html('<div class="alert alert-danger" role="alert">Llene todos los campos.</div>');
                }
            },
            error: function (xhr, status, error) {
                console.error(error);
                $('.error-container').html('<div class="alert alert-danger" role="alert">Error al conectar con el servidor</div>');
            }
        });
    });
});


function validarTextoSinEspeciales(input){
var text = input.value

}

function validarSoloNumeros(input){
inpu.value = input.value.replace(/\D/g,'');
}



function validarSinNumeros(input){
var texto = input.value;
var textoSinNumeros = texto.replace(/[0-9]/, '');
if(texto !== textoSinNumeros){
    input.value = textoSinNumeros; 
}
}


function soloLetras(evento) {
    var code = (evento.which) ? evento.which : evento.keycode;
    if (code == 8 || code == 32) {
        return true;
    } else if (code >= 65 && code <= 90 || code >= 97 && code <= 122) {
        return true;
    } else {
        return false;
    }
}

// * Función para restringir letras de campos números
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