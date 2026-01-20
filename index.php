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


            <div class="teclado">
                <button type="button" data-insert="dy/dx">dy/dx</button>
                <button type="button" data-insert="y'">y'</button>
                <button type="button" data-insert="y''">y''</button>
                <button type="button" data-insert="y'''">y'''</button>
                <button type="button" data-insert="^">^</button>
                <button type="button" data-insert="(">(</button>
                <button type="button" data-insert=")">)</button>
                <button type="button" data-insert="+">+</button>
                <button type="button" data-insert="-">−</button>
                <button type="button" data-insert="=0">= 0</button>
            </div>



            <input type="text" name="ecuacion" id="ecuacion" required>

            <!-- <input type="text" name="ecuacion" required> -->
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

<script>
document.querySelectorAll('.teclado button').forEach(btn => {
    btn.addEventListener('click', () => {
        const input = document.getElementById('ecuacion');
        const texto = btn.dataset.insert;

        const start = input.selectionStart;
        const end = input.selectionEnd;

        input.value =
            input.value.substring(0, start) +
            texto +
            input.value.substring(end);

        input.focus();
        input.selectionStart = input.selectionEnd = start + texto.length;
    });
});
</script>

