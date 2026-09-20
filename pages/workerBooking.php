<?php
include "../components/Navbar.php";
include "../php/authGuard.php";
include "../components/fetchWorkers.php";
include "../php/caller.php";

if (isset($_SESSION['showOtpPopup'])) {
    $showOtpPopup = $_SESSION['showOtpPopup'];
    unset($_SESSION['showOtpPopup']);
}
$userId = $_SESSION['user_id'];

$sql = "SELECT Worker_id
        FROM worker
        WHERE user_id = '$userId'";

$result = mysqli_query($conn, $sql);
$worker = mysqli_fetch_assoc($result);

$workerId = $worker['Worker_id'];
if (isset($_POST['approve_booking'])) {

    $bookingId = $_POST['booking_id'];

    mysqli_query(
        $conn,
        "UPDATE booking
         SET status='approved'
         WHERE Booking_id='$bookingId'"
    );
}

if (isset($_POST['reject_booking'])) {

    $bookingId = $_POST['booking_id'];

    mysqli_query(
        $conn,
        "UPDATE booking
         SET status='rejected'
         WHERE Booking_id='$bookingId'"
    );
}

if (isset($_POST['mark_completed'])) {

    $bookingId = $_POST['booking_id'];
    $completionDescription = $_POST['completion_description'];

    $otp = random_int(100000, 999999);
    $otpExpires = time() + (2 * 60);

    $_SESSION['completion_otp'] = $otp;
    $_SESSION['completion_otp_expires'] = $otpExpires;
    $_SESSION['completion_booking_id'] = $bookingId;
    $_SESSION['completion_description'] = $completionDescription;

    $sql = "SELECT u.email, u.name
            FROM booking b
            JOIN users u ON b.user_id = u.user_id
            WHERE b.Booking_id = '$bookingId'";

    $result = mysqli_query($conn, $sql);
    $customer = mysqli_fetch_assoc($result);

    $emailHandler = new EmailHandler();
    $emailHandler->sendCompletionOTP(
        $customer['email'],
        $customer['name'],
        $otp
    );
    $_SESSION['showOtpPopup'] = $bookingId;

    header("Location: workerBooking.php");
    exit;
}
if (isset($_POST['verify_completion_otp'])) {

    $bookingId = $_POST['booking_id'];
    $enteredOtp = $_POST['completion_otp'];

    $sessionOtp = $_SESSION['completion_otp'] ?? null;
    $otpExpires = $_SESSION['completion_otp_expires'] ?? null;

    if ($sessionOtp === null || $otpExpires === null) {

        $otpError = "OTP not found or session expired.";
        $showOtpPopup = $bookingId;

    } elseif (time() > $otpExpires) {

        unset(
            $_SESSION['completion_otp'],
            $_SESSION['completion_otp_expires']
        );

        $otpError = "OTP expired.";
        $showOtpPopup = $bookingId;

    } elseif ((string) $enteredOtp !== (string) $sessionOtp) {

        $otpError = "Invalid OTP.";
        $showOtpPopup = $bookingId;

    } else {

        $completionDescription = $_SESSION['completion_description'];

        $stmt = mysqli_prepare(
            $conn,
            "UPDATE booking
             SET status='completed',
                 completion_description=?
             WHERE Booking_id=?"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "si",
            $completionDescription,
            $bookingId
        );

        mysqli_stmt_execute($stmt);

        unset(
            $_SESSION['completion_otp'],
            $_SESSION['completion_otp_expires'],
            $_SESSION['completion_booking_id'],
            $_SESSION['completion_description']
        );

        header("Location: workerBooking.php");
        exit;
    }
}

mysqli_query(
    $conn,
    "UPDATE booking
     SET status='rejected'
     WHERE Worker_id='$workerId'
     AND Booking_date < CURDATE()
     AND status='pending'"
);

$bookings = fetchWorkerBookings($conn, $workerId);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/worker.css">
</head>

<body>
    <?php Navbar("workerBookings") ?>
    <div class="dashboard_right">
        <p class="greetings">My Bookings</p>
        <div class="customer_bookings">
            <?php foreach ($bookings as $booking) {
                if ($booking['status'] == 'rejected') {
                    continue;
                }
                ?>
                <div class="workerin_customer">
                    <div class="workerprof">
                        <div class="worker_profile_logo">
                            <?php
                            $name = explode(' ', $booking['customer_name']);
                            $initials = strtoupper($name[0][0] . $name[count($name) - 1][0]);
                            ?>
                            <div class="avatar navy">
                                <?php echo $initials; ?>
                            </div>
                        </div>

                        <div class="bookings_contents">
                            <div class="worker_profile_text">
                                <p class="job">
                                    <?php echo $booking['customer_name']; ?>
                                </p>
                                <p class="worker_profile_name">
                                    <?php echo $booking['Booking_detail']; ?>
                                </p>
                            </div>
                            <div class="booking_date">
                                <div>
                                    <span>Date</span>
                                    <strong><?php echo date('M d', strtotime($booking['Booking_date'])); ?></strong>
                                </div>
                            </div>
                            <div style="text-transform: capitalize;" class="<?php echo $booking['status']; ?>">
                                <?php echo $booking['status']; ?>
                            </div>
                            <div class="worker_buttons">

                                <div class="worker_status_btns">

                                    <button class="button_reponse"
                                        popovertarget="booking_<?php echo $booking['Booking_id']; ?>"
                                        popovertargetaction="show">
                                        View Details
                                    </button>

                                    <?php if ($booking['status'] == 'approved') { ?>

                                        <button class="button_reponse"
                                            popovertarget="complete_<?php echo $booking['Booking_id']; ?>"
                                            popovertargetaction="show">
                                            Mark Completed
                                        </button>

                                    <?php } ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <dialog class="popup-container" popover id="booking_<?php echo $booking['Booking_id']; ?>">

                    <div class="popup">

                        <h2>Booking Details</h2>

                        <p>
                            <strong>Customer:</strong>
                            <?php echo $booking['customer_name']; ?>
                        </p>

                        <p>
                            <strong>Location:</strong>
                            <?php echo $booking['address']; ?>
                        </p>

                        <div class="time">
                            <p>
                                <strong>Date:</strong>
                                <?php echo date('d M Y', strtotime($booking['Booking_date'])); ?>
                            </p>

                            <p>
                                <strong>Time:</strong>
                                <?php echo date('g:i A', strtotime($booking['Booking_date'])); ?>
                            </p>

                        </div>
                        <p>
                            <strong>Description:</strong><br>
                            <?php echo $booking['Booking_detail']; ?>
                        </p>

                        <div class="popup_buttons">

                            <form method="POST">
                                <input type="hidden" name="booking_id" value="<?php echo $booking['Booking_id']; ?>">

                                <button type="submit" name="approve_booking" class="approve_btn">
                                    Approve
                                </button>
                            </form>

                            <form method="POST">
                                <input type="hidden" name="booking_id" value="<?php echo $booking['Booking_id']; ?>">

                                <button type="submit" name="reject_booking" class="reject_btn">
                                    Reject
                                </button>
                            </form>

                        </div>
                    </div>
                </dialog>
                <dialog class="popup-container" popover id="complete_<?php echo $booking['Booking_id']; ?>">
                    <div class="popup">
                        <h2>Complete Booking</h2>
                        <p>
                            <strong>Customer:</strong>
                            <?php echo $booking['customer_name']; ?>
                        </p>
                        <p class="completion-label">
                            <strong>Describe the work completed:</strong>
                        </p>
                        <form method="POST">
                            <input type="hidden" name="booking_id" value="<?php echo $booking['Booking_id']; ?>">
                            <textarea class="completion-textarea" name="completion_description"
                                placeholder="Write a description of the work you completed..." required></textarea>
                            <div class="popup_buttons">
                                <button type="button" popovertarget="complete_<?php echo $booking['Booking_id']; ?>"
                                    popovertargetaction="hide" class="reject_btn">
                                    Cancel
                                </button>
                                <button type="submit" name="mark_completed" class="approve_btn">
                                    Complete Booking
                                </button>
                            </div>
                        </form>
                    </div>
                </dialog>


                <dialog class="popup-container" popover id="otp_<?php echo $booking['Booking_id']; ?>">
                    <div class="otp-box">

                        <div class="brand">
                            <div class="brand-logo">A</div>
                            <div class="brand-name">Artipera</div>
                        </div>
                        <h2>Verify Completion</h2>

                        <p class="description">
                            Enter the verification code sent to the customer's email.
                        </p>

                        <?php
                        if (
                            isset($otpError) &&
                            isset($showOtpPopup) &&
                            $showOtpPopup == $booking['Booking_id']
                        ) {
                            ?>
                            <p class="otp-error">
                                <?php echo $otpError; ?>
                            </p>
                        <?php } ?>

                        <div class="otp-title">ENTER CODE</div>

                        <form method="POST" id="otpForm_<?php echo $booking['Booking_id']; ?>">

                            <input type="hidden" name="booking_id" value="<?php echo $booking['Booking_id']; ?>">

                            <div class="passcode-container">

                                <input type="text" class="passcode-digit" maxlength="1">
                                <input type="text" class="passcode-digit" maxlength="1">
                                <input type="text" class="passcode-digit" maxlength="1">
                                <input type="text" class="passcode-digit" maxlength="1">
                                <input type="text" class="passcode-digit" maxlength="1">
                                <input type="text" class="passcode-digit" maxlength="1">

                            </div>

                            <input type="hidden" name="completion_otp"
                                id="completion_otp_<?php echo $booking['Booking_id']; ?>">

                            <div class="otp-info">
                                <div>
                                    Expires in <span>2 minutes</span>
                                </div>
                            </div>

                            <div class="buttons">

                                <button type="button" popovertarget="otp_<?php echo $booking['Booking_id']; ?>"
                                    popovertargetaction="hide" class="resend-btn">
                                    Cancel
                                </button>

                                <button type="submit" name="verify_completion_otp" class="submit-btn">
                                    Verify Code
                                </button>

                            </div>

                        </form>

                        <div class="security-notice">
                            This verification code can only be used once to confirm
                            the completion of this booking.
                        </div>

                    </div>
                </dialog>
                <?php
            } ?>
        </div>
    </div>
    <?php if (isset($showOtpPopup)) { ?>

        <script>
            document.getElementById(
                "otp_<?php echo $showOtpPopup; ?>"
            ).showPopover();
        </script>

    <?php } ?>
    <script>
        document.querySelectorAll(".passcode-digit").forEach(function (input, index, inputs) {

            input.addEventListener("input", function () {

                this.value = this.value.replace(/[^0-9]/g, "");

                if (this.value && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            });

            input.addEventListener("keydown", function (e) {

                if (e.key === "Backspace" && !this.value && index > 0) {
                    inputs[index - 1].focus();
                }
            });
        });

        document.querySelectorAll("form[id^='otpForm_']").forEach(function (form) {

            form.addEventListener("submit", function () {

                let inputs = form.querySelectorAll(".passcode-digit");
                let otp = "";

                inputs.forEach(function (input) {
                    otp += input.value;
                });

                form.querySelector("input[name='completion_otp']").value = otp;
            });

        });
    </script>
</body>

</html>