<?php
include '../include/header.php';
error_reporting(0);
ini_set('display_errors', 0);
session_start();
include('../include/auth.php');
include('../config/db.php');
isAdmin(); // Only admin can edit patients
$id = $_GET['id'] ?? 0;
$stmt = $conn->prepare("SELECT * FROM patients WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$patient = $result->fetch_assoc();
if (!$patient) {
    echo '<div class="alert alert-danger">Patient not found!</div>';
    include '../include/footer.php';
    exit;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $updateStmt = $conn->prepare("UPDATE patients SET name=?, age=?, gender=?, address=?, phone=? WHERE id=?");
    $updateStmt->bind_param("sisssi", $name, $age, $gender, $address, $phone, $id);
    if ($updateStmt->execute()) {
        echo '<div class="alert alert-success">Patient updated successfully.</div>';
    } else {
        echo '<div class="alert alert-danger">Error: ' . $updateStmt->error . '</div>';
    }
}
?>
<div class="card p-4 shadow-sm bg-white mt-4">
    <h2 class="mb-4 text-primary">Edit Patient</h2>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="<?php echo $patient['name']; ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Age</label>
            <input type="number" name="age" class="form-control" value="<?php echo $patient['age']; ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Gender</label>
            <select name="gender" class="form-select" required>
                <option value="male" <?php if ($patient['gender'] == 'male') echo 'selected'; ?>>Male</option>
                <option value="female" <?php if ($patient['gender'] == 'female') echo 'selected'; ?>>Female</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Address</label>
            <input type="text" name="address" class="form-control" value="<?php echo $patient['address']; ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control" value="<?php echo $patient['phone']; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Patient</button>
        <a href="view.php" class="btn btn-secondary ms-2">Back</a>
    </form>
</div>
<?php include '../include/footer.php'; ?>
