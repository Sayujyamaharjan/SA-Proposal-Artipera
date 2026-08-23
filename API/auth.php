<?php
header("Content-Type: application/json");
include '../php/connect.php';
include "../php/authFunction.php";

$action = $_POST['action'] ?? '';
if ($_SERVER['REQUEST_METHOD'] === "POST") {

    switch ($action) {
        case "otp_verification":
            handleOtpVerification($_POST, $conn);
            break;

        default:
            echo json_encode([
                "status" => 400,
                "message" => "Invalid action."
            ]);
            break;
    }
}