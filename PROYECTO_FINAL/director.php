<?php
session_start();
if (empty($_SESSION["id"])) {
    header("location: login.php");
}
require 'database.php';

$id = $_SESSION["id"];
$sql = $conexion->prepare("SELECT ID_Docente, Nombre FROM Docente");
$sql->execute();
$result = $sql->get_result();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Director</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #007bff;
            color: #fff;
            text-align: center;
            padding: 10px;
        }

        .container {
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: #fff;
        }

        .logout-btn {
            background-color: #dc3545;
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
        }

        .welcome-msg {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .view-list-btn {
            display: inline-block;
            padding: 6px 12px;
            background-color: #28a745;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            cur
        sor: pointer;
        }
    </style>
</head>

<body>
    <header>
        <h1>Docente</h1>
    </header>

    <div class="container">
        <div class="float-right">
            <form method="post" action="login.php">
                <input type="submit" class="btn btn-danger logout-btn" value="Salir">
            </form>
        </div>

        <div class="welcome-msg">
            BIENVENIDO <?php echo $_SESSION["nombre"]; ?>
        </div>

        <form method="post" action="director.php">
            <table class="table">
                <thead>
                    <tr>
                        <th>Número</th>
                        <th>ID_Docente</th>
                        <th>Nombre</th>
                        <th>Lista</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $numero = 1; // Inicializar el contador
                    foreach ($result as $row) {
                        echo "<tr>";
                        echo "<td>{$numero}</td>";
                        echo "<td>{$row['ID_Docente']}</td>";
                        echo "<td>{$row['Nombre']}</td>";
                        echo "<td><button class='btn btn-info view-list-btn' data-docente-id='{$row['ID_Docente']}'>Ver Lista</button></td>";
                        echo "</tr>";
                        $numero++; // Incrementar el contador
                    }
                    ?>
                </tbody>
            </table>
            <input type="submit" class="btn btn-primary" value="Guardar">
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function () {
            // Manejar el clic en el botón "Ver Lista"
            $('.view-list-btn').on('click', function () {
                // Obtener el ID del docente desde el atributo de datos
                var docenteId = $(this).data('docente-id');

                // Construir la URL de la ventana emergente (alumnos.php con el ID correspondiente)
                var popupUrl = 'alumnos .php?id=' + docenteId;

                // Abrir la ventana emergente
                window.open(popupUrl, '_blank', 'width=600,height=400,location=no,menubar=no,status=no');
            });
        });
    </script>
</body>

</html>
