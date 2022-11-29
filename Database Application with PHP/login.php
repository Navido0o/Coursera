<?php // Do not put any HTML above this line
session_start() ;

$salt = 'XyZzy12*_';
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';  // Pw is php123


// Check to see if we have some POST data, if we do process it
if ( isset($_POST['email']) && isset($_POST['pass']) ) {
//    unset ($_SESSION['name']) ;
    if ( strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1 ) {
        $_SESSION['error'] = "User name and password are required";
        header("Location: login.php");
        return;
    } elseif (!strpos ($_POST['email'], '@')) {
        $_SESSION['error'] = "Email must have an at-sign (@)";
        header("Location: login.php");
        return;
    }  else {
        $check = hash('md5', $salt.$_POST['pass']);
        if ( $check == $stored_hash ) {
            error_log("Login success ".$_POST['email']);
            $_SESSION["name"] = $_POST["email"];
            $_SESSION["succ"] = "Logged in.";
            header("Location: index.php");
            return;
        } else {
            $_SESSION["error"] = "Incorrect password.";
            header( 'Location: login.php' ) ;
            error_log("Login fail ".$_POST['email']." $check");
            return;
        }
    }
}

// Fall through into the View
?>
<!DOCTYPE html>
<html>
<head>
<?php require_once "bootstrap.php"; ?>
<title>Navid Ghaffari's Login Page</title>
</head>
<body>
<div class="container">
<h1>Please Log In</h1>
<?php
// Note triple not equals and think how badly double
// not equals would work here...
if ( isset($_SESSION["error"] ) ) {
    // Look closely at the use of single and double quotes
    echo('<p style="color: red;">'.$_SESSION["error"]."</p>\n");
    unset($_SESSION["error"]);
}
?>
<form method="POST">
User Name <input type="text" name="email"><br/>
Password <input type="text" name="pass"><br/>
<input type="submit" value="Log In">
<a href="index.php">Cancle</a> 
</form>

</div>
</body>
