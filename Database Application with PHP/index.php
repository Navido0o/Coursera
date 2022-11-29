
<?php
session_start();
require_once "bootstrap.php"; 

if ( ! isset($_SESSION['name']) ) {
    echo '<!DOCTYPE html>' ;
    echo '<html>' ;
    echo '<head>' ;
    echo '<title>Navid Ghaffari Autos Database</title>' ;
    echo '</head>' ;
    echo '<body>' ;
    echo '<div class="container">' ;
    echo '<h1>Welcome to the Automobiles Database </h1>' ;
    
    echo '<a href="login.php">Please log in</a>'."\n" ;
    echo '<br>' ;
    echo '<p>Attempt to  <a href="add.php">add Data</a> without logging in </p>';
    echo '</div>' ;
    echo '</body>' ;
} else {
    echo '<!DOCTYPE html>' ;
    echo '<html>' ;
    echo '<head>' ;
    echo '<title>Navid Ghaffari Automobils Tracker</title>' ;
    echo '</head>' ;
    echo '<body>' ;
    echo '<div class="container">' ;
    echo '<h1>' ;
    echo 'Welcome to the Automobiles Database';
    echo '</h1>' ;
    
    require_once "pdo.php";
    
    $stmt = $pdo->query("SELECT make, model, year, mileage, autos_id FROM autos");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (isset ($_SESSION['msg'])) {
        echo('<p style="color: green;">'.$_SESSION['msg']."</p>");
        unset($_SESSION['msg']) ;
    }


    if ((count ($rows) > 0 ) ){
        echo "<h1>Automobiles</h1>"."\n" ;

        echo('<table border="1">'."\n");
    
        echo "<tr><td>";
        echo "make";
        echo("</td><td>");
        echo "model";
        echo("</td><td>");
        echo "year";
        echo("</td><td>");
        echo "mileage" ;
        echo("</td><td>");
        echo "action";
        echo("</td></tr>\n");         
      
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
    echo '<br>' ;
    } else {
    echo "No rows found" ;
    echo '<br>' ;
    }    
    echo '<br>' ;
    echo '<br>' ;
    echo '<a href="add.php">Add New Entry</a>' ;
    echo '<br>' ;
    echo '<br>' ;
    echo '<a href="logout.php">Logout</a> ' ;
    
    echo '</div>' ;
    echo '</body>' ;
    echo '</html>' ;
}
   
?>
    