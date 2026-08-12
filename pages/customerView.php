<?php
include '../components/Navbar.php';
include "../php/connect.php";
include "../php/authGuard.php";
include "../components/fetchWorkers.php";
$workerDetails = fetchWorkers($conn);

$userIdUrl =  $_GET['user_id'] ?? NULL;

$worker = null;
if ($workerDetails) {
    foreach ($workerDetails as $item) {
        if ((int)$item['user_id'] === (int)$userIdUrl) {
            $worker = $item;
            break;
        }
    }
}
$today = date('Y-m-d');

if (isset($_POST['save_worker'])) {
    $user_id = $_SESSION['user_id'];
    $worker_id = $_POST['worker_id'];

    $check = mysqli_query(
        $conn,
        "SELECT * FROM saved_workers
         WHERE user_id = '$user_id'
         AND worker_id = '$worker_id'"
    );

    if (mysqli_num_rows($check) == 0) {
        mysqli_query(
            $conn,
            "INSERT INTO saved_workers(user_id, worker_id) VALUES('$user_id', '$worker_id')"
        );
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../css/choose.css">
</head>

<body>
    <?php Navbar("view") ?>
    <div class="dashboard_right">
        <div class="profile_info">
            <div class="profile_logo_view"></div>
            <div class="profile_view_text">
                <p class="profile_view_name"><?php echo $worker['name'] ?></p>
                <div class="verify_manage">
                    <p class="profile_view_category"><?php echo $worker['category_name'] ?></p>
                </div>
                <div class="details">
                    <div class="rating_data">
                        <div class="rating_number">
                            <img src="../assets/logo/star.png" alt="" class="view_rate">
                            <span class="rating_view">4.9</span>
                        </div>
                        <span class="rating_txt">Rating</span>
                    </div>
                    <div class="experience_data">
                        <p class="rating_view"><?php echo $worker['year_of_experience'] ?> years</p>
                        <p class="rating_txt">Experience</p>
                    </div>
                    <div class="view_status">
                        <p class="status_detail">✓Verified</p>
                    </div>
                </div>
                <div class="worker_services_view">
                    <?php foreach ($worker['services'] as $service) { ?>
                        <div class="service">
                            <?php echo $service['name'] ?? "sam" ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="view_buttons">
                <p class="view_price">NPR <?php echo $worker['base_rate'] ?>/hr</p>
                <div class="btns"><button class="book_btn button" popovertarget="popupbox" popovertargetaction="show">Book now</button>
                    <form action="" method="POST">
                        <input type="hidden" name="worker_id" value="<?php echo $worker['Worker_id']; ?>">
                        <button type="submit" name="save_worker" class="save_btn button">
                            <span class="love">♥&nbsp;</span>Save
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="view_bottom">
            <div class="left_section">
                <div class="view_container">
                    <p class="head">About</p>
                    <p class="paragraph">
                        Licensed electrician specializing in residential and commercial wiring,
                        solar panel installation, and electrical safety audits.
                    </p>
                </div>
                <div class="view_container">
                    <p class="head">Customer Reviews</p>
                    <?php foreach ($worker['services'] as $service) { ?>
                        <div class="review_container">
                            <div class="review_header">
                                <div class="view_profile_logo">
                                    PA
                                </div>
                                <div class="view_profile_text">
                                    <p class="view_profile_name">
                                        <?php echo $_SESSION['name'] ?? "Sayujya"; ?>
                                    </p>
                                    <span class="review_date">2 days ago</span>
                                </div>
                            </div>
                            <p class="review_text">
                                Highly recommend. Showed up on time, did the job perfectly.
                                Will book again.
                            </p>
                        </div>
                    <?php } ?>
                </div>

            </div>
        </div>
    </div>

    <dialog class="popup-container" popover id="popupbox">
        <div class="popup">
            <div class="booking_modal">
                <h1 class="worker_name">
                    <?php echo $worker['name'] ?? "Ram" ?>
                </h1>
                <p class="worker_info">
                    <?php echo $worker['category_name']  ?? "electrician" ?> · NPR <?php echo $worker['base_rate'] ?? 100 ?>/hr
                </p>
                <form method="POST">
                    <div class="form_group">
                        <label>Service Needed</label>
                        <select name="service_name">

                            <?php foreach ($worker['services'] as $service) { ?>
                                <option value="<?php $service['name'] ?>">
                                    <?php echo $service['name'] ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="row">
                        <div class="form_group">
                            <label>Date</label>
                            <input type="date" name="booking_date" min="<?php echo $today ?>" value="<?php echo $today ?>">
                        </div>
                        <div class="form_group">
                            <label>Time</label>
                            <input type="time" name="booking_time" value="10:00" min="08:00" max="18:00" steps="1800">
                        </div>
                    </div>
                    <div class="form_group">
                        <label>Service Address</label>
                        <input type="text" name="address" placeholder="Your full address">
                    </div>
                    <div class="form_group">
                        <label>Description of Problem</label>
                        <textarea name="description" rows="5" placeholder="Describe what needs to be done..."></textarea>
                    </div>
                    <div class="price_box">
                        <div class="price_row">
                            <span>Hourly Rate</span>
                            <span>NPR <?php echo $worker['base_rate'] ?></span>
                        </div>
                        <div class="price_row">
                            <span>Platform Fee</span>
                            <span>NPR 50</span>
                        </div>
                        <div class="price_row total">
                            <span>Estimated Total</span>
                            <span>NPR <?php echo $worker['base_rate'] + 50 ?? 100 ?>+</span>
                        </div>
                    </div>
                    <button class="confirm_btn" type="submit">Confirm Booking</button>
                    <button class="cancel_btn" type="button" popovertarget="popupbox" popovertargetaction="hide">Cancel </button>
                </form>
            </div>
        </div>
    </dialog>
</body>

</html>