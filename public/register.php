<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <?php
    include '../include/header.php';
    error_reporting(0);
    ini_set('display_errors', 0);
    session_start();
    include('../config/db.php');
    include('../include/auth.php');
    isAdmin();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $role = $_POST['role'];
        $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
        $stmt->bind_param('sss', $username, $password, $role);
        if ($stmt->execute()) {
            if ($role === 'doctor') {
                header('Location: ../doctors/view.php');
                exit;
            } elseif ($role === 'patient') {
                header('Location: ../patients/view.php');
                exit;
            } elseif ($role === 'nurse') {
                header('Location: ../appointments/view.php');
                exit;
            } else {
                $msg = '<div class="alert alert-success">Admin registered!</div>';
            }
        } else {
            $msg = '<div class="alert alert-danger">Error: ' . $stmt->error . '</div>';
        }
    }
    ?>
    <div class="container mt-5">
        <div class="card p-4 shadow-sm bg-white mt-4">
            <h2 class="mb-4 text-primary">Register User</h2>
            <?php if (isset($msg)) echo $msg; ?>
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Role</label>
                    <select name="role" class="form-select" required>
                        <option value="admin">Admin</option>
                        <option value="doctor">Doctor</option>
                        <option value="nurse">Nurse</option>
                        <option value="patient">Patient</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Register</button>
            </form>
        </div>
    </div>
    <?php include '../include/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
