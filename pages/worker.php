<?php
include '../php/authGuard.php';
include '../components/Navbar.php';
include '../components/fetchWorkers.php';
$conn = mysqli_connect("localhost", "root", "", "Artipera");

$users = fetchWorkers($conn, 4);
$user_id = $_SESSION['user_id'];

$sql = "
SELECT
    COUNT(b.Booking_id) AS total_bookings,
    SUM(CASE
        WHEN b.status = 'completed'
        THEN 1 ELSE 0
    END) AS completed_bookings,
    SUM(CASE
        WHEN b.status = 'pending'
        THEN 1 ELSE 0
    END) AS pending_bookings,
    COALESCE(SUM(CASE
        WHEN b.status = 'completed'
        THEN b.pricing
        ELSE 0
    END), 0) AS earnings
FROM booking b
JOIN worker w ON b.Worker_id = w.Worker_id
WHERE w.user_id = $user_id
";

$result = mysqli_query($conn, $sql);
$stats = mysqli_fetch_assoc($result);

$user_id = $_SESSION['user_id'];
$sql = "SELECT Worker_id FROM `worker` where user_id = '$user_id'";
$res = mysqli_query($conn, $sql);
$myBookings = [];
if ($res) {
    $worker_id = mysqli_fetch_assoc($res);
    $id = $worker_id['Worker_id'];
    $sql = "SELECT b.*, u.name
FROM booking b
JOIN users u ON b.user_id = u.user_id
WHERE b.Worker_id = $id;";
    $res = mysqli_query($conn, $sql);
    if ($res) {
        while ($row = mysqli_fetch_assoc($res)) {
            array_push($myBookings, $row);
        }
    }
}

$month = date('m');
$year = date('Y');

$daysInMonth = cal_days_in_month(
    CAL_GREGORIAN,
    $month,
    $year
);
$firstDay = date(
    'w',
    strtotime("$year-$month-01")
);

$today = date('j');

$bookedDates = [];

foreach ($myBookings as $booking) {
    $bookedDates[] = date('j', strtotime($booking['Booking_date']));
}



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
    <?php Navbar("workerDashboard") ?>
    <div class="dashboard_right">
        <p class="greetings">Welcome back, <?php echo $_SESSION['name'] ?? "Sayujya" ?></p>
        <div class="right_stats">
            <div class="stats_box">
                <img src="../assets/svg/calendar-week blue.svg" alt="" class="stats_logo">
                <p class="stats_number"><?php echo $stats['total_bookings']; ?></p>
                <p class="stats_text">Total Bookings</p>
                <p class="stats_status">This Month</p>
            </div>
            <div class="stats_box">
                <img src="../assets/svg/checkbox.svg" alt="" class="stats_logo">
                <p class="stats_number"><?php echo $stats['completed_bookings']; ?></p>
                <p class="stats_text">Completed Bookings</p>
                <p class="stats_status">Last Completed Date</p>
            </div>
            <div class="stats_box">
                <img src="../assets/svg/clock-red.svg" alt="" class="stats_logo">
                <p class="stats_number"><?php echo $stats['pending_bookings']; ?></p>
                <p class="stats_text">Pending Bookings</p>
                <p class="stats_status">Next Appointment</p>
            </div>
            <div class="stats_box">
                <img src="../assets/svg/coin-rupee.svg" alt="" class="stats_logo">
                <p class="stats_number">Rs. <?php echo number_format($stats['earnings']); ?></p>
                <p class="stats_text">Earnings</p>
                <p class="stats_status"></p>
            </div>
        </div>

        <div class="right_two_container">
            <div class=" right_container_upcomming">
                <div class="recomended_head">
                    <p class="right_heading">Upcoming Bookings</p>
                    <a href="customerBooking.php" class="right_btn">View all</a>
                </div>
                <div class="right_contents_detail">
                    <div>
                        <?php
                        foreach ($users as $user) {
                        ?>
                            <div class="workerin_customer upcoming">
                                <div class="workerprof">
                                    <div class="worker_profile_logo"></div>
                                    <div class="worker_profile_text">
                                        <p class="worker_profile_name">
                                            <?php echo $user['name'] ?>
                                        </p>
                                        <p class="job"><?php echo $user['category_name'] ?></p>
                                    </div>
                                </div>
                            </div>
                            <br>
                        <?php

                        }
                        ?>

                    </div>
                </div>
            </div>
            <div class=" right_container_upcomming" style="width: 100%;">
                <div class="calendar_card">
                    <h2 class="calendar_title">
                        <?php echo date('F Y', strtotime("$year-$month-01")); ?>
                    </h2>
                    <div class="calendar">
                        <div class="day_name">SUN</div>
                        <div class="day_name">MON</div>
                        <div class="day_name">TUE</div>
                        <div class="day_name">WED</div>
                        <div class="day_name">THU</div>
                        <div class="day_name">FRI</div>
                        <div class="day_name">SAT</div>
                        <?php
                        for ($i = 0; $i < $firstDay; $i++) {
                            echo "<div></div>";
                        }
                        for ($day = 1; $day <= $daysInMonth; $day++) {
                            $class = "day";
                            if ($day == $today) {
                                $class .= " today";
                            }
                            if (in_array($day, $bookedDates)) {
                                $class .= " booked";
                            }
                            echo "
                    <div
                        class='$class'
                        onclick='showDetails($day)'
                    >
                        $day
                    </div>
                ";
                        }
                        ?>
                    </div>
                    <div class="legend">
                        <div class="legend_item">
                            <div class="box today_box"></div>
                            Today
                        </div>
                        <div class="legend_item">
                            <div class="box booking_box"></div>
                            Has Booking
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>