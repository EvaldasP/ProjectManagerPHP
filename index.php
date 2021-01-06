<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro&display=swap" rel="stylesheet">
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


    <table class="table table-hover table-dark">
        <thead>
            <tr>
                <th scope="col">ID</th>

                <?php
                if ($_GET['path'] == "employee") {
                    echo "<th scope=col>Vardas</th>";
                    echo "<th scope=col> Projektai</th>";
                } else if ($_GET['path'] == "projects") {
                    echo "<th scope=col>Projektas</th>";
                    echo "<th scope=col> Darbuotojai</th>";
                } else {
                    echo "<th scope=col>Vardas</th>";
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
            $db = "projectmanager";

            //Creating connection

            $conn = mysqli_connect($servername, $username, $password, $db);
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            //logika kuri pasikeitus path'ui keicia lentele kuri spausdinama

            if ($_GET['path'] == "employee" || $_GET['path'] == "") {
                $sql = "SELECT employee.id as nr, employee.name as vardas, projects.name as projektas 
                FROM employee
                LEFT JOIN projects ON employee.project_id = projects.id 
                ORDER BY nr;";

                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                        <td> $row[nr]</td>
                        <td> $row[vardas]</td>
                        <td> $row[projektas]</td>
                        </tr>";
                    }
                }
            } else if ($_GET['path'] == "projects") {
                $sql =  "SELECT projects.id as numeris, projects.name as projektas , GROUP_CONCAT(employee.name SEPARATOR', ') as vardas FROM projects
                        LEFT JOIN employee ON employee.project_id = projects.id 
                        GROUP BY projektas
                        ORDER BY numeris;  
                        ";

                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                        <td> $row[numeris]</td>
                        <td> $row[projektas]</td>
                        <td> $row[vardas] </td>
                        </tr>";
                    }
                }
            }
            mysqli_close($conn);








            ?>
        </tbody>
    </table>














</body>

</html>