<html>

<body>
    <h2>Auth en PHP</h2>
    <form method="post" action="register.php">
        <input type="submit" name="register" class="button" value="Registrarse" />
    </form>
    <form method="post" action="login.php">
        <input type="submit" name="login" class="button" value="Iniciar sesion" />
    </form>

</body>

<?php

if (isset($_POST['register'])) {
    echo "register";
}

if (isset($_POST['login'])) {
    echo "login";
}
?>

</html>