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
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
if (!$user) {
    echo '<div class="alert alert-danger">User not found.</div>';
    include '../include/footer.php';
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $role = $_POST['role'];
    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $update = $conn->prepare("UPDATE users SET username=?, password=?, role=? WHERE id=?");
        $update->bind_param('sssi', $username, $password, $role, $id);
    } else {
        $update = $conn->prepare("UPDATE users SET username=?, role=? WHERE id=?");
        $update->bind_param('ssi', $username, $role, $id);
    }
    if ($update->execute()) {
        $msg = '<div class="alert alert-success">User updated successfully!</div>';
    } else {
        $msg = '<div class="alert alert-danger">Error: ' . $update->error . '</div>';
    }
}
?>
<div class="card p-4 shadow-sm bg-white mt-4">
    <h2 class="mb-4 text-primary">Edit User</h2>
    <?php if (isset($msg)) echo $msg; ?>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" value="<?php echo htmlspecialchars($user['username']); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Password (leave blank to keep current)</label>
            <input type="password" name="password" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Role</label>
            <select name="role" class="form-select" required>
                <option value="admin" <?php if($user['role']==='admin') echo 'selected'; ?>>Admin</option>
                <option value="doctor" <?php if($user['role']==='doctor') echo 'selected'; ?>>Doctor</option>
                <option value="nurse" <?php if($user['role']==='nurse') echo 'selected'; ?>>Nurse</option>
                <option value="patient" <?php if($user['role']==='patient') echo 'selected'; ?>>Patient</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update User</button>
        <a href="index.php" class="btn btn-secondary ms-2">Back</a>
    </form>
</div>
<?php include '../include/footer.php'; ?> 