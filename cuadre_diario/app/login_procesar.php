<?php
session_start();
include "../db/conexion_db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'], $_POST['contrasena'])) {
    $email = $_POST['email'];
    $contrasena = $_POST['contrasena'];

    $sql = "SELECT id, nombre, email, password FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $usuario = $result->fetch_assoc();
            if (password_verify($contrasena, $usuario['password'])) {
                // Inicio de sesión exitoso, establece las variables de sesión
                $_SESSION['email'] = $usuario['email'];
                $_SESSION['nombre'] = $usuario['nombre'];

                // Redirige al usuario a la página de inicio (index.php)
                header('Location: index.php');
                exit();
            } else {//mensaje error clave incorrecta
                header('Location: ../index.php?error=clave');
            }
        } else {
            header('Location: ../index.php?error=email');
        }
    } else {
        echo "Error en la consulta: " . $conn->error;
    }
}
?>
