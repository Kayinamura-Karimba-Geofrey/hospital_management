<?php
include '../include/header.php';
error_reporting(0);
ini_set('display_errors', 0);
session_start();
include('../include/auth.php');
include('../config/db.php');
//isAdmin(); // Only admin can view doctors

$result = $conn->query("SELECT * FROM doctors");
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="text-primary mb-0">Doctor List</h2>
    <a href="add.php" class="btn btn-success">Add Doctor</a>
</div>
<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Specialty</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['specialty']; ?></td>
                <td><?php echo $row['phone']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td>
                    <a href='edit.php?id=<?php echo $row['id']; ?>' class="btn btn-sm btn-warning">Edit</a> 
                    <a href='delete.php?id=<?php echo $row['id']; ?>' class="btn btn-sm btn-danger">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="6" class="text-center">No doctors found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
<a href="../dashboard/dashboard.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
<?php include '../include/footer.php'; ?>