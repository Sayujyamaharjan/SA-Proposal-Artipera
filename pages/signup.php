<?php
include '../php/authGuard.php';
include '../components/fetchWorkers.php';
include "../php/caller.php";
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
    $confirm_password = $_POST['confirm_password'];
    $full_name = $first_name . " " . $last_name;
    $role = ($pageTitle == "Worker") ? "worker" : "customer";
    $_SESSION['signup_form'] = [
        'first_name' => $first_name,
        'last_name' => $last_name,
        'email' => $email,
        'phone' => $phone,
        'address' => $address
    ];

    if (
        empty($first_name) ||
        empty($last_name) ||
        empty($email) ||
        empty($phone) ||
        empty($address) ||
        empty($password) ||
        empty($confirm_password)
    ) {
        header("Location: signup.php?page_title=$pageTitle&error=empty");
        exit;
    }

    if ($password !== $confirm_password) {
        header("Location: signup.php?page_title=$pageTitle&error=password_mismatch");
        exit;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: signup.php?page_title=$pageTitle&error=email");
        exit;
    }

    $existingUser = getUser('email', $email, $conn);


    if (count($existingUser) > 0) {
        header("Location: signup.php?page_title=$pageTitle&error=email_exists");
        exit;
    }
    $existingPhone = getUser('phone', $phone, $conn);

    if (count($existingPhone) > 0) {
        header("Location: signup.php?page_title=$pageTitle&error=phone_exists");
        exit;
    }
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
    $profile_image = "default.jpg";
    $status = otpMailer($email, $full_name);
    $otp_exp = $status['expiresOn'];
    $request_id = $status['requestId'];
    if ($status['status']) {
        $_SESSION['pending_signup'] = [
            'full_name' => $full_name,
            'email' => $email,
            'phone' => $phone,
            'address' => $address,
            'password' => $hashed_password,
            'role' => $role,
            'profile_image' => $profile_image
        ];
    }

    header("location: otpPage.php?expires_on=$otp_exp&request_id=$request_id&email=$email");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="../css/sign.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
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
                        <input type="text" name="first_name" id="first_name"
                            value="<?php echo htmlspecialchars($signup_form['first_name'] ?? ''); ?>" required>
                    </div>
                    <div class="input_boxes">
                        <label for="last_name"> Last Name </label>
                        <input type="text" name="last_name" id="last_name"
                            value="<?php echo htmlspecialchars($signup_form['last_name'] ?? ''); ?>" required>
                    </div>
                </div>
                <div class="input_boxes">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email"
                        value="<?php echo htmlspecialchars($signup_form['email'] ?? ''); ?>" required>
                </div>
                <div class="input_boxes password_box">
                    <label for="pass">Password</label>
                    <div class="password_input">
                        <input type="password" name="password" id="pass"
                            value="<?php echo htmlspecialchars($signup_form['password'] ?? ''); ?>" required>
                        <span class="toggle_password" onclick="togglePassword('pass', 'eye1')">
                            <i class="fa-solid fa-eye" id="eye1"></i>
                        </span>
                    </div>
                </div>
                <div class="input_boxes password_box">
                    <label for="confirm_pass">Confirm Password</label>
                    <div class="password_input">
                        <input type="password" name="confirm_password" id="confirm_pass"
                            value="<?php echo htmlspecialchars($signup_form['confirm_password'] ?? ''); ?>" required>
                        <span class="toggle_password" onclick="togglePassword('confirm_pass', 'eye2')">
                            <i class="fa-solid fa-eye" id="eye2"></i>
                        </span>
                    </div>
                </div>
                <div class="input_boxes_locate_phone">
                    <div class="input_boxes">
                        <label for="phone">Phone </label>
                        <input type="tel" name="phone" id="phone"
                            value="<?php echo htmlspecialchars($signup_form['phone'] ?? ''); ?>" required>
                    </div>
                    <div class="input_boxes">
                        <label for="locate"> Address </label>
                        <select name="address" id="locate" required>
                            <option value="" disabled <?php echo empty($signup_form['address']) ? 'selected' : ''; ?>>
                                Select Address</option>
                            <option value="Kathmandu" <?php echo (($signup_form['address'] ?? '') == 'Kathmandu') ? 'selected' : ''; ?>>Kathmandu</option>
                            <option value="Lalitpur" <?php echo (($signup_form['address'] ?? '') == 'Lalitpur') ? 'selected' : ''; ?>>Lalitpur</option>
                            <option value="Bhaktapur" <?php echo (($signup_form['address'] ?? '') == 'Bhaktapur') ? 'selected' : ''; ?>>Bhaktapur</option>
                            <option value="Pokhara" <?php echo (($signup_form['address'] ?? '') == 'Pokhara') ? 'selected' : ''; ?>>Pokhara</option>
                            <option value="Chitwan" <?php echo (($signup_form['address'] ?? '') == 'Chitwan') ? 'selected' : ''; ?>>Chitwan</option>
                            <option value="Butwal" <?php echo (($signup_form['address'] ?? '') == 'Butwal') ? 'selected' : ''; ?>>Butwal</option>
                            <option value="Dharan" <?php echo (($signup_form['address'] ?? '') == 'Dharan') ? 'selected' : ''; ?>>Dharan</option>
                            <option value="Biratnagar" <?php echo (($signup_form['address'] ?? '') == 'Biratnagar') ? 'selected' : ''; ?>>Biratnagar</option>
                            <option value="Janakpur" <?php echo (($signup_form['address'] ?? '') == 'Janakpur') ? 'selected' : ''; ?>>Janakpur</option>
                            <option value="Hetauda" <?php echo (($signup_form['address'] ?? '') == 'Hetauda') ? 'selected' : ''; ?>>Hetauda</option>
                            <option value="Nepalgunj" <?php echo (($signup_form['address'] ?? '') == 'Nepalgunj') ? 'selected' : ''; ?>>Nepalgunj</option>
                            <option value="Itahari" <?php echo (($signup_form['address'] ?? '') == 'Itahari') ? 'selected' : ''; ?>>Itahari</option>
                            <option value="Dhangadhi" <?php echo (($signup_form['address'] ?? '') == 'Dhangadhi') ? 'selected' : ''; ?>>Dhangadhi</option>
                            <option value="Tulsipur" <?php echo (($signup_form['address'] ?? '') == 'Tulsipur') ? 'selected' : ''; ?>>Tulsipur</option>
                            <option value="Banepa" <?php echo (($signup_form['address'] ?? '') == 'Banepa') ? 'selected' : ''; ?>>Banepa</option>
                            <option value="Dhulikhel" <?php echo (($signup_form['address'] ?? '') == 'Dhulikhel') ? 'selected' : ''; ?>>Dhulikhel</option>
                            <option value="Bharatpur" <?php echo (($signup_form['address'] ?? '') == 'Bharatpur') ? 'selected' : ''; ?>>Bharatpur</option>
                            <option value="Gorkha" <?php echo (($signup_form['address'] ?? '') == 'Gorkha') ? 'selected' : ''; ?>>Gorkha</option>
                            <option value="Ilam" <?php echo (($signup_form['address'] ?? '') == 'Ilam') ? 'selected' : ''; ?>>Ilam</option>
                            <option value="Surkhet" <?php echo (($signup_form['address'] ?? '') == 'Surkhet') ? 'selected' : ''; ?>>Surkhet</option>
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
        } elseif ($_GET['error'] == 'password_mismatch') {
            $title = "Passwords Do Not Match";
            $text = "Password and confirm password must be the same.";
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
                timerProgressBar: false
            });
            window.history.replaceState(
                {},
                document.title,
                "signup.php?page_title=<?php echo $pageTitle; ?>"
            );
        </script>
    <?php } ?>
    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                input.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }
    </script>
</body>

</html>