<?php
include '../include/header.php';
error_reporting(0);
ini_set('display_errors', 0);
session_start();
include('../include/auth.php');
include('../config/db.php');
isAdmin(); // Only admin can edit appointments

$id = $_GET['id'] ?? 0;
// Fetch existing appointment data
$stmt = $conn->prepare("SELECT * FROM appointments WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$appointment = $result->fetch_assoc();
// Fetch Patients and Doctors for selection
$patients = $conn->query("SELECT id, name FROM patients");
$doctors = $conn->query("SELECT id, name FROM doctors");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $patient_id = $_POST['patient_id'];
    $doctor_id = $_POST['doctor_id'];
    $appointment_date = $_POST['appointment_date'];
    $description = $_POST['description'];
    $updateStmt = $conn->prepare("UPDATE appointments SET patient_id=?, doctor_id=?, appointment_date=?, description=? WHERE id=?");
    $updateStmt->bind_param("iissi", $patient_id, $doctor_id, $appointment_date, $description, $id);
    if ($updateStmt->execute()) {
        echo '<div class="alert alert-success">Appointment updated successfully.</div>';
    } else {
        echo '<div class="alert alert-danger">Error: ' . $updateStmt->error . '</div>';
    }
}
?>
<div class="card p-4 shadow-sm bg-white mt-4">
    <h2 class="mb-4 text-primary">Edit Appointment</h2>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Patient</label>
            <select name="patient_id" class="form-select" required>
                <?php while($p = $patients->fetch_assoc()): ?>
                    <option value="<?php echo $p['id']; ?>" <?php if($p['id']==$appointment['patient_id']) echo 'selected'; ?>><?php echo $p['name']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Doctor</label>
            <select name="doctor_id" class="form-select" required>
                <?php while($d = $doctors->fetch_assoc()): ?>
                    <option value="<?php echo $d['id']; ?>" <?php if($d['id']==$appointment['doctor_id']) echo 'selected'; ?>><?php echo $d['name']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Date</label>
            <input type="date" name="appointment_date" value="<?php echo $appointment['appointment_date']; ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <input type="text" name="description" value="<?php echo $appointment['description']; ?>" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Update Appointment</button>
        <a href="view.php" class="btn btn-secondary ms-2">Back</a>
    </form>
</div>
<?php include '../include/footer.php'; ?>
