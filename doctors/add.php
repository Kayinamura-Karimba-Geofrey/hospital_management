<?php
include '../include/header.php';
error_reporting(0);
ini_set('display_errors', 0);
session_start();
include('../include/auth.php');
include('../config/db.php');
//isAdmin(); // Only Admin can add doctors
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $specialty = $_POST['specialty'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $stmt = $conn->prepare("INSERT INTO doctors (name, specialty, phone, email) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $specialty, $phone, $email);
    if ($stmt->execute()) {
        echo '<div class="alert alert-success">Doctor added successfully.</div>';
    } else {
        echo '<div class="alert alert-danger">Error: ' . $stmt->error . '</div>';
    }
}
?>
<div class="card p-4 shadow-sm bg-white mt-4">
    <h2 class="mb-4 text-primary">Add New Doctor</h2>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Doctor Name</label>
            <input type="text" name="name" class="form-control" required placeholder="Enter doctor&#39;s full name">
        </div>
        <div class="mb-3">
            <label class="form-label">Specialty</label>
            <input type="text" name="specialty" class="form-control" required placeholder="e.g. Cardiologist, Pediatrician">
        </div>
        <div class="mb-3">
            <label class="form-label">Phone Number</label>
            <input type="text" name="phone" class="form-control" required placeholder="Doctor&#39;s phone number">
        </div>
        <div class="mb-3">
            <label class="form-label">Email Address</label>
            <input type="email" name="email" class="form-control" required placeholder="Doctor&#39;s email">
        </div>
        <button type="submit" class="btn btn-primary">Add Doctor</button>
        <a href="view.php" class="btn btn-secondary ms-2">Back</a>
    </form>
</div>
<?php include '../include/footer.php'; ?>

