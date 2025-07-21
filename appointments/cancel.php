<?php
session_start();
include('../includes/auth.php');
include('../config/db.php');
isAdmin(); // Only admin can cancel appointments

$id = $_GET['id'] ?? 0;

$stmt = $conn->prepare("DELETE FROM appointments WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: view.php");
    exit;
} else {
    echo "Error: " . $stmt->error;
}
?>
