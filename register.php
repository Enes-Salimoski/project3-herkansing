<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $naam = $_POST['naam'];
    $email = $_POST['email'];
    $wachtwoord = password_hash($_POST['wachtwoord'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO gebruikers (naam, email, wachtwoord) VALUES ('$naam', '$email', '$wachtwoord')";

    if ($conn->query($sql) === TRUE) {
        echo "Registratie geslaagd";
    } else {
        echo "Fout: " . $sql . "<br>" . $conn->error;
    }
}
?>

<form method="post" action="register.php">
    Naam: <input type="text" name="naam" required><br>
    Email: <input type="email" name="email" required><br>
    Wachtwoord: <input type="password" name="wachtwoord" required><br>
    <input type="submit" value="Registreren">
</form>
