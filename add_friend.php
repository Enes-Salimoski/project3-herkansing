<?php
include 'config.php';

session_start();

if (!isset($_SESSION['gebruikers_ID'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_POST['vriend_naam'])) {
    die("Vriend naam niet opgegeven.");
}

$gebruikers_ID = $_SESSION['gebruikers_ID'];
$vriend_naam = $_POST['vriend_naam'];

echo "Gebruikers ID: " . $gebruikers_ID . "<br>";
echo "Vriend naam: " . $vriend_naam . "<br>";

// check of de vriend bestaat
$sql = "SELECT gebruikers_ID FROM gebruikers WHERE naam = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $vriend_naam);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $vriend_ID = $row['gebruikers_ID'];

    echo "Vriend ID: " . $vriend_ID . "<br>";

    // check of de vriend bestaat van beide kanten
    $sql = "SELECT * FROM vrienden WHERE (gebruiker1_ID = ? AND gebruiker2_ID = ?) OR (gebruiker1_ID = ? AND gebruiker2_ID = ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiii", $gebruikers_ID, $vriend_ID, $vriend_ID, $gebruikers_ID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        // vriendschap verzoek
        $sql = "INSERT INTO vrienden (gebruiker1_ID, gebruiker2_ID) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $gebruikers_ID, $vriend_ID);

        if ($stmt->execute() === TRUE) {
            header("Location: friends.php");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Vriendenrequest al gestuurd.";
    }
} else {
    echo "Gebruiker niet gevonden.";
}

$stmt->close();
$conn->close();
?>
