<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="tailwind.config.js"></script>
    <link rel="stylesheet" href="css/custom.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body>
<section class="bg-[#007FFF]">
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
        <div class="w-full bg-white rounded-lg shadow dark:border sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white text-center">
                    Welcome Back!
                </h1>

                <form class="space-y-4 md:space-y-6" id="login-form" method="post">
                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your Email</label>
                        <div class="relative">
                            <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="you@gmail.com" required>
                            <a href="#" id="sendLoginOtp" class="absolute top-1/4 right-6 text-sm text-blue-500">Send OTP</a>
                        </div>
                    </div>

                    <div id="otp-div" class="hidden">
                        <label for="otp" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Enter OTP</label>
                        <input type="text" name="otp" id="otp" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Enter OTP" minlength="6" maxlength="6" pattern="\d{6}" required>
                    </div>

                    <button type="submit" class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600">Login</button>

                    <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                        Don’t have an account yet?
                        <a href="register.php" class="font-medium text-primary-600 hover:underline dark:text-primary-500">Sign up</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $('#sendLoginOtp').click(function (e) {
        e.preventDefault();
        const email = $('#email').val();

        if (!email) {
            return Swal.fire('Error', 'Please enter your email first.', 'warning');
        }

        $.post('send_login_otp.php', { email: email }, function (res) {
            if (res === 'success') {
                $('#otp-div').show();
                Swal.fire('Success', 'OTP sent to your email.', 'success');
            } else {
                Swal.fire('Error', res, 'error');
            }
        });
    });

    $('#login-form').submit(function (e) {
        e.preventDefault();
        const email = $('#email').val();
        const otp = $('#otp').val();

        $.post('verify_login_otp.php', { email: email, otp: otp }, function (res) {
            if (res === 'success') {
                Swal.fire('Logged In', 'Welcome!', 'success').then(() => {
                    window.location.href = 'login.php';
                });
            } else {
                Swal.fire('Error', res, 'error');
            }
        });
    });
</script>

<script src="js/script.js"></script>
</body>
</html>