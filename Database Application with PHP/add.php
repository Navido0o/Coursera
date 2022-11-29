<?php

// Demand a GET parameter

session_start();
if ( ! isset($_SESSION['name']) ) {
    die("ACCESS DENIED");
}

require_once "pdo.php";



if ( isset($_REQUEST['Add']) ) {
    if (strlen($_POST['make']) < 1 || strlen($_POST['model']) < 1 || strlen($_POST['year']) < 1 || strlen($_POST['mileage']) < 1 ) {
        $_SESSION['failure'] = 'All fields are required' ;
        header("Location: add.php");
        return;

    } elseif ( !is_numeric($_POST['year']) ) {
        $_SESSION ['failure'] = 'Year must be numeric' ;
        header("Location: add.php");
        return;
    } elseif ( !is_numeric($_POST['mileage'])) {
        $_SESSION ['failure'] = 'Mileage must be numeric' ;
        header("Location: add.php");
        return;
    } else{
        $sql = "INSERT INTO autos (make, model, year, mileage) 
        VALUES (:make, :model, :year, :mileage)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':make' => $_POST['make'],
            ':model' => $_POST['model'],
            ':year' => $_POST['year'],
            ':mileage' => $_POST['mileage']));
        $_SESSION['msg'] = 'Record added'; 
        header("Location: index.php");
        return;       
    }

} else if ( isset($_REQUEST['cancle']) ) {
    header("Location: index.php");
    return;  

} 
?>

<!DOCTYPE html>
<html>

<head>
<title>Navid Ghaffari's Automobils Tracker</title>
<?php require_once "bootstrap.php"; ?>
</head>

<body>

<div class="container">
<h1>Tracking Autos for 
<?php
if ( isset($_SESSION['name']) ) {
    echo htmlentities($_SESSION['name']);
}
?></h1>
<?php
if ( isset( $_SESSION ['failure'])) {
    echo('<p style="color: red;">'.$_SESSION ['failure']."</p>");
    unset($_SESSION ['failure']) ;
} 
?>
<br> 
<form method="post">

<p>Make:
<input type="text" size="60" name="make"></p>
<p>Model:
<input type="text" size="60" name="model">    
</p>
<p>Year:
<input type="text" size="20" name="year"></p>
<p>Mileage:
<input type="text" size="20" name="mileage"></p>

<input type="submit" name= "Add" value="Add">
<input type="submit" name="cancle" value="Cancle">
</form>

</div>
</body>
</html>