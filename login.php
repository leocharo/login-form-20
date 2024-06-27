<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Configuración de la conexión a la base de datos
$host = 'localhost';
$db = 'BD_Asilo';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = "";
$password = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $remember = isset($_POST['remember']);

    // Verifica las credenciales del usuario en la base de datos
    $stmt = $conn->prepare('SELECT ID_Usuario FROM Usuarios WHERE Username = ? AND Password = ?');
    $stmt->bind_param('ss', $username, $password);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Inicio de sesión exitoso
        $_SESSION['username'] = $username;

        if ($remember) {
            setcookie('username', $username, time() + (86400 * 30), "/"); // 86400 = 1 día
        } else {
            setcookie('username', '', time() - 3600, "/"); // Eliminar cookie
        }

        // Redirige a la página de inicio después de iniciar sesión
        header('Location: pagina_inicio.html');
        exit(); // Asegura que no se ejecute más código después de la redirección
    } else {
        $error = "Credenciales incorrectas. Por favor, inténtalo de nuevo.";
    }
    $stmt->close();
} else {
    if (isset($_COOKIE['username'])) {
        $username = $_COOKIE['username'];
    }
}

$conn->close();
?>
