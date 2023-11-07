
<?php
session_start();
include "../db/conexion_db.php";
// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['email']) && !isset($_SESSION['user_id'])) {
    // Si no ha iniciado sesión, redirige al usuario a la página de inicio de sesión.
    header('Location: ../index.php');
    exit();
}
          $user_id = $_SESSION['user_id'];
          $correo = $_SESSION['email'];
          $nombre = $_SESSION['nombre'];
         



// Obtener el último valor registrado en la tabla valor_base
$sql = "SELECT * FROM valor_base WHERE user_id = $user_id ORDER BY id DESC LIMIT 1";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $monto_base_actual = $result->fetch_assoc()['monto_base'];
    $monto_base_actual = number_format($monto_base_actual, 0, ',', '.');
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/styleapp.css">
    <title>Registro Movimientos Bancarios</title>
</head>

<body>
       <!-- encabezado o header-->
<header class="header" >
     <!-- Mostrar el valor base en tiempo actual -->
      <h1>Base Registrada:<?php echo "$ $monto_base_actual"; ?></h1>
         
    <!--boton con nombre bienvenido y menu de perfil usuario-->
    <div class="dropdown">
      <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?php echo "Bienvenido . $nombre"; ?>
      </button>
      <ul class="dropdown-menu" style="">
        <li><a class="dropdown-item" href="#">Perfil</a></li><!-- Futuras funciones -->
        <li><a class="dropdown-item" href="#">Adquiere Premiun</a></li><!-- Futuras funciones -->
        <li><a class="dropdown-item" href="cerrar_sesion.php">Cerrar Sesion</a></li>
      </ul>
    </div>
</header>

<div class="barra_lateral" >
<a href="javascript:abrirCalculadora()" class="cal_barra" data-icon="../img/calculadora.png"
        title="Calculadora PHP">Calculadora</a>
</div>

<!--seccion de formularios--->
<section class="forms">

 <!-- Formulario para registrar el monto base -->
    <div id="mont_base" >
      <h2>Registra Monto Base</h2>
      <form action="registrar_base.php" method="post">
          <input type="number" name="monto_base" id="monto_base" required="yes" min="1000000" >
          <button type="submit" class="btn btn-outline-info" onclick="sinvalor()" >Registrar</button>
      </form>
    </div>

    <!-- Formulario para registrar retiro -->
   <div id="reg_retiro" >
    <h2>Registrar Retiro</h2>
    <form action="registrar_movimientos.php" method="post">
        <input type="number" name="monto_retiro" id="monto_retiro" required="yes" min="1500" >
        <button type="submit" name="retiro" class="btn btn-outline-info">Retiro</button>
    </form>
   </div>

   <!-- Formulario para registrar depósito -->
   <div id="reg_deposito" >
    <h2>Registrar Depósito</h2>
    <form action="registrar_movimientos.php" method="post">
        <input type="number" name="monto_deposito" id="monto_deposito"  required="yes" min="10000" >
        <button type="submit" name="deposito"  class="btn btn-outline-info">Depósito</button>
    </form>
 </div>    
</section>

<!-- seccion de consulta y borrado de registros por medio de ventanas y botones modales -->
<section class="modales">
      <!-- Botón para abrir el modal de consulta de movimientos el cual se expresa en una tabla -->
      <h2>Consulta y Borra los Registros</h2>
   <button type="button" class="btn btn-outline-info" data-toggle="modal" data-target="#modalConsultarMovimientos">
     Consultar Movimientos
   </button>
   <div class="modal fade" id="modalConsultarMovimientos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Registros Actuales</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <tr>
                        <th>ID</th>
                        <th>Valor</th>
                        <th>Tipo</th>
                        <th>Fecha y Hora</th>
                    </tr>
                    <?php
                    // Consultar registros de la tabla "movimientos"
                 // Consultar registros de la tabla "movimientos" para el usuario actual
                 $query = "SELECT id, monto, tipo, DATE_FORMAT(fecha, '%Y-%m-%d %h:%i %p') AS fecha FROM movimientos WHERE user_id = ? ORDER BY fecha DESC";
                 $stmt = $conn->prepare($query);
                 
                 
                 // Comprobar si la consulta preparada fue exitosa
                 if ($stmt) {
                     // Enlazar el user_id del usuario actual a la consulta
                     $stmt->bind_param('i', $_SESSION['user_id']);
                     $stmt->execute();
                     $result = $stmt->get_result();
                 
                     // Resto de tu código para mostrar los movimientos en la tabla
                     if ($result && $result->num_rows > 0) {
                         while ($row = $result->fetch_assoc()) {
                             $id = $row['id'];
                             $monto = $row['monto'];
                             $tipo = $row['tipo'];
                             $fecha = $row['fecha'];
                             $monto = number_format($monto, 0, ',', '.');
                             
                             echo "<tr>";
                             echo "<td>$id</td>";
                             echo "<td>$ $monto</td>";
                             echo "<td>$tipo</td>";
                             echo "<td>$fecha</td>";
                             echo "</tr>";
                         }
                         echo "</table>";
                     } else {
                         echo "<h2>No se encontraron registros.</h2>";
                     }
                     $stmt->close();
                 } else {
                     echo "Error en la consulta: " . $conn->error;
                 }
                 $conn->close();
                 ?>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


 <!-- Botón para borrar registros -->
 <button type="button" class="btn btn-outline-info" data-toggle="modal" data-target="#modalBorrarRegistros">
  Borrar Registros
  </button>
      <div class="modal fade" id="modalBorrarRegistros" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
       <div class="modal-dialog" role="document">
         <div class="modal-content">
           <div class="modal-header">
             <h5 class="modal-title" id="exampleModalLabel">Borrar Registros</h5>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
             </button>
           </div>
           <div class="modal-body">
             <form action="borrar_registros.php" method="post">
               <input type="hidden" name="borrar_registros" value="1">

               <p>¿Estás seguro de que quieres borrar todos los registros de movimientos? No podras revertir los cambios</p>

               <button type="submit" class="btn btn-danger">Borrar</button>
               <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
             </form>
           </div>
           <div class="modal-footer">
             <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
           </div>
         </div>
       </div>
 </div>
</section>
<footer>
  
</footer>

<script src="../js/main.js"></script>

</body>
</html>


<?php
//validacion de borrado de datos
if (isset($_SESSION['borrado_exitoso']) && $_SESSION['borrado_exitoso'] === true) {
  echo '<script>swal("Listo...","Has borrado todos los registros","success");</script>';
  unset($_SESSION['borrado_exitoso']); // Limpiar la variable de sesión
}


?>