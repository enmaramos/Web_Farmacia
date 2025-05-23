// Arreglo para almacenar los productos del carrito
let carrito = [];

function agregarAlCarrito() {
    const nombreProducto = document.querySelector('#nombreProducto').value;
    const laboratorio = document.querySelector('#laboratorio').value;
    const unidad = document.querySelector('#unidad').value;
    const presentacion = document.querySelector('#presentacion').value;

    const dosisSelect = document.querySelector('#dosis');
    let dosis = dosisSelect.value;
    const opcionSeleccionadaTexto = dosisSelect.options[dosisSelect.selectedIndex].text.trim().toLowerCase();

    // Filtramos todas las opciones válidas (que no sean vacías ni la opción por defecto)
    const opcionesValidas = Array.from(dosisSelect.options).filter(opt => 
        opt.value.trim() !== '' && !opt.text.trim().toLowerCase().startsWith('seleccione')
    );

    // Validación específica para la dosis
    if (opcionSeleccionadaTexto.startsWith('seleccione')) {
        if (opcionesValidas.length > 0) {
            // Hay otras opciones, mostrar alerta
            Swal.fire({
                icon: 'warning',
                title: 'Dosis no seleccionada',
                text: 'Por favor, seleccione una dosis válida.',
                confirmButtonColor: '#d33'
            });
            dosisSelect.focus();
            return;
        } else {
            // No hay más opciones, se guarda un guion
            dosis = '-';
        }
    }

    const precio = parseFloat(document.querySelector('#precio').value);
    const cantidad = parseInt(document.querySelector('#cantidad').value);

    const imagenProducto = document.querySelector('#imagenProducto').src;
    const nombreImagen = imagenProducto.split('/').pop();
    const rutaImagen = '../../dist/assets/img-medicamentos/' + nombreImagen;

    const nombreCliente = document.querySelector('#nombreCliente').value;
    const cedulaCliente = document.querySelector('#cedulaCliente').value;

    // Validación general de campos del producto
    if (
        !nombreProducto || !laboratorio ||
        !unidad || !presentacion ||
        isNaN(precio) || isNaN(cantidad) || cantidad <= 0
    ) {
        Swal.fire({
            icon: 'warning',
            title: 'Campos incompletos',
            text: 'Por favor, complete todos los campos del producto correctamente.',
            confirmButtonColor: '#d33'
        });
        return;
    }

    // Validación de datos del cliente
    if (!nombreCliente || !cedulaCliente) {
        Swal.fire({
            icon: 'warning',
            title: 'Datos del cliente faltantes',
            text: 'Por favor, complete los campos del cliente.',
            confirmButtonColor: '#d33'
        });
        return;
    }

    // Verificar si ya existe un producto con la misma presentación, dosis y unidad
    const yaExiste = carrito.some(producto =>
        producto.presentacion.trim().toLowerCase() === presentacion.trim().toLowerCase() &&
        producto.dosis.trim().toLowerCase() === dosis.trim().toLowerCase() &&
        producto.unidad.trim().toLowerCase() === unidad.trim().toLowerCase()
    );

    if (yaExiste) {
        Swal.fire({
            icon: 'info',
            title: 'Producto duplicado',
            text: 'Ya existe un producto con la misma presentación, dosis y formato en el carrito.',
            confirmButtonColor: '#3085d6'
        });
        return;
    }

    // Crear el objeto producto
    const producto = {
        nombreProducto,
        laboratorio,
        unidad,
        presentacion,
        dosis,
        precio,
        cantidad,
        imagen: rutaImagen,
        clienteNombre: nombreCliente,
        clienteCedula: cedulaCliente
    };

    // Agregar al carrito
    carrito.push(producto);

    // Actualizar el contador del carrito
    actualizarContador();

    // Mostrar mensaje de éxito
    mostrarNotificacion(rutaImagen, nombreProducto);
}






// Función para mostrar la notificación de producto agregado
function mostrarNotificacion(imagen, nombreProducto) {
    const notificacion = document.getElementById('notificacion');
    const icono = notificacion.querySelector('.imagen-icono'); // Seleccionamos el elemento donde se mostrará la imagen
    const texto = notificacion.querySelector('span'); // Seleccionamos el texto de la notificación

    // Establecemos la imagen del producto en el icono
    icono.src = imagen;
    texto.textContent = `El producto "${nombreProducto}" se agregó al carrito de compras.`;  // Cambiamos el texto

    // Mostrar la notificación
    notificacion.classList.add('show');
    notificacion.style.display = 'flex';

    // Ocultar la notificación después de 3 segundos
    setTimeout(function () {
        notificacion.classList.remove('show'); // Remover la animación
        notificacion.style.display = 'none';
    }, 4000);
}


// Función para actualizar el contador del carrito
function actualizarContador() {
    document.getElementById('contadorCarrito').textContent = carrito.length;
}

// Función para mostrar el carrito en el modal
function mostrarCarrito() {
    const modalCarrito = document.getElementById('mostarCarrito');
    const contenidoCarrito = modalCarrito.querySelector('.modal-body');
    contenidoCarrito.innerHTML = ''; // Limpiar el contenido previo

    let totalGeneral = 0;

    carrito.forEach((producto, index) => {
        const totalProducto = producto.precio * producto.cantidad;
        totalGeneral += totalProducto;

        const productoHTML = `
        <div class="d-flex justify-content-between align-items-center">
            <!-- Imagen del producto -->
            <img src="${producto.imagen}" alt="${producto.nombreProducto}" class="img-fluid" style="width: 100px;">
            
            <div class="flex-grow-1 ms-3">
                <h5 class="fw-bold text-primary mb-1">${producto.nombreProducto}</h5>

                <h6 class="fw-bold text-primary">Precio unitario: C$${producto.precio.toFixed(2)}</h6>
    
                <!-- Solo muestra Presentación si tiene un valor válido -->
                ${producto.presentacion && producto.presentacion !== "Seleccione una opción" ?
                `<p class="mb-1"><strong>Presentación:</strong> ${producto.presentacion}</p>` : ''}
                
                <!-- Solo muestra Dosis si tiene un valor válido -->
                ${producto.dosis && producto.dosis !== "Seleccione una opción" ?
                `<p class="mb-1"><strong>Dosis:</strong> ${producto.dosis}</p>` : ''}
                
                <!-- Solo muestra Formato si tiene un valor válido -->
                ${producto.unidad && producto.unidad !== "Seleccione una opción" ?
                `<p class="mb-1"><strong>Formato:</strong> ${producto.unidad}</p>` : ''}

                <div class="d-flex align-items-center mt-1">
                    <button class="btn btn-outline-primary btn-sm" onclick="updateQuantity(${index}, -1)">-</button>
                    <input type="text" class="form-control mx-2 text-center" value="${producto.cantidad}" style="width: 40px;" readonly>
                    <button class="btn btn-outline-primary btn-sm" onclick="updateQuantity(${index}, 1)">+</button>
                </div>
            </div>
    
            <div class="d-flex flex-column align-items-end">
                <span class="fw-bold text-success mb-2">Subtotal: C$${totalProducto.toFixed(2)}</span>
                <button class="btn btn-danger btn-sm" onclick="removeProduct(${index})">🗑</button>
            </div>
        </div>
        <hr>
    `;



        contenidoCarrito.insertAdjacentHTML('beforeend', productoHTML);
    });

    document.getElementById('grandTotal').textContent = `C$${totalGeneral.toFixed(2)}`;

    // Mostrar el modal
    const modal = bootstrap.Modal.getOrCreateInstance(modalCarrito);
    modal.show();

}

// Función para actualizar la cantidad de un producto en el carrito
function updateQuantity(index, cantidadCambio) {
    const producto = carrito[index];
    producto.cantidad += cantidadCambio;

    // Evitar que la cantidad sea menor a 1
    if (producto.cantidad < 1) producto.cantidad = 1;

    // Volver a mostrar el carrito
    mostrarCarrito();
}

// Función para eliminar un producto del carrito
function removeProduct(index) {
    carrito.splice(index, 1); // Eliminar el producto del carrito
    actualizarContador(); // Actualizar el contador
    mostrarCarrito(); // Volver a mostrar el carrito
}

// Event Listener para el botón de agregar al carrito
document.querySelector('#btnAgregar').addEventListener('click', agregarAlCarrito);

// Event Listener para el ícono del carrito
document.querySelector('.carrito-icono').addEventListener('click', mostrarCarrito);


////////////////////////////////////////////////////////AQUI INICIA MODAL PAGOS/////////////////////////////////////////////////////////////////////

function abrirMetodoPago() {
    if (carrito.length === 0) {
        Swal.fire({
            icon: 'warning',
            title: 'Carrito vacío',
            text: 'No hay productos en el carrito para facturar.',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Entendido'
        });
        return;
    }

    const total = carrito.reduce((sum, producto) => sum + producto.precio * producto.cantidad, 0);
    document.getElementById('totalPagar').value = `C$${total.toFixed(2)}`;

    const modalCarrito = bootstrap.Modal.getInstance(document.getElementById('mostarCarrito'));
    modalCarrito.hide();

    const modalPago = new bootstrap.Modal(document.getElementById('modalMetodoPago'));
    modalPago.show();

    const inputMonto = document.getElementById('montoRecibido');
    const inputCambio = document.getElementById('vueltoCliente');
    const monedaSelect = document.getElementById('monedaSeleccionada');

    const TASA_CAMBIO = 36.80;

    function calcularCambio() {
        const totalCordobas = parseFloat(document.getElementById('totalPagar').value.replace('C$', '').trim()) || 0;
        const recibido = parseFloat(inputMonto.value.trim()) || 0;
        const moneda = monedaSelect.value;

        let recibidoEnCordobas = recibido;

        // Convertir a córdobas si la moneda es dólares
        if (moneda === 'US$') {
            recibidoEnCordobas = recibido * TASA_CAMBIO;
        }

        const cambio = recibidoEnCordobas - totalCordobas;

        // Mostrar siempre el vuelto en córdobas
        inputCambio.value = cambio >= 0 ? `C$${cambio.toFixed(2)}` : 'C$0.00';
    }

    // Listeners
    inputMonto.removeEventListener('input', calcularCambio);
    monedaSelect.removeEventListener('change', calcularCambio);
    inputMonto.addEventListener('input', calcularCambio);
    monedaSelect.addEventListener('change', calcularCambio);

    calcularCambio();
}


// Limpiar los campos al cerrar el modal de método de pago
document.getElementById('modalMetodoPago').addEventListener('hidden.bs.modal', function () {
    document.getElementById('montoRecibido').value = '';
    document.getElementById('vueltoCliente').value = '';
});

function volverAlCarrito() {
    // Cerrar el modal de Método de Pago
    const metodoPagoModal = bootstrap.Modal.getInstance(document.getElementById('modalMetodoPago'));
    if (metodoPagoModal) metodoPagoModal.hide();

    // Mostrar el modal del carrito
    const carritoModal = new bootstrap.Modal(document.getElementById('mostarCarrito'));
    carritoModal.show();
}





////////////////////////////////////////////////////////AQUI INICIA FACTURA/////////////////////////////////////////////////////////////////////

//////llamado al modal factura///////

// 👇 Esta variable ahora debe ser insertada desde PHP antes de cargar este script




let numeroFacturaActual = ''; // Variable global

function generarNumeroRecibo() {
    const prefijo = 'N505';
    const claveStorage = 'ultimoNumeroRecibo';

    return fetch('../pages/Ctrl/obtener_ultimo_numero_factura.php') // Asegúrate que esta ruta sea correcta
        .then(response => response.json())
        .then(data => {
            if (data.exito && data.numeroFactura) {
                const nuevoNumero = data.numeroFactura;
                localStorage.setItem(claveStorage, nuevoNumero); // Guarda en localStorage si quieres usarlo luego
                numeroFacturaActual = nuevoNumero; // Actualiza tu variable global
                return nuevoNumero;
            } else {
                throw new Error('No se pudo obtener el número de factura.');
            }
        })
        .catch(error => {
            console.error('Error al generar número de recibo:', error);
            const fallback = `${prefijo}-0001`;
            numeroFacturaActual = fallback;
            return fallback; // En caso de fallo, usa número por defecto
        });
}

// Puedes invocarla donde la necesites así:
generarNumeroRecibo().then(numero => {
    console.log('Número generado:', numero);
    // Aquí puedes seguir con otras tareas como cargar la factura
});





async function alpargar() {
    const total = parseFloat(document.getElementById('totalPagar').value.replace('C$', '').trim()) || 0;
    const recibidoRaw = parseFloat(document.getElementById('montoRecibido').value.trim()) || 0;
    const moneda = document.getElementById('monedaSeleccionada').value;
    const TASA_CAMBIO = 36.80;

    // Convertir a córdobas si se pagó en dólares
    const recibido = moneda === 'US$' ? recibidoRaw * TASA_CAMBIO : recibidoRaw;

    if (recibido < total) {
        Swal.fire({
            icon: 'error',
            title: 'Pago insuficiente',
            text: 'El monto recibido no puede ser menor al total a pagar.',
            confirmButtonColor: '#d33',
            confirmButtonText: 'Revisar'
        });
        return;
    }

    const metodoPagoModal = bootstrap.Modal.getInstance(document.getElementById('modalMetodoPago'));
    if (metodoPagoModal) metodoPagoModal.hide();

    const clienteNombre = carrito[0]?.clienteNombre || 'Cliente Genérico';
    const clienteCedula = carrito[0]?.clienteCedula || '000-000000-0000X';
    const clienteId = document.getElementById('idClienteSeleccionado').value.trim();
    const fecha = new Date().toLocaleString();

    if (!clienteId) {
        Swal.fire({
            icon: 'error',
            title: 'Faltan los datos del cliente',
            text: 'Por favor, selecciona un cliente antes de continuar.',
            confirmButtonColor: '#d33',
            confirmButtonText: 'Revisar'
        });
        return;
    }

    document.getElementById('facturaIDCliente').value = clienteId;
    document.getElementById('facturaFecha').textContent = fecha;
    document.getElementById('facturaCliente').textContent = `${clienteNombre} (${clienteCedula})`;

    const tabla = document.getElementById('tablaFacturaProductos');
    tabla.innerHTML = '';

    let totalFactura = 0;
    carrito.forEach(producto => {
        const subtotal = producto.precio * producto.cantidad;
        totalFactura += subtotal;

        const fila = `
            <tr>
                <td>${producto.nombreProducto}</td>
                <td class="dosis">${producto.dosis || ''}</td>
                <td>${producto.cantidad}</td>
                <td>C$${producto.precio.toFixed(2)}</td>
                <td>C$${subtotal.toFixed(2)}</td>
            </tr>
        `;
        tabla.innerHTML += fila;
    });

    document.getElementById('facturaTotal').textContent = totalFactura.toFixed(2);
    document.getElementById('facturaMetodoPago').textContent = document.getElementById('metodoPago').value;
    document.getElementById('facturaVuelto').textContent = document.getElementById('vueltoCliente').value;
    document.getElementById('facturaMontoRecibido').textContent = recibidoRaw.toFixed(2); // Mostrar lo que el cliente entregó (no convertido)

    try {
        const numeroGenerado = await generarNumeroRecibo();
        numeroFacturaActual = numeroGenerado;
        document.getElementById('facturaNumeroRecibo').textContent = numeroFacturaActual;
    } catch (error) {
        console.error('Error al obtener número de factura:', error);
        document.getElementById('facturaNumeroRecibo').textContent = 'N505-0001';
    }

    document.getElementById('facturaVendedor').textContent = vendedorLogueado;

    const facturaModal = new bootstrap.Modal(document.getElementById('modalFactura'));
    facturaModal.show();
}



async function imprimirFactura() {
    const facturaModalElem = document.getElementById('modalFactura');
    const facturaModal = bootstrap.Modal.getInstance(facturaModalElem);
    if (facturaModal) {
        facturaModal.hide();
    }

    function formatearFechaParaBD(fechaStr) {
        const partes = fechaStr.split(',');
        if (partes.length !== 2) {
            throw new Error('Formato de fecha no reconocido. Asegúrate que sea DD/MM/YYYY, HH:mm:ss');
        }

        const fechaPartes = partes[0].trim().split('/');
        if (fechaPartes.length !== 3) {
            throw new Error('Formato de fecha no reconocido. Asegúrate que sea DD/MM/YYYY');
        }

        const dia = fechaPartes[0].padStart(2, '0');
        const mes = fechaPartes[1].padStart(2, '0');
        const anio = fechaPartes[2];
        const hora = partes[1].trim();

        return `${anio}-${mes}-${dia} ${hora}`;
    }

    const fechaTexto = document.getElementById('facturaFecha').textContent.trim();
    let fechaFormateada;
    try {
        fechaFormateada = formatearFechaParaBD(fechaTexto);
    } catch (error) {
        alert(error.message);
        return;
    }

    if (!numeroFacturaActual) {
        try {
            numeroFacturaActual = await generarNumeroRecibo();
        } catch (error) {
            console.error('Error al generar número de factura:', error);
            numeroFacturaActual = 'N505-0001';
        }
    }

    const numeroReciboGenerado = numeroFacturaActual;

    const datosFactura = {
        numero_factura: numeroReciboGenerado,
        fecha: fechaFormateada,
        metodo_pago: document.getElementById('facturaMetodoPago').textContent.trim(),
        subtotal: document.getElementById('facturaTotal').textContent.replace('C$', '').trim(),
        total: document.getElementById('facturaTotal').textContent.replace('C$', '').trim(),
        monto_pagado: document.getElementById('facturaMontoRecibido').textContent.replace('C$', '').replace('US$', '').trim(),
        cambio: document.getElementById('facturaVuelto').textContent.replace('C$', '').replace('US$', '').trim(),
        cliente: document.getElementById('facturaCliente').textContent.trim(),
        vendedor: document.getElementById('facturaVendedor').textContent.trim(),
        ID_Cliente: document.getElementById('facturaIDCliente').value,
        ID_Usuario: document.getElementById('facturaIDUsuario').value
    };

    if (!datosFactura.numero_factura || !datosFactura.fecha || !datosFactura.cliente || !datosFactura.vendedor) {
        alert("Faltan datos importantes para generar la factura.");
        return;
    }

    // Obtener símbolo de moneda actual
    const monedaSeleccionada = document.getElementById('monedaSeleccionada')?.value || 'C$';
    const monedaSimbolo = monedaSeleccionada === 'US$' ? 'US$' : 'C$';

    fetch('../pages/Ctrl/guardar_factura.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(datosFactura)
    })
    .then(response => response.json())
    .then(result => {
        if (!result.success) {
            Swal.fire({
                icon: 'error',
                title: 'Error al guardar factura',
                text: result.message
            });
            return;
        }

        Swal.fire({
            icon: 'success',
            title: 'Factura guardada exitosamente',
            timer: 1500,
            showConfirmButton: false
        }).then(() => {
            const logoURL = '../assets/images-html/farmacia_batahola_circulo_sin_fondo.jpg';
            const facturaContenido = `
                <div style="font-family: monospace; font-size: 12px; width: 250px; position: relative;">
                    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;
                        background-image: url('${logoURL}');
                        background-size: contain;
                        background-repeat: no-repeat;
                        background-position: center;
                        opacity: 0.85; z-index: 0;"></div>
                    <div style="position: relative; z-index: 1;
                        background-color: rgba(255, 255, 255, 0.53);
                        padding: 20px 10px; border-radius: 5px;">
                        <div style="display: flex; justify-content: space-between; font-size: 12px; margin-bottom: 8px;">
                            <div><strong>Fecha:</strong> ${fechaTexto}</div>
                            <div><strong>Recibo N°:</strong> ${numeroReciboGenerado}</div>
                        </div>
                        <div style="text-align: center; font-size: 18px; font-weight: bold; margin-bottom: 5px;">FACTURA</div>
                        <center>
                            <div style="font-size: 14px; font-weight: bold;">Farmacia Batahola</div>
                            Dirección: Managua, Nicaragua<br>
                            Tel: 8888-8888<br>
                            -------------------------------<br>
                            Cliente: ${datosFactura.cliente}<br>
                            Vendedor: ${datosFactura.vendedor}<br>
                            -------------------------------<br>
                        </center>
                        <table style="width: 100%; font-size: 12px; margin-top: 5px;">
                            <thead>
                                <tr>
                                    <th style="text-align: left;">Prod</th>
                                    <th style="text-align: left;">Dosis</th>
                                    <th style="text-align: center;">Cant</th>
                                    <th style="text-align: right;">P.U</th>
                                    <th style="text-align: right;">SubT</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${Array.from(document.querySelectorAll('#tablaFacturaProductos tr')).map(row => {
                                    const cols = row.querySelectorAll('td');
                                    const dosisText = cols[1].textContent.trim();
                                    const dosisMostrada = !dosisText || dosisText === 'Seleccione Dosis' || dosisText === 'Seleccione una opción' ? '-' : dosisText;
                                    return `
                                        <tr>
                                            <td>${cols[0].textContent}</td>
                                            <td style="text-align: center;">${dosisMostrada}</td>
                                            <td style="text-align: right;">${cols[2].textContent}</td>
                                            <td style="text-align: right;">${cols[3].textContent}</td>
                                            <td style="text-align: right;">${cols[4].textContent}</td>
                                        </tr>`;
                                }).join('')}
                            </tbody>
                        </table>
                        -------------------------------<br>
                        <strong>Total:</strong> C$${datosFactura.total}<br>
                        <strong>Pago:</strong> ${datosFactura.metodo_pago}<br>
                        <strong>Monto Recibido:</strong> ${monedaSimbolo}${datosFactura.monto_pagado}<br>
                        <strong>Vuelto:</strong> C$${datosFactura.cambio}<br>
                        -------------------------------<br>
                        <center>¡Gracias por su compra!</center>
                    </div>
                </div>
            `;

            const ventana = window.open('', '', 'width=500,height=600');
            ventana.document.write(`
                <html>
                    <head>
                        <title>Factura</title>
                        <style>
                            @media print {
                                @page { size: auto; margin: 10mm; }
                                body { font-family: Arial, sans-serif; }
                            }
                        </style>
                    </head>
                    <body onload="window.print(); window.close();">
                        ${facturaContenido}
                    </body>
                </html>
            `);
            ventana.document.close();

            const chequearVentanaCerrada = setInterval(() => {
                if (ventana.closed) {
                    clearInterval(chequearVentanaCerrada);
                    location.reload();
                }
            }, 500);

            numeroFacturaActual = '';
        });
    })
    .catch(error => {
        console.error('Error en fetch:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error de conexión',
            text: 'No se pudo conectar con el servidor.'
        });
    });
}






function volverAlMetodoPago() {
    const facturaModal = bootstrap.Modal.getInstance(document.getElementById('modalFactura'));
    if (facturaModal) facturaModal.hide();

    const metodoPagoModal = new bootstrap.Modal(document.getElementById('modalMetodoPago'));
    metodoPagoModal.show();
}


