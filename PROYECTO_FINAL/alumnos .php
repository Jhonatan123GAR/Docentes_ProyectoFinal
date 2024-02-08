<?php
// Realiza la conexión a la base de datos (asegúrate de tener un archivo database.php válido)
require 'database.php';

// Verifica si se proporciona el parámetro "id" en la URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    // Redirige a una página de error si no se proporciona el parámetro
    header("Location: error.php");
    exit();
}

$idDocente = $_GET['id'];

// Si se envió un formulario de agregar tutoría
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['agregar_tutoria'])) {
    // Verifica que se hayan enviado todos los datos necesarios
    if (isset($_POST['id_alumno_agregar'], $_POST['fecha_agregar'], $_POST['hora_agregar'])) {
        // Obtiene los datos del formulario
        $idAlumnoAgregar = $_POST['id_alumno_agregar'];
        $fechaAgregar = $_POST['fecha_agregar'];
        $horaAgregar = $_POST['hora_agregar'];

        // Prepara la consulta para agregar una nueva tutoría
        $sqlAgregar = $conexion->prepare("INSERT INTO tutorias (ID_Docente, ID_Alumno, Fecha, Hora) VALUES (?, ?, ?, ?)");
        $sqlAgregar->bind_param("ssss", $idDocente, $idAlumnoAgregar, $fechaAgregar, $horaAgregar);

        // Ejecuta la consulta para agregar la nueva tutoría
        if ($sqlAgregar->execute()) {
            // Redirige a la página de alumnos con el ID del docente
            header("Location: alumnos .php?id=$idDocente");
            exit(); 
        } else {
            // Muestra un mensaje de error si la consulta falla
            echo "Error al agregar la tutoría: " . $conexion->error;
        }
    } else {
        // Muestra un mensaje si faltan datos en el formulario
        echo "Por favor, complete todos los campos del formulario.";
    }
}


// Realiza la conexión a la base de datos (asegúrate de tener un archivo database.php válido)
require 'database.php';

// Verifica si se proporciona el parámetro "id" en la URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    // Redirige a una página de error si no se proporciona el parámetro
    header("Location: error.php");
    exit();
}

$idDocente = $_GET['id'];

// Si no se envió una búsqueda, obtener todos los alumnos asociados al docente
$sql = $conexion->prepare("SELECT t.ID_Tutoria, t.ID_Alumno, a.Nombre, t.Fecha, t.Hora, t.Asistencia, t.Observacion
                        FROM tutorias t
                        JOIN alumno a ON t.ID_Alumno = a.ID_Alumno
                        WHERE t.ID_Docente = ?");
$sql->bind_param("s", $idDocente);
$sql->execute();
$result = $sql->get_result();

// Manejar la eliminación si se envió un formulario de eliminar
if (isset($_POST['eliminar_tutoria'])) {
    $idTutoriaEliminar = $_POST['id_tutoria_eliminar'];

    // Consulta para eliminar la tutoría por ID
    $sqlEliminar = $conexion->prepare("DELETE FROM tutorias WHERE ID_Tutoria = ?");
    $sqlEliminar->bind_param("s", $idTutoriaEliminar);
    
    // Ejecutar la consulta
    if ($sqlEliminar->execute()) {
        // Redirigir para evitar envíos de formulario repetidos al recargar la página
        header("Location: alumnos .php?id=$idDocente");
        exit();
    } else {
        // Mostrar mensaje de error si la eliminación falla
        echo "Error al eliminar la tutoría: " . $conexion->error;
    }
}
// Si no se envió un formulario de agregar tutoría o si ocurrió un error en el proceso,
// obtener todos los alumnos asociados al docente
$sql = $conexion->prepare("SELECT t.ID_Tutoria, t.ID_Alumno, a.Nombre, t.Fecha, t.Hora, t.Asistencia, t.Observacion
                        FROM tutorias t
                        JOIN alumno a ON t.ID_Alumno = a.ID_Alumno
                        WHERE t.ID_Docente = ?");
$sql->bind_param("s", $idDocente);
$sql->execute();
$result = $sql->get_result();

// Obtener todos los códigos de alumnos que no tienen tutoría asociada
$sqlAlumnosSinTutoria = "SELECT ID_Alumno FROM alumno WHERE ID_Alumno NOT IN (SELECT ID_Alumno FROM tutorias)";
$resultAlumnosSinTutoria = $conexion->query($sqlAlumnosSinTutoria);
$alumnosSinTutoria = $resultAlumnosSinTutoria->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Lista de Alumnos</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        form {
            margin-bottom: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .btn {
            display: inline-block;
            padding: 8px 16px;
            text-decoration: none;
            background-color: #4285f4;
            color: #ffffff;
            border-radius: 4px;
        }

        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            justify-content: center;
            align-items: center;
        }

        .popup {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }
    </style>
    <!-- Agrega cualquier estilo adicional para tu ventana emergente aquí -->
</head>
<body>
    <?php require 'partials/header.php' ?>
    <div style="position: absolute; top: 10px; right: 10px;">
        <a href="javascript:history.go(-1)">Volver</a>
    </div>
    <h1>Lista de Alumnos</h1>

    <!-- Formulario para agregar una nueva tutoría -->
    <form method="post" action="">
        <label for="id_alumno_agregar">Alumno:</label>
        <select name="id_alumno_agregar" id="id_alumno_agregar" required>
            <?php foreach ($alumnosSinTutoria as $alumno) : ?>
                <option value="<?php echo $alumno['ID_Alumno']; ?>"><?php echo $alumno['ID_Alumno']; ?></option>
            <?php endforeach; ?>
        </select>
        
        <label for="fecha_agregar">Fecha:</label>
        <input type="date" name="fecha_agregar" id="fecha_agregar" required>

        <label for="hora_agregar">Hora:</label>
        <input type="time" name="hora_agregar" id="hora_agregar" required>
        
        <input type="submit" name="agregar_tutoria" value="Agregar Tutoría">
    </form>

    <table border="1">
        <tr>
            <th>Número</th>
            <th>ID_Alumno</th>
            <th>Nombre</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Asistencia</th>
            <th>Observacion</th>
            <th>Acciones</th> <!-- Nueva columna para acciones -->
        </tr>
        <?php
        $numero = 1; // Inicializar el contador
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>{$numero}</td>";
            echo "<td>{$row['ID_Alumno']}</td>";
            echo "<td>{$row['Nombre']}</td>";
            echo "<td>{$row['Fecha']}</td>";
            echo "<td>{$row['Hora']}</td>";
            echo "<td>{$row['Asistencia']}</td>";
            echo "<td>{$row['Observacion']}</td>";

            // Agregar botón de eliminar
            echo "<td>";
            echo "<form method='post' action=''>";
            echo "<input type='hidden' name='id_tutoria_eliminar' value='{$row['ID_Tutoria']}'>";
            echo "<input type='submit' name='eliminar_tutoria' value='Eliminar'>";
            echo "</form>";
            echo "</td>";

            echo "</tr>";
            $numero++; // Incrementar el contador
        }
        ?>
    </table>
    <div>
        <button type="button" class="btn btn-primary" onclick="imprimir()">Imprimir</button>
    </div>

    <!-- Agrega cualquier script adicional necesario para tu ventana emergente aquí -->
    <script>
        function imprimir() {
            window.print();
        }
    </script>

</body>
</html>
