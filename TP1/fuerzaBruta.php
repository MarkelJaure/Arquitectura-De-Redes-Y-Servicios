<html>

<body>
    <h2>Descifrador a Fuerza Bruta</h2>

    <form method="post" action="fuerzaBruta.php">

        <br><label>Ingrese su mensaje</label>
        <input type="text" name="aMensaje">
        <br>
        <input type="submit" value="click" name="submit">

    </form>

    <?php
    require 'decodificador.php';

    if (isset($_POST['submit'])) {

        $bestMessage = descifrarAFuerzaBruta($_POST['aMensaje']);
        echo "El mensaje decodificado mas probable es: ";
        echo $bestMessage[0];
        echo "<br>";
        echo "Con la clave: ";
        echo $bestMessage[1];
        //echo "<br>";

        // $allPosibles = getAllPosiblesMessages($_POST['aMensaje']);
        // foreach ($allPosibles as $posible) {
        //     echo $posible;
        //     echo "<br>";
        // }
    }
    ?>
</body>

</html>