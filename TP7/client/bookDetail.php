<html>

<head>
    <link rel="stylesheet" href="styles.css">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
</head>

<?php
require_once "callAPI.php";

$userId = getParam("userId");
$bookId = getParam("id");

$get_user_data = callAPI('GET',  $apiURL . "users/" . $userId, false);
$userResponse = json_decode($get_user_data, true);
$actualUser = new User();
$actualUser->id = $userResponse["id"];
$actualUser->email = $userResponse["email"];
$actualUser->password = $userResponse["password"];
$actualUser->firstName = $userResponse["firstName"];
$actualUser->lastName = $userResponse["lastName"];
$actualUser->permissionLevel = $userResponse["permissionLevel"];

$get_book_data = callAPI('GET',  $apiURL . "users/" . $userId . "/books" . "/" . $bookId, false);
$bookResponse = json_decode($get_book_data, true);
$actualBook = new Book();
$actualBook->id = $bookResponse["id"];
$actualBook->userId = $bookResponse["userId"];
$actualBook->title = $bookResponse["title"];
$actualBook->autor = $bookResponse["autor"];

// echo nl2br("====================== \n");
// var_dump($actualUser);
// echo nl2br("\n");
// echo nl2br("====================== \n");

// echo nl2br("====================== \n");
// var_dump($actualBook);
// echo nl2br("\n");
// echo nl2br("====================== \n");


?>

<body>

    <h2><?php echo ($bookId !== null) ? 'Editando: ' . $actualBook->title  : 'Nuevo libro'; ?></h2>

    <form method="POST">

        <input class="input1" type="text" name="aId" hidden=true value="<?php echo $actualBook->id ?>">

        <input class="input1" type="text" name="aUserId" hidden=true value="<?php echo $actualUser->id ?>">

        <br><label>Ingrese el titulo:</label>
        <input style="margin-left: 74px" class="input1" type="text" name="aTitle" placeholder="Ingrese su title..." value="<?php echo $actualBook->title ?>" required>

        <br><label>Ingrese el autor:</label>
        <input style="margin-left: 75px" class="input1" type="text" name="aAutor" placeholder="Ingrese autor..." value="<?php echo $actualBook->autor ?>" required>


        <br> <input style="margin-left: 30px" class="login-button" name="submit" type="submit" value="<?php echo ($id !== null) ? 'Editar libro' : 'Crear libro'; ?>">

        <?php

        if (isset($_POST['submit'])) {

            $theId = $_POST['aId'];
            $theUserId = $_POST['aUserId'];

            $title = $_POST['aTitle'];
            $autor = $_POST['aAutor'];

            if (empty($autor) || empty($title)) {
                echo "Title: " . $title . "\n";
                echo "Autor: " . $autor . "\n";
                echo "Completar el titulo y autor";
            } else {
                $newBook = new Book();
                $newBook->title = $title;
                $newBook->autor = $autor;
                $newBook->userId = $theUserId;

                if ($theId !== "") { //Editar libro (PUT / PATCH)
                    echo "Actualizando Libro";
                    $put_data = callAPI('PUT', $apiURL . "users/" . $theUserId . "/books" . "/" . $theId, json_encode($newBook));
                } else { //Crear libro (POST)
                    echo "Creando Libro";
                    $post_data = callAPI('POST', $apiURL . "users/" . $theUserId . "/books", json_encode($newBook));
                }
                header("Location: booksList.php?id=" . $actualUser->id);
            }
        }

        ?>

    </form>

    <form method="post" action=<?php echo "booksList.php?id=" . $actualUser->id; ?>>
        <input style="margin-left: 30px" class="volver" type="submit" name="volver" class="button" value="Volver" />
    </form>

</body>

</html>