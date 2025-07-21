<?php
include '../include/header.php';
error_reporting(0);
ini_set('display_errors', 0);
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    echo '<div class="alert alert-danger">Access denied: Admins only.</div>';
    include '../include/footer.php';
    exit;
}
include('../config/db.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = 'nurse';
    $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param('sss', $username, $password, $role);
    if ($stmt->execute()) {
        $msg = '<div class="alert alert-success">Nurse added successfully!</div>';
    } else {
        $msg = '<div class="alert alert-danger">Error: ' . $stmt->error . '</div>';
    }
}
?>
<div class="card p-4 shadow-sm bg-white mt-4">
    <h2 class="mb-4 text-primary">Add Nurse</h2>
    <?php if (isset($msg)) echo $msg; ?>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Nurse</button>
        <a href="index.php" class="btn btn-secondary ms-2">Back</a>
    </form>
</div>
<?php include '../include/footer.php'; ?> 