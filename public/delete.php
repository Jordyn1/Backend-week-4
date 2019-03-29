<?php 
// code will execute if button is clicked
	
    require "../config.php";
    require "common.php";
    
	try {
        $connection = new PDO($dsn, $username, $password, $options);
        
        $sql = "SELECT * FROM works";
        
        $statement = $connection->prepare($sql);
        $statement->execute();
        
        $result = $statement->fetchAll();
	} catch(PDOException $error) {
		echo $sql . "<br>" . $error->getMessage();
	}	
?>
<?php
    // This code will only run if the delete button is clicked
    if (isset($_GET["id"])) {
	    // this is called a try/catch statement 
        try {
            // define database connection
            $connection = new PDO($dsn, $username, $password, $options);
            
            // set id variable
            $id = $_GET["id"];
            
            // Create the SQL 
            $sql = "DELETE FROM works WHERE id = :id";
            // Prepare the SQL
            $statement = $connection->prepare($sql);
            
            // bind the id to the PDO
            $statement->bindValue(':id', $id);
            
            // execute the statement
            $statement->execute();
            // Success message
            $success = "Work successfully deleted";
        } catch(PDOException $error) {
            // if there is an error, tell us what it is
            echo $sql . "<br>" . $error->getMessage();
        }
    };
    // This code runs on page load
    try {
        $connection = new PDO($dsn, $username, $password, $options);
		
        // SECOND: Create the SQL 
        $sql = "SELECT * FROM works";
        
        // THIRD: Prepare the SQL
        $statement = $connection->prepare($sql);
        $statement->execute();
        
        // FOURTH: Put it into a $result object that we can access in the page
        $result = $statement->fetchAll();
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
?>


<?php include "templates/header.php"?>
<?php include "templates/navigation.php"?>
<h2>Results</h2>
<?php 
    // This is a loop, which will loop through each result in the array
    foreach($result as $row) { 
?>

<p>
    ID:
    <?php echo $row["id"]; ?><br> 
    Movie Title:
    <?php echo $row['movietitle']; ?><br> 
    Director Name:
    <?php echo $row['directorname']; ?><br> 
    Year:
    <?php echo $row['year']; ?><br> 
    Genre:
    <?php echo $row['genre']; ?><br>
   
    <a href='delete.php?id=<?php echo $row['id']; ?>'>Delete</a>
</p>



<?php 
        // this willoutput all the data from the array
//        echo '<pre>'; var_dump($row); 
?>

<hr>
<?php }; //close the foreach
 
?>





<?php include "templates/footer.php"?>