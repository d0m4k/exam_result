<?php
foreach ($_COOKIE as $key => $value) {
    $user = $_GET["user"];
    if ($user == "admin") {
        setcookie("admin", "", time() - 3600, "/");

        header("Location: /admin/login.php");
        exit;
    }

    if ($user == "user") {
        setcookie("user", "", time() - 3600, "/");

        header("Location: login.php");
        exit;
    }
}
