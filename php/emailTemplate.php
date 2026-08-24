<?php
function emailTemplate($props)
{
    $code = $props['passcode'];
    $expiresOn = $props['expiresOn'];
    $requestId = $props['requestId'];
    ob_start();
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Artipera OTP Verification</title>
    </head>

    <body style="margin:0;padding:0;   background-color:#f4f7f2;font-family:Arial, Helvetica, sans-serif; color:#222222; ">
        <table width="100%" cellpadding="0" cellspacing="0" border="0"
            style="background-color:#f4f7f2; width:100%; margin:0; padding:35px 15px;">
            <tr>
                <td align="center">
                    <table width="600" cellpadding="0" cellspacing="0" border="0"
                        style="width:100%;max-width:600px;background-color:#ffffff; border-radius:18px;overflow:hidden; box-shadow:0 4px 20px rgba(0,0,0,0.06);">
                        <tr>
                            <td align="center" style="padding:30px 30px 24px 30px;">

                                <table cellpadding="0" cellspacing="0" border="0">
                                    <tr>

                                        <td width="42" height="42" align="center" valign="middle"
                                            style="width:42px;  height:42px;  background-color:#a4e063; border-radius:12px;  color:#ffffff; font-size:21px; font-weight:bold;">
                                            A
                                        </td>
                                        <td style=" padding-left:10px; color:#111111;  font-size:20px;font-weight:bold; ">
                                            Artipera
                                        </td>

                                    </tr>
                                </table>

                            </td>
                        </tr>
                        <tr>
                            <td style=" height:4px;background-color:#a4e063; font-size:0; line-height:0;"></td>
                        </tr>

                        <tr>
                            <td align="center" style="padding:40px 35px 35px 35px;">

                                <div
                                    style=" color:#7a7a7a;font-size:12px; font-weight:bold;  letter-spacing:2px;  text-transform:uppercase;">
                                    Account Verification
                                </div>

                                <div
                                    style=" margin-top:12px;color:#151515; font-size:24px;line-height:32px;font-weight:bold;">
                                    Verify your email
                                </div>
                                <div style=" margin-top:12px;color:#6b7280; font-size:14px;line-height:22px;">
                                    Use the verification code below to continu with your Artipera account.
                                </div>
                                <table width="100%" cellpadding="0" cellspacing="0" border="0"
                                    style="margin-top:30px;    background-color:#f7faf5;    border:1px solid #e2ecd9;  border-radius:14px; ">
                                    <tr>
                                        <td align="center" style="padding:24px 15px 10px 15px;">
                                            <div
                                                style=" color:#6b7280; font-size:11px; font-weight:bold; letter-spacing:2px;">
                                                YOUR VERIFICATION CODE
                                            </div>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center" style="padding:8px 10px 25px 10px;">

                                            <table cellpadding="0" cellspacing="0" border="0">
                                                <tr>
                                                    <td align="center" style="
                                                            width:45px;
                                                            height:52px;
                                                            background-color:#ffffff;
                                                            border:1px solid #dfe7d9;
                                                            border-radius:9px;
                                                            color:#222222;
                                                            font-size:24px;
                                                            font-weight:bold;
                                                        ">
                                                        <?php echo htmlspecialchars($code[0]); ?>
                                                    </td>
                                                    <td width="7"></td>
                                                    <td align="center" style="
                                                            width:45px;
                                                            height:52px;
                                                            background-color:#ffffff;
                                                            border:1px solid #dfe7d9;
                                                            border-radius:9px;
                                                            color:#222222;
                                                            font-size:24px;
                                                            font-weight:bold;
                                                        ">
                                                        <?php echo htmlspecialchars($code[1]); ?>
                                                    </td>
                                                    <td width="7"></td>
                                                    <td align="center" style="
                                                            width:45px;
                                                            height:52px;
                                                            background-color:#ffffff;
                                                            border:1px solid #dfe7d9;
                                                            border-radius:9px;
                                                            color:#222222;
                                                            font-size:24px;
                                                            font-weight:bold;
                                                        ">
                                                        <?php echo htmlspecialchars($code[2]); ?>
                                                    </td>
                                                    <td width="7"></td>
                                                    <td align="center" style="
                                                            width:45px;
                                                            height:52px;
                                                            background-color:#ffffff;
                                                            border:1px solid #dfe7d9;
                                                            border-radius:9px;
                                                            color:#222222;
                                                            font-size:24px;
                                                            font-weight:bold;
                                                        ">
                                                        <?php echo htmlspecialchars($code[3]); ?>
                                                    </td>
                                                    <td width="7"></td>
                                                    <td align="center" style="
                                                            width:45px;
                                                            height:52px;
                                                            background-color:#ffffff;
                                                            border:1px solid #dfe7d9;
                                                            border-radius:9px;
                                                            color:#222222;
                                                            font-size:24px;
                                                            font-weight:bold;
                                                        ">
                                                        <?php echo htmlspecialchars($code[4]); ?>
                                                    </td>
                                                    <td width="7"></td>
                                                    <td align="center" style="
                                                            width:45px;
                                                            height:52px;
                                                            background-color:#ffffff;
                                                            border:1px solid #dfe7d9;
                                                            border-radius:9px;
                                                            color:#222222;
                                                            font-size:24px;
                                                            font-weight:bold;
                                                        ">
                                                        <?php echo htmlspecialchars($code[5]); ?>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>

                                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-top:20px;">
                                    <tr>
                                        <td align="center" style="color:#777777;font-size:12px;line-height:18px; ">
                                            This code is valid for
                                            <strong style="color:#333333;">2 minutes</strong>
                                            and can only be used once.
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                        <tr>
                            <td align="center"
                                style="padding:20px 25px;background-color:#fafafa;border-top:1px solid #eeeeee;">
                                <div style="color:#999999;font-size:11px;line-height:18px;">
                                    © Artipera — Handyman Service Booking Platform
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>

    </html>
    <?php
    return ob_get_clean();
}