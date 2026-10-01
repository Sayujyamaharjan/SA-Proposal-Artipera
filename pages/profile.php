<?php
include '../php/authGuard.php';
include "../components/Navbar.php";
$user_id = $_SESSION['user_id'];

$sql = "SELECT
            u.*,
            w.category_id,
            w.year_of_experience,
            w.bio
        FROM users u
        LEFT JOIN worker w
            ON u.user_id = w.user_id
        WHERE u.user_id = '$user_id'";

$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);


if (isset($_POST['save_profile'])) {

    $user_id = $_SESSION['user_id'];

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    $sql = "UPDATE users
        SET name='$name',
            email='$email',
            phone='$phone',
            address='$address'
        WHERE user_id='$user_id'";

    mysqli_query($conn, $sql);

    $_SESSION['name'] = $name;
    $_SESSION['email'] = $email;

    if ($_SESSION['role'] == 'worker') {

        $category_id = (int) $_POST['category_id'];
        $year_of_experience = (int) $_POST['experience'];
        $bio = mysqli_real_escape_string($conn, $_POST['bio']);

        $sql = "UPDATE worker
                SET category_id='$category_id',
                    year_of_experience='$year_of_experience',
                    bio='$bio'
                WHERE user_id='$user_id'";

        mysqli_query($conn, $sql);
    }
    $_SESSION['name'] = $name;
    $_SESSION['email'] = $email;
    header("Location: profile.php");
    exit();
}
if (isset($_POST['change_password'])) {

    $user_id = $_SESSION['user_id'];

    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if (
        empty($current_password) ||
        empty($new_password) ||
        empty($confirm_password)
    ) {

        echo "<script>
                alert('Please fill in all password fields.');
              </script>";
    } else {

        $sql = "SELECT password FROM users WHERE user_id='$user_id'";
        $result = mysqli_query($conn, $sql);
        $user_data = mysqli_fetch_assoc($result);

        if (!password_verify($current_password, $user_data['password'])) {
            echo "<script>
                    alert('Current password is incorrect.');
                  </script>";
        } elseif ($new_password != $confirm_password) {
            echo "<script>
                    alert('New password and confirm password do not match.');
                  </script>";
        } elseif (
            strlen($new_password) < 8 ||
            !preg_match('/[0-9]/', $new_password) ||
            !preg_match('/[^A-Za-z0-9]/', $new_password)
        ) {
            echo "<script>
                    alert('Password must be at least 8 characters long and contain a number and a special character.');
                  </script>";
        } else {

            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            $sql = "UPDATE users
                    SET password='$hashed_password'
                    WHERE user_id='$user_id'";

            mysqli_query($conn, $sql);

            echo "<script>
                    alert('Password changed successfully.');
                    window.location.href='profile.php';
                  </script>";
            exit();
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
    <link rel="stylesheet" href="../css/worker.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php Navbar("workerProfile") ?>
    <div class="dashboard_right_profile">
        <div class="profile_left">
            <div class="profile_userprof">
                <p class="info">Profile Information</p>
                <div class="profile_top">
                    <div class="profile_logo_worker">
                    </div>
                    <div class="change_photo">
                        <button class="photo_btn">Change Photo</button>
                    </div>
                </div>
                <form method="POST" class="profile_form">
                    <div class="input_group">
                        <label>Full Name</label>
                        <input type="text" name="name" value="<?php echo $user['name'] ?>">
                    </div>
                    <div class="input_group">
                        <label>Email</label>
                        <input type="email" name="email" value="<?php echo $user['email'] ?> " disabled>
                    </div>
                    <div class="input_group">
                        <label>Phone</label>
                        <input type="tel" name="phone" value="<?php echo $user['phone'] ?>" disabled>
                    </div>
                    <div class="input_group">
                        <label for="locate">Address</label>
                        <select name="address" id="locate" placeholder="">
                            <option value="" selected disabled hidden>Select Location</option>
                            <option value="Kathmandu" <?php echo $user['address'] == 'Kathmandu' ? 'selected' : '' ?>>
                                Kathmandu</option>
                            <option value="Lalitpur" <?php echo $user['address'] == 'Lalitpur' ? 'selected' : '' ?>>
                                Lalitpur</option>
                            <option value="Bhaktapur" <?php echo $user['address'] == 'Bhaktapur' ? 'selected' : '' ?>>
                                Bhaktapur</option>
                            <option value="Pokhara" <?php echo $user['address'] == 'Pokhara' ? 'selected' : '' ?>>Pokhara
                            </option>
                            <option value="Chitwan" <?php echo $user['address'] == 'Chitwan' ? 'selected' : '' ?>>Chitwan
                            </option>
                            <option value="Butwal" <?php echo $user['address'] == 'Butwal' ? 'selected' : '' ?>>Butwal
                            </option>
                            <option value="Dharan" <?php echo $user['address'] == 'Dharan' ? 'selected' : '' ?>>Dharan
                            </option>
                            <option value="Biratnagar" <?php echo $user['address'] == 'Biratnagar' ? 'selected' : '' ?>>
                                Biratnagar</option>
                            <option value="Janakpur" <?php echo $user['address'] == 'Janakpur' ? 'selected' : '' ?>>
                                Janakpur</option>
                            <option value="Hetauda" <?php echo $user['address'] == 'Hetauda' ? 'selected' : '' ?>>Hetauda
                            </option>
                            <option value="Nepalgunj" <?php echo $user['address'] == 'Nepalgunj' ? 'selected' : '' ?>>
                                Nepalgunj</option>
                            <option value="Itahari" <?php echo $user['address'] == 'Itahari' ? 'selected' : '' ?>>Itahari
                            </option>
                            <option value="Dhangadhi" <?php echo $user['address'] == 'Dhangadhi' ? 'selected' : '' ?>>
                                Dhangadhi</option>
                            <option value="Tulsipur" <?php echo $user['address'] == 'Tulsipur' ? 'selected' : '' ?>>
                                Tulsipur</option>
                            <option value="Banepa" <?php echo $user['address'] == 'Banepa' ? 'selected' : '' ?>>Banepa
                            </option>
                            <option value="Dhulikhel" <?php echo $user['address'] == 'Dhulikhel' ? 'selected' : '' ?>>
                                Dhulikhel</option>
                            <option value="Bharatpur" <?php echo $user['address'] == 'Bharatpur' ? 'selected' : '' ?>>
                                Bharatpur</option>
                            <option value="Gorkha" <?php echo $user['address'] == 'Gorkha' ? 'selected' : '' ?>>Gorkha
                            </option>
                            <option value="Ilam" <?php echo $user['address'] == 'Ilam' ? 'selected' : '' ?>>Ilam</option>
                            <option value="Surkhet" <?php echo $user['address'] == 'Surkhet' ? 'selected' : '' ?>>Surkhet
                            </option>
                        </select>
                    </div>
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] == "worker") { ?>
                        <div class="input_group">
                            <label for="locate">Category</label>
                            <select name="category_id" id="locate" placeholder="">
                                <option value="" selected disabled hidden>Select your category</option>
                                <option value="1" <?php echo $user['category_id'] == 1 ? 'selected' : '' ?>>Electrician
                                </option>
                                <option value="2" <?php echo $user['category_id'] == 2 ? 'selected' : '' ?>>Plumber</option>
                                <option value="3" <?php echo $user['category_id'] == 3 ? 'selected' : '' ?>>Painter</option>
                                <option value="4" <?php echo $user['category_id'] == 4 ? 'selected' : '' ?>>Mechanic</option>
                                <option value="5" <?php echo $user['category_id'] == 5 ? 'selected' : '' ?>>Carpenter
                                </option>
                            </select>
                        </div>
                        <div class="input_group">
                            <label>Experience</label>
                            <input type="text" name="experience"
                                value="<?php echo $user['year_of_experience'] . ' years' ?>">
                        </div>
                        <div class="input_group">
                            <label>Bio</label>
                            <textarea name="bio"><?php echo $user['bio'] ?></textarea>
                        </div>
                    <?php } ?>
                    <button class="save_btn_profile" type="submit" name="save_profile">Save Changes</button>
                </form>
            </div>
        </div>
        <div class="profile_right">
            <div class="profile_right_top">
                <h2>Change Password</h2>
                <form method="POST" class="profile_form">
                    <div class="input_group">
                        <label>Current Password</label>
                        <input type="password" name="current_password" placeholder="••••••••" required>
                    </div>
                    <div class="input_group">
                        <label>New Password</label>
                        <input type="password" name="new_password" placeholder="••••••••" required>
                    </div>
                    <div class="input_group">
                        <label>Confirm Password</label>
                        <input type="password" name="confirm_password" placeholder="••••••••" required>
                    </div>
                    <button class="update_btn" type="submit" name="change_password">
                        Update Password
                    </button>
                </form>
            </div>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] == "worker") { ?>
                <form class="documents_container" id="document-verification-form">
                    <div class="document_item">
                        <span>Upload Documents To get Verified</span>
                    </div>
                    <label for="documentUpload1" class="upload_box">
                        <div class="upload_content">
                            <p>ID front photo</p>
                        </div>
                    </label>
                    <input type="file" id="documentUpload1" accept="image/*,.pdf" hidden name="id_front_photo">
                    <label for="documentUpload2" class="upload_box">
                        <div class="upload_content">
                            <p>ID back photo</p>
                        </div>
                    </label>
                    <input type="file" id="documentUpload2" accept="image/*,.pdf" hidden name="id_back_photo">
                    <label for="documentUpload3" class="upload_box">
                        <div class="upload_content">
                            <p>Past work photo</p>
                        </div>
                    </label>
                    <input type="file" id="documentUpload3" accept="image/*,.pdf" hidden name="past_work_photo">
                    <input type="submit" value="Submit" class="document">
                </form>
                <?php
            }
            ?>
        </div>
    </div>
    <script>document.getElementById("documentUpload1").addEventListener("change", function () {
            if (this.files.length > 0) {
                this.previousElementSibling.querySelector("p").innerHTML = "✓ Document Uploaded";
            }
        });

        document.getElementById("documentUpload2").addEventListener("change", function () {
            if (this.files.length > 0) {
                this.previousElementSibling.querySelector("p").innerHTML = "✓ Document Uploaded";
            }
        });

        document.getElementById("documentUpload3").addEventListener("change", function () {
            if (this.files.length > 0) {
                this.previousElementSibling.querySelector("p").innerHTML = "✓ Document Uploaded";
            }
        });</script>
    <script src="../js/documents.js"></script>
</body>

</html>