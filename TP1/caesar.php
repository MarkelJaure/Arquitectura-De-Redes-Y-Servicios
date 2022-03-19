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
    require 'cifrador.php';

    if (isset($_POST['submit'])) {

        $isCifrar = isset($_POST['isCifrarActivated']) ? True : False;

        echo cifrar($_POST['aMensaje'], (int)$_POST['aClave'], $isCifrar);
    }
    ?>
</body>

</html>