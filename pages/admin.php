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
        <div class="table_container">
            <div class="booking_table">
                <table>
                    <thead>
                        <tr>
                            <th class="book">BOOKING ID</th>
                            <th>SERVICE</th>
                            <th>CUSTOMER</th>
                            <th>WORKER</th>
                            <th>DATE & TIME</th>
                            <th>AMOUNT</th>
                            <th>STATUS</th>
                            <th class="book_left">ACTION</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($bookings as $booking) { ?>
                            <tr>
                                <td class="booking_id">
                                    <?php echo $booking['Booking_id']; ?>
                                </td>
                                <td>
                                    <?php echo $booking['Booking_detail']; ?>
                                </td>
                                <td>
                                    <div class="user_info">
                                        <div class="user_avatar">
                                            <?php
                                            $name = explode(' ', $booking['customer_name']);
                                            $initials = strtoupper($name[0][0] . $name[count($name) - 1][0]);
                                            ?>
                                            <?php echo $initials ?>
                                        </div>
                                        <span><?php echo $booking['customer_name']; ?></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="user_info">
                                        <div class="user_avatar">
                                            <?php
                                            $name = explode(' ', $booking['worker_name']);
                                            $initials = strtoupper($name[0][0] . $name[count($name) - 1][0]);
                                            ?>
                                            <?php echo $initials ?>
                                        </div>
                                        <span><?php echo $booking['worker_name']; ?></span>
                                    </div>
                                </td>
                                <td class="date-books">
                                    <?php echo date('Y-m-d', strtotime($booking['Booking_date'])); ?>
                                    <br>
                                    10:00 AM
                                </td>
                                <td class="amount">
                                    NPR <?php echo number_format($booking['pricing']); ?>
                                </td>
                                <td>
                                    <span class="<?php echo $booking['status']; ?>">
                                        <?php echo $booking['status']; ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="bookingDetail.php?id=<?php echo $booking['Booking_id']; ?>">
                                        <button class="view_btn">View</button>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>