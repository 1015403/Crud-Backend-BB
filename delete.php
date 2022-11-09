<?php
// Verwijderingsbewerking verwerken na bevestiging
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // toevoegen van config file
    require_once "config.php";

    // voorbereiden van een delete statement
    $sql = "DELETE FROM recipies WHERE id = ?";

    if($stmt = $mysqli->prepare($sql)){
        // Bind variabelen aan de voorbereide instructie als parameters
        $stmt->bind_param("i", $param_id);

        // stel parameters in
        $param_id = trim($_POST["id"]);

        // Poging om de voorbereide instructie uit te voeren
        if($stmt->execute()){
            // Gegevens zijn verwijderd, verwijs door naar de hoofdpagina
            header("location: index.php");
            exit();
        } else{
            echo "Oeps! Er is iets mis gegaan. Probeer het later opnieuw.";
        }
    }

    // Sluit statement
    $stmt->close();

    // Sluit connectie met de database
    $mysqli->close();
} else{
    // Controlleer bestaan van Check id parameter
    if(empty(trim($_GET["id"]))){
        // URL bevat geen id-parameter verwijs door naar foutpagina
        header("location: error.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verwijder recept</title>
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
                <h2 class="mt-5 mb-3">Delete Record</h2>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="alert alert-danger">
                        <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>"/>
                        <p>Weet je zeker dat je dit recept wilt verwijderen?</p>
                        <p>
                            <input type="submit" value="Yes" class="btn btn-danger">
                            <a href="index.php" class="btn btn-secondary ml-2">Nee</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
