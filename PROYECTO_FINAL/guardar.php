<?php
  session_start();
  require 'database.php';

  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $asistenciaArray = $_POST['asistencia'] ?? [];
    $observacionArray = $_POST['observacion'] ?? [];

    $id = $_SESSION["id"];

    // Assuming tutorias table has primary key ID_Tutoria, adjust it accordingly
    $updateSql = $conexion->prepare("UPDATE tutorias SET Asistencia = ?, Observacion = ? WHERE ID_Docente = ? AND ID_Tutoria = ?");

    foreach ($asistenciaArray as $key => $asistencia) {
      $observacion = $observacionArray[$key] ?? ''; // Default empty string if not set
      $tutoriaId = $key + 1; // Adjust the index to your actual tutoria ID

      $updateSql->bind_param("ssii", $asistencia, $observacion, $id, $tutoriaId);
      $updateSql->execute();
    }

    $updateSql->close();
    $conexion->close();
  }
?>
