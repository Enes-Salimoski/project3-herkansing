<?php
include 'config.php';

session_start();

if (!isset($_SESSION['gebruikers_ID'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['reactie_ID']) && isset($_POST['inhoud'])) {
        $reactie_ID = $_POST['reactie_ID'];
        $inhoud = $_POST['inhoud'];
        $vriend_ID = $_POST['vriend_ID'];

        $sql = "UPDATE reacties SET inhoud=? WHERE reactie_ID=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $inhoud, $reactie_ID);

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
    $reactie_ID = $_GET['reactie_ID'];
    $vriend_ID = $_GET['vriend_ID'];

    $sql = "SELECT inhoud FROM reacties WHERE reactie_ID=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $reactie_ID);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $inhoud = $row['inhoud'];
    $stmt->close();
}
?>

<form method="post" action="edit_reaction.php">
    <input type="hidden" name="reactie_ID" value="<?php echo $reactie_ID; ?>">
    <input type="hidden" name="vriend_ID" value="<?php echo $vriend_ID; ?>">
    Reactie: <textarea name="inhoud" required><?php echo $inhoud; ?></textarea><br>
    <input type="submit" value="Bijwerken">
</form>
<a href="profile.php?id=<?php echo $vriend_ID; ?>">Terug naar profiel</a>
