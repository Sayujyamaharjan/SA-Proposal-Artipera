<?php include "../components/Navbar.php";
include "../php/authGuard.php";
include "../components/fetchWorkers.php";

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

    mysqli_query(
        $conn,
        "UPDATE booking
         SET status='completed'
         WHERE Booking_id='$bookingId'"
    );
}
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
                                <p class="worker_profile_name">
                                    <?php echo $booking['customer_name']; ?>
                                </p>
                                <p class="job">
                                    <?php echo $booking['Booking_detail']; ?>
                                </p>
                            </div>
                            <div class="worker_buttons">
                                <div style="text-transform: capitalize;" class="<?php echo $booking['status']; ?>">
                                    <?php echo $booking['status']; ?>
                                </div>

                                <div class="worker_status_btns">
                                    <?php if ($booking['status'] == 'pending') { ?>

                                        <button class="button_reponse" popovertarget="booking_<?php echo $booking['Booking_id']; ?>" popovertargetaction="show">
                                            View Details
                                        </button>

                                    <?php } elseif ($booking['status'] == 'approved') { ?>

                                        <form method="POST">
                                            <input type="hidden" name="booking_id" value="<?php echo $booking['Booking_id']; ?>">
                                            <button class="button_reponse" type="submit" name="mark_completed">
                                                Mark Completed
                                            </button>
                                        </form>

                                    <?php } elseif ($booking['status'] == 'completed') { ?>
                                    <?php } ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <dialog
                    class="popup-container"
                    popover
                    id="booking_<?php echo $booking['Booking_id']; ?>">

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
            <?php
            }   ?>
        </div>
    </div>
</body>

</html>