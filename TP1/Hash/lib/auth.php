<?php

require_once "config.php";

function register($username, $password)
{
    global $link;

    $sql = "INSERT INTO users (username, password) VALUES (?, ?)";

    if ($stmt = mysqli_prepare($link, $sql)) {

        mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
        $param_username = $username;
        $param_password = password_hash($password, PASSWORD_DEFAULT); // Hash de la clave


        if (mysqli_stmt_execute($stmt)) { //Ejecuto SQL
            echo $username . " Registrado correctamente";
        } else {
            echo "Error en el registro a la base de datos";
        }

        mysqli_stmt_close($stmt);
    }

    mysqli_close($link);
}


function login($username, $password)
{
    global $link;

    $sql = "SELECT id, username, password FROM users WHERE username = ?";

    if ($stmt = mysqli_prepare($link, $sql)) {

        mysqli_stmt_bind_param($stmt, "s", $param_username);
        $param_username = $username;


        if (mysqli_stmt_execute($stmt)) { //Ejecuto SQL

            mysqli_stmt_store_result($stmt);

            if (mysqli_stmt_num_rows($stmt) == 1) { // Check if username exists, if yes then verify password

                mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                if (mysqli_stmt_fetch($stmt)) {
                    if (password_verify($password, $hashed_password)) {
                        echo "Bienvenido " . $username;
                    } else {
                        echo  "Invalid username or password."; //Pasword invalida
                    }
                }
            } else {
                echo  "Invalid username or password.";  //Pasword invalida
            }
        } else {
            echo "Error en el Login a la base de datos.";
        }

        mysqli_stmt_close($stmt);
    }

    mysqli_close($link);
}
