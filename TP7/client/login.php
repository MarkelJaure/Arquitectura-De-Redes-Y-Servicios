<head>
    <link rel="stylesheet" href="./styles.css">
</head>

<body>
    <h2>Login en PHP</h2>
    <form method="post">

        <br><label>Ingrese su email:</label>
        <input class="input1" type="email" name="aEmail" placeholder="Ingrese su email..." required>
        <br><label>Ingrese su clave:</label>
        <input class="input1" type="text" name="aClave" placeholder="Ingrese su clave..." required>
        <br>
        <input class="login-button" type="submit" value="Iniciar sesion" name="submit">

    </form>

    <form method="post" action="usersList.php">
        <input class="volver" type="submit" name="volver" class="button" value="Volver" />
    </form>
</body>

<?php
require_once "callAPI.php";

$user = getLogguedUser();
if (empty($user)) {
    echo "No se encuentra logueado";
} else {
    echo "Logueado como: " . $user["email"];

?>

<?php
}
?>

<?php

require_once "callAPI.php";

$email = $password = "";

if (isset($_POST['submit'])) {
    $email = $_POST['aEmail'];
    $password = $_POST['aClave'];

    if (empty($email) || empty($password)) {
        echo "Completar el email y clave";
    } else {
        $loginUser = array('email' => $email, 'password' => $password);
        $post_data = callAPI('POST', $apiURL . "auth", json_encode($loginUser));
        $loginResponse = json_decode($post_data, true);

        if (!empty($loginResponse["error"])) {
            echo $loginResponse["error"];
        } else {
            setcookie("accessToken", $loginResponse["accessToken"]);
            setcookie("refreshToken", $loginResponse["refreshToken"]);
            header("Location: usersList.php");
        }
    }
}

?>