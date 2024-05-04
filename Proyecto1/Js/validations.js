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


function loadPage(page) {
    fetch(page)
        .then(response => response.text())
        .then(html => {
            document.getElementById('mainContent').innerHTML = html;
        })
        .catch(error => console.error('Error al cargar la página:', error));
}
