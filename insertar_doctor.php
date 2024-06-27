<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "root"; // Cambia esto si tu usuario es diferente
$password = ""; // Cambia esto si tu contraseña es diferente
$dbname = "Base_Asilo";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos del formulario
$nombre = $_POST['nombre'];
$especialidad = $_POST['especialidad'];
$numero_licencia = $_POST['numero_licencia'];
$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash de la contraseña

// Insertar datos en la tabla 'doctores'
$sql_doctor = "INSERT INTO doctores (nombre, especialidad, numero_licencia) VALUES ('$nombre', '$especialidad', '$numero_licencia')";

if ($conn->query($sql_doctor) === TRUE) {
    $doctor_id = $conn->insert_id; // Obtener el ID del doctor insertado

    // Insertar datos en la tabla 'usuarios'
    $sql_usuario = "INSERT INTO usuarios (doctor_id, username, password) VALUES ('$doctor_id', '$username', '$password')";
    if ($conn->query($sql_usuario) === TRUE) {
        echo "Nuevo doctor agregado exitosamente";
    } else {
        echo "Error: " . $sql_usuario . "<br>" . $conn->error;
    }
} else {
    echo "Error: " . $sql_doctor . "<br>" . $conn->error;
}

$conn->close();
?>
