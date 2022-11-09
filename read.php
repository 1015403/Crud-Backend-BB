<?php
// Check bestaan van id van de parameter voor het verder gaan met processen
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // voeg config file toe
    require_once "config.php";

    // Voorbereiden van een query
    $sql = "SELECT * FROM recipies WHERE id = ?";

    if($stmt = $mysqli->prepare($sql)){
        // Bind variabelen aan de voorbereide instructie als parameters
        $stmt->bind_param("i", $param_id);

        // Stel parameters in
        $param_id = trim($_GET["id"]);

        // Probeer de voorbereidde statement uit te voeren
        if($stmt->execute()){
            $result = $stmt->get_result();

            if($result->num_rows == 1){
                /* Haal de resultaatrij op als een associatieve array. Sinds de resultatenset
                slechts één rij bevat, hoeven we geen while-lus te gebruiken */
                $row = $result->fetch_array(MYSQLI_ASSOC);

                // Haal individueel veld waarde op
                $title = $row["title"];
                $description = $row["description"];
            } else{
                // URL bevat geen geldige ID-parameter. Doorverwijzen naar foutpagina
                header("location: error.php");
                exit();
            }

        } else{
            echo "Oeps! Er is iets mis gegaan. Probeer het later opnieuw.";
        }
    }

    // Sluit statement
    $stmt->close();

    // Sluit connectie met database
    $mysqli->close();
} else{
    // URL bevat geen geldige ID-parameter. Doorverwijzen naar foutpagina
    header("location: error.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bekijk recept</title>
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
                <h1 class="mt-5 mb-3">View Record</h1>
                <div class="form-group">
                    <label>Title</label>
                    <p><b><?php echo $row["title"]; ?></b></p>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <p><b><?php echo $row["description"]; ?></b></p>
                </div>
                <p><a href="index.php" class="btn btn-primary">Terug</a></p>
            </div>
        </div>
    </div>
</div>
</body>
</html>
