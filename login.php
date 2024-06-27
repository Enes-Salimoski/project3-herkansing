<?php
include 'config.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $wachtwoord = $_POST['wachtwoord'];

    $sql = "SELECT * FROM gebruikers WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($wachtwoord, $row['wachtwoord'])) {
            $_SESSION['gebruikers_ID'] = $row['gebruikers_ID'];
            header("Location: profile.php");
        } else {
            echo "Ongeldig wachtwoord.";
        }
    } else {
        echo "Geen gebruiker gevonden met dit e-mailadres.";
    }
}
?>

<link rel="stylesheet" type="text/css" href="style.css">

<form method="post" action="login.php">
    Email: <input type="email" name="email" required><br>
    Wachtwoord: <input type="password" name="wachtwoord" required><br>
    <input type="submit" value="Inloggen">
</form>