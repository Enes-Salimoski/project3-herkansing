<?php
// Include config
include 'config.php';

// Include header
include 'header.php';

// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['gebruikers_ID'])) {
    header("Location: login.php");
    exit();
}

// Get current user's ID
$gebruikers_ID = $_SESSION['gebruikers_ID'];

// Display friends
echo "<h2>Mijn Vrienden</h2>";

// Query to retrieve friends
$sql = "SELECT * FROM vrienden WHERE gebruiker1_ID = ? OR gebruiker2_ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $gebruikers_ID, $gebruikers_ID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $vriend_ID = ($row['gebruiker1_ID'] == $gebruikers_ID) ? $row['gebruiker2_ID'] : $row['gebruiker1_ID'];

        // Query to retrieve friend's information
        $sql2 = "SELECT * FROM gebruikers WHERE gebruikers_ID = ?";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bind_param("i", $vriend_ID);
        $stmt2->execute();
        $result2 = $stmt2->get_result();
        $row2 = $result2->fetch_assoc();

        // Display friend's information
        echo "<a href='profile.php?id=" . $row2['gebruikers_ID'] . "'>Naam: " . $row2['naam'] . "</a><br>";
        echo "Email: " . $row2['email'] . "<br><br>";

        // Close statement
        $stmt2->close();
    }
} else {
    echo "Geen vrienden gevonden.";
}

// Add vriend form
echo "<h2>Vriend Toevoegen</h2>";
echo "<form method='post' action='add_friend.php'>";
echo "Gebruikersnaam: <input type='text' name='vriend_naam' required>";
echo "<input type='submit' value='Toevoegen'>";
echo "</form>";

// Close statement and database connection
$stmt->close();
$conn->close();
?>

<link rel="stylesheet" type="text/css" href="style.css">
