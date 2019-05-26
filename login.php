<?php

    if (!empty($_SESSION['user'])) {
        echo $_SESSION['user'];
        ?>
        <a href="logout.php">Logout</a>
    <?php
} else { ?>
        <form action="" method="POST">
            <input type="email" name="email" placeholder="email">
            <br>
            <input type="password" name="password" placeholder="password">
            <br>
            <input type="submit" value="Register" name="register">
        </form>

        <br>

        <form action="" method="POST">
            <input type="email" name="email" placeholder="email">
            <br>
            <input type="password" name="password" placeholder="password">
            <br>
            <input type="submit" value="Login" name="login">
        </form>

    <?php } ?>
    <?php

    if (isset($_POST['register'])) {

        $fields = [
            ':email' => filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING),
            ':password' => filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING),
        ];
        $user->checkUserExists($fields);
    }

    if (isset($_POST['login'])) {
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
        $user->getAllUsers($email, $password);
    }
    ?>
