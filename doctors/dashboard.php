<?php
error_reporting(0);
ini_set('display_errors', 0);
session_start();
include('../include/header.php');
include('../include/auth.php');
include('../config/db.php');
$role = $_SESSION['user']['role'] ?? '';
if ($role !== 'admin' && $role !== 'doctor') {
    echo '<div class="alert alert-danger">Access denied.</div>';
    include '../include/footer.php';
    exit;
}
$total_doctors = $conn->query("SELECT COUNT(*) as c FROM doctors")->fetch_assoc()['c'];
$recent_doctors = $conn->query("SELECT * FROM doctors ORDER BY id DESC LIMIT 5");
?>
<div class="container py-4">
    <div class="mb-4 text-center">
        <h1 class="display-6 fw-bold text-primary mb-3">Doctors Dashboard</h1>
    </div>
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 text-center">
                <div class="card-body">
                    <i class="fa fa-user-md fa-2x text-success mb-2"></i>
                    <h5 class="card-title">Total Doctors</h5>
                    <h2 class="fw-bold"><?php echo $total_doctors; ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-success text-white"><i class="fa fa-clock me-2"></i>Recent Doctors</div>
                <div class="card-body p-0">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Specialty</th>
                                <th>Phone</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($recent_doctors && $recent_doctors->num_rows > 0): ?>
                                <?php while($d = $recent_doctors->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($d['name']); ?></td>
                                    <td><?php echo htmlspecialchars($d['specialty']); ?></td>
                                    <td><?php echo htmlspecialchars($d['phone']); ?></td>
                                    <td><?php echo htmlspecialchars($d['email']); ?></td>
                                </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr><td colspan="4" class="text-center">No recent doctors.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-4">
        <div class="col-md-12">
            <a href="view.php" class="btn btn-outline-primary w-100 py-3"><i class="fa fa-list me-2"></i>View Doctors</a>
        </div>
    </div>
</div>
<?php include '../include/footer.php'; ?> 