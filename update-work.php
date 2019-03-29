<?php

    require "../config.php";
    require "common.php";

// run when submit button is clicked
    if (isset($_POST['submit'])) {
        try {
            $connection = new PDO($dsn, $username, $password, $options);  
            
            //grab elements from form and set as varaible
            $work =[
              "id"         => $_POST['id'],
              "movietitle" => $_POST['movietitle'],
              "directorname"  => $_POST['directorname'],
              "year"   => $_POST['year'],
              "genre"   => $_POST['genre'],
              "date"   => $_POST['date'],
            ];
            
            // create SQL statement
            $sql = "UPDATE `works` 
                    SET id = :id, 
                        movietitle = :movietitle, 
                        directorname = :directorname, 
                        year = :year, 
                        genre = :genre, 
                        date = :date 
                    WHERE id = :id";

            //prepare sql statement
            $statement = $connection->prepare($sql);
            
            //execute sql statement
            $statement->execute($work);

        } catch(PDOException $error) {
            echo $sql . "<br>" . $error->getMessage();
        }
    }


//get data from DB
// GET data from DB
    //simple if/else statement to check if the id is available
    if (isset($_GET['id'])) {
        //yes the id exists 
        
        try {
            // standard db connection
            $connection = new PDO($dsn, $username, $password, $options);
            
            // set if as variable
            $id = $_GET['id'];
            
            //select statement to get the right data
            $sql = "SELECT * FROM works WHERE id = :id";
            
            // prepare the connection
            $statement = $connection->prepare($sql);
            
            //bind the id to the PDO id
            $statement->bindValue(':id', $id);
            
            // now execute the statement
            $statement->execute();
            
            // attach the sql statement to the new work variable so we can access it in the form
            $work = $statement->fetch(PDO::FETCH_ASSOC);
            
        } catch(PDOExcpetion $error) {
            echo $sql . "<br>" . $error->getMessage();
        }
    } else {
        // no id, show error
        echo "No id - something went wrong";
        //exit;
    };

?>

<?php include "templates/header.php";?>

<?php if (isset($_POST['submit']) && $statement) : ?>
        
        <p>Work successfully updated</p>

<?php endif; ?>

<h2>Edit a work</h2>

<form method="post">

    <label for="id">ID</label>
    <input type="text" name="id" id="id" value="<?php echo escape($work['id']); ?>" >
    
    <label for="movietitle">Movie Title</label>
    <input type="text" name="movietitle" id="movietitle" value="<?php echo $work['movietitle']; ?>">

    <label for="directorname">Director Name</label>
    <input type="text" name="directorname" id="directorname" value="<?php echo $work['directorname']; ?>">

    <label for="year">Year</label>
    <input type="text" name="year" id="year" value="<?php echo $work['year']; ?>">

    <label for="genre">Genre</label>
    <input type="text" name="genre" id="genre" value="<?php echo $work['genre']; ?>">
    
    <label for="date">Work Date</label>
    <input type="text" name="date" id="date" value="<?php echo $work['date']; ?>">

    <input type="submit" name="submit" value="Save">

</form>


<?php include "templates/footer.php" ?>










