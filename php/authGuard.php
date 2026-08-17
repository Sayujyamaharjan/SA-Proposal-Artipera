<?php
session_start();

$currentPage = basename($_SERVER['PHP_SELF']);

$publicPages = [
    'landing.php',
    'login.php',
    'signup.php'
];

$workerPages = [
    'worker.php',
    'workerBooking.php',
    'workerSchedule.php',
    'profile.php',
    'logout.php'

];

$customerPages = [
    'customer.php',
    'customerSearch.php',
    'customerBooking.php',
    'customerSaved.php',
    'customerView.php',
    'profile.php',
    'bookingpopup.php',
    'logout.php'
];

$adminPages = [
    'admin.php',
    'adminWorker.php',
    'adminCustomer.php',
    'logout.php'
];

if (isset($_SESSION['isLogged_in']) && $_SESSION['isLogged_in'] == true) {

    if ($_SESSION['role'] === 'worker') {

        if (!in_array($currentPage, $workerPages)) {
            header("Location: https://proposal.test/pages/worker.php");
            exit();
        }
    }

    if ($_SESSION['role'] === 'customer') {

        if (!in_array($currentPage, $customerPages)) {
            header("Location: https://proposal.test/pages/customer.php");
            exit();
        }
    }
    if ($_SESSION['role'] === 'admin') {

        if (!in_array($currentPage, $adminPages)) {
            header("Location: https://proposal.test/pages/admin.php");
            exit();
        }
    }
} else {

    if (!in_array($currentPage, $publicPages)) {
        header("Location: https://proposal.test/pages/login.php");
        exit();
    }
}
