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

?>

<?php

// darbuotoju trynimas

if (isset($_GET['action']) and $_GET['action'] == 'deleteEmp') {
    $sql = 'DELETE FROM employee WHERE id = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $_GET['id']);
    $res = $stmt->execute();

    $stmt->close();
    mysqli_close($conn);

    header("Location: " . strtok("?path=employee", ''));
    die();
}

// projektu trynimas.

if (isset($_GET['action']) and $_GET['action'] == 'deletePr') {
    $sql = 'DELETE FROM projects WHERE id = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $_GET['id']);
    $res = $stmt->execute();

    $stmt->close();
    mysqli_close($conn);

    header("Location: " . strtok("?path=projects", ''));
    die();
}

// Darbuotoju updatinimas. Galima keisti varda/Priskirti projekta

if (isset($_GET['updateEmp'])) {

    $oldName = $_GET['updateEmp'];
    $id = $_GET['id'];
    $pr = $_GET['pr'];

    $projektaiSql = "SELECT DISTINCT projects.id as prId, projects.name as prPav, employee.project_id as empPrId
    FROM projects 
    LEFT JOIN  employee ON employee.project_id = projects.id ";
    $projektaiResults = mysqli_query($conn, $projektaiSql);

    echo
        "<form  id=updateForm method='POST'> 
    <label>Vardas</label>
    <input type='text' name='newName' value='$oldName' >
    <label>Projektas</label>
    <Select class=form-control id=exampleFormControlSelect1 name='prId'>";

    //Spaudinami visi projektai kaip option. kartu "nesasi" savo id  kaip value

    while ($row = mysqli_fetch_assoc($projektaiResults)) {
        if ($pr == $row['empPrId']) {
            echo "<option selected=selected value=$row[prId] >$row[prPav]</option>";
            if ($pr == "") {
                echo "<option id=selectOption selected=selected hidden >Pasirinkite Projektą:</option>";
            }
        } else {
            echo "<option  value=$row[prId] >$row[prPav]</option>";
        }
    }
    if ($pr !== "") {
        echo "<option id=outOption  value=0 >Išeiti iš Projekto</option>";
    }

    echo "</Select>
         <input type='submit' name='updateEmp' value='Update'>
         </form>";

    if (isset($_POST['updateEmp'])) {

        $sql;

        if ($_POST['prId'] == 0) {
            $sql = "UPDATE employee 
            SET employee.name ='$_POST[newName]', employee.project_id =NULL
            WHERE employee.id= '$id'";
        } else {
            $sql = "UPDATE employee 
            SET employee.name ='$_POST[newName]', employee.project_id ='$_POST[prId]'
            WHERE employee.id= '$id'";
        }

        mysqli_query($conn, $sql);
        mysqli_close($conn);
        header("Location: " . strtok("?path=employee", ''));
        die();
    }
}


// Projekto pavadinimo updatinimas

if (isset($_GET['updatePr'])) {
    $oldPrName = ($_GET['updatePr']);
    $id =  $_GET['id'];
    echo
        "
        <form  id=updateForm method=post>
        <label>Projekto pavadinimas</label>
        <input type=text name='newPrName' value='$oldPrName' > 
        <input type=submit name=updatePr value=Update>
        </form>
        ";
    if (isset($_POST['updatePr'])) {
        $sql = "UPDATE projects 
        SET projects.name ='$_POST[newPrName]' 
        WHERE projects.id= '$id'";
        mysqli_query($conn, $sql);
        mysqli_close($conn);
        header("Location: " . strtok("?path=projects", ''));
        die();
    }
}


// darbuotojo pridejimas

if (isset($_POST['addNew'])) {

    if ($_GET['path'] == "employee" || $_GET['path'] == "") {

        $naujas  = $_POST['newEmp'];
        $sql = "INSERT INTO employee (employee.name)
        VALUES ('$naujas'); ";
        mysqli_query($conn, $sql);
        mysqli_close($conn);
        header("Location: " . strtok("?path=employee", ''));
        die();


        // Projekto pridejimas

    } else if ($_GET['path'] == "projects") {
        $naujas  = $_POST['newPr'];
        $sql = "INSERT INTO projects (projects.name)
        VALUES ('$naujas'); ";
        mysqli_query($conn, $sql);
        mysqli_close($conn);
        header("Location: " . strtok("?path=projects", ''));
        die();
    }
}
?>


