<?php
/**
 * @var mysqli $mysqli
 */

// Voeg config file toe
require_once "config.php";

// Definieer variabelen en start met lege waardes
$title = $description = "";
$title_err = $description_err = "";

// Verwerk gegevens wanneer formulier word verstuurd
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Haal verborgen input waarde op
    $id = $_POST["id"];

    // Valideer title
    $input_title = mysqli_escape_string($mysqli, trim($_POST["title"]));
    if(empty($input_title)){
        $title_err = "Vul een titel in.";
    } elseif(!filter_var($input_title, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $title_err = "Vul een geldige titel in.";
    } else{
        $title = $input_title;
    }

    // Valideer description
    $input_description = mysqli_escape_string($mysqli, trim($_POST["description"]));
    if(empty($input_description)){
        $description_err = "Vul een beschrijving in.";
    } else{
        $description = $input_description;
    }

    $recipe = [
        'title' => $title,
        'description' => $description
    ];

    // Controleer input errors voordat deze ingevoegd worden in de database
    if(empty($title_err) && empty($description_err)) {
        // Bereid een update statement voor
        $query = "UPDATE recipies SET title='$title', description='$description' WHERE id='$id'";

        $result = mysqli_query($mysqli, $query);

        if ($result){
            header('Location: index.php');
            exit;
        } else {
            echo 'error in query';
        }
    }

    // Sluit connectie met de database
    $mysqli->close();
} else{
    // controlleren van bestaan van de id parameter, voordat het proces verder gaat
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // ophalen van URL parameter
        $id =  trim($_GET["id"]);

        // bereid een select statement voor
        $query = "SELECT * FROM recipies WHERE id = '$id'";

        // uitvoeren en in variabele stoppen
        $result = mysqli_query($mysqli, $query) or die('Error: ' . $query . '<br>' . mysqli_error($mysqli));
        $recipe = mysqli_fetch_assoc($result);

        // sluit connectie met de database
        $mysqli->close();
    }  else{
        // Als URL geen id parameters bevat, verbind door naar error pagina
        header("location: error.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Recipe</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="mt-5">Update Recipe</h2>
                <p>Update de gegevens en sla op, om het recept aan te passen.</p>
                <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $recipe['title']; ?>">
                        <span class="invalid-feedback"><?php echo $title_err;?></span>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" class="form-control <?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?>"><?php echo $recipe['description']; ?></textarea>
                        <span class="invalid-feedback"><?php echo $description_err;?></span>
                    </div>
                    <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                    <input type="submit" class="btn btn-primary" value="Submit">
                    <a href="index.php" class="btn btn-secondary ml-2">Annuleer</a>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
