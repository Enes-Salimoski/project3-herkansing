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
        $vriend_ID = $_POST['vriend_ID'];

        $sql = "UPDATE berichten SET inhoud=? WHERE bericht_ID=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $inhoud, $bericht_ID);

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

    $sql = "SELECT inhoud FROM berichten WHERE bericht_ID=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $bericht_ID);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $inhoud = $row['inhoud'];
    $stmt->close();
}
?>

<form method="post" action="edit_message.php">
    <input type="hidden" name="bericht_ID" value="<?php echo $bericht_ID; ?>">
    <input type="hidden" name="vriend_ID" value="<?php echo $vriend_ID; ?>">
    Bericht: <textarea name="inhoud" required><?php echo $inhoud; ?></textarea><br>
    <input type="submit" value="Bijwerken">
</form>
<a href="profile.php?id=<?php echo $vriend_ID; ?>">Terug naar profiel</a>
