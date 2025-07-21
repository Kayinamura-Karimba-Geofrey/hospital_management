<?php
error_reporting(0);
ini_set('display_errors', 0);
session_start();
include('../include/header.php');
include('../include/auth.php');
include('../config/db.php');
$role = $_SESSION['user']['role'] ?? '';
if ($role !== 'admin') {
    echo '<div class="alert alert-danger">Access denied: Only admins can manage appointments.</div>';
    include '../include/footer.php';
    exit;
}
$total_appointments = $conn->query("SELECT COUNT(*) as c FROM appointments")->fetch_assoc()['c'];
$recent_appointments = $conn->query("SELECT a.*, p.name as patient, d.name as doctor FROM appointments a JOIN patients p ON a.patient_id = p.id JOIN doctors d ON a.doctor_id = d.id ORDER BY a.appointment_date DESC LIMIT 5");
?>
<div class="container py-4">
    <div class="mb-4 text-center">
        <h1 class="display-6 fw-bold text-primary mb-3">Appointments Dashboard</h1>
    </div>
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 text-center">
                <div class="card-body">
                    <i class="fa fa-calendar-check fa-2x text-danger mb-2"></i>
                    <h5 class="card-title">Total Appointments</h5>
                    <h2 class="fw-bold"><?php echo $total_appointments; ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-danger text-white"><i class="fa fa-clock me-2"></i>Recent Appointments</div>
                <div class="card-body p-0">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Patient</th>
                                <th>Doctor</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($recent_appointments && $recent_appointments->num_rows > 0): ?>
                                <?php while($a = $recent_appointments->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($a['appointment_date']); ?></td>
                                    <td><?php echo htmlspecialchars($a['patient']); ?></td>
                                    <td><?php echo htmlspecialchars($a['doctor']); ?></td>
                                    <td><?php echo htmlspecialchars($a['description']); ?></td>
                                </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr><td colspan="4" class="text-center">No recent appointments.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-4">
        <div class="col-md-12">
            <a href="view.php" class="btn btn-outline-primary w-100 py-3"><i class="fa fa-list me-2"></i>View Appointments</a>
        </div>
    </div>
</div>
<?php include '../include/footer.php'; ?> 