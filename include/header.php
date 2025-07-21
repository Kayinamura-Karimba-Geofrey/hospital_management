<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { padding-top: 70px; }
        .navbar-brand i { margin-right: 8px; }
    </style>
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top shadow">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="../dashboard/dashboard.php">
      <i class="fa fa-hospital"></i> HospitalMS
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link<?php if(str_contains($_SERVER['REQUEST_URI'], 'dashboard')) echo ' active'; ?>" href="../dashboard/dashboard.php"><i class="fa fa-home me-1"></i>Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link<?php if(str_contains($_SERVER['REQUEST_URI'], 'users')) echo ' active'; ?>" href="../users/index.php"><i class="fa fa-users me-1"></i>Users</a>
        </li>
        <li class="nav-item">
          <a class="nav-link<?php if(str_contains($_SERVER['REQUEST_URI'], 'nurses')) echo ' active'; ?>" href="../nurses/index.php"><i class="fa fa-user-nurse me-1"></i>Nurses</a>
        </li>
        <li class="nav-item">
          <a class="nav-link<?php if(str_contains($_SERVER['REQUEST_URI'], 'patients')) echo ' active'; ?>" href="../patients/dashboard.php"><i class="fa fa-user-injured me-1"></i>Patients</a>
        </li>
        <li class="nav-item">
          <a class="nav-link<?php if(str_contains($_SERVER['REQUEST_URI'], 'doctors')) echo ' active'; ?>" href="../doctors/dashboard.php"><i class="fa fa-user-md me-1"></i>Doctors</a>
        </li>
        <li class="nav-item">
          <a class="nav-link<?php if(str_contains($_SERVER['REQUEST_URI'], 'appointments')) echo ' active'; ?>" href="../appointments/dashboard.php"><i class="fa fa-calendar-check me-1"></i>Appointments</a>
        </li>
      </ul>
      <ul class="navbar-nav mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="../public/register.php"><i class="fa fa-user-plus me-1"></i>Register</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../public/login.php"><i class="fa fa-sign-in-alt me-1"></i>Login</a>
        </li>
        <li class="nav-item">
          <span class="navbar-text text-white me-3">
            <i class="fa fa-user-circle"></i> <?php echo htmlspecialchars($_SESSION['user']['username'] ?? ''); ?>
          </span>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../public/logout.php"><i class="fa fa-sign-out-alt"></i> Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<div class="container-fluid">
