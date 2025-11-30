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

/* Increase spacing inside whole card */
.de-item .d-info {
    padding: 28px 26px !important;
}

/* Space between title and attributes */
.de-item .d-text h4 {
    margin-bottom: 20px !important;
}

/* Space between attributes and the pricing area */
.de-item .d-atr-group {
    margin-bottom: 26px !important;
}

/* Price section: push it down and add separation */
.de-item .d-price {
    padding-top: 20px !important;
    margin-top: 10px !important;
    border-top: 1px solid #e6e6e6 !important;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

/* Add space between price number and button */
.de-item .d-price .btn-main {
    margin-left: 18px !important;
}
/* Add spacing between each car attribute */
.d-atr-group {
    display: flex;
    flex-wrap: wrap;
    gap: 14px 22px !important; /* vertical , horizontal */
}

.d-atr {
    padding: 6px 12px;
    background: #f7f7f7;
    border-radius: 10px;
    font-size: 14px;
    border: 1px solid #e6e6e6;
}
.de-item {
    border: 1px solid #e6e6e6 !important;
    border-radius: 20px !important;
    overflow: hidden;
}
/* Make carousel arrows clearly visible */
#vehicleCarousel .carousel-control-prev-icon,
#vehicleCarousel .carousel-control-next-icon {
    background-color: rgba(0,0,0,0.75);   /* solid dark */
    padding: 20px;                        /* bigger icon size */
    border-radius: 50%;
    background-size: 60% 60%;
}

#vehicleCarousel .carousel-control-prev,
#vehicleCarousel .carousel-control-next {
    width: 7%;  /* make arrow area wider */
}
#section-img-with-tab {
            background-color: var(--bg-light);
            position: relative;
            overflow: hidden;
        }
        
        .image-container {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            width: 50%;
            background-image: url('https://images.unsplash.com/photo-1486496572940-2bb2341fdbdf?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=80');
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
        }
        
        .content-wrapper {
            position: relative;
            z-index: 2;
            background-color: white;
            padding: 60px;
            border-radius: 12px;
            box-shadow: var(--shadow);
        }
        
        h2 {
            font-weight: 700;
            font-size: 2.5rem;
            margin-bottom: 20px;
            position: relative;
        }
        
        h2:after {
            content: '';
            position: absolute;
            width: 70px;
            height: 4px;
            background: var(--primary-color);
            bottom: -15px;
            left: 0;
            border-radius: 2px;
        }
        
        .spacer-20 {
            height: 20px;
        }
        
        .nav-pills {
            border-bottom: 1px solid #eee;
            margin-bottom: 30px;
        }
        
        .nav-pills .nav-link {
            background: none;
            color: var(--text-dark);
            font-weight: 500;
            padding: 12px 25px;
            margin-right: 10px;
            border-radius: 6px;
            transition: var(--transition);
        }
        
        .nav-pills .nav-link:hover {
            background-color: rgba(46, 204, 113, 0.1);
            color: var(--primary-dark);
        }
        
        .nav-pills .nav-link.active {
            background-color: var(--primary-color);
            color: white;
            box-shadow: 0 4px 15px rgba(46, 204, 113, 0.3);
        }
        
        .tab-content {
            font-size: 1.1rem;
            padding: 50px;
        }
        
        .tab-pane {
            padding: 10px 0;
        }
        
        .de-icon {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 20px;
            display: inline-block;
            background: rgba(46, 204, 113, 0.1);
            width: 80px;
            height: 80px;
            line-height: 80px;
            text-align: center;
            border-radius: 50%;
            transition: var(--transition);
        }
        
        .de-icon:hover {
            transform: translateY(-5px);
            background: rgba(46, 204, 113, 0.2);
        }
        
        h4 {
            font-weight: 600;
            margin-bottom: 15px;
            font-size: 1.4rem;
        }
        
        .mb20 {
            margin-bottom: 20px;
        }
        
        .mb30 {
            margin-bottom: 30px;
        }
        
        /* Animation for tab content */
        .tab-pane.fade {
            transition: opacity 0.3s ease-in-out;
        }
        
        .tab-pane.fade.show.active {
            animation: fadeIn 0.5s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Responsive adjustments */
        @media (max-width: 992px) {
            .image-container {
                position: relative;
                width: 100%;
                height: 400px;
            }
            
            .content-wrapper {
                margin-top: 30px;
            }
            
            h2 {
                font-size: 2rem;
            }
        }
        
        @media (max-width: 768px) {
            .content-wrapper {
                padding: 40px 30px;
            }
            
            .nav-pills .nav-link {
                display: block;
                margin-bottom: 10px;
                text-align: center;
            }
        }

        :root {
    --primary-color: rgba(12, 233, 56, 0.867);
    --primary-light: rgba(12, 250, 56, 0.93);
    --text-dark: #222;
}

:root {
    --primary-color: rgba(12, 233, 56, 0.867);
    --primary-light: rgba(12, 250, 56, 0.93);
    --text-dark: #222;
}

/* GENERAL */
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    margin: 0;
    padding: 0;
}

/* HERO SECTION */
#hero-section {
    display: flex;
    flex-wrap: wrap;
    min-height: 80vh;
    align-items: stretch; /* Equal height */
    padding: 0;
}

/* LEFT COLUMN (IMAGE) */
.hero-image {
    flex: 1;
    min-width: 300px;
    background-image: url('../assets/img/5.jpg');
    background-size: cover;
    background-position: center;
}

/* RIGHT COLUMN (TEXT) */
.hero-text {
    flex: 1;
    min-width: 300px;
    background-color: #f5f5f5;
    padding: 60px 40px;
    border-radius: 0; /* no rounded corners */
    color: var(--text-dark);
    display: flex;
    flex-direction: column;
    justify-content: center;
}

/* HEADINGS */
.hero-text h2 {
    font-weight: 700;
    font-size: 2.5rem;
    margin-bottom: 20px;
    position: relative;
}

.hero-text h2::after {
    content: '';
    position: absolute;
    width: 70px;
    height: 4px;
    background: var(--primary-color);
    bottom: -10px;
    left: 0;
    border-radius: 2px;
}

.nav-pills .nav-link {
    background: none;
    color: var(--text-dark);
    font-weight: 500;
    margin-right: 10px;
    border-radius: 6px;
    transition: all 0.3s ease;
}

.nav-pills .nav-link.active {
    background-color: var(--primary-color);
    color: #fff;
}

/* SERVICES SECTION */
#services-section {
    padding: 80px 50px;
    background-color: #f9f9f9;
}

#services-section h2 {
    font-weight: 700;
    font-size: 2rem;
    margin-bottom: 30px;
}

.de-icon {
    font-size: 2.5rem;
    color: var(--primary-color);
    margin-bottom: 20px;
    display: inline-block;
    background: rgba(12, 233, 56, 0.1);
    width: 80px;
    height: 80px;
    line-height: 80px;
    text-align: center;
    border-radius: 50%;
    transition: 0.3s ease;
}

.de-icon:hover {
    transform: translateY(-5px);
    background: rgba(12, 233, 56, 0.2);
}

#services-section h4 {
    font-weight: 600;
    margin-bottom: 15px;
}

#services-section p {
    font-size: 0.95rem;
    line-height: 1.6;
}

/* RESPONSIVE */
@media (max-width: 992px) {
    #hero-section {
        flex-direction: column-reverse; /* text first on mobile */
    }
    .hero-image, .hero-text {
        min-height: 300px;
    }
    .hero-text {
        padding: 40px 20px;
    }
}
.hero-text, 
.hero-text h2,
.hero-text p,
.hero-text .nav-pills .nav-link {
    color: #222 !important;
}

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
                <a class="navbar-brand" href="index.php">
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

    <section id="section-cars" class="no-top py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 offset-lg-2 text-center mb-5">
                    <div class="section-title">
                        <h2>Our Vehicle Fleet</h2>
                        <p>Driving your dreams to reality with an exquisite fleet of versatile vehicles for unforgettable journeys.</p>
                    </div>
                    <div class="spacer-20"></div>
                </div>

                <div class="clearfix"></div>

                <!-- Bootstrap Carousel -->
                <div id="vehicleCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <!-- Carousel Item 1 -->
                        <div class="carousel-item active">
                            <div class="row justify-content-center">
                                <div class="col-md-4 mb-4 fade-in">
                                    <div class="de-item mb30">
                                        <div class="d-img">
                                            <img src="../assets/img/Cars/jeep-renegade.jpg" class="img-fluid" alt="Jeep Renegade">
                        
                                            
                                        </div>
                                        <div class="d-info">
                                            <div class="d-text">
                                                <h4 class="car-title">Jeep Renegade</h4>
                                                <div class="d-atr-group">
                                                    <span class="d-atr"><i class="fas fa-user"></i>5 Seats</span>
                                                    <span class="d-atr"><i class="fas fa-suitcase"></i>2 Bags</span>
                                                    <span class="d-atr"><i class="fas fa-door-closed"></i>4 Doors</span>
                                                    <span class="d-atr"><i class="fas fa-car"></i>SUV</span>
                                                </div>
                                                <div class="d-price">
                                                    Daily rate from <span>$265</span>
                                                    <a class="btn-main" href="car-single.html">Rent Now</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-4 fade-in">
                                    <div class="de-item mb30">
                                        <div class="d-img">
                                            <img src="../assets/img/Cars/bmw-m5.jpg" class="img-fluid" alt="BMW M2">
                                            
                                            
                                        </div>
                                        <div class="d-info">
                                            <div class="d-text">
                                                <h4 class="car-title">BMW M2</h4>
                                                <div class="d-atr-group">
                                                    <span class="d-atr"><i class="fas fa-user"></i>5 Seats</span>
                                                    <span class="d-atr"><i class="fas fa-suitcase"></i>2 Bags</span>
                                                    <span class="d-atr"><i class="fas fa-door-closed"></i>4 Doors</span>
                                                    <span class="d-atr"><i class="fas fa-car"></i>Sedan</span>
                                                </div>
                                                <div class="d-price">
                                                    Daily rate from <span>$244</span>
                                                    <a class="btn-main" href="car-single.html">Rent Now</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-4 fade-in">
                                    <div class="de-item mb30">
                                        <div class="d-img">
                                            <img src="../assets/img/Cars/ferrari-enzo.jpg" class="img-fluid" alt="Ferrari Enzo">
                                            
                                        
                                        </div>
                                        <div class="d-info">
                                            <div class="d-text">
                                                <h4 class="car-title">Ferrari Enzo</h4>
                                                <div class="d-atr-group">
                                                    <span class="d-atr"><i class="fas fa-user"></i>2 Seats</span>
                                                    <span class="d-atr"><i class="fas fa-suitcase"></i>1 Bag</span>
                                                    <span class="d-atr"><i class="fas fa-door-closed"></i>2 Doors</span>
                                                    <span class="d-atr"><i class="fas fa-car"></i>Sports</span>
                                                </div>
                                                <div class="d-price">
                                                    Daily rate from <span>$167</span>
                                                    <a class="btn-main" href="car-single.html">Rent Now</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Carousel Item 2 -->
                        <div class="carousel-item">
                            <div class="row justify-content-center">
                                <div class="col-md-4 mb-4 fade-in">
                                    <div class="de-item mb30">
                                        <div class="d-img">
                                            <img src="../assets/img/Cars/ford-raptor.jpg" class="img-fluid" alt="Ford Raptor">
                                            
                                            
                                        </div>
                                        <div class="d-info">
                                            <div class="d-text">
                                                <h4 class="car-title">Ford Raptor</h4>
                                                <div class="d-atr-group">
                                                    <span class="d-atr"><i class="fas fa-user"></i>5 Seats</span>
                                                    <span class="d-atr"><i class="fas fa-suitcase"></i>3 Bags</span>
                                                    <span class="d-atr"><i class="fas fa-door-closed"></i>4 Doors</span>
                                                    <span class="d-atr"><i class="fas fa-car"></i>Truck</span>
                                                </div>
                                                <div class="d-price">
                                                    Daily rate from <span>$147</span>
                                                    <a class="btn-main" href="car-single.html">Rent Now</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-4 fade-in">
                                    <div class="de-item mb30">
                                        <div class="d-img">
                                            <img src="../assets/img/Cars/mini-cooper.jpg" class="img-fluid" alt="Mini Cooper">
                                            
                                            
                                        </div>
                                        <div class="d-info">
                                            <div class="d-text">
                                                <h4 class="car-title">Mini Cooper</h4>
                                                <div class="d-atr-group">
                                                    <span class="d-atr"><i class="fas fa-user"></i>4 Seats</span>
                                                    <span class="d-atr"><i class="fas fa-suitcase"></i>2 Bags</span>
                                                    <span class="d-atr"><i class="fas fa-door-closed"></i>2 Doors</span>
                                                    <span class="d-atr"><i class="fas fa-car"></i>Hatchback</span>
                                                </div>
                                                <div class="d-price">
                                                    Daily rate from <span>$238</span>
                                                    <a class="btn-main" href="car-single.html">Rent Now</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-4 fade-in">
                                    <div class="de-item mb30">
                                        <div class="d-img">
                                            <img src="../assets/img/Cars/vw-polo.jpg" class="img-fluid" alt="VW Polo">
                                            
                                            
                                        </div>
                                        <div class="d-info">
                                            <div class="d-text">
                                                <h4>VW Polo</h4>
                                                <div class="d-atr-group">
                                                    <span class="d-atr"><i class="fas fa-user"></i>5 Seats</span>
                                                    <span class="d-atr"><i class="fas fa-suitcase"></i>2 Bags</span>
                                                    <span class="d-atr"><i class="fas fa-door-closed"></i>4 Doors</span>
                                                    <span class="d-atr"><i class="fas fa-car"></i>Hatchback</span>
                                                </div>
                                                <div class="d-price">
                                                    Daily rate from <span>$106</span>
                                                    <a class="btn-main" href="car-single.html">Rent Now</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Carousel Controls -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#vehicleCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#vehicleCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                    
                    <!-- Carousel Indicators -->
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#vehicleCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#vehicleCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Image with Tabs Section -->
    <section id="hero-section">
    <div class="hero-image"></div>
    <div class="hero-text">
        <h2>Only Quality For Clients</h2>
        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#luxury" type="button">Luxury</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#comfort" type="button">Comfort</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#prestige" type="button">Prestige</button>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="luxury">
                <p>We offer a meticulously curated collection of the most sought-after luxury vehicles on the market. Whether you prefer the sporty allure of a high-performance sports car, the sophistication of a sleek and luxurious sedan, or the versatility of a premium SUV, we have the perfect car to match your discerning taste.</p>
            </div>
            <div class="tab-pane fade" id="comfort">
                <p>We prioritize your comfort and convenience throughout your journey. We understand that a comfortable ride can make a world of difference, whether you're embarking on a business trip or enjoying a leisurely vacation. That's why we offer a wide range of well-maintained, comfortable cars that cater to your specific needs.</p>
            </div>
            <div class="tab-pane fade" id="prestige">
                <p>We understand that prestige goes beyond luxury. It's about making a statement, embracing sophistication, and indulging in the finer things in life. That's why we offer an exclusive selection of prestigious cars that exude elegance, style, and status.</p>
            </div>
        </div>
    </div>
</section>

<!-- SERVICES SECTION -->
<section id="services-section">
    <div class="container">
        <div class="row align-items-start">
            <div class="col-lg-3">
                <h2>Explore the world with comfortable car</h2>
            </div>
            <div class="col-md-3 text-center text-md-start mb-4 mb-md-0">
                <i class="fa fa-trophy de-icon"></i>
                <h4>First Class Services</h4>
                <p>Luxury meets exceptional care, creating unforgettable moments and exceeding your expectations.</p>
            </div>
            <div class="col-md-3 text-center text-md-start mb-4 mb-md-0">
                <i class="fa fa-road de-icon"></i>
                <h4>24/7 Road Assistance</h4>
                <p>Reliable support when you need it most, keeping you on the move with confidence.</p>
            </div>
            <div class="col-md-3 text-center text-md-start">
                <i class="fa fa-map-pin de-icon"></i>
                <h4>Free Pick-Up & Drop-Off</h4>
                <p>Enjoy free pickup and drop-off services, adding ease to your car rental experience.</p>
            </div>
        </div>
    </div>
</section>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Add animation to carousel items
        document.addEventListener('DOMContentLoaded', function() {
            const carousel = document.getElementById('vehicleCarousel');
            
            carousel.addEventListener('slide.bs.carousel', function(e) {
                const items = e.relatedTarget.querySelectorAll('.fade-in');
                items.forEach(item => {
                    item.style.animation = 'none';
                    setTimeout(() => {
                        item.style.animation = 'fadeIn 0.8s ease-in';
                    }, 50);
                });
            });
        });
    </script>
</body>

</html>
