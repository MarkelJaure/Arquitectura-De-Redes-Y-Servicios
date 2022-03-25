<html>

<head>
    <link rel="stylesheet" href="../styles.css">
</head>

<body>
    <h2>Descifrador a Fuerza Bruta</h2>

    <form method="post" action="fuerzaBruta.php">

        <br><label class="label1"> Ingrese su mensaje</label>
        <input class="input1" type="text" name="aMensaje" placeholder="Ingrese el mensaje...">
        <br>
        <input class="button1" type="submit" value="Decodificar" name="submit">

    </form>

    <?php
    require 'lib/decodificador.php';

    if (isset($_POST['submit'])) {

        $bestMessage = descifrarAFuerzaBruta($_POST['aMensaje']);
        echo "El mensaje decodificado mas probable es: $bestMessage[0]";
        echo "<br>";
        echo "Con la clave: $bestMessage[1]";
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