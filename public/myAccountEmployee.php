<?php
session_start();
include("../includes/db.php");
// require_once "../includes/log.php";
// use after eash operation this function     writeLog("login.php", "User {$email} logged in successfully");

// Check if logged in 
if (!isset($_SESSION['employee_id'])) {
    header("Location:login.php");
    exit();
}

// Get employee details
$employee_id = $_SESSION['employee_id'];
$employee_query = "SELECT * FROM employee WHERE EMPID = ?";
$stmt = $connect->prepare($employee_query);
$stmt->bind_param("s", $employee_id);
$stmt->execute();
$employee_result = $stmt->get_result();
$employee = $employee_result->fetch_assoc();

// Check if employee exists 
if (!$employee) {
    header("Location:login.php");
    exit();
}

// Function to process returned rentals (maintenance system)
function processReturnedRentals($connect) {
    // Find completed rentals that need maintenance
    $sql = "SELECT r.RENTALID, r.CARID, c.CARNAME 
            FROM rental r 
            JOIN car c ON r.CARID = c.CARID 
            WHERE r.STATUS = 'Completed' 
            AND r.DROPOFFDATE < CURDATE()
            AND r.CARID NOT IN (
                SELECT CARID FROM maintanance 
                WHERE MAINDATE >= CURDATE() - INTERVAL 30 DAY
            )
            AND c.CAR_STATUS = 'Available'";
    
    $result = $connect->query($sql);
    $completedRentals = [];
    if ($result) {
        $completedRentals = $result->fetch_all(MYSQLI_ASSOC);
    }
    
    foreach ($completedRentals as $rental) {
        $maintenanceDays = rand(15, 30);
        $maintenanceStartDate = date('Y-m-d');
        $maintenanceId = 'MAINT' . str_pad(rand(100, 999), 3, '0', STR_PAD_LEFT);
        
        $maintenanceTasks = [
            "Oil change and filter replacement",
            "Brake inspection and service",
            "Tire rotation and pressure check",
            "Engine diagnostics and tune-up",
            "Transmission fluid check",
            "Coolant system check",
            "Air conditioning service",
            "Interior deep cleaning",
            "Exterior wash and wax",
            "Safety inspection"
        ];
        
        $randomTask = $maintenanceTasks[array_rand($maintenanceTasks)];
        $description = "Post-rental maintenance for car #{$rental['CARID']} - $randomTask";
        $cost = rand(100, 500) + (rand(0, 99) / 100);
        
        // Check if maintenance already exists for this car today
        $check_stmt = $connect->prepare("SELECT MAINTANANCEID FROM maintanance WHERE CARID = ? AND MAINDATE = ?");
        $check_stmt->bind_param("ss", $rental['CARID'], $maintenanceStartDate);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
        
        if ($check_result->num_rows == 0) {
            // Insert maintenance record
            $stmt = $connect->prepare("INSERT INTO maintanance (MAINTANANCEID, CARID, MAINDATE, DESCRIPTON, COST) 
                                       VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssd", $maintenanceId, $rental['CARID'], $maintenanceStartDate, $description, $cost);
            $stmt->execute();
            
            // Update car status to 'Maintenance'
            $stmt = $connect->prepare("UPDATE car SET CAR_STATUS = 'Maintenance' WHERE CARID = ?");
            $stmt->bind_param("s", $rental['CARID']);
            $stmt->execute();
        }
    }
    
    // Check for completed maintenance and return cars to inventory
    $sql = "SELECT m.CARID, c.CARNAME, m.MAINDATE 
            FROM maintanance m
            JOIN car c ON m.CARID = c.CARID
            WHERE c.CAR_STATUS = 'Maintenance'
            AND DATE_ADD(m.MAINDATE, INTERVAL 14 DAY) <= CURDATE()";
    
    $result = $connect->query($sql);
    $completedMaintenance = [];
    if ($result) {
        $completedMaintenance = $result->fetch_all(MYSQLI_ASSOC);
    }
    
    foreach ($completedMaintenance as $car) {
        $stmt = $connect->prepare("UPDATE car SET CAR_STATUS = 'Available' WHERE CARID = ?");
        $stmt->bind_param("s", $car['CARID']);
        $stmt->execute();
    }
}

// Process returned rentals (ONLY ONCE PER SESSION)
if (!isset($_SESSION['maintenance_processed'])) {
    processReturnedRentals($connect);
    $_SESSION['maintenance_processed'] = true;
}

$success = '';
$error = '';

// Statistics from database
// Total orders
$total_order_query = "SELECT COUNT(*) as total FROM rental";
$total_order_result = $connect->query($total_order_query);
$total_order_row = $total_order_result->fetch_assoc();
$total_order = $total_order_row['total'] ?? 0;

// Pending orders (using 'Ongoing' status from your database)
$pending_order_query = "SELECT COUNT(*) as pending FROM rental WHERE STATUS = 'Ongoing'";
$pending_order_result = $connect->query($pending_order_query);
$pending_order_row = $pending_order_result->fetch_assoc();
$pending_order = $pending_order_row['pending'] ?? 0;

// Approved orders (completed rentals)
$approved_order_query = "SELECT COUNT(*) as approved FROM rental WHERE STATUS = 'Completed'";
$approved_order_result = $connect->query($approved_order_query);
$approved_order_row = $approved_order_result->fetch_assoc();
$approved_order = $approved_order_row['approved'] ?? 0;

// Rejected orders
$rejected_order_query = "SELECT COUNT(*) as rejected FROM rental WHERE STATUS = 'Rejected'";
$rejected_order_result = $connect->query($rejected_order_query);
$rejected_order_row = $rejected_order_result->fetch_assoc();
$rejected_order = $rejected_order_row['rejected'] ?? 0;

// Cars statistics - FIXED: Use COUNT instead of SUM for number of car models
$total_car_query = "SELECT COUNT(*) as total FROM car";
$total_car_result = $connect->query($total_car_query);
$total_car_row = $total_car_result->fetch_assoc();
$total_car = $total_car_row['total'] ?? 0;

$available_car_query = "SELECT COUNT(*) as available FROM car WHERE CAR_STATUS = 'Available'";
$available_car_result = $connect->query($available_car_query);
$available_car_row = $available_car_result->fetch_assoc();
$available_car = $available_car_row['available'] ?? 0;

// Low stock cars - FIXED: Check quantity < 3
$low_stock_car_query = "SELECT COUNT(*) as low_stock FROM car WHERE Quantity < 3 AND Quantity > 0";
$low_stock_car_result = $connect->query($low_stock_car_query);
$low_stock_car_row = $low_stock_car_result->fetch_assoc();
$low_stock_car = $low_stock_car_row['low_stock'] ?? 0;

// Pending orders list for dashboard
$pending_order_list_query = "SELECT r.*, c.CUSTNAME, ca.CARNAME, ca.daily_price, 
                            DATEDIFF(r.DROPOFFDATE, r.PICKUPDATE) as days,
                            (DATEDIFF(r.DROPOFFDATE, r.PICKUPDATE) * ca.daily_price) as total_price
                            FROM rental r
                            JOIN customer c ON r.CUSTID = c.CUSTID
                            JOIN car ca ON r.CARID = ca.CARID
                            WHERE r.STATUS = 'Ongoing'
                            ORDER BY r.PICKUPDATE DESC
                            LIMIT 4";
$pending_order_list_result = $connect->query($pending_order_list_query);
$pending_orders = [];
if ($pending_order_list_result) {
    $pending_orders = $pending_order_list_result->fetch_all(MYSQLI_ASSOC);
}

// All orders for management
$all_order_query = "SELECT r.*, c.CUSTNAME, ca.CARNAME, ca.daily_price, 
                   DATEDIFF(r.DROPOFFDATE, r.PICKUPDATE) as days,
                   (DATEDIFF(r.DROPOFFDATE, r.PICKUPDATE) * ca.daily_price) as total_price
                   FROM rental r
                   JOIN customer c ON r.CUSTID = c.CUSTID
                   JOIN car ca ON r.CARID = ca.CARID
                   ORDER BY r.PICKUPDATE DESC";
$all_order_result = $connect->query($all_order_query);
$all_orders = [];
if ($all_order_result) {
    $all_orders = $all_order_result->fetch_all(MYSQLI_ASSOC);
}

// All cars for management
$all_car_query = "SELECT c.*, cp.URL as photo_url 
                  FROM car c 
                  LEFT JOIN car_photos cp ON c.CARID = cp.CARID AND cp.IS_MAIN = 1 
                  ORDER BY c.CARNAME";
$all_car_result = $connect->query($all_car_query);
$all_cars = [];
if ($all_car_result) {
    $all_cars = $all_car_result->fetch_all(MYSQLI_ASSOC);
}

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Add new car
    if (isset($_POST["add_car"])) {
        try {
            // Generate car ID
            $stmt = $connect->prepare("SELECT CARID FROM car ORDER BY CARID DESC LIMIT 1");
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            
            if ($row) {
                $carid = $row['CARID'];
                $code = substr($carid, 0, 3);
                $nb = substr($carid, 3);
                $nb = (int) $nb + 1;
                $id = $code . str_pad($nb, 3, "0", STR_PAD_LEFT);
            } else {
                $id = "CAR001";
            }
            
            $model = $connect->real_escape_string($_POST['model'] ?? '');
            $carname = $connect->real_escape_string($_POST['carname'] ?? '');
            $brand = $connect->real_escape_string($_POST['brand'] ?? '');
            $horse_power = intval($_POST['horse_power'] ?? 0);
            $car_year = intval($_POST['car_year'] ?? date('Y'));
            $platenumber = $connect->real_escape_string($_POST['platenumber'] ?? '');
            $daily_price = floatval($_POST['daily_price'] ?? 0);
            $car_type = $connect->real_escape_string($_POST['car_type'] ?? '');
            $bags = $connect->real_escape_string($_POST['bags'] ?? '');
            $doors = $connect->real_escape_string($_POST['doors'] ?? '');
            $seats = $connect->real_escape_string($_POST['seats'] ?? '');
            $quantity = intval($_POST['quantity'] ?? 1);
            $description = $connect->real_escape_string($_POST['description'] ?? '');
            $color = $connect->real_escape_string($_POST['color'] ?? '');
            
            // Handle photo upload
            $photo_url = '';
            $use_upload = false;
            
            // Check if file was uploaded
            if (isset($_FILES["car_photo"]) && $_FILES["car_photo"]["error"] == 0) {
                $file_name = $_FILES["car_photo"]["name"];
                $file_tmp = $_FILES["car_photo"]["tmp_name"];
                $file_size = $_FILES["car_photo"]["size"];
                
                // Check file extension
                $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
                
                if (in_array($file_extension, $allowed_extensions)) {
                    // Check file size (max 2MB)
                    if ($file_size <= 2 * 1024 * 1024) {
                        // Create uploads directory if it doesn't exist
                        $upload_dir = dirname(__FILE__) . '/../assets/img/cars/';
                        if (!file_exists($upload_dir)) {
                            mkdir($upload_dir, 0777, true);
                        }
                        
                        // Generate unique filename
                        $unique_filename = $id . '_' . time() . '.' . $file_extension;
                        $destination = $upload_dir . $unique_filename;
                        
                        // Debug: Check if destination is writable
                        if (move_uploaded_file($file_tmp, $destination)) {
                            // Store relative path for database
                            $photo_url = "assets/img/cars/" . $unique_filename;
                            $use_upload = true;
                        } else {
                            $error = "Failed to move uploaded file. Check directory permissions.";
                        }
                    } else {
                        $error = "File size too large. Maximum size is 2MB.";
                    }
                } else {
                    $error = "Invalid file type. Only JPG, JPEG, PNG, GIF, and WEBP are allowed.";
                }
            } elseif (!empty($_POST['photo_url'])) {
                $photo_url = $connect->real_escape_string($_POST['photo_url']);
            }
            
            // Check if car already exists with same plate number
            $check_car_query = "SELECT CARID FROM car WHERE PLATENUMBER = ?";
            $check_stmt = $connect->prepare($check_car_query);
            $check_stmt->bind_param("s", $platenumber);
            $check_stmt->execute();
            $check_result = $check_stmt->get_result();
            
            if ($check_result->num_rows > 0) {
                $error = "A car with this plate number already exists!";
            }
            
            // Only proceed if no error with image and car doesn't exist
            if (empty($error)) {
                // Check if all required fields are filled
                if (empty($carname) || empty($model) || empty($brand) || empty($platenumber) || empty($car_type)) {
                    $error = "Please fill all required fields!";
                } else {
                    // Insert car
                    $insert_car_query = "INSERT INTO car (CARID, MODEL, CARNAME, BRAND, HORSE_POWER, CAR_STATUS, CAR_YEAR, PLATENUMBER,
                                        daily_price, car_type, bags, Doors, Seats, Quantity, description, color)
                                        VALUES (?, ?, ?, ?, ?, 'Available', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    
                    $stmt = $connect->prepare($insert_car_query);
                    $stmt->bind_param(
                        "ssssiisssssiiss",
                        $id,
                        $model,
                        $carname,
                        $brand,
                        $horse_power,
                        $car_year,
                        $platenumber,
                        $daily_price,
                        $car_type,
                        $bags,
                        $doors,
                        $seats,
                        $quantity,
                        $description,
                        $color
                    );
                    
                    if ($stmt->execute()) {
                        // Insert photo if available
                        if (!empty($photo_url)) {
                            // Delete any existing photo for this car
                            $delete_old_photo = "DELETE FROM car_photos WHERE CARID = ? AND IS_MAIN = 1";
                            $del_stmt = $connect->prepare($delete_old_photo);
                            $del_stmt->bind_param("s", $id);
                            $del_stmt->execute();
                            
                            // Insert new photo
                            $insert_photo_query = "INSERT INTO car_photos (CARID, URL, IS_MAIN, CREATE_AT) 
                                                   VALUES (?, ?, 1, CURDATE())";
                            $stmt2 = $connect->prepare($insert_photo_query);
                            $stmt2->bind_param("ss", $id, $photo_url);
                            if (!$stmt2->execute()) {
                                $error = "Error saving photo: " . $connect->error;
                            }
                        }
                        
                        if (empty($error)) {
                            $success = "Car added successfully!";
                            // Redirect to prevent form resubmission on refresh
                            $_SESSION['success'] = "Car added successfully!";
                            header("Location: " . $_SERVER['PHP_SELF']);
                            exit();
                        }
                    } else {
                        // Check if it's a duplicate entry error
                        if (strpos($connect->error, 'Duplicate entry') !== false) {
                            $error = "This car already exists in the database!";
                        } else {
                            $error = "Error adding car: " . $connect->error;
                        }
                    }
                }
            }
        } catch (Exception $e) {
            $error = "Error adding car: " . $e->getMessage();
        }
    }
    
    // Update car quantity
    if (isset($_POST["update_quantity"])) {
        try {
            $car_id = $connect->real_escape_string($_POST["carid"]);
            $quantity = intval($_POST["quantity"]);
            
            $update_query = "UPDATE car SET Quantity = ? WHERE CARID = ?";
            $stmt = $connect->prepare($update_query);
            $stmt->bind_param("is", $quantity, $car_id);
            
            if ($stmt->execute()) {
                $success = "Quantity updated successfully!";
                // Redirect to prevent form resubmission on refresh
                $_SESSION['success'] = "Quantity updated successfully!";
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            }
        } catch (Exception $e) {
            $error = "Error updating quantity: " . $e->getMessage();
        }
    }
    
    // Delete car
    if (isset($_POST["delete_car"])) {
        try {
            $car_id = $connect->real_escape_string($_POST["carid"]);
            
            // Check if car exists in any rentals
            $check_rentals = "SELECT COUNT(*) as rental_count FROM rental WHERE CARID = ?";
            $check_stmt = $connect->prepare($check_rentals);
            $check_stmt->bind_param("s", $car_id);
            $check_stmt->execute();
            $check_result = $check_stmt->get_result();
            $rental_row = $check_result->fetch_assoc();
            
            if ($rental_row['rental_count'] > 0) {
                $error = "Cannot delete car. It has existing rentals.";
            } else {
                // Get photo URL to delete file
                $get_photo_query = "SELECT URL FROM car_photos WHERE CARID = ? AND IS_MAIN = 1";
                $stmt = $connect->prepare($get_photo_query);
                $stmt->bind_param("s", $car_id);
                $stmt->execute();
                $result = $stmt->get_result();
                $photo_row = $result->fetch_assoc();
                
                // Delete photo file if it exists locally
                if ($photo_row && !empty($photo_row['URL']) && strpos($photo_row['URL'], 'assets/img/cars/') !== false) {
                    $photo_path = dirname(__FILE__) . '/../' . $photo_row['URL'];
                    if (file_exists($photo_path)) {
                        unlink($photo_path);
                    }
                }
                
                // Delete photos from database
                $delete_photo_query = "DELETE FROM car_photos WHERE CARID = ?";
                $stmt = $connect->prepare($delete_photo_query);
                $stmt->bind_param("s", $car_id);
                $stmt->execute();
                
                // Delete the car
                $delete_query = "DELETE FROM car WHERE CARID = ?";
                $stmt = $connect->prepare($delete_query);
                $stmt->bind_param("s", $car_id);
                
                if ($stmt->execute()) {
                    $success = "Car deleted successfully!";
                    // Redirect to prevent form resubmission on refresh
                    $_SESSION['success'] = "Car deleted successfully!";
                    header("Location: " . $_SERVER['PHP_SELF']);
                    exit();
                }
            }
        } catch (Exception $e) {
            $error = "Error deleting car: " . $e->getMessage();
        }
    }
    
    // Handle order status update
    if (isset($_POST['update_order_status'])) {
        try {
            $rentalid = $connect->real_escape_string($_POST['rentalid']);
            $status = $connect->real_escape_string($_POST['status']);
            $currentDate = date('Y-m-d');
            
            // Update rental status
            $update_rental_query = "UPDATE rental SET STATUS = ? WHERE RENTALID = ?";
            $stmt = $connect->prepare($update_rental_query);
            $stmt->bind_param("ss", $status, $rentalid);
            $stmt->execute();
            
            // Get car ID for the rental
            $get_car_query = "SELECT CARID FROM rental WHERE RENTALID = ?";
            $stmt = $connect->prepare($get_car_query);
            $stmt->bind_param("s", $rentalid);
            $stmt->execute();
            $result = $stmt->get_result();
            $car_row = $result->fetch_assoc();
            $carid = $car_row['CARID'] ?? null;
            
            if ($carid) {
                if ($status == 'Rejected' || $status == 'Completed') {
                    // Return car to inventory
                    $update_car_query = "UPDATE car SET Quantity = Quantity + 1 WHERE CARID = ?";
                    $stmt = $connect->prepare($update_car_query);
                    $stmt->bind_param("s", $carid);
                    $stmt->execute();
                    
                    // If completed, update dropoff date
                    if ($status == 'Completed') {
                        $update_date_query = "UPDATE rental SET DROPOFFDATE = ? WHERE RENTALID = ?";
                        $stmt = $connect->prepare($update_date_query);
                        $stmt->bind_param("ss", $currentDate, $rentalid);
                        $stmt->execute();
                    }
                } elseif ($status == 'Ongoing') {
                    // Remove car from inventory when rented
                    $update_car_query = "UPDATE car SET Quantity = Quantity - 1 WHERE CARID = ? AND Quantity > 0";
                    $stmt = $connect->prepare($update_car_query);
                    $stmt->bind_param("s", $carid);
                    $stmt->execute();
                }
            }
            
            $success = "Order status updated successfully!";
            // Redirect to prevent form resubmission on refresh
            $_SESSION['success'] = "Order status updated successfully!";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } catch (Exception $e) {
            $error = "Error updating order status: " . $e->getMessage();
        }
    }
}

// Check for success message from redirect
if (isset($_SESSION['success'])) {
    $success = $_SESSION['success'];
    unset($_SESSION['success']);
}
if (isset($_SESSION['error'])) {
    $error = $_SESSION['error'];
    unset($_SESSION['error']);
}
?>

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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        /* Your CSS styles remain the same */
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

        .alert {
            border-radius: 10px;
            border: none;
            margin-bottom: 20px;
        }

        .dashboard-container {
            min-height: calc(100vh - 200px);
        }

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
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: var(--primary-color);
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

        /* Content Sections */
        .content-section {
            display: none !important;
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.5s ease, transform 0.5s ease;
        }

        .content-section.active {
            display: block !important;
            opacity: 1;
            transform: translateY(0);
        }

        /* Car Tab Content */
        .car-tab-content {
            display: none !important;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .car-tab-content.active {
            display: block !important;
            opacity: 1;
        }

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

        .order-item.completed {
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

        .status-completed {
            background-color: rgba(46, 204, 113, 0.15);
            color: var(--primary-dark);
        }

        .status-rejected {
            background-color: rgba(231, 76, 60, 0.15);
            color: var(--danger-color);
        }

        .car-management-card {
            background: white;
            border-radius: 15px;
            box-shadow: var(--shadow);
            padding: 30px;
            margin-bottom: 30px;
        }

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

        .maintenance {
            background: rgba(155, 89, 182, 0.15);
            color: #9b59b6;
        }

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

        @media (max-width: 992px) {
            .dashboard-sidebar {
                position: static;
                margin-bottom: 30px;
            }

            .car-list {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .order-header {
                flex-direction: column;
                align-items: flex-start;
            }
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .fade-in {
            animation: fadeIn 0.6s ease forwards;
        }
    </style>
</head>
<body>
    <!-- Dashboard Content -->
    <section class="dashboard-container py-4">
        <div class="container">
            <?php if ($success): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo $success; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            
            <?php if ($error): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo $error; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            
            <div class="row">
                <!-- Sidebar -->
                <div class="col-lg-3">
                    <div class="dashboard-sidebar">
                        <div class="sidebar-card fade-in">
                            <div class="employee-profile">
                                <div class="employee-image">
                                    <i class="fas fa-user-tie"></i>
                                </div>
                                <h3 class="employee-name"><?php echo htmlspecialchars($employee['EMPNAME'] ?? 'Employee'); ?></h3>
                                <div class="employee-role"><?php echo htmlspecialchars($employee['ROLE'] ?? 'Staff'); ?></div>
                                <p class="mt-3" style="font-size: 0.9rem; opacity: 0.9;">Employee ID: <?php echo htmlspecialchars($employee['EMPID'] ?? ''); ?></p>
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
                                <a href="logout.php" class="menu-button">
                                    <i class="fas fa-sign-out-alt"></i>
                                    <span>Sign Out</span>
                                </a>
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
                                    <div class="stat-number"><?php echo $pending_order; ?></div>
                                    <div class="stat-label">Pending Orders</div>
                                </div>
                            </div>

                            <div class="col-lg-3 col-sm-6">
                                <div class="stat-card approved">
                                    <div class="stat-icon">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    <div class="stat-number"><?php echo $approved_order; ?></div>
                                    <div class="stat-label">Completed Orders</div>
                                </div>
                            </div>

                            <div class="col-lg-3 col-sm-6">
                                <div class="stat-card rejected">
                                    <div class="stat-icon">
                                        <i class="fas fa-times-circle"></i>
                                    </div>
                                    <div class="stat-number"><?php echo $rejected_order; ?></div>
                                    <div class="stat-label">Rejected Orders</div>
                                </div>
                            </div>

                            <div class="col-lg-3 col-sm-6">
                                <div class="stat-card total">
                                    <div class="stat-icon">
                                        <i class="fas fa-list-alt"></i>
                                    </div>
                                    <div class="stat-number"><?php echo $total_order; ?></div>
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
                                    <div class="stat-number"><?php echo $total_car; ?></div>
                                    <div class="stat-label">Total Cars</div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-sm-6">
                                <div class="stat-card" style="border-top-color: var(--primary-color);">
                                    <div class="stat-icon" style="background: var(--primary-color);">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    <div class="stat-number"><?php echo $available_car; ?></div>
                                    <div class="stat-label">Available Cars</div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-sm-6">
                                <div class="stat-card" style="border-top-color: var(--warning-color);">
                                    <div class="stat-icon" style="background: var(--warning-color);">
                                        <i class="fas fa-exclamation-circle"></i>
                                    </div>
                                    <div class="stat-number"><?php echo $low_stock_car; ?></div>
                                    <div class="stat-label">Low Stock Cars</div>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Orders -->
                        <div class="orders-card fade-in">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h3 class="card-title mb-0">Pending Orders - Need Action</h3>
                                <span class="badge bg-warning"><?php echo count($pending_orders); ?> orders require attention</span>
                            </div>

                            <?php if (empty($pending_orders)): ?>
                                <div class="alert alert-info">
                                    No pending orders at the moment.
                                </div>
                            <?php else: ?>
                                <?php foreach ($pending_orders as $order): ?>
                                    <div class="order-item pending">
                                        <div class="order-header">
                                            <div class="order-id"><?php echo htmlspecialchars($order['RENTALID']); ?> - <?php echo htmlspecialchars($order['CARNAME']); ?></div>
                                            <div class="order-status status-pending">Pending Approval</div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="info-item">
                                                    <span class="info-label">Customer:</span>
                                                    <span class="info-value highlight"><?php echo htmlspecialchars($order['CUSTNAME']); ?></span>
                                                </div>
                                                <div class="info-item">
                                                    <span class="info-label">Pickup Date:</span>
                                                    <span class="info-value"><?php echo date('M d, Y', strtotime($order['PICKUPDATE'])); ?></span>
                                                </div>
                                                <div class="info-item">
                                                    <span class="info-label">Return Date:</span>
                                                    <span class="info-value"><?php echo date('M d, Y', strtotime($order['DROPOFFDATE'])); ?></span>
                                                </div>
                                                <div class="info-item">
                                                    <span class="info-label">Location:</span>
                                                    <span class="info-value"><?php echo htmlspecialchars($order['PickUpLocation']); ?> → <?php echo htmlspecialchars($order['DropOffLocation']); ?></span>
                                                </div>
                                                <div class="info-item">
                                                    <span class="info-label">Total Amount:</span>
                                                    <span class="info-value highlight">$<?php echo number_format($order['total_price'], 2); ?></span>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="text-end">
                                                    <form method="POST" class="d-inline">
                                                        <input type="hidden" name="rentalid" value="<?php echo $order['RENTALID']; ?>">
                                                        <input type="hidden" name="status" value="Completed">
                                                        <button type="submit" name="update_order_status" class="btn btn-success btn-sm">
                                                            <i class="fas fa-check"></i> Approve
                                                        </button>
                                                    </form>
                                                    <form method="POST" class="d-inline">
                                                        <input type="hidden" name="rentalid" value="<?php echo $order['RENTALID']; ?>">
                                                        <input type="hidden" name="status" value="Rejected">
                                                        <button type="submit" name="update_order_status" class="btn btn-danger btn-sm">
                                                            <i class="fas fa-times"></i> Reject
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Manage Orders Content -->
                    <div id="orders-section" class="content-section">
                        <div class="orders-card fade-in">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h3 class="card-title mb-0">Manage All Orders</h3>
                            </div>

                            <?php if (empty($all_orders)): ?>
                                <div class="alert alert-info">
                                    No orders found.
                                </div>
                            <?php else: ?>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Order ID</th>
                                                <th>Customer</th>
                                                <th>Car</th>
                                                <th>Pickup Date</th>
                                                <th>Return Date</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($all_orders as $order): ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($order['RENTALID']); ?></td>
                                                    <td><?php echo htmlspecialchars($order['CUSTNAME']); ?></td>
                                                    <td><?php echo htmlspecialchars($order['CARNAME']); ?></td>
                                                    <td><?php echo date('M d, Y', strtotime($order['PICKUPDATE'])); ?></td>
                                                    <td><?php echo date('M d, Y', strtotime($order['DROPOFFDATE'])); ?></td>
                                                    <td>$<?php echo number_format($order['total_price'], 2); ?></td>
                                                    <td>
                                                        <span class="badge bg-<?php 
                                                            switch($order['STATUS']) {
                                                                case 'Ongoing': echo 'warning'; break;
                                                                case 'Completed': echo 'success'; break;
                                                                case 'Rejected': echo 'danger'; break;
                                                                default: echo 'secondary';
                                                            }
                                                        ?>">
                                                            <?php echo htmlspecialchars($order['STATUS']); ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <?php if ($order['STATUS'] == 'Ongoing'): ?>
                                                            <form method="POST" class="d-inline">
                                                                <input type="hidden" name="rentalid" value="<?php echo $order['RENTALID']; ?>">
                                                                <input type="hidden" name="status" value="Completed">
                                                                <button type="submit" name="update_order_status" class="btn btn-success btn-sm">
                                                                    <i class="fas fa-check"></i>
                                                                </button>
                                                            </form>
                                                            <form method="POST" class="d-inline">
                                                                <input type="hidden" name="rentalid" value="<?php echo $order['RENTALID']; ?>">
                                                                <input type="hidden" name="status" value="Rejected">
                                                                <button type="submit" name="update_order_status" class="btn btn-danger btn-sm">
                                                                    <i class="fas fa-times"></i>
                                                                </button>
                                                            </form>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Car Management Content -->
                    <div id="cars-section" class="content-section">
                        <div class="car-management-card fade-in">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h3 class="card-title mb-0">Car Inventory Management</h3>
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

                                <div class="car-list">
                                    <?php if (empty($all_cars)): ?>
                                        <div class="alert alert-info">
                                            No cars found in inventory.
                                        </div>
                                    <?php else: ?>
                                        <?php foreach ($all_cars as $car): 
                                            $status_class = '';
                                            $status_text = '';
                                            
                                            if ($car['Quantity'] <= 0) {
                                                $status_class = 'out-of-stock';
                                                $status_text = 'Out of Stock';
                                            } elseif ($car['CAR_STATUS'] == 'Maintenance') {
                                                $status_class = 'maintenance';
                                                $status_text = 'Maintenance';
                                            } elseif ($car['Quantity'] < 3) {
                                                $status_class = 'low-stock';
                                                $status_text = 'Low Stock';
                                            } else {
                                                $status_class = 'available';
                                                $status_text = 'Available';
                                            }
                                            
                                            // Get photo URL or use default - FIXED: Check if URL exists and is not empty
                                            $photo_url = 'https://images.unsplash.com/photo-1503376780353-7e6692767b70?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80';
                                            if (!empty($car['photo_url'])) {
                                                // Check if it's a local file or URL
                                                if (strpos($car['photo_url'], 'http') === 0) {
                                                    $photo_url = $car['photo_url'];
                                                } else {
                                                    // It's a local file, add base path if needed
                                                    $photo_url = '../' . $car['photo_url'];
                                                }
                                            }
                                        ?>
                                            <div class="car-item">
                                                <div class="car-image-container">
                                                    <img src="<?php echo htmlspecialchars($photo_url); ?>" alt="<?php echo htmlspecialchars($car['CARNAME']); ?>" 
                                                         onerror="this.src='https://images.unsplash.com/photo-1503376780353-7e6692767b70?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80'">
                                                    <span class="availability-badge <?php echo $status_class; ?>">
                                                        <?php echo $status_text . ' (' . $car['Quantity'] . ')'; ?>
                                                    </span>
                                                </div>
                                                <div class="car-info">
                                                    <div class="car-name"><?php echo htmlspecialchars($car['CARNAME']); ?> (<?php echo $car['CAR_YEAR']; ?>)</div>
                                                    <div class="car-details">
                                                        <span>$<?php echo $car['daily_price']; ?>/day</span>
                                                        <span><?php echo htmlspecialchars($car['car_type']); ?></span>
                                                    </div>
                                                    <div class="car-specs">
                                                        <span class="spec-badge">
                                                            <i class="fas fa-user me-1"></i><?php echo $car['Seats']; ?> seats
                                                        </span>
                                                        <span class="spec-badge">
                                                            <i class="fas fa-suitcase me-1"></i><?php echo $car['bags']; ?> bags
                                                        </span>
                                                        <span class="spec-badge">
                                                            <?php echo $car['Doors']; ?> doors
                                                        </span>
                                                        <span class="spec-badge">
                                                            <?php echo $car['HORSE_POWER']; ?> HP
                                                        </span>
                                                    </div>
                                                    <div class="car-actions mt-2">
                                                        <form method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this car?');">
                                                            <input type="hidden" name="carid" value="<?php echo $car['CARID']; ?>">
                                                            <button type="submit" name="delete_car" class="btn btn-danger btn-sm">
                                                                <i class="fas fa-trash me-1"></i>Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Add New Car Tab -->
                            <div id="add-car" class="car-tab-content">
                                <h5 class="mb-4">Add New Car to Inventory</h5>
                                
                                <form id="addCarForm" class="add-car-form" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="add_car" value="1">
                                    
                                    <!-- Basic Information -->
                                    <div class="form-section">
                                        <h6 class="form-section-title">Basic Information</h6>
                                        <div class="form-row">
                                            <div class="form-group">
                                                <label for="carid">Car ID *</label>
                                                <input type="text" id="carid" name="carid" class="form-control" required 
                                                       value="CAR<?php echo str_pad(count($all_cars) + 1, 3, '0', STR_PAD_LEFT); ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="carname">Car Name *</label>
                                                <input type="text" id="carname" name="carname" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="model">Model *</label>
                                                <input type="text" id="model" name="model" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group">
                                                <label for="brand">Brand *</label>
                                                <input type="text" id="brand" name="brand" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="car_year">Year *</label>
                                                <input type="number" id="car_year" name="car_year" class="form-control" 
                                                       min="2000" max="<?php echo date('Y') + 1; ?>" value="<?php echo date('Y'); ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="platenumber">Plate Number *</label>
                                                <input type="text" id="platenumber" name="platenumber" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Specifications -->
                                    <div class="form-section">
                                        <h6 class="form-section-title">Specifications</h6>
                                        <div class="form-row">
                                            <div class="form-group">
                                                <label for="horse_power">Horse Power *</label>
                                                <input type="number" id="horse_power" name="horse_power" class="form-control" min="50" max="2000" value="150" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="car_type">Car Type *</label>
                                                <select id="car_type" name="car_type" class="form-control" required>
                                                    <option value="">Select Type</option>
                                                    <option value="SUV">SUV</option>
                                                    <option value="Sedan">Sedan</option>
                                                    <option value="Hatchback">Hatchback</option>
                                                    <option value="Sport">Sport</option>
                                                    <option value="Luxury">Luxury</option>
                                                    <option value="Economy">Economy</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="color">Color</label>
                                                <input type="text" id="color" name="color" class="form-control" placeholder="e.g., Red, Blue, Black">
                                            </div>
                                        </div>
                                        
                                        <div class="form-row">
                                            <div class="form-group">
                                                <label for="doors">Doors *</label>
                                                <select id="doors" name="doors" class="form-control" required>
                                                    <option value="2">2 Doors</option>
                                                    <option value="4" selected>4 Doors</option>
                                                    <option value="5">5 Doors</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="seats">Seats *</label>
                                                <select id="seats" name="seats" class="form-control" required>
                                                    <option value="2">2 Seats</option>
                                                    <option value="4">4 Seats</option>
                                                    <option value="5" selected>5 Seats</option>
                                                    <option value="7">7 Seats</option>
                                                    <option value="8">8 Seats</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="bags">Luggage Capacity (bags) *</label>
                                                <select id="bags" name="bags" class="form-control" required>
                                                    <option value="1">1 Bag</option>
                                                    <option value="2" selected>2 Bags</option>
                                                    <option value="3">3 Bags</option>
                                                    <option value="4">4 Bags</option>
                                                    <option value="5">5+ Bags</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Rental Information -->
                                    <div class="form-section">
                                        <h6 class="form-section-title">Rental Information</h6>
                                        <div class="form-row">
                                            <div class="form-group">
                                                <label for="daily_price">Daily Rental Price ($) *</label>
                                                <input type="number" id="daily_price" name="daily_price" class="form-control" 
                                                       min="10" max="1000" step="0.01" value="100" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="quantity">Initial Quantity *</label>
                                                <input type="number" id="quantity" name="quantity" class="form-control" 
                                                       min="1" max="50" value="1" required>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Additional Information -->
                                    <div class="form-section">
                                        <h6 class="form-section-title">Additional Information</h6>
                                        <div class="form-group">
                                            <label for="car_photo">Car Photo Upload *</label>
                                            <input type="file" id="car_photo" name="car_photo" class="form-control" 
                                                   accept=".jpg,.jpeg,.png,.gif,.webp">
                                            <small class="text-muted">Max file size: 2MB. Accepted formats: JPG, JPEG, PNG, GIF, WEBP</small>
                                        </div>
                                        <div class="form-group">
                                            <label for="photo_url">Car Photo URL </label>
                                            <input type="url" id="photo_url" name="photo_url" class="form-control" 
                                                   placeholder="https://example.com/car-image.jpg" required>
                                            
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea id="description" name="description" class="form-control" rows="3" 
                                                      placeholder="Brief description of the car..."></textarea>
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="text-end mt-4">
                                        <button type="reset" class="btn btn-secondary me-2">Reset Form</button>
                                        <button type="submit" class="btn-submit">
                                            <i class="fas fa-plus-circle me-2"></i>Add Car to Inventory
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- Manage Quantity Tab -->
                            <div id="manage-quantity" class="car-tab-content">
                                <h5 class="mb-4">Update Car Quantities</h5>
                                
                                <?php if (empty($all_cars)): ?>
                                    <div class="alert alert-info">
                                        No cars found in inventory.
                                    </div>
                                <?php else: ?>
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Car Model</th>
                                                    <th>Current Quantity</th>
                                                    <th>Status</th>
                                                    <th>Update Quantity</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($all_cars as $car): ?>
                                                    <tr>
                                                        <td>
                                                            <strong><?php echo htmlspecialchars($car['CARNAME']); ?></strong><br>
                                                            <small class="text-muted">ID: <?php echo $car['CARID']; ?></small>
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-primary"><?php echo $car['Quantity']; ?></span>
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-<?php 
                                                                switch($car['CAR_STATUS']) {
                                                                    case 'Available': echo 'success'; break;
                                                                    case 'Maintenance': echo 'warning'; break;
                                                                    case 'Rented': echo 'info'; break;
                                                                    default: echo 'secondary';
                                                                }
                                                            ?>">
                                                                <?php echo htmlspecialchars($car['CAR_STATUS']); ?>
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <form method="POST" class="d-inline">
                                                                <input type="hidden" name="carid" value="<?php echo $car['CARID']; ?>">
                                                                <div class="input-group input-group-sm" style="width: 150px;">
                                                                    <input type="number" name="quantity" class="form-control" 
                                                                           value="<?php echo $car['Quantity']; ?>" min="0" max="50">
                                                                    <button type="submit" name="update_quantity" class="btn btn-outline-primary">
                                                                        Update
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php endif; ?>
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
        // Navigation functionality
        document.addEventListener('DOMContentLoaded', function () {
            const menuButtons = document.querySelectorAll('.menu-button');
            const contentSections = document.querySelectorAll('.content-section');
            
            // Set first content section as active
            contentSections.forEach(section => {
                if (section.id === 'dashboard-section') {
                    section.classList.add('active');
                }
            });
            
            menuButtons.forEach(button => {
                if (!button.href) {
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
                }
            });
            
            // Initialize car tabs
            initializeCarTabs();
        });
        
        // Initialize car management tabs
        function initializeCarTabs() {
            const carTabs = document.querySelectorAll('.car-tab');
            const carTabContents = document.querySelectorAll('.car-tab-content');
            
            // Set first car tab as active
            carTabContents.forEach(content => {
                if (content.id === 'view-cars') {
                    content.classList.add('active');
                }
            });
        }
        
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
        
        // Auto-generate Car ID
        document.getElementById('carname').addEventListener('input', function() {
            const carName = this.value.trim();
            if (carName) {
                const words = carName.split(' ');
                const initials = words.map(word => word.charAt(0).toUpperCase()).join('');
                const count = document.querySelectorAll('.car-item').length + 1;
                document.getElementById('carid').value = initials + count.toString().padStart(3, '0');
            }
        });
        
        // Auto-fill model based on car name
        document.getElementById('carname').addEventListener('blur', function() {
            const carName = this.value.trim();
            if (carName && !document.getElementById('model').value) {
                const modelMatch = carName.match(/\s(\w+)$/);
                if (modelMatch) {
                    document.getElementById('model').value = modelMatch[1];
                }
            }
        });
        
        // File upload validation
        document.getElementById('car_photo').addEventListener('change', function(e) {
            const file = this.files[0];
            const urlField = document.getElementById('photo_url');
            
            if (file) {
                // Clear URL field when file is selected
                urlField.value = '';
                urlField.required = false;
                
                // Validate file size
                const maxSize = 2 * 1024 * 1024; // 2MB
                if (file.size > maxSize) {
                    alert('File size exceeds 2MB limit. Please choose a smaller file.');
                    this.value = '';
                }
                
                // Validate file type
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
                if (!allowedTypes.includes(file.type)) {
                    alert('Invalid file type. Please upload an image (JPG, JPEG, PNG, GIF, or WEBP).');
                    this.value = '';
                }
            }
        });
        
        // URL field validation
        document.getElementById('photo_url').addEventListener('input', function() {
            const fileField = document.getElementById('car_photo');
            if (this.value) {
                fileField.required = false;
            } else {
                fileField.required = true;
            }
        });
    </script>
</body>
</html>

