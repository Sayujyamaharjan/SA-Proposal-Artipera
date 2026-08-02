<?php
include '../php/authGuard.php';
include "../components/Navbar.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/worker.css">
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
                <div class="profile_form">
                    <div class="input_group">
                        <label>Full Name</label>
                        <input type="text" value="Sayujya Maharjan">
                    </div>
                    <div class="input_group">
                        <label>Email</label>
                        <input type="email" value="sayujya@gmail.com">
                    </div>
                    <div class="input_group">
                        <label>Phone</label>
                        <input type="text" value="+977 9812345678">
                    </div>
                    <button class="save_btn_profile">Save Changes</button>
                </div>
            </div>
        </div>
        <div class="profile_right">
            <div class="profile_right_top">
                <h2>Change Password</h2>
                <div class="input_group">
                    <label>Current Password</label>
                    <input type="password" placeholder="••••••••">
                </div>
                <div class="input_group">
                    <label>New Password</label>
                    <input type="password" placeholder="••••••••">
                </div>
                <div class="input_group">
                    <label>Confirm Password</label>
                    <input type="password" placeholder="••••••••">
                </div>
                <button class="update_btn">
                    Update Password
                </button>
            </div>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] == "worker") { ?>
                <div class="documents_container">
                    <div class="document_item">
                        <span>📄 Citizenship Card (Verified)</span>
                        <span class="verified">✓</span>
                    </div>
                    <label for="documentUpload" class="upload_box">
                        <div class="upload_content">
                            <p>Upload additional document</p>
                        </div>
                    </label>
                    <input type="file" id="documentUpload" accept="image/*,.pdf" hidden>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</body>

</html>