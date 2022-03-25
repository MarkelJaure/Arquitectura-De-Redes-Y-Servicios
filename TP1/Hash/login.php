<head>
    <link rel="stylesheet" href="../styles.css">
</head>

<body>
    <h2>Login en PHP</h2>
    <form method="post">

        <br><label>Ingrese su usuario:</label>
        <input class="input1" type="text" name="aUser" placeholder="Ingrese su usuario..." required>
        <br><label>Ingrese su clave:</label>
        <input class="input1" type="text" name="aClave" placeholder="Ingrese su clave..." style="margin-left: 15px;" required>
        <br>
        <input class="login-button" type="submit" value="Iniciar sesion" name="submit">

    </form>

    <form method="post" action="authApp.php">
        <input class="volver" type="submit" name="volver" class="button" value="Volver" />
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
        login($username, $password);
    }
}

?>