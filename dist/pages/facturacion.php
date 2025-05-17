<?php
session_start();
include_once "Ctrl/head.php";

?>





<?php
include_once "Ctrl/menu.php";
?>

<!--ESTILOS DE CAJA-->
<style>
    .contenedor {
        max-width: 1200px;
        margin: 20px auto;
        padding: 40px;
        background: #ffff;
        border-radius: 10px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        position: relative;
        min-height: 700px;
    }

    .row {
        margin: 0 -10px;
    }

    .col-md-5,
    .col-md-2 {
        padding: 0 55px;
    }

    .form-control,
    .form-select {
        margin-bottom: 15px;
    }

    .carrito-container {
        position: absolute;
        top: 20px;
        right: 20px;
        display: flex;
        align-items: center;
    }

    .carrito-icono {
        background-color: #007bff;
        color: white;
        padding: 10px;
        border-radius: 50%;
        cursor: pointer;
        font-size: 1.5rem;
        margin-left: 10px;
    }

    .carrito-contenedor {
        background-color: red;
        color: white;
        padding: 5px 10px;
        border-radius: 50%;
        font-size: 1rem;
        font-weight: bold;
    }

    #btnAgregar {
        position: absolute;
        bottom: 20px;
        left: 50%;
        transform: translateX(-35%);
        width: auto;
    }

    /* Cuadro para la imagen del producto */
    .img-container {
        width: 200px;
        /* Ajusta el tamaño del cuadro */
        height: 200px;
        border: 2px dashed #ccc;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        text-align: center;
        padding: 10px;
    }

    .img-container img {
        max-width: 100%;
        max-height: 80%;
        object-fit: contain;
    }

    #imagenProducto {
        width: 95%;
        height: auto;
        /* Mantiene la proporción de la imagen */
        object-fit: cover;
        /* Asegura que la imagen cubra el espacio sin distorsionarse */
        display: block;
        /* Elimina los márgenes y paddings que puedan haber */
        margin: 0 auto;
        /* Centra la imagen dentro de su contenedor */
    }


    .modal-dialog {
        max-width: 80%;
        /* Limita el tamaño máximo del modal */
    }


    /* Ajustar el tamaño de los inputs "Requiere Receta" y "Vencimiento" */
    .extra-inputs {
        width: 200px;
        /* Mismo ancho que el cuadro de la imagen */
    }

    .requiere-receta-advertencia {
        background-color: #ffcccc;
        /* Fondo rojo claro para advertencia */
        color: #a94442;
        /* Color del texto en rojo oscuro */
        border: 1px solid #a94442;
        /* Borde rojo oscuro */
    }

    .modal-dialog {
        display: flex;
        align-items: center;
        min-height: calc(100% - 1rem);
    }

    .modal.fade .modal-dialog {
        transition: transform 0.3s ease-out;
    }

    .modal.show .modal-dialog {
        transform: translate(0, 0);
    }
</style>

<!-- CONTENEDOR DE CAJA -->
<div class="contenedor  mx-auto">
    <div class="d-flex justify-content-between align-items-center">
        <div class="carrito-container ">
            <div class="carrito-contenedor" id="contadorCarrito">0</div>
            <div id="abircarrirto" class="carrito-icono" onclick="mostrarCarrito()">🛒</div>
        </div>
    </div>

    <div class="row">
        <!-- Sección de productos -->
        <div class="col-md-5">
            <h4>Buscar Producto</h4>

            <!-- Botón para abrir cuadro de búsqueda -->
            <button type="button" id="btnBuscarProducto" class="btn btn-info form-control">
                <i class="fas fa-search"></i> Buscar
            </button>

            <label>Nombre del Producto</label>
            <input type="text" id="nombreProducto" class="form-control" readonly>

            <label>Laboratorio o Marca</label>
            <input type="text" id="laboratorio" class="form-control" readonly>

            <label>Formato del producto</label>
            <select id="unidad" class="form-select">
                <option value="">Seleccione Unidad</option>
            </select>

            <label>Presentación</label>
            <select id="presentacion" class="form-select">
                <option value="">Seleccione Presentación</option>
            </select>

            <label>Dosis</label>
            <select id="dosis" class="form-select">
                <option value="">Seleccione Dosis</option>
            </select>

            <label>Precio</label>
            <input type="text" id="precio" class="form-control" readonly>

            <label>Cantidad</label>
            <input type="number" id="cantidad" class="form-control">
        </div>

        <!-- Sección de imagen y detalles adicionales -->
        <div class="col-md-2 d-flex flex-column align-items-center">
            <div class="img-container">
                <img id="imagenProducto" src="default.jpg" alt="Imagen del producto" style="max-width: 100%;">
            </div>

            <label>Requiere Receta</label>
            <input type="text" id="requiereReceta" class="form-control extra-inputs" readonly>

            <label>Vencimiento</label>
            <input type="text" id="vencimiento" class="form-control extra-inputs" readonly>

            <label>Descripcion</label>
            <textarea id="descripcion" class="form-control extra-inputs" readonly></textarea>
        </div>

        <!-- Sección de clientes -->
        <div class="col-md-5">
            <h4>Buscar Cliente</h4>

            <div class="d-flex align-items-center mb-3">
                <!-- Checkbox cliente aleatorio -->
                <div class="form-check me-3">
                    <input class="form-check-input" type="checkbox" id="clienteAleatorio">
                    <label class="form-check-label" for="clienteAleatorio">Cliente Aleatorio</label>
                </div>

                <!-- Botón agregar cliente -->
                <button type="button" id="btnAgregarCliente" class="btn btn-info me-2" data-bs-toggle="modal" data-bs-target="#modalAgregarCliente">
                    <i class="fa-solid fa-user-plus"></i>
                </button>
            </div>

            <!-- Input con icono de búsqueda -->
            <div class="input-group mb-3">
                <span class="input-group-text" id="buscarClienteIcon" style="height: calc(2.25rem + 2px); padding-top: 0.375rem; padding-bottom: 0.375rem;">
                    <i class="fa-solid fa-magnifying-glass" style="font-size: 16px;"></i>
                </span>
                <input type="text" id="buscarCliente" class="form-control" placeholder="Escriba el nombre del cliente..." style="height: calc(2.25rem + 2px); padding-left: 5px;">
            </div>

            <!-- Contenedor para mostrar los resultados de la búsqueda -->
            <div id="resultadosBusqueda" class="list-group" style="max-height: 150px; overflow-y: auto; display: none;"></div>

            <label for="nombreCliente">Nombre del Cliente</label>
            <input type="text" id="nombreCliente" class="form-control" readonly>

            <label for="cedulaCliente">Cédula</label>
            <input type="text" id="cedulaCliente" class="form-control" readonly>

            <!-- Imagen del cliente -->
            <div class="img mt-3">
                <img id="fotoCliente" src="/Web_Farmacia/dist/assets/img/farmacia_batahola_circulo_sin_fondo.jpg" width="100%">
            </div>
        </div>

        <!-- Campo oculto para almacenar el ID del cliente seleccionado -->
        <input type="hidden" id="idClienteSeleccionado" value="">

        <!-- Botón de agregar al carrito -->
        <button class="btn btn-primary d-block mx-auto mt-4" id="btnAgregar">Agregar al Carrito</button>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Inicializar DataTable en la tabla con el id "tablaProducto"
        $('#tablaProducto, #clientesTable').DataTable();
    });
</script>


<!-- Modal para buscar productos -->
<div class="modal fade" id="modalBusquedaProducto" tabindex="-1" aria-labelledby="modalBusquedaProductoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalBusquedaProductoLabel">Buscar Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table id="tablaProducto" class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Imagen</th>
                            <th>Nombre</th>
                            <th>Laboratorio o Marca</th>
                            <th>Dosis</th>
                            <th>Presentaciones</th>
                            <th>Formato del producto</th> <!-- Nueva columna -->
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Los productos se llenarán aquí dinámicamente -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal para agregar cliente en el archivo caja.php-->
<div class="modal fade" id="modalAgregarCliente" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog" style="max-width: 500px; margin: 0 auto;"> <!-- Estilo para controlar el tamaño y centrar -->
        <div class="modal-content">
            <form action="../pages/Ctrl/agregar_cliente.php" method="POST">
                <!-- Campo oculto para identificar que proviene de caja.php -->
                <input type="hidden" name="origen" value="facturacion.php">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Agregar Cliente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>

                <div class="modal-body">
                    <!-- Nombre -->
                    <div class="mb-3">
                        <label for="nombreCliente" class="form-label">Nombre</label>
                        <input type="text" class="form-control" name="nombreCliente" id="nombreCliente" placeholder="Ingrese el primer y segundo nombre" required>
                    </div>

                    <!-- Apellido -->
                    <div class="mb-3">
                        <label for="apellidoCliente" class="form-label">Apellido</label>
                        <input type="text" class="form-control" name="apellidoCliente" id="apellidoCliente" placeholder="Ingrese el primer y segundo apellido" required>
                    </div>

                    <!-- Cédula -->
                    <div class="mb-3">
                        <label for="cedulaCliente" class="form-label">Cédula</label>
                        <input type="text" class="form-control" name="cedulaCliente" id="cedulaCliente" placeholder="000-000000-0000X" pattern="[0-9]{3}-[0-9]{6}-[0-9]{4}[A-Z]{1}" title="Formato: 000-000000-0000X" required>
                    </div>

                    <!-- Género -->
                    <div class="mb-3">
                        <label for="generoCliente" class="form-label">Género</label>
                        <select class="form-select" name="generoCliente" id="generoCliente" required>
                            <option value="">Seleccione género</option>
                            <option value="Masculino">Masculino</option>
                            <option value="Femenino">Femenino</option>
                        </select>
                    </div>

                    <!-- Dirección -->
                    <div class="mb-3">
                        <label for="direccionCliente" class="form-label">Dirección</label>
                        <input type="text" class="form-control" name="direccionCliente" id="direccionCliente" placeholder="Ingrese dirección" required>
                    </div>

                    <!-- Teléfono -->
                    <div class="mb-3">
                        <label for="telefonoCliente" class="form-label">Teléfono</label>
                        <input type="tel" class="form-control" name="telefonoCliente" id="telefonoCliente" placeholder="8888-8888" pattern="[0-9]{4}-[0-9]{4}" title="Formato: 8888-8888" required>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="emailCliente" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" name="emailCliente" id="emailCliente" placeholder="ejemplo@correo.com" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Cliente</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal del Carrito-->
<div class="modal fade" id="mostarCarrito" tabindex="-1" aria-labelledby="modalCarritoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-md">
        <div class="modal-content rounded-4 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="modalCarritoLabel">🛒 Tu Carrito de Ventas</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <div class="modal-body">
                <!-- Aquí se agregan los productos dinámicamente -->
            </div>

            <div class="modal-footer flex-column text-start">
                <div class="w-100 mb-2">
                    <h5 class="text-end fw-bold text-success">
                        Total General: <span id="grandTotal">C$0.00</span>
                    </h5>
                    <p class="text-muted text-end">Incluye todos los productos con descuento aplicado.</p>
                </div>

                <div class="w-100 d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        ✖ Cerrar
                    </button>
                    <button type="button" class="btn btn-primary" onclick="abrirMetodoPago()">
                        💳 Facturar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- notificación de agregar al carrito -->
<div id="notificacion" class="notificacion">
    <i class="icono">i</i>
    <span>El producto se agregó al carrito de compras.</span>
    <img src="" alt="Producto" class="imagen-icono" />
</div>

<!-- Modal del Carrito estilos -->
<style>
    .modal-dialog {
        width: 900px !important;
        /* Ajusta el ancho */
        margin: auto;
        /* Centra el modal */
    }

    /* Estilo de la notificación */
    .notificacion {
        display: none;
        /* Inicialmente oculta */
        position: fixed;
        top: 20px;
        right: 20px;
        background-color: #4CAF50;
        /* Fondo verde */
        color: white;
        border-radius: 8px;
        padding: 15px 20px;
        width: auto;
        max-width: 350px;
        /* Hacemos que sea más estrecha */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        font-family: Arial, sans-serif;
        font-size: 16px;
        z-index: 9999;
        transition: opacity 0.5s ease;
        /* Animación suave */
        align-items: center;
        justify-content: space-between;
    }

    .notificacion .imagen-icono {
        width: 50px;
        /* Imagen más grande */
        height: 50px;
        object-fit: cover;
        /* Mantiene la proporción de la imagen */
        margin-right: 10px;
        /* Espacio entre la imagen y el texto */
        border-radius: 5px;
        /* Redondeamos la imagen */
    }

    .notificacion .icono {
        display: none;
        /* Ocultamos el icono de la 'i' */
    }

    .notificacion span {
        flex-grow: 1;
        /* Ocupa el espacio restante */
        font-weight: bold;
    }

    /* Transición suave para la aparición y desaparición */
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(100%);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .notificacion.show {
        animation: slideIn 0.5s ease-in-out;
    }

    /* Estilos personalizados para el modal de factura */
    #modalFactura .modal-content {
        border-radius: 10px;
        padding: 20px;
        background-color: #ffffff;
    }

    /* Encabezado con fondo personalizado */
    #modalFactura .modal-header {
        background-color: #17a2b8;
        /* color info de Bootstrap */
        color: white;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }

    /* Cuerpo del modal con fuente legible */
    #modalFactura .modal-body {
        font-family: Arial, sans-serif;
        font-size: 14px;
    }

    /* Tabla de productos en la factura */
    #modalFactura table {
        width: 100%;
        border-collapse: collapse;
    }

    #modalFactura th,
    #modalFactura td {
        padding: 8px;
        text-align: left;
        border: 1px solid #dee2e6;
    }

    /* Pie del modal alineado */
    #modalFactura .modal-footer {
        justify-content: space-between;
    }

    /* alerta del boton facturar */
    .swal2-container {
        z-index: 9999 !important;
    }

    #modalBusquedaProducto .modal-dialog {
        margin-top: 40px;
        /* Ajusta este valor para separar más o menos */
    }
</style>


<!-- Modal de Método de Pago -->
<div class="modal fade" id="modalMetodoPago" tabindex="-1" aria-labelledby="modalMetodoPagoLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content rounded-4 shadow">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title fw-bold" id="modalMetodoPagoLabel">💵 Método de Pago</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Total a Pagar</label>
                    <input type="text" class="form-control" id="totalPagar" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Método de Pago</label>
                    <select class="form-select" id="metodoPago">
                        <option value="efectivo" selected>Efectivo</option>
                        <!-- Puedes añadir otros métodos de pago aquí si lo deseas -->
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Monto Recibido</label>
                    <input type="number" class="form-control" id="montoRecibido">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Vuelto</label>
                    <input type="text" class="form-control" id="vueltoCliente" readonly>
                </div>
            </div>

            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-warning btn-sm" style="padding-left: 18px; padding-right: 18px; padding-top: 10px; padding-bottom: 10px;" onclick="volverAlCarrito()">← Atrás</button>
                <button type="button" id="btnPagar" class="btn btn-success" onclick="alpargar()">✅ Pagar</button>
            </div>
        </div>
    </div>
</div>

<!---aqui hago el llamado del nombre del vendedor en modalfa factura---->
<script>
    const vendedorLogueado = <?php echo json_encode($_SESSION['Nombre_Usuario'] ?? ''); ?>;
</script>

<!-- Modal de Factura -->
<div class="modal fade" id="modalFactura" tabindex="-1" aria-labelledby="modalFacturaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="modalFacturaLabel">🧾 Factura de Compra</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <div class="modal-body">
                <div id="facturaContenido" style="font-family: Arial, sans-serif;">

                    <!-- Datos generales en filas sin tabla -->
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <strong>Fecha:</strong> <span id="facturaFecha"></span>
                        </div>
                        <div class="col-md-6 text-end">
                            <strong>N° Recibo:</strong> <span id="facturaNumeroRecibo"></span>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <strong>Cliente:</strong> <span id="facturaCliente"></span>
                            <!-- Guardar el ID del cliente en un input oculto -->
                            <input type="hidden" id="facturaIDCliente" value="" />
                        </div>
                        <div class="col-md-6 text-end">
                            <strong>Vendedor:</strong> <span id="facturaVendedor">
                                <?php echo isset($_SESSION['Nombre_Usuario']) ? htmlspecialchars($_SESSION['Nombre_Usuario']) : 'No identificado'; ?>
                            </span>
                            <!-- Guardar el ID del usuario (vendedor) en un input oculto -->
                            <input type="hidden" id="facturaIDUsuario" value="<?php echo isset($_SESSION['ID_Usuario']) ? $_SESSION['ID_Usuario'] : ''; ?>" />
                        </div>
                    </div>

                    <!-- Detalle de productos -->
                    <table class="table table-bordered table-sm mt-3">
                        <thead class="table-light">
                            <tr>
                                <th>Producto</th>
                                <th>Dosis</th>
                                <th>Cantidad</th>
                                <th>Precio U.</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody id="tablaFacturaProductos">
                            <!-- Filas de productos -->
                        </tbody>
                    </table>

                    <!-- Totales y métodos -->
                    <div class="mt-3">
                        <div class="text-end mt-3">
                            <span style="color: #0c5460; font-size: 1.3rem; font-weight: bold;">
                                Total a Pagar: C$<span id="facturaTotal"></span>
                            </span>
                        </div>


                        <p><strong>Método de Pago:</strong> <span id="facturaMetodoPago"></span></p>
                        <p><strong>Monto Recibido:</strong> C$<span id="facturaMontoRecibido"></span></p>
                        <p><strong>Vuelto:</strong> <span id="facturaVuelto"></span></p>
                        <p class="text-center mt-4">¡Gracias por tu compra!</p>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-warning" onclick="volverAlMetodoPago() ">← Atrás</button>
                <button type="button" class="btn btn-primary" onclick="imprimirFactura()">Imprimir</button>
            </div>
        </div>
    </div>
</div>








<?php
include '../pages/Cnx/conexion.php';

// Ahora usa la variable $conn en lugar de $conexion
$query = "SELECT * FROM clientes WHERE Estado = 1";
$stmt = $conn->prepare($query);
$stmt->execute();
$clientes = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>
<!-- Modal para buscar cliente -->
<div class="modal fade" id="clientesModal" tabindex="-1" aria-labelledby="clientesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="clientesModalLabel">Seleccionar Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table id="clientesTable" class=" table table-striped ">
                    <thead class="table-dark">
                        <tr>
                            <th>Nombre Completo</th>
                            <th>Cédula</th>
                            <th>Género</th>
                            <th>Teléfono</th>
                            <th>Seleccionar</th>
                        </tr>
                    </thead>
                    <tbody id="clientesTableBody">
                        <?php if (count($clientes) > 0): ?>
                            <?php foreach ($clientes as $cliente): ?>
                                <tr>
                                    <td><?php echo $cliente['Nombre'] . ' ' . $cliente['Apellido']; ?></td>
                                    <td><?php echo $cliente['Cedula']; ?></td>
                                    <td><?php echo $cliente['Genero']; ?></td>
                                    <td><?php echo $cliente['Telefono']; ?></td>
                                    <td><button class="btn btn-primary select-client" data-id="<?php echo $cliente['ID_Cliente']; ?>">Seleccionar</button></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6">No hay clientes disponibles</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<script src="../js/modal_medicamento.js?12345"></script>
<script src="../js/seleccionar_medicamento.js?12345"></script>
<script src="../js/mostar_clientes_chexbox.js?1234"></script>
<script src="../js/buscar_clientes_cedula.js?1234"></script>
<script src="../js/carrito_caja.js?12"></script>



<?php
include_once "Ctrl/footer.php";
?>