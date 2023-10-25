<?php
session_start();
include "../db/conexion_db.php";

// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['monto_base'])) {
    $monto_base = $_POST['monto_base'];

    // Insertar el monto base en la tabla valor_base
    $sql = "INSERT INTO valor_base (monto_base) VALUES (?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param('d', $monto_base); // 'd' indica que es un valor decimal (monto)
        $stmt->execute();

        // Redireccionar a la página principal después de registrar el monto base
        header('Location: index.php');
        exit();
    } else {
        echo "Error en la consulta: " . $conn->error;
    }
}
?>
