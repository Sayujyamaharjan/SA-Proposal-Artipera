<?php
include 'emailHandler.php';

function getUser($field, $value, $conn)
{
    $allowed = ['email', 'phone'];
    if (!in_array($field, $allowed)) {
        return [];
    }

    $stmt = $conn->prepare(
        "SELECT * FROM users WHERE $field=?"
    );

    $stmt->bind_param("s", $value);
    $stmt->execute();
    $res = $stmt->get_result();
    return $res->fetch_all(MYSQLI_ASSOC);
}
function generateOtp()
{
    return random_int(100000, 999999);
}
function generateRefCode($length = 8)
{
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
function otpMailer($email, $name)
{
    try {
        $emailHandler = new EmailHandler();
        date_default_timezone_set('Asia/Kathmandu');
        $otp = generateOtp();
        $refCode = generateRefCode();
        $otp_expires = time() + (2 * 60);
        $_SESSION['otp'] = $otp;
        $_SESSION['otp_expires'] = $otp_expires;

        $emailHandler->sendOTP(
            $email,
            $name,
            $otp,
            $otp_expires,
            $refCode
        );

        return [
            "success" => true,
            "message" => "OTP Sent Successfully",
            "expiresOn" => $otp_expires,
            "requestId" => $refCode,
            "email" => $email,
            "status" => 200,
        ];

    } catch (Exception $e) {
        return [
            "success" => false,
            "message" => "Failed to send OTP: " . $e->getMessage(),
            "status" => 500,
        ];
    }
}
function respondJson($statusCode, $message, $extra = [])
{
    http_response_code($statusCode);
    echo json_encode(array_merge([
        "status" => $statusCode,
        "message" => $message
    ], $extra));
    exit;
}

