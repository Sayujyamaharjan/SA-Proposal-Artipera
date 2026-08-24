<?php
include 'caller.php';
session_start();

function handleOtpVerification($data, $conn)
{
    $submittedOtp = $data['otp_code'] ?? '';
    $sessionOtp = $_SESSION['otp'] ?? null;
    $expiresAt = $_SESSION['otp_expires'] ?? null;
    // Check whether OTP exists
    if ($sessionOtp === null || $expiresAt === null) {
        http_response_code(400);
        echo json_encode([
            "message" => "OTP not found or session expired",
            "error" => true
        ]);
        return;
    }
    // Check expiry
    if (time() > $expiresAt) {
        unset($_SESSION['otp'], $_SESSION['otp_expires']);
        http_response_code(400);
        echo json_encode([
            "message" => "OTP expired",
            "error" => true
        ]);
        return;
    }
    // Check OTP
    if ((string) $submittedOtp !== (string) $sessionOtp) {
        http_response_code(400);
        echo json_encode([
            "message" => "Invalid OTP",
            "error" => true
        ]);
        return;
    }
    // OTP is correct
    $signup = $_SESSION['pending_signup'];
    $status = [];

    $status = process_pending_user($conn, $signup);

    unset($_SESSION['otp'], $_SESSION['otp_expires']);
    respondJson($status['status'], $status['message']);


}
function process_pending_user($conn, $signup)
{
    $pending_signup = $_SESSION['pending_signup'];

    $full_name = $pending_signup['full_name'];
    $email = $pending_signup['email'];
    $phone = $pending_signup['phone'];
    $address = $pending_signup['address'];
    $hashed_password = $pending_signup['password'];
    $role = $pending_signup['role'];
    $profile_image = $pending_signup['profile_image'];

    $sql = "INSERT INTO users
        (name, email, password, phone, address, role, profile_image)
        VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "sssssss",
        $full_name,
        $email,
        $hashed_password,
        $phone,
        $address,
        $role,
        $profile_image
    );

    $res = mysqli_stmt_execute($stmt);

    if ($res) {

        // Remove temporary signup data after successful account creation
        unset($_SESSION['pending_signup']);

        return [
            "error" => false,
            "message" => "Account Created successfully",
            "status" => 200
        ];

    } else {

        return [
            "error" => true,
            "message" => "Failed To Create An Account",
            "status" => 400
        ];
    }
}
?>