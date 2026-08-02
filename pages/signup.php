<?php
include '../php/authGuard.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/sign.css">
</head>

<body>
    <form action="" method="post" class="form">
        <div class="left">
            <a href="landing.php" class="logo">
                <img src="../assets/logo/logo1.png" alt="" class="logo_img">
            </a>
            <div class="texts">
                <h2>Become a customer</h2>
                <p>Login to your account to continue</p>
            </div>
            <div class="info_container">
                <div class="input_boxes">
                    <label for="full_name">Full Name</label>
                    <input type="text" name="name" id="full_name">
                </div>
                <div class="input_boxes">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email">
                </div>
                <div class="input_boxes">
                    <label for="pass">Password</label>
                    <input type="password" name="password" id="pass">
                </div>
                <div class="input_boxes_locate_phone">
                    <div class="input_boxes">
                        <label for="phone">Phone</label>
                        <input type="tel" name="phone" id="phone">
                    </div>
                    <div class="input_boxes">
                        <label for="locate">Address</label>
                        <select name="address" id="locate" placeholder="">
                            <option value="" selected disabled hidden></option>
                            <option value="Kathmandu">Kathmandu</option>
                            <option value="Lalitpur">Lalitpur</option>
                            <option value="Bhaktapur">Bhaktapur</option>
                            <option value="Pokhara">Pokhara</option>
                            <option value="Chitwan">Chitwan</option>
                            <option value="Butwal">Butwal</option>
                            <option value="Dharan">Dharan</option>
                            <option value="Biratnagar">Biratnagar</option>
                            <option value="Janakpur">Janakpur</option>
                            <option value="Hetauda">Hetauda</option>
                            <option value="Nepalgunj">Nepalgunj</option>
                            <option value="Itahari">Itahari</option>
                            <option value="Dhangadhi">Dhangadhi</option>
                            <option value="Tulsipur">Tulsipur</option>
                            <option value="Banepa">Banepa</option>
                            <option value="Dhulikhel">Dhulikhel</option>
                            <option value="Bharatpur">Bharatpur</option>
                            <option value="Gorkha">Gorkha</option>
                            <option value="Ilam">Ilam</option>
                            <option value="Surkhet">Surkhet</option>
                        </select>
                    </div>
                </div>
                <div class="input_boxes input_button">
                    <input type="submit" value="Create account">
                </div>
                <div class="already_have">
                    <span class="txt">Already have an account?</span>
                    <a href="login.php" class="anchor">Log in</a>
                </div>
            </div>
        </div>
        <div class="right">
            <img src="../assets/img/sign.jpg" alt="">
        </div>
    </form>
</body>

</html>