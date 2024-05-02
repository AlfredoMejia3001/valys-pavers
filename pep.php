<!-- Detalles de la factura -->
<?php include './backend/connection.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facturas</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
</head>
<?php
if (isset($_GET['id'])) {
    $factura_id = $_GET['id'];
    // Consulta para obtener los datos de la factura y su contenido
    $sql = "SELECT f.*, cf.* FROM facturas f
        INNER JOIN contenido_facturas cf ON f.ID = cf.Factura_ID
        WHERE f.ID = $factura_id"; // Puedes cambiar "1" por el ID de la factura que deseas mostrar
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
?>
<!-- Botón para abrir el modal -->
<button id="openModal" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
  Open Modal
</button>

<!-- Modal -->
<!-- Modal -->
<div id="modal" class="fixed inset-0 z-10 overflow-y-auto hidden bg-gray-900 bg-opacity-75 flex items-center justify-center">
  <div class="bg-white rounded-lg shadow-xl w-full max-w-3xl p-6">
    <div class="flex items-center mb-8">
      <img class="h-8 w-8 mr-2" src="https://tailwindflex.com/public/images/logos/favicon-32x32.png" alt="Logo" />
      <div class="text-gray-700 font-semibold text-lg">VALY'S PAVERS</div>
    </div>
    <div class="text-gray-700 mb-6">
      <div class="font-bold text-xl mb-2">INVOICE</div>
      <div class="text-sm">Date: <?php echo $row["Fecha_Emision"]; ?></div>
      <div class="text-sm">Invoice #: <?php echo $row["ID"]; ?></div>
      <div class="text-sm">Licence: LIC#NV20232736670</div>
    </div>
    <div class="border-b-2 border-gray-300 pb-8 mb-8">
      <h2 class="text-2xl font-bold mb-4">Bill To:</h2>
      <div class="flex justify-between mb-4">
        <div>
          <div class="text-gray-700"><?php echo $row["Cliente"]; ?></div>
          <div class="text-gray-700">Fecha de emisión: <?php echo $row["Fecha_Emision"]; ?></div>
        </div>
        <div>
          <div class="text-gray-700"><?php echo $row["Direccion"]; ?></div>
          <div class="text-gray-700">Fecha de vencimiento: <?php echo $row["Fecha_Vencimiento"]; ?></div>
        </div>
      </div>
      <!-- Agregar los demás campos del cliente aquí -->
    </div>
    <table class="w-full text-left mb-8">
      <thead>
        <tr>
          <th class="text-gray-700 font-bold uppercase py-2">Description</th>
          <th class="text-gray-700 font-bold uppercase py-2">Quantity</th>
          <th class="text-gray-700 font-bold uppercase py-2">Price</th>
          <th class="text-gray-700 font-bold uppercase py-2">Total</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if (isset($_GET['id'])) {
          $factura_id = $_GET['id'];
          $sql_detalle = "SELECT * FROM Contenido_Facturas WHERE Factura_ID = $factura_id";
          $result_detalle = $conn->query($sql_detalle);
          $total = 0;
          if ($result_detalle->num_rows > 0) {
            while ($row_detalle = $result_detalle->fetch_assoc()) {
              echo "<tr>";
              echo "<td class='py-4 text-gray-700'>" . $row_detalle["Descripcion"] . "</td>";
              echo "<td class='py-4 text-gray-700'>" . $row_detalle["Cantidad"] . "</td>";
              echo "<td class='py-4 text-gray-700'>$" . $row_detalle["Precio_Unitario"] . "</td>";
              echo "<td class='py-4 text-gray-700'>$" . $row_detalle["Importe"] . "</td>";
              echo "</tr>";
            }
          }
        }
        ?>
      </tbody>
    </table>
    <div class="flex justify-end mb-8">
      <div class="text-gray-700 mr-2">Subtotal:</div>
      <div class="text-gray-700">$<?php echo $row["Total"] ?></div>
    </div>
    <div class="text-right mb-8">
      <?php
      if (isset($_GET['id'])) {
        $factura_id = $_GET['id'];
        // Consulta para obtener el total de la factura
        $sql_total = "SELECT Total FROM facturas WHERE ID = $factura_id";
        $result_total = $conn->query($sql_total);
        if ($result_total->num_rows > 0) {
          $row_total = $result_total->fetch_assoc();
          $total = $row_total["Total"];
          // Calcular impuestos (6.85% para Las Vegas, Nevada)
          $impuestos = $total * 0.0685;
          $impuestos_formateados = number_format($impuestos, 2);
          $total_final1 = $impuestos + $total;
          $total_final = number_format($total_final1, 2);
      ?>
          <div class="text-gray-700 mr-2">Tax:</div>
          <div class="text-gray-700">$<?php echo $impuestos_formateados; ?></div>
      <?php
        } else {
          echo "No se encontró el total de la factura.";
        }
      ?>
    </div>
    <div class="flex justify-end mb-8">
      <div class="text-gray-700 mr-2">Total:</div>
      <div class="text-gray-700 font-bold text-xl">$<?php echo $total_final ?></div>
    </div>
    <div class="mt-6 flex justify-end">
      <button id="closeModal" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center">
        Cerrar
      </button>
    </div>
  </div>
</div>

    <?php
                }
    ?>
<?php
    } else {
        echo "No se encontraron resultados.";
    }
    $conn->close();
}
?>

<script>
    // Abrir el modal al hacer clic en el botón
document.getElementById("openModal").addEventListener("click", function() {
  document.getElementById("modal").classList.remove("hidden");
});

// Cerrar el modal al hacer clic en el botón de cerrar
document.getElementById("closeModal").addEventListener("click", function() {
  document.getElementById("modal").classList.add("hidden");
});

</script>