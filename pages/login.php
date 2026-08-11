<?php
include '../php/authGuard.php';
include "../php/connect.php";
if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email' ";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {


            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['isLogged_in'] = true;

            if ($user['role'] == 'admin') {
                header("Location: admin.php");
            } elseif ($user['role'] == 'worker') {
                header("Location: worker.php");
            } else {
                header("Location: customer.php");
            }
        } else {
?>
            <script>
                alert("Invalid Password")
            </script> <?php
                    }
                } ?>
    <script>
        alert("Invalid Email ")
    </script>
<?php
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
        <div class="right">
            <img src="../assets/img/signWorker.jpg" alt="">
        </div>
        <div class="left">
            <a href="landing.php" class="logo">
                <img src="../assets/logo/logo1.png" alt="" class="logo_img">
            </a>
            <div class="texts">
                <h2>Welcome back</h2>
                <p>Login to your account to continue</p>
            </div>
            <div class="info_container">
                <div class="input_boxes">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email">
                </div>
                <div class="input_boxes">
                    <label for="pass">Password</label>
                    <input type="password" name="password" id="pass">
                </div>
                <div class="input_boxes input_button">
                    <input type="submit" value="Log in" name="login">
                </div>
                <div class="divider">
                    <div class="line"></div>
                    <span>or</span>
                    <div class="line"></div>
                </div>
                <div class="buttons">
                    <button class="signcuss sign"><a href="signup.php" class="cusssign">Be a customer</a></button>
                    <button class="signwork sign"><a href="signup.php" class="worksign">Be a worker</a></button>
                </div>

            </div>
        </div>
    </form>

</body>

</html>