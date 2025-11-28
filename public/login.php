<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rentaly</title>
    <link rel="icon" href="../assets/img/icon.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
:root {
    --primary-color: rgba(12, 233, 56, 0.867);
    --primary-light: rgba(12, 250, 56, 0.93);
    --dark-color: #121212;
    --light-color: #ffffff;
    --text-light: #ffffff;
    --text-dark: #000000;
    --title-font: 'Arial', sans-serif;
    --transition: all 0.3s ease;
}

/* Base Styles */
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    line-height: 1.6;
    background-color: var(--light-color);
    overflow-x: hidden;
    margin: 0;
    padding: 0;
}

/* Topbar */
.topbar-dark {
    background-color: var(--dark-color);
    color: var(--text-light);
    padding: 8px 0;
    font-size: 14px;
}

.topbar-left {
    display: flex;
    align-items: center;
    gap: 20px; /* spacing between left items */
}

.topbar-left a {
    display: flex;
    align-items: center;
    color: var(--text-light);
    text-decoration: none;
    gap: 5px; /* space between icon and text */
    transition: var(--transition);
}

.topbar-left a .fa {
    color: var(--primary-color); /* green icons */
}

.topbar-left a:hover {
    color: var(--primary-light);
}

.topbar-left a:hover .fa {
    color: var(--primary-light);
}

/* Right side social icons */
.topbar-right {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 10px;
}

.social-icons .fa-lg {
  font-size: 16px;
  color: var(--text-light);
  padding: 10px;
  border-radius: 4px;
  transition: var(--transition);
}

.social-icons .fa-lg:hover {
  color: var(--primary-color);
  background: rgba(255, 255, 255, 0.1);
  transform: translateY(-2px);
}


/* Header & Navbar */
header.indexheader {
    background-color: transparent !important;
    box-shadow: none;
    position: absolute;
    width: 100%;
    z-index: 10;
}

.navbar {
    padding: 10px 0;
    background: transparent !important;
}

.navbar-brand img {
    height: 40px;
    transition: var(--transition);
}

.navbar-brand:hover img {
    transform: scale(1.05);
}

.navbar-light .navbar-nav .nav-link {
    color: #000000 !important; /* black links */
    font-weight: 500;
    padding: 0.5rem 1rem;
    transition: color 0.3s ease;
    position: relative;
}

.navbar-light .navbar-nav .nav-link:hover {
    color: #555555 !important;
}

.navbar-light .navbar-toggler {
    border-color: #000000;
    color: #000000;
}

.navbar-light .navbar-toggler-icon {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%280, 0, 0, 0.55%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
}

/* Hero Section */
#section-hero {
    min-height: 100vh;
    display: flex;
    align-items: center;
    color: #000000;
    background: linear-gradient(rgba(255,255,255,0.3), rgba(255,255,255,0.3)),
                url('../assets/img/7.jpg') no-repeat center/cover;
}

#section-hero .container .row {
    align-items: center;
}

#section-hero .col-lg-6:first-child {
    padding-right: 30px; /* space between text and image */
}

#section-hero h1, 
#section-hero p, 
#section-hero h4 {
    max-width: 95%;
}

#section-hero h4 {
    font-weight: 600;
    color: var(--primary-color);
}

@media (max-width: 991px) {
    #section-hero .col-lg-6:first-child {
        padding-right: 0;
        text-align: center;
        margin-bottom: 30px;
    }
}

/* Buttons */
.btn-main {
    display: inline-flex;
    justify-content: center;
    align-items: center;
    padding: 12px 30px;
    font-size: 15px;
    font-weight: 700;
    border-radius: 8px;
    border: none;
    color: var(--light-color);
    text-decoration: none;
    transition: var(--transition);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
    position: relative;
    overflow: hidden;
    background-color: var(--primary-color);
}

.btn-main:hover {
    background-color: var(--primary-light);
    transform: translateY(-2px);
    box-shadow: 0 8px 18px rgba(12, 233, 56, 0.4);
}

/* Spacing Utilities */
.spacer-10 { height: 10px; }
.spacer-double { height: 40px; }

</style>


</head>

<body>
    <!-- Topbar -->
    <div id="topbar" class="topbar-dark text-light">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="topbar-left xs-hide">
                        <div class="topbar-widget">
                            <a href="#"><i class="fa fa-phone"></i>+961 01 234 567</a>
                        </div>
                        <div class="topbar-widget">
                            <a href="#"><i class="fa fa-envelope"></i>contact@rentaly.com</a>
                        </div>
                        <div class="topbar-widget">
                            <a href="#"><i class="fa fa-clock"></i>Mon - Fri 08.00 - 18.00</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="topbar-right">
                        <div class="social-icons">
                            <a href="#"><i class="fab fa-facebook fa-lg"></i></a>
                            <a href="#"><i class="fab fa-twitter fa-lg"></i></a>
                            <a href="#"><i class="fab fa-youtube fa-lg"></i></a>
                            <a href="#"><i class="fab fa-pinterest fa-lg"></i></a>
                            <a href="#"><i class="fab fa-instagram fa-lg"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Header -->
    <header class="indexheader">
        <nav class="navbar navbar-expand-lg navbar-light sticky-top">
            <div class="container">
                <a class="navbar-brand" href="index.html">
                    <img src="../assets/img/logo.png" alt="Rentaly">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain"
                    aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarMain">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="cars.php">Cars</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="booking-form.php">Booking</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">My Account</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="news_events.php">News</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <div class="no-bottom no-top Hero" id="content">
        <div id="top"></div>
        <section id="section-hero" aria-label="section" class="full-height vertical-center">
            <div class="container">
                <div class="row align-items-center">
                    <div class="spacer-double sm-hide"></div>
                    <div class="col-lg-6">
                        <h4><span class="id-color">Plan your trip now</span></h4>
                        <div class="spacer-10"></div>
                        <h1>Explore the world with comfortable car</h1>
                        <p class="lead">Embark on unforgettable adventures and discover the world in unparalleled
                            comfort and style with our fleet of exceptionally comfortable cars.</p>
                        <a class="btn-main" href="#">Choose a Car</a>&nbsp;&nbsp;&nbsp;
                    </div>
                    <div class="col-lg-6">
                        <img src="../assets/img/car-2.png" class="img-fluid" alt="car">
                    </div>
                </div>
            </div>
        </section>
    </div>

</body>

</html>
