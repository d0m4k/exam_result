<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Student Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 5px;
        }

        h2 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background: #007bff;
            color: white;
        }

        .crud-btn {
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 3px;
            margin: 2px;
            display: inline-block;
        }

        .add-btn {
            background: green;
            color: white;
        }

        .edit-btn {
            background: orange;
            color: white;
        }

        .delete-btn {
            background: red;
            color: white;
        }

        .search-box {
            margin-bottom: 10px;
        }

        input[type="text"] {
            padding: 5px;
            width: 200px;
        }

        button {
            padding: 6px 10px;
            background: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }

        .pass {
            background-color: green;
            color: white;
            padding: 10px;
            border-radius: 10px;
            box-shadow: 0 0 20px;
            font-weight: bold;
        }

        .fail {
            background-color: red;
            color: white;
            padding: 10px;
            border-radius: 10px;
            box-shadow: 0 0 20px;
            font-weight: bold;
        }

        .not-found {
            text-align: center;
            color: red;
            font-weight: bold;
            margin-top: 20px;
        }

        .delete-msg{
            background-color: rgb(212, 128, 128);
            width: fit-content;
            margin: auto;
            color: white;
            padding: 20px;
        }
    </style>
</head>

<body>
    <?php
    if(!isset($_COOKIE["admin"])){
        header("Location: /admin/login.php");
        exit;
    }
    $deleted_message = null;
    $connection = mysqli_connect("localhost", "domak", "domak", "examResult");
    if (!$connection) {
        die("" . mysqli_connect_error());
    }
    if(isset($_GET["delete-id"])){
        $query = "DELETE FROM student WHERE id = ". $_GET["delete-id"];
        $result = mysqli_query($connection, $query);
        if($result){
            $deleted_message = "SUCCEFULLY DELETED STUDENT</br>NAME: ".$_GET['name']. "</br>ROLL: " .$_GET["roll"];
        }
    }
    $query_string = "";
    if (isset($_GET["search"])) {
        $search_term = mysqli_real_escape_string($connection, $_GET["search"]);
        $query_string = "SELECT * FROM student WHERE CONCAT(name, email, roll, fatherName, nrc) LIKE '%$search_term%'";
    } else {
        $query_string = "SELECT * FROM student ORDER BY id DESC";
    }

    $query = mysqli_query($connection, $query_string);
    ?>
    <a href="/logout.php?user=admin">LOGOUT</a>
    <div class="container">
        <?php 
            if($deleted_message){
                echo "<div class='delete-msg'>".$deleted_message."</div>";
            }
        ?>
        <h2>Student Management</h2>
        <form class="search-box" action="">
            <input type="text" placeholder="Search by name or roll..." value="<?= isset($_GET["search"]) ? $_GET["search"] : "" ?>" name="search">
            <button type="submit">Search</button>
        </form>
        <a href="admin/addStudent.php" class="crud-btn add-btn">Add Student</a>

        <?php if (mysqli_num_rows($query) == 0) : ?>
            <div class="not-found">No students found matching your search.</div>
        <?php else : ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Roll</th>
                        <th>Email</th>
                        <th>Score</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($student = mysqli_fetch_assoc($query)) { ?>
                        <tr>
                            <td><?= $student["id"] ?></td>
                            <td><?= $student["name"] ?></td>
                            <td><?= $student["roll"] ?></td>
                            <td><?= $student["email"] ?></td>
                            <td><?= $student["score"] ?></td>
                            <td><?= $student["pass"] ? "<span class='pass'>Pass</span>" : "<span class='fail'>Fail</span>" ?></td>
                            <td>
                                <a href="/admin/editStudent.php?id=<?= $student["id"]?>" class="crud-btn edit-btn">Edit</a>
                                <a href="?delete-id=<?= $student["id"]?>&name=<?= $student["name"]?>&roll=<?= $student["roll"]?>" class="crud-btn delete-btn">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

</body>

</html>
