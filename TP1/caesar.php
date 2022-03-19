<html>

<body>
    <h2>Cifrado Caesar</h2>

    <form method="post" action="caesar.php">

        <label>Descifrar=Uncheck Cifrar=Chech</label>
        <input type="checkbox" name="isCifrarActivated">
        <br><label>Ingrese la clave (tipo numerica)</label>
        <input type="number" min=0 name="aClave">
        <br><label>Ingrese su mensaje</label>
        <input type="text" name="aMensaje">
        <br>
        <input type="submit" value="click" name="submit"> <!-- assign a name for the button -->
    </form>

    <?php


    function cifrar($aMessage, $aKey, $isCifrarActivated)
    {
        $arrayOfLetras = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "ñ", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");

        $aPalabrasCifradas = explode(" ", $aMessage);

        for ($n = 0; $n < count($aPalabrasCifradas); $n++) {

            $aMessageCifrado = str_split($aPalabrasCifradas[$n]);
            for ($i = 0; $i < count($aMessageCifrado); $i++) {

                $indexOfLetra = array_search($aMessageCifrado[$i], $arrayOfLetras);
                $modOfArrayOfLetras = count($arrayOfLetras);

                if ($isCifrarActivated) {
                    $aMessageCifrado[$i] = $arrayOfLetras[((int)$indexOfLetra + $aKey) % $modOfArrayOfLetras];
                } else {
                    $abs = ((int)$indexOfLetra - $aKey) % $modOfArrayOfLetras;
                    if ($abs < 0) {
                        $abs += $modOfArrayOfLetras;
                    }
                    $aMessageCifrado[$i] = $arrayOfLetras[$abs];
                }
            }
            $aPalabrasCifradas[$n] = join("", $aMessageCifrado);
        }

        return join(" ", $aPalabrasCifradas);
    }
    if (isset($_POST['submit'])) {

        $isCifrar = isset($_POST['isCifrarActivated']) ? True : False;
        $return = cifrar($_POST['aMensaje'], (int)$_POST['aClave'], $isCifrar);

        echo $return;
    }
    ?>
</body>

</html>