<?php
/**
 * @var mysqli $mysqli
 */

// Definieer variabelen en start met lege waardes
$title = $description = "";
$title_err = $description_err = "";

// Verwerken van gegevens wanneer formulier is opgeslagen
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Include config file
    require_once "config.php";

    // Valideer title
    $input_title = trim($_POST["title"]);
    if(empty($input_title)){
        $title_err = "Vul een titel in.";
    } elseif(!filter_var($input_title, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $title_err = "Vul een geldige titel in.";
    } else{
        $title = $input_title;
    }

    // Valideer description
    $input_description = trim($_POST["description"]);
    if(empty($input_description)){
        $description_err = "Vul een beschrijving in.";
    } else{
        $description = $input_description;
    }

    // Controleer input errors voordat deze ingevoegd worden in de database
    if(empty($title_err) && empty($description_err)){
        // Bereid een insert statement voor
        $query = "INSERT INTO recipies (title, description) VALUES ('$title', '$description')";
        $result = mysqli_query($mysqli, $query) or die ('Error: ' . $query . '<br>' . mysqli_error($mysqli));

        if ($result){
            header('Location: index.php');
        } else {
            echo 'error in mysql';
        }
    }

    // Sluit verbinding met de database af
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Maak nieuw recept</title>
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
                <h2 class="mt-5">Maak nieuw recept</h2>
                <p>Vul dit formulier in en sla de wijzigingen op, om het recept toe te voegen aan de database.</p>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control <?php echo (!empty($title_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $title; ?>">
                        <span class="invalid-feedback"><?php echo $title_err;?></span>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" class="form-control <?php echo (!empty($description_err)) ? 'is-invalid' : ''; ?>"><?php echo $description; ?></textarea>
                        <span class="invalid-feedback"><?php echo $description_err;?></span>
                    </div>
                    <input type="submit" class="btn btn-primary" value="Submit">
                    <a href="index.php" class="btn btn-secondary ml-2">Annuleer</a>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
