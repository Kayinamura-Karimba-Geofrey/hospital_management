<?php
include '../include/header.php';
error_reporting(0);
ini_set('display_errors', 0);
session_start();
include('../include/auth.php');
include('../config/db.php');
//isAdmin(); // Only admin can view patients

$result = $conn->query("SELECT * FROM patients");
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="text-primary mb-0">Patient List</h2>
    <a href="add.php" class="btn btn-success">Add Patient</a>
</div>
<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Age</th>
            <th>Gender</th>
            <th>Address</th>
            <th>Phone</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['age']; ?></td>
                <td><?php echo $row['gender']; ?></td>
                <td><?php echo $row['address']; ?></td>
                <td><?php echo $row['phone']; ?></td>
                <td>
                    <a href='edit.php?id=<?php echo $row['id']; ?>' class="btn btn-sm btn-warning">Edit</a> 
                    <a href='delete.php?id=<?php echo $row['id']; ?>' class="btn btn-sm btn-danger">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="7" class="text-center">No patients found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
<a href="../dashboard/dashboard.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
<?php include '../include/footer.php'; ?>