<html>

<head>
    <link rel="stylesheet" href="styles.css">


    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
</head>

<body>
    <h2>Tabla de usuarios</h2>

    <table>
        <tr>
            <th> N° </th>
            <th> Id </th>
            <th> Email </th>
            <th> Nombre </th>
            <th> Apellido </th>
            <th> Nivel de permiso </th>
            <th> Editar </th>
            <th> Borrar </th>
        </tr>
        </thead>
        <tbody>
            <?php
            require_once "callAPI.php";


            $apiURL = 'http://localhost:3000/users/';

            $get_data = callAPI('GET', $apiURL, false);
            $response = json_decode($get_data, true);

            // $strJsonFileContents = file_get_contents("users.json");
            // $array = json_decode($strJsonFileContents, true);

            $users = array();
            foreach ($response as $aUser) {
                $actualUser = new User();
                $actualUser->id = $aUser["id"];
                $actualUser->email = $aUser["email"];
                $actualUser->password = $aUser["password"];
                $actualUser->firstName = $aUser["firstName"];
                $actualUser->lastName = $aUser["lastName"];
                $actualUser->permissionLevel = $aUser["permissionLevel"];
                array_push($users, $actualUser);
            }
            $total = 0;
            // echo $apiURL . $user->id;
            foreach ($users as $user) : ?>
                <tr class="item_row">
                    <td> <?php echo ++$total; ?></td>
                    <td> <?php echo $user->id; ?></td>
                    <td> <?php echo $user->email; ?></td>
                    <td> <?php echo $user->firstName; ?></td>
                    <td> <?php echo $user->lastName; ?></td>
                    <td> <?php echo $user->permissionLevel; ?></td>
                    <td>
                        <form method="POST" action=<?php echo "userDetail.php?id=" . $user->id; ?> style="display: inline;">
                            <button type="edit"><i class="fa fa-edit"></i></button>
                        </form>
                    </td>
                    <td>
                        <form method="post" style="display: inline;">
                            <button type="delete" name=<?php echo "delete" . $user->id; ?>><i class="fa fa-trash"></i></button>
                            <?php
                            if (isset($_POST['delete' . $user->id])) { //TODO: Insertar logica de eliminado
                                echo "Eliminando usuario: " . $user->id;
                            }
                            ?>
                        </form>

                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <form method="POST" action="userDetail.php">
        <button class="add_button">Agregar usuario <i class="fa fa-plus"></i></button>
    </form>





</body>

</html>