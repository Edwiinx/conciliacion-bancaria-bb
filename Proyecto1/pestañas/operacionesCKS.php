<!DOCTYPE html>
<html lang="en">
<!--cosas-->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Operaciones Cks</title>
    <link rel="stylesheet" href="../Proyecto 1/CSS/styles.css">
</head>
<body>
    <header class="header">
        <div class="logo">
            <img src="../Proyecto 1/img/logopag.jpg" alt="LOGO MARCA">
        </div>
        <nav>
            <ul class="nav-links">
                <li><a href="PaginaG.html" class="btninicio" >Inicio</a></li>
                <li><a href="cheque.html" class="btncheques" >Cheques  </a></li>

                <li><a href="operacionesCKS.html" class="btnoperaciones">Operaciones Cks</a></li>

                <li><a href="otrastransacciones.html" class="btnotrastrans">Otras transacciones</a></li>

                <li><a href="consiliacion.html" class="btnconsiliacion">Consiliacion</a></li>

                <li><a href="" class="btnreportes">Reportes</a></li>

                <li><a href="" class="btnmanten">Mantenimiento</a></li>
            </ul>
        </nav>
        <a href="" class="btn"><button>contact</button></a>
        
    </header> 


</body>
<script>
    function cargarContenido(url) {
        // Realiza una solicitud HTTP para obtener el contenido de la URL
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Si la solicitud es exitosa, coloca el contenido en el área de contenido
                    document.getElementById('contenido').innerHTML = xhr.responseText;
                } else {
                    // Maneja el caso de error
                    console.error('Error al cargar el contenido:', xhr.status);
                }
            }
        };
        xhr.open('GET', url, true);
        xhr.send();
    }
</script>
</html>