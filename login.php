<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php
    $error = null;
    $email = null;
    $password = null;
    $connection = mysqli_connect(hostname: "localhost", username: "domak", password: "domak", database: "examResult");
    if (mysqli_connect_errno()) {
        die("" . mysqli_connect_error());
    }

    if (isset($_POST["login"])) {
        $email = $_POST["email"];
        $password = $_POST["password"];
        $query_string = "SELECT * FROM user WHERE email = '$email' AND password = '$password'";
        $result = mysqli_query($connection, $query_string);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);
            $user = [
                "username" => $row["username"],
                "email" => $row["email"],
                "password" => $row["password"],
            ];
            setcookie("user", json_encode($user), time() + 3600, "/");
            header("Location: /?msg=Welcome Back");
            exit;
        }
        $error .= "Incorrect Email or Password!";
    }
    ?>
    <div class="container">
        <h2>Login</h2>
        <?php if (isset($error)) {
            echo "<span class='error'>$error</span>";
        } ?>
        <form method="post">
            <input type="email" name="email" id="loginEmail" value="<?= isset($email) ? $email : "" ?>" placeholder="Email" required>
            <input type="password" id="loginPassword" name="password" value="<?= isset($password) ? $password : ""?>" placeholder="Password" required>
            <button type="submit" name="login">Login</button>
            <div><a href="/signup.php">Create Account</a></div>
        </form>
    </div>
</body>

</html>