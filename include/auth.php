<?php
if (!isset($_SESSION['user'])) {
    header("Location: ../public/login.php");
    exit;
}

function isAdmin() {
    if ($_SESSION['user']['role'] !== 'admin') {
        die('Access denied: Admins only.');
    }
}

function isDoctor() {
    if ($_SESSION['user']['role'] !== 'doctor') {
        die('Access denied: Doctors only.');
    }
}

function isNurse() {
    if ($_SESSION['user']['role'] !== 'nurse') {
        die('Access denied: Nurses only.');
    }
}

function isPatient() {
    if ($_SESSION['user']['role'] !== 'patient') {
        die('Access denied: Patients only.');
    }
}
?>
