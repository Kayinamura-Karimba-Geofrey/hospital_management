<?php
error_reporting(0);
ini_set('display_errors', 0);
session_start();
include('../includes/auth.php');
include('../config/db.php');

isPatient(); // Only patients can book their own appointments

$patient_id = $_SESSION['user']['id'];
$doctors = $conn->query("SELECT id, name FROM doctors");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $doctor_id = $_POST['doctor_id'];
    $appointment_date = $_POST['appointment_date'];
    $description = $_POST['description'];

    $stmt = $conn->prepare("INSERT INTO appointments (patient_id, doctor_id, appointment_date, description) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $patient_id, $doctor_id, $appointment_date, $description);

    if ($stmt->execute()) {
        $msg = '<div class="alert alert-success">Appointment booked successfully.</div>';
    } else {
        $msg = '<div class="alert alert-danger">Error: ' . $stmt->error . '</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card p-4 shadow-sm bg-white">
            <h2 class="mb-4 text-primary">Book Appointment</h2>
            <?php if (isset($msg)) echo $msg; ?>
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Doctor</label>
                    <select name="doctor_id" class="form-select" required>
                        <option value="">Select Doctor</option>
                        <?php while($d = $doctors->fetch_assoc()): ?>
                            <option value="<?php echo $d['id']; ?>"><?php echo $d['name']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Date</label>
                    <input type="date" name="appointment_date" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <input type="text" name="description" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Book Appointment</button>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 