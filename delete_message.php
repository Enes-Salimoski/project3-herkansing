<?php
include 'config.php';

session_start();

if (!isset($_SESSION['gebruikers_ID'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['bericht_ID'])) {
        $bericht_ID = $_POST['bericht_ID'];
        $vriend_ID = $_POST['vriend_ID'];

        $sql = "DELETE FROM berichten WHERE bericht_ID=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $bericht_ID);

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

<form method="post" action="delete_message.php">
    <input type="hidden" name="bericht_ID" value="<?php echo $bericht_ID; ?>">
    <input type="hidden" name="vriend_ID" value="<?php echo $vriend_ID; ?>">
    <p>Weet je zeker dat je dit bericht wilt verwijderen?</p>
    <input type="submit" value="Verwijderen">
</form>
<a href="profile.php?id=<?php echo $vriend_ID; ?>">Terug naar profiel</a>
