<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Exam Results</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php
    if(!isset($_COOKIE["user"])){
        header("Location: /login.php");
        exit;
    }
    $connection = mysqli_connect(hostname: "localhost", username: "domak", password: "domak", database: "examResult");
    if (mysqli_connect_errno()) {
        die("". mysqli_connect_error());
    }

    $roll = $_GET["roll"];
    $student = null;
    if ($roll) {
        $query_string = "SELECT * FROM student WHERE roll='$roll'";
        $query = mysqli_query($connection, $query_string);
        $student = mysqli_fetch_array($query);
    }
    ?>
    <div class="logout"><a href="/logout.php?user=user" class="">LOGOUT</a></div>
    <h1>University Of Computer Studies, Hinthada</h1>
    <h2>Exam Result Looker</h2>
    
    <form class="container" action="">
        <h2>Search Exam Results</h2>
        <input type="text" id="rollNo" name="roll" value="<?= isset($_GET["roll"]) ? $_GET["roll"] : ""?>" placeholder="Enter Roll Number" required>
        <button type="submit">Search</button>
    </form>
    <?php
    if ($student) {

        ?>
        <table class="result">
            <tr>
                <th>Name</th>
                <td class="data"><?= $student["name"] ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td class="data"><?= $student["email"] ?></td>
            </tr>
            <tr>
                <th>Roll No</th>
                <td class="data"><?= $student["roll"] ?></td>
            </tr>
            <tr>
                <th>NRC</th>
                <td class="data"><?= $student["nrc"] ?></td>
            </tr>
            <tr>
                <th>Father's Name</th>
                <td class="data"><?= $student["fatherName"] ?></td>
            </tr>
            <tr>
                <th>Score</th>
                <td class="data"><?= $student["score"] ?></td>
            </tr>
            <tr>
                <th>Pass or Fail</th>
                <td class="data status">
                    <?= $student["pass"] ? "<span class='pass'>Pass</span>" : "<span class='fail'>Fail</span>" ?>
                </td>
            </tr>
        </table>

    <?php } else if(isset($_GET["roll"])){ ?>
        <h3>Student Not found with Roll No. - <?= $roll ?></h3>
    <?php } ?>

    <!-- <footer>
        <h4>Copyright@2024</h4>
    </footer> -->
</body>

</html>