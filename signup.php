<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Here</title>
    <style>
        *{
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            font-size: 14px;
            font-weight: bold;
            color: #555;
            display: block;
            margin-bottom: 5px;
        }

        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            color: #333;
        }

        input:focus {
            outline: none;
            border-color: #007bff;
        }

        .submit-btn {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            width: 100%;
            font-size: 16px;
            cursor: pointer;
        }

        .submit-btn:hover {
            background-color: #0056b3;
        }

        .err-msg{
            color: red;
            font-family: monospace;
            font-weight: lighter;
        }

        form a{
            display: block;
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>

<body>
    <?php
    $error = null;
    $username = null;
    $email = null;
    $password = null;
    $connection = mysqli_connect(hostname: "localhost", username: "domak", password: "domak", database: "examResult");
    if (mysqli_connect_errno()) {
        die("" . mysqli_connect_error());
    }

    if (isset($_POST["signup"])) {
        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        if(explode("@",$email)[1] != "ucsh.edu.mm"){
            die("Email must be @ucsh.edu.mm mail");
        }
        if(strlen($password) < 5){
            echo "Your password is too short";
            exit;
        }
        $search_email = "SELECT * FROM student WHERE email='" . $email."'";
        $search = mysqli_query($connection, $search_email);
        if (mysqli_num_rows($search) > 0) {
            $student = mysqli_fetch_array($search);
            $query_string = "INSERT INTO user(username, email, password, student_id) VALUES('$username', '$email', '$password', ".$student["id"]. ")";
            $result = mysqli_query($connection, $query_string);
            if ($result) {
                $user = [
                    "username"=> $username,
                    "email"=> $email,
                    "password" => $password,
                ];
                setcookie("username", json_encode($username), time() + 3600,"/");
                header("Location: /?msg=welcome");
                exit;
            }
        }else{
            $error .= "Look like you don't have access to the organization, please use your real edu mail";
        }
    }
    ?>
    <div class="form-container">
        <h1>Register Here</h1>
        <form method="post" action="">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="<?= isset($username) ? $username : "" ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email <?php if($error){
                    echo "<span class='err-msg'>*".$error."</span>";   
                }?></label>
                <input type="email" id="email" value="<?= isset($email) ? $email : "" ?>" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" value="<?= isset($password) ? $password : ""?>" required>
            </div>
            <button type="submit" name="signup" class="submit-btn">Sign Up</button>
            <div><a href="/login.php">Already have account? Login here!</a></div>
        </form>
    </div>
</body>

</html>