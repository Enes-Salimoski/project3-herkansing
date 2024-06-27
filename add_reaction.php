<?php
include 'config.php';

session_start();

if (!isset($_SESSION['gebruikers_ID'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['bericht_ID']) && isset($_POST['inhoud'])) {
        $bericht_ID = $_POST['bericht_ID'];
        $inhoud = $_POST['inhoud'];
        $gebruiker_ID = $_SESSION['gebruikers_ID'];
        $vriend_ID = $_POST['vriend_ID'];

        $sql = "INSERT INTO reacties (bericht_ID, gebruiker_ID, inhoud) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iis", $bericht_ID, $gebruiker_ID, $inhoud);

        if ($stmt->execute() === TRUE) {
            header("Location: profile.php?id=" . $vriend_ID);
        } else {
            echo "Fout: " . $sql . "<br>" . $conn->error;
        }
        $stmt->close();
    } else {
        echo "Onvolledige gegevens ontvangen.";
    }
} else {
    $bericht_ID = $_GET['bericht_ID'];
    $vriend_ID = $_GET['vriend_ID'];
}
?>

<form method="post" action="add_reaction.php">
    <input type="hidden" name="bericht_ID" value="<?php echo $bericht_ID; ?>">
    <input type="hidden" name="vriend_ID" value="<?php echo $vriend_ID; ?>">
    Reactie: <textarea name="inhoud" required></textarea><br>
    <input type="submit" value="Plaatsen">
</form>
<a href="profile.php?id=<?php echo $vriend_ID; ?>">Terug naar profiel</a>
