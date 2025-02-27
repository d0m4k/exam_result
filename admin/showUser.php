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
            max-width: 90%;
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

        .logout{
            display: block;
            width: fit-content;
            margin-left: 90%;
            margin-bottom: 10px;
            background-color: blue;
            padding: 10px;
            border-radius: 10px;
            color: white;
            text-decoration: none;
            
            
        }
    </style>
</head>

<body>
    <?php
    if(!isset($_COOKIE["admin"])){
        header("Location: /admin/login.php");
        exit;
    }

    $connection = mysqli_connect("localhost", "domak", "domak", "examResult");
    if (!$connection) {
        die("" . mysqli_connect_error());
    }
    $query_string = "";
    if (isset($_GET["search"])) {
        $search_term = mysqli_real_escape_string($connection, $_GET["search"]);
        $query_string = "SELECT * FROM user WHERE CONCAT(username, email, created_at) LIKE '%$search_term%'";
    } else {
        $query_string = "SELECT * FROM user ORDER BY id DESC";
    }
    $query = mysqli_query($connection, $query_string);
    $no = 0;
    ?>
    <div class="container">
        <a href="/admin/index.php" class="home">HOME</a>
         <a href="/logout.php?user=admin" class="logout">LOGOUT</a>
        <h2>Users</h2>
        <form class="search-box" action="">
            <input type="text" placeholder="Search by username, email or Created time" value="<?= isset($_GET["search"]) ? $_GET["search"] : "" ?>" name="search">
            <button type="submit">Search</button>
        </form>

        <?php if (mysqli_num_rows($query) == 0) : ?>
            <div class="not-found">No User found matching your search.</div>
        <?php else : ?>
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Account Created Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($user = mysqli_fetch_assoc($query)) { ?>
                        <tr>
                            <td><?= $no += 1 ?></td>
                            <td><?= $user["username"] ?></td>
                            <td><?= $user["email"] ?></td>
                            <td><?= $user["created_at"] ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

</body>

</html>
