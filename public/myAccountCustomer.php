<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - Rentaly</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        :root {
            --primary-color: #2ecc71;
            --primary-dark: #27ae60;
            --text-dark: #333;
            --text-light: #777;
            --bg-light: #f8f9fa;
            --border-color: #e9ecef;
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            --transition: all 0.3s ease;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: var(--text-dark);
            background-color: var(--bg-light);
            line-height: 1.6;
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

        /* Hero Section */
        .dashboard-hero {

            color: white;
            padding: 100px 0 60px;
            margin-bottom: 40px;
        }

        .navbar,
        .dashboard-hero {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)),
                url('https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1600&q=80')center/cover no-repeat fixed;
            background-size: cover;
            background-position: center;
        }

        .hero-title {
            font-size: 2.8rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        /* Dashboard Layout */
        .dashboard-container {
            min-height: calc(100vh - 200px);
        }

        /* Sidebar */
        .dashboard-sidebar {
            position: sticky;
            top: 30px;
            height: fit-content;
        }

        .sidebar-card {
            background: white;
            border-radius: 15px;
            box-shadow: var(--shadow);
            overflow: hidden;
            margin-bottom: 30px;
        }

        .user-profile {
            padding: 30px;
            text-align: center;
            border-bottom: 1px solid var(--border-color);
        }

        .profile-image {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            overflow: hidden;
            margin: 0 auto 20px;
            border: 4px solid var(--primary-color);
        }

        .profile-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-name {
            font-size: 1.4rem;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .profile-email {
            color: var(--text-light);
            font-size: 0.95rem;
        }

        .sidebar-menu {
            padding: 20px 0;
        }

        .menu-button {
            display: block;
            width: 100%;
            text-align: left;
            border: none;
            background: none;
            display: flex;
            align-items: center;
            padding: 15px 30px;
            color: var(--text-dark);
            text-decoration: none;
            transition: var(--transition);
            border-left: 4px solid transparent;
            cursor: pointer;
        }

        .menu-button:hover,
        .menu-button.active {
            background-color: rgba(46, 204, 113, 0.1);
            color: var(--primary-color);
            border-left-color: var(--primary-color);
        }

        .menu-button i {
            width: 25px;
            margin-right: 15px;
            font-size: 1.2rem;
        }

        /* Main Content Area */
        .content-section {
            display: none;
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.5s ease, transform 0.5s ease;
        }

        .content-section.active {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }

        /* Stats Cards */
        .stats-grid {
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: var(--shadow);
            text-align: center;
            transition: var(--transition);
            height: 100%;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            background: rgba(46, 204, 113, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: var(--primary-color);
            font-size: 1.5rem;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 5px;
            line-height: 1;
        }

        .stat-label {
            color: var(--text-light);
            font-size: 0.95rem;
        }

        /* Orders Card */
        .orders-card {
            background: white;
            border-radius: 15px;
            box-shadow: var(--shadow);
            padding: 30px;
            margin-bottom: 30px;
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 25px;
            color: var(--text-dark);
            padding-bottom: 15px;
            border-bottom: 2px solid var(--primary-color);
        }

        /* Order Categories */
        .order-category {
            margin-bottom: 40px;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            overflow: hidden;
        }

        .category-header {
            padding: 20px;
            background-color: rgba(46, 204, 113, 0.05);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .category-title {
            font-size: 1.3rem;
            font-weight: 600;
            display: flex;
            align-items: center;
        }

        .category-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 1.2rem;
        }

        .completed-icon {
            background-color: rgba(46, 204, 113, 0.15);
            color: var(--primary-dark);
        }

        .scheduled-icon {
            background-color: rgba(255, 193, 7, 0.15);
            color: #ffc107;
        }

        .cancelled-icon {
            background-color: rgba(220, 53, 69, 0.15);
            color: #dc3545;
        }

        .order-count {
            background-color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .completed-count {
            color: var(--primary-dark);
            border: 1px solid var(--primary-dark);
        }

        .scheduled-count {
            color: #ffc107;
            border: 1px solid #ffc107;
        }

        .cancelled-count {
            color: #dc3545;
            border: 1px solid #dc3545;
        }

        .category-body {
            padding: 0;
        }

        /* Order Items */
        .order-item {
            display: flex;
            align-items: center;
            padding: 20px;
            border-bottom: 1px solid var(--border-color);
            transition: var(--transition);
        }

        .order-item:last-child {
            border-bottom: none;
        }

        .order-item:hover {
            background-color: rgba(46, 204, 113, 0.03);
        }

        .car-image-small {
            width: 120px;
            height: 80px;
            border-radius: 8px;
            overflow: hidden;
            margin-right: 20px;
            flex-shrink: 0;
        }

        .car-image-small img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .order-info {
            flex: 1;
        }

        .order-car-name {
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 5px;
            color: var(--text-dark);
        }

        .order-details {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            color: var(--text-light);
            font-size: 0.9rem;
        }

        .order-id {
            font-weight: 600;
            color: var(--primary-color);
        }

        .order-dates {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            text-align: right;
            min-width: 150px;
        }

        .order-date {
            font-weight: 500;
            margin-bottom: 3px;
        }

        .order-location {
            color: var(--text-light);
            font-size: 0.9rem;
        }

        .order-actions {
            display: flex;
            gap: 10px;
            margin-left: 20px;
        }

        .btn-action {
            padding: 8px 15px;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 500;
            border: 1px solid transparent;
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-details {
            background-color: rgba(46, 204, 113, 0.1);
            color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-details:hover {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-modify {
            background-color: rgba(255, 193, 7, 0.1);
            color: #ffc107;
            border-color: #ffc107;
        }

        .btn-modify:hover {
            background-color: #ffc107;
            color: white;
        }

        .btn-cancel {
            background-color: rgba(220, 53, 69, 0.1);
            color: #dc3545;
            border-color: #dc3545;
        }

        .btn-cancel:hover {
            background-color: #dc3545;
            color: white;
        }

        /* Empty State */
        .empty-orders {
            text-align: center;
            padding: 40px 20px;
            color: var(--text-light);
        }

        .empty-icon {
            font-size: 3rem;
            color: var(--border-color);
            margin-bottom: 20px;
        }

        /* Table for mobile view */
        .table-responsive {
            border-radius: 10px;
            overflow: hidden;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background-color: #f8f9fa;
            border-bottom: 2px solid var(--border-color);
            font-weight: 600;
            color: var(--text-dark);
            padding: 15px;
        }

        .table tbody td {
            padding: 15px;
            vertical-align: middle;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(46, 204, 113, 0.05);
        }

        .status-badge {
            padding: 6px 15px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .status-completed {
            background-color: rgba(46, 204, 113, 0.15);
            color: var(--primary-dark);
        }

        .status-scheduled {
            background-color: rgba(255, 193, 7, 0.15);
            color: #ffc107;
        }

        .status-cancelled {
            background-color: rgba(220, 53, 69, 0.15);
            color: #dc3545;
        }

        /* Favorites Section */
        .favorites-card {
            background: white;
            border-radius: 15px;
            box-shadow: var(--shadow);
            padding: 30px;
        }

        .favorite-item {
            display: flex;
            align-items: center;
            padding: 20px;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            margin-bottom: 20px;
            transition: var(--transition);
        }

        .favorite-item:hover {
            border-color: var(--primary-color);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .car-image {
            width: 200px;
            height: 140px;
            border-radius: 8px;
            overflow: hidden;
            margin-right: 25px;
            flex-shrink: 0;
        }

        .car-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition);
        }

        .favorite-item:hover .car-image img {
            transform: scale(1.05);
        }

        .car-info {
            flex: 1;
        }

        .car-name {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 10px;
            color: var(--text-dark);
        }

        .car-specs {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 15px;
        }

        .spec-item {
            display: flex;
            align-items: center;
            color: var(--text-light);
            font-size: 0.9rem;
        }

        .spec-item i {
            color: var(--primary-color);
            margin-right: 5px;
        }

        .car-price {
            text-align: right;
        }

        .daily-rate {
            font-size: 1.1rem;
            color: var(--text-light);
            margin-bottom: 10px;
        }

        .price {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 15px;
            display: block;
        }

        .btn-rent {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 8px;
            font-weight: 500;
            transition: var(--transition);
            cursor: pointer;
        }

        .btn-rent:hover {
            background: var(--primary-dark);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(46, 204, 113, 0.3);
        }

        /* Profile Section */
        .profile-card {
            background: white;
            border-radius: 15px;
            box-shadow: var(--shadow);
            padding: 30px;
            margin-bottom: 30px;
        }

        .profile-form .form-group {
            margin-bottom: 25px;
        }

        .profile-form label {
            font-weight: 500;
            margin-bottom: 8px;
            color: var(--text-dark);
        }

        .profile-form .form-control {
            padding: 12px 15px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            transition: var(--transition);
        }

        .profile-form .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(46, 204, 113, 0.2);
        }

        .btn-update {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 500;
            transition: var(--transition);
        }

        .btn-update:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(46, 204, 113, 0.3);
        }

        /* Sign Out Section */
        .signout-card {
            background: white;
            border-radius: 15px;
            box-shadow: var(--shadow);
            padding: 50px 30px;
            text-align: center;
            margin-bottom: 30px;
        }

        .signout-icon {
            font-size: 4rem;
            color: var(--primary-color);
            margin-bottom: 20px;
        }

        .signout-message {
            font-size: 1.2rem;
            margin-bottom: 30px;
            color: var(--text-light);
        }

        .btn-confirm-signout {
            background: white;
            color: #dc3545;
            border: 2px solid #dc3545;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 500;
            transition: var(--transition);
        }

        .btn-confirm-signout:hover {
            background: #dc3545;
            color: white;
        }

        /* Order Filters */
        .order-filters {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 25px;
        }

        .filter-btn {
            padding: 8px 20px;
            background-color: white;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            cursor: pointer;
            transition: var(--transition);
            font-weight: 500;
        }

        .filter-btn:hover {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        .filter-btn.active {
            background-color: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        /* Responsive */
        @media (max-width: 992px) {
            .dashboard-sidebar {
                position: static;
                margin-bottom: 30px;
            }

            .order-item {
                flex-wrap: wrap;
            }

            .car-image-small {
                width: 100%;
                height: 160px;
                margin-right: 0;
                margin-bottom: 15px;
            }

            .order-dates {
                flex-direction: row;
                justify-content: space-between;
                width: 100%;
                margin-top: 15px;
            }

            .order-actions {
                width: 100%;
                justify-content: center;
                margin-left: 0;
                margin-top: 15px;
            }

            .favorite-item {
                flex-direction: column;
                text-align: center;
            }

            .car-image {
                width: 100%;
                height: 200px;
                margin-right: 0;
                margin-bottom: 20px;
            }

            .car-price {
                text-align: center;
            }
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.2rem;
            }

            .table thead {
                display: none;
            }

            .table tbody tr {
                display: block;
                margin-bottom: 20px;
                border: 1px solid var(--border-color);
                border-radius: 8px;
                padding: 15px;
            }

            .table tbody td {
                display: block;
                text-align: right;
                padding: 10px 15px;
                position: relative;
            }

            .table tbody td:before {
                content: attr(data-label);
                position: absolute;
                left: 15px;
                font-weight: 600;
                color: var(--text-dark);
            }

            .stat-number {
                font-size: 2rem;
            }

            .category-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
        }

        @media (max-width: 576px) {
            .hero-title {
                font-size: 1.8rem;
            }

            .stats-grid .col-6 {
                margin-bottom: 20px;
            }

            .orders-card,
            .favorites-card,
            .profile-card,
            .signout-card {
                padding: 20px;
            }

            .car-specs {
                justify-content: center;
            }

            .order-details {
                flex-direction: column;
                gap: 5px;
            }

            .order-actions {
                flex-direction: column;
                width: 100%;
            }

            .btn-action {
                width: 100%;
            }
        }

        /* Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeIn 0.6s ease forwards;
        }
    </style>
</head>

<body>
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
    <!-- Hero Section -->
    <section class="dashboard-hero">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h1 class="hero-title">Dashboard</h1>
                    <p class="lead">Welcome back! Manage your bookings, favorites, and account settings.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Dashboard Content -->
    <section class="dashboard-container">
        <div class="container">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-lg-3">
                    <div class="dashboard-sidebar">
                        <div class="sidebar-card fade-in">
                            <div class="user-profile">
                                
                                <h3 class="profile-name">Haidar Habach</h3>
                                <p class="profile-email">haidarhabach@rentaly.com</p>
                            </div>

                            <div class="sidebar-menu">
                                <button class="menu-button active" data-section="dashboard">
                                    <i class="fas fa-home"></i>
                                    <span>Dashboard</span>
                                </button>
                                <button class="menu-button" data-section="profile">
                                    <i class="fas fa-user"></i>
                                    <span>My Profile</span>
                                </button>
                                <button class="menu-button" data-section="orders">
                                    <i class="fas fa-calendar"></i>
                                    <span>My Orders</span>
                                </button>
                                <button class="menu-button" data-section="signout">
                                    <i class="fas fa-sign-out-alt"></i>
                                    <span>Sign Out</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="col-lg-9">
                    <!-- Dashboard Content (Default) -->
                    <div id="dashboard-section" class="content-section active">
                        <!-- Stats Cards -->
                        <div class="row stats-grid g-4 fade-in">
                            <div class="col-lg-3 col-sm-6">
                                <div class="stat-card">
                                    <div class="stat-icon">
                                        <i class="fas fa-calendar-check"></i>
                                    </div>
                                    <div class="stat-number">03</div>
                                    <div class="stat-label">Upcoming Orders</div>
                                </div>
                            </div>

                            <div class="col-lg-3 col-sm-6">
                                <div class="stat-card">
                                    <div class="stat-icon">
                                        <i class="fas fa-tags"></i>
                                    </div>
                                    <div class="stat-number">12</div>
                                    <div class="stat-label">Coupons Available</div>
                                </div>
                            </div>

                            <div class="col-lg-3 col-sm-6">
                                <div class="stat-card">
                                    <div class="stat-icon">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                    <div class="stat-number">58</div>
                                    <div class="stat-label">Total Orders</div>
                                </div>
                            </div>

                            <div class="col-lg-3 col-sm-6">
                                <div class="stat-card">
                                    <div class="stat-icon">
                                        <i class="fas fa-calendar-times"></i>
                                    </div>
                                    <div class="stat-number">24</div>
                                    <div class="stat-label">Cancelled Orders</div>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Orders -->
                        <div class="orders-card fade-in">
                            <h3 class="card-title">My Recent Orders</h3>

                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Car Name</th>
                                            <th>Pick Up</th>
                                            <th>Drop Off</th>
                                            <th>Pick Up Date</th>
                                            <th>Return Date</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="order-id">#01236</td>
                                            <td><strong>Jeep Renegade</strong></td>
                                            <td>New York</td>
                                            <td>Los Angeles</td>
                                            <td>March 2, 2023</td>
                                            <td>March 10, 2023</td>
                                            <td><span class="status-badge status-completed">Completed</span></td>
                                        </tr>
                                        <tr>
                                            <td class="order-id">#01263</td>
                                            <td><strong>Mini Cooper</strong></td>
                                            <td>San Francisco</td>
                                            <td>Chicago</td>
                                            <td>March 8, 2023</td>
                                            <td>March 10, 2023</td>
                                            <td><span class="status-badge status-cancelled">Cancelled</span></td>
                                        </tr>
                                        <tr>
                                            <td class="order-id">#01245</td>
                                            <td><strong>Ferrari Enzo</strong></td>
                                            <td>Philadelphia</td>
                                            <td>Washington</td>
                                            <td>March 6, 2023</td>
                                            <td>March 10, 2023</td>
                                            <td><span class="status-badge status-scheduled">Scheduled</span></td>
                                        </tr>
                                        <tr>
                                            <td class="order-id">#01287</td>
                                            <td><strong>Hyundai Staria</strong></td>
                                            <td>Kansas City</td>
                                            <td>Houston</td>
                                            <td>March 13, 2023</td>
                                            <td>March 10, 2023</td>
                                            <td><span class="status-badge status-completed">Completed</span></td>
                                        </tr>
                                        <tr>
                                            <td class="order-id">#01216</td>
                                            <td><strong>Toyota Rav 4</strong></td>
                                            <td>Baltimore</td>
                                            <td>Sacramento</td>
                                            <td>March 7, 2023</td>
                                            <td>March 10, 2023</td>
                                            <td><span class="status-badge status-scheduled">Scheduled</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            
                        </div>

                        <!-- Favorite Cars -->
                        <div class="favorites-card fade-in">
                            <h3 class="card-title">My Favorite Cars</h3>

                            <!-- Favorite 1 -->
                            <div class="favorite-item">
                                <div class="car-image">
                                    <img src="https://images.unsplash.com/photo-1503376780353-7e6692767b70?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80"
                                        alt="Jeep Renegade">
                                </div>

                                <div class="car-info">
                                    <h4 class="car-name">Jeep Renegade</h4>
                                    <div class="car-specs">
                                        <div class="spec-item">
                                            <i class="fas fa-user"></i> 4 Seats
                                        </div>
                                        <div class="spec-item">
                                            <i class="fas fa-suitcase"></i> 2 bags
                                        </div>
                                        <div class="spec-item">
                                            <i class="fas fa-door-closed"></i> 4 Doors
                                        </div>
                                        
                                    </div>
                                </div>

                                <div class="car-price">
                                    <div class="daily-rate">Daily rate from</div>
                                    <span class="price">$265</span>
                                    <button class="btn-rent">Rent Now</button>
                                </div>
                            </div>

                            <!-- Favorite 2 -->
                            <div class="favorite-item">
                                <div class="car-image">
                                    <img src="https://images.unsplash.com/photo-1555215695-3004980ad54e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80"
                                        alt="BMW M2">
                                </div>

                                <div class="car-info">
                                    <h4 class="car-name">BMW M2</h4>
                                    <div class="car-specs">
                                        <div class="spec-item">
                                            <i class="fas fa-user"></i> 2 Seats
                                        </div>
                                        <div class="spec-item">
                                            <i class="fas fa-suitcase"></i> 1 bags
                                        </div>
                                        <div class="spec-item">
                                            <i class="fas fa-door-closed"></i> 2 Doors
                                        </div>
                                        
                                    </div>
                                </div>

                                <div class="car-price">
                                    <div class="daily-rate">Daily rate from</div>
                                    <span class="price">$244</span>
                                    <button class="btn-rent">Rent Now</button>
                                </div>
                            </div>

                            <!-- Favorite 3 -->
                            <div class="favorite-item">
                                <div class="car-image">
                                    <img src="https://images.unsplash.com/photo-1580273916550-e323be2ae537?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80"
                                        alt="Ferrari Enzo">
                                </div>

                                <div class="car-info">
                                    <h4 class="car-name">Ferrari Enzo</h4>
                                    <div class="car-specs">
                                        <div class="spec-item">
                                            <i class="fas fa-user"></i> 2 Seats
                                        </div>
                                        <div class="spec-item">
                                            <i class="fas fa-suitcase"></i> 1 bags
                                        </div>
                                        <div class="spec-item">
                                            <i class="fas fa-door-closed"></i> 2 Doors
                                        </div>
                                        
                                    </div>
                                </div>

                                <div class="car-price">
                                    <div class="daily-rate">Daily rate from</div>
                                    <span class="price">$167</span>
                                    <button class="btn-rent">Rent Now</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Profile Content -->
                    <div id="profile-section" class="content-section">
                        <div class="profile-card fade-in">
                            <h3 class="card-title">My Profile</h3>
                            <p class="text-muted mb-4">Update your personal information and preferences</p>

                            <form class="profile-form">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="first-name">First Name</label>
                                            <input type="text" class="form-control" id="first-name" value="haidar">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="last-name">Last Name</label>
                                            <input type="text" class="form-control" id="last-name" value="habach">
                                            </div>  
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email">Email Address</label>
                                    <input type="email" class="form-control" id="email" value="haidar@rentaly.com">
                                </div>

                                <div class="form-group">
                                    <label for="phone">Phone Number</label>
                                    <input type="tel" class="form-control" id="phone" value="01 234 567">
                                </div>

                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" class="form-control" id="address"
                                        value="123 Main St, New York, NY 10001">
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password">New Password</label>
                                            <input type="password" class="form-control" id="password"
                                                placeholder="Enter new password">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="confirm-password">Confirm Password</label>
                                            <input type="password" class="form-control" id="confirm-password"
                                                placeholder="Confirm new password">
                                        </div>
                                    </div>
                                </div>

                                

                                <div class="text-end mt-4">
                                    <button type="submit" class="btn btn-update">Update Profile</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Orders Content -->
                    <div id="orders-section" class="content-section">
                        <div class="orders-card fade-in">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h3 class="card-title mb-0">My Orders</h3>
                                <div class="order-filters">
                                    <button class="filter-btn active" data-filter="all">All Orders</button>
                                    <button class="filter-btn" data-filter="completed">Completed</button>
                                    <button class="filter-btn" data-filter="scheduled">Scheduled</button>
                                    <button class="filter-btn" data-filter="cancelled">Cancelled</button>
                                </div>
                            </div>
                            <p class="text-muted mb-4">View and manage all your rental orders</p>

                            <!-- Completed Orders -->
                            <div class="order-category completed-category" data-category="completed">
                                <div class="category-header">
                                    <div class="category-title">
                                        <div class="category-icon completed-icon">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                        <span>Completed Orders</span>
                                    </div>
                                    <div class="order-count completed-count">15 Orders</div>
                                </div>
                                <div class="category-body">
                                    <!-- Order Item 1 -->
                                    <div class="order-item">
                                        <div class="car-image-small">
                                            <img src="https://images.unsplash.com/photo-1503376780353-7e6692767b70?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80"
                                                alt="Jeep Renegade">
                                        </div>
                                        <div class="order-info">
                                            <div class="order-car-name">Jeep Renegade</div>
                                            <div class="order-details">
                                                <span class="order-id">#01236</span>
                                                <span>New York → Los Angeles</span>
                                                <span>March 2 - March 10, 2023</span>
                                                <span class="text-success"><i
                                                        class="fas fa-check-circle me-1"></i>Successfully
                                                    completed</span>
                                            </div>
                                        </div>
                                        <div class="order-dates">
                                            <div class="order-date">March 2, 2023</div>
                                            <div class="order-date">March 10, 2023</div>
                                            <div class="order-location">14 days</div>
                                        </div>
                                        <div class="order-actions">
                                            
                                            <button class="btn-action btn-modify">Rent Again</button>
                                        </div>
                                    </div>

                                    <!-- Order Item 2 -->
                                    <div class="order-item">
                                        <div class="car-image-small">
                                            <img src="https://images.unsplash.com/photo-1555215695-3004980ad54e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80"
                                                alt="BMW M2">
                                        </div>
                                        <div class="order-info">
                                            <div class="order-car-name">BMW M2</div>
                                            <div class="order-details">
                                                <span class="order-id">#01198</span>
                                                <span>Miami → Atlanta</span>
                                                <span>March 1 - March 5, 2023</span>
                                                <span class="text-success"><i
                                                        class="fas fa-check-circle me-1"></i>Successfully
                                                    completed</span>
                                            </div>
                                        </div>
                                        <div class="order-dates">
                                            <div class="order-date">March 1, 2023</div>
                                            <div class="order-date">March 5, 2023</div>
                                            <div class="order-location">5 days</div>
                                        </div>
                                        <div class="order-actions">
                                            
                                            <button class="btn-action btn-modify">Rent Again</button>
                                        </div>
                                    </div>

                                    <!-- Order Item 3 -->
                                    <div class="order-item">
                                        <div class="car-image-small">
                                            <img src="https://images.unsplash.com/photo-1580273916550-e323be2ae537?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80"
                                                alt="Ferrari Enzo">
                                        </div>
                                        <div class="order-info">
                                            <div class="order-car-name">Ferrari Enzo</div>
                                            <div class="order-details">
                                                <span class="order-id">#01175</span>
                                                <span>Seattle → Portland</span>
                                                <span>Feb 25 - Feb 28, 2023</span>
                                                <span class="text-success"><i
                                                        class="fas fa-check-circle me-1"></i>Successfully
                                                    completed</span>
                                            </div>
                                        </div>
                                        <div class="order-dates">
                                            <div class="order-date">Feb 25, 2023</div>
                                            <div class="order-date">Feb 28, 2023</div>
                                            <div class="order-location">4 days</div>
                                        </div>
                                        <div class="order-actions">
                                            
                                            <button class="btn-action btn-modify">Rent Again</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Scheduled Orders -->
                            <div class="order-category scheduled-category" data-category="scheduled">
                                <div class="category-header">
                                    <div class="category-title">
                                        <div class="category-icon scheduled-icon">
                                            <i class="fas fa-calendar-alt"></i>
                                        </div>
                                        <span>Scheduled Orders</span>
                                    </div>
                                    <div class="order-count scheduled-count">3 Orders</div>
                                </div>
                                <div class="category-body">
                                    <!-- Order Item 1 -->
                                    <div class="order-item">
                                        <div class="car-image-small">
                                            <img src="https://images.unsplash.com/photo-1549399542-7e3f8b79c341?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80"
                                                alt="Ferrari Enzo">
                                        </div>
                                        <div class="order-info">
                                            <div class="order-car-name">Ferrari Enzo</div>
                                            <div class="order-details">
                                                <span class="order-id">#01245</span>
                                                <span>Philadelphia → Washington</span>
                                                <span>March 6 - March 10, 2023</span>
                                                <span class="text-warning"><i class="fas fa-clock me-1"></i>Upcoming
                                                    rental</span>
                                            </div>
                                        </div>
                                        <div class="order-dates">
                                            <div class="order-date">March 6, 2023</div>
                                            <div class="order-date">March 10, 2023</div>
                                            <div class="order-location">5 days</div>
                                        </div>
                                        <div class="order-actions">
                                            
                                            
                                            <button class="btn-action btn-cancel">Cancel</button>
                                        </div>
                                    </div>

                                    <!-- Order Item 2 -->
                                    <div class="order-item">
                                        <div class="car-image-small">
                                            <img src="https://images.unsplash.com/photo-1553440569-bcc63803a83d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80"
                                                alt="Toyota Rav 4">
                                        </div>
                                        <div class="order-info">
                                            <div class="order-car-name">Toyota Rav 4</div>
                                            <div class="order-details">
                                                <span class="order-id">#01216</span>
                                                <span>Baltimore → Sacramento</span>
                                                <span>March 7 - March 10, 2023</span>
                                                <span class="text-warning"><i class="fas fa-clock me-1"></i>Upcoming
                                                    rental</span>
                                            </div>
                                        </div>
                                        <div class="order-dates">
                                            <div class="order-date">March 7, 2023</div>
                                            <div class="order-date">March 10, 2023</div>
                                            <div class="order-location">4 days</div>
                                        </div>
                                        <div class="order-actions">
                                            
                                            <button class="btn-action btn-cancel">Cancel</button>
                                        </div>
                                    </div>

                                    <!-- Order Item 3 -->
                                    <div class="order-item">
                                        <div class="car-image-small">
                                            <img src="https://images.unsplash.com/photo-1580273916550-e323be2ae537?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80"
                                                alt="Ferrari Enzo">
                                        </div>
                                        <div class="order-info">
                                            <div class="order-car-name">Ferrari Enzo</div>
                                            <div class="order-details">
                                                <span class="order-id">#01299</span>
                                                <span>Los Angeles → San Diego</span>
                                                <span>March 15 - March 20, 2023</span>
                                                <span class="text-warning"><i class="fas fa-clock me-1"></i>Upcoming
                                                    rental</span>
                                            </div>
                                        </div>
                                        <div class="order-dates">
                                            <div class="order-date">March 15, 2023</div>
                                            <div class="order-date">March 20, 2023</div>
                                            <div class="order-location">6 days</div>
                                        </div>
                                        <div class="order-actions">
                                            
                                            <button class="btn-action btn-cancel">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Cancelled Orders -->
                            <div class="order-category cancelled-category" data-category="cancelled">
                                <div class="category-header">
                                    <div class="category-title">
                                        <div class="category-icon cancelled-icon">
                                            <i class="fas fa-times-circle"></i>
                                        </div>
                                        <span>Cancelled Orders</span>
                                    </div>
                                    <div class="order-count cancelled-count">24 Orders</div>
                                </div>
                                <div class="category-body">
                                    <!-- Order Item 1 -->
                                    <div class="order-item">
                                        <div class="car-image-small">
                                            <img src="https://images.unsplash.com/photo-1542282088-fe8426682b8f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80"
                                                alt="Mini Cooper">
                                        </div>
                                        <div class="order-info">
                                            <div class="order-car-name">Mini Cooper</div>
                                            <div class="order-details">
                                                <span class="order-id">#01263</span>
                                                <span>San Francisco → Chicago</span>
                                                <span>March 8 - March 10, 2023</span>
                                                <span class="text-danger"><i
                                                        class="fas fa-times-circle me-1"></i>Cancelled by user</span>
                                            </div>
                                        </div>
                                        <div class="order-dates">
                                            <div class="order-date">March 8, 2023</div>
                                            <div class="order-date">March 10, 2023</div>
                                            <div class="order-location">3 days</div>
                                        </div>
                                        <div class="order-actions">
                        
                                            <button class="btn-action btn-modify">Re-book</button>
                                        </div>
                                    </div>

                                    <!-- Order Item 2 -->
                                    <div class="order-item">
                                        <div class="car-image-small">
                                            <img src="https://images.unsplash.com/photo-1549399542-7e3f8b79c341?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80"
                                                alt="Ferrari Enzo">
                                        </div>
                                        <div class="order-info">
                                            <div class="order-car-name">Ferrari Enzo</div>
                                            <div class="order-details">
                                                <span class="order-id">#01189</span>
                                                <span>Chicago → Detroit</span>
                                                <span>Feb 20 - Feb 25, 2023</span>
                                                <span class="text-danger"><i
                                                        class="fas fa-times-circle me-1"></i>Cancelled by system</span>
                                            </div>
                                        </div>
                                        <div class="order-dates">
                                            <div class="order-date">Feb 20, 2023</div>
                                            <div class="order-date">Feb 25, 2023</div>
                                            <div class="order-location">6 days</div>
                                        </div>
                                        <div class="order-actions">
                                            
                                            <button class="btn-action btn-modify">Re-book</button>
                                        </div>
                                    </div>

                                    <!-- Empty State for other categories (hidden by default) -->
                                    <div class="empty-orders" style="display: none;">
                                        <div class="empty-icon">
                                            <i class="fas fa-calendar-times"></i>
                                        </div>
                                        <h5>No orders in this category</h5>
                                        <p>You don't have any orders with this status yet.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sign Out Content -->
                    <div id="signout-section" class="content-section">
                        <div class="signout-card fade-in">
                            <div class="signout-icon">
                                <i class="fas fa-sign-out-alt"></i>
                            </div>
                            <h3 class="card-title">Sign Out</h3>
                            <p class="signout-message">Are you sure you want to sign out of your account?</p>
                            <p class="text-muted mb-4">You will need to sign in again to access your dashboard.</p>

                            <div class="d-flex justify-content-center gap-3">
                                <button class="btn btn-update" id="cancel-signout">Cancel</button>
                                <button class="btn btn-confirm-signout">Sign Out</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
     // Main content switching functionality
        document.addEventListener('DOMContentLoaded', function () {
            // Get all menu buttons and content sections
            const menuButtons = document.querySelectorAll('.menu-button');
            const contentSections = document.querySelectorAll('.content-section');

            // Function to switch content
            function switchContent(sectionId) {
                // Hide all content sections
                contentSections.forEach(section => {
                    section.classList.remove('active');
                });

                // Show the selected section
                const activeSection = document.getElementById(`${sectionId}-section`);
                if (activeSection) {
                    activeSection.classList.add('active');
                }

                // Update active button
                menuButtons.forEach(button => {
                    button.classList.remove('active');
                    if (button.getAttribute('data-section') === sectionId) {
                        button.classList.add('active');
                    }
                });
            }

            // Add click event listeners to menu buttons
            menuButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const sectionId = this.getAttribute('data-section');
                    switchContent(sectionId);
                });
            });







            // Order filtering functionality
            const filterButtons = document.querySelectorAll('.filter-btn');
            const orderCategories = document.querySelectorAll('.order-category');

            filterButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const filter = this.getAttribute('data-filter');

                    // Update active filter button
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');

                    // Show/hide categories based on filter
                    orderCategories.forEach(category => {
                        const categoryType = category.getAttribute('data-category');

                        if (filter === 'all' || filter === categoryType) {
                            category.style.display = 'block';
                        } else {
                            category.style.display = 'none';
                        }
                    });
                });
            });







            // Add responsive table labels
            const tableHeaders = document.querySelectorAll('.table thead th');
            const tableRows = document.querySelectorAll('.table tbody tr');

            tableRows.forEach(row => {
                const cells = row.querySelectorAll('td');
                cells.forEach((cell, index) => {
                    if (tableHeaders[index]) {
                        cell.setAttribute('data-label', tableHeaders[index].textContent);
                    }
                });
            });

            // Add animation on scroll
            const observerOptions = {
                threshold: 0.1
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('fade-in');
                    }
                });
            }, observerOptions);

            const animatedElements = document.querySelectorAll('.sidebar-card, .stat-card, .orders-card, .favorites-card, .profile-card, .signout-card');
            animatedElements.forEach(el => observer.observe(el));
        });
    </script>
</body>

</html>
