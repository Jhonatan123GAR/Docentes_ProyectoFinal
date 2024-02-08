<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>BTutorias</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
      body {
        background-image: url('portada.jpg'); /* Reemplaza 'image.jpg' con la ruta correcta de tu imagen */
        background-size: cover;
        background-position: center;
        font-family: 'Roboto', sans-serif;
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100vh; /* Ajusta el tamaño para ocupar toda la altura de la ventana */
      }

      .text-container {
        background-color: rgba(0, 0, 0, 0.5); /* Fondo con opacidad */
        padding: 20px; /* Ajusta el padding del contenedor */
        border-radius: 10px; /* Esquinas redondeadas al contenedor */
        text-align: center;
        margin-top: 20px; /* Ajusta el margen superior del contenedor */
      }

      h1 {
        color: white; /* Cambia el color del texto a blanco */
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7); /* Agrega sombra al texto */
        margin: 0; /* Elimina el margen del h1 para que no haya espacio adicional */
      }

      a {
        display: inline-block;
        padding: 15px 30px; /* Ajusta el padding del botón */
        background-color: #4CAF50; /* Verde oliva, similar al color del texto */
        color: white;
        text-decoration: none;
        border-radius: 5px; /* Esquinas redondeadas al botón */
        transition: background-color 0.3s ease; /* Transición suave al color de fondo */
        font-size: 18px; /* Tamaño de fuente del botón */
      }

      a:hover {
        background-color: #45a049; /* Cambia el color de fondo al pasar el ratón sobre el botón */
      }
    </style>
  </head>
  <body>
    <div class="text-container">
      <h1>Optimización del Sistema de Tutorías</h1>
      <h1>en Informática</h1>
      <a href="login.php">Iniciar sesión</a> 
    </div>
  </body>
</html>
