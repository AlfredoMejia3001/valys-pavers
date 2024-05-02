<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Facturas</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

  <nav class="bg-gray-800 text-white p-4">
    <div class="max-w-4xl mx-auto flex justify-between items-center">
      <div>
        <a href="./index.php" class="text-white">Crear factura</a>
        <a href="./facturas.php" class="text-white ml-4">Facturas</a>
      </div>
      <div>
        <!-- Aquí puedes agregar el contenido de tu logo -->
      </div>
    </div>
  </nav>

  <div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-bold mb-4">Lista de facturas</h1>
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
      <div class="overflow-x-auto">
        <table class="min-w-full">
          <thead class="bg-gray-200 text-gray-700">
            <tr>
              <th class="py-2 px-4">ID</th>
              <th class="py-2 px-4">Cliente</th>
              <th class="py-2 px-4">Fecha de emisión</th>
              <th class="py-2 px-4">Fecha de vencimiento</th>
              <th class="py-2 px-4">Total</th>
              <th class="py-2 px-4">Acciones</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">
            <?php
              // Conectar a la base de datos
              include './backend/connection.php';

              // Consultar las facturas
              $sql = "SELECT * FROM Facturas";
              $result = $conn->query($sql);

              // Mostrar las filas de la tabla con los datos de las facturas
              if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                  echo "<tr>";
                  echo "<td class='py-2 px-4'>" . $row["ID"] . "</td>";
                  echo "<td class='py-2 px-4'>" . $row["Cliente"] . "</td>";
                  echo "<td class='py-2 px-4'>" . $row["Fecha_Emision"] . "</td>";
                  echo "<td class='py-2 px-4'>" . $row["Fecha_Vencimiento"] . "</td>";
                  echo "<td class='py-2 px-4'>$" . $row["Total"] . "</td>";
                  echo "<td class='py-2 px-4'>
                        <a href='#' class='text-blue-500 hover:underline ver-link' data-id='" . $row["ID"] . "'>Ver</a>
                        </td>";
                  echo "</tr>";
                }
              } else {
                echo "<tr><td colspan='6' class='py-4 px-4 text-center'>No hay facturas disponibles.</td></tr>";
              }
              // Cerrar conexión a la base de datos
              $conn->close();
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div id="modal" class="fixed inset-0 z-10 overflow-y-auto hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
      <div class="bg-white rounded-lg shadow-xl w-full max-w-lg p-6">
        <!-- Contenido del modal -->
        <?php
         if(isset($_GET['id'])) {
          $factura_i = $_GET['id'];

            $sql_factura = "SELECT * FROM factura WHERE id =  . $factura_i";
            echo "<h2 id='modalTitle' class='text-2xl font-bold mb-4'>Detalles de la Factura #".$factura_i."</h2>";
         
          }
        ?>
        <div class="overflow-x-auto">
          <table class="min-w-full">
            <thead class="bg-gray-200 text-gray-700">
              <tr>
                <th class="py-2 px-4">Descripción</th>
                <th class="py-2 px-4">Cantidad</th>
                <th class="py-2 px-4">Precio Unitario</th>
                <th class="py-2 px-4">Importe</th>
              </tr>
            </thead>
            <tbody>
              <?php
                // Obtener el ID de la factura seleccionada
                if(isset($_GET['id'])) {
                  $factura_id = $_GET['id'];
                  // Conectar a la base de datos
                  include './backend/connection.php';
                  // Consultar los detalles de la factura
                  $sql_factura = "SELECT * FROM factura WHERE id =  . $factura_id";
                  $sql_detalle = "SELECT * FROM Contenido_Facturas WHERE Factura_ID = $factura_id";
                  $result_detalle = $conn->query($sql_detalle);
                  // Mostrar los detalles de la factura en el modal
                  if ($result_detalle->num_rows > 0) {
                    while($row_detalle = $result_detalle->fetch_assoc()) {
                      echo "<tr>";
                      echo "<td class='py-2 px-4'>" . $row_detalle["Descripcion"] . "</td>";
                      echo "<td class='py-2 px-4'>" . $row_detalle["Cantidad"] . "</td>";
                      echo "<td class='py-2 px-4'>$" . $row_detalle["Precio_Unitario"] . "</td>";
                      echo "<td class='py-2 px-4'>$" . $row_detalle["Importe"] . "</td>";
                      echo "</tr>";
                    }
                  } else {
                    echo "<tr><td colspan='4' class='py-4 px-4 text-center'>No hay detalles disponibles para esta factura.</td></tr>";
                  }
                  // Cerrar conexión a la base de datos
                  $conn->close();
                } else {
                  echo "<tr><td colspan='4' class='py-4 px-4 text-center'>No se ha seleccionado ninguna factura.</td></tr>";
                }
              ?>
            </tbody>
          </table>
        </div>
        <!-- Botón de cerrar modal -->
        <button id="closeModal" class="mt-4 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center">
          Cerrar
        </button>
        <button id="closeModal" class="mt-4 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center">
          Descargar
        </button>
      </div>
    </div>
  </div>

  <script>
  // Obtener elementos del DOM
  const modal = document.getElementById('modal');
  const closeModalButton = document.getElementById('closeModal');

  // Función para abrir el modal
  function openModal() {
    modal.classList.remove('hidden');
  }

  // Función para cerrar el modal
  function closeModal() {
    modal.classList.add('hidden');
  }

  // Función para establecer el estado del modal en sessionStorage
  function setModalState(state) {
    sessionStorage.setItem('modalState', state);
  }

  // Función para verificar el estado del modal y abrirlo si es necesario
  function checkModalState() {
    const modalState = sessionStorage.getItem('modalState');
    if (modalState === 'open') {
      openModal();
    }
  }

  // Asignar eventos a los elementos
  closeModalButton.addEventListener('click', () => {
    closeModal();
    setModalState('closed');
  });

  // Asignar evento a los enlaces de "Ver"
  const verLinks = document.querySelectorAll('.ver-link');
  verLinks.forEach(link => {
    link.addEventListener('click', (event) => {
      event.preventDefault(); // Prevenir el comportamiento predeterminado del enlace
      const id = link.getAttribute('data-id');
      setModalState('open');
      window.location.href = `facturas.php?id=${id}`;
    });
  });

  // Verificar el estado del modal cuando se carga la página
  document.addEventListener('DOMContentLoaded', () => {
    checkModalState();
  });
</script>

</body>
</html>
