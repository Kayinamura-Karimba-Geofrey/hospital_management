<?php
error_reporting(0);
ini_set('display_errors', 0);
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    echo '<div class="alert alert-danger">Access denied: Admins only.</div>';
    exit;
}
include('../config/db.php');
// Get counts
$total_users = $conn->query("SELECT COUNT(*) as c FROM users")->fetch_assoc()['c'];
$total_doctors = $conn->query("SELECT COUNT(*) as c FROM users WHERE role='doctor'")->fetch_assoc()['c'];
$total_nurses = $conn->query("SELECT COUNT(*) as c FROM users WHERE role='nurse'")->fetch_assoc()['c'];
$total_patients = $conn->query("SELECT COUNT(*) as c FROM users WHERE role='patient'")->fetch_assoc()['c'];



// Recent Appointments
$recent_appointments = $conn->query("SELECT a.id, a.appointment_date, a.description, p.name as patient, d.name as doctor FROM appointments a JOIN patients p ON a.patient_id = p.id JOIN doctors d ON a.doctor_id = d.id ORDER BY a.appointment_date DESC LIMIT 5");

// Appointments per month for current year
$year = date('Y');
$monthly = [];
for ($m = 1; $m <= 12; $m++) $monthly[$m] = 0;
$res = $conn->query("SELECT MONTH(appointment_date) as m, COUNT(*) as c FROM appointments WHERE YEAR(appointment_date) = '$year' GROUP BY m");
while ($row = $res->fetch_assoc()) $monthly[(int)$row['m']] = (int)$row['c'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="mb-5 text-center">
            <h1 class="display-5 fw-bold text-primary mb-3">Welcome, <?php echo htmlspecialchars($_SESSION['user']['username']); ?>!</h1>
            <p class="lead">Admin Dashboard</p>
        </div>
        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="card shadow-sm border-0 text-center">
                    <div class="card-body">
                        <i class="fa fa-users fa-2x text-primary mb-2"></i>
                        <h5 class="card-title">Users</h5>
                        <h2 class="fw-bold"><?php echo $total_users; ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0 text-center">
                    <div class="card-body">
                        <i class="fa fa-user-nurse fa-2x text-info mb-2"></i>
                        <h5 class="card-title">Nurses</h5>
                        <h2 class="fw-bold"><?php echo $total_nurses; ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0 text-center">
                    <div class="card-body">
                        <i class="fa fa-user-md fa-2x text-success mb-2"></i>
                        <h5 class="card-title">Doctors</h5>
                        <h2 class="fw-bold"><?php echo $total_doctors; ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0 text-center">
                    <div class="card-body">
                        <i class="fa fa-user-injured fa-2x text-danger mb-2"></i>
                        <h5 class="card-title">Patients</h5>
                        <h2 class="fw-bold"><?php echo $total_patients; ?></h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-4 mb-5">
            <div class="col-md-6">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-primary text-white"><i class="fa fa-clock me-2"></i>Recent Appointments</div>
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
            <div class="col-md-6">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-info text-white"><i class="fa fa-chart-line me-2"></i>Appointments per Month (<?php echo $year; ?>)</div>
                    <div class="card-body">
                        <canvas id="appointmentsChart" height="180"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-md-3">
                <a href="../users/index.php" class="btn btn-outline-primary w-100 py-3"><i class="fa fa-users me-2"></i>Manage Users</a>
            </div>
            <div class="col-md-3">
                <a href="../nurses/index.php" class="btn btn-outline-info w-100 py-3"><i class="fa fa-user-nurse me-2"></i>Manage Nurses</a>
            </div>
            <div class="col-md-3">
                <a href="../patients/view.php" class="btn btn-outline-success w-100 py-3"><i class="fa fa-user-injured me-2"></i>Manage Patients</a>
            </div>
            <div class="col-md-3">
                <a href="../doctors/view.php" class="btn btn-outline-info w-100 py-3"><i class="fa fa-user-md me-2"></i>Manage Doctors</a>
            </div>
            <div class="col-md-3">
                <a href="../appointments/view.php" class="btn btn-outline-danger w-100 py-3"><i class="fa fa-calendar-check me-2"></i>Manage Appointments</a>
            </div>
        </div>
        <div class="mt-5 text-center">
            <a href="../public/logout.php" class="btn btn-secondary"><i class="fa fa-sign-out-alt me-2"></i>Logout</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    const ctx = document.getElementById('appointmentsChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            datasets: [{
                label: 'Appointments',
                data: <?php echo json_encode(array_values($monthly)); ?>,
                backgroundColor: 'rgba(13, 110, 253, 0.7)',
                borderColor: 'rgba(13, 110, 253, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: { beginAtZero: true, stepSize: 1 }
            }
        }
    });
    </script>
</body>
</html> 