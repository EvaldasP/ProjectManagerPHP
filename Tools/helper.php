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

// darbuotoju trinimas

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

// projektu trinimas. Istrinus projekta darbuotuojai unsigned

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






// Darbuotoju updatinimas. Galima keisti varda

if (isset($_GET['updateEmp'])) {
    $oldName = $_GET['updateEmp'];
    $id =  $_GET['id'];

    $projektaiSql = "SELECT employee.project_id FROM employess ";
    $projektaiResults = mysqli_query($conn, $projektaiSql);


    echo
        "<form  id=updateForm method='POST'> 
    <label>Vardas</label>
    <input type='text' name='newName' value='$oldName' >
    <input type='submit' name='updateEmp' value='Update'>
    </form>";

    if (isset($_POST['updateEmp'])) {

        $sql = "UPDATE employee 
        SET employee.name ='$_POST[newName]' 
        WHERE employee.id= '$id'";

        mysqli_query($conn, $sql);

        header("Location: " . strtok("?path=employee", ''));
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


        // Projekto pridejimas

    } else if ($_GET['path'] == "projects") {
        $naujas  = $_POST['newPr'];
        $sql = "INSERT INTO projects (projects.name)
        VALUES ('$naujas'); ";
        mysqli_query($conn, $sql);
        mysqli_close($conn);
        header("Location: " . strtok("?path=projects", ''));
    }
}












?>


