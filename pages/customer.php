<?php $name = "Sayujya Maharjan";
$role = "Customer" ?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/customer.css">
</head>

<body>
    <div class="option_bar">
        <a href="landing.html" class="logo">
            <div class="logo_icon">A</div>
            <span class="logo_text">Artipera</span>
        </a>
        <div class="customerprof">
            <div class="profile_logo"></div>
            <div class="profile_text">
                <p class="profile_name">
                    <?php echo $name ?>
                </p>
                <p class="role"><?php echo $role ?></p>
            </div>
        </div>
        <br>
        <div class="hr-line"></div>
        <div class="profile_main">
            <p class="contents_head">MAIN</p>
            <div class="main_contents">
                <div class="main_home">
                    <img src="../assets/svg/home.svg" alt="" class="home_img">
                    <span class="home_text">Home</span>
                </div>
                <div class="main_browse">
                    <img src="../assets/svg/search.svg" alt="" class="search_img">
                    <span class="search_text">Search</span>
                </div>
                <div class="main_history">
                    <img src="../assets/svg/calendar-week.svg" alt="" class="history_img">
                    <span class="history_text">My Bookings</span>
                </div>
                <div class="main_fav">
                    <img src="../assets/svg/heart.svg" alt="" class="fav_img">
                    <span class="fav_text">Saved Workers</span>
                </div>
            </div>
            <p class="content_head">Account</p>
        </div>
    </div>
</body>

</html>