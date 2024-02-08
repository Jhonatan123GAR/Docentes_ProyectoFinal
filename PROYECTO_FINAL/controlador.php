<?php
session_start();
require 'database.php';

if (!empty($_POST["boton"])) {
    if (!empty($_POST["codigo"]) && !empty($_POST["password"])) {
        $usuario = $_POST["codigo"];
        $password = $_POST["password"];

        // Assuming $conexion is your database connection object
        $sql = $conexion->prepare("SELECT * FROM Docente WHERE ID_Docente = ? AND Contrasenia = ?");
        $sql->bind_param("ss", $usuario, $password);
        $sql->execute();
        $result = $sql->get_result();

        if ($result->num_rows > 0) {
            $datos = $result->fetch_object();
            $_SESSION["nombre"]=$datos->Nombre;
            $_SESSION["id"]=$datos->ID_Docente;

            if ($usuario === 'D00') {
                header("location: director.php");
            } else {
                header("location: docente.php");
            }
        } else {
            echo "<div class='alert alert-danger'>Acceso Denegado</div>";
        }

        $sql->close();
    } else {
        echo "Campos vacios";
    }
}
?>
