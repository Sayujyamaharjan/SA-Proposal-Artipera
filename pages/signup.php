<?php
include '../php/authGuard.php';
include '../components/fetchWorkers.php';

$pageTitle = $_GET['page_title'];

if (!isset($pageTitle)  ||  !in_array($pageTitle, ['Worker', "Customer"])) {
    header("location: ./login.php");
}
if (isset($_POST['signup'])) {
    $first_name =  $_POST['first_name'];
    $last_name  = $_POST['last_name'];
    $email      = $_POST['email'];
    $phone      = $_POST['phone'];
    $address    = $_POST['address'];

    $full_name = $first_name . " " . $last_name;
    $role = $pageTitle == "Worker" ? "worker" : "customer";
    if (empty($email)) {
        header("location: ./login.php");
    }
    $password   = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $sql = "INSERT INTO users
        (name, email, password, phone, address, role,profile_image)
        VALUES
        ('$full_name', '$email', '$password', '$phone', '$address', '$role','default.jpg')";

    if (mysqli_query($conn, $sql)) {
?>
        <script>
            alert("Account created successfully")
            window.location.href = 'signup.php?page_title=$pageTitle';
        </script> <?php
                } else {
                    echo "Error: " . mysqli_error($conn);
                    header("location: ./login.php");
                }
            }
                    ?>
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
                <h2>Become a <?php echo $pageTitle ?></h2>
                <p>Create your account to continue</p>
            </div>
            <div class="info_container">
                <div class="input_boxes_locate_phone ">
                    <div class="input_boxes">
                        <label for="first_name">First Name</label>
                        <input type="text" name="first_name" id="first_name">
                    </div>
                    <div class="input_boxes">
                        <label for="last_name">Last Name</label>
                        <input type="text" name="last_name" id="last_name">
                    </div>
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
                    <input type="submit" value="Create account" name="signup">
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