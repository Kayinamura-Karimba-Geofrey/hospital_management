<?php
error_reporting(0);
ini_set('display_errors', 0);
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    echo '<div class="alert alert-danger">Access denied: Admins only.</div>';
    include '../include/header.php';
    exit;
}
include('../config/db.php');
$id = $_GET['id'] ?? 0;
$stmt = $conn->prepare("DELETE FROM users WHERE id = ? AND role = 'nurse'");
$stmt->bind_param('i', $id);
if ($stmt->execute()) {
    header('Location: index.php');
    exit;
} else {
    include '../include/header.php';
    echo '<div class="alert alert-danger">Error: ' . $stmt->error . '</div>';
    include '../include/footer.php';
} 