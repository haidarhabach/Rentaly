<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rentaly - Register</title>
    <link rel="icon" href="../assets/img/icon.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>

        :root {
            --primary-color: rgba(12, 233, 56, 0.867);
            --primary-light: rgba(12, 250, 56, 0.93);
            --title-font: 'Arial', sans-serif;
            --transition: all 0.3s ease;
        }
        
        body {
            background-color: #ffffff;
            line-height: 1.7em;
            overflow-x: hidden;
        }

        #topbar {
            background: #121212 !important;
            color: #ffffff;
            padding: 5px 0;
            font-size: 14px;
            transition: var(--transition);
        }

        .topbar-left,
        .topbar-right {
            display: flex;
        }

        .topbar-right {
            justify-content: flex-end;
        }

        .topbar-widget {
            display: flex;
            padding: 3px 15px;
            font-weight: 400;
            height: 46px;
            align-items: center;
            transition: var(--transition);
        }

        .topbar-widget a {
            color: #ffffff;
            text-decoration: none;
            transition: var(--transition);
        }

        .topbar-widget:first-child {
            padding-left: 0;
        }

        .topbar-widget i {
            font-size: 16px;
            margin-right: 10px;
            transition: var(--transition);
            color: rgba(12, 233, 56, 0.867);
        }

        .topbar-widget:hover i {
            color: rgba(12, 233, 56, 0.867);
            transform: scale(1.1);
        }

        .social-icons i {
            color: #fff;
            padding: 10px;
            font-size: 16px;
            transition: var(--transition);
            border-radius: 4px;
            margin-top: 12px;
        }

        .social-icons i:hover {
            color: rgba(12, 233, 56, 0.867);
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }

        /* Header Styles */
        header {
            width: 100%;
            position: static;
            
            margin: 0;
            transition: var(--transition);
        }

        .navbar {
            padding: 10px 0;
            transition: var(--transition);
        }

        .navbar-brand img {
            height: 40px;
            transition: var(--transition);
        }

        .navbar-brand:hover img {
            transform: scale(1.05);
        }

        .navbar-nav .nav-link {
            color: #ffffff !important;
            font-weight: 500;
            padding: 8px 15px;
            margin: 0 5px;
            border-radius: 5px;
            transition: var(--transition);
            position: relative;
        }

        .navbar-nav .nav-link:hover {
            color: rgba(12, 233, 56, 0.867);
        }

        .navbar-nav .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 15px;
            width: 0;
            height: 2px;
        }

        .navbar-nav .nav-link:hover::after {
            width: calc(100% - 30px);
        }

        .register-section {
            padding: 100px 0;
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)),
                url('../assets/img/2.jpg') center/cover no-repeat fixed;
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .register-section, .navbar {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)),
                        url('../assets/img/2.jpg') center/cover no-repeat fixed;
        }

        .register-box {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 15px 35px rgba(0, 19, 87, 0.1);
            padding: 30px;
            position: relative;
            z-index: 1;
            transform: translateY(0);
            overflow: hidden;
            max-width: 500px;
            width: 100%;
            transition: var(--transition);
        }

        .register-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 19, 87, 0.15);
        }

        .register-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 5px;
            height: 100%;
            background: var(--primary-color);
        }

        .register-box h4 {
            font-family: var(--title-font);
            font-weight: 600;
            color: rgba(12, 250, 56, 0.93);
            margin-bottom: 25px;
            position: relative;
            padding-bottom: 15px;
        }

        .register-box h4::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background: var(--primary-color);
            border-radius: 3px;
        }

        .form-control {
            border: 2px solid #eeeeee;
            background: rgba(0, 0, 0, .025);
            border-radius: 8px;
            padding: 12px 15px;
            margin-bottom: 20px;
            transition: var(--transition);
            font-size: 15px;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.9);
            box-shadow: 0 0 0 3px rgba(0, 146, 124, 0.1);
            border-color: rgba(12, 233, 56, 0.867);
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 8px;
            color: rgba(0, 0, 0, 0.7);
        }

        .btn-register {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            padding: 12px;
            font-size: 15px;
            font-weight: 700;
            border-radius: 8px;
            border: none;
            color: #fff;
            transition: 0.25s ease;
            letter-spacing: 0.3px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
            width: 100%;
            margin-top: 10px;
        }

        .btn-customer {
            background: linear-gradient(135deg, #00c853, #00e676);
        }

        .btn-customer:hover {
            transform: translateY(-3px);
            background: linear-gradient(135deg, #00e676, #00c853);
            box-shadow: 0 8px 18px rgba(0, 200, 83, 0.4);
        }

        .btn-employee {
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7));
        }

        .btn-employee:hover {
            transform: translateY(-3px);
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7));
            box-shadow: 0 8px 18px rgba(12, 233, 56, 0.867);
        }

        .btn-register:hover i {
            transform: scale(1.15);
            transition: 0.2s;
        }

        .additional-links {
            margin-top: 25px;
        }

        .additional-links a {
            color: var(--primary-color);
            text-decoration: none;
            transition: var(--transition);
            font-weight: 500;
        }

        .additional-links a:hover {
            color: rgba(12, 250, 56, 0.93);
            text-decoration: underline;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animated {
            animation: fadeInUp 0.5s ease-out;
        }

        /* Responsive Styles */
        @media (max-width: 992px) {
            .navbar-collapse {
                background: #2b313f;
                padding: 15px;
                border-radius: 8px;
                margin-top: 10px;
            }

            .navbar-toggler {
                border: none;
                color: #fff;
                font-size: 1.5rem;
            }

            .navbar-toggler:focus {
                box-shadow: none;
            }

            .topbar-left,
            .topbar-widget:not(:first-child) {
                display: none;
            }

            .register-section {
                padding: 80px 0;
            }
        }

        @media (min-width: 993px) {
            #menu-btn {
                display: none;
            }
        }

        /* Force navbar background */


/* Ensure nav links are white */
.navbar .nav-link {
    color: #ffffff !important;
}

/* Hover effect (green) */
.navbar .nav-link:hover {
    color: rgba(12, 233, 56, 0.867) !important;
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
    <header class="Registerheader">
        <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
            <div class="container">
                <a class="navbar-brand" href="index.php">
                    <img src="../assets/img/logo-light.png" alt="Rentaly">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
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
                            <a class="nav-link" href="#">My Account</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="news_events.php">News</a>
                        </li>
                    </ul>
                    
                </div>
            </div>
        </nav>
    </header>

    <!-- Register Section -->
    <section class="register-section">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-6 col-md-8">
                    <div class="register-box animated">
                        <h4>Create Your Account</h4>
                        <form id="form_register" method="post" action="account-dashboard.html">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="firstName" class="form-label">First Name</label>
                                        <input type="text" name="firstName" id="firstName" class="form-control" placeholder="Enter your first name" required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="lastName" class="form-label">Last Name</label>
                                        <input type="text" name="lastName" id="lastName" class="form-control" placeholder="Enter your last name" required />
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" required />
                            </div>
                            
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" name="phone" id="phone" class="form-control" placeholder="Enter your phone number" required />
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" name="password" id="password" class="form-control" placeholder="Create a password" required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="confirmPassword" class="form-label">Confirm Password</label>
                                        <input type="password" name="confirmPassword" id="confirmPassword" class="form-control" placeholder="Confirm your password" required />
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" name="address" id="address" class="form-control" placeholder="Enter your address" />
                            </div>


                            <div class="mb-3">
                                <label for="address" class="form-label">Drive license</label>
                                <input type="text" name="license" id="license" class="form-control" placeholder="Enter your driver license id" />
                            </div>
                            
                            
                            
                            <div class="mb-4">
                                <button type="submit" class="btn-register btn-customer">
                                    <i class="fas fa-user-plus me-2"></i> Register as Customer
                                </button>
                                
                                <button type="submit" class="btn-register btn-employee mt-3">
                                    <i class="fas fa-briefcase me-2"></i> Register as Employee
                                </button>
                            </div>
                        </form>
                        
                        <div class="additional-links text-center">
                            <span>Already have an account? <a href="login.php" class="fw-bold">Sign in now</a></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Add animation to elements on scroll
        document.addEventListener('DOMContentLoaded', function() {
            const animatedElements = document.querySelectorAll('.animated');
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = 1;
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, { threshold: 0.1 });
            
            animatedElements.forEach(el => {
                el.style.opacity = 0;
                el.style.transform = 'translateY(20px)';
                el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                observer.observe(el);
            });
        });
    </script>
</body>
</html>

