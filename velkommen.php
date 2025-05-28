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
// Hent brukerens fornavn og ID fra sesjonen
$fornavn = $_SESSION['fornavn'];
$kunde_id = $_SESSION['kunde_id'];
?>
<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <title>Velkommen <?php echo "$fornavn"?> til EL butikk</title>
    <link rel="stylesheet" href="nettside.css">
</head>
<body>
    <h1>Velkommen <?php echo "$fornavn"?>, til EL butikken</h1>
    <p>Vennligst velg et alternativ for å komme i gang</p>

    <div>
        <a href="bestill.php"tabindex ="1">Bestill produkter</a></p> 
        <br>
    <p><a href="index.php" tabindex ="2">Logg ut</a></p>
    </div>
    <br>
    <img src="https://img.freepik.com/premium-vector/el-monogram-logo-design-letter-text-name-symbol-monochrome-logotype-alphabet-character-simple-logo_955145-11458.jpg" alt="El butikk logo" width="400" height="400">
</body>
<footer>
    <p>&copy; 2025 EL butikk. All rights reserved</p>
</footer>
</html>