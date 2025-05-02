<?php
var_dump($_POST);
// Parámetros de conexión
$host = '127.0.0.1';
$user = 'root';
$password = 'root123';
$database = 'registro_contactos';

// Crear conexión
$conn = new mysqli($host, $user, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Verificar si los datos están presentes en el formulario
if (isset($_POST['Nombcontacto'], $_POST['Apecontacto'], $_POST['Direccion'], $_POST['Telefono'], $_POST['Email'], $_POST['FNac'], $_POST['EstadoCivil'])) {
    
    // Recibir datos del formulario
    $nombre = $_POST['Nombcontacto'];
    $apellidos = $_POST['Apecontacto'];
    $direccion = $_POST['Direccion'];
    $telefono = $_POST['Telefono'];
    $email = $_POST['Email'];
    $fnac = $_POST['FNac']; // YYYY-MM-DD
    $estadoCivil = $_POST['EstadoCivil'];

    // Validación de la fecha de nacimiento
    if (empty($fnac) || !preg_match("/^\d{4}-\d{2}-\d{2}$/", $fnac)) {
        die("❌ Fecha de nacimiento no válida. Asegúrate de ingresar una fecha en el formato YYYY-MM-DD.");
    }

    // Evitar SQL Injection
    $nombre = $conn->real_escape_string($nombre);
    $apellidos = $conn->real_escape_string($apellidos);
    $direccion = $conn->real_escape_string($direccion);
    $telefono = $conn->real_escape_string($telefono);
    $email = $conn->real_escape_string($email);
    $fnac = $conn->real_escape_string($fnac);
    $estadoCivil = $conn->real_escape_string($estadoCivil);

    // Consultas preparadas para evitar SQL injection
    $sql = "INSERT INTO contacto (Nombcontacto, Apecontacto, Direccion, Telefono, Email, FNac, EstadoCivil) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
            -- 1️ CREAR BASE DE DATOS
CREATE DATABASE IF NOT EXISTS registro_contactos;

-- Usar la base de datos recién creada
USE registro_contactos;

-- 2 CREAR TABLA 'contacto'
CREATE TABLE contacto (
    Codcontacto INT AUTO_INCREMENT PRIMARY KEY,
    Nombcontacto VARCHAR(50) NOT NULL,
    Apecontacto VARCHAR(50) NOT NULL,
    Direccion VARCHAR(100) NOT NULL,
    Telefono VARCHAR(15) NOT NULL,
    Email VARCHAR(100) NOT NULL,
    FNac DATE NOT NULL,
    EstadoCivil VARCHAR(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


    // Preparar la consulta
    $stmt = $conn->prepare($sql);

    if ($stmt) {    
        // Enlazar los parámetros
        $stmt->bind_param("sssssss", $nombre, $apellidos, $direccion, $telefono, $email, $fnac, $estadoCivil);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo "✅ Registro exitoso.";
            echo "<br><a href='contacto.html'>Volver al formulario</a>";
        } else {
            echo "❌ Error: " . $stmt->error;
        }

        // Cerrar la declaración
        $stmt->close();
    } else {
        echo "❌ Error al preparar la consulta: " . $conn->error;
    }

} else {
    echo "❌ Error: Faltan datos en el formulario.";
}

// Cerrar conexión
$conn->close();
?>
