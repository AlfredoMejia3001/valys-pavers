<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include './connection.php';

    // Recopilación de datos del formulario principal
    $cliente = $_POST['nombre'];
    $calle = $_POST['calle'];
    $estado = $_POST['estado'];
    $codigo_postal = $_POST['codigo_postal'];
    $fecha_emision = $_POST['fecha_emision'];
    $fecha_vencimiento = $_POST['fecha_vencimiento'];
    $total = $_POST['total'];

    // Inserción de la factura principal
    $sql_factura = "INSERT INTO facturas (Cliente, Calle, Estado, Codigo_Postal, Fecha_Emision, Fecha_Vencimiento, Total) VALUES ('$cliente', '$calle','$estado','$codigo_postal', '$fecha_emision', '$fecha_vencimiento', '$total')";

    if ($conn->query($sql_factura) === TRUE) {
        // Obtención del ID de la factura recién insertada
        $factura_id = $conn->insert_id;

        // Recopilación y inserción de detalles de factura
        $contadorFilas = $_POST['contadorFilas'];
        $cantidad1= $_POST['cantidad'];
        $descripcion1= $_POST['descripcion'];
        $precio_unitario1= $_POST['precio'];
        $importe1= $_POST['importe'];
        // Inserción del detalle de la factura
        $sql_detalle = "INSERT INTO contenido_facturas (Factura_ID, Descripcion, Precio_Unitario, Cantidad, Importe) VALUES ($factura_id, '$descripcion1', $precio_unitario1, $cantidad1, $importe1)";
        $conn->query($sql_detalle);

        for ($i = 1; $i < $contadorFilas; $i++) {
            $cantidad = $_POST["cantidad_$i"];
            $descripcion = $_POST["descripcion_$i"];
            $precio_unitario = $_POST["precio_$i"];
            $importe = $_POST["importe_$i"];

            // Inserción del detalle de la factura
            $sql_detalle = "INSERT INTO contenido_facturas (Factura_ID, Descripcion, Precio_Unitario, Cantidad, Importe) VALUES ($factura_id, '$descripcion', $precio_unitario, $cantidad, $importe)";
            $conn->query($sql_detalle);
        }

        // Redirección a index.php después de guardar correctamente
        header("Location:../index.php");
        exit();
    } else {
        // Si hubo un error, mostrar una alerta con Tailwind
        echo '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">¡Error!</strong>
                <span class="block sm:inline">Hubo un problema al guardar la factura.</span>
            </div>';
    }

    $conn->close();
}
?>
