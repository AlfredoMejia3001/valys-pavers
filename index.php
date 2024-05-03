<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Generar PDF</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="style.css">
</head>
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

<div class="max-w-4xl mx-auto py-8">
<div class="max-w-4xl mx-auto py-8 flex justify-center items-center">
    <img src="logo.png" alt="Logo de la empresa" class="w-28 h-auto">
</div>

    <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" id="facturaForm" action="./backend/guardar_factura.php" method="POST">
      <!-- Facturar a -->
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="nombre">Facturar a - Nombre</label>
        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="nombre" name="nombre" type="text" placeholder="Nombre">
      </div>
      <div class="flex mb-4">
          <div class="mr-4">
            <label class="block text-gray-700 text-sm font-bold" >Calle</label>
            <input class="shadow appearance-none border rounded w-35 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline "  name="calle" type="text"  placeholder="Calle">
          </div>
          <div class="mr-4">
            <label class="block text-gray-700 text-sm font-bold" ">Estado</label>
            <input class="shadow appearance-none border rounded w-30 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline "  type="text" name="estado" placeholder="Estado">
          </div>
          <div class="mr-4">
            <label class="block text-gray-700 text-sm font-bold" >Código postal</label>
            <p class="block text-gray-700 text-sm font-bold"><input class="shadow appearance-none border rounded w-28 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline " type="text" name="codigo_postal" placeholder="Código Postal"></p>
          </div>
        </div>
      <!-- Fecha -->
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="fecha_emision">Fecha - Fecha de Emisión</label>
        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="fecha_emision" name="fecha_emision" type="date">
      </div>
      <div class="mb-6">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="fecha_vencimiento">Fecha - Fecha de Vencimiento</label>
        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="fecha_vencimiento" name="fecha_vencimiento" type="date">
      </div>
      <!-- Detalles de la factura -->
      <div id="detalle-container">
        <!-- Primer conjunto de campos para detalles de factura -->
        <div class="flex mb-4">
          <div class="mr-4">
            <label class="block text-gray-700 text-sm font-bold" for="cantidad_0">Cantidad</label>
            <input class="shadow appearance-none border rounded w-20 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline cantidad" id="cantidad_0" name="cantidad" type="number" min="1" value="1">
          </div>
          <div class="mr-4">
            <label class="block text-gray-700 text-sm font-bold" for="descripcion_0">Descripción</label>
            <input class="shadow appearance-none border rounded w-96 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline descripcion" id="descripcion_0" type="text" name="descripcion" placeholder="Descripción">
          </div>
          <div class="mr-4">
            <label class="block text-gray-700 text-sm font-bold" for="precio_0">Precio Unitario</label>
            <p class="block text-gray-700 text-sm font-bold">$<input class="shadow appearance-none border rounded w-28 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline precio" id="precio_0" type="number" name="precio" min="0" placeholder="Precio Unitario"></p>
          </div>
          <div>
            <label class="block text-gray-700 text-sm font-bold" for="importe_0">Importe</label>
            <p class="block text-gray-700 text-sm font-bold">$<input class="shadow appearance-none border rounded w-28 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline importe" id="importe_0" type="text" name="importe" placeholder="Importe" readonly></p>
          </div>
        </div>
        <!-- Aquí se agregarán más conjuntos de campos dinámicamente -->
      </div>
      <!-- Campo oculto para el contador de filas -->
      <input type="hidden" id="contadorFilas" name="contadorFilas" value="1">
      <!-- Campo para mostrar el total -->
      <br>
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="total">Total</label>
        <input class="shadow appearance-none border rounded w-28 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="total" name="total" type="text" placeholder="Total" readonly>
      </div>
      <!-- Botones -->
      <div class="flex items-center justify-between mt-6">
        <input class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" value="Guardar" type="submit" id="botonGuardar"></input>
        <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button" id="botonAgregar">Agregar más</button>
      </div>
    </form>
  </div>

  <script>
    // Obtener elementos del DOM
    const botonAgregar = document.getElementById('botonAgregar');
    const detalleContainer = document.getElementById('detalle-container');
    const facturaForm = document.getElementById('facturaForm');
    let contador = 1;

    // Función para agregar un nuevo conjunto de campos para detalles de factura
    function agregarDetalleFactura() {
      // Crear un nuevo conjunto de campos
      const detalleDiv = document.createElement('div');
      detalleDiv.classList.add('flex', 'mb-4');

      detalleDiv.innerHTML = `
  <div class="mr-4">
    <input class="shadow appearance-none border rounded w-20 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline cantidad" id="cantidad_${contador}"  name="cantidad_${contador}" type="number" min="1" value="1">
  </div>
  <div class="mr-4">
    <input class="shadow appearance-none border rounded w-96 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline descripcion" id="descripcion_${contador}" type="text" name="descripcion_${contador}" placeholder="Descripción">
  </div>
  <div class="mr-4">
    <p class="block text-gray-700 text-sm font-bold">$<input class="shadow appearance-none border rounded w-28 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline precio" id="precio_${contador}" name="precio_${contador}" type="number" min="0" placeholder="Precio Unitario"></p>
  </div>
  <div>
    <p class="block text-gray-700 text-sm font-bold">$<input class="shadow appearance-none border rounded w-28 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline importe" id="importe_${contador}" type="text" name="importe_${contador}" placeholder="Importe" readonly></p>
  </div>
`;

      // Incrementar el contador para el próximo conjunto
      contador++;
      // Actualizar el valor del campo oculto
      document.getElementById('contadorFilas').value = contador;
      // Agregar el nuevo conjunto al contenedor
      detalleContainer.appendChild(detalleDiv);

      // Actualizar eventos de cambio
      actualizarEventosCambio();
    }

    // Función para calcular el importe
    function calcularImporte(precio, cantidad) {
      return precio * cantidad;
    }

    // Función para calcular el total
    function calcularTotal(importeInputs) {
      let total = 0;
      importeInputs.forEach(input => {
        total += parseFloat(input.value) || 0;
      });
      document.getElementById('total').value = total.toFixed(2);
    }

    // Función para actualizar eventos de cambio
    function actualizarEventosCambio() {
      const cantidadInputs = document.querySelectorAll('.cantidad');
      const precioInputs = document.querySelectorAll('.precio');
      const importeInputs = document.querySelectorAll('.importe');
      const totalInput = document.getElementById('total');

      cantidadInputs.forEach((input, index) => {
        input.addEventListener('input', () => {
          const cantidad = parseInt(input.value) || 0;
          const precio = parseFloat(precioInputs[index].value) || 0;
          importeInputs[index].value = (cantidad * precio).toFixed(2);
          // Calcular el total
          calcularTotal(importeInputs);
        });
      });

      precioInputs.forEach((input, index) => {
        input.addEventListener('input', () => {
          const cantidad = parseInt(cantidadInputs[index].value) || 0;
          const precio = parseFloat(input.value) || 0;
          importeInputs[index].value = (cantidad * precio).toFixed(2);
          // Calcular el total
          calcularTotal(importeInputs);
        });
      });
    }

    // Inicializar eventos cuando el DOM esté cargado
    document.addEventListener("DOMContentLoaded", function() {
      // Asignar evento clic para el botón "Agregar más"
      botonAgregar.addEventListener('click', agregarDetalleFactura);
      // Inicializar eventos de cambio para los inputs existentes
      actualizarEventosCambio();
    });

  </script>
</body>
</html>
