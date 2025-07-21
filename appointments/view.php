<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments List</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <?php
        error_reporting(0);
        ini_set('display_errors', 0);
        session_start();
        include('../include/auth.php');
        include('../config/db.php');
        isAdmin(); // Only admin can view appointments

        $query = "SELECT a.id, p.name as patient, d.name as doctor, a.appointment_date, a.description 
                  FROM appointments a
                  JOIN patients p ON a.patient_id = p.id
                  JOIN doctors d ON a.doctor_id = d.id";
        $result = $conn->query($query);
        ?>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-primary mb-0">Appointments List</h2>
            <a href="add.php" class="btn btn-success">Add Appointment</a>
        </div>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Patient</th>
                    <th>Doctor</th>
                    <th>Date</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['patient']; ?></td>
                        <td><?php echo $row['doctor']; ?></td>
                        <td><?php echo $row['appointment_date']; ?></td>
                        <td><?php echo $row['description']; ?></td>
                        <td>
                            <a href='edit.php?id=<?php echo $row['id']; ?>' class="btn btn-sm btn-warning">Edit</a> 
                            <a href='cancel.php?id=<?php echo $row['id']; ?>' class="btn btn-sm btn-danger">Cancel</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">No appointments found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <a href="../dashboard/dashboard.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
        <?php include '../include/footer.php'; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
