<html>
<?php include('../includes/db.php'); ?>
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


      :root {
 
            --text-dark: #333;
            --text-light: #777;
            --bg-dark: #2c3e50;
            --bg-light: #f8f9fa;
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            --transition: all 0.3s ease;
        }
        
        
        
        /* News Section */
        #section-news {
            background-color: var(--bg-light);
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 50px;
        }
        
        .section-title h2 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 600;
            font-size: 2.5rem;
            position: relative;
            display: inline-block;
            margin-bottom: 20px;
        }
        
        .section-title h2:after {
            content: '';
            position: absolute;
            width: 80px;
            height: 4px;
            background: var(--primary-color);
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            border-radius: 2px;
        }
        
        .section-title p {
            color: var(--text-light);
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto;
        }
        
        .spacer-20 {
            height: 20px;
        }
        
        /* News Cards */
        .news-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: var(--transition);
            height: 100%;
        }
        
        .news-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
        }
        
        .news-image {
            position: relative;
            overflow: hidden;
            height: 250px;
        }
        
        .news-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition);
        }
        
        .news-card:hover .news-image img {
            transform: scale(1.05);
        }
        
        .date-box {
            position: absolute;
            top: 20px;
            left: 20px;
            background: var(--primary-color);
            color: white;
            width: 60px;
            height: 60px;
            border-radius: 8px;
            text-align: center;
            padding: 10px 0;
            z-index: 2;
        }
        
        .date-box .m {
            font-size: 1.5rem;
            font-weight: 700;
            line-height: 1;
        }
        
        .date-box .d {
            font-size: 0.9rem;
            font-weight: 500;
            line-height: 1;
        }
        
        .news-content {
            padding: 30px;
        }
        
        .news-content h4 {
            font-weight: 600;
            font-size: 1.4rem;
            margin-bottom: 15px;
        }
        
        .news-content h4 a {
            color: var(--text-dark);
            text-decoration: none;
            transition: var(--transition);
        }
        
        .news-content h4 a:hover {
            color: var(--primary-color);
        }
        
        .news-content p {
            color: var(--text-light);
            margin-bottom: 20px;
        }
        
        .btn-main {
            background-color: var(--primary-color);
            color: white;
            padding: 10px 25px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 500;
            display: inline-block;
            transition: var(--transition);
            border: none;
        }
        
        .btn-main:hover {
            background-color: var(--primary-color);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(46, 204, 113, 0.3);
        }
        
        /* Fun Facts Section */
        #section-fun-facts {
            background-color: var(--primary-color);
            color: var(--text-dark);
            padding: 60px 20px;
            margin-top: 30px;
        }
        
        .stats-container {
            text-align: center;
        }
        
        .stat-item {
            padding: 20px 10px;
            transition: var(--transition);
            background-color: white;
            border-radius: 15px;
            
        }
        
        .stat-item:hover {
            transform: translateY(-5px);
        }
        
        .stat-number {
            font-family: 'Montserrat', sans-serif;
            font-size: 3.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 10px;
            line-height: 1;
            justify-self: center;
        }
        
        .stat-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 1px;
            justify-self: center;
        }
        
        .stat-description {
            color: gray
            font-size: 0.95rem;
            max-width: 250px;
            margin: 0 auto;
            text-align: center;
        }
        
        /* Animation for counters */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .fadeInUp {
            animation: fadeInUp 0.6s ease forwards;
        }
        
        /* Responsive */
        @media (max-width: 992px) {
            .section-title h2 {
                font-size: 2rem;
            }
            
            .stat-number {
                font-size: 3rem;
            }
            
            .news-image {
                height: 220px;
            }
        }
        
        @media (max-width: 768px) {
            section {
                padding: 60px 0;
            }
            
            .section-title h2 {
                font-size: 1.8rem;
            }
            
            .stat-number {
                font-size: 2.5rem;
            }
            
            .news-content {
                padding: 20px;
            }
        }
        
        @media (max-width: 576px) {
            .section-title h2 {
                font-size: 1.6rem;
            }
            
            .section-title p {
                font-size: 1rem;
            }
            
            .stat-number {
                font-size: 2rem;
            }
            
            .stat-item {
                padding: 20px 15px;
            }
        }
        
        .mb10 {
            margin-bottom: 30px;
        }
        /* Marquee Section - Single Line */
        .marquee-section {
            background-color: var(--text-dark);
            color: white;
            padding: 50px 0;
            overflow: hidden;
            position: relative;
        }
        
        .marquee-wrapper {
            position: relative;
            width: 100%;
            overflow: hidden;
            padding: 20px 0;
        }
        
        .marquee-container {
            display: flex;
            width: fit-content;
            animation: marquee 40s linear infinite;
            white-space: nowrap;
            gap: 50px;
            align-items: center;
            padding: 10px 0;
        }
        
        .marquee-item {
            display: flex;
            align-items: center;
            gap: 25px;
            font-size: 2.4rem;
            font-weight: 600;
            color: var(--primary-color);
            transition: var(--transition);
            text-transform: uppercase;
            letter-spacing: 1px;
            font-family: 'Montserrat', sans-serif;
        }
        
        .marquee-item:hover {
            color: var(--primary-color);
            transform: scale(1.08);
        }
        
        .marquee-dot {
            display: inline-block;
            width: 12px;
            height: 12px;
            background-color: var(--primary-color);
            border-radius: 50%;
            margin: 0 5px;
            animation: pulse 2s infinite;
        }
        
        @keyframes marquee {
            0% {
                transform: translateX(0);
            }
            100% {
                transform: translateX(-50%);
            }
        }
        
        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
                opacity: 1;
            }
            50% {
                transform: scale(1.3);
                opacity: 0.8;
            }
        }
        
        .marquee-overlay-left, .marquee-overlay-right {
            position: absolute;
            top: 0;
            bottom: 0;
            width: 150px;
            z-index: 2;
            pointer-events: none;
        }
        
        .marquee-overlay-left {
            left: 0;
            background: linear-gradient(90deg, var(--text-dark), transparent);
        }
        
        .marquee-overlay-right {
            right: 0;
            background: linear-gradient(90deg, transparent, var(--text-dark));
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
<!-- begin of backend -1-  -->
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
<!-- backend hasan -->
                <!-- Bootstrap Carousel -->
            <!-- NOTE NOTE ANA 3AMEL L available_cars AS VIEW LKEL STATUS = AVAILABLE -->
<div id="vehicleCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <?php
        $stmt = $connect->prepare("SELECT MODEL,c.CARNAME, Seats, bags, Doors, car_type, daily_price, URL 
                                FROM car AS c, car_photos AS cp , available_cars as a 
                                WHERE c.CARID = cp.CARID
                                and a.CARID=c.CARID;
                                ");
        $stmt->execute();
        $result = $stmt->get_result();

        $count = 0;
        $active_set = false;
        echo '<div class="carousel-item '.($active_set ? '' : 'active').'"><div class="row">';
        while($row = $result->fetch_assoc()) {
            if($count > 0 && $count % 3 == 0) { 
                echo '</div></div>';
                echo '<div class="carousel-item"><div class="row">'; 
            }
            ?>
            <div class="col-md-4 mb-4">
                <div class="de-item <?= $row['MODEL'] ?>">
                    <div class="d-img">
                        <img src="../assets/img/Cars/<?= $row['URL'] ?>" class="img-fluid" alt="<?= $row['CARNAME'] ?>">
                    </div>
                    <div class="d-info">
                        <div class="d-text">
                            <h4 class="car-title"><?= $row['CARNAME'] ?></h4>
                            <div class="d-atr-group">
                                <span class="d-atr"><i class="fas fa-user"></i> <?= $row['Seats'] ?></span>
                                <span class="d-atr"><i class="fas fa-suitcase"></i> <?= $row['bags'] ?></span>
                                <span class="d-atr"><i class="fas fa-door-closed"></i> <?= $row['Doors'] ?></span>
                                <span class="d-atr"><i class="fas fa-car"></i> <?= $row['car_type'] ?></span>
                            </div>
                            <div class="d-price">
                                Daily rate from <span> <?= $row['daily_price'] ?>$</span>
                                <a class="btn-main" href="car-single.html">Rent Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $count++;
            $active_set = true;
        }
        echo '</div></div>';
        ?>
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
<!-- end of backend -1- -->

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

    <!-- News Section -->
    <section id="section-news">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 offset-lg-3 text-center">
                    <div class="section-title">
                        <h2>Latest News</h2>
                        <p>Breaking news, fresh perspectives, and in-depth coverage - stay ahead with our latest news, insights, and analysis.</p>
                        <div class="spacer-20"></div>
                    </div>
                </div>
                
                <!-- News Card 1 -->
                <div class="col-lg-4 mb10">
                    <div class="news-card">
                        <div class="news-image">
                            <div class="date-box">
                                <div class="m">10</div>
                                <div class="d">MAR</div>
                            </div>
                            <img src="https://images.unsplash.com/photo-1488646953014-85cb44e25828?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Travel Experience">
                        </div>
                        <div class="news-content">
                            <h4><a href="news-single.html">Enjoy Best Travel Experience</a></h4>
                            <p>Discover how to make the most of your travels with our expert tips and insights for unforgettable experiences.</p>
                            <a class="btn-main" href="#">Read More</a>
                        </div>
                    </div>
                </div>
                
                <!-- News Card 2 -->
                <div class="col-lg-4 mb10">
                    <div class="news-card">
                        <div class="news-image">
                            <div class="date-box">
                                <div class="m">12</div>
                                <div class="d">MAR</div>
                            </div>
                            <img src="https://images.unsplash.com/photo-1553440569-bcc63803a83d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Car Rental Future">
                        </div>
                        <div class="news-content">
                            <h4><a href="news-single.html">The Future of Car Rental</a></h4>
                            <p>Explore the latest trends and innovations shaping the future of the car rental industry worldwide.</p>
                            <a class="btn-main" href="#">Read More</a>
                        </div>
                    </div>
                </div>
                
                <!-- News Card 3 -->
                <div class="col-lg-4 mb10">
                    <div class="news-card">
                        <div class="news-image">
                            <div class="date-box">
                                <div class="m">14</div>
                                <div class="d">MAR</div>
                            </div>
                            <img src="https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Holiday Tips">
                        </div>
                        <div class="news-content">
                            <h4><a href="news-single.html">Holiday Tips For Backpackers</a></h4>
                            <p>Essential tips and tricks for backpackers looking to make the most of their holiday adventures.</p>
                            <a class="btn-main" href="#">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Fun Facts Section -->
    <section id="section-fun-facts">
        <div class="container">
            <div class="row g-4">
                <!-- Stat 1 -->
                <div class="col-md-3 col-sm-6">
                    <div class="stat-item fadeInUp">
                        <div class="stat-number" data-count="15425">0</div>
                        <div class="stat-title">Trips Powered</div>
                        <p class="stat-description">Helping travelers explore the world with reliable transportation solutions and excellent service.</p>
                    </div>
                </div>
                
                <!-- Stat 2 -->
                <div class="col-md-3 col-sm-6">
                    <div class="stat-item fadeInUp">
                        <div class="stat-number" data-count="8745">0</div>
                        <div class="stat-title">Happy Customers</div>
                        <p class="stat-description">Building lasting relationships with satisfied customers who trust us for their travel needs.</p>
                    </div>
                </div>
                
                <!-- Stat 3 -->
                <div class="col-md-3 col-sm-6">
                    <div class="stat-item fadeInUp">
                        <div class="stat-number" data-count="235">0</div>
                        <div class="stat-title">Fleet Vehicles</div>
                        <p class="stat-description">Maintaining a diverse and modern fleet to meet every traveler's preferences and requirements.</p>
                    </div>
                </div>
                
                <!-- Stat 4 -->
                <div class="col-md-3 col-sm-6">
                    <div class="stat-item fadeInUp">
                        <div class="stat-number" data-count="15">0</div>
                        <div class="stat-title">Years Experience</div>
                        <p class="stat-description">Over a decade of excellence in providing premium transportation and travel services.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Marquee Section - Single Line -->
    <section class="marquee-section">
        <div class="container-fluid px-0">
            <div class="marquee-wrapper">
                <div class="marquee-overlay-left"></div>
                <div class="marquee-overlay-right"></div>
                
                <!-- Single Marquee Line -->
                <div class="marquee-container">
                    <!-- Original Items -->
                    <span class="marquee-item">SUV <span class="marquee-dot"></span></span>
                    <span class="marquee-item">Hatchback <span class="marquee-dot"></span></span>
                    <span class="marquee-item">Crossover <span class="marquee-dot"></span></span>
                    <span class="marquee-item">Convertible <span class="marquee-dot"></span></span>
                    <span class="marquee-item">Sedan <span class="marquee-dot"></span></span>
                    <span class="marquee-item">Sports Car <span class="marquee-dot"></span></span>
                    <span class="marquee-item">Coupe <span class="marquee-dot"></span></span>
                    <span class="marquee-item">Minivan <span class="marquee-dot"></span></span>
                    <span class="marquee-item">Station Wagon <span class="marquee-dot"></span></span>
                    <span class="marquee-item">Truck <span class="marquee-dot"></span></span>
                    <span class="marquee-item">Minivans <span class="marquee-dot"></span></span>
                    <span class="marquee-item">Exotic Cars <span class="marquee-dot"></span></span>
                    
                    <!-- Duplicate Items for Seamless Loop -->
                    <span class="marquee-item">SUV <span class="marquee-dot"></span></span>
                    <span class="marquee-item">Hatchback <span class="marquee-dot"></span></span>
                    <span class="marquee-item">Crossover <span class="marquee-dot"></span></span>
                    <span class="marquee-item">Convertible <span class="marquee-dot"></span></span>
                    <span class="marquee-item">Sedan <span class="marquee-dot"></span></span>
                    <span class="marquee-item">Sports Car <span class="marquee-dot"></span></span>
                    <span class="marquee-item">Coupe <span class="marquee-dot"></span></span>
                    <span class="marquee-item">Minivan <span class="marquee-dot"></span></span>
                    <span class="marquee-item">Station Wagon <span class="marquee-dot"></span></span>
                    <span class="marquee-item">Truck <span class="marquee-dot"></span></span>
                    <span class="marquee-item">Minivans <span class="marquee-dot"></span></span>
                    <span class="marquee-item">Exotic Cars <span class="marquee-dot"></span></span>
                    
                    <!-- Additional Duplicate for Better Loop -->
                    <span class="marquee-item">SUV <span class="marquee-dot"></span></span>
                    <span class="marquee-item">Hatchback <span class="marquee-dot"></span></span>
                    <span class="marquee-item">Crossover <span class="marquee-dot"></span></span>
                    <span class="marquee-item">Convertible <span class="marquee-dot"></span></span>
                    <span class="marquee-item">Sedan <span class="marquee-dot"></span></span>
                    <span class="marquee-item">Sports Car <span class="marquee-dot"></span></span>
                    <span class="marquee-item">Coupe <span class="marquee-dot"></span></span>
                    <span class="marquee-item">Minivan <span class="marquee-dot"></span></span>
                    <span class="marquee-item">Station Wagon <span class="marquee-dot"></span></span>
                    <span class="marquee-item">Truck <span class="marquee-dot"></span></span>
                    <span class="marquee-item">Minivans <span class="marquee-dot"></span></span>
                    <span class="marquee-item">Exotic Cars <span class="marquee-dot"></span></span>
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
        <script>
        // Animated Counter
        function animateCounter(element) {
            const target = parseInt(element.getAttribute('data-count'));
            const duration = 2000; // 2 seconds
            const increment = target / (duration / 16); // 60fps
            let current = 0;
            
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    element.textContent = target.toLocaleString();
                    clearInterval(timer);
                } else {
                    element.textContent = Math.floor(current).toLocaleString();
                }
            }, 16);
        }
        
        // Initialize counters when section is in view
        function initCounters() {
            const statNumbers = document.querySelectorAll('.stat-number');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const element = entry.target;
                        if (!element.classList.contains('animated')) {
                            animateCounter(element);
                            element.classList.add('animated');
                        }
                    }
                });
            }, { threshold: 0.5 });
            
            statNumbers.forEach(stat => observer.observe(stat));
        }
        
        // Add animation classes on scroll
        function animateOnScroll() {
            const statItems = document.querySelectorAll('.stat-item');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('fadeInUp');
                    }
                });
            }, { threshold: 0.1 });
            
            statItems.forEach(item => observer.observe(item));
        }
        
        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            initCounters();
            animateOnScroll();
            
            // Add hover effects to news cards
            const newsCards = document.querySelectorAll('.news-card');
            newsCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-10px)';
                    this.style.boxShadow = '0 15px 40px rgba(0, 0, 0, 0.12)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                    this.style.boxShadow = '0 10px 30px rgba(0, 0, 0, 0.08)';
                });
            });
            
            // News card image hover effect
            const newsImages = document.querySelectorAll('.news-image img');
            newsImages.forEach(img => {
                const parentCard = img.closest('.news-card');
                
                parentCard.addEventListener('mouseenter', function() {
                    img.style.transform = 'scale(1.05)';
                });
                
                parentCard.addEventListener('mouseleave', function() {
                    img.style.transform = 'scale(1)';
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const backToTop = document.getElementById('back-to-top');
            
            // Show/hide back to top button on scroll
            window.addEventListener('scroll', function() {
                if (window.pageYOffset > 300) {
                    backToTop.classList.add('show');
                } else {
                    backToTop.classList.remove('show');
                }
            });
            
            // Smooth scroll to top
            backToTop.addEventListener('click', function(e) {
                e.preventDefault();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
            
            // Marquee item hover effects
            const marqueeItems = document.querySelectorAll('.marquee-item');
            marqueeItems.forEach(item => {
                item.addEventListener('mouseenter', function() {
                    this.style.color = '#2ecc71';
                    this.style.transform = 'scale(1.08)';
                });
                
                item.addEventListener('mouseleave', function() {
                    this.style.color = '';
                    this.style.transform = '';
                });
            });
            
            // Quick links hover effect
            const quickLinks = document.querySelectorAll('.quick-links a');
            quickLinks.forEach(link => {
                link.addEventListener('mouseenter', function() {
                    this.style.color = '#2ecc71';
                    this.style.paddingLeft = '10px';
                });
                
                link.addEventListener('mouseleave', function() {
                    this.style.color = '';
                    this.style.paddingLeft = '';
                });
            });
            
            // Add animation to marquee section when in view
            const marqueeSection = document.querySelector('.marquee-section');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        marqueeSection.classList.add('fadeInRight');
                    }
                });
            }, { threshold: 0.1 });
            
            observer.observe(marqueeSection);
            
            // Pause/play marquee on hover
            const marqueeWrapper = document.querySelector('.marquee-wrapper');
            const marqueeContainer = document.querySelector('.marquee-container');
            
            marqueeWrapper.addEventListener('mouseenter', function() {
                marqueeContainer.style.animationPlayState = 'paused';
            });
            
            marqueeWrapper.addEventListener('mouseleave', function() {
                marqueeContainer.style.animationPlayState = 'running';
            });
        });
    </script>
</body>

</html>


