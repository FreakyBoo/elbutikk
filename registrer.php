<?php
session_start();

// Koble til databasen
$conn = new mysqli("localhost", "julian", "Julian2007!", "elbutikk");
if ($conn->connect_error) {
    die("Tilkoblingsfeil: " . $conn->connect_error);
}

// Når skjemaet sendes inn
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fornavn = $_POST['fornavn'];
    $etternavn = $_POST['etternavn'];
    $epost = $_POST['epost'];
    $telefon = $_POST['telefon'];
    $adresse = $_POST['adresse'];
    $fodselsdato = $_POST['fodselsdato'];
    $passord = password_hash($_POST['passord'], PASSWORD_DEFAULT);

    // SQL for å sjekke om epost allerede finnes
    $sql = "SELECT * FROM kunder WHERE epost = '$epost'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) { // Hvis eposten allerede finnes
        echo "Eposten er allerede registrert.";
    } else {
        // SQL for å sette inn ny bruker
        $sql = "INSERT INTO kunder (fornavn, etternavn, epost, telefon, adresse, fodselsdato, passord)
                VALUES ('$fornavn', '$etternavn', '$epost', '$telefon', '$adresse', '$fodselsdato', '$passord')";

        if ($conn->query($sql) === TRUE) {// Hvis registreringen er vellykket
            echo "Registrering fullført! <br>
            <a href='login.php'>Logg inn her</a>";
        } else {
            echo "Feil under registrering: " . $conn->error;
        }
    }
} 
?>
<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <title>Registrer deg - El butikk</title>
    <link rel="stylesheet" href="nettside.css">
</head>
<body>
    <h1>Registrer deg</h1>
    <form method="post">
        <label for="fornavn">Fornavn:</label>
        <input type="text" id="fornavn" name="fornavn" tabindex ="1" required><br>
        <br>
        <label for="etternavn">Etternavn:</label>
        <input type="text" id="etternavn" name="etternavn" tabindex ="2" required><br>
        <br>
        <label for="epost">E-post:</label>
        <input type="email" id="epost" name="epost" tabindex ="3" required><br>
        <br>
        <label for="telefon">Telefon:</label>
        <input type="tel" id="telefon" name="telefon" tabindex ="4"><br>
        <br>
        <label for="adresse">Adresse:</label>
        <textarea id="adresse" name="adresse" placeholder="Adresse" tabindex ="5"></textarea><br>
        <br>            
        <label for="fodselsdato">Fødselsdato:</label>
        <input type="date" id="fodselsdato" name="fodselsdato" tabindex ="6"><br>
        <br>
        <label for="passord">Passord:</label>
        <input type="password" id="passord" name="passord" tabindex ="7" required><br>
        <br>
        <button type="submit" tabindex ="8">Registrer</button>
    </form>
    <p>Har du allerede en konto? <br>
    <br>
    <a href="login.php" tabindex ="9">Logg inn her</a></p>
    <p><a href="index.php" tabindex ="10">Tilbake til forsiden</a></p>
    <br>
    <img src="https://img.freepik.com/premium-vector/el-monogram-logo-design-letter-text-name-symbol-monochrome-logotype-alphabet-character-simple-logo_955145-11458.jpg" alt="El butikk logo" width="200" height="200">
</body>
</html>