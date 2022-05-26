<html>

<head>
    <link rel="stylesheet" href="styles.css">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
</head>

<body>

    <?php
    require_once "callAPI.php";

    $id = getParam("id");
    $apiURL = 'http://localhost:3000/users/';

    $get_data = callAPI('GET', $apiURL . $id, false);
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
        $actualUser->id = null;
        $actualUser->email = "";
        $actualUser->password = "";
        $actualUser->firstName = "";
        $actualUser->lastName = "";
        $actualUser->permissionLevel = "";
    }


    ?>

    <h2><?php if ($id !== null) {

            echo "Editando usuario: " . $actualUser->email;
        } else {
            echo "Creando usuario";
        } ?></h2>

    <form method="post">

        <br><label>Ingrese su email:</label>
        <input class="input1" type="email" name="aEmail" placeholder="Ingrese su email..." value="<?php echo $actualUser->email ?>" required>


        <?php if ($id !== null) { ?>
            <br><label>Cambiar clave:</label>
            <input class="input1" type="text" name="aNewClave" placeholder="Ingrese una nueva clave...">
        <?php } else { ?>
            <br><label>Ingrese su clave:</label>
            <input class="input1" type="text" name="aClave" placeholder="Ingrese clave..." required>
        <?php } ?>

        <br><label>Ingrese su primer nombre:</label>
        <input class="input1" type="text" name="aFirstName" placeholder="Ingrese su primer nombre..." value="<?php echo $actualUser->firstName ?>">

        <br><label>Ingrese su apellido:</label>
        <input class="input1" type="text" name="aLastName" placeholder="Ingrese su apellido..." value="<?php echo $actualUser->lastName ?>">

        <br><label>Ingrese su nivel de permiso:</label>
        <input class="input1" type="number" name="aPermissionLevel" placeholder="Ingrese su nivel de permiso..." value="<?php echo $actualUser->permissionLevel ?>">

        <br> <input class="login-button" type="submit" value="<?php if ($id !== null) echo "Editar usuario";
                                                                else echo "Crear usuario"; ?>" name="submit">

    </form>

    <form method="post" action="usersList.php">
        <input class="volver" type="submit" name="volver" class="button" value="Volver" />
    </form>

    <?php

    require_once "callAPI.php";

    $email = $password = $firstName = $lastName = $permissionLevel =  "";

    if (isset($_POST['submit'])) {
        $email = $_POST['aEmail'];
        $firstName = $_POST['aFirstName'];
        $lastName = $_POST['aLastName'];
        $permissionLevel = $_POST['aPermissionLevel'];

        if (!empty($actualUser->password)) {
            if (!empty($_POST['aNewClave'])) {
                $password = $_POST['aNewClave'];
            }
            $password = $actualUser->password;
        } else {
            $password = $_POST['aClave'];
        }

        if (empty($email) || empty($password)) {
            echo "Completar el email y password";
        } else {
            echo "Cargando";

            if ($id) { //Editar usuario (PUT / PATCH)

            } else { //Crear usuario (POST)

            }
        }
    }

    ?>

</body>

</html>