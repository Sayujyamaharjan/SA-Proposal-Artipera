<?php

function completionEmailTemplate($props)
{
    $name = $props['name'];
    $code = $props['passcode'];


    return "
   <!DOCTYPE html>
    <html>

    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Booking Completion Verification</title>
    </head>

    <body style='margin:0; padding:0; background:#f4f7f5; font-family:Arial, sans-serif;'>

        <div style='max-width:600px; margin:40px auto; background:white;  border-radius:15px; overflow:hidden; box-shadow:0 4px 15px rgba(0,0,0,0.08);'>
            <!-- Header -->
   <div style='background:#ffffff; padding:15px 30px; text-align:left;'>
    <div style='display:flex; align-items:center;'>
        <div style='width:42px; height:42px; background-color:#a4e063; border-radius:12px; color:#ffffff;  font-size:21px; font-weight:bold; line-height:42px; text-align:center;'>
            A
        </div>
        <div style='padding-left:10px; color:#111111; font-size:20px; font-weight:bold; line-height:42px;'>
            Artipera
        </div>
    </div>
    </div>

            <!-- Content -->
            <div style='padding:25px;'>
                <h2 style='color:#222; '>
                    Booking Completion Verification
                </h2>
                <p style='color:#555; font-size:15px;'>
                    Hello <strong>{$name}</strong>,
                </p>
                <p style='color:#555; font-size:15px; line-height:1.6;'>
                    Your handyman has marked your booking as completed.
                    Please provide the verification code below to the
                    handyman to confirm the completion of the work.
                </p>
                <!-- OTP -->
                <div style='text-align:center; margin:30px 0;'>
                    <p style='color:#777; margin-bottom:10px;'>
                        Your verification code
                    </p>
                    <div style='display:inline-block; background:#f4faed; border:2px solid #a4e063; border-radius:10px; padding:18px 30px;'>
                        <span style='font-size:32px;font-weight:bold; letter-spacing:8px;  color:#a4e063;'>
                            {$code}
                        </span>
                    </div>
                </div>
                <p style='color:#777; font-size:13px; line-height:1.5;'>
                    This verification code is valid for 2 minutes and can only be used once.
                </p>
            </div>
            <!-- Footer -->
            <div style='background:#f4f7f5; padding:20px; text-align:center;'>
                <p style='margin:0; color:#888; font-size:12px;'>
                    © ARTIPERA — Handyman Service Booking
                </p>
            </div>
        </div>
    </body>
    </html>
    ";
}