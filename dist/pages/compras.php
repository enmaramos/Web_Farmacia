<?php include_once "Ctrl/head.php"; ?>
<?php include_once "Ctrl/menu.php"; ?>
<?php include('../pages/Cnx/conexion.php'); ?>

<div class="container mt-4">
  <h2 class="mb-4">📦 Módulo de Compras</h2>

  <form method="POST" action="guardar_compra.php" id="formCompra">
    <!-- ==================== DATOS GENERALES ==================== -->
    <div class="card mb-4">
      <div class="card-header bg-primary text-white">
        <strong>Datos Generales de la Compra</strong>
      </div>
      <div class="card-body row">
        <!-- Proveedor -->
        <div class="col-md-6 mb-3">
          <label for="id_proveedor" class="form-label">Proveedor</label>
          <select name="id_proveedor" id="id_proveedor" class="form-select" required>
            <option value="">-- Seleccione un proveedor --</option>
            <?php
            if (!$conexion) {
              echo "<option disabled>Error de conexión</option>";
            } else {
              $sql = "SELECT ID_Proveedor, Nombre FROM proveedor WHERE Estado = 1";
              $result = mysqli_query($conexion, $sql);
              if (!$result) {
                echo "<option disabled>Error en la consulta: " . mysqli_error($conexion) . "</option>";
              } elseif (mysqli_num_rows($result) == 0) {
                echo "<option disabled>No hay proveedores disponibles</option>";
              } else {
                while ($row = mysqli_fetch_assoc($result)) {
                  echo "<option value='" . $row['ID_Proveedor'] . "'>" . $row['Nombre'] . "</option>";
                }
              }
            }
            ?>
          </select>
        </div>

        <!-- Fecha de emisión -->
        <div class="col-md-3 mb-3">
          <label for="fecha_emision" class="form-label">Fecha de Emisión</label>
          <input type="datetime-local" name="fecha_emision" id="fecha_emision" class="form-control"
            value="<?= date('Y-m-d\TH:i') ?>" required>
        </div>

        <!-- Estado del pedido -->
        <div class="col-md-3 mb-3">
          <label for="estado_pedido" class="form-label">Estado del Pedido</label>
          <select name="estado_pedido" id="estado_pedido" class="form-select">
            <option value="Recibido">Recibido</option>
            <option value="Pendiente">Pendiente</option>
            <option value="En camino">En camino</option>
          </select>
        </div>

        <!-- Descripción de la compra -->
        <div class="col-md-12">
          <label for="descripcion_compra" class="form-label">Descripción</label>
          <textarea name="descripcion_compra" id="descripcion_compra" class="form-control" rows="2"
            placeholder="Descripción general de esta compra..."></textarea>
        </div>
      </div>
    </div>

    <!-- ==================== DETALLE DE MEDICAMENTOS ==================== -->
    <div class="card mb-4">
      <div class="card-header d-flex justify-content-between align-items-center bg-secondary text-white">
        <strong>🧪 Detalle de Medicamentos</strong>
        <button type="button" class="btn btn-light btn-sm" id="btnAgregarMedicamento">
          <i class="bi bi-plus-circle"></i> Agregar Medicamento
        </button>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-bordered mb-0" id="tablaDetalleCompra">
            <thead class="table-light">
              <tr>
                <th>Medicamento</th>
                <th>Descripción Lote</th>
                <th>F. Fabricación</th>
                <th>F. Caducidad</th>
                <th>Precio Unitario</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
                <th>Acción</th>
              </tr>
            </thead>
            <tbody id="detalleCompraBody">
              <!-- JS agregará las filas aquí -->
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- ==================== TOTALES ==================== -->
    <div class="row justify-content-end mb-4">
      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <div class="mb-3">
              <label for="subtotal" class="form-label">Subtotal</label>
              <input type="text" name="subtotal" id="subtotal" class="form-control text-end" readonly value="0.00">
            </div>
            <div class="mb-3">
              <label for="iva" class="form-label">IVA (15%)</label>
              <input type="text" name="iva" id="iva" class="form-control text-end" readonly value="0.00">
            </div>
            <div>
              <label for="total" class="form-label fw-bold">Total</label>
              <input type="text" name="total" id="total" class="form-control text-end fw-bold" readonly value="0.00">
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- ==================== BOTÓN GUARDAR ==================== -->
    <div class="text-end">
      <button type="submit" class="btn btn-success">
        <i class="bi bi-save"></i> Guardar Compra
      </button>
    </div>
  </form>
</div>

<?php include_once "Ctrl/footer.php"; ?>
