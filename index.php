<?php
require 'analizar.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Ecuaciones Diferenciales</title>
    <link rel="stylesheet" href="estilos.css">

</head>
<body>

    <div class="contenedor">
        <h1>Clasificar Ecuaciones Diferenciales</h1>
        
        <div class="instrucciones">
            <p><strong>Formato permitido para las ecuaciones:</strong></p>
            <ul>
                <li>(dy/dx)^2 + y = 0</li>
                <li>(d1y/dx1)^3 + y = 0</li>
                <li>(d2y/dx2)^4 + y = 0</li>
                <li>y'' + y = 0</li>
            </ul>
            <p class="nota">
                Nota: para calcular el grado, la derivada debe estar elevada a una potencia.
            </p>
        </div>
        
        <form method="post" class="formulario">
            <label>Ingresa la ecuación diferencial:</label><br>
            <input type="text" name="ecuacion" required>
            <br><br>
            <button type="submit">Clasificar</button>
        </form>

        <?php
            // RESPUESTA
            if (isset($_POST['ecuacion'])) { 
                $ecuacion = $_POST['ecuacion'];

                $orden = obtenerOrden($ecuacion);
                $grado = obtenerGrado($ecuacion);
                $linealidad = esLineal($ecuacion) ? "Lineal" : "No lineal";
                $tipo = obtenerTipo($ecuacion);

                echo "<div class='resultado'>";

                echo "<p class='ecuacion-usada'><strong>Ecuación ingresada:</strong><br>"
                    . htmlspecialchars($ecuacion) .
                    "</p>";

                echo "<hr>";

                echo "<p>Orden de la ecuación: <strong>$orden</strong></p>";
                echo "<p>Grado de la ecuación: <strong>$grado</strong></p>";
                echo "<p>Linealidad: <strong>$linealidad</strong></p>";
                echo "<p>Tipo de ecuación: <strong>$tipo</strong></p>";

                echo "</div>";
            }
        ?>

    </div>




</body>
</html>
