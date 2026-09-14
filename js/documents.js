const BASEURL = "https://proposal.test/";
const documentForm = document.getElementById("document-verification-form");

documentForm.addEventListener("submit", (e) => {
    e.preventDefault();

    const documentFormData = new FormData(documentForm);
    documentFormData.append("action", "add_document");
    const data = Object.fromEntries(documentFormData.entries());
    console.log(data);
    let error = false;
    for (const [key, value] of documentFormData.entries()) {
        if (value instanceof File) {
            if (value.size === 0) {
                error = true;
            }
            continue;
        }

        if (!value?.toString().trim()) {
            error = true;
        }
    }

    console.log(data);
    if (error) {
        // Toast("Don't leave any fields empty.", "Error");
        return;
    }

    const xhr = new XMLHttpRequest();

    xhr.open("POST", `${BASEURL}api/document.php`, true);
    xhr.onload = function () {
        if (xhr.status >= 200 && xhr.status < 300) {
            try {
                const response = JSON.parse(xhr.responseText);
                console.log("Parsed response:", response);

                if (response.success) {
                    Toast("Documents submitted successfully.", "Success");
                } else {
                    Toast(response.message || "Something went wrong.", "Error");
                }
            } catch (err) {
                console.error("JSON Parse Error:", err);
                console.error("Raw response:", xhr.responseText);

                Toast("Invalid server response.", "Error");
            }
        } else {
            console.error("HTTP Error:", xhr.status);
            console.error("Server response:", xhr.responseText);

            Toast(`Server error: ${xhr.status}`, "Error");
        }
    };

    xhr.onerror = function () {
        console.error("Network Error");
        Toast("Unable to connect to the server.", "Error");
    };

    xhr.send(documentFormData);
});

function Toast(a, b) {
    console.log(a);
    console.log(b);
}
