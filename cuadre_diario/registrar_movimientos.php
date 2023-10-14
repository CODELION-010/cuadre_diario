<?php
session_start();
include "db/conexion_db.php";

// Verificar si se ha enviado el formulario de retiro
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['monto_retiro'])) {
    $monto_retiro = $_POST['monto_retiro'];

    // Insertar el retiro en la tabla movimientos
    $sql = "INSERT INTO movimientos (monto, tipo) VALUES (?, 'Retiro')";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param('d', $monto_retiro); // 'd' indica que es un valor decimal (monto)
        $stmt->execute();

        // Actualizar el valor base sumando el retiro
        $sql = "UPDATE valor_base SET monto_base = monto_base + ?";
        $stmt2 = $conn->prepare($sql);

        if ($stmt2) {
            $stmt2->bind_param('d', $monto_retiro);
            $stmt2->execute();

            // Redireccionar a la página principal después de registrar el retiro
            header('Location: index.php');
            exit();
        } else {
            echo "Error en la consulta de actualización: " . $conn->error;
        }
    } else {
        echo "Error en la consulta de inserción: " . $conn->error;
    }
}

// Verificar si se ha enviado el formulario de depósito
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['monto_deposito'])) {
    $monto_deposito = $_POST['monto_deposito'];

    // Insertar el depósito en la tabla movimientos
    $sql = "INSERT INTO movimientos (monto, tipo) VALUES (?, 'Depósito')";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param('d', $monto_deposito); // 'd' indica que es un valor decimal (monto)
        $stmt->execute();

        // Actualizar el valor base restando el depósito
        $sql = "UPDATE valor_base SET monto_base = monto_base - ?";
        $stmt2 = $conn->prepare($sql);

        if ($stmt2) {
            $stmt2->bind_param('d', $monto_deposito);
            $stmt2->execute();

            // Redireccionar a la página principal después de registrar el depósito
            header('Location: index.php');
            exit();
        } else {
            echo "Error en la consulta de actualización: " . $conn->error;
        }
    } else {
        echo "Error en la consulta de inserción: " . $conn->error;
    }
}
?>
