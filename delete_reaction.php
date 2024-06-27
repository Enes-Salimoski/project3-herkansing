<?php
include 'config.php';

session_start();

if (!isset($_SESSION['gebruikers_ID'])) {
    header("Location: login.php");
    exit();
}

$reactie_ID = $_GET['reactie_ID'];
$sql = "DELETE FROM reacties WHERE reactie_ID=? AND gebruiker_ID=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $reactie_ID, $_SESSION['gebruikers_ID']);

if ($stmt->execute() === TRUE) {
    header("Location: profile.php");
} else {
    echo "Fout: " . $sql . "<br>" . $conn->error;
}
$stmt->close();
?>
