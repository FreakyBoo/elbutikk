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
