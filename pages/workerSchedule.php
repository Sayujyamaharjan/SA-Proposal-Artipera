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


$services = [];

if (isset($_POST['add_skill'])) {

    $service_name = trim($_POST['service_name']);

    if (!empty($service_name)) {


        $sql = "INSERT INTO worker_service (worker_id, service_name)
                    VALUES ('$id', '$service_name')";

        mysqli_query($conn, $sql);
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

if (isset($_POST['delete_service'])) {

    $service_name = mysqli_real_escape_string($conn, $_POST['delete_service']);
    $sql = "DELETE FROM worker_service
                WHERE worker_id = '$id'
                AND service_name = '$service_name'
                LIMIT 1";

    mysqli_query($conn, $sql);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}


$sql = "SELECT b.*, u.name
            FROM booking b
            JOIN users u ON b.user_id = u.user_id
            WHERE b.Worker_id = $id";

$res = mysqli_query($conn, $sql);

if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $myBookings[] = $row;
    }
}


$sql = "SELECT * FROM worker_service
            WHERE worker_id = '$id'";

$res = mysqli_query($conn, $sql);

if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $services[] = $row;
    }
}


if (isset($_POST['update_rate'])) {

    $base_rate = (float)$_POST['base_rate'];

    $sql = "UPDATE worker
            SET base_rate = '$base_rate'
            WHERE Worker_id = '$id'";

    mysqli_query($conn, $sql);

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

$sql = "SELECT base_rate
        FROM worker
        WHERE Worker_id = '$id'";

$res = mysqli_query($conn, $sql);
$worker = mysqli_fetch_assoc($res);


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
    <title>Worker Schedule</title>
    <link rel="stylesheet" href="../css/worker.css">
</head>

<body>
    <?php Navbar('workerSchedule'); ?>
    <div class="dashboard_right">
        <div class="schedule_container">
            <div class="booking_calendar_card">
                <h2 class="booking_calendar_title">
                    <?php echo date('F Y', strtotime("$year-$month-01")); ?>
                </h2>

                <div class="booking_calendar">
                    <div class="calendar_header">SUN</div>
                    <div class="calendar_header">MON</div>
                    <div class="calendar_header">TUE</div>
                    <div class="calendar_header">WED</div>
                    <div class="calendar_header">THU</div>
                    <div class="calendar_header">FRI</div>
                    <div class="calendar_header">SAT</div>

                    <?php
                    for ($i = 0; $i < $firstDay; $i++) {
                        echo "<div></div>";
                    }
                    for ($day = 1; $day <= $daysInMonth; $day++) {

                        $class = "calendar_date";

                        if ($day == $today) {
                            $class .= " current_date";
                        }

                        if (in_array($day, $bookedDates)) {
                            $class .= " booked_date";
                        }

                        echo " <div class='$class' onclick='showDetails($day)'> $day </div>";
                    }
                    ?>
                </div>
                <div class="calendar_status">
                    <div class="status_item">
                        <div class="status_box today_status"></div>
                        Today
                    </div>

                    <div class="status_item">
                        <div class="status_box booking_status"></div>
                        Has Booking
                    </div>
                </div>
            </div>
            <div class="right_side">
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
                    <!-- <div class="status_buttons">
                        <button class="available">
                            Available
                        </button>
                        <button class="busy">
                            Set Busy
                        </button>
                    </div> -->
                </div>
                <div class="skills_section">
                    <h3>Skills & Specializations</h3>
                    <div class="skills_container">
                        <?php foreach ($services as $service): ?>
                            <form method="POST" class="skill_form">
                                <input type="hidden" name="delete_service" value="<?php echo $service['service_name'] ?>">
                                <button type="submit" class="skill_tag"> <?php echo $service['service_name'] ?>
                                    <span>&times;</span>
                                </button>
                            </form>
                        <?php endforeach; ?>
                    </div>
                    <form method="POST" class="add_skill">
                        <input type="text" name="service_name" placeholder="Add a skill..." required>
                        <button type="submit" name="add_skill"> + Add</button>
                    </form>
                    <div class="hourly_rate_section">
                        <p class="rate_title">Hourly Rate (NPR)</p>
                        <form method="POST" class="rate_form">
                            <input
                                type="number"
                                name="base_rate"
                                value="<?php $worker['base_rate'] ?>"
                                min="0"
                                step="50"
                                class="rate_input">
                            <button
                                type="submit"
                                name="update_rate"
                                class="rate_btn">
                                Save
                            </button>
                        </form>
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
                        "selected_date"
                    ).innerHTML =
                    "Selected Date : " + day;
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