<?php 
// code will execute if button is clicked
	
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
    
    <a href='update-work.php?id=<?php echo $row['id']; ?>'>Edit</a>
</p>

<?php 
        // this willoutput all the data from the array
//        echo '<pre>'; var_dump($row); 
?>

<hr>
<?php }; //close the foreach
 
?>





<?php include "templates/footer.php"?>