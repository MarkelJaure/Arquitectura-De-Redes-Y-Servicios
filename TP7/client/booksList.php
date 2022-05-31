<html>

<head>
    <link rel="stylesheet" href="styles.css?1.0">


    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
</head>

<body>
    <h2>Libros del usuario: </h2>

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
            require_once "callAPI.php";

            $apiURL = 'http://localhost:3000/users/';

            $get_data = callAPI('GET', $apiURL, false);
            $response = json_decode($get_data, true);



            $books = array();
            foreach ($response as $aBook) {
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
                        <form method="POST" action=<?php echo "userDetail.php?id=" . $book->id; ?> style="display: inline;">
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

    <form method="POST" action="userDetail.php">
        <button class="add-button">Agregar libro <i class="fa fa-plus"></i></button>
    </form>


    <?php
    if (isset($_POST['delete' . $book->id])) {
        //TODO: eliminado del libro
        // $delete_data = callAPI("DELETE", $apiURL . $book->id, false);
        // header("Location: usersList.php");
    }
    ?>


</body>

</html>