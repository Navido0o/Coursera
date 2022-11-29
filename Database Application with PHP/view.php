
<?php
session_start();

if ( ! isset($_SESSION['name']) ) {
    echo '<!DOCTYPE html>' ;
    echo '<html>' ;
    echo '<head>' ;
    echo '<title>Navid Ghaffari Autos Database</title>' ;
    echo '<?php require_once "bootstrap.php"; ?>' ;
    echo '</head>' ;
    echo '<body>' ;
    echo '<div class="container">' ;
    echo '<h1>Welcome to the Automobiles Database </h1>' ;
    
    echo '<a href="login.php">Please Log In</a>' ;
    
    echo '<p>Attempt to  <a href="add.php">add Data</a> without logging in </p>';
    echo '</div>' ;
    echo '</body>' ;
} else {
    echo '<!DOCTYPE html>' ;
    echo '<html>' ;
    echo '<head>' ;
    echo '<title>Navid Ghaffari Automobils Tracker</title>' ;
    echo '<?php require_once "bootstrap.php"; ?>' ;
    echo '</head>' ;
    echo '<body>' ;
    echo '<div class="container">' ;
    echo '<h1>Tracking Autos for '.htmlentities($_SESSION['name']) ;

    echo '</h1>' ;
    
    require_once "pdo.php";
    
    $stmt = $pdo->query("SELECT make, model, year, mileage, autos_id FROM autos");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (isset ($_SESSION['msg'])) {
        echo('<p style="color: green;">'.$_SESSION['msg']."</p>");
        unset($_SESSION['msg']) ;
    }
    echo('<table border="1">'."\n");
    if ((count ($rows) > 0 ) ){
        echo "<h1>Automobiles</h1>"."\n" ;
      
        foreach ( $rows as $row ) {
      
            echo "<tr><td>";
            echo(htmlentities($row['make']));
            echo("</td><td>");
            echo(htmlentities($row['model']));
            echo("</td><td>");
            echo(htmlentities($row['year']));
            echo("</td><td>");
            echo(htmlentities($row['mileage']));
            echo("</td><td>");
            echo('<a href="edit.php?autos_id='.$row['autos_id'].'">Edit</a> / ');
            echo('<a href="delete.php?autos_id='.$row['autos_id'].'">Delete</a>');
            echo("</td></tr>\n");        
        }
    echo '</table>' ;
    } else {
    echo "No Records" ;
    }    
    echo '<a href="add.php">Add New</a>  |  ' ;
    echo '<a href="logout.php">Logout</a> ' ;
    
    echo '</div>' ;
    echo '</body>' ;
    echo '</html>' ;
}
   
?>
    