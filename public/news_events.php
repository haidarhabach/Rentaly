<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rentaly</title>
    <link rel="icon" href="../assets/img/icon.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
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

/* Force navbar background */
        .navbar {
            background-color: #121212;
        }

        /* Ensure nav links are white */
        .navbar .nav-link {
            color: #ffffff !important;
        }

        /* Hover effect (green) */
        .navbar .nav-link:hover {
            color: rgba(12, 233, 56, 0.867) !important;
        }

        /* Fix left side alignment */
        .topbar-left {
            display: flex;
            align-items: center;
            gap: 20px;
            /* spacing between items */
        }

        .topbar-left .topbar-widget {
            display: flex;
            align-items: center;
        }

        /* Fix right side social icons */
        .topbar-right {
            display: flex;
            justify-content: flex-end;
        }

        .topbar-right .social-icons {
            display: flex;
            gap: 15px;
        }

        .topbar-right .social-icons a {
            color: white;
        }

        .login-section,
        .navbar {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)),
                url('../assets/img/2.jpg') center/cover no-repeat fixed;
        }
        /* Fix right side social icons */
        .topbar-right {
            display: flex;
            justify-content: flex-end;
        }

        .topbar-right .social-icons {
            display: flex;
            gap: 15px;
            margin-top: 12px;
        }

        .topbar-right .social-icons a {
            color: white;
        }
 /* Hero Section */
        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), 
                        url('../assets/img/2.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            color: white;
            padding: 120px 0 60px;
        }
        
        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
        }
        
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
        }
        
        /* Vehicle Details Section */
        .vehicle-section {
            padding: 60px 0;
        }
        
        /* Car Images */
        .main-car-image {
            width: 100%;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: var(--shadow);
            margin-bottom: 20px;
        }
        
        .main-car-image img {
            width: 100%;
            height: 400px;
            object-fit: cover;
            transition: var(--transition);
        }
        
        .main-car-image:hover img {
            transform: scale(1.02);
        }
        
        .car-thumbnails {
            display: flex;
            gap: 15px;
            overflow-x: auto;
            padding-bottom: 10px;
        }
        
        .car-thumbnail {
            width: 120px;
            height: 80px;
            border-radius: 8px;
            overflow: hidden;
            cursor: pointer;
            border: 2px solid transparent;
            transition: var(--transition);
            flex-shrink: 0;
        }
        
        .car-thumbnail.active {
            border-color: var(--primary-color);
        }
        
        .car-thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .car-thumbnail:hover {
            transform: translateY(-5px);
        }
        
        /* Vehicle Info */
        .vehicle-info h2 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 600;
            font-size: 2.2rem;
            margin-bottom: 15px;
            color: var(--text-dark);
        }
        
        .vehicle-description {
            color: var(--text-dark);
            font-size: 1.0rem;
            margin-bottom: 30px;
        }
        
        .specifications-title {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 20px;
            color: var(--text-dark);
            position: relative;
            display: inline-block;
        }
        
        .specifications-title:after {
            content: '';
            position: absolute;
            width: 50px;
            height: 3px;
            background: var(--primary-color);
            bottom: -8px;
            left: 0;
            border-radius: 2px;
        }
        
        .spec-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 30px;
        }
        
        .spec-item {
            display: flex;
            justify-content: space-between;
            padding: 7px 15px;
            background: var(--bg-light);
            border-radius: 8px;
            border-left: 4px solid var(--primary-color);
        }
        
        .spec-label {
            font-weight: 500;
            color: var(--text-dark);
        }
        
        .spec-value {
            font-weight: 600;
            color: var(--primary-color);
        }
        
        .features-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .features-list li {
            padding: 7px 0;
            color: var(--text-dark);
            position: relative;
            padding-left: 25px;
        }
        
        .features-list li:before {
            content: '✓';
            position: absolute;
            left: 0;
            color: var(--primary-color);
            font-weight: bold;
        }
        
        /* Booking Box */
        .booking-box {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: var(--shadow);
            margin-bottom: 30px;
        }
        
        .price-display {
            text-align: center;
            padding: 25px;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: var(--dark-color);
            border-radius: 12px;
            margin-bottom: 30px;
        }
        
        .price-label {
            font-size: 1.1rem;
            margin-bottom: 10px;
            opacity: 0.9;
        }
        
        .price-amount {
            font-size: 3rem;
            font-weight: 700;
            line-height: 1;
        }
        
        .booking-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 25px;
            color: var(--text-dark);
        }
        
        .form-label {
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--text-dark);
        }
        
        .form-control, .form-select {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 12px 15px;
            font-size: 0.9rem;
            transition: var(--transition);
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(46, 204, 113, 0.2);
        }
        
        .date-time-group {
            display: flex;
            gap: 10px;
        }
        
        .date-time-group .form-control {
            flex: 1;
        }
        
        .date-time-group .form-select {
            flex: 0 0 120px;
        }
        
        .btn-book {
            background: var(--primary-color);
            color: white;
            padding: 15px 30px;
            font-size: 1.1rem;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            transition: var(--transition);
            width: 100%;
            margin-top: 20px;
        }
        
        .btn-book:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(46, 204, 113, 0.3);
        }
        /* Footer Section */
        .footer-main {
            background-color: #121212;
            color: white;
            padding: 80px 0 0;
        }
        
        .footer-widget h5 {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 25px;
            color: white;
            position: relative;
            display: inline-block;
        }
        
        .footer-widget h5:after {
            content: '';
            position: absolute;
            width: 40px;
            height: 3px;
            background: var(--primary-color);
            bottom: -10px;
            left: 0;
            border-radius: 2px;
        }
        
        .footer-widget p {
            color: #aaa;
            font-size: 0.95rem;
            line-height: 1.8;
        }
        
        .contact-info {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .contact-info li {
            display: flex;
            align-items: flex-start;
            margin-bottom: 20px;
            color: #aaa;
            font-size: 0.95rem;
        }
        
        .contact-info i {
            color: var(--primary-color);
            font-size: 1.1rem;
            margin-right: 15px;
            min-width: 20px;
            margin-top: 2px;
        }
        
        .contact-info a {
            color: #aaa;
            text-decoration: none;
            transition: var(--transition);
        }
        
        .contact-info a:hover {
            color: var(--primary-color);
        }
        
        .quick-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .quick-links li {
            margin-bottom: 12px;
        }
        
        .quick-links a {
            color: #aaa;
            text-decoration: none;
            font-size: 0.95rem;
            transition: var(--transition);
            display: inline-block;
            position: relative;
            padding-left: 0;
        }
        
        .quick-links a:hover {
            color: var(--primary-color);
            padding-left: 10px;
        }
        
        .quick-links a:before {
            content: '→';
            position: absolute;
            left: -15px;
            opacity: 0;
            transition: var(--transition);
        }
        
        .quick-links a:hover:before {
            left: 0;
            opacity: 1;
        }
        
        .social-icons1 {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }
        
        .social-icons1 a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 45px;
            height: 45px;
            background-color: #2a2a2a;
            color: white;
            border-radius: 50%;
            font-size: 1.2rem;
            text-decoration: none;
            transition: var(--transition);
        }
        
        .social-icons1 a:hover {
            background-color: var(--primary-color);
            transform: translateY(-5px);
            color: white;
        }
        
        
        
        /* Back to Top Button */
        .back-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            background-color: var(--primary-color);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            opacity: 0;
            visibility: hidden;
            transition: var(--transition);
            z-index: 1000;
            text-decoration: none;
        }
        
        .back-to-top.show {
            opacity: 1;
            visibility: visible;
        }
        
        .back-to-top:hover {
            background-color: white;
            color: var(--primary-color);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(46, 204, 113, 0.3);
        }
        
        /* Responsive */
        @media (max-width: 992px) {
            .marquee-item {
                font-size: 1.5rem;
                gap: 20px;
            }
            
            .marquee-dot {
                width: 10px;
                height: 10px;
            }
            
            .footer-widget {
                margin-bottom: 40px;
            }
            
            .subfooter-content {
                flex-direction: column;
                text-align: center;
                gap: 15px;
            }
            
            .subfooter-links {
                justify-content: center;
            }
        }
        
        @media (max-width: 768px) {
            .marquee-section {
                padding: 40px 0;
            }
            
            .marquee-item {
                font-size: 1.3rem;
                gap: 15px;
            }
            
            .marquee-dot {
                width: 8px;
                height: 8px;
            }
            
            .marquee-overlay-left, .marquee-overlay-right {
                width: 80px;
            }
            
            .footer-main {
                padding: 60px 0 0;
            }
            
            .social-icons {
                gap: 10px;
            }
            
            .social-icons a {
                width: 40px;
                height: 40px;
                font-size: 1.1rem;
            }
        }
        
        @media (max-width: 576px) {
            .marquee-item {
                font-size: 1.1rem;
                gap: 10px;
            }
            
            .marquee-dot {
                width: 6px;
                height: 6px;
            }
            
            .marquee-container {
                gap: 30px;
            }
            
            .back-to-top {
                width: 45px;
                height: 45px;
                bottom: 20px;
                right: 20px;
            }
        }
        
        /* Animation */
        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        .fadeInRight {
            animation: fadeInRight 0.8s ease forwards;
        }
        
        /* Pause marquee on hover */
        .marquee-wrapper:hover .marquee-container {
            animation-play-state: paused;
        }
        
        /* Smooth marquee effect */
        .marquee-container {
            will-change: transform;
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
                    <img src="../assets/img/logo-light.png" alt="Rentaly">
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
    <section class="hero-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h1 class="hero-title">Vehicle Fleet</h1>
                </div>
            </div>
        </div>
    </section>

    <!-- Vehicle Details -->
<section class="vehicle-section">
    <div class="container">
        <div class="row g-4">
            <!-- Column 1: Main Car Image -->
            <div class="col-lg-5">
                <div class="main-car-image">
                    <img id="mainCarImage" src="../assets/img/CArs/bmw-m5.jpg" alt="BMW M2 2020">
                </div>
            </div>

            <!-- Column 2: Vehicle Info -->
            <div class="col-lg-4">
                <div class="vehicle-info">
                    <h2>BMW M2 2020</h2>
                    <p class="vehicle-description">
                        The BMW M2 is the high-performance version of the 2 Series 2-door coupé. 
                        The first generation of the M2 is the F87 coupé and is powered by turbocharged 
                        engines delivering exceptional performance and precision handling.
                    </p>

                    <h3 class="specifications-title">Specifications</h3>
                    <div class="spec-grid">
                        <div class="spec-item"><span class="spec-label">Body Type</span><span class="spec-value">Sedan</span></div>
                        <div class="spec-item"><span class="spec-label">Seats</span><span class="spec-value">2 seats</span></div>
                        <div class="spec-item"><span class="spec-label">Doors</span><span class="spec-value">2 doors</span></div>
                        <div class="spec-item"><span class="spec-label">Luggage</span><span class="spec-value">150L</span></div>
                        <div class="spec-item"><span class="spec-label">Fuel Type</span><span class="spec-value">Hybrid</span></div>
                        <div class="spec-item"><span class="spec-label">Engine</span><span class="spec-value">3000cc</span></div>
                        <div class="spec-item"><span class="spec-label">Year</span><span class="spec-value">2020</span></div>
                        <div class="spec-item"><span class="spec-label">Mileage</span><span class="spec-value">200mi</span></div>
                        <div class="spec-item"><span class="spec-label">Transmission</span><span class="spec-value">Automatic</span></div>
                        <div class="spec-item"><span class="spec-label">Fuel Economy</span><span class="spec-value">18.5 MPG</span></div>
                        <div class="spec-item"><span class="spec-label">Exterior Color</span><span class="spec-value">Blue Metallic</span></div>
                        <div class="spec-item"><span class="spec-label">Interior Color</span><span class="spec-value">Black</span></div>
                    </div>

                    <h3 class="specifications-title">Features</h3>
                    <ul class="features-list">
                        <li>Bluetooth Connectivity</li>
                        
                        <li>Central Locking System</li>
                        <li>Leather Seats</li>
                        <li>Navigation System</li>
                        
                    </ul>
                </div>
            </div>

            <!-- Column 3: Booking -->
            <div class="col-lg-3">
                <div class="booking-box fade-in">
                    

                    <div id="bookingForm">
                        <div class="price-display">
                            <div class="price-label">Daily Rate</div>
                            <div class="price-amount">$265</div>
                        </div>

                        <h3 class="booking-title">Book This Car</h3>

                        <form id="vehicleBookingForm">
                            <div class="mb-3">
                                <label class="form-label">Pick Up Location</label>
                                <input type="text" class="form-control" placeholder="Enter pickup location" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Drop Off Location</label>
                                <input type="text" class="form-control" placeholder="Enter dropoff location" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Pick Up Date & Time</label>
                                <div class="date-time-group">
                                    <input type="date" class="form-control" required>
                                    <select class="form-select">
                                        <option value="08:00">08:00 AM</option>
                                        <option value="09:00">09:00 AM</option>
                                        <option value="10:00">10:00 AM</option>
                                        <option value="11:00">11:00 AM</option>
                                        <option value="12:00">12:00 PM</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Return Date & Time</label>
                                <div class="date-time-group">
                                    <input type="date" class="form-control" required>
                                    <select class="form-select">
                                        <option value="16:00">04:00 PM</option>
                                        <option value="17:00">05:00 PM</option>
                                        <option value="18:00">06:00 PM</option>
                                        <option value="19:00">07:00 PM</option>
                                        <option value="20:00">08:00 PM</option>
                                    </select>
                                </div>
                            </div>

                            <button type="submit" class="btn-book"><i class="fas fa-calendar-check me-2"></i> Book Now</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer Section -->
    <footer class="footer-main">
        <div class="container">
            <div class="row g-4">
                <!-- About Column -->
                <div class="col-lg-3 col-md-6">
                    <div class="footer-widget">
                        <h5>About Rentaly</h5>
                        <p>Where quality meets affordability. We understand the importance of a smooth and enjoyable journey without the burden of excessive costs. That's why we have meticulously crafted our offerings to provide you with top-notch vehicles at minimum expense.</p>
                    </div>
                </div>
                
                <!-- Contact Info Column -->
                <div class="col-lg-3 col-md-6">
                    <div class="footer-widget">
                        <h5>Contact Info</h5>
                        <ul class="contact-info">
                            <li>
                                <i class="fas fa-map-marker-alt"></i>
                                <span>08 W 36th St, New York, NY 10001</span>
                            </li>
                            <li>
                                <i class="fas fa-phone"></i>
                                <span>+1 333 9296</span>
                            </li>
                            <li>
                                <i class="fas fa-envelope"></i>
                                <a href="mailto:contact@example.com">contact@rentaly.com</a>
                            </li>
                            
                        </ul>
                    </div>
                </div>

                <!-- Quick Links Column -->
                <div class="col-lg-3 col-md-6">
                    <div class="footer-widget">
                        <h5>Quick Links</h5>
                        <ul class="quick-links">
                            <li><a href="#">Blog</a></li>
                            <li><a href="#">News</a></li>
                            <li><a href="#">Booking</a></li>
                            <li><a href="#">Fleet</a></li>
                            <li><a href="#">Contact</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Social Network Column -->
                <div class="col-lg-3 col-md-6">
                    <div class="footer-widget">
                        <h5>Social Network</h5>
                        <p>Follow us on social media to stay updated with our latest offers and news.</p>
                        <div class="social-icons1">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#"><i class="fab fa-pinterest-p"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        

    <!-- Back to Top Button -->
    <a href="#" class="back-to-top" id="back-to-top">
        <i class="fas fa-arrow-up"></i>
    </a>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Back to Top Button
        const backToTopButton = document.getElementById('back-to-top');

        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
                backToTopButton.classList.add('show');
            } else {
                backToTopButton.classList.remove('show');
            }
        });

        backToTopButton.addEventListener('click', (e) => {
            e.preventDefault();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    </script>
</body>
</html>
