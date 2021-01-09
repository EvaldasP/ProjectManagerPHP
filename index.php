<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="Tools/styles.css">
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
            <div class="textLogo">
                <h2>Project Manager</h2>
                <h2>PHP</h2>
            </div>
        </div>
    </header>




    <div id=update_add_forms>
        <?php
        include "./Tools/helper.php";




        // Formos nauju darbuotoju/project pridejimui

        if ($_GET['path'] == "employee" || $_GET['path'] == "") {
            echo "
            <form  id=addForm method=post>
            <label>Naujas Darbuotojas:</label>
            <input type=text name='newEmp' > 
            <input type=submit name='addNew' value=Add>
            </form>
        ";
        } else if ($_GET['path'] == "projects") {
            echo "
        <form  id=addForm method=post>
        <label>Naujas Projektas:</label>
        <input type=text name='newPr' > 
        <input type=submit name='addNew' value=Add>
        </form>
    ";
        }



        ?>
    </div>


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
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>



            <?php


            //logika kuri pasikeitus path'ui keicia lentele kuri spausdinama


            // Darbuotoju Lentele

            if ($_GET['path'] == "employee" || $_GET['path'] == "") {
                $sql = "SELECT employee.id as nr, employee.name as vardas, employee.project_id as prId, projects.name as projektas 
                FROM employee
                LEFT JOIN projects ON employee.project_id = projects.id 
                ORDER BY nr;";

                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {

                        $index++;

                        print('<tr>'
                            . '<td>' . $index . '</td>'
                            . '<td>' . $row['vardas'] . '</td>'
                            . '<td>' . $row['projektas'] . '</td>'
                            . '<td>' . '<a href="?action=deleteEmp&id='  . $row['nr'] . '"><button id=deleteBtn >DELETE</button></a>' .
                            '<a href="?path=employee&updateEmp='  . rawurlencode($row['vardas']) . '&id=' . $row['nr'] .   '&pr=' . $row['prId'] .  '"  ><button id=updateBtn >UPDATE</button></a>'
                            .  '</td>'
                            . '</tr>');
                    }
                }


                // Project Lentele

            } else if ($_GET['path'] == "projects") {
                $sql =  "SELECT ANY_VALUE(projects.id) as numeris, projects.name as projektas , GROUP_CONCAT(employee.name SEPARATOR', ') as vardas 
                        FROM projects
                        LEFT JOIN employee ON employee.project_id = projects.id 
                        GROUP BY projektas
                        ORDER BY numeris;  
                        ";

                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {

                        $index++;

                        print('<tr>'
                            . '<td>' . $index . '</td>'
                            . '<td>' . $row['projektas'] . '</td>'
                            . '<td>' . $row['vardas'] . '</td>'
                            . '<td>' . '<a href="?action=deletePr&id='  . $row['numeris'] . '"><button id=deleteBtn>DELETE</button></a>' .
                            '<a href="?path=projects&updatePr=' . $row['projektas'] . '&id=' . $row['numeris'] . '"><button id=updateBtn>UPDATE</button></a>'
                            . '</td>'
                            . '</tr>');
                    }
                }
            }
            mysqli_close($conn);
            ?>
        </tbody>
    </table>

</body>

</html>