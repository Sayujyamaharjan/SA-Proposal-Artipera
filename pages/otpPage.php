<?php
include '../php/authGuard.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artipera - Verify OTP</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            background: #f6f8f3;
            font-family: Arial, Helvetica, sans-serif;

            display: flex;
            justify-content: center;
            align-items: center;
        }

        .otp-box {
            width: 420px;
            background: white;
            border: 1px solid #e3eadc;
            border-radius: 14px;
            padding: 30px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.06);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 9px;
            margin-bottom: 28px;
        }

        .brand-logo {
            width: 34px;
            height: 34px;
            border-radius: 9px;
            background: #a4e063;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-weight: bold;
            font-size: 17px;
        }

        .brand-name {
            font-size: 17px;
            font-weight: bold;
            color: #111;
        }

        .label {
            color: #a35a2e;
            font-size: 10px;
            font-weight: bold;
            letter-spacing: 2px;
            margin-bottom: 9px;
        }

        /* h1 {
            margin: 0;
            font-size: 24px;
            color: #111;
        }

        h1 span {
            color: #91cf55;
        } */

        .description {
            margin: 10px 0 24px;
            color: #73786f;
            font-size: 13px;
            line-height: 20px;
        }

        #emailReadOnly {
            color: #7bb847;
            font-weight: 600;
        }

        .otp-title {
            color: #555b51;
            font-size: 10px;
            font-weight: bold;
            letter-spacing: 1.5px;
            margin-bottom: 10px;
        }

        .passcode-container {
            display: flex;
            justify-content: center;
            gap: 8px;
        }

        .passcode-digit {
            width: 48px;
            height: 52px;
            border: 1px solid #d7e2ce;
            border-radius: 8px;
            background: #fbfcfa;
            text-align: center;
            font-size: 21px;
            font-weight: bold;
            color: #222;
            outline: none;
        }

        .passcode-digit:focus {
            border: 2px solid #a4e063;
            background: #ffffff;
        }

        .otp-info {
            display: flex;
            justify-content: space-between;

            margin-top: 12px;

            color: #8a9085;
            font-size: 10px;
        }

        .otp-info span {
            color: #444;
            font-weight: 600;
        }

        .buttons {
            display: flex;
            gap: 9px;
            margin-top: 22px;
        }

        .buttons button {
            flex: 1;
            height: 43px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: bold;
            cursor: pointer;
        }

        .resend-btn {
            border: 1px solid #dce5d7;
            background: white;
            color: #596052;
        }

        .submit-btn {
            border: none;
            background: #a4e063;
            color: white;
        }

        .submit-btn:hover {
            background: #91cf55;
        }

        .security-notice {
            margin-top: 18px;
            padding: 11px 13px;
            background: #f7faf4;
            border-left: 3px solid #a4e063;
            color: #777d73;
            font-size: 10px;
            line-height: 16px;
        }

        .security-notice strong {
            color: #444;
        }

        #otp-container {

            input[type="number"]::-webkit-inner-spin-button,
            input[type="number"]::-webkit-outer-spin-button {
                -webkit-appearance: none;
                margin: 0;
            }
        }


        @media (max-width: 480px) {

            body {
                padding: 15px;
            }

            .otp-box {
                width: 100%;
                padding: 24px 20px;
            }

            .passcode-container {
                gap: 5px;
            }

            .passcode-digit {
                width: 43px;
                height: 50px;
            }

            .otp-info {
                flex-direction: column;
                gap: 4px;
            }
        }
    </style>
</head>

<body>

    <section class="otp-box" id="otp-container">
        <div class="brand">
            <div class="brand-logo"> A </div>
            <div class="brand-name">Artipera</div>
        </div>
        <div class="label"> ONE TIME PASSWORD</div>
        <!-- <h1>
            Confirm it's <span>really you</span>
        </h1> -->
        <p class="description">
            Enter the code sent to
            <span id="emailReadOnly"></span>.
            The code is valid for 2 minutes.
        </p>
        <div class="otp-title"> ENTER CODE </div>
        <div class="passcode-container" id="passcode-container">
            <input type="number" class="passcode-digit" maxlength="1">
            <input type="number" class="passcode-digit" maxlength="1">
            <input type="number" class="passcode-digit" maxlength="1">
            <input type="number" class="passcode-digit" maxlength="1">
            <input type="number" class="passcode-digit" maxlength="1">
            <input type="number" class="passcode-digit" maxlength="1">
        </div>
        <div class="otp-info">
            <div>Expires in
                <span id="expiresOnText"></span>
            </div>
            <div>Request ID -
                <span id="requestIdOnText"></span>
            </div>
        </div>
        <div class="buttons">
            <button type="button" class="resend-btn"> Resend Code </button>
            <button type="button" id="submit_otp" class="submit-btn"> Submit Code </button>
        </div>
    </section>
    <script type="module" src="../js/otpPage.js"></script>
</body>

</html>