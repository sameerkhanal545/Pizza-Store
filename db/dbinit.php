<!doctype html>
<html>
    <head>
      
    </head>
    <body>
         <?php 
        
            if($_SERVER['REQUEST_METHOD'] == "POST"){
                
               require_once("dbhelper.php");
               DBHelper::initializeDatabase();
                
                echo "<h3>Database Intitialized</h3>";
            }
        
        ?>
        <form method= "POST">
            <input type ="submit" value="Initialize"/>
        </form>
    </body>
</html>







