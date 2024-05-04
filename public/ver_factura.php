<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Facturas</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>

<body class="bg-gray-100">

<nav class="bg-gray-800 text-white py-1.5 px-4">
    <div class="max-w-4xl mx-auto flex justify-between items-center">
        <div>
            <a href="./index.php" class="text-white">Crear factura</a>
            <a href="./facturas.php" class="text-white ml-4">Facturas</a>
        </div>
        <div>
            <img src="./logo.png" alt="" class="w-14 h-auto">
        </div>
    </div>
</nav>


  <?php
include './backend/connection.php';

if (isset($_GET['id'])) {
    $factura_id = $_GET['id'];

    // Consulta para obtener los datos de la factura y su contenido
    $sql = "SELECT f.*, cf.* FROM facturas f
        INNER JOIN contenido_facturas cf ON f.ID = cf.Factura_ID
        WHERE f.ID = $factura_id";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
?>
<div class="bg-white rounded-lg shadow-lg px-8 py-3 max-w-xl mx-auto mt-3 mb-3">
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center">
            <img class="h-8 w-8 mr-2" src="./logo.png"
                alt="Logo" />
            <div class="text-gray-700 font-semibold text-lg">VALY'S PAVERS</div>
        </div>
        <div class="text-gray-700">
            <div class="font-bold text-xl mb-2">INVOICE</div>
            <div class="text-sm">Date: <?php echo $row["Fecha_Emision"]; ?></div>
            <div class="text-sm">Date: <?php echo $row["Fecha_Vencimiento"]; ?></div>
            <div class="text-sm">Invoice #: <?php echo $row["ID"]; ?></div>
            <div class="text-sm">Licence: LIC#NV20232736670</div>
        </div>
    </div>
    <div class="border-b-2 border-gray-300 pb-8 mb-8">
        <h2 class="text-2xl font-bold mb-4">Bill To:</h2>
        <div class="text-gray-700 mb-2"><?php echo $row["Cliente"]; ?></div>
        <div class="text-gray-700 mb-2"><?php echo $row["Calle"]; ?></div>
        <div class="text-gray-700 mb-2"><?php echo $row["Estado"]; ?>, USA <?php echo $row["Codigo_Postal"]; ?></div>
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
                $sql_detalle = "SELECT * FROM contenido_facturas WHERE Factura_ID = $factura_id";
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
        <div class="text-gray-700">$<?php echo $row["Total"]; ?></div>
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
    <div class="border-t-2 border-gray-300 pt-4 mb-8">
    <a  href="./pdf/facturar.php?id=<?php echo $factura_id?>"  class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded float-right">
  Download
</a>
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
document.addEventListener("DOMContentLoaded", function() {
  document.querySelector("#downloadBtn").addEventListener("click", function() {
    // Hacer solicitud AJAX para obtener el contenido del archivo de Word
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "get_word_content.php", true);
    xhr.responseType = "json";
    xhr.onload = function() {
      if (xhr.status === 200) {
        var data = xhr.response;
        // Generar el archivo de Word
        generateWordFile(data.wordContent);
      } else {
        console.error("Error al obtener el contenido del archivo de Word");
      }
    };
    xhr.send();
  });

  function generateWordFile(wordContent) {
    // Reemplazar los marcadores de posición con los datos de la factura
    // Aquí debes reemplazar los marcadores de posición en wordContent con los datos de la factura

    // Crear un Blob con el contenido modificado
    var blob = new Blob([wordContent], { type: "application/msword" });

    // Crear un enlace de descarga y hacer clic en él para descargar el archivo
    var link = document.createElement("a");
    link.href = URL.createObjectURL(blob);
    link.download = "factura_con_datos.doc";
    link.click();
  }
});


</script>