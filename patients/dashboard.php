<?php
error_reporting(0);
ini_set('display_errors', 0);
session_start();
include('../include/header.php');
include('../include/auth.php');
include('../config/db.php');
$role = $_SESSION['user']['role'] ?? '';
if ($role !== 'admin' && $role !== 'patient') {
    echo '<div class="alert alert-danger">Access denied.</div>';
    include '../include/footer.php';
    exit;
}
$total_patients = $conn->query("SELECT COUNT(*) as c FROM patients")->fetch_assoc()['c'];
$recent_patients = $conn->query("SELECT * FROM patients ORDER BY id DESC LIMIT 5");
?>
<div class="container py-4">
    <div class="mb-4 text-center">
        <h1 class="display-6 fw-bold text-primary mb-3">Patients Dashboard</h1>
    </div>
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 text-center">
                <div class="card-body">
                    <i class="fa fa-user-injured fa-2x text-primary mb-2"></i>
                    <h5 class="card-title">Total Patients</h5>
                    <h2 class="fw-bold"><?php echo $total_patients; ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-primary text-white"><i class="fa fa-clock me-2"></i>Recent Patients</div>
                <div class="card-body p-0">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Age</th>
                                <th>Gender</th>
                                <th>Phone</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($recent_patients && $recent_patients->num_rows > 0): ?>
                                <?php while($p = $recent_patients->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($p['name']); ?></td>
                                    <td><?php echo htmlspecialchars($p['age']); ?></td>
                                    <td><?php echo htmlspecialchars($p['gender']); ?></td>
                                    <td><?php echo htmlspecialchars($p['phone']); ?></td>
                                </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr><td colspan="4" class="text-center">No recent patients.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-4">
        <div class="col-md-12">
            <a href="view.php" class="btn btn-outline-primary w-100 py-3"><i class="fa fa-list me-2"></i>View Patients</a>
        </div>
    </div>
</div>
<?php include '../include/footer.php'; ?> 