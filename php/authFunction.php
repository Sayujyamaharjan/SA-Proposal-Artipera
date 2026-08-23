<?php
session_start();
function handleOtpVerification($data, $con)
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
    unset($_SESSION['otp'], $_SESSION['otp_expires']);
    http_response_code(200);
    echo json_encode([
        "message" => "OTP verified successfully",
        "error" => false
    ]);
}
?>