
<?php 
// this code will only execute after the submit button is clicked
if (isset($_POST['submit'])) {
	
    // include the config file that we created before
    require "../config.php"; 
    
    // this is called a try/catch statement 
	try {
        // FIRST: Connect to the database
        $connection = new PDO($dsn, $username, $password, $options);
		
        // SECOND: Get the contents of the form and store it in an array
        $new_work = array( 
            "movietitle" => $_POST['movietitle'], 
            "directorname" => $_POST['directorname'],
            "year" => $_POST['year'],
            "genre" => $_POST['genre'], 
        );
        
        // THIRD: Turn the array into a SQL statement
        $sql = "INSERT INTO works (movietitle, directorname, year, genre) VALUES (:movietitle, :directorname, :year, :genre)";        
        
        // FOURTH: Now write the SQL to the database
        $statement = $connection->prepare($sql);
        $statement->execute($new_work);
	} catch(PDOException $error) {
        // if there is an error, tell us what it is
		echo $sql . "<br>" . $error->getMessage();
	}	
}
?>



<?php include "templates/header.php"?>

<h2>Add a work</h2>

<?php if (isset($_POST['submit']) && $statement) { ?>
<p>Work successfully added.</p>
<?php } ?>

<!--form to collect data for each artwork-->

<form method="post">
    <label for="movietitle">Movie Title</label>
    <input type="text" name="movietitle" id="movietitle">

    <label for="directorname">Director Name</label>
    <input type="text" name="directorname" id="directorname">

    <label for="year">Year</label>
    <input type="text" name="year" id="year">

    <label for="genre">Genre</label>
    <input type="text" name="genre" id="genre">


    <input type="submit" name="submit" value="Submit">

</form>

<?php include "templates/footer.php"?>
