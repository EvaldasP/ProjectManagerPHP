<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="styles.css">
    <title>ProjectManagerPHP</title>
</head>

<body>
    <header>
        <div class="linkai">
            <a href="?path=employee">Darbuotojai</a>
            <a href="?path=projects">Projektai</a>
        </div>
        <div class="logo">
            <img src="./logo/project-management.svg" alt="">
            <h2>Projekto Valdymas</h2>
        </div>
    </header>


    <table class="table table-striped table-dark">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <?php
                if ($_GET['path'] == "employee") {
                    echo "<th scope=col> Projektai</th>";
                } else if ($_GET['path'] == "projects") {
                    echo "<th scope=col> Darbuotojai</th>";
                } else {
                    echo "<th scope=col> Projektai</th>";
                }
                ?>
            </tr>
        </thead>
        <tbody>

            <?php

            $servername = "localhost";
            $username = "root";
            $password = "mysql";

            //Creating connection

            $conn = mysqli_connect($servername, $username, $password);
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            // Logika kuri pasikeitus path'ui pakecia spausdinama lentele

            $table = "employee";

            if ($_GET['path'] == "employee") {
                $table = "employee";
            } else if ($_GET['path'] == "projects") {
                $table = "projects";
            }



            $sql = "SELECT id, name FROM projectmanager . $table";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                    <td> $row[id] </td>
                    <td> $row[name]</td>
                    </tr>";
                }
            }


            mysqli_close($conn);

            ?>
        </tbody>
    </table>














</body>

</html>