<?php

include '../php/authGuard.php';
include "../php/connect.php";

if (isset($_POST['login'])) {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        header("Location: login.php?error=empty");
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: login.php?error=invalid_format");
        exit;
    }

    $sql = "SELECT * FROM users WHERE email = ?";

    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        header("Location: login.php?error=database");
        exit;
    }

    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 0) {
        header("Location: login.php?error=email");
        exit;
    }

    $user = mysqli_fetch_assoc($result);

    if (!password_verify($password, $user['password'])) {
        header("Location: login.php?error=password");
        exit;
    }

    session_regenerate_id(true);

    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['name'] = $user['name'];
    $_SESSION['role'] = $user['role'];
    $_SESSION['isLogged_in'] = true;

    if ($user['role'] == 'admin') {
        header("Location: admin.php");
        exit;
    } elseif ($user['role'] == 'worker') {
        header("Location: worker.php");
        exit;
    } elseif ($user['role'] == 'customer') {
        header("Location: customer.php");
        exit;
    } else {
        header("Location: login.php?error=role");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../css/sign.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
                    <input type="email" name="email" id="email" required>
                </div>
                <div class="input_boxes">
                    <label for="pass">Password</label>
                    <input type="password" name="password" id="pass" required>
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
                    <button type="button" class="signcuss sign">
                        <a href="signup.php?page_title=Customer" class="cusssign"> Be a customer</a>
                    </button>
                    <button type="button" class="signwork sign">
                        <a href="signup.php?page_title=Worker" class="worksign"> Be a worker</a>
                    </button>
                </div>
            </div>
        </div>
    </form>
    <?php

    if (isset($_GET['error'])) {

        if ($_GET['error'] == 'email') {
            $title = "Invalid Email";
            $text = "The email address you entered does not exist.";
        } elseif ($_GET['error'] == 'password') {
            $title = "Invalid Password";
            $text = "The password you entered is incorrect.";
        } elseif ($_GET['error'] == 'empty') {
            $title = "Email or password cannot be empty.";
            $text = "Email or password cannot be empty.";
        } elseif ($_GET['error'] == 'invalid_format') {
            $title = "Invalid Email Format";
            $text = "Please enter a valid email address.";
        } elseif ($_GET['error'] == 'database') {
            $title = "Error";
            $text = "Something went wrong. Please try again.";
        } elseif ($_GET['error'] == 'role') {
            $title = "Error";
            $text = "Invalid user role.";
        }

        ?>

        <script>
            Swal.fire({
                text: '<?php echo $title; ?>',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
                width: 'auto',
                timerProgressBar: false
            });
            window.history.replaceState({}, document.title, "login.php");
        </script>

    <?php } ?>

</body>

</html>