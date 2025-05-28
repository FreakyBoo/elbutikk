<?php
session_start();    

// Koble til databasen
$conn = new mysqli("localhost", "julian", "Julian2007!", "elbutikk");
if ($conn->connect_error) {
    die("Tilkoblingsfeil: " . $conn->connect_error);
}
// Når skjemaet sendes inn
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $epost = $_POST['epost'];
    $passord = $_POST['passord'];

    // SQL for å hente bruker med gitt epost
    $sql = "SELECT * FROM kunder WHERE epost = '$epost'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) { // Skjekker om epost finnes
        $row = $result->fetch_assoc();
        if (password_verify($passord, $row['passord'])) { // Sjekker om passord stemmer
            $_SESSION['kunde_id'] = $row['kunde_id']; // Lagre kunde ID i sesjonen
            $_SESSION['fornavn'] = $row['fornavn']; // Lagre fornavn i sesjonen

            header("Location: velkommen.php"); // Omdiriger til velkommen siden
            exit();
        } else {
            echo "Feil passord.";
        }
    } else {
        echo "E-post ikke funnet.";
    }
}
?>
<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <title>Logg inn - El butikk</title>
    <link rel="stylesheet" href="nettside.css">
</head>
<body>
    <h1>Logg inn</h1>
    <form method="post">
        <label for="epost">E-post:</label>
        <input type="email" id="epost" name="epost" tabindex="1" required><br>

        <label for="passord">Passord:</label>
        <input type="password" id="passord" name="passord" tabindex="2" required><br>

        <input type="submit" value="Logg inn" tabindex="3">
    </form>
    <br>
    <p>Har du ikke en konto? <a href="registrer.php">Registrer deg her</a></p>
</body>
</html>