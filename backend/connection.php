<?php


    // Establecer la conexión con la base de datos
    $servername = "valy.cb888im4e9ce.us-east-1.rds.amazonaws.com";
    $username = "admin";
    $password = "root2024";
    $dbname = "valyspavers";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

?>