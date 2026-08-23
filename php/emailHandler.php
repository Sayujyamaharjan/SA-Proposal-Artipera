<?php
// use PHPMailer\PHPMailer\SMTP;


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/emailTemplate.php';

$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();
class EmailHandler
{
    private PHPMailer $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);

        $this->mail->isSMTP();
        $this->mail->Host = $_ENV['MAIL_HOST'];
        $this->mail->SMTPAuth = true;
        $this->mail->Username = $_ENV['MAIL_USERNAME'];
        $this->mail->Password = $_ENV['MAIL_PASSWORD'];
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $this->mail->Port = (int) $_ENV['MAIL_PORT'];

        $this->mail->setFrom(
            $_ENV['MAIL_FROM_EMAIL'],
            $_ENV['MAIL_FROM_NAME']
        );
    }

    public function send(
        string $to,
        string $name,
        string $subject,
        string $body,
        string $altBody = ''
    ): bool {
        try {
            $this->mail->clearAddresses();
            $this->mail->addAddress($to, $name);
            $this->mail->Subject = $subject;
            $this->mail->Body = $body;
            $this->mail->AltBody = $altBody ?: strip_tags($body);

            return $this->mail->send();

        } catch (Exception $e) {
            error_log("Mailer Error: " . $this->mail->ErrorInfo);
            return false;
        }
    }

    public function sendOTP(
        string $to,
        string $name,
        string $passcode,
        string $expiresOn,
        string $requestId
    ): bool {
        $message = emailTemplate([
            'passcode' => $passcode,
            'expiresOn' => $expiresOn,
            'requestId' => $requestId
        ]);

        return $this->send(
            $to,
            $name,
            'Your OTP Verification Code',
            $message,
            "Your OTP is: {$passcode}. It expires at {$expiresOn}."
        );
    }
}
