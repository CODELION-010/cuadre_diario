<?php
session_start();
// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['email'])) {
    // Si no ha iniciado sesión, redirige al usuario a la página de inicio de sesión.
    header('Location: ../index.php');
    exit();
}
include "../db/conexion_db.php";


// Consultar registros de la tabla "movimientos"
$query = "SELECT id, monto, tipo, DATE_FORMAT(fecha, '%Y-%m-%d %h:%i %p') AS fecha FROM movimientos";
$result = $conn->query($query);

// Comprobar si hay registros
if ($result && $result->num_rows > 0) {
    // Mostrar los registros en una tabla
    echo "<table>";
    echo "<tr><th>ID</th><th>Monto</th><th>Tipo</th><th>Fecha</th></tr>";

    while ($row = $result->fetch_assoc()) {
        $id = $row['id'];
        $monto = $row['monto'];
        $tipo = $row['tipo'];
        $fecha = $row['fecha'];

        echo "<tr>";
        echo "<td>$id</td>";
        echo "<td>$monto</td>";
        echo "<td>$tipo</td>";
        echo "<td>$fecha</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "<h2>No se encontraron registros.</h2>";
}

$conn->close();

?>
