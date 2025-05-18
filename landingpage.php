<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Responsive Landing Page using HTML, CSS & Javascript</title>

    <link rel="stylesheet" href="assets/css/styles.css" />

    <link
        href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css"
        rel="stylesheet"
    />

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
</head>
<body>
    <header class="container header">
        <nav class="nav">
            <div class="logo">
                <h2>Optima HR.</h2>
            </div>

            <div class="nav_menu" id="nav_menu">
                <button class="close_btn" id="close_btn">
                    <i class="ri-close-fill"></i>
                </button>

                <ul class="nav_menu_list">
                    <li class="nav_menu_item">
                        <a href="#" class="nav_menu_link">My Profile</a>
                    </li>
                    <li class="nav_menu_item">
                        <a href="#" class="nav_menu_link">Why Choose Us</a>
                    </li>
                    <li class="nav_menu_item">
                        <a href="#" class="nav_menu_link">Features</a>
                    </li>
                    <li class="nav_menu_item">
                        <a href="#" class="nav_menu_link">Contact Us</a>
                    </li>
                </ul>
            </div>

            <button class="toggle_btn" id="toggle_btn">
                <i class="ri-menu-line"></i>
            </button>
        </nav>
    </header>

    <section class="wrapper">
        <div class="container">
            <div class="grid-cols-2">
                <div class="grid-item-1">
                    <h1 class="main-heading">
                        Welcome to <span>Optima HR.</span>
                        <br />
                        <div class="empowering-text">Empowering Your People.</div>
                    </h1>
                    <p class="info-text">
                        A comprehensive HR management platform designed for efficiency and growth.
                    </p>

                    <div class="btn_wrapper">
                        <button class="btn view_more_btn">
                            Learn More <i class="ri-arrow-right-line"></i>
                        </button>

                        <button class="btn documentation_btn">Get Started</button>
                    </div>
                </div>
                <div class="grid-item-2">
                    <div class="team_img_wrapper">
                        <img src="assets/images/team.svg" alt="team-img" />
                    </div>
                </div>
            </div>
        </div>
    </section>

    
    <footer></footer>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.8.0/gsap.min.js"></script>
    <script src="assets/script.js" defer></script>
</body>
</html>