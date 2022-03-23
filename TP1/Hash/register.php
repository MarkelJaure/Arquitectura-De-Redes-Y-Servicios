<body>
    <h2>Register en PHP</h2>
    <form method="post">
        <!-- <form method="post" action="authApp.php"> -->

        <br><label>Ingrese su usuario</label>
        <input type="text" name="aUser">
        <br><label>Ingrese su clave</label>
        <input type="text" name="aClave">
        <br>
        <input type="submit" value="Registrarse" name="submit">

    </form>

    <form method="post" action="authApp.php">
        <input type="submit" name="volver" class="button" value="Volver" />
    </form>
</body>

<?php

require_once "lib/config.php";
require "lib/auth.php";

$username = $password = "";

if (isset($_POST['submit'])) {
    $username = $_POST['aUser'];
    $password = $_POST['aClave'];

    if (empty($username) || empty($password)) {
        echo "Completar el usuario y clave";
    } else {
        register($username, $password);
    }
}

?>