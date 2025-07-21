<?php
error_reporting(0);
ini_set('display_errors', 0);
session_start();
include('../includes/auth.php');
include('../config/db.php');
isAdmin(); // Only admin can delete patients

$id = $_GET['id'] ?? 0;

$stmt = $conn->prepare("DELETE FROM patients WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: view.php");
    exit;
} else {
    echo "Error: " . $stmt->error;
}
?>
