<?php
include '../components/customerNavbar.php';
$user['services'] = [
    [
        'name' => 'House Wiring',
    ],
    [
        'name' => 'Fan Installation',
    ],
    [
        'name' => 'Switch Installation',
    ],
    [
        'name' => 'Circuit Repair',
    ]
];
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
                <p class="profile_view_name">Sayujya Maharjan</p>
                <div class="verify_manage">
                    <p class="profile_view_category">Electrician</p>
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
                    <?php foreach ($user['services'] as $service) { ?>
                        <div class="service">
                            <?php echo $service['name'] ?? "sam" ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="view_buttons">
                <p class="view_price">NPR 500/hr</p>
                <button>Book now</button>
                <a href=""><button>Saved</button></a>
            </div>
        </div>

    </div>
</body>

</html>