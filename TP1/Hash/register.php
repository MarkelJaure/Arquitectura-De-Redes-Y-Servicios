<body>
    <h2>Register en PHP</h2>
    <form method="post">
        <!-- <form method="post" action="authApp.php"> -->

        <br><label>Ingrese su usuario</label>
        <input type="text" name="aUser">
        <br><label>Ingrese su clave</label>
        <input type="text" name="aClave">
        <br>
        <input type="submit" value="click" name="submit">

    </form>
</body>

<?php

require_once "config.php";

$username = $password = "";

if (isset($_POST['submit'])) {
    echo "register";
    $username = $_POST['aUser'];
    $password = $_POST['aClave'];

    $sql = "INSERT INTO users (username, password) VALUES (?, ?)";

    if ($stmt = mysqli_prepare($link, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);

        // Set parameters
        $param_username = $username;
        $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            // Redirect to login page
            header("location: login.php");
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    mysqli_close($link);
}

?>