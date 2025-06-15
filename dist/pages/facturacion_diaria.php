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

        <div class="table-responsive">
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
                    data: 'Numero_Factura',
    render: function (data) {
        return `
            <button class="btn btn-success btn-sm" title="Ver" onclick="verFactura('${data}')">
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

<script>
function verFactura(numero) {
    fetch('ver_factura.php?numero=' + numero)
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const f = data.factura;
                const detalles = data.detalles;

                let html = `<h3>Factura: ${f.Numero_Factura}</h3>`;
                html += `<p>Cliente: ${f.Nombre_Cliente}</p>`;
                html += `<p>Método de pago: ${f.Metodo_Pago}</p>`;
                html += `<p>Total: C$${f.Total}</p>`;
                html += `<hr><table border="1"><tr>
                            <th>Medicamento</th><th>Unidad</th><th>Dosis</th><th>Presentación</th>
                            <th>Cantidad</th><th>Precio</th><th>Subtotal</th></tr>`;

                detalles.forEach(d => {
                    html += `<tr>
                        <td>${d.Nombre_Medicamento}</td>
                        <td>${d.Forma_Farmaceutica ?? '-'}</td>
                        <td>${d.Dosis ?? '-'}</td>
                        <td>${d.Tipo_Presentacion ?? '-'}</td>
                        <td>${d.Cantidad}</td>
                        <td>C$${d.Precio_Unitario}</td>
                        <td>C$${d.Subtotal}</td>
                    </tr>`;
                });

                html += '</table>';
                document.getElementById('modalFactura').innerHTML = html;
                document.getElementById('modalFactura').style.display = 'block';
            } else {
                alert(data.message);
            }
        });
}
</script>


<div id="modalFactura" style="
    display:none;
    background:#fff;
    padding:20px;
    border:1px solid #000;
    position:fixed;
    top:10%;
    left:10%;
    width:80%;
    height:auto;
    z-index:9999;
    box-shadow:0px 0px 15px rgba(0,0,0,0.3);
">
    <button onclick="document.getElementById('modalFactura').style.display='none'" style="float:right;">Cerrar</button>
</div>



<script src=""></script>

<?php
include_once "Ctrl/footer.php";
?>