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

// * Función para validar el campo de cedula
function cedulaVal(evento) {
  var code = (evento.which) ? evento.which : evento.keycode;
  if (code == 8) {
      return true;
  } else if (code == 45 || code >= 48 && code <= 57) {
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


function mostrarMontoEnLetras() {
    var monto = document.getElementById("input-monto").value;
    var parteEntera = Math.floor(monto);
    var parteDecimal = Math.round((monto - parteEntera) * 100);
    var montoEnLetras = numeroALetras(parteEntera) + ' balboas con ' + (parteDecimal < 10 ? '0' : '') + parteDecimal + '/100';
    document.getElementById("input-monto-letras").value = montoEnLetras;
}

	
function validarTextoSinEspeciales(input) {
    var texto = input.value;
    var textoSinEspeciales = texto.replace(/[^a-zA-Z\s]/g, '');

    if (texto !== textoSinEspeciales) {
    input.value = textoSinEspeciales;
    
    }
}

function validarCampoNumerico(input) {
    var valor = input.value;

    // Verificar si el valor es un número válido (positivo) con hasta dos decimales
    if (/^[+]?\d+(\.\d{1,2})?$/.test(valor)) {
        // El valor es válido (número positivo con hasta dos decimales)
        return true;
    } else {
        // El valor no es válido
        alert("Por favor, ingrese un número válido (positivo) con hasta dos decimales.");
        input.value = "";
        return false;
    }
}

function validarEntrada(input) {
    // Obtener el valor actual del campo
    var valor = input.value;

    // Eliminar caracteres no numéricos
    var valorNumerico = valor.replace(/[^\d]/g, '');

    // Asignar el valor numérico al campo
    input.value = valorNumerico;
}

function validarSinNumeros(input) {
    var texto = input.value;
    var textoSinNumeros = texto.replace(/[0-9]/g, '');

    if (texto !== textoSinNumeros) {
        input.value = textoSinNumeros;
    }
}

function validarSoloNumeros(input) {
    input.value = input.value.replace(/\D/g, '');
}

// Función para validar que un campo no esté en blanco
function validarNoVacio(input) {
    var nombre1 = document.getElementById("nombre1").value;
    var apellido1 = document.getElementById("apellido1").value;

    if (nombre1 === "" || apellido1 === "") {
        alert("Nombre 1 y Apellido 1 son campos obligatorios.");
        return;
    }
}

function mostrarNombreCompleto() {
    // Obtener los valores de los campos de nombres y apellidos
    var nombre1 = document.getElementById("nombre1").value;
    var nombre2 = document.getElementById("nombre2").value;
    var apellido1 = document.getElementById("apellido1").value;
    var apellido2 = document.getElementById("apellido2").value;
    var usaApellidoCasada = document.getElementById("usaApellidoCasada").value;
    var apellidoCasadaInput = document.getElementById("apellidoCasadaInput").value;

    // Combinar los valores en un solo campo
    var nombreCompleto = nombre1 + " " + nombre2 + " " + apellido1 + " " + apellido2;

    if (usaApellidoCasada === "si" && apellidoCasadaInput.trim() !== "") {
        nombreCompleto += " de " + apellidoCasadaInput;
    }

    // Mostrar el nombre completo en el campo de salida
    document.getElementById("nombreCompleto").value = nombreCompleto;
}












//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

















// * Función para grabar cheques
function grabarCheques(event) {

	event.preventDefault();

	let form_data = new FormData(document.getElementById("cheques-form"));

	var xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function () {
		if (xhr.readyState === 4 && xhr.status === 200) {
			try {
				var response = JSON.parse(xhr.responseText);
				console.log(response);
				if (response.success) {
					console.log('Respuesta del servidor:', response.mensaje);
					$('.error-container').html('<div class="alert alert-success" role="alert">' + response.mensaje + '</div>');
				} else {
					console.error('Error en el servidor:', response.error);
					$('.error-container').html('<div class="alert alert-danger" role="alert">' + response.error + '</div>');
				}
			} catch (e) {
				console.error('Error al analizar la respuesta del servidor:', e);
			}
		}
	};
	xhr.open('POST', 'logica_cheque.php', true);
	xhr.send(form_data);
}

// * Función para validar el número del cheque
function validarNumCheque() {
	let numCheque = document.getElementById("numCkInput").value.trim();
	console.log(numCheque);
	if (numCheque !== "") {
		console.log(numCheque);
		$.ajax({
			type: 'POST',
			url: 'logica_cheque.php',
			dataType: 'json', // Especifica que esperamos una respuesta JSON
			data: { numCheque: numCheque },
			success: function (response) {
				try {
					if (response.successNumCk) {
						// El número de cheque es válido
						$('.error-container').html('<div class="alert alert-success" role="alert">' + response.mensajeNumCk + '</div>');
						enableFields();
					} else {
						$('.error-container').html('<div class="alert alert-danger" role="alert"> ' + response.mensajeNumCk + ' </div>');
						disableFields();
					}
				} catch (error) {
					console.error('Error al analizar la respuesta JSON:', error);
					$('.error-container').html('<div class="alert alert-danger" role="alert">Error al analizar la respuesta del servidor</div>');
					disableFields();
				}
			},
			error: function (xhr, status, error) {
				$('.error-container').html('<div class="alert alert-danger" role="alert">Error al conectar con el servidor</div>');
				disableFields();
			}
		});
	} else {
		// Error: número de cheque no recibido
		$('.error-container').html('<div class="alert alert-danger" role="alert">Error: número de cheque no recibido.</div>');
		disableFields();
	}
}

// ! ======================================== 			Sección Anulación de Cheque 				==============================================
// * Función para grabar Anulación
function grabarAnulacion(event) {
	event.preventDefault();
	let fecha_anulacion = document.getElementById("fecha-anulada").value;
	let detalle_anulacion = document.getElementById("detalle-anulacion").value;
	// Crear un objeto FormData con los campos necesarios para la actualización
	let formData = new FormData(document.getElementById("anulacion-form"));

	if (fecha_anulacion === '' || detalle_anulacion === '') {
		$('#mensaje-cliente').html('<div class="alert alert-warning" role="alert"> ⚠️ Llene todos los campos.</div>');
	}

	// Realizar la solicitud AJAX
	var xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function () {
		if (xhr.readyState === 4 && xhr.status === 200) {
			try {
				// Analizar la respuesta JSON del servidor
				var response = JSON.parse(xhr.responseText);

				if (response.success) {
					// Mostrar mensaje de éxito si se completó la actualización
					console.log('Cheque anulado correctamente:', response.mensaje);
					$('#mensaje-cliente').html('<div class="alert alert-success" role="alert">' + response.mensaje + '</div>');
				} else {
					// Mostrar mensaje de error si hubo problemas en la actualización
					console.error('Error en el servidor:', response.mensaje || 'Error desconocido');
					$('#mensaje-cliente').html('<div class="alert alert-danger" role="alert">' + (response.mensaje || 'Error desconocido') + '</div>');
				}
			} catch (e) {
				console.error('Error al analizar la respuesta del servidor:', e);
				$('#mensaje-cliente').html('<div class="alert alert-danger" role="alert">Error al analizar la respuesta del servidor</div>');
			}
		} else {
			// Manejo de errores HTTP
			console.error('Error HTTP:', xhr.status, xhr.statusText);
			$('#mensaje-cliente').html('<div class="alert alert-danger" role="alert">Error en la solicitud HTTP</div>');
		}
	};
	// Configurar la solicitud AJAX como POST
	xhr.open('POST', 'logica_grabarAnulacion.php', true);
	// Enviar los datos de los campos para la actualización
	xhr.send(formData);
}

// * Función para validar número de Cheque
function validarCkAnulacion() {
	let numeroCheque = document.getElementById("num-cheque-input").value.trim();
	if (numeroCheque !== "") {
		$.ajax({
			type: 'POST',
			url: 'logica_validarAnulacion.php',
			dataType: 'json',
			data: { numeroCheque: numeroCheque },
			success: function (response) {
				try {
					if (response.successCirculacion && response.successAnulado) {
						// El número de cheque es válido
						$('#mensaje-cliente').html('<div class="alert alert-success" role="alert">' + response.mensajeNumCk + '</div>');
						llenarCampos(response);
						disableFields();
					} else {
						$('#mensaje-cliente').html('<div class="alert alert-danger" role="alert">' + response.mensajeNumCk + '</div>');
					}
				} catch (error) {
					console.error('Error al analizar la respuesta JSON:', error);
					$('#mensaje-cliente').html('<div class="alert alert-danger" role="alert">Error al analizar la respuesta del servidor</div>');
				}
			},
			error: function (xhr, status, error) {
				console.error('Error al conectar con el servidor:', error);
				$('#mensaje-cliente').html('<div class="alert alert-danger" role="alert">Error al conectar con el servidor</div>');
			}
		});
	} else {
		// Error: número de cheque no recibido
		$('#mensaje-cliente').html('<div class="alert alert-danger" role="alert">Error: número de cheque no recibido.</div>');
	}
}



// ! ======================================== 			Sección Sacar de Circulación 				==============================================
function validarCkCirculacion() {
	let numeroCheque = document.getElementById("num-cheque-input").value.trim();
	if (numeroCheque !== "") {
		$.ajax({
			type: 'POST',
			url: 'logica_validarCirculacion.php',
			dataType: 'json',
			data: { numeroCheque: numeroCheque },
			success: function (response) {
				try {
					if (response.successCirculacion && response.successAnulado) {
						// El número de cheque es válido
						$('#mensaje-cliente').html('<div class="alert alert-success" role="alert">' + response.mensajeNumCk + '</div>');
						llenarCampos(response);
						disableFields();
					} else {
						$('#mensaje-cliente').html('<div class="alert alert-danger" role="alert">' + response.mensajeNumCk + '</div>');
						$('#fecha-circulacion').attr('disabled', 'disabled');
					}
				} catch (error) {
					console.error('Error al analizar la respuesta JSON:', error);
					$('#mensaje-cliente').html('<div class="alert alert-danger" role="alert">Error al analizar la respuesta del servidor</div>');
				}
			},
			error: function (xhr, status, error) {
				console.error('Error al conectar con el servidor:', error);
				$('#mensaje-cliente').html('<div class="alert alert-danger" role="alert">Error al conectar con el servidor</div>');
			}
		});
	} else {
		// Error: número de cheque no recibido
		$('#mensaje-cliente').html('<div class="alert alert-danger" role="alert">Error: número de cheque no recibido.</div>');
	}
}

function grabarCirculacion(event) {
	event.preventDefault();
	let fecha_circulacion = document.getElementById("fecha-circulacion").value;

	// Crear un objeto FormData con los campos necesarios para la actualización
	let formData = new FormData(document.getElementById("circulacion-form"));

	if (fecha_circulacion === '') {
		$('#mensaje-cliente').html('<div class="alert alert-warning" role="alert"> ⚠️ Llene todos los campos.</div>');
	}

	// Realizar la solicitud AJAX
	var xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function () {
		if (xhr.readyState === 4 && xhr.status === 200) {
			try {
				// Registrar la respuesta completa del servidor
				console.log('Respuesta completa del servidor:', xhr.responseText);

				// Analizar la respuesta JSON del servidor
				var response = JSON.parse(xhr.responseText);

				if (response.success) {
					// Mostrar mensaje de éxito si se completó la actualización
					console.log('Cheque anulado correctamente:', response.mensaje);
					$('#mensaje-cliente').html('<div class="alert alert-success" role="alert">' + response.mensaje + '</div>');
				} else {
					// Mostrar mensaje de error si hubo problemas en la actualización
					console.error('Error en el servidor:', response.mensaje || 'Error desconocido');
					$('#mensaje-cliente').html('<div class="alert alert-danger" role="alert">' + (response.mensaje || 'Error desconocido') + '</div>');
				}
			} catch (e) {
				console.error('Error al analizar la respuesta del servidor:', e);
				$('#mensaje-cliente').html('<div class="alert alert-danger" role="alert">Error al analizar la respuesta del servidor</div>');
			}
		} else {
			// Manejo de errores HTTP
			console.error('Error HTTP:', xhr.status, xhr.statusText);
			$('#mensaje-cliente').html('<div class="alert alert-danger" role="alert">Error en la solicitud HTTP</div>');
		}
	};
	// Configurar la solicitud AJAX como POST
	xhr.open('POST', 'logica_grabarCirculacion.php', true);
	// Enviar los datos de los campos para la actualización
	xhr.send(formData);
}


// ! ======================================== 			Sección Otras Transacciones 				==============================================
function grabarOtrasTransacciones(event) {

	event.preventDefault();

	let form_data = new FormData(document.getElementById("otras-transacciones-form"));

	var xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function () {
		if (xhr.readyState === 4 && xhr.status === 200) {
			try {
				var response = JSON.parse(xhr.responseText);
				if (response.success) {
					console.log('Respuesta del servidor:', response.mensaje);
					$('.error-container').html('<div class="alert alert-success" role="alert">' + response.mensaje + '</div>');
				} else {
					console.error('Error en el servidor:', response.error);
					$('.error-container').html('<div class="alert alert-danger" role="alert">' + response.error + '</div>');
				}
			} catch (e) {
				console.error('Error al analizar la respuesta del servidor:', e);
			}
		}
	};
	xhr.open('POST', 'logica_otrasTransacciones.php', true);
	xhr.send(form_data);
}

// ! ======================================== 			Sección Conciliación 			==============================================
function realizarConciliacion() {
	let mes = document.getElementById("inputMeses").value;
	let anio = document.getElementById("inputAnio").value;
	if (mes !== "" || anio !== "") {
		$.ajax({
			type: 'POST',
			url: 'logica_conciliacion.php',
			dataType: 'json',
			data: { meses: mes, anio: anio },
			success: function (response) {
				try {
					if (response.success) {
						// El número de cheque es válido
						$('#mensaje-cliente').html('<div class="alert alert-warning" role="alert">' + response.mensaje + '</div>');
						llenarLabels(response);
						llenarConciliacionRegistrada(response);
						$("#inputSaldoBanco").attr('disabled', 'disabled');
					} else {
						$('#inputSaldoBanco').removeAttr('disabled');
						if (response.successConciliacion) {
							$('#mensaje-cliente').html('<div class="alert alert-success" role="alert">' + response.mensajeConciliacion + '</div>');
							llenarLabels(response);
							vaciarCamposConciliacion();
							llenarConciliacion(response);
							calcularSubtotales();
						} else {
							$('#mensaje-cliente').html('<div class="alert alert-danger" role="alert">' + response.mensajeConciliacion + '</div>');
							vaciarCamposConciliacion();
							vaciarLabels();
							$("#inputSaldoBanco").attr('disabled', 'disabled');
						}
					}

				} catch (error) {
					console.error('Error al analizar la respuesta JSON:', error);
					$('#mensaje-cliente').html('<div class="alert alert-danger" role="alert">❗Error al analizar la respuesta del servidor</div>');
				}
			},
			error: function (xhr, status, error) {
				console.error('Error al conectar con el servidor:', error);
				$('#mensaje-cliente').html('<div class="alert alert-danger" role="alert">❌ Error al conectar con el servidor</div>');
			}
		});
	} else {
		$('#mensaje-cliente').html('<div class="alert alert-warning" role="alert">⚠️ Ingrese la fecha antes de realizar la conciliacion </div>')
		$('#inputSaldoBanco').attr('disabled', 'disabled');
	}
}


// ! ========================================		Sección Funciones	Complementarias		==============================================

function resetMensaje() {
	const mensajeCliente = document.getElementById('mensaje-cliente');
	mensajeCliente.innerHTML = '';
	vaciarLabels();
}

// * Esta funcón llena los campos del formulario (Anulación y Circulación) con los datos recibidos.
function llenarCampos(response) {
	$('#fecha-input').val(response.fecha);
	$('#inputOrden').val(response.beneficiario);
	$('#inputMonto').val(response.monto);
	$('#inputDetalle').val(response.descripcion);
	$('#fecha-anulada').val(response.fecha_anulado);
}

// * Esta función llena los inputs con los valores del objeto response.
function llenarConciliacionRegistrada(response) {
	$('#inputSaldoLibro').val(response.saldo_anterior);
	$('#inputDeposito').val(response.mas_depositos);
	$('#inputChequesAnulados').val(response.mas_cheques_anulados);
	$('#inputNotasCredito').val(response.mas_notas_credito);
	$('#inputAjustesLibro').val(response.mas_ajustes_libro);
	$('#inputSubtotal').val(response.sub_primera);
	$('#inputSubtotalFinal').val(response.subtotal_primera);
	$('#inputCkGirados').val(response.menos_cheques_girados);
	$('#inputNotasDebito').val(response.menos_notas_debito);
	$('#inputAjusteCkGirados').val(response.menos_ajustes_libro);
	$('#inputSubtotalMenosLibros').val(response.sub_segunda);
	$('#inputSaldoConsiliadoLibros').val(response.saldo_libros);
	$('#inputSaldoBanco').val(response.saldo_banco);
	$('#inputDepositoTransito').val(response.mas_depositos_transito);
	$('#inputChequesCirculacion').val(response.menos_cheques_circulacion);
	$('#inputAjusteBanco').val(response.mas_ajustes_banco);
	$('#inputSubtotalMenosBanco').val(response.sub_tercero);
	let sub3 = parseFloat($('#inputSubtotalMenosBanco').val());
	let sub3Formateado = formatearNumeroNegativo(sub3);
	parseFloat($('#inputSubtotalMenosBanco').val(sub3Formateado));
	$('#inputSaldoConsiliadoBanco').val(response.saldo_conciliado);
}

function llenarLabels(response) {
	// Obtener fechas de las variables de respuesta
	var dia = response.dia;
	var mes_libro = response.mes_libro;
	var dia_actual = response.dia_actual;
	var mes_actual = response.mes_actual;
	var anio_anterior = response.anio_anterior;
	var anio = response.anio;

	// Desplegar las fechas en los labels correspondientes
	$('#labelSaldoLibro').html(`<strong>SALDO SEGÚN LIBRO AL ${dia} de ${mes_libro} de ${anio_anterior}</strong>`);
	$('#labelSaldoConsiliadoLibros').html(`<strong>SALDO CONCILIADO SEGÚN LIBROS AL ${dia_actual} de ${mes_actual} de ${anio}</strong>`);
	$('#labelSaldoBanco').html(`<strong>SALDO EN BANCO AL ${dia_actual} de ${mes_actual} de ${anio}</strong>`);
	$('#labelSaldoConsiliadoBanco').html(`<strong>SALDO CONCILIADO IGUAL A BANCO AL ${dia_actual} de ${mes_actual} de ${anio}</strong>`);
}

function vaciarLabels() {
	// Vaciar los labels seleccionando cada uno por su ID 
	$('#labelSaldoLibro').html(`<strong>SALDO SEGÚN LIBRO AL</strong>`);
	$('#labelSaldoConsiliadoLibros').html(`<strong>SALDO CONCILIADO SEGÚN LIBROS AL</strong>`);
	$('#labelSaldoBanco').html(`<strong>SALDO EN BANCO AL</strong>`);
	$('#labelSaldoConsiliadoBanco').html(`<strong>SALDO CONCILIADO IGUAL A BANCO AL</strong>`);
}


function vaciarCamposConciliacion() {
	// Vaciar los campos de entrada seleccionando cada uno por su ID y estableciendo su valor en una cadena vacía ('')
	$('#inputSaldoLibro').val('');
	$('#inputDeposito').val('');
	$('#inputChequesAnulados').val('');
	$('#inputNotasCredito').val('');
	$('#inputAjustesLibro').val('');
	$('#inputSubtotal').val('');
	$('#inputSubtotalFinal').val('');
	$('#inputCkGirados').val('');
	$('#inputNotasDebito').val('');
	$('#inputAjusteCkGirados').val('');
	$('#inputSubtotalMenosLibros').val('');
	$('#inputSaldoConsiliadoLibros').val('');
	$('#inputSaldoBanco').val('');
	$('#inputDepositoTransito').val('');
	$('#inputChequesCirculacion').val('');
	$('#inputAjusteBanco').val('');
	$('#inputSubtotalMenosBanco').val('');
	$('#inputSaldoConsiliadoBanco').val('');
}

function llenarConciliacion(response) {
	$('#inputSaldoLibro').val(response.saldo_anterior);
	$('#inputDeposito').val(response.mas_depositos);
	$('#inputChequesAnulados').val(response.mas_cheques_anulados);
	$('#inputNotasCredito').val(response.mas_notas_credito);
	$('#inputAjustesLibro').val(response.mas_ajustes_libro);
	$('#inputCkGirados').val(response.menos_cheques_girados);
	$('#inputNotasDebito').val(response.menos_notas_debito);
	$('#inputAjusteCkGirados').val(response.menos_ajustes_libro);
	$('#inputDepositoTransito').val(response.mas_depositos_transito);
	$('#inputChequesCirculacion').val(response.menos_cheques_circulacion);
	$('#inputAjusteBanco').val(response.mas_ajustes_banco);
}

function calcularSubtotales() {
	// ! Obtener saldo conciliado
	let saldo_conciliado_anterior = parseFloat($('#inputSaldoLibro').val());

	// ! Sección 1
	let input_deposito = parseFloat($('#inputDeposito').val());
	let input_cks_anulado = parseFloat($('#inputChequesAnulados').val());
	let input_notas_credito = parseFloat($('#inputNotasCredito').val());
	let input_ajuste_libro = parseFloat($('#inputAjustesLibro').val());
	let sub1 = input_deposito + input_cks_anulado + input_notas_credito + input_ajuste_libro;
	$('#inputSubtotal').val(sub1);
	let subtotal_primera = saldo_conciliado_anterior + sub1;
	$('#inputSubtotalFinal').val(subtotal_primera);

	// ! Sección 2
	let input_cks_girados = parseFloat($('#inputCkGirados').val());
	let input_notas_debito = parseFloat($('#inputNotasDebito').val());
	let input_ajuste_cks_girados = parseFloat($('#inputAjusteCkGirados').val());
	let sub2 = input_cks_girados + input_notas_debito + input_ajuste_cks_girados;
	$('#inputSubtotalMenosLibros').val(sub2);
	let subtotal_segunda = subtotal_primera - sub2;
	$('#inputSaldoConsiliadoLibros').val(subtotal_segunda);

	// ! Sección 3
	let input_deposito_transito = parseFloat($('#inputDepositoTransito').val());
	let input_cks_circulacion = parseFloat($('#inputChequesCirculacion').val());
	let input_ajuste_banco = parseFloat($('#inputAjusteBanco').val());

	let sub3 = input_deposito_transito - input_cks_circulacion + input_ajuste_banco;
	let sub3Formateado = formatearNumeroNegativo(sub3);
	$('#inputSubtotalMenosBanco').val(sub3Formateado);

	let input_saldo_banco = 0;
	document.getElementById("inputSaldoBanco").addEventListener("blur", function () {
		input_saldo_banco = parseFloat($('#inputSaldoBanco').val());
		let sub_tercero = parseFloat(sub3 + input_saldo_banco);
		$('#inputSaldoConsiliadoBanco').val(sub_tercero);
	});
}

function formatearNumeroNegativo(valor) {
	// Convertir el valor a número
	let numero = parseFloat(valor);

	// Si el número es negativo, devolverlo entre paréntesis
	if (numero < 0) {
		return `(${Math.abs(numero).toFixed(2)})`;
	}
	// Si no es negativo, devolver el número normalmente
	return numero.toFixed(2);
}