<html>

<body>
    <h2>Cifrado Vigenere</h2>

    <form method="post" action="vigenere.php">

        <label>Descifrar=Uncheck Cifrar=Chech</label>
        <input type="checkbox" name="isCifrarActivated">
        <br><label>Ingrese la clave (tipo string)</label>
        <input type="text" min=0 name="aClave">
        <br><label>Ingrese su mensaje</label>
        <input type="text" name="aMensaje">
        <br>
        <input type="submit" value="click" name="submit"> <!-- assign a name for the button -->
    </form>

    <?php
    require 'lib/cifradorVigenere.php';

    if (isset($_POST['submit'])) {

        $isCifrar = isset($_POST['isCifrarActivated']) ? True : False;

        echo cifrarVigenere($_POST['aMensaje'], $_POST['aClave'], $isCifrar);
    }
    ?>
</body>

</html>