<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rentaly - Login</title>
    <link rel="icon" href="../assets/img/icon.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">

    <style>
        /* Force navbar background */
.navbar {
    background-color: #121212 ;
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
    gap: 20px; /* spacing between items */
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

.login-section,.navbar{
    background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)),
                url('../assets/img/2.jpg') center/cover no-repeat fixed;
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
    <header class="Loginheader">
        <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
            <div class="container">
                <a class="navbar-brand" href="index.html">
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

    <!-- Login Section -->
    <section class="login-section">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-5 col-md-7">
                    <div class="login-box animated">
                        <h4>Login to Your Account</h4>
                        <form id="form_register" method="post" action="account-dashboard.html">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" required />
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required />
                                
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="rememberMe">
                                <label class="form-check-label" for="rememberMe">Remember me</label>
                            </div>
                            <div class="mb-4 signin-buttons">
    <button type="submit" class="btn-signin btn-customer w-100">
        <i class="fas fa-user me-2"></i> Sign In as Customer
    </button>

    <button type="submit" class="btn-signin btn-employee w-100 mt-3">
        <i class="fas fa-briefcase me-2"></i> Sign In as Employee
    </button>
</div>

                        </form>
                        
                        
                        
                        <div class="additional-links text-center">
                            <span>Don't have an account? <a href="register.php" class="fw-bold">Sign up now</a></span>
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
