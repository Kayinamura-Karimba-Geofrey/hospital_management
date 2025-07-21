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
$users = $conn->query("SELECT * FROM users");
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="text-primary">Users Management</h2>
    <a href="add.php" class="btn btn-success">Add User</a>
</div>
<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($user = $users->fetch_assoc()): ?>
        <tr>
            <td><?php echo $user['id']; ?></td>
            <td><?php echo htmlspecialchars($user['username']); ?></td>
            <td><?php echo htmlspecialchars($user['role']); ?></td>
            <td>
                <a href="edit.php?id=<?php echo $user['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                <a href="delete.php?id=<?php echo $user['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<a href="../dashboard/dashboard.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
<?php include '../include/footer.php'; ?> 