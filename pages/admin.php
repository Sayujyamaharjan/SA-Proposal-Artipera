<?php
include '../components/Navbar.php';
include '../php/authGuard.php';
include '../components/fetchWorkers.php';

$bookings = fetchBookings($conn);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>

<body>
    <?php Navbar("admin") ?>
    <div class="dashboard_right">
        <div class="booking_table">
            <div class="booking_header">
                <div>BOOKING ID</div>
                <div>SERVICE</div>
                <div>CUSTOMER</div>
                <div>WORKER</div>
                <div>DATE & TIME</div>
                <div>AMOUNT</div>
                <div>STATUS</div>
                <div>ACTION</div>
            </div>

            <?php foreach ($bookings as $booking) { ?>
                <div class="booking_row">
                    <div class="booking_id">
                        BK<?php echo $booking['Booking_id'] ?>
                    </div>
                    <div>
                        <?php echo $booking['Booking_detail']; ?>
                    </div>
                    <div class="user_info">
                        <div class="user_avatar"> <!-- <?php echo $booking['customer_name']; ?> --></div>
                        <span><?php echo $booking['customer_name']; ?></span>
                    </div>
                    <div class="user_info">
                        <div class="user_avatar">
                            <!-- <?php echo $booking['worker_name'] ?> -->
                        </div>
                        <span><?php echo $booking['worker_name']; ?></span>
                    </div>
                    <div class="date-books">
                        <?php echo date('Y-m-d', strtotime($booking['Booking_date'])); ?>
                        <br>
                        10:00 AM
                    </div>
                    <div class="amount">
                        NPR <?php echo number_format($booking['pricing']); ?>
                    </div>
                    <div>
                        <span class="status">
                            <?php echo ucfirst($booking['status']); ?>
                        </span>
                    </div>
                    <div>
                        <a href="bookingDetail.php?id=<?php echo $booking['Booking_id']; ?>">
                            <button class="view_btn">View</button>
                        </a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</body>

</html>