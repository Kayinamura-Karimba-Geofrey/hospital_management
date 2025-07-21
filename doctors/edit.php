<?php
include '../include/header.php';
error_reporting(0);
ini_set('display_errors', 0);
session_start();
include('../include/auth.php');
include('../config/db.php');
isAdmin(); // Only admin can edit doctors
$id = $_GET['id'] ?? 0;
$stmt = $conn->prepare("SELECT * FROM doctors WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$doctor = $result->fetch_assoc();
if (!$doctor) {
    echo '<div class="alert alert-danger">Doctor not found!</div>';
    include '../include/footer.php';
    exit;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $specialty = $_POST['specialty'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $updateStmt = $conn->prepare("UPDATE doctors SET name=?, specialty=?, phone=?, email=? WHERE id=?");
    $updateStmt->bind_param("ssssi", $name, $specialty, $phone, $email, $id);
    if ($updateStmt->execute()) {
        echo '<div class="alert alert-success">Doctor updated successfully.</div>';
    } else {
        echo '<div class="alert alert-danger">Error: ' . $updateStmt->error . '</div>';
    }
}
?>
<div class="card p-4 shadow-sm bg-white mt-4">
    <h2 class="mb-4 text-primary">Edit Doctor</h2>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="<?php echo $doctor['name']; ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Specialty</label>
            <input type="text" name="specialty" class="form-control" value="<?php echo $doctor['specialty']; ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control" value="<?php echo $doctor['phone']; ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="<?php echo $doctor['email']; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Doctor</button>
        <a href="view.php" class="btn btn-secondary ms-2">Back</a>
    </form>
</div>
<?php include '../include/footer.php'; ?>
