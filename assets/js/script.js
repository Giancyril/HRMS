$(document).ready(function () {
    $("#sendOtpLink").on("click", function () {
        var emailInput = $("#email").val();
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        // Check if the entered email is valid
        if (!emailRegex.test(emailInput)) {
            Swal.fire({
                icon: "error",
                title: "Invalid Email",
                text: "Please enter a valid email address",
            });
            return;
        }
        // Disable the link to prevent multiple clicks
        var sendOtpLink = $("#sendOtpLink");
        sendOtpLink.css("pointer-events", "none");
        $("#email").prop("disabled", true);
        $("#loadingOverlay").css("display", "flex");

        // Make an AJAX request to a PHP file to send OTP
        $.ajax({
            url: "endpoint/api.php",
            type: "POST",
            data: {
                action: "sendotp",
                email: emailInput,
            },
            success: function (response) {
                $("#otp-div").removeClass("hidden");
                $("#otp").prop("disabled", false);
                $("#loadingOverlay").css("display", "none");
                sendOtpLink.html("Sent!").addClass("text-green-500");
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error("AJAX Error:", textStatus, errorThrown);
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "An error occurred while processing your request",
                });

                // Re-enable the "Send OTP" link and email input on error
                sendOtpLink.css("pointer-events", "auto");
                $("#email").prop("disabled", false);
                $("#loadingOverlay").css("display", "none");
            },
        });
    });

    $("#verifyOtp").on("click", function () {
        var enteredOTP = $("#otp").val();
        var enteredEmail = $("#email").val();

        $("#loadingOverlay").css("display", "flex");
        // Make an AJAX request to verify OTP and log in
        $.ajax({
            url: "endpoint/api.php",
            type: "POST",
            data: {
                action: "verifyotp", // Corrected action name to "verifyotp"
                otp: enteredOTP,
                email: enteredEmail,
            },
            success: function (response) {
                $("#loadingOverlay").css("display", "none");
                if (response === "OTP Verified") {
                    $("#verifyOtp").html("Verified!").addClass("text-green-500");
                    $("#verifyOtp").off("click");
                    $("#otp").prop("disabled", true);

                    Swal.fire({
                        icon: "success",
                        title: "OTP Verified",
                        text: "You can now proceed to log in.",
                        showConfirmButton: true,
                    }).then(function () {
                        // You might want to automatically trigger the login
                        // or enable the login button here.
                        // For now, let's just show a message.
                        $("#loginBtn").prop("disabled", false); // Enable the "LOG IN" button
                        Swal.fire('Info', 'Please click the "LOG IN" button to continue.', 'info');
                    });
                } else if (response === "OTP Expired") {
                    Swal.fire({
                        icon: "error",
                        title: "Expired OTP",
                        text: "Please resend new OTP.",
                    });
                    $("#sendOtpLink").css("pointer-events", "auto").html("Send OTP");
                    $("#email").prop("disabled", false);
                    $("#otp").val("");
                    $("#otp-div").addClass("hidden");
                    $("#otp").prop("disabled", true);
                } else if (response === "Invalid OTP or Email") {
                    Swal.fire({
                        icon: "error",
                        title: "Invalid OTP",
                        text: "Please enter the correct OTP.",
                    });
                    $("#otp").val("");
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "An unexpected error occurred: " + response,
                    });
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error("AJAX Error:", textStatus, errorThrown);
                $("#loadingOverlay").css("display", "none");
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "An error occurred while processing your request",
                });
            },
        });
    });

    $("#loginBtn").on("click", function (e) {
        e.preventDefault();
        const email = $('#email').val();
        const password = $('#password').val(); // Assuming you have a password input with ID 'password'

        if (!email) {
            Swal.fire('Error', 'Please enter your email!', 'warning');
            return;
        }

        if (!password) {
            Swal.fire('Error', 'Please enter your password!', 'warning');
            return;
        }

        $.ajax({
            url: 'endpoint/api.php',
            type: 'POST',
            data: {
                action: "login",
                email: email,
                password: password
            },
            success: function (res) {
                if (res === 'login_success') {
                    Swal.fire('Logged In', 'Welcome!', 'success').then(() => {
                        window.location.href = 'homepage.php';
                    });
                } else {
                    Swal.fire('Error', res, 'error');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error("AJAX Error:", textStatus, errorThrown);
                Swal.fire('Error', 'An error occurred during login.', 'error');
            }
        });
    });

    $('#logout').click(function (e) {
        e.preventDefault();

        $.ajax({
            type: 'POST',
            url: 'endpoint/api.php',
            data: { action: "logout" },
            success: function (response) {
                window.location.href = 'login.php';
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error('AJAX Error:', textStatus, errorThrown);
                Swal.fire('Error', 'An error occurred during logout.', 'error');
            }
        });
    });
});