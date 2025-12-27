<!DOCTYPE html>
<html lang="en">
<?php
include '../includes/db.php';
session_start();
 
// Retrieve errors from session if they exist
if (isset($_SESSION["errors"])) {
    $error = $_SESSION["errors"];
    unset($_SESSION["errors"]);
}
 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $state = $connect->prepare("SELECT CUSTID FROM customer ORDER BY CUSTID DESC LIMIT 1");
    $state->execute();
    $result = $state->get_result();
    $row = $result->fetch_assoc();
   
    if ($row) {
        $custid = $row['CUSTID'];
        $code = substr($custid, 0, 3);
        $nb = substr($custid, 3);
        $nb = (int)$nb + 1;
        $id = $code . str_pad($nb, 3, "0", STR_PAD_LEFT);
    } else {
        $id = "CUS001";
    }
   
    if (isset($_POST["firstName"])) {
        $fname = $_POST["firstName"];
    }
    if (isset($_POST["lastName"])) {
        $lname = $_POST["lastName"];
    }
    if (isset($_POST["phone"])) {
        $phone = (int) $_POST["phone"];
    }
    if (isset($_POST["password"])) {
        $pass = $_POST["password"];
    }
    if (isset($_POST["email"])) {
        $email = $_POST["email"];
    }
    if (isset($_POST["confirmPassword"])) {
        $confirm = $_POST["confirmPassword"];
    }
    if (isset($_POST["address"])) {
        $address = $_POST["address"];
    }
    if (isset($_POST["license"])) {
        $license = $_POST["license"];
    }
   
    $error = [];
   
    if (isset($_POST["firstName"])) {
        if (!filter_var($fname, FILTER_SANITIZE_STRING)) {
            $error["invalid_fname"] = 1;
        }
    }
    if (isset($_POST["lastName"])) {
        if (!filter_var($lname, FILTER_SANITIZE_STRING)) {
            $error["invalid_lname"] = 1;
        }
    }
    if (isset($_POST["password"])) {
        if (filter_var($pass, FILTER_SANITIZE_STRING)) {
            if (!preg_match("/^[A-Za-z]{4,}.*\d+.*$/", $pass)) {
                $error["password_match_error"] = 1;
            }
 
            if ($confirm != $pass) {
                $error["the_two_password_doesn't_match"] = 1;
            }
        } else {
            $error["incorret_password"] = 1;
        }
    }
    if (isset($_POST["email"])) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error["invalid_email"] = 1;
        }
    }
    if (isset($_POST["phone"])) {
        if (!preg_match("/^\d{8}$/", $phone)) {
            $error["invalid_phonenumber"] = 1;
        }
    }
    if (isset($_POST["license"])) {
        if (!filter_var($license, FILTER_SANITIZE_STRING)) {
            $error["license_illegale"] = 1;
        }
    }
    if (isset($_POST["address"])) {
        if (!filter_var($address, FILTER_SANITIZE_STRING)) {
            $error["invalid_adress"] = 1;
        }
    }
 
    /// insert to data base
 if (isset($_POST["employee"]) && empty($error)) {

    $query = "
    INSERT INTO employee
    (EMPID, EMPNAME, ROLE, PHONE, EMAIL, PRINTINVOICE, Password, remember_token, remember_expiry)
    VALUES (?, ?, NULL, ?, ?, NULL, ?, NULL, NULL)
    ";

    $stmt = $connect->prepare($query);

    $pass1 = password_hash($pass, PASSWORD_DEFAULT);
    $name1 = $fname . " " . $lname;

    $stmt->bind_param(
        "ssiss",
        $id,       // EMPID
        $name1,    // EMPNAME
        $phone,    // PHONE (INT)
        $email,    // EMAIL
        $pass1     // Password (HASH)
    );

    $stmt->execute();

    header("Location: login.php");
    exit();
}
if (isset($_POST["customer"]) && empty($error)) {

    $query = "
    INSERT INTO customer
    (CUSTID, CUSTNAME, PHONE, ADDRESS, DRIVERLISENCE, EMAIL, Password, remember_token, remember_expiry)
    VALUES (?, ?, ?, ?, ?, ?, ?, NULL, NULL)
    ";

    $stmt = $connect->prepare($query);

    $pass1 = password_hash($pass, PASSWORD_DEFAULT);
    $name1 = $fname . " " . $lname;

    $stmt->bind_param(
        "ssissss",
        $id,        // CUSTID
        $name1,     // CUSTNAME
        $phone,     // PHONE (INT)
        $address,   // ADDRESS
        $license,   // DRIVERLISENCE
        $email,     // EMAIL
        $pass1      // Password
    );

    $stmt->execute();
    $stmt->close();
    header("Location: login.php");
    exit();
}
   
    if (!empty($error)) {
        $_SESSION["errors"] = $error;
        header("Location:register.php");
        exit();
    }
}
?>
 
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
            background: #121212;
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
    <header>
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
 
    <!-- Register Section -->
    <section class="register-section">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-6 col-md-8">
                    <div class="register-box animated">
                        <h4>Create Your Account</h4>
                        <form id="form_register" method="post">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="firstName" class="form-label">First Name</label>
                                        <input type="text" name="firstName" id="firstName" class="form-control" placeholder="Enter your first name" required <?php if (isset($error["invalid_fname"])) {
                                            echo "style='border-bottom-color:red;'";
                                        } ?> />
                                       
                                        <?php
                                        if (isset($error["invalid_fname"])) {
                                            echo "<span style='color:red;'>invalid name enter a valid one</span>";
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="lastName" class="form-label">Last Name</label>
                                        <input type="text" name="lastName" id="lastName" class="form-control" placeholder="Enter your last name" required <?php if (isset($error["invalid_lname"])) {
                                            echo "style='border-bottom-color:red;'";
                                        } ?> />
                                       
                                        <?php
                                        if (isset($error["invalid_lname"])) {
                                            echo "<span style='color:red;'>invalid lstname enter a valid one</span>";
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
 
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" required <?php if (isset($error["invalid_email"])) {
                                    echo "style='border-bottom-color:red'";
                                } ?>/>
                             
                                <?php
                                if (isset($error["invalid_email"])) {
                                    echo "<span style='color:red;'> enter a valid email</span>";
                                }
                                ?>
                            </div>
 
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" name="phone" id="phone" class="form-control" placeholder="Enter your phone number" required <?php if (isset($error["invalid_phonenumber"])) {
                                    echo "style='border-bottom-color:red'";
                                } ?>/>
                             
                                <?php
                                if (isset($error["invalid_phonenumber"])) {
                                    echo "<span style='color:red;'>enter a valid number</span>";
                                }
                                ?>
                            </div>
 
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" name="password" id="password" class="form-control" placeholder="Create a password" required <?php if (isset($error["incorret_password"]) || isset($error["password_match_error"])) {
                                            echo "style='border-bottom-color:red'";
                                        } ?>/>
                                     
                                        <?php
                                        if (isset($error["incorret_password"])) {
                                            echo "<span style='color:red;'>incorrect password.enter a valid one </span>";
                                        } elseif (isset($error["password_match_error"])) {
                                            echo "<span style='color:red;'> password need at least 4 characters and 1 number</span>";
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="confirmPassword" class="form-label">Confirm Password</label>
                                        <input type="password" name="confirmPassword" id="confirmPassword" class="form-control" placeholder="Confirm your password" required <?php if (isset($error["the_two_password_doesn't_match"])) {
                                            echo "style='border-bottom-color:red'";
                                        } ?>/>
                                       
                                        <?php
                                        if (isset($error["the_two_password_doesn't_match"])) {
                                            echo "<span style='color:red;'> the two passwords don't match</span>";
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
 
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" name="address" id="address" class="form-control" placeholder="Enter your address" <?php if (isset($error["invalid_adress"])) {
                                    echo "style='border-bottom-color:red'";
                                }
                                ?> />
                               
                                <?php
                                if (isset($error["invalid_adress"])) {
                                    echo "<span style='color:red;'> invalid.enter a real adress</span>";
                                }
                                ?>
                            </div>
 
                            <div class="mb-3">
                                <label for="license" class="form-label">Drive license</label>
                                <input type="text" name="license" id="license" class="form-control" placeholder="Enter your driver license id" <?php if (isset($error["license_illegale"])) {
                                    echo "style='border-bottom-color:red'";
                                } ?> />
                             
                                <?php if (isset($error["license_illegale"])) {
                                    echo "<span style='color:red;'> illegale license</span>";
                                }
                                ?>
                            </div>
 
                            <div class="mb-4">
                                <button type="submit" name="customer" class="btn-register btn-customer">
                                    <i class="fas fa-user-plus me-2"></i> Register as Customer
                                </button>
 
                                <button type="submit" name="employee" class="btn-register btn-employee mt-3">
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
            }, {
                threshold: 0.1
            });
 
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
