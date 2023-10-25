<?php
session_start();


// Obtener el último valor registrado en la tabla valor_base
$sql = "SELECT monto_base FROM valor_base ORDER BY id DESC LIMIT 1";
$stmt = $conn->query($sql);
$monto_base_actual = $stmt->fetchColumn();
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
</body>

</html>
