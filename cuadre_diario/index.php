
<?php
session_start();

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['email'])) {
    // Si no ha iniciado sesión, redirige al usuario a la página de inicio de sesión.
    header('Location: index.html');
    exit();
}
// Variables de sesión ya establecidas (correo y nombre) disponibles para su uso.
$correo = $_SESSION['email'];
$nombre = $_SESSION['nombre'];
echo" Bienvenido . $nombre";

include "db/conexion_db.php";

// Obtener el último valor registrado en la tabla valor_base
$sql = "SELECT monto_base FROM valor_base ORDER BY id DESC LIMIT 1";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $monto_base_actual = $result->fetch_assoc()['monto_base'];
} else {
    $monto_base_actual = 0; // Valor predeterminado si no hay registros en la tabla
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Movimientos Bancarios</title>
    <link rel="stylesheet" href="css/stylephp.css">
</head>

<body>
<a href="cerrar_sesion.php">Cerrar Sesión</a>
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
    <form action="registrar_movimientos.php" method="post">
        <input type="number" name="monto_retiro" id="monto_retiro">
        <button type="submit" name="retiro">Retiro</button>
    </form>

    <!-- Formulario para registrar depósito -->
    <h2>Registrar Depósito</h2>
    <form action="registrar_movimientos.php" method="post">
        <input type="number" name="monto_deposito" id="monto_deposito">
        <button type="submit" name="deposito">Depósito</button>
    </form>
    <br>
    <!-- Botón para consultar movimientos -->
<h2>Consultar Movimientos</h2>
<form action="consultar_movimientos.php" method="post">
    <button type="submit" name="consulta_movimientos">Consultar</button>
</form>
<!-- Botón para borrar los registros de la tabla movimientos -->
<h2>Borrar Registros de la Tabla Movimientos</h2>
<form action="borrar_registros.php" method="post">
    <button type="submit" name="borrar_registros">Borrar Registros</button>
</form>
</body>
</html>