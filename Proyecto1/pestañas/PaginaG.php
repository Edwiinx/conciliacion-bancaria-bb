<!DOCTYPE html>
<hthtjgml Lang="en">
<!-- PAGINA PRINCIPAL -->



<!--ESTE SI ESQUELETO-->
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatibler" content="IEwedge">
    <meta name ="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina</title>
    <link rel="stylesheet" href="../CSS/styles.css">
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

                <li><a href="conciliacion.html" class="btnconsiliacion">Conciliación</a></li>

                <li><a href="" class="btnreportes">Reportes</a></li>

                <li><a href="" class="btnmanten">Mantenimiento</a></li>
            </ul>
        </nav>
        <a href="" class="btn"><button>contact</button></a>
        
    </header>

    <section class="hero">
        <div class="hero-content">

            <h1>Bienvenido a Nuestro Sitio Web</h1>

            <p>Descubre todo lo que tenemos para ofrecerte</p>

        </div>
   

        <footer>
            <!-- Pie de página con información de contacto y enlaces adicionales -->
        </footer>

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