<?php
session_start();

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['email'])) {
    // Si no ha iniciado sesión, redirige al usuario a la página de inicio de sesión.
    header('Location: ../index.php');
    exit();
}
// Después de borrar los registros con éxito
session_start();
$_SESSION['borrado_exitoso'] = true;

include "../db/conexion_db.php";

// Verificar si se ha enviado el formulario para borrar los registros de la tabla movimientos
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['borrar_registros'])) {
    // Query para borrar los registros de la tabla movimientos
    $sql = "DELETE FROM movimientos";

    // Ejecutar la consulta
    if ($conn->query($sql)) {
        echo "Registros de la tabla movimientos borrados correctamente.";
    } else {
        echo "Error al borrar los registros de la tabla movimientos: " . $conn->error;
    }
}header('Location: index.php?borrado_exitoso=1');
?>
