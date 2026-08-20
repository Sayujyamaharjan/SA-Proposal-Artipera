<?php
include '../php/authGuard.php';
include '../components/fetchWorkers.php';
if (
    !isset($_GET['page_title']) || !in_array($_GET['page_title'], ['Worker', 'Customer'])
) {
    header("Location: ./login.php");
    exit;
}
$pageTitle = $_GET['page_title'];
if (isset($_POST['signup'])) {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $password = $_POST['password'];
    $full_name = $first_name . " " . $last_name;
    $role = ($pageTitle == "Worker") ? "worker" : "customer";

    if (empty($first_name) || empty($last_name) || empty($email) || empty($phone) || empty($address) || empty($password)) {
        header("Location: signup.php?page_title=$pageTitle&error=empty");
        exit;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: signup.php?page_title=$pageTitle&error=email");
        exit;
    }
    $checkSql = "SELECT user_id FROM users WHERE email = ?";
    $checkStmt = mysqli_prepare($conn, $checkSql);
    if (!$checkStmt) {
        header("Location: signup.php?page_title=$pageTitle&error=database");
        exit;
    }
    mysqli_stmt_bind_param($checkStmt, "s", $email);
    mysqli_stmt_execute($checkStmt);
    $checkResult = mysqli_stmt_get_result($checkStmt);
    if (mysqli_num_rows($checkResult) > 0) {
        mysqli_stmt_close($checkStmt);
        header("Location: signup.php?page_title=$pageTitle&error=email_exists");
        exit;
    }
    mysqli_stmt_close($checkStmt);
    if (
        strlen($password) < 8 ||
        !preg_match('/[0-9]/', $password) ||
        !preg_match('/[^A-Za-z0-9]/', $password)
    ) {
        header("Location: signup.php?page_title=$pageTitle&error=weak_password");
        exit;
    }
    if (!preg_match('/^[0-9]{10}$/', $phone)) {
        header("Location: signup.php?page_title=$pageTitle&error=phone");
        exit;
    }
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users
            (name, email, password, phone, address, role, profile_image)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        header("Location: signup.php?page_title=$pageTitle&error=database");
        exit;
    }
    $profile_image = "default.jpg";
    mysqli_stmt_bind_param(
        $stmt,
        "sssssss",
        $full_name,
        $email,
        $hashed_password,
        $phone,
        $address,
        $role,
        $profile_image
    );
    try {
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            header("Location: signup.php?page_title=$pageTitle&success=created");
            exit;
        }
    } catch (mysqli_sql_exception $e) {
        mysqli_stmt_close($stmt);
        if ($e->getCode() == 1062) {
            if (strpos($e->getMessage(), 'users.email') !== false) {

                header("Location: signup.php?page_title=$pageTitle&error=email_exists");
                exit;
            }
            if (strpos($e->getMessage(), 'users.phone') !== false) {
                header("Location: signup.php?page_title=$pageTitle&error=phone_exists");
                exit;
            }
        }
        header("Location: signup.php?page_title=$pageTitle&error=database");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="../css/sign.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <form action="" method="post" class="form">
        <div class="left">
            <a href="landing.php" class="logo">
                <img src="../assets/logo/logo1.png" alt="" class="logo_img">
            </a>
            <div class="texts">
                <h2>
                    Become a <?php echo $pageTitle; ?>
                </h2>
                <p>Create your account to continue</p>
            </div>
            <div class="info_container">
                <div class="input_boxes_locate_phone">
                    <div class="input_boxes">
                        <label for="first_name"> First Name</label>
                        <input type="text" name="first_name" id="first_name" required>
                    </div>
                    <div class="input_boxes">
                        <label for="last_name"> Last Name </label>
                        <input type="text" name="last_name" id="last_name" required>
                    </div>
                </div>
                <div class="input_boxes">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" required>
                </div>
                <div class="input_boxes">
                    <label for="pass">Password</label>
                    <input type="password" name="password" id="pass" required>
                </div>
                <div class="input_boxes_locate_phone">
                    <div class="input_boxes">
                        <label for="phone">Phone </label>
                        <input type="tel" name="phone" id="phone" required>
                    </div>
                    <div class="input_boxes">
                        <label for="locate"> Address </label>
                        <select name="address" id="locate" required>
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
                    <span class="txt">Already have an account? </span>
                    <a href="login.php" class="anchor"> Log in</a>
                </div>
            </div>
        </div>
        <div class="right">
            <img src="../assets/img/sign.jpg" alt="">
        </div>
    </form>
    <?php
    if (isset($_GET['error'])) {
        if ($_GET['error'] == 'empty') {
            $title = "Missing Information";
            $text = "Please fill in all the fields.";
        } elseif ($_GET['error'] == 'email') {
            $title = "Invalid Email";
            $text = "Please enter a valid email address.";
        } elseif ($_GET['error'] == 'phone') {
            $title = "Invalid Phone";
            $text = "Phone number must contain 10 digits.";
        } elseif ($_GET['error'] == 'email_exists') {
            $title = "Email Already Exists";
            $text = "Use a different email.";
        } elseif ($_GET['error'] == 'phone_exists') {
            $title = "Phone Already Exists";
            $text = "This phone number is already registered.";
        } elseif ($_GET['error'] == 'weak_password') {
            $title = "Weak Password";
            $text = "Password must be at least 8 characters with a number and special character.";
        } elseif ($_GET['error'] == 'database') {
            $title = "Error";
            $text = "Something went wrong. Please try again.";
        } else {
            $title = "Error";
            $text = "Something went wrong.";
        }
        ?>
        <script>
            Swal.fire({
                title: '<?php echo $title; ?>',
                text: '<?php echo $text; ?>',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                width: 'auto',
                padding: '5px',
                timerProgressBar: false
            });
            window.history.replaceState(
                {},
                document.title,
                "signup.php?page_title=<?php echo $pageTitle; ?>"
            );
        </script>
        <?php
    }
    if (isset($_GET['success']) && $_GET['success'] == 'created') {
        ?>
        <script>
            Swal.fire({
                text: 'Account Created Successfully',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
                width: 'auto',
                padding: '5px',
                timerProgressBar: false
            });
            window.history.replaceState(
                {},
                document.title,
                "signup.php?page_title=<?php echo $pageTitle; ?>"
            );
        </script>
    <?php } ?>
</body>

</html>