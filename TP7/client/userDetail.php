<html>

<head>
    <link rel="stylesheet" href="styles.css">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
</head>

<?php
require_once "callAPI.php";

$logguedUser = getLogguedUser();
if (empty($logguedUser)) {
    echo "No se encuentra logueado";
} else {
    echo "Logueado como: " . $logguedUser["email"];
?>

<?php
}
?>

<?php
require_once "callAPI.php";

$id = getParam("id");

$get_data = callAPI('GET',  $apiURL . "users/" . $id, false);
$response = json_decode($get_data, true);
$actualUser = new User();
if ($response !== null) {
    $actualUser->id = $response["id"];
    $actualUser->email = $response["email"];
    $actualUser->password = $response["password"];
    $actualUser->firstName = $response["firstName"];
    $actualUser->lastName = $response["lastName"];
    $actualUser->permissionLevel = $response["permissionLevel"];
} else {
    $actualUser->id = "";
    $actualUser->email = "";
    $actualUser->password = "";
    $actualUser->firstName = "";
    $actualUser->lastName = "";
    $actualUser->permissionLevel = "";
}
?>

<body>

    <h2><?php echo ($id !== null) ? 'Editando: ' . $actualUser->email  : 'Nuevo usuario'; ?></h2>

    <form method="POST">

        <input class="input1" type="text" name="aId" hidden=true placeholder="Ingrese su email..." value="<?php echo $actualUser->id ?>">

        <br><label>Ingrese su email:</label>
        <input style="margin-left: 74px" class="input1" type="email" name="aEmail" placeholder="Ingrese su email..." value="<?php echo $actualUser->email ?>" required>

        <br><label>Ingrese su clave:</label>
        <input style="margin-left: 75px" class="input1" type="password" name="aClave" placeholder="Ingrese clave..." value="<?php echo $actualUser->password ?>" required>

        <br><label>Ingrese su primer nombre:</label>
        <input style="margin-left: 14px" class="input1" type="text" name="aFirstName" placeholder="Ingrese su primer nombre..." value="<?php echo $actualUser->firstName ?>">

        <br><label>Ingrese su apellido:</label>
        <input style="margin-left: 58px" class="input1" type="text" name="aLastName" placeholder="Ingrese su apellido..." value="<?php echo $actualUser->lastName ?>">

        <br><label>Ingrese su nivel de permiso:</label>
        <input class="input1" type="number" name="aPermissionLevel" placeholder="Ingrese su nivel de permiso..." value="<?php echo $actualUser->permissionLevel ?>">

        <?php //Mostrar boton solo si estas creando usuario o sos admin
        if ($id === null || (!empty($logguedUser["permissionLevel"]) && $logguedUser["permissionLevel"] == PermissionLevelEnum::ADMIN_PERMISSION->value)) {
        ?>

            <br> <input style="margin-left: 30px" class="login-button" name="submit" type="submit" value="<?php echo ($id !== null) ? 'Editar usuario' : 'Crear usuario'; ?>">

        <?php
        }
        ?>

        <?php

        if (isset($_POST['submit'])) {

            $theId = $_POST['aId'];
            $email = $_POST['aEmail'];
            $password = $_POST['aClave'];
            $firstName = $_POST['aFirstName'];
            $lastName = $_POST['aLastName'];
            $permissionLevel = $_POST['aPermissionLevel'];

            if (empty($email) || empty($password)) {
                echo "Email: " . $email . "\n";
                echo "Password: " . $password . "\n";
                echo "Completar el email y password";
            } else {
                $newUser = new User();
                $newUser->email = $email;
                $newUser->firstName = $firstName;
                $newUser->lastName = $lastName;
                $newUser->permissionLevel = $permissionLevel;
                $newUser->password = $password;

                if ($theId !== "") { //Editar usuario (PUT / PATCH)
                    echo "Actualizando Usuario";
                    $put_data = callAPI('PUT', $apiURL . "users/" . $theId, json_encode($newUser));
                } else { //Crear usuario (POST)
                    echo "Creando Usuario";

                    $post_data = callAPI('POST', $apiURL . "users/", json_encode($newUser));
                }
                header("Location: usersList.php");
            }
        }

        ?>

    </form>

    <form method="post" action="usersList.php">
        <input style="margin-left: 30px" class="volver" type="submit" name="volver" class="button" value="Volver" />
    </form>

    <form method="post" action=<?php echo "booksList.php?id=" . $actualUser->id; ?>>
        <input style="margin-left: 30px" class="add-button" type="submit" name="volver" class="button" value="Ver libros" />
    </form>

</body>

</html>