<?php
include_once "Ctrl/head.php";
?>







<?php
include_once "Ctrl/menu.php";
?>

<!---table JQUERY -->



<!-- ESTILO PERSONALIZADO -->
<style>
    .container {
        margin-top: 20px;
    }

    .btn-sm i {
        font-size: 1rem;
    }

    .table td, .table th {
        vertical-align: middle;
    }
</style>

<!-- TABLA FACTURAS -->
<div class="container mt-4">
    <div class="card p-3 shadow-sm">
        <h3 class="text-center mb-3">Facturas Diarias</h3>

        <table id="FacturaTable" class="table table-striped text-center">
            <thead>
                <tr>
                    <th>N° Factura</th>
                    <th>Cliente</th>
                    <th>Método de Pago</th>
                    <th>Subtotal</th>
                    <th>Total</th>
                    <th>Ver</th>
                    <th>Editar</th>
                </tr>
            </thead>
            <tbody>
                <!-- Se llena dinámicamente con DataTables -->
            </tbody>
        </table>
    </div>
</div>

<!-- SCRIPT -->
<script>
    $(document).ready(function () {
        $('#FacturaTable').DataTable({
            ajax: '../pages/Ctrl/obtener_facturas.php',
            columns: [
                { data: 'Numero_Factura' },
                { data: 'Cliente' },
                { data: 'Metodo_Pago' },
                { data: 'Subtotal' },
                { data: 'Total' },
                {
                    data: 'ID_FacturaV',
                    render: function (data) {
                        return `
                            <button class="btn btn-success btn-sm" title="Ver" onclick="verFactura(${data})">
                                <i class="bx bx-show"></i>
                            </button>`;
                    }
                },
                {
                    data: 'ID_FacturaV',
                    render: function (data) {
                        return `
                            <button class="btn btn-warning btn-sm text-white" title="Editar" onclick="editarFactura(${data})">
                                <i class="bx bx-edit"></i>
                            </button>`;
                    }
                }
            ],
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json'
            }
        });
    });

    function verFactura(id) {
        window.location.href = 'ver_factura.php?id=' + id;
    }

    function editarFactura(id) {
        window.location.href = 'editar_factura.php?id=' + id;
    }
</script>



<script src=""></script>

<?php
include_once "Ctrl/footer.php";
?>