<?php
include '../components/Navbar.php';
include "../php/connect.php";
include "../php/authGuard.php";

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

/* Booking dates from DB later */
$bookedDates = [];

foreach ($myBookings as $booking) {
    $bookedDates[] = date('j', strtotime($booking['Booking_date']));
}

// print_r($bookedDates);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Worker Schedule</title>
    <link rel="stylesheet" href="../css/worker.css">
</head>

<body>
    <?php Navbar('workerSchedule'); ?>
    <div class="dashboard_right">
        <div class="schedule_container">
            <div class="calendar_card">
                <h2 class="calendar_title">
                    <?= date('F Y', strtotime("$year-$month-01")); ?>
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
            <div class="right_side">
                <div class="hours_card">
                    <h2>Working Hours</h2>
                    <p class="hours_subtitle">
                        Set your default working hours
                    </p>
                    <?php
                    $days = [
                        "Monday",
                        "Tuesday",
                        "Wednesday",
                        "Thursday",
                        "Friday"
                    ];
                    foreach ($days as $d) {
                    ?>
                        <div class="time_row">
                            <label><?= $d ?></label>
                            <input type="time" value="08:00">
                            <span>-</span>
                            <input type="time" value="18:00">
                            <input type="checkbox" checked>
                        </div>
                    <?php } ?>
                    <button class="save_btn">
                        Save Hours
                    </button>
                </div>
                <div class="availability_card">
                    <h2>Availability Status</h2>
                    <div
                        class="selected_date"
                        id="selected_date">
                        Select a date
                    </div>
                    <div
                        class="booking_details"
                        id="booking_details">
                        Click any date from the calendar.
                    </div>
                    <div class="status_buttons">
                        <button class="available">
                            Available
                        </button>
                        <button class="busy">
                            Set Busy
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const bookings = <?php echo json_encode($myBookings) ?>;
        console.log(bookings)




        function showDetails(day) {
            if (day < 10) {
                day = `0${day}`;
            }


            let taskArr = bookings.find((e) => {
                return parseInt(e.Booking_date.split("-").at(-1)) == parseInt(day)
            });
            if (taskArr) {

                document.getElementById(
                        "selected_date"
                    ).innerHTML =
                    "Selected Date : " + day;

                document.getElementById(
                    "booking_details"
                ).innerHTML = `
                <strong>Bookings</strong><br><br>
                
${taskArr['Booking_detail']}<br>
                Customer : ${taskArr['name']}<br>
                Status : ${taskArr['status']}
                `;
            } else {
                document.getElementById(
                    "booking_details"
                ).innerHTML = `
                <strong>No Bookings</strong><br><br>
                `;
            }
        }
    </script>
</body>

</html>