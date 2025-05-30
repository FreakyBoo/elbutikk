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
    <title>Logg inn - EL butikk</title>
    <link rel="stylesheet" href="nettside.css">
</head>
<body>
    <h1>Logg inn</h1>
    <form method="post">
        <label for="epost">E-post:</label>
        <input type="email" id="epost" name="epost" tabindex="1" required><br>
        <br>
        <label for="passord">Passord:</label>
        <input type="password" id="passord" name="passord" tabindex="2" required><br>
        <br>
        <button type="submit" value="Logg inn" tabindex="3">Logg inn</button>
    </form>
    <p>Har du ikke en konto? <br>
    <br>
    <a href="registrer.php" tabindex = "4">Registrer deg her</a></p>
    <br>
    <a href="index.php" tabindex = "5">Tibake til forsiden</a></p>
    <br>
    <img src="https://img.freepik.com/premium-vector/el-monogram-logo-design-letter-text-name-symbol-monochrome-logotype-alphabet-character-simple-logo_955145-11458.jpg" alt="El butikk logo" width="200" height="200">
</body>
<footer>
    <p>&copy; 2025 EL butikk. All rights reserved</p>
</footer>
</html>