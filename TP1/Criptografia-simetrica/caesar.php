<html>

<head>
    <link rel="stylesheet" href="../styles.css">
</head>

<body>
    <h2>Cifrado Caesar</h2>

    <form method="post" action="caesar.php">

        <label class="label1">Seleccionado: </label>
        <span class="cifrarLabel" id="my-checkbox-unchecked" style="display:inline-block; background-color:#28BF23; margin-left:32px">Descifrar</span>
        <input class="input1" id="my-checkbox" type="checkbox" name="isCifrarActivated" onclick="ChangeCheckboxLabel(this)">
        <span class="cifrarLabel" id="my-checkbox-checked" style="display:inline-block; background-color:#DCDCDC">Cifrar</span>

        <br><label class="label1">Ingrese la clave:</label>
        <input class="input1" type="number" min=0 name="aClave" placeholder="Ingrese la clave (numero)..." style="margin-left:10px">

        <br><label class="label1">Ingrese su mensaje</label>
        <input class="input1" type="text" name="aMensaje" placeholder="Ingrese el mensaje...">

        <br><input type="submit" class="button1" value="Codificar" name="submit">
    </form>

    <script>
        function ChangeCheckboxLabel(ckbx) {
            var d = ckbx.id;
            if (ckbx.checked) {
                document.getElementById(d + "-checked").style.backgroundColor = "#28BF23";
                document.getElementById(d + "-unchecked").style.backgroundColor = "#DCDCDC";
            } else {
                document.getElementById(d + "-checked").style.backgroundColor = "#DCDCDC";
                document.getElementById(d + "-unchecked").style.backgroundColor = "#28BF23";
            }
        }
    </script>

    <?php
    require 'lib/cifrador.php';

    if (isset($_POST['submit'])) {

        $isCifrar = isset($_POST['isCifrarActivated']) ? True : False;

        echo cifrar($_POST['aMensaje'], (int)$_POST['aClave'], $isCifrar);
    }
    ?>
</body>

</html>