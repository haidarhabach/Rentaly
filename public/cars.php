<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Dashboard - Rentaly</title>
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
            --secondary-color: #3498db;
            --warning-color: #f39c12;
            --danger-color: #e74c3c;
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
            background-color: #f5f7fa;
            line-height: 1.6;
        }

        /* Navbar Styling */
        .navbar {
            background-color: #121212;
            padding: 15px 0;
        }

        .navbar .nav-link {
            color: #ffffff !important;
        }

        .navbar .nav-link:hover {
            color: rgba(12, 233, 56, 0.867) !important;
        }

        /* Hero Section */
        .dashboard-hero {
            background: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)),
                url('https://images.unsplash.com/photo-1558618666-fcd25c85cd64?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1600&q=80') center/cover no-repeat;
            color: white;
            padding: 80px 0 40px;
            margin-bottom: 40px;
        }

        .hero-title {
            font-size: 2.5rem;
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


        .sidebar-card {
            background: white;
            border-radius: 15px;
            box-shadow: var(--shadow);
            overflow: hidden;
            margin-bottom: 30px;
        }

        .employee-profile {
            padding: 30px;
            text-align: center;
            border-bottom: 1px solid var(--border-color);
            background: linear-gradient(135deg, #2ecc71, #27ae60);
            color: white;
        }

        .employee-image {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            overflow: hidden;
            margin: 0 auto 20px;
            border: 4px solid white;
            background: white;
        }

        .employee-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .employee-name {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .employee-role {
            background: rgba(255, 255, 255, 0.2);
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            display: inline-block;
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
            border-top: 4px solid;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
        }

        .stat-card.pending {
            border-top-color: var(--warning-color);
        }

        .stat-card.approved {
            border-top-color: var(--primary-color);
        }

        .stat-card.rejected {
            border-top-color: var(--danger-color);
        }

        .stat-card.total {
            border-top-color: var(--secondary-color);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 1.5rem;
            color: white;
        }

        .pending .stat-icon {
            background: var(--warning-color);
        }

        .approved .stat-icon {
            background: var(--primary-color);
        }

        .rejected .stat-icon {
            background: var(--danger-color);
        }

        .total .stat-icon {
            background: var(--secondary-color);
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

        /* Car Management Card */
        .car-management-card {
            background: white;
            border-radius: 15px;
            box-shadow: var(--shadow);
            padding: 30px;
            margin-bottom: 30px;
        }

        /* Tabs for Car Management */
        .car-tabs {
            display: flex;
            border-bottom: 2px solid var(--border-color);
            margin-bottom: 25px;
            overflow-x: auto;
        }

        .car-tab {
            padding: 12px 25px;
            background: none;
            border: none;
            border-bottom: 3px solid transparent;
            font-weight: 500;
            color: var(--text-light);
            cursor: pointer;
            transition: var(--transition);
            white-space: nowrap;
        }

        .car-tab:hover {
            color: var(--primary-color);
        }

        .car-tab.active {
            color: var(--primary-color);
            border-bottom-color: var(--primary-color);
        }

        /* Car Management Content */
        .car-tab-content {
            display: none;
        }

        .car-tab-content.active {
            display: block;
            animation: fadeIn 0.5s ease;
        }

        /* Car List */
        .car-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .car-item {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            overflow: hidden;
            transition: var(--transition);
        }

        .car-item:hover {
            border-color: var(--primary-color);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transform: translateY(-3px);
        }

        .car-image-container {
            height: 180px;
            overflow: hidden;
            position: relative;
        }

        .car-image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .car-item:hover .car-image-container img {
            transform: scale(1.05);
        }

        .availability-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .available {
            background: rgba(46, 204, 113, 0.15);
            color: var(--primary-dark);
        }

        .low-stock {
            background: rgba(243, 156, 18, 0.15);
            color: var(--warning-color);
        }

        .out-of-stock {
            background: rgba(231, 76, 60, 0.15);
            color: var(--danger-color);
        }

        .car-info {
            padding: 20px;
        }

        .car-name {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 10px;
            color: var(--text-dark);
        }

        .car-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            font-size: 0.9rem;
            color: var(--text-light);
        }

        .car-specs {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 15px;
        }

        .spec-badge {
            padding: 4px 10px;
            background: #f8f9fa;
            border-radius: 15px;
            font-size: 0.8rem;
            color: var(--text-dark);
        }

        .car-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        .btn-edit, .btn-delete {
            padding: 8px 15px;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            border: 1px solid transparent;
        }

        .btn-edit {
            background: rgba(52, 152, 219, 0.1);
            color: var(--secondary-color);
            border-color: var(--secondary-color);
        }

        .btn-edit:hover {
            background: var(--secondary-color);
            color: white;
        }

        .btn-delete {
            background: rgba(231, 76, 60, 0.1);
            color: var(--danger-color);
            border-color: var(--danger-color);
        }

        .btn-delete:hover {
            background: var(--danger-color);
            color: white;
        }

        /* Add Car Form */
        .add-car-form {
            max-width: 800px;
            margin: 0 auto;
        }

        .form-section {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 25px;
        }

        .form-section-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 20px;
            color: var(--text-dark);
            padding-bottom: 10px;
            border-bottom: 2px solid var(--primary-color);
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: 500;
            margin-bottom: 8px;
            color: var(--text-dark);
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            transition: var(--transition);
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(46, 204, 113, 0.2);
            outline: none;
        }

        .quantity-control {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .qty-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 1px solid var(--border-color);
            background: white;
            font-size: 1.2rem;
            cursor: pointer;
            transition: var(--transition);
        }

        .qty-btn:hover {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        .qty-input {
            width: 80px;
            text-align: center;
            font-weight: 600;
            font-size: 1.2rem;
        }

        .btn-submit {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 500;
            transition: var(--transition);
            cursor: pointer;
        }

        .btn-submit:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(46, 204, 113, 0.3);
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

        /* Order Items */
        .order-item {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid var(--border-color);
            transition: var(--transition);
            position: relative;
        }

        .order-item:hover {
            border-color: var(--primary-color);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .order-item.pending {
            border-left: 4px solid var(--warning-color);
        }

        .order-item.approved {
            border-left: 4px solid var(--primary-color);
        }

        .order-item.rejected {
            border-left: 4px solid var(--danger-color);
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 10px;
        }

        .order-id {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-dark);
        }

        .order-status {
            padding: 6px 15px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .status-pending {
            background-color: rgba(243, 156, 18, 0.15);
            color: var(--warning-color);
        }

        .status-approved {
            background-color: rgba(46, 204, 113, 0.15);
            color: var(--primary-dark);
        }

        .status-rejected {
            background-color: rgba(231, 76, 60, 0.15);
            color: var(--danger-color);
        }

        .order-details {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            margin-bottom: 20px;
        }

        .order-car {
            flex: 1;
            min-width: 300px;
        }

        .car-image {
            width: 200px;
            height: 140px;
            border-radius: 8px;
            overflow: hidden;
            float: left;
            margin-right: 20px;
        }

        .car-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .car-name {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .car-specs {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 10px;
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

        .order-info {
            flex: 1;
            min-width: 300px;
        }

        .info-item {
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }

        .info-label {
            font-weight: 500;
            min-width: 120px;
            color: var(--text-dark);
        }

        .info-value {
            color: var(--text-light);
        }

        .info-value.highlight {
            color: var(--primary-color);
            font-weight: 500;
        }

        .order-actions {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            border-top: 1px solid var(--border-color);
            padding-top: 20px;
            margin-top: 20px;
        }

        .btn-action {
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 500;
            border: 1px solid transparent;
            cursor: pointer;
            transition: var(--transition);
            min-width: 100px;
            text-align: center;
        }

        .btn-approve {
            background-color: rgba(46, 204, 113, 0.1);
            color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-approve:hover {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-reject {
            background-color: rgba(231, 76, 60, 0.1);
            color: var(--danger-color);
            border-color: var(--danger-color);
        }

        .btn-reject:hover {
            background-color: var(--danger-color);
            color: white;
        }

        .btn-view {
            background-color: rgba(52, 152, 219, 0.1);
            color: var(--secondary-color);
            border-color: var(--secondary-color);
        }

        .btn-view:hover {
            background-color: var(--secondary-color);
            color: white;
        }

        /* Customer Info */
        .customer-card {
            background: white;
            border-radius: 15px;
            box-shadow: var(--shadow);
            padding: 30px;
            margin-bottom: 30px;
        }

        .customer-header {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
        }

        .customer-avatar {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            overflow: hidden;
            margin-right: 20px;
        }

        .customer-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .customer-name {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .customer-email {
            color: var(--text-light);
            font-size: 0.95rem;
        }

        .customer-details {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }

        .detail-item {
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
        }

        .detail-label {
            font-size: 0.85rem;
            color: var(--text-light);
            margin-bottom: 5px;
        }

        .detail-value {
            font-weight: 500;
            color: var(--text-dark);
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

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 50px 20px;
            color: var(--text-light);
        }

        .empty-icon {
            font-size: 3rem;
            color: #ddd;
            margin-bottom: 20px;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .dashboard-sidebar {
                position: static;
                margin-bottom: 30px;
            }

            .car-image {
                float: none;
                width: 100%;
                height: 200px;
                margin-right: 0;
                margin-bottom: 15px;
            }

            .order-details {
                flex-direction: column;
            }

            .car-list {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2rem;
            }

            .order-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .order-actions {
                flex-direction: column;
                width: 100%;
            }

            .btn-action {
                width: 100%;
            }

            .customer-header {
                flex-direction: column;
                text-align: center;
            }

            .customer-avatar {
                margin-right: 0;
                margin-bottom: 15px;
            }

            .car-tabs {
                flex-direction: column;
            }

            .car-tab {
                text-align: left;
                border-bottom: 1px solid var(--border-color);
            }

            .car-tab.active {
                border-bottom-color: var(--primary-color);
            }
        }

        @media (max-width: 576px) {
            .hero-title {
                font-size: 1.6rem;
            }

            .stats-grid .col-6 {
                margin-bottom: 20px;
            }

            .orders-card,
            .customer-card,
            .car-management-card,
            .signout-card {
                padding: 20px;
            }

            .stat-number {
                font-size: 2rem;
            }

            .car-list {
                grid-template-columns: 1fr;
            }

            .form-row {
                grid-template-columns: 1fr;
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
    <!-- Top Bar -->
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
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
            <div class="container">
                <a class="navbar-brand" href="index.php">
                    <img src="../assets/img/logo-light.png" alt="Rentaly" style="height: 40px;">
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
                            <a class="nav-link" href="myAccountEmployee.php">Manage Cars</a>
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
                    <h1 class="hero-title">Employee Dashboard</h1>
                    <p class="lead">Manage client orders, car inventory, and handle customer inquiries.</p>
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
                            <div class="employee-profile">
                                
                                <h3 class="employee-name">Haidar Habach</h3>
                                <div class="employee-role">Admin</div>
                                <p class="mt-3" style="font-size: 0.9rem; opacity: 0.9;">Employee ID: EMP-2023-045</p>
                            </div>

                            <div class="sidebar-menu">
                                <button class="menu-button active" data-section="dashboard">
                                    <i class="fas fa-tachometer-alt"></i>
                                    <span>Dashboard</span>
                                </button>
                                <button class="menu-button" data-section="orders">
                                    <i class="fas fa-clipboard-list"></i>
                                    <span>Manage Orders</span>
                                </button>
                                <button class="menu-button" data-section="cars">
                                    <i class="fas fa-car"></i>
                                    <span>Car Management</span>
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
                    <!-- Dashboard Content -->
                    <div id="dashboard-section" class="content-section active">
                        <!-- Stats Cards -->
                        <div class="row stats-grid g-4 fade-in">
                            <div class="col-lg-3 col-sm-6">
                                <div class="stat-card pending">
                                    <div class="stat-icon">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                    <div class="stat-number" id="pending-count">12</div>
                                    <div class="stat-label">Pending Orders</div>
                                </div>
                            </div>

                            <div class="col-lg-3 col-sm-6">
                                <div class="stat-card approved">
                                    <div class="stat-icon">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    <div class="stat-number" id="approved-count">58</div>
                                    <div class="stat-label">Approved Orders</div>
                                </div>
                            </div>

                            <div class="col-lg-3 col-sm-6">
                                <div class="stat-card rejected">
                                    <div class="stat-icon">
                                        <i class="fas fa-times-circle"></i>
                                    </div>
                                    <div class="stat-number" id="rejected-count">24</div>
                                    <div class="stat-label">Rejected Orders</div>
                                </div>
                            </div>

                            <div class="col-lg-3 col-sm-6">
                                <div class="stat-card total">
                                    <div class="stat-icon">
                                        <i class="fas fa-list-alt"></i>
                                    </div>
                                    <div class="stat-number" id="total-count">94</div>
                                    <div class="stat-label">Total Orders</div>
                                </div>
                            </div>
                        </div>

                        <!-- Car Inventory Stats -->
                        <div class="row stats-grid g-4 fade-in">
                            <div class="col-lg-4 col-sm-6">
                                <div class="stat-card" style="border-top-color: #9b59b6;">
                                    <div class="stat-icon" style="background: #9b59b6;">
                                        <i class="fas fa-car"></i>
                                    </div>
                                    <div class="stat-number" id="total-cars">42</div>
                                    <div class="stat-label">Total Cars</div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-sm-6">
                                <div class="stat-card" style="border-top-color: var(--primary-color);">
                                    <div class="stat-icon" style="background: var(--primary-color);">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    <div class="stat-number" id="available-cars">28</div>
                                    <div class="stat-label">Available Cars</div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-sm-6">
                                <div class="stat-card" style="border-top-color: var(--warning-color);">
                                    <div class="stat-icon" style="background: var(--warning-color);">
                                        <i class="fas fa-exclamation-circle"></i>
                                    </div>
                                    <div class="stat-number" id="low-stock-cars">5</div>
                                    <div class="stat-label">Low Stock</div>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Orders -->
                        <div class="orders-card fade-in">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h3 class="card-title mb-0">Pending Orders - Need Action</h3>
                                <span class="badge bg-warning">12 orders require attention</span>
                            </div>

                            <!-- Pending Order 1 -->
                            <div class="order-item pending" data-order-id="ORD-2023-001">
                                <div class="order-header">
                                    <div class="order-id">ORD-2023-001 - Jeep Renegade</div>
                                    <div class="order-status status-pending">Pending Approval</div>
                                </div>
                                
                                <div class="order-details">
                                    <div class="order-car">
                                        <div class="car-image">
                                            <img src="https://images.unsplash.com/photo-1503376780353-7e6692767b70?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80" alt="Jeep Renegade">
                                        </div>
                                        <div class="car-name">Jeep Renegade 2023</div>
                                        <div class="car-specs">
                                            <div class="spec-item">
                                                <i class="fas fa-user"></i> 4 Seats
                                            </div>
                                            <div class="spec-item">
                                                <i class="fas fa-suitcase"></i> 2 Bags
                                            </div>
                                            <div class="spec-item">
                                                <i class="fas fa-gas-pump"></i> Petrol
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="order-info">
                                        <div class="info-item">
                                            <span class="info-label">Customer:</span>
                                            <span class="info-value highlight">Michael Johnson</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">Pickup Date:</span>
                                            <span class="info-value">March 15, 2023</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">Return Date:</span>
                                            <span class="info-value">March 20, 2023</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">Location:</span>
                                            <span class="info-value">New York → Los Angeles</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">Total Amount:</span>
                                            <span class="info-value highlight">$1,325.00</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="order-actions">
                                    <button class="btn-action btn-reject" data-action="reject" onclick="handleOrderAction('reject', 'ORD-2023-001')">Reject</button>
                                    <button class="btn-action btn-approve" data-action="approve" onclick="handleOrderAction('approve', 'ORD-2023-001')">Approve</button>
                                </div>
                            </div>
                            
                            <!-- Pending Order 2 -->
                            <div class="order-item pending" data-order-id="ORD-2023-002">
                                <div class="order-header">
                                    <div class="order-id">ORD-2023-002 - BMW M2</div>
                                    <div class="order-status status-pending">Pending Approval</div>
                                </div>
                                
                                <div class="order-details">
                                    <div class="order-car">
                                        <div class="car-image">
                                            <img src="https://images.unsplash.com/photo-1555215695-3004980ad54e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80" alt="BMW M2">
                                        </div>
                                        <div class="car-name">BMW M2 Competition 2023</div>
                                        <div class="car-specs">
                                            <div class="spec-item">
                                                <i class="fas fa-user"></i> 2 Seats
                                            </div>
                                            <div class="spec-item">
                                                <i class="fas fa-suitcase"></i> 1 Bag
                                            </div>
                                            <div class="spec-item">
                                                <i class="fas fa-gas-pump"></i> Petrol
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="order-info">
                                        <div class="info-item">
                                            <span class="info-label">Customer:</span>
                                            <span class="info-value highlight">Sarah Williams</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">Pickup Date:</span>
                                            <span class="info-value">March 18, 2023</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">Return Date:</span>
                                            <span class="info-value">March 25, 2023</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">Location:</span>
                                            <span class="info-value">Miami Airport</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">Total Amount:</span>
                                            <span class="info-value highlight">$1,708.00</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="order-actions">
                                    <button class="btn-action btn-reject" data-action="reject" onclick="handleOrderAction('reject', 'ORD-2023-002')">Reject</button>
                                    <button class="btn-action btn-approve" data-action="approve" onclick="handleOrderAction('approve', 'ORD-2023-002')">Approve</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Manage Orders Content -->
                    <div id="orders-section" class="content-section">
                        <div class="orders-card fade-in">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h3 class="card-title mb-0">Manage All Orders</h3>
                                <div class="order-filters">
                                    <button class="filter-btn active" onclick="filterOrders('all')">All Orders</button>
                                    <button class="filter-btn" onclick="filterOrders('pending')">Pending</button>
                                    <button class="filter-btn" onclick="filterOrders('approved')">Approved</button>
                                    <button class="filter-btn" onclick="filterOrders('rejected')">Rejected</button>
                                </div>
                            </div>
                            <p class="text-muted mb-4">Review, approve, or reject client rental orders</p>

                            <div id="orders-container">
                                <!-- Order 1: Pending -->
                                <div class="order-item pending" data-order-id="ORD-2023-001" data-status="pending">
                                    <div class="order-header">
                                        <div class="order-id">ORD-2023-001 - Jeep Renegade</div>
                                        <div class="order-status status-pending">Pending Approval</div>
                                    </div>
                                    
                                    <div class="order-details">
                                        <div class="order-car">
                                            <div class="car-image">
                                                <img src="https://images.unsplash.com/photo-1503376780353-7e6692767b70?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80" alt="Jeep Renegade">
                                            </div>
                                            <div class="car-name">Jeep Renegade 2023</div>
                                            <div class="car-specs">
                                                <div class="spec-item">
                                                    <i class="fas fa-user"></i> 4 Seats
                                                </div>
                                                <div class="spec-item">
                                                    <i class="fas fa-suitcase"></i> 2 Bags
                                                </div>
                                                <div class="spec-item">
                                                    <i class="fas fa-gas-pump"></i> Petrol
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="order-info">
                                            <div class="info-item">
                                                <span class="info-label">Customer:</span>
                                                <span class="info-value highlight">Michael Johnson</span>
                                            </div>
                                            <div class="info-item">
                                                <span class="info-label">Pickup Date:</span>
                                                <span class="info-value">March 15, 2023</span>
                                            </div>
                                            <div class="info-item">
                                                <span class="info-label">Return Date:</span>
                                                <span class="info-value">March 20, 2023</span>
                                            </div>
                                            <div class="info-item">
                                                <span class="info-label">Location:</span>
                                                <span class="info-value">New York → Los Angeles</span>
                                            </div>
                                            <div class="info-item">
                                                <span class="info-label">Total Amount:</span>
                                                <span class="info-value highlight">$1,325.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="order-actions">
                                        <button class="btn-action btn-reject" onclick="handleOrderAction('reject', 'ORD-2023-001')">Reject</button>
                                        <button class="btn-action btn-approve" onclick="handleOrderAction('approve', 'ORD-2023-001')">Approve</button>
                                    </div>
                                </div>

                                <!-- Order 2: Pending -->
                                <div class="order-item pending" data-order-id="ORD-2023-002" data-status="pending">
                                    <div class="order-header">
                                        <div class="order-id">ORD-2023-002 - BMW M2</div>
                                        <div class="order-status status-pending">Pending Approval</div>
                                    </div>
                                    
                                    <div class="order-details">
                                        <div class="order-car">
                                            <div class="car-image">
                                                <img src="https://images.unsplash.com/photo-1555215695-3004980ad54e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80" alt="BMW M2">
                                            </div>
                                            <div class="car-name">BMW M2 Competition 2023</div>
                                            <div class="car-specs">
                                                <div class="spec-item">
                                                    <i class="fas fa-user"></i> 2 Seats
                                                </div>
                                                <div class="spec-item">
                                                    <i class="fas fa-suitcase"></i> 1 Bag
                                                </div>
                                                <div class="spec-item">
                                                    <i class="fas fa-gas-pump"></i> Petrol
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="order-info">
                                            <div class="info-item">
                                                <span class="info-label">Customer:</span>
                                                <span class="info-value highlight">Sarah Williams</span>
                                            </div>
                                            <div class="info-item">
                                                <span class="info-label">Pickup Date:</span>
                                                <span class="info-value">March 18, 2023</span>
                                            </div>
                                            <div class="info-item">
                                                <span class="info-label">Return Date:</span>
                                                <span class="info-value">March 25, 2023</span>
                                            </div>
                                            <div class="info-item">
                                                <span class="info-label">Location:</span>
                                                <span class="info-value">Miami Airport</span>
                                            </div>
                                            <div class="info-item">
                                                <span class="info-label">Total Amount:</span>
                                                <span class="info-value highlight">$1,708.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="order-actions">
                                        <button class="btn-action btn-reject" onclick="handleOrderAction('reject', 'ORD-2023-002')">Reject</button>
                                        <button class="btn-action btn-approve" onclick="handleOrderAction('approve', 'ORD-2023-002')">Approve</button>
                                    </div>
                                </div>

                                <!-- Order 3: Approved -->
                                <div class="order-item approved" data-order-id="ORD-2023-003" data-status="approved">
                                    <div class="order-header">
                                        <div class="order-id">ORD-2023-003 - Ferrari Enzo</div>
                                        <div class="order-status status-approved">Approved</div>
                                    </div>
                                    
                                    <div class="order-details">
                                        <div class="order-car">
                                            <div class="car-image">
                                                <img src="https://images.unsplash.com/photo-1580273916550-e323be2ae537?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80" alt="Ferrari Enzo">
                                            </div>
                                            <div class="car-name">Ferrari Enzo 2022</div>
                                            <div class="car-specs">
                                                <div class="spec-item">
                                                    <i class="fas fa-user"></i> 2 Seats
                                                </div>
                                                <div class="spec-item">
                                                    <i class="fas fa-suitcase"></i> 1 Bag
                                                </div>
                                                <div class="spec-item">
                                                    <i class="fas fa-gas-pump"></i> Petrol
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="order-info">
                                            <div class="info-item">
                                                <span class="info-label">Customer:</span>
                                                <span class="info-value highlight">Robert Chen</span>
                                            </div>
                                            <div class="info-item">
                                                <span class="info-label">Pickup Date:</span>
                                                <span class="info-value">March 10, 2023</span>
                                            </div>
                                            <div class="info-item">
                                                <span class="info-label">Return Date:</span>
                                                <span class="info-value">March 12, 2023</span>
                                            </div>
                                            <div class="info-item">
                                                <span class="info-label">Location:</span>
                                                <span class="info-value">Las Vegas</span>
                                            </div>
                                            <div class="info-item">
                                                <span class="info-label">Total Amount:</span>
                                                <span class="info-value highlight">$2,500.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                </div>

                                <!-- Order 4: Rejected -->
                                <div class="order-item rejected" data-order-id="ORD-2023-004" data-status="rejected">
                                    <div class="order-header">
                                        <div class="order-id">ORD-2023-004 - Toyota Rav 4</div>
                                        <div class="order-status status-rejected">Rejected</div>
                                    </div>
                                    
                                    <div class="order-details">
                                        <div class="order-car">
                                            <div class="car-image">
                                                <img src="https://images.unsplash.com/photo-1553440569-bcc63803a83d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80" alt="Toyota Rav 4">
                                            </div>
                                            <div class="car-name">Toyota Rav 4 2023</div>
                                            <div class="car-specs">
                                                <div class="spec-item">
                                                    <i class="fas fa-user"></i> 5 Seats
                                                </div>
                                                <div class="spec-item">
                                                    <i class="fas fa-suitcase"></i> 3 Bags
                                                </div>
                                                <div class="spec-item">
                                                    <i class="fas fa-gas-pump"></i> Hybrid
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="order-info">
                                            <div class="info-item">
                                                <span class="info-label">Customer:</span>
                                                <span class="info-value highlight">Emma Davis</span>
                                            </div>
                                            <div class="info-item">
                                                <span class="info-label">Pickup Date:</span>
                                                <span class="info-value">March 5, 2023</span>
                                            </div>
                                            <div class="info-item">
                                                <span class="info-label">Return Date:</span>
                                                <span class="info-value">March 10, 2023</span>
                                            </div>
                                            <div class="info-item">
                                                <span class="info-label">Location:</span>
                                                <span class="info-value">Chicago → Detroit</span>
                                            </div>
                                            <div class="info-item">
                                                <span class="info-label">Total Amount:</span>
                                                <span class="info-value highlight">$850.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                </div>
                            </div>

                            <div id="empty-orders" class="empty-state" style="display: none;">
                                <div class="empty-icon">
                                    <i class="fas fa-clipboard-list"></i>
                                </div>
                                <h5>No orders found</h5>
                                <p>There are no orders matching your current filter.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Car Management Content -->
                    <div id="cars-section" class="content-section">
                        <div class="car-management-card fade-in">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h3 class="card-title mb-0">Car Inventory Management</h3>
                                <span class="badge bg-primary">Manage fleet and availability</span>
                            </div>

                            <!-- Car Management Tabs -->
                            <div class="car-tabs">
                                <button class="car-tab active" data-tab="view-cars" onclick="switchCarTab('view-cars')">
                                    <i class="fas fa-list me-2"></i>View All Cars
                                </button>
                                <button class="car-tab" data-tab="add-car" onclick="switchCarTab('add-car')">
                                    <i class="fas fa-plus-circle me-2"></i>Add New Car
                                </button>
                                <button class="car-tab" data-tab="manage-quantity" onclick="switchCarTab('manage-quantity')">
                                    <i class="fas fa-boxes me-2"></i>Manage Quantity
                                </button>
                            </div>

                            <!-- View All Cars Tab -->
                            <div id="view-cars" class="car-tab-content active">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h5 class="mb-0">Fleet Overview</h5>
                                    
                                </div>

                                <div class="car-list" id="car-list-container">
                                    <!-- Car 1: Jeep Renegade -->
                                    <div class="car-item" data-car-id="CAR-001" data-available="3" data-quantity="5" data-status="available">
                                        <div class="car-image-container">
                                            <img src="https://images.unsplash.com/photo-1503376780353-7e6692767b70?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80" alt="Jeep Renegade">
                                            <span class="availability-badge available">
                                                Available (3/5)
                                            </span>
                                        </div>
                                        <div class="car-info">
                                            <div class="car-name">Jeep Renegade 2023</div>
                                            <div class="car-details">
                                                <span>$265/day</span>
                                                <span>SUV</span>
                                            </div>
                                            <div class="car-specs">
                                                <span class="spec-badge">
                                                    <i class="fas fa-user me-1"></i>4 seats
                                                </span>
                                                <span class="spec-badge">
                                                    <i class="fas fa-suitcase me-1"></i>2 bags
                                                </span>
                                                <span class="spec-badge">
                                                    <i class="fas fa-gas-pump me-1"></i>Petrol
                                                </span>
                                                <span class="spec-badge">
                                                    Automatic
                                                </span>
                                            </div>
                                            <div class="car-actions">
                                                
                                                <button class="btn-delete" onclick="deleteCar('CAR-001')">
                                                    <i class="fas fa-trash me-1"></i>Delete
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Car 2: BMW M2 -->
                                    <div class="car-item" data-car-id="CAR-002" data-available="1" data-quantity="2" data-status="low-stock">
                                        <div class="car-image-container">
                                            <img src="https://images.unsplash.com/photo-1555215695-3004980ad54e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80" alt="BMW M2">
                                            <span class="availability-badge low-stock">
                                                Low Stock (1/2)
                                            </span>
                                        </div>
                                        <div class="car-info">
                                            <div class="car-name">BMW M2 Competition 2023</div>
                                            <div class="car-details">
                                                <span>$450/day</span>
                                                <span>Sports Car</span>
                                            </div>
                                            <div class="car-specs">
                                                <span class="spec-badge">
                                                    <i class="fas fa-user me-1"></i>2 seats
                                                </span>
                                                <span class="spec-badge">
                                                    <i class="fas fa-suitcase me-1"></i>1 bag
                                                </span>
                                                <span class="spec-badge">
                                                    <i class="fas fa-gas-pump me-1"></i>Petrol
                                                </span>
                                                <span class="spec-badge">
                                                    Manual
                                                </span>
                                            </div>
                                            <div class="car-actions">
                                                
                                                <button class="btn-delete" onclick="deleteCar('CAR-002')">
                                                    <i class="fas fa-trash me-1"></i>Delete
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Car 3: Toyota Camry -->
                                    <div class="car-item" data-car-id="CAR-003" data-available="5" data-quantity="8" data-status="available">
                                        <div class="car-image-container">
                                            <img src="https://images.unsplash.com/photo-1605559424843-9e4c228bf1c2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80" alt="Toyota Camry">
                                            <span class="availability-badge available">
                                                Available (5/8)
                                            </span>
                                        </div>
                                        <div class="car-info">
                                            <div class="car-name">Toyota Camry 2023</div>
                                            <div class="car-details">
                                                <span>$85/day</span>
                                                <span>Sedan</span>
                                            </div>
                                            <div class="car-specs">
                                                <span class="spec-badge">
                                                    <i class="fas fa-user me-1"></i>5 seats
                                                </span>
                                                <span class="spec-badge">
                                                    <i class="fas fa-suitcase me-1"></i>3 bags
                                                </span>
                                                <span class="spec-badge">
                                                    <i class="fas fa-gas-pump me-1"></i>Hybrid
                                                </span>
                                                <span class="spec-badge">
                                                    Automatic
                                                </span>
                                            </div>
                                            <div class="car-actions">
                                                
                                                <button class="btn-delete" onclick="deleteCar('CAR-003')">
                                                    <i class="fas fa-trash me-1"></i>Delete
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Car 4: Ford F-150 -->
                                    <div class="car-item" data-car-id="CAR-004" data-available="0" data-quantity="3" data-status="out-of-stock">
                                        <div class="car-image-container">
                                            <img src="https://images.unsplash.com/photo-1580273916550-e323be2ae537?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80" alt="Ford F-150">
                                            <span class="availability-badge out-of-stock">
                                                Out of Stock (0/3)
                                            </span>
                                        </div>
                                        <div class="car-info">
                                            <div class="car-name">Ford F-150 2023</div>
                                            <div class="car-details">
                                                <span>$120/day</span>
                                                <span>Pickup Truck</span>
                                            </div>
                                            <div class="car-specs">
                                                <span class="spec-badge">
                                                    <i class="fas fa-user me-1"></i>5 seats
                                                </span>
                                                <span class="spec-badge">
                                                    <i class="fas fa-suitcase me-1"></i>4 bags
                                                </span>
                                                <span class="spec-badge">
                                                    <i class="fas fa-gas-pump me-1"></i>Diesel
                                                </span>
                                                <span class="spec-badge">
                                                    Automatic
                                                </span>
                                            </div>
                                            <div class="car-actions">
                                                
                                                <button class="btn-delete" onclick="deleteCar('CAR-004')">
                                                    <i class="fas fa-trash me-1"></i>Delete
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="empty-cars" class="empty-state" style="display: none;">
                                    <div class="empty-icon">
                                        <i class="fas fa-car"></i>
                                    </div>
                                    <h5>No cars found</h5>
                                    <p>There are no cars matching your current filter.</p>
                                </div>
                            </div>

                            <!-- Add New Car Tab -->
                            <div id="add-car" class="car-tab-content">
                                <h5 class="mb-4">Add New Car to Inventory</h5>
                                
                                <form id="addCarForm" class="add-car-form" onsubmit="return addNewCar()">
                                    <!-- Basic Information -->
                                    <div class="form-section">
                                        <h6 class="form-section-title">Basic Information</h6>
                                        <div class="form-row">
                                            <div class="form-group">
                                                <label for="car-brand">Brand *</label>
                                                <input type="text" id="car-brand" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="car-model">Model *</label>
                                                <input type="text" id="car-model" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="car-year">Year *</label>
                                                <input type="number" id="car-year" class="form-control" min="2010" max="2024" value="2023" required>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Specifications -->
                                    <div class="form-section">
                                        <h6 class="form-section-title">Specifications</h6>
                                        <div class="form-row">
                                            <div class="form-group">
                                                <label for="car-type">Vehicle Type *</label>
                                                <select id="car-type" class="form-control" required>
                                                    <option value="">Select Type</option>
                                                    <option value="sedan">Sedan</option>
                                                    <option value="suv">SUV</option>
                                                    <option value="coupe">Coupe</option>
                                                    <option value="convertible">Convertible</option>
                                                    <option value="hatchback">Hatchback</option>
                                                    <option value="pickup">Pickup Truck</option>
                                                    <option value="luxury">Luxury</option>
                                                    <option value="sports">Sports Car</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="car-transmission">Transmission *</label>
                                                <select id="car-transmission" class="form-control" required>
                                                    <option value="">Select Transmission</option>
                                                    <option value="automatic">Automatic</option>
                                                    <option value="manual">Manual</option>
                                                    <option value="semi-automatic">Semi-Automatic</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="car-fuel">Fuel Type *</label>
                                                <select id="car-fuel" class="form-control" required>
                                                    <option value="">Select Fuel Type</option>
                                                    <option value="petrol">Petrol</option>
                                                    <option value="diesel">Diesel</option>
                                                    <option value="electric">Electric</option>
                                                    <option value="hybrid">Hybrid</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="form-row">
                                            <div class="form-group">
                                                <label for="car-seats">Number of Seats *</label>
                                                <input type="number" id="car-seats" class="form-control" min="1" max="10" value="5" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="car-bags">Luggage Capacity (bags) *</label>
                                                <input type="number" id="car-bags" class="form-control" min="1" max="6" value="2" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="car-mileage">Mileage (km per liter)</label>
                                                <input type="number" id="car-mileage" class="form-control" min="5" max="30" value="12">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Rental Information -->
                                    <div class="form-section">
                                        <h6 class="form-section-title">Rental Information</h6>
                                        <div class="form-row">
                                            <div class="form-group">
                                                <label for="car-price">Daily Rental Price ($) *</label>
                                                <input type="number" id="car-price" class="form-control" min="10" max="1000" step="0.01" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="car-quantity">Initial Quantity *</label>
                                                <div class="quantity-control">
                                                    <button type="button" class="qty-btn" id="decrease-qty" onclick="decreaseQuantity()">-</button>
                                                    <input type="number" id="car-quantity" class="form-control qty-input" value="1" min="1" max="20" required>
                                                    <button type="button" class="qty-btn" id="increase-qty" onclick="increaseQuantity()">+</button>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>

                                    <!-- Additional Information -->
                                    <div class="form-section">
                                        <h6 class="form-section-title">Additional Information</h6>
                                        <div class="form-group">
                                            <label for="car-image">Car Image URL</label>
                                            <input type="url" id="car-image" class="form-control" placeholder="https://example.com/car-image.jpg">
                                            <small class="text-muted">Leave empty to use default image</small>
                                        </div>
                                        <div class="form-group">
                                            <label for="car-features">Features (comma separated)</label>
                                            <input type="text" id="car-features" class="form-control" placeholder="GPS, Bluetooth, Air Conditioning, etc.">
                                        </div>
                                        <div class="form-group">
                                            <label for="car-description">Description</label>
                                            <textarea id="car-description" class="form-control" rows="3" placeholder="Brief description of the car..."></textarea>
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="text-end mt-4">
                                        <button type="button" class="btn btn-secondary me-2" onclick="resetCarForm()">Reset Form</button>
                                        <button type="submit" class="btn-submit">
                                            <i class="fas fa-plus-circle me-2"></i>Add Car to Inventory
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- Manage Quantity Tab -->
                            <div id="manage-quantity" class="car-tab-content">
                                <h5 class="mb-4">Update Car Quantities</h5>
                                <p class="text-muted mb-4">Adjust the available quantity for each car in your fleet</p>

                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Car Model</th>
                                                <th>Current Quantity</th>
                                                <th>Available</th>
                                                <th>Rented</th>
                                                <th>Update Quantity</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody id="quantity-table">
                                            <!-- Car 1 Quantity -->
                                            <tr data-car-id="CAR-001">
                                                <td>
                                                    <strong>Jeep Renegade</strong><br>
                                                    <small class="text-muted">ID: CAR-001</small>
                                                </td>
                                                <td>
                                                    <span class="badge bg-primary">5</span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-success">3</span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-info">2</span>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm" style="width: 150px;">
                                                        <input type="number" class="form-control qty-update" value="5" min="0" max="50" id="qty-CAR-001">
                                                        <button class="btn btn-outline-primary" type="button" onclick="updateQuantity('CAR-001')">
                                                            Update
                                                        </button>
                                                    </div>
                                                </td>
                                                
                                            </tr>
                                            
                                            <!-- Car 2 Quantity -->
                                            <tr data-car-id="CAR-002">
                                                <td>
                                                    <strong>BMW M2 Competition</strong><br>
                                                    <small class="text-muted">ID: CAR-002</small>
                                                </td>
                                                <td>
                                                    <span class="badge bg-primary">2</span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-warning">1</span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-info">1</span>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm" style="width: 150px;">
                                                        <input type="number" class="form-control qty-update" value="2" min="0" max="50" id="qty-CAR-002">
                                                        <button class="btn btn-outline-primary" type="button" onclick="updateQuantity('CAR-002')">
                                                            Update
                                                        </button>
                                                    </div>
                                                </td>
                                                
                                            </tr>
                                            
                                            <!-- Car 3 Quantity -->
                                            <tr data-car-id="CAR-003">
                                                <td>
                                                    <strong>Toyota Camry</strong><br>
                                                    <small class="text-muted">ID: CAR-003</small>
                                                </td>
                                                <td>
                                                    <span class="badge bg-primary">8</span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-success">5</span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-info">3</span>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm" style="width: 150px;">
                                                        <input type="number" class="form-control qty-update" value="8" min="0" max="50" id="qty-CAR-003">
                                                        <button class="btn btn-outline-primary" type="button" onclick="updateQuantity('CAR-003')">
                                                            Update
                                                        </button>
                                                    </div>
                                                </td>
                                                
                                            </tr>
                                            
                                            <!-- Car 4 Quantity -->
                                            <tr data-car-id="CAR-004">
                                                <td>
                                                    <strong>Ford F-150</strong><br>
                                                    <small class="text-muted">ID: CAR-004</small>
                                                </td>
                                                <td>
                                                    <span class="badge bg-primary">3</span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-danger">0</span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-info">3</span>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm" style="width: 150px;">
                                                        <input type="number" class="form-control qty-update" value="3" min="0" max="50" id="qty-CAR-004">
                                                        <button class="btn btn-outline-primary" type="button" onclick="updateQuantity('CAR-004')">
                                                            Update
                                                        </button>
                                                    </div>
                                                </td>
                                                
                                            </tr>
                                        </tbody>
                                    </table>
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
                            <p class="signout-message">Are you sure you want to sign out of your employee account?</p>
                            <p class="text-muted mb-4">You will need to sign in again to access the dashboard.</p>

                            <div class="d-flex justify-content-center gap-3">
                                <button class="btn btn-update" onclick="cancelSignout()">Cancel</button>
                                <button class="btn btn-confirm-signout" onclick="confirmSignout()">Sign Out</button>
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
        // Simple JavaScript for UI interactions (no dynamic data loading)
        
        // Navigation functionality
        document.addEventListener('DOMContentLoaded', function () {
            // Menu button click handlers
            const menuButtons = document.querySelectorAll('.menu-button');
            const contentSections = document.querySelectorAll('.content-section');
            
            menuButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const sectionId = this.getAttribute('data-section');
                    
                    // Update active menu button
                    menuButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                    
                    // Show corresponding content section
                    contentSections.forEach(section => {
                        section.classList.remove('active');
                        if (section.id === `${sectionId}-section`) {
                            section.classList.add('active');
                        }
                    });
                });
            });
            
            // Initialize first tab in car management
            switchCarTab('view-cars');
        });
        
        // Car Management Tabs
        function switchCarTab(tabId) {
            // Update active tab
            document.querySelectorAll('.car-tab').forEach(tab => {
                tab.classList.remove('active');
                if (tab.getAttribute('data-tab') === tabId) {
                    tab.classList.add('active');
                }
            });
            
            // Show corresponding content
            document.querySelectorAll('.car-tab-content').forEach(content => {
                content.classList.remove('active');
                if (content.id === tabId) {
                    content.classList.add('active');
                }
            });
        }
        
        // Order filtering
        function filterOrders(status) {
            const orders = document.querySelectorAll('.order-item');
            const emptyState = document.getElementById('empty-orders');
            
            // Update filter button active state
            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.classList.remove('active');
                if (btn.textContent.includes(status.charAt(0).toUpperCase() + status.slice(1)) || 
                    (status === 'all' && btn.textContent.includes('All Orders'))) {
                    btn.classList.add('active');
                }
            });
            
            let visibleCount = 0;
            
            orders.forEach(order => {
                const orderStatus = order.getAttribute('data-status');
                if (status === 'all' || orderStatus === status) {
                    order.style.display = 'block';
                    visibleCount++;
                } else {
                    order.style.display = 'none';
                }
            });
            
            // Show/hide empty state
            if (visibleCount === 0) {
                emptyState.style.display = 'block';
            } else {
                emptyState.style.display = 'none';
            }
        }
        
        
        
        // Car filtering
        function filterCars() {
            const filter = document.getElementById('car-filter').value;
            const cars = document.querySelectorAll('.car-item');
            const emptyState = document.getElementById('empty-cars');
            
            let visibleCount = 0;
            
            cars.forEach(car => {
                const status = car.getAttribute('data-status');
                if (filter === 'all' || status === filter) {
                    car.style.display = 'block';
                    visibleCount++;
                } else {
                    car.style.display = 'none';
                }
            });
            
            // Show/hide empty state
            if (visibleCount === 0) {
                emptyState.style.display = 'block';
            } else {
                emptyState.style.display = 'none';
            }
        }
        
        
        
    </script>
</body>

</html>
