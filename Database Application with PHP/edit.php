<?php
require_once "pdo.php";
session_start();

if ( ! isset($_SESSION['name']) ) {
    die("ACCESS DENIED");
}

if ( isset($_REQUEST['Save']) ) {
    if (strlen($_POST['make']) < 1 || strlen($_POST['model']) < 1 || strlen($_POST['year']) < 1 || strlen($_POST['mileage']) < 1 ) {
        $_SESSION['failure'] = 'All fields are required' ;
        header("Location: edit.php?autos_id=".$_POST['autos_id']);
        return;

    } elseif ( !is_numeric($_POST['year']) ) {
        $_SESSION ['failure'] = 'Year must be numeric' ;
        header("Location: edit.php?autos_id=".$_POST['autos_id']);
        return;
    } elseif ( !is_numeric($_POST['mileage'])) {
        $_SESSION ['failure'] = 'Mileage must be numeric' ;
        header("Location: edit.php?autos_id=".$_POST['autos_id']);
        return;
    } else{
        $sql = "UPDATE autos SET make = :make,
                model = :model, 
                year = :year, mileage = :mileage 
                WHERE autos_id = :autos_id" ;
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
        ':make' => $_POST['make'],
        ':model' => $_POST['model'],
        ':year' => $_POST['year'],
        ':mileage' => $_POST['mileage'],
        ':autos_id' => $_POST['autos_id']));
        $_SESSION['msg'] = 'Record updated'; 
        header("Location: index.php");
        return;       
    }

}

    

// Guardian: Make sure that user_id is present
if ( ! isset($_GET['autos_id']) ) {
  $_SESSION['error'] = "Missing autos_id";
  header('Location: index.php');
  return;
}

$stmt = $pdo->prepare("SELECT * FROM autos where autos_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['autos_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['failure'] = 'Bad value for autos_id';
    header( 'Location: index.php' ) ;
    return;
}


$make = htmlentities($row['make']);
$model = htmlentities($row['model']);
$year = htmlentities($row['year']);
$mileage = htmlentities($row['mileage']);
$autos_id = $row['autos_id'];
?>

<!DOCTYPE html>
<html>

<head>
<title>Navid Ghaffari's Automobils Tracker</title>
<?php require_once "bootstrap.php"; ?>
</head>

<body>
<div class="container">
<p>Edit Automobile</p>

<?php
if ( isset($_SESSION['failure']) ) {
    echo '<p style="color:red">'.$_SESSION['failure']."</p>\n";
    unset($_SESSION['failure']);
}
?>
<form method="post">

<p>Make:
<input type="text" size="60" name="make" value="<?= $make ?>"></p>
<p>Model:
<input type="text" size="60" name="model" value="<?= $model ?>" >    
</p>
<p>Year:
<input type="text" size="20" name="year" value="<?= $year ?>"></p>
<p>Mileage:
<input type="text" size="20" name="mileage" value="<?= $mileage ?>"></p>

<input type="hidden" name="autos_id" value="<?= $autos_id ?>">

<p><input type="submit" name= "Save" value="Save">
<a href="index.php">Cancel</a></p>
</form>

</div>
</body>
</html>




