<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Recepten overzicht</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="style.scss" lang="scss">
</head>
<body class="background">
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="mt-5 mb-3 clearfix">
                    <h2 class="pull-left">Recepten overzicht</h2>
                    <a href="create.php" class="button-style btn btn-succes pull-right">
                        <i class="fa fa-plus">Voeg nieuw recept toe</i>
                    </a>
                </div>

                <?php
                // Toevoegen van config file
                require_once "config.php";

                // Maak een variabele van de benodigde query
                $sql = "SELECT * FROM recipies";

                // Proberen query uit te voeren, haal de data op en maak hier een tabel van
                if($result = $mysqli->query($sql)){
                    if($result->num_rows > 0){
                        // Maak header voor de tabel
                        echo '<table class="table table-bordered table-striped">';
                        echo "<thead>";
                        echo "<tr>";
                        echo "<th>#</th>";
                        echo "<th>Title</th>";
                        echo "<th>Description</th>";
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";

                        // Vul de rijen met de gevonden data, zolang er data gevonden wordt
                        while($row = $result->fetch_array()){
                            echo "<tr>";
                            echo "<td>" . $row['id'] . "</td>";
                            echo "<td>" . $row['title'] . "</td>";
                            echo "<td>" . $row['description'] . "</td>";
                            echo "<td>";
                            echo '<a href="read.php?id='. $row['id'] .'" class="mr-3" title="Bekijk Recept" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                            echo '<a href="update.php?id='. $row['id'] .'" class="mr-3" title="Update Recept" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                            echo '<a href="delete.php?id='. $row['id'] .'" title="Verwijder Recept" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                            echo "</td>";
                            echo "</tr>";
                        }
                        // Sluit de tabel af
                        echo "</tbody>";
                        echo "</table>";
                        // geef error bij, niks gevonden in de database
                        $result->free();
                    } else{
                        echo '<div class="alert alert-danger"><em>Geen bestanden gevonden.</em></div>';
                    }
                    //geef error als er geen query uitgevoerd kan worden
                } else{
                    echo "Oeps! Er is iets mis gegaan. Probeer het later opnieuw.";
                }

                // database connectie sluiten
                $mysqli->close();
                ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>

