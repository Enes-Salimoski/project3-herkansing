<?php
include 'config.php';
include 'header.php';

session_start();

if (!isset($_SESSION['gebruikers_ID'])) {
    header("Location: login.php");
    exit();
}

$gebruikers_ID = $_SESSION['gebruikers_ID'];

// username van database
$sql = "SELECT naam FROM gebruikers WHERE gebruikers_ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $gebruikers_ID);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$my_naam = $row['naam'];

// Check of user ID is provided
if (isset($_GET['id'])) {
    $vriend_ID = $_GET['id'];
    if ($vriend_ID == $gebruikers_ID) {
        header("Location: profile.php");
        exit();
    }
} else {
    $vriend_ID = $gebruikers_ID;
    $vriend_naam = $my_naam;
}

// vriend van database ophalen
$sql = "SELECT naam FROM gebruikers WHERE gebruikers_ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $vriend_ID);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$vriend_naam = $row['naam'];

// vriend profile info
$sql = "SELECT * FROM gebruikers WHERE gebruikers_ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $vriend_ID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo "Profiel van " . $vriend_naam . "!<br>";
    echo "Email: " . $row['email'] . "<br>";
    if (isset($row['profieltekst'])) {
        echo "Profieltekst: " . $row['profieltekst'] . "<br>";
    } else {
        echo "Geen profieltekst beschikbaar.<br>";
    }
}

// Form to add a new message
if ($gebruikers_ID == $vriend_ID) {
    echo "<h2>Plaats een nieuw bericht</h2>";
    echo "<form method='post' action='add_message.php'>";
    echo "Bericht: <textarea name='inhoud' required></textarea><br>";
    echo "<input type='submit' value='Plaatsen'>";
    echo "</form><br>";
}

// Display friend's messages
echo "<h2>Berichten van " . $vriend_naam . "</h2>";
$sql = "SELECT * FROM berichten WHERE gebruiker_ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $vriend_ID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "Bericht: " . $row['inhoud'] . "<br>";
        if ($row['gebruiker_ID'] == $gebruikers_ID) {
            echo "<a href='edit_message.php?bericht_ID=" . $row['bericht_ID'] . "&vriend_ID=" . $vriend_ID . "'>Bewerken</a> ";
            echo "<a href='delete_message.php?bericht_ID=" . $row['bericht_ID'] . "&vriend_ID=" . $vriend_ID . "'>Verwijderen</a> ";
        }
        echo "<a href='add_reaction.php?bericht_ID=" . $row['bericht_ID'] . "&vriend_ID=" . $vriend_ID . "'>Reageren</a><br><br>";

        // Display reactions
        $sql2 = "SELECT * FROM reacties WHERE bericht_ID = ?";
        $stmt_reacties = $conn->prepare($sql2);
        $stmt_reacties->bind_param("i", $row['bericht_ID']);
        $stmt_reacties->execute();
        $result_reacties = $stmt_reacties->get_result();
        while ($row_reactie = $result_reacties->fetch_assoc()) {
            echo "Reactie: " . $row_reactie['inhoud'];
            if ($row_reactie['gebruiker_ID'] == $gebruikers_ID) {
                echo " <a href='edit_reaction.php?reactie_ID=" . $row_reactie['reactie_ID'] . "&vriend_ID=" . $vriend_ID . "'>Bewerken</a>";
                echo " <a href='delete_reaction.php?reactie_ID=" . $row_reactie['reactie_ID'] . "&vriend_ID=" . $vriend_ID . "'>Verwijderen</a>";
            }
            echo "<br>";
        }
        $stmt_reacties->close();
    }
} else {
    echo "Geen berichten gevonden.";
}

// vriend knop
if ($gebruikers_ID != $vriend_ID) {
    echo "<form method='post' action='add_friend.php'>";
    echo "<input type='hidden' name='vriend_naam' value='" . $vriend_naam . "'>";
    echo "<input type='hidden' name='vriend_ID' value='" . $vriend_ID . "'>";
    echo "<input type='submit' value='Voeg als vriend toe'>";
    echo "</form><br><br>";
}

$stmt->close();
$conn->close();
?>

<link rel="stylesheet" type="text/css" href="style.css">

<a href="logout.php">Uitloggen</a>
