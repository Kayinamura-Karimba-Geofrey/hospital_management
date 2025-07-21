<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <?php
        error_reporting(0);
        ini_set('display_errors', 0);
        session_start();
        include('../config/db.php');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user'] = $user;
                if ($user['role'] === 'admin') {
                    header('Location: ../dashboard/dashboard.php');
                } elseif ($user['role'] === 'doctor') {
                    header('Location: ../doctors/dashboard.php');
                } elseif ($user['role'] === 'nurse') {
                    header('Location: ../users/dashboard.php');
                } elseif ($user['role'] === 'patient') {
                    header('Location: ../patients/dashboard.php');
                } else {
                    header('Location: ../dashboard/dashboard.php');
                }
                exit();
            } else {
                echo '<div class="alert alert-danger">Invalid login credentials!</div>';
            }
        }
        ?>
        <div class="card p-4 shadow-sm bg-white">
            <h2 class="mb-4 text-primary">Login</h2>
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
