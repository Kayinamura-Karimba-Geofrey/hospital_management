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
$id = $_GET['id'] ?? 0;
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ? AND role = 'nurse'");
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$nurse = $result->fetch_assoc();
if (!$nurse) {
    echo '<div class="alert alert-danger">Nurse not found.</div>';
    include '../include/footer.php';
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $update = $conn->prepare("UPDATE users SET username=?, password=? WHERE id=? AND role='nurse'");
        $update->bind_param('ssi', $username, $password, $id);
    } else {
        $update = $conn->prepare("UPDATE users SET username=? WHERE id=? AND role='nurse'");
        $update->bind_param('si', $username, $id);
    }
    if ($update->execute()) {
        $msg = '<div class="alert alert-success">Nurse updated successfully!</div>';
    } else {
        $msg = '<div class="alert alert-danger">Error: ' . $update->error . '</div>';
    }
}
?>
<div class="card p-4 shadow-sm bg-white mt-4">
    <h2 class="mb-4 text-primary">Edit Nurse</h2>
    <?php if (isset($msg)) echo $msg; ?>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" value="<?php echo htmlspecialchars($nurse['username']); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Password (leave blank to keep current)</label>
            <input type="password" name="password" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Update Nurse</button>
        <a href="index.php" class="btn btn-secondary ms-2">Back</a>
    </form>
</div>
<?php include '../include/footer.php'; ?> 