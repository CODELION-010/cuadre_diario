<?php
session_start();
// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['correo'])) {
    // Si no ha iniciado sesión, redirige al usuario a la página de inicio de sesión.
    header('Location: login.php');
    exit();
}
include "db/conexion_db.php";

// Obtener el último valor registrado en la tabla valor_base
$sql = "SELECT monto_base FROM valor_base ORDER BY id DESC LIMIT 1";
$result = $conn->query($sql);

// Verificar si la consulta fue exitosa
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $monto_base_actual = $row['monto_base'];
} else {
    echo "Error en la consulta: " . $conn->error;
}

// Consultar todos los movimientos
$sql_movimientos = "SELECT * FROM movimientos";
$result_movimientos = $conn->query($sql_movimientos);

// Verificar si la consulta de movimientos fue exitosa
if ($result_movimientos && $result_movimientos->num_rows > 0) {
    $movimientos = $result_movimientos->fetch_all(MYSQLI_ASSOC);
} else {
    echo "Error en la consulta de movimientos: " . $conn->error;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Movimientos Bancarios</title>
</head>

<body>
    <!-- Mostrar el valor base en pantalla -->
    <h2>Valor Base Actual:
        <?php echo $monto_base_actual; ?>
    </h2>

    <!-- Formulario para registrar el monto base -->
    <h2>Registre su monto base</h2>
    <form action="registrar_base.php" method="post">
        <input type="number" name="monto_base" id="monto_base">
        <button type="submit">Registrar</button>
    </form>
    <br>
    <!-- Formulario para registrar retiro -->
    <h2>Registrar Retiro</h2>
    <form action="" method="post">
        <input type="number" name="monto_retiro" id="monto_retiro">
        <button type="submit" name="retiro">Retiro</button>
    </form>

    <!-- Formulario para registrar depósito -->
    <h2>Registrar Depósito</h2>
    <form action="" method="post">
        <input type="number" name="monto_deposito" id="monto_deposito">
        <button type="submit" name="deposito">Depósito</button>
    </form>
    <br>
    <!-- Botón para consultar movimientos -->
<h2>Consultar Movimientos</h2>
<form action="" method="post">
    <button type="submit" name="consulta_movimientos">Consultar</button>
</form>

    <!-- Tabla de movimientos -->
    <table>
        <tr>
            <th>ID</th>
            <th>Monto</th>
            <th>Tipo</th>
            <th>Fecha</th>
        </tr>
        <?php foreach ($movimientos as $movimiento) : ?>
            <tr>
                <td><?php echo $movimiento['id']; ?></td>
                <td><?php echo $movimiento['monto']; ?></td>
                <td><?php echo $movimiento['tipo']; ?></td>
                <td><?php echo $movimiento['fecha']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

</body>

</html>
