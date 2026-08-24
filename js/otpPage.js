import { AddText } from "./addText.js";
// import { Toast } from "../../utils/toast.js";

export const HandleOtp = () => {
    const container = document.getElementById("otp-container");
    const submitOtpButton = document.getElementById("submit_otp");
    if (!container) return;

    const params = new URLSearchParams(window.location.search);
    const inputs = document.querySelectorAll(".passcode-digit");
    const expires_on = params.get("expires_on");
    const request_id = params.get("request_id");
    const email = params.get("email");
    const expiresTime = new Date(Number(expires_on) * 1000);

    const timer = setInterval(() => {
        const isActive = updateCountdown(expiresTime);
        if (!isActive) {
            clearInterval(timer);
        }
    }, 1000);

    AddText("#requestIdOnText", request_id);
    AddText("#emailReadOnly", email);
    updateCountdown(expiresTime);
    handleInputChange(inputs);

    submitOtpButton.addEventListener("click", async () => {
        const passcode = [...inputs].map((input) => input.value).join("");
        if (passcode.length == 6) {
            try {
                // Toast("Please wait ...", "Success");
                let otpData = new FormData();
                otpData.append("action", "otp_verification");
                otpData.append("otp_code", passcode);

                let res = await fetch(`https://proposal.test/api/auth.php`, {
                    method: "POST",
                    body: otpData,
                });
                let data = await res.json();
                if (!data.error) {
                    console.log(data);
                    // Toast(data.message, "Success");
                } else {
                    // Toast(data.message, "Error");
                    console.log(data);
                }
            } catch (error) {
                // Toast("Something went wrong", "Error");
                console.log(error);
            }
        } else {
            // Toast("Enter the code", "Error");
        }
    });
};
function handleInputChange(inputs) {
    inputs.forEach((input, index) => {
        // Select old value when clicking/focusing an input
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
        // Toast("OTP Expired", "Error");
        setTimeout(() => {
            // window.location.href = `https://proposal.test/pages/signup.php?page_title=Customer`;
        }, 1000);
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
