<?php
session_start();

// Koble til databasen
$conn = new mysqli("localhost", "julian", "Julian2007!", "elbutikk");
if ($conn->connect_error) {
    die("Tilkoblingsfeil: " . $conn->connect_error);
}
// Sjekk om bruker er logget inn
if (!isset($_SESSION['kunde_id'])) {
    header("Location: login.php");
    exit();
}

// Start handlekurv hvis den ikke finnes
if (!isset($_SESSION["handlekurv"])) {
    $_SESSION["handlekurv"] = [];
}

// Legg til produkt i handlekurv
if (isset($_POST["legg_til"])) {
    $produkt_id = $_POST["legg_til"];
    $_SESSION["handlekurv"][] = $produkt_id;
}

// Fullfør bestilling
if (isset($_POST["complete_order"])) {
    $conn = new mysqli("localhost", "julian", "Julian2007!", "elbutikk");
    if ($conn->connect_error) die("Tilkoblingsfeil: " . $conn->connect_error);

    $kunde_id = $_SESSION['kunde_id'];
    
    // Opprett ny bestilling
    $sql = "INSERT INTO bestillinger (kunde_id) VALUES ('$kunde_id')";
    $conn->query($sql);
    $bestilling_id = $conn->insert_id;


    // Legg til produkter i bestillingen
    foreach ($_SESSION["handlekurv"] as $produkt_id) {
        $sql = "SELECT pris FROM produkter WHERE produkt_id = '$produkt_id'";
        $result = $conn->query($sql);
        $produkt = $result->fetch_assoc();
        $produkt_pris = $produkt['pris'];


        $sql = "INSERT INTO bestillingsdetaljer (bestilling_id, produkt_id, antall, produkt_pris) VALUES ('$bestilling_id', '$produkt_id', 1, '$produkt_pris')";
        $conn->query($sql);
    }
    // Tøm handlekurven
    unset($_SESSION["handlekurv"]);
      echo "<p>Bestillingen er fullført! <br><br> <a href='velkommen.php'>Gå tilbake</a></p>";
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <title>Bestill produkter - EL butikk</title>
    <link rel="stylesheet" href="nettside.css">
</head>
<body>
    <h1>Bestill produkter</h1>

    <form method="post">
        <div class = "produkter">
        <?php
        // Koble til databasen
        $conn = new mysqli("localhost", "julian", "Julian2007!", "elbutikk");
        $sql = "SELECT * FROM produkter";
        $result = $conn->query($sql);

        while ($row = $result->fetch_assoc()) {
        ?>
            <div class="produkt">
                <h2><?php echo $row['navn']; ?></h2>
                <p>Pris: <?php echo $row['pris']; ?> kr</p>
                <img src="<?php echo $row['bilde']; ?>" alt="<?php echo $row['navn']; ?>" width="200" height="200">
                <button type="submit" name="legg_til" value="<?php echo $row['produkt_id']; ?>" tabindex="1">Legg til i handlekurv</button>
            </div>
        <?php }
        $conn->close();
        ?>
        
        </div>
        <h2>Handlekurv</h2>
        <ul>
        <?php
        if (!empty($_SESSION["handlekurv"])) {
            $conn = new mysqli("localhost", "julian", "Julian2007!", "elbutikk");
              foreach ($_SESSION["handlekurv"] as $produkt_id) {
                    $sql = "SELECT navn FROM produkter WHERE produkt_id = '$produkt_id'";
                    $result = $conn->query($sql);
                    $navn = $result->fetch_assoc()["navn"];
                    echo "<li>$navn</li>";
                    }
                $conn->close();
            } else {
                echo "<li>Handlekurven er tom</li>";
            }
            ?>
        </ul>
        <button type="submit" name="complete_order" tabindex ="2">Fullfør bestilling</button>
    </form>
</body>
<footer>
    <p>&copy; 2025 EL butikk. All rights reserved</p>
</footer>
</html>
    



