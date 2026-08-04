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



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/dashboard.css">
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
                        <p class="rating_view">5 years</p>
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
                <p class="view_price">NPR 500/hr</p>
                <div class="btns"><button class="book_btn button">Book now</button>
                    <a href=""><button class="save_btn button"><span class="love">♥&nbsp;</span>Saved</button></a>
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
            <!-- <div class="right_section">
                <div class="view_container">
                    <p class="head">Services</p>
                    <?php foreach ($worker['services'] as $service) { ?>
                        <div class="service_row">
                            <span><?php echo $service['name']; ?></span>

                        </div>
                    <?php } ?>
                </div>
            </div> -->
        </div>
    </div>
</body>

</html>