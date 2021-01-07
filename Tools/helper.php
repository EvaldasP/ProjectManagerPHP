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


    echo
        "<form  id=updateForma method='POST'> 
    <label>Vardas</label>
    <input type='text' name='newName' value= $oldName >
    <input type='submit' name='updateEmp' value='Update'>
    </form>";

    if (isset($_POST['updateEmp'])) {

        $sql = "UPDATE employee 
        SET employee.name ='$_POST[newName]' 
        WHERE employee.name= '$oldName'";

        mysqli_query($conn, $sql);

        header("Location: " . strtok("?path=employee", ''));
    }
}







// Projekto pavadinimo updatinimas


if (isset($_GET['updatePr'])) {

    $oldPrName = ($_GET['updatePr']);



    echo
        "<div>
        <form  id=forma a method=post>
        <label>Projecto pavadinimas</label>
        <input type=text name='newPrName' value=$oldPrName> 
        <input type=submit name=updatePr value=Update>
        </form>
        </div>";




    if (isset($_POST['updatePr'])) {
        $sql = "UPDATE projects 
        SET projects.name ='$_POST[newPrName]' 
        WHERE projects.name= '$oldPrName'";


        mysqli_query($conn, $sql);

        header("Location: " . strtok("?path=projects", ''));
    }
}


?>


