<?php include "templates/header.php"?>
<?php include "templates/navigation.php"?>
<?php 
// code will execute if button is clicked
if (isset($_POST['submit'])) {
	
    require "../config.php"; 
    
	try {
        $connection = new PDO($dsn, $username, $password, $options);
        
        $sql = "SELECT * FROM works";
        
        $statement = $connection->prepare($sql);
        $statement->execute();
        
        $result = $statement->fetchAll();
	} catch(PDOException $error) {
		echo $sql . "<br>" . $error->getMessage();
	}	
}
?>


<?php  
    if (isset($_POST['submit'])) {
        //if there are some results
    if ($result && $statement->rowCount() > 0) { 
?>

<h2>Results</h2>

<?php 
    // This is a loop, which will loop through each result in the array
    foreach($result as $row) { 
?>

<p1>
    <div class="results">
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
            <div class="delete-edit">
            <a href='delete.php?id=<?php echo $row['id']; ?>' class="read-button">Delete</a>
            <a href='update-work.php?id=<?php echo $row['id']; ?>' class="read-button">Edit</a>
            </div>
    </div>
</p1>

<?php 
        // this willoutput all the data from the array
        //echo '<pre>'; var_dump($row); 
?>

<hr>
<?php }; //close the foreach
        }; 
    }; 
?>


<!-- view all button  -->

<form method="post" class="view-button">    
    <input class="button" type="submit" name="submit" value="View all"> 
</form>   

 


<?php include "templates/footer.php"?>