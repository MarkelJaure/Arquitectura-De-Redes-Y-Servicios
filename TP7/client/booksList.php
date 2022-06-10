<html>

<head>
    <link rel="stylesheet" href="styles.css?1.0">


    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
</head>

<?php
require_once "callAPI.php";

$user = getLogguedUser();
if (empty($user)) {
    echo "No se encuentra logueado";
} else {
    echo "Logueado como: " . $user["email"];

?>



    <body>

        <?php
        require_once "callAPI.php";

        $userId = getParam("id");

        $get_user_data = callAPI('GET',  $apiURL . "users/" . $userId, false);
        $userResponse = json_decode($get_user_data, true);
        $actualUser = new User();
        $actualUser->id = $userResponse["id"];
        $actualUser->email = $userResponse["email"];
        $actualUser->password = $userResponse["password"];
        $actualUser->firstName = $userResponse["firstName"];
        $actualUser->lastName = $userResponse["lastName"];
        $actualUser->permissionLevel = $userResponse["permissionLevel"];
        ?>
        <h2>Libros del usuario: <?php echo $actualUser->email ?> </h2>

        <table style="border: 1px solid black;">
            <tr>
                <th> N° </th>
                <th> Id </th>
                <th> Titulo </th>
                <th> Autor </th>
                <th> Editar </th>
                <th> Borrar </th>
            </tr>
            </thead>
            <tbody>
                <?php

                $get_books_data = callAPI('GET', $apiURL . "users/" . $userId . "/books", false);
                $booksResponse = json_decode($get_books_data, true);



                $books = array();
                foreach ($booksResponse as $aBook) {
                    $newBook = new Book();
                    $newBook->id = $aBook["id"];
                    $newBook->userId = $aBook["userId"];
                    $newBook->title = $aBook["title"];
                    $newBook->autor = $aBook["autor"];
                    array_push($books, $newBook);
                }
                $total = 0;



                foreach ($books as $book) : ?>
                    <tr class="item_row">
                        <td> <?php echo ++$total; ?></td>
                        <td> <?php echo $book->id; ?></td>
                        <td> <?php echo $book->title; ?></td>
                        <td> <?php echo $book->autor; ?></td>
                        <td>
                            <form method="POST" action=<?php echo "bookDetail.php?userId=" . $actualUser->id . "&id=" . $book->id; ?> style="display: inline;">
                                <button type="edit" class="edit-button"><i class="fa fa-edit"></i></button>
                            </form>
                        </td>
                        <td>
                            <form method="POST" style="display: inline;">
                                <button type="delete" class="remove-button" name=<?php echo "delete" . $book->id; ?>><i class="fa fa-trash"></i></button>
                            </form>

                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <form method="POST" action=<?php echo "bookDetail.php?userId=" . $actualUser->id; ?>>
            <button class="add-button">Agregar libro <i class="fa fa-plus"></i></button>
        </form>

        <form method="POST" action=<?php echo "userDetail.php?id=" . $actualUser->id; ?>>
            <button class="volver">Volver </button>
        </form>

        <?php
        if (isset($_POST['delete' . $book->id])) {
            $delete_data = callAPI("DELETE", $apiURL . "users/" . $userId . "/books" . "/" . $book->id, false);
            header("Location: booksList.php?id=" . $actualUser->id);
        }
        ?>



    </body>
<?php
}
?>

</html>