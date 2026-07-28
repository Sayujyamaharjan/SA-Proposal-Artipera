<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/login.css">
</head>

<body>
    <!--     // todo CUSTOMER SIGNUP -->
    <div class="container_box">
        <div class="image login_image" id="login_image">
            <img src="../assets/img/leftimg.png" alt="" class="">
        </div>
        <form method="POST">
            <div class=" login_content" id="customeLogin">
                <a href="landing.html" class="logo">
                    <div class="logo_icon">A</div>
                    <span class="logo_text">Artipera</span>
                </a>
                <div class="login_top">
                    <h1 class="login_text">Create your account</h1>
                    <p class="login_subtext">Sign in to continue</p>
                </div>
                <div class="login_email">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" placeholder="example@gmail.com" required>
                </div>
                <div class="login_password">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="email" placeholder="••••••••" required>
                </div>
                <div class="forgot_link">
                    <a href="" class="forgot">Forgot pasword?</a>
                </div>
                <button class="login_button" name="signin_btn_customer" id="customerLoginBtn">Log in</button>
                <div class="login_bot">
                    <span class="login_bot_text">Don't have an account?</span>
                </div>
            </div>

        </form>
        <!-- // ! WORKER SIGNUP -->
        <form action="">

            <div class="login_content hidden" id="workerLogin">
                <div class="login_content_worker">
                    <div id="worker_login_part_1" class="">
                        <a href="landing.html" class="logo">
                            <div class="logo_icon">A</div>
                            <span class="logo_text">Artipera</span>
                        </a>
                        <div class="login_top">
                            <h1 class="login_text">Create your account</h1>
                            <p class="login_subtext"></p>
                        </div>
                        <div class="login_email">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" placeholder="example@gmail.com" required>
                        </div>
                        <div class="login_password">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="email" placeholder="••••••••" required>
                        </div>
                    </div>
                    <!-- // ! WORKER SIGNUP PART 2 -->
                    <div id="worker_login_part_2" class="hidden">
                        <a href="landing.html" class="logo">
                            <div class="logo_icon">A</div>
                            <span class="logo_text">Artipera</span>
                        </a>
                        <div class="login_top">
                            <h1 class="login_text">Welcome back</h1>
                            <p class="login_subtext">Sign in to continue</p>
                        </div>

                        <div class="login_password">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="email" placeholder="••••••••" required>
                        </div>
                    </div>
                </div>
                <button class="login_button" id="customerNextBtn">Next</button>
            </div>
        </form>
        <!--         //! LOGIN PAGE -->
        <div class="login_content">
            <a href="landing.html" class="logo">
                <div class="logo_icon">A</div>
                <span class="logo_text">Artipera</span>
            </a>
            <div class="login_top">
                <h1 class="login_text">Welcome back</h1>
                <p class="login_subtext">Sign in to continue</p>
            </div>
            <div class="login_email">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="example@gmail.com" required>
            </div>
            <div class="login_password">
                <label for="password">Password</label>
                <input type="password" name="password" id="email" placeholder="••••••••" required>
            </div>
            <div class="forgot_link">
                <a href="" class="forgot">Forgot pasword?</a>
            </div>
            <button class="login_button">Log in</button>
            <div class="login_bot">
                <span class="login_bot_text">Don't have an account?</span>
            </div>
            <div class="login_bot_btn">
                <a href="" class="login_user_customer" id="be_a_customer">Be a customer</a>
                <a href="" class="login_user_worker" id="be_a_worker">Be a worker</a>
            </div>
        </div>
    </div>
</body>
<script src="../js/login.js"></script>

</html>