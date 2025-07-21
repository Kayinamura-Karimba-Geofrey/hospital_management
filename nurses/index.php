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
$nurses = $conn->query("SELECT * FROM users WHERE role='nurse'");
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="text-primary">Nurses Management</h2>
    <a href="add.php" class="btn btn-success">Add Nurse</a>
</div>
<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($nurse = $nurses->fetch_assoc()): ?>
        <tr>
            <td><?php echo $nurse['id']; ?></td>
            <td><?php echo htmlspecialchars($nurse['username']); ?></td>
            <td>
                <a href="edit.php?id=<?php echo $nurse['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                <a href="delete.php?id=<?php echo $nurse['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this nurse?');">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<a href="../dashboard/dashboard.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
<?php include '../include/footer.php'; ?> 