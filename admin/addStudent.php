<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student - Admin</title>
    <style>
        
        body {

            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            margin: 0;
        }

        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
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

        input,
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            color: #333;
        }

        input:focus,
        select:focus {
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

        .notic{
            font-weight: lighter;
        }
    </style>
</head>

<body>
    <?php
    if(!isset($_COOKIE["username"]) && !isset($_COOKIE["password"])){
        header("Location: /admin/login.php");
        exit;
    }
    $connection = mysqli_connect("localhost", "domak", "domak", "examResult");
    if (!$connection) {
        die("" . mysqli_connect_error());
    }
    $is_added = false;
    if (isset($_POST["add-student"])) {
        $name = $_POST["name"];
        $email = $_POST["email"];
        $roll = $_POST["roll"];
        $nrc = $_POST["nrc"];
        $fatherName = $_POST["father_name"];
        $score = $_POST["score"];
        $pass = $_POST["passorfail"];

        $roll_p = "/^\d[a-zA-Z]{2,3}\d+$/";
        if(!preg_match($roll_p,$roll)){
            die("roll number must be format that 3CS12 or 4CST123");
        }
        $nrc_p = "/^\d{1,2}\/[A-Z]{3,6}\(N\)\d{6}$/";
        if(!preg_match($nrc_p, $nrc)){
            die("Nrc format wrong example: 12/TAMANA(N)123456");
        }
        if(explode("@",$email)[1] != "ucsh.edu.mm"){
            die("Email must be ucsh.edu.mm mail");
        }
        $query_string = "INSERT INTO student(name, email, roll, nrc, fatherName, score, pass) VALUES('$name', '$email', '$roll', '$nrc', '$father_name', '$score', '$pass')";
        $result = mysqli_query($connection, $query_string);
        if (!$result) {
            die("" . mysqli_error($connection));
        }
        $is_added = true;
    }
    if($is_added){
        header("Location: /admin");
        exit;
    }
    ?>
    <div class="form-container">
        <a href="/admin">BACK</a>
        <h1>Add Student</h1>
        <form name="studentForm" method="POST">
            <div class="form-group">
                <label for="name">Student Name</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="roll">Roll Number <span class="notic">* ALL IN CAPITAL LETTER EXAMPLE: 2CS10 or 5CST80</span></label>
                <input type="text" id="roll" name="roll" required>
            </div>

            <div class="form-group">
                <label for="nrc">NRC <span class="notic">* ALL IN CAPITAL LETTER EXAMPLE: 12/TAMANA(N)123456</span></label>
                <input type="text" id="nrc" name="nrc" required>
            </div>

            <div class="form-group">
                <label for="email">Email <span class="notic">* EMAIL MUST BE ucsh mail</span></label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="father_name">Father's Name</label>
                <input type="text" id="father_name" name="father_name" required>
            </div>

            <div class="form-group">
                <label for="score">Score</label>
                <input type="number" id="score" name="score" min="0" required>
            </div>

            <div class="form-group">
                <label for="pass">Pass</label>
                <select id="pass" name="passorfail" required>
                    <option value="null">Select Pass or Fail</option>
                    <option value="1">Pass</option>
                    <option value="0">Fail</option>
                </select>
            </div>

            <button type="submit" class="submit-btn" name="add-student">Add Student</button>
        </form>
    </div>
</body>

</html>
