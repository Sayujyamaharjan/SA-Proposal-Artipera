import { AddText } from "./addText.js";

export const HandleOtp = () => {
    const container = document.getElementById("otp-container");
    const submitOtpButton = document.getElementById("submit_otp");

    if (!container) return;

    const params = new URLSearchParams(window.location.search);

    const inputs = document.querySelectorAll(".passcode-digit");

    const expires_on = params.get("expires_on");
    const request_id = params.get("request_id");
    const email = params.get("email");
    const resent = params.get("resent");

    const expiresTime = new Date(Number(expires_on) * 1000);

    AddText("#requestIdOnText", request_id);
    AddText("#emailReadOnly", email);

    // Show resend success message
    if (resent === "1") {
        Swal.fire({
            title: "OTP Sent",
            text: "A new OTP has been sent to your email.",
            icon: "success",
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 2500,
            timerProgressBar: true,
        });

        // Remove resent=1 from URL
        window.history.replaceState(
            {},
            document.title,
            `otpPage.php?expires_on=${expires_on}&request_id=${request_id}&email=${encodeURIComponent(email)}`,
        );
    }

    // Start countdown
    updateCountdown(expiresTime);

    const timer = setInterval(() => {
        const isActive = updateCountdown(expiresTime);

        if (!isActive) {
            clearInterval(timer);
        }
    }, 1000);

    handleInputChange(inputs);

    submitOtpButton.addEventListener("click", async () => {
        const passcode = [...inputs].map((input) => input.value).join("");

        if (passcode.length === 6) {
            try {
                Swal.fire({
                    title: "Please wait...",
                    text: "Verifying your OTP",
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    },
                });

                let otpData = new FormData();

                otpData.append("action", "otp_verification");
                otpData.append("otp_code", passcode);

                let res = await fetch("https://proposal.test/api/auth.php", {
                    method: "POST",
                    body: otpData,
                });

                let data = await res.json();

                Swal.close();

                if (!data.error) {
                    Swal.fire({
                        title: "Account Created Successfully",
                        text: "Your account has been created successfully.",
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: false,
                        allowOutsideClick: false,
                    });
                    setTimeout(() => {
                        window.location.href = "login.php";
                    }, 2000);
                } else {
                    Swal.fire({
                        title: "Verification Failed",
                        text: data.message,
                        confirmButtonText: "OK",
                    });

                    console.log(data);
                }
            } catch (error) {
                Swal.close();
                Swal.fire({
                    title: "Something went wrong",
                    text: "Please try again.",
                    confirmButtonText: "OK",
                });
                console.log(error);
            }
        } else {
            Swal.fire({
                title: "Invalid OTP",
                text: "Please enter the 6-digit code.",
                confirmButtonText: "OK",
            });
        }
    });
};
function handleInputChange(inputs) {
    inputs.forEach((input, index) => {
        input.addEventListener("focus", () => {
            input.select();
        });
        input.addEventListener("input", () => {
            input.value = input.value.replace(/[^0-9]/g, "").slice(0, 1);
            if (input.value) {
                const nextInput = inputs[index + 1];
                if (nextInput) {
                    nextInput.focus();
                }
            }
        });
        input.addEventListener("keydown", (event) => {
            if (event.key === "Backspace") {
                if (input.value) {
                    input.value = "";
                    return;
                }
                const previousInput = inputs[index - 1];
                if (previousInput) {
                    previousInput.value = "";
                    previousInput.focus();
                }
            }
        });
    });
}
function updateCountdown(expiresTime) {
    const now = new Date();
    const difference = expiresTime.getTime() - now.getTime();
    if (difference <= 0) {
        AddText("#expiresOnText", "Expired");
        return false;
    }
    const totalSeconds = Math.floor(difference / 1000);
    const minutesLeft = Math.floor(totalSeconds / 60);
    const secondsLeft = totalSeconds % 60;
    AddText(
        "#expiresOnText",
        `${minutesLeft}:${String(secondsLeft).padStart(2, "0")}`,
    );
    return true;
}
HandleOtp();
