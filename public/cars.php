<?php
session_start();
include '../includes/db.php'; // Database connection file

// Check if employee is logged in
if (!isset($_SESSION["EID"])) {
    header('Location: login.php');
    exit();
}

$employee_id = $_SESSION["EID"];

// Get employee information
$stmt = $connect->prepare("SELECT * FROM employee WHERE employee_id = ?");
$stmt->bind_param("i", $employee_id);
$stmt->execute();
$employee_result = $stmt->get_result();
$employee = $employee_result->fetch_assoc();
$stmt->close();

// Check if employee exists
if (!$employee) {
    session_destroy();
    header('Location: login.php');
    exit();
}

// Get statistics for dashboard
$stats = [
    'total_bookings' => 0,
    'pending_bookings' => 0,
    'confirmed_bookings' => 0,
    'cancelled_bookings' => 0,
    'total_rooms' => 0,
    'available_rooms' => 0,
    'occupied_rooms' => 0
];

// Total bookings
$stmt = $connect->prepare("SELECT COUNT(*) as count FROM reservation");
$stmt->execute();
$result = $stmt->get_result();
$stats['total_bookings'] = $result->fetch_assoc()['count'] ?? 0;
$stmt->close();

// Pending bookings (Confirmed but not paid)
$stmt = $connect->prepare("SELECT COUNT(*) as count FROM reservation WHERE RESV_STATUS = 'Confirmed'");
$stmt->execute();
$result = $stmt->get_result();
$stats['pending_bookings'] = $result->fetch_assoc()['count'] ?? 0;
$stmt->close();

// Confirmed and paid bookings
$stmt = $connect->prepare("SELECT COUNT(*) as count FROM reservation WHERE RESV_STATUS = 'Completed'");
$stmt->execute();
$result = $stmt->get_result();
$stats['confirmed_bookings'] = $result->fetch_assoc()['count'] ?? 0;
$stmt->close();

// Cancelled bookings
$stmt = $connect->prepare("SELECT COUNT(*) as count FROM reservation WHERE RESV_STATUS = 'Cancelled'");
$stmt->execute();
$result = $stmt->get_result();
$stats['cancelled_bookings'] = $result->fetch_assoc()['count'] ?? 0;
$stmt->close();

// Total rooms
$stmt = $connect->prepare("SELECT COUNT(*) as count FROM room");
$stmt->execute();
$result = $stmt->get_result();
$stats['total_rooms'] = $result->fetch_assoc()['count'] ?? 0;
$stmt->close();

// Available rooms
$stmt = $connect->prepare("SELECT COUNT(*) as count FROM room WHERE STATUS = 'available'");
$stmt->execute();
$result = $stmt->get_result();
$stats['available_rooms'] = $result->fetch_assoc()['count'] ?? 0;
$stmt->close();

// Occupied rooms (reserved)
$stmt = $connect->prepare("SELECT COUNT(*) as count FROM room WHERE STATUS = 'Reserved'");
$stmt->execute();
$result = $stmt->get_result();
$stats['occupied_rooms'] = $result->fetch_assoc()['count'] ?? 0;
$stmt->close();

// Get recent pending bookings for dashboard
$recent_pending_bookings_stmt = $connect->prepare("
    SELECT 
        r.RESERVATIONID,
        r.CKECKIN,
        r.CHECKOUT,
        r.NB_GUEST,
        r.RESV_STATUS,
        r.ROOMID,
        g.FULLNAME as guest_name,
        g.EMAIL as guest_email,
        g.PHONE as guest_phone,
        rm.ROOM_NUMBER,
        rt.TYPENAME as room_type,
        rm.PRICE_PER_NIGHT,
        DATEDIFF(r.CHECKOUT, r.CKECKIN) as nights,
        (rm.PRICE_PER_NIGHT * DATEDIFF(r.CHECKOUT, r.CKECKIN)) as total_amount
    FROM reservation r
    JOIN guest g ON r.GUESTID = g.GUESTID
    JOIN room rm ON r.ROOMID = rm.ROOMID
    JOIN room_type rt ON rm.ROOMTYPEID = rt.ROOMTYPEID
    WHERE r.RESV_STATUS = 'Confirmed'
    ORDER BY r.CKECKIN ASC
    LIMIT 5
");
$recent_pending_bookings_stmt->execute();
$recent_pending_bookings_result = $recent_pending_bookings_stmt->get_result();
$recent_pending_bookings_stmt->close();

// Get all bookings for management page
$all_bookings_stmt = $connect->prepare("
    SELECT 
        r.RESERVATIONID,
        r.CKECKIN,
        r.CHECKOUT,
        r.NB_GUEST,
        r.RESV_STATUS,
        r.ROOMID,
        g.GUESTID,
        g.FULLNAME as guest_name,
        g.EMAIL as guest_email,
        g.PHONE as guest_phone,
        rm.ROOM_NUMBER,
        rt.TYPENAME as room_type,
        rt.MAXOCCUPANCY,
        rt.DESCRIPTION,
        rt.bed,
        rt.toillet,
        rm.PRICE_PER_NIGHT,
        DATEDIFF(r.CHECKOUT, r.CKECKIN) as nights,
        (rm.PRICE_PER_NIGHT * DATEDIFF(r.CHECKOUT, r.CKECKIN)) as total_amount,
        p.STATUS_PAYMENT,
        p.AMOUNT,
        p.PAYMENTMETHOD,
        pu.URL as room_image
    FROM reservation r
    JOIN guest g ON r.GUESTID = g.GUESTID
    JOIN room rm ON r.ROOMID = rm.ROOMID
    JOIN room_type rt ON rm.ROOMTYPEID = rt.ROOMTYPEID
    LEFT JOIN payment p ON r.RESERVATIONID = p.RESERVATIONID
    LEFT JOIN photo_url pu ON r.ROOMID = pu.Room_ID
    ORDER BY 
        CASE WHEN r.RESV_STATUS = 'Confirmed' THEN 1
             WHEN r.RESV_STATUS = 'Completed' THEN 2
             WHEN r.RESV_STATUS = 'Cancelled' THEN 3
             ELSE 4
        END,
        r.CKECKIN DESC
");
$all_bookings_stmt->execute();
$all_bookings_result = $all_bookings_stmt->get_result();
$all_bookings_stmt->close();

// Get all rooms for management
$rooms_stmt = $connect->prepare("
    SELECT 
        rm.ROOMID,
        rm.ROOM_NUMBER,
        rm.STATUS,
        rm.PRICE_PER_NIGHT,
        rt.TYPENAME,
        rt.MAXOCCUPANCY,
        rt.DESCRIPTION,
        rt.bed,
        rt.toillet,
        pu.URL as room_image
    FROM room rm
    JOIN room_type rt ON rm.ROOMTYPEID = rt.ROOMTYPEID
    LEFT JOIN photo_url pu ON rm.ROOMID = pu.Room_ID
    ORDER BY rm.ROOM_NUMBER ASC
");
$rooms_stmt->execute();
$rooms_result = $rooms_stmt->get_result();
$rooms_stmt->close();

// Get room types for adding new rooms
$room_types_stmt = $connect->prepare("SELECT * FROM room_type ORDER BY TYPENAME");
$room_types_stmt->execute();
$room_types_result = $room_types_stmt->get_result();
$room_types_stmt->close();

// Handle booking approval
if (isset($_GET['approve_booking'])) {
    $reservation_id = $_GET['approve_booking'];
    
    // Update reservation status
    $stmt = $connect->prepare("UPDATE reservation SET RESV_STATUS = 'Completed' WHERE RESERVATIONID = ?");
    $stmt->bind_param("i", $reservation_id);
    
    if ($stmt->execute()) {
        $success_message = "Booking confirmed successfully!";
        
        // Update payment status if exists
        $payment_stmt = $connect->prepare("UPDATE payment SET STATUS_PAYMENT = 'Completed' WHERE RESERVATIONID = ?");
        $payment_stmt->bind_param("i", $reservation_id);
        $payment_stmt->execute();
        $payment_stmt->close();
        
        // Refresh statistics
        $stats['pending_bookings']--;
        $stats['confirmed_bookings']++;
    } else {
        $error_message = "Error confirming booking: " . $stmt->error;
    }
    $stmt->close();
}

// Handle booking cancellation
if (isset($_GET['cancel_booking'])) {
    $reservation_id = $_GET['cancel_booking'];
    
    // Get room ID before cancelling
    $room_stmt = $connect->prepare("SELECT ROOMID FROM reservation WHERE RESERVATIONID = ?");
    $room_stmt->bind_param("i", $reservation_id);
    $room_stmt->execute();
    $room_result = $room_stmt->get_result();
    $booking = $room_result->fetch_assoc();
    $room_stmt->close();
    
    // Start transaction
    $connect->begin_transaction();
    
    try {
        // Update reservation status
        $stmt = $connect->prepare("UPDATE reservation SET RESV_STATUS = 'Cancelled' WHERE RESERVATIONID = ?");
        $stmt->bind_param("i", $reservation_id);
        $stmt->execute();
        $stmt->close();
        
        // Update room status back to available
        $room_update_stmt = $connect->prepare("UPDATE room SET STATUS = 'available' WHERE ROOMID = ?");
        $room_update_stmt->bind_param("i", $booking['ROOMID']);
        $room_update_stmt->execute();
        $room_update_stmt->close();
        
        // Update payment status if exists
        $payment_stmt = $connect->prepare("UPDATE payment SET STATUS_PAYMENT = 'Refunded' WHERE RESERVATIONID = ?");
        $payment_stmt->bind_param("i", $reservation_id);
        $payment_stmt->execute();
        $payment_stmt->close();
        
        // Commit transaction
        $connect->commit();
        
        $success_message = "Booking cancelled successfully!";
        
        // Refresh statistics
        $stats['pending_bookings']--;
        $stats['cancelled_bookings']++;
        $stats['occupied_rooms']--;
        $stats['available_rooms']++;
        
    } catch (Exception $e) {
        $connect->rollback();
        $error_message = "Error cancelling booking: " . $e->getMessage();
    }
}

// Handle room status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_room_status'])) {
    $room_id = $_POST['room_id'];
    $status = $_POST['status'];
    
    $stmt = $connect->prepare("UPDATE room SET STATUS = ? WHERE ROOMID = ?");
    $stmt->bind_param("si", $status, $room_id);
    
    if ($stmt->execute()) {
        $success_message = "Room status updated successfully!";
        
        // Refresh room statistics
        $stats['available_rooms'] = 0;
        $stats['occupied_rooms'] = 0;
        
        $count_stmt = $connect->prepare("SELECT STATUS, COUNT(*) as count FROM room GROUP BY STATUS");
        $count_stmt->execute();
        $count_result = $count_stmt->get_result();
        while ($row = $count_result->fetch_assoc()) {
            if ($row['STATUS'] == 'available') {
                $stats['available_rooms'] = $row['count'];
            } elseif ($row['STATUS'] == 'Reserved') {
                $stats['occupied_rooms'] = $row['count'];
            }
        }
        $count_stmt->close();
    } else {
        $error_message = "Error updating room status: " . $stmt->error;
    }
    $stmt->close();
}

// Handle add new room
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_room'])) {
    $room_type_id = $_POST['room_type_id'];
    $room_number = $_POST['room_number'];
    $price_per_night = $_POST['price_per_night'];
    $status = 'available';
    
    // Check if room number already exists
    $check_stmt = $connect->prepare("SELECT COUNT(*) as count FROM room WHERE ROOM_NUMBER = ?");
    $check_stmt->bind_param("i", $room_number);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    $room_exists = $check_result->fetch_assoc()['count'] > 0;
    $check_stmt->close();
    
    if ($room_exists) {
        $error_message = "Room number already exists!";
    } else {
        $stmt = $connect->prepare("INSERT INTO room (ROOMTYPEID, ROOM_NUMBER, STATUS, PRICE_PER_NIGHT) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iisi", $room_type_id, $room_number, $status, $price_per_night);
        
        if ($stmt->execute()) {
            $success_message = "New room added successfully!";
            
            // Refresh statistics
            $stats['total_rooms']++;
            $stats['available_rooms']++;
        } else {
            $error_message = "Error adding room: " . $stmt->error;
        }
        $stmt->close();
    }
}

// Handle delete room
if (isset($_GET['delete_room'])) {
    $room_id = $_GET['delete_room'];
    
    // Check if room has any reservations
    $check_stmt = $connect->prepare("SELECT COUNT(*) as count FROM reservation WHERE ROOMID = ? AND RESV_STATUS IN ('Confirmed', 'Completed')");
    $check_stmt->bind_param("i", $room_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    $has_reservations = $check_result->fetch_assoc()['count'] > 0;
    $check_stmt->close();
    
    if ($has_reservations) {
        $error_message = "Cannot delete room with active or future reservations!";
    } else {
        // Start transaction
        $connect->begin_transaction();
        
        try {
            // Delete room photos first
            $photo_stmt = $connect->prepare("DELETE FROM photo_url WHERE Room_ID = ?");
            $photo_stmt->bind_param("i", $room_id);
            $photo_stmt->execute();
            $photo_stmt->close();
            
            // Delete room
            $room_stmt = $connect->prepare("DELETE FROM room WHERE ROOMID = ?");
            $room_stmt->bind_param("i", $room_id);
            $room_stmt->execute();
            $room_stmt->close();
            
            // Delete any cancelled reservations for this room
            $resv_stmt = $connect->prepare("DELETE FROM reservation WHERE ROOMID = ? AND RESV_STATUS = 'Cancelled'");
            $resv_stmt->bind_param("i", $room_id);
            $resv_stmt->execute();
            $resv_stmt->close();
            
            $connect->commit();
            
            $success_message = "Room deleted successfully!";
            
            // Refresh statistics
            $stats['total_rooms']--;
            $stats['available_rooms']--;
            
        } catch (Exception $e) {
            $connect->rollback();
            $error_message = "Error deleting room: " . $e->getMessage();
        }
    }
}

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: employee-login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Veloria Palace - Employee Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        :root {
            --primary-color: #B8860B;
            --primary-dark: #B8860B;
            --secondary-color: #B8860B;
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
            color: #B8860B !important;
        }

        /* Hero Section */
        .dashboard-hero {
            background: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)),
                url('https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1600&q=80') center/cover no-repeat;
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
            background: linear-gradient(135deg, #B8860B, #B8860B);
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
        }

        .employee-image i {
            font-size: 3rem;
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

        /* Bookings Card */
        .bookings-card {
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

        /* Room Management Card */
        .room-management-card {
            background: white;
            border-radius: 15px;
            box-shadow: var(--shadow);
            padding: 30px;
            margin-bottom: 30px;
        }

        /* Tabs for Room Management */
        .room-tabs {
            display: flex;
            border-bottom: 2px solid var(--border-color);
            margin-bottom: 25px;
            overflow-x: auto;
        }

        .room-tab {
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

        .room-tab:hover {
            color: var(--primary-color);
        }

        .room-tab.active {
            color: var(--primary-color);
            border-bottom-color: var(--primary-color);
        }

        /* Room Management Content */
        .room-tab-content {
            display: none;
        }

        .room-tab-content.active {
            display: block;
            animation: fadeIn 0.5s ease;
        }

        /* Room List */
        .room-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .room-item {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            overflow: hidden;
            transition: var(--transition);
        }

        .room-item:hover {
            border-color: var(--primary-color);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transform: translateY(-3px);
        }

        .room-image-container {
            height: 180px;
            overflow: hidden;
            position: relative;
        }

        .room-image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .room-item:hover .room-image-container img {
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

        .room-info {
            padding: 20px;
        }

        .room-name {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 10px;
            color: var(--text-dark);
        }

        .room-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            font-size: 0.9rem;
            color: var(--text-light);
        }

        .room-specs {
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

        .room-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        .btn-edit,
        .btn-delete {
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

        /* Add Room Form */
        .add-room-form {
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

        /* Booking Filters */
        .booking-filters {
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

        /* Booking Items */
        .booking-item {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid var(--border-color);
            transition: var(--transition);
            position: relative;
        }

        .booking-item:hover {
            border-color: var(--primary-color);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .booking-item.pending {
            border-left: 4px solid var(--warning-color);
        }

        .booking-item.approved {
            border-left: 4px solid var(--primary-color);
        }

        .booking-item.rejected {
            border-left: 4px solid var(--danger-color);
        }

        .booking-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 10px;
        }

        .booking-id {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-dark);
        }

        .booking-status {
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

        .booking-details {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            margin-bottom: 20px;
        }

        .booking-room {
            flex: 1;
            min-width: 300px;
        }

        .room-image {
            width: 200px;
            height: 140px;
            border-radius: 8px;
            overflow: hidden;
            float: left;
            margin-right: 20px;
        }

        .room-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .room-name {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .room-specs {
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

        .booking-info {
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

        .booking-actions {
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

        /* Guest Info */
        .guest-card {
            background: white;
            border-radius: 15px;
            box-shadow: var(--shadow);
            padding: 30px;
            margin-bottom: 30px;
        }

        .guest-header {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
        }

        .guest-avatar {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            overflow: hidden;
            margin-right: 20px;
            background: linear-gradient(135deg, #f5f5f5, #e0e0e0);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .guest-avatar i {
            font-size: 2rem;
            color: var(--primary-color);
        }

        .guest-name {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .guest-email {
            color: var(--text-light);
            font-size: 0.95rem;
        }

        .guest-details {
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

        /* Alert Messages */
        .alert-container {
            position: fixed;
            top: 100px;
            right: 20px;
            z-index: 9999;
            max-width: 400px;
        }
        
        .alert {
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            animation: slideInRight 0.3s ease;
        }
        
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        /* Responsive */
        @media (max-width: 992px) {
            .dashboard-sidebar {
                position: static;
                margin-bottom: 30px;
            }

            .room-image {
                float: none;
                width: 100%;
                height: 200px;
                margin-right: 0;
                margin-bottom: 15px;
            }

            .booking-details {
                flex-direction: column;
            }

            .room-list {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2rem;
            }

            .booking-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .booking-actions {
                flex-direction: column;
                width: 100%;
            }

            .btn-action {
                width: 100%;
            }

            .guest-header {
                flex-direction: column;
                text-align: center;
            }

            .guest-avatar {
                margin-right: 0;
                margin-bottom: 15px;
            }

            .room-tabs {
                flex-direction: column;
            }

            .room-tab {
                text-align: left;
                border-bottom: 1px solid var(--border-color);
            }

            .room-tab.active {
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

            .bookings-card,
            .guest-card,
            .room-management-card,
            .signout-card {
                padding: 20px;
            }

            .stat-number {
                font-size: 2rem;
            }

            .room-list {
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


    <!-- Header -->
    

    <!-- Messages -->
    <?php if(isset($success_message)): ?>
    <div class="alert-container">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <?php echo htmlspecialchars($success_message); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
    <?php endif; ?>
    
    <?php if(isset($error_message)): ?>
    <div class="alert-container">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            <?php echo htmlspecialchars($error_message); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
    <?php endif; ?>

    <!-- Hero Section -->
    <section class="dashboard-hero">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h1 class="hero-title">Hotel Management Dashboard</h1>
                    <p class="lead">Manage guest bookings, room inventory, and handle hotel operations.</p>
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
                                <div class="employee-image">
                                    <i class="fas fa-user-tie"></i>
                                </div>
                                <h3 class="employee-name"><?php echo htmlspecialchars($employee['name']); ?></h3>
                                <div class="employee-role"><?php echo htmlspecialchars($employee['position']); ?></div>
                                <p class="mt-3" style="font-size: 0.9rem; opacity: 0.9;">Employee ID: <?php echo $employee['employee_id']; ?></p>
                            </div>

                            <div class="sidebar-menu">
                                <button class="menu-button active" data-section="dashboard">
                                    <i class="fas fa-tachometer-alt"></i>
                                    <span>Dashboard</span>
                                </button>
                                <button class="menu-button" data-section="bookings">
                                    <i class="fas fa-clipboard-list"></i>
                                    <span>Manage Bookings</span>
                                </button>
                                <button class="menu-button" data-section="rooms">
                                    <i class="fas fa-bed"></i>
                                    <span>Room Management</span>
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
                                    <div class="stat-number" id="pending-count"><?php echo $stats['pending_bookings']; ?></div>
                                    <div class="stat-label">Pending Bookings</div>
                                </div>
                            </div>

                            <div class="col-lg-3 col-sm-6">
                                <div class="stat-card approved">
                                    <div class="stat-icon">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    <div class="stat-number" id="approved-count"><?php echo $stats['confirmed_bookings']; ?></div>
                                    <div class="stat-label">Confirmed Bookings</div>
                                </div>
                            </div>

                            <div class="col-lg-3 col-sm-6">
                                <div class="stat-card rejected">
                                    <div class="stat-icon">
                                        <i class="fas fa-times-circle"></i>
                                    </div>
                                    <div class="stat-number" id="rejected-count"><?php echo $stats['cancelled_bookings']; ?></div>
                                    <div class="stat-label">Cancelled Bookings</div>
                                </div>
                            </div>

                            <div class="col-lg-3 col-sm-6">
                                <div class="stat-card total">
                                    <div class="stat-icon">
                                        <i class="fas fa-list-alt"></i>
                                    </div>
                                    <div class="stat-number" id="total-count"><?php echo $stats['total_bookings']; ?></div>
                                    <div class="stat-label">Total Bookings</div>
                                </div>
                            </div>
                        </div>

                        <!-- Room Inventory Stats -->
                        <div class="row stats-grid g-4 fade-in">
                            <div class="col-lg-4 col-sm-6">
                                <div class="stat-card" style="border-top-color: #9b59b6;">
                                    <div class="stat-icon" style="background: #9b59b6;">
                                        <i class="fas fa-bed"></i>
                                    </div>
                                    <div class="stat-number" id="total-rooms"><?php echo $stats['total_rooms']; ?></div>
                                    <div class="stat-label">Total Rooms</div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-sm-6">
                                <div class="stat-card" style="border-top-color: var(--primary-color);">
                                    <div class="stat-icon" style="background: var(--primary-color);">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    <div class="stat-number" id="available-rooms"><?php echo $stats['available_rooms']; ?></div>
                                    <div class="stat-label">Available Rooms</div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-sm-6">
                                <div class="stat-card" style="border-top-color: var(--warning-color);">
                                    <div class="stat-icon" style="background: var(--warning-color);">
                                        <i class="fas fa-exclamation-circle"></i>
                                    </div>
                                    <div class="stat-number" id="occupied-rooms"><?php echo $stats['occupied_rooms']; ?></div>
                                    <div class="stat-label">Occupied Rooms</div>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Bookings -->
                        <div class="bookings-card fade-in">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h3 class="card-title mb-0">Pending Bookings - Need Action</h3>
                                <span class="badge bg-warning"><?php echo $stats['pending_bookings']; ?> booking<?php echo $stats['pending_bookings'] != 1 ? 's' : ''; ?> require attention</span>
                            </div>

                            <?php if($recent_pending_bookings_result->num_rows > 0): ?>
                                <?php while($booking = $recent_pending_bookings_result->fetch_assoc()): 
                                    $room_image = !empty($booking['room_image']) ? '../assets/images/rooms/' . $booking['room_image'] : 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80';
                                ?>
                                <div class="booking-item pending" data-booking-id="<?php echo $booking['RESERVATIONID']; ?>">
                                    <div class="booking-header">
                                        <div class="booking-id">BOOKING #<?php echo str_pad($booking['RESERVATIONID'], 6, '0', STR_PAD_LEFT); ?> - <?php echo htmlspecialchars($booking['room_type']); ?></div>
                                        <div class="booking-status status-pending">Pending Confirmation</div>
                                    </div>

                                    <div class="booking-details">
                                        <div class="booking-room">
                                            <div class="room-image">
                                                <img src="<?php echo $room_image; ?>" 
                                                     alt="<?php echo htmlspecialchars($booking['room_type']); ?>"
                                                     onerror="this.src='https://images.unsplash.com/photo-1611892440504-42a792e24d32?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80'">
                                            </div>
                                            <div class="room-name"><?php echo htmlspecialchars($booking['room_type']); ?></div>
                                            <div class="room-specs">
                                                <div class="spec-item">
                                                    <i class="fas fa-user"></i> <?php echo $booking['NB_GUEST']; ?> Guest<?php echo $booking['NB_GUEST'] > 1 ? 's' : ''; ?>
                                                </div>
                                                <div class="spec-item">
                                                    <i class="fas fa-bed"></i> Room <?php echo $booking['ROOM_NUMBER']; ?>
                                                </div>
                                                <div class="spec-item">
                                                    <i class="fas fa-calendar"></i> <?php echo $booking['nights']; ?> night<?php echo $booking['nights'] > 1 ? 's' : ''; ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="booking-info">
                                            <div class="info-item">
                                                <span class="info-label">Guest:</span>
                                                <span class="info-value highlight"><?php echo htmlspecialchars($booking['guest_name']); ?></span>
                                            </div>
                                            <div class="info-item">
                                                <span class="info-label">Email:</span>
                                                <span class="info-value"><?php echo htmlspecialchars($booking['guest_email']); ?></span>
                                            </div>
                                            <div class="info-item">
                                                <span class="info-label">Phone:</span>
                                                <span class="info-value"><?php echo htmlspecialchars($booking['guest_phone']); ?></span>
                                            </div>
                                            <div class="info-item">
                                                <span class="info-label">Check-in:</span>
                                                <span class="info-value"><?php echo date('M j, Y', strtotime($booking['CKECKIN'])); ?></span>
                                            </div>
                                            <div class="info-item">
                                                <span class="info-label">Check-out:</span>
                                                <span class="info-value"><?php echo date('M j, Y', strtotime($booking['CHECKOUT'])); ?></span>
                                            </div>
                                            <div class="info-item">
                                                <span class="info-label">Total Amount:</span>
                                                <span class="info-value highlight">$<?php echo number_format($booking['total_amount'], 2); ?></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="booking-actions">
                                        <a href="?cancel_booking=<?php echo $booking['RESERVATIONID']; ?>" 
                                           class="btn-action btn-reject"
                                           onclick="return confirm('Are you sure you want to cancel this booking?')">Reject</a>
                                        <a href="?approve_booking=<?php echo $booking['RESERVATIONID']; ?>" 
                                           class="btn-action btn-approve"
                                           onclick="return confirm('Are you sure you want to confirm this booking?')">Approve</a>
                                    </div>
                                </div>
                                <?php endwhile; ?>
                            <?php else: ?>
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <h5>No Pending Bookings</h5>
                                <p>All bookings are currently processed.</p>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Manage Bookings Content -->
                    <div id="bookings-section" class="content-section">
                        <div class="bookings-card fade-in">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h3 class="card-title mb-0">Manage All Bookings</h3>
                                <div class="booking-filters">
                                    <button class="filter-btn active" onclick="filterBookings('all')">All Bookings</button>
                                    <button class="filter-btn" onclick="filterBookings('Confirmed')">Pending</button>
                                    <button class="filter-btn" onclick="filterBookings('Completed')">Confirmed</button>
                                    <button class="filter-btn" onclick="filterBookings('Cancelled')">Cancelled</button>
                                </div>
                            </div>
                            <p class="text-muted mb-4">Review, confirm, or cancel guest hotel bookings</p>

                            <div id="bookings-container">
                                <?php if($all_bookings_result->num_rows > 0): ?>
                                    <?php while($booking = $all_bookings_result->fetch_assoc()): 
                                        $room_image = !empty($booking['room_image']) ? '../assets/images/rooms/' . $booking['room_image'] : 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80';
                                        $status_class = '';
                                        $status_text = '';
                                        $border_class = '';
                                        
                                        switch($booking['RESV_STATUS']) {
                                            case 'Confirmed':
                                                $status_class = 'status-pending';
                                                $status_text = 'Pending Confirmation';
                                                $border_class = 'pending';
                                                break;
                                            case 'Completed':
                                                $status_class = 'status-approved';
                                                $status_text = 'Confirmed';
                                                $border_class = 'approved';
                                                break;
                                            case 'Cancelled':
                                                $status_class = 'status-rejected';
                                                $status_text = 'Cancelled';
                                                $border_class = 'rejected';
                                                break;
                                            default:
                                                $status_class = 'status-pending';
                                                $status_text = $booking['RESV_STATUS'];
                                                $border_class = 'pending';
                                        }
                                    ?>
                                    <div class="booking-item <?php echo $border_class; ?>" data-booking-id="<?php echo $booking['RESERVATIONID']; ?>" data-status="<?php echo $booking['RESV_STATUS']; ?>">
                                        <div class="booking-header">
                                            <div class="booking-id">BOOKING #<?php echo str_pad($booking['RESERVATIONID'], 6, '0', STR_PAD_LEFT); ?> - <?php echo htmlspecialchars($booking['room_type']); ?></div>
                                            <div class="booking-status <?php echo $status_class; ?>"><?php echo $status_text; ?></div>
                                        </div>

                                        <div class="booking-details">
                                            <div class="booking-room">
                                                <div class="room-image">
                                                    <img src="<?php echo $room_image; ?>" 
                                                         alt="<?php echo htmlspecialchars($booking['room_type']); ?>"
                                                         onerror="this.src='https://images.unsplash.com/photo-1611892440504-42a792e24d32?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80'">
                                                </div>
                                                <div class="room-name"><?php echo htmlspecialchars($booking['room_type']); ?> - Room <?php echo $booking['ROOM_NUMBER']; ?></div>
                                                <div class="room-specs">
                                                    <div class="spec-item">
                                                        <i class="fas fa-user"></i> <?php echo $booking['NB_GUEST']; ?> Guest<?php echo $booking['NB_GUEST'] > 1 ? 's' : ''; ?>
                                                    </div>
                                                    <div class="spec-item">
                                                        <i class="fas fa-bed"></i> <?php echo $booking['bed']; ?> Bed<?php echo $booking['bed'] > 1 ? 's' : ''; ?>
                                                    </div>
                                                    <div class="spec-item">
                                                        <i class="fas fa-bath"></i> <?php echo $booking['toillet']; ?> Bathroom<?php echo $booking['toillet'] > 1 ? 's' : ''; ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="booking-info">
                                                <div class="info-item">
                                                    <span class="info-label">Guest:</span>
                                                    <span class="info-value highlight"><?php echo htmlspecialchars($booking['guest_name']); ?></span>
                                                </div>
                                                <div class="info-item">
                                                    <span class="info-label">Check-in:</span>
                                                    <span class="info-value"><?php echo date('M j, Y', strtotime($booking['CKECKIN'])); ?></span>
                                                </div>
                                                <div class="info-item">
                                                    <span class="info-label">Check-out:</span>
                                                    <span class="info-value"><?php echo date('M j, Y', strtotime($booking['CHECKOUT'])); ?></span>
                                                </div>
                                                <div class="info-item">
                                                    <span class="info-label">Nights:</span>
                                                    <span class="info-value"><?php echo $booking['nights']; ?> night<?php echo $booking['nights'] > 1 ? 's' : ''; ?></span>
                                                </div>
                                                <div class="info-item">
                                                    <span class="info-label">Total Amount:</span>
                                                    <span class="info-value highlight">$<?php echo number_format($booking['total_amount'], 2); ?></span>
                                                </div>
                                                <?php if(!empty($booking['PAYMENTMETHOD'])): ?>
                                                <div class="info-item">
                                                    <span class="info-label">Payment:</span>
                                                    <span class="info-value"><?php echo htmlspecialchars($booking['PAYMENTMETHOD']); ?> (<?php echo htmlspecialchars($booking['STATUS_PAYMENT']); ?>)</span>
                                                </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <?php if($booking['RESV_STATUS'] == 'Confirmed'): ?>
                                        <div class="booking-actions">
                                            <a href="?cancel_booking=<?php echo $booking['RESERVATIONID']; ?>" 
                                               class="btn-action btn-reject"
                                               onclick="return confirm('Are you sure you want to cancel this booking?')">Reject</a>
                                            <a href="?approve_booking=<?php echo $booking['RESERVATIONID']; ?>" 
                                               class="btn-action btn-approve"
                                               onclick="return confirm('Are you sure you want to confirm this booking?')">Approve</a>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <i class="fas fa-clipboard-list"></i>
                                    </div>
                                    <h5>No Bookings Found</h5>
                                    <p>There are no bookings in the system.</p>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Room Management Content -->
                    <div id="rooms-section" class="content-section">
                        <div class="room-management-card fade-in">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h3 class="card-title mb-0">Room Inventory Management</h3>
                                <span class="badge bg-primary">Manage rooms and availability</span>
                            </div>

                            <!-- Room Management Tabs -->
                            <div class="room-tabs">
                                <button class="room-tab active" data-tab="view-rooms" onclick="switchRoomTab('view-rooms')">
                                    <i class="fas fa-list me-2"></i>View All Rooms
                                </button>
                                <button class="room-tab" data-tab="add-room" onclick="switchRoomTab('add-room')">
                                    <i class="fas fa-plus-circle me-2"></i>Add New Room
                                </button>
                                <button class="room-tab" data-tab="manage-status" onclick="switchRoomTab('manage-status')">
                                    <i class="fas fa-cogs me-2"></i>Manage Status
                                </button>
                            </div>

                            <!-- View All Rooms Tab -->
                            <div id="view-rooms" class="room-tab-content active">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h5 class="mb-0">Room Inventory Overview</h5>
                                    <select id="room-filter" class="form-select w-auto" onchange="filterRooms()">
                                        <option value="all">All Rooms</option>
                                        <option value="available">Available</option>
                                        <option value="Reserved">Occupied</option>
                                    </select>
                                </div>

                                <div class="room-list" id="room-list-container">
                                    <?php if($rooms_result->num_rows > 0): ?>
                                        <?php while($room = $rooms_result->fetch_assoc()): 
                                            $room_image = !empty($room['room_image']) ? '../assets/images/rooms/' . $room['room_image'] : 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80';
                                            $availability_badge = '';
                                            $badge_class = '';
                                            
                                            switch($room['STATUS']) {
                                                case 'available':
                                                    $availability_badge = 'Available';
                                                    $badge_class = 'available';
                                                    break;
                                                case 'Reserved':
                                                    $availability_badge = 'Occupied';
                                                    $badge_class = 'low-stock';
                                                    break;
                                                default:
                                                    $availability_badge = $room['STATUS'];
                                                    $badge_class = 'out-of-stock';
                                            }
                                        ?>
                                        <div class="room-item" data-room-id="ROOM-<?php echo $room['ROOMID']; ?>" data-status="<?php echo $room['STATUS']; ?>">
                                            <div class="room-image-container">
                                                <img src="<?php echo $room_image; ?>" 
                                                     alt="<?php echo htmlspecialchars($room['TYPENAME']); ?>"
                                                     onerror="this.src='https://images.unsplash.com/photo-1611892440504-42a792e24d32?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80'">
                                                <span class="availability-badge <?php echo $badge_class; ?>">
                                                    <?php echo $availability_badge; ?>
                                                </span>
                                            </div>
                                            <div class="room-info">
                                                <div class="room-name"><?php echo htmlspecialchars($room['TYPENAME']); ?></div>
                                                <div class="room-details">
                                                    <span>$<?php echo number_format($room['PRICE_PER_NIGHT'], 2); ?>/night</span>
                                                    <span>Room <?php echo $room['ROOM_NUMBER']; ?></span>
                                                </div>
                                                <div class="room-specs">
                                                    <span class="spec-badge">
                                                        <i class="fas fa-user me-1"></i><?php echo $room['MAXOCCUPANCY']; ?> guests
                                                    </span>
                                                    <span class="spec-badge">
                                                        <i class="fas fa-bed me-1"></i><?php echo $room['bed']; ?> bed<?php echo $room['bed'] > 1 ? 's' : ''; ?>
                                                    </span>
                                                    <span class="spec-badge">
                                                        <i class="fas fa-bath me-1"></i><?php echo $room['toillet']; ?> bathroom<?php echo $room['toillet'] > 1 ? 's' : ''; ?>
                                                    </span>
                                                </div>
                                                <div class="room-actions">
                                                    <a href="?delete_room=<?php echo $room['ROOMID']; ?>" 
                                                       class="btn-delete"
                                                       onclick="return confirm('Are you sure you want to delete this room? This action cannot be undone.')">
                                                        <i class="fas fa-trash me-1"></i>Delete
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                    <div class="col-12">
                                        <div class="empty-state">
                                            <div class="empty-icon">
                                                <i class="fas fa-bed"></i>
                                            </div>
                                            <h5>No Rooms Found</h5>
                                            <p>There are no rooms in the inventory.</p>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Add New Room Tab -->
                            <div id="add-room" class="room-tab-content">
                                <h5 class="mb-4">Add New Room to Inventory</h5>

                                <form id="addRoomForm" class="add-room-form" method="POST" action="">
                                    <input type="hidden" name="add_room" value="1">
                                    
                                    <!-- Room Information -->
                                    <div class="form-section">
                                        <h6 class="form-section-title">Room Information</h6>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="room_type_id">Room Type *</label>
                                                    <select id="room_type_id" name="room_type_id" class="form-control" required>
                                                        <option value="">Select Room Type</option>
                                                        <?php 
                                                        $room_types_result->data_seek(0); // Reset pointer
                                                        while($room_type = $room_types_result->fetch_assoc()): ?>
                                                        <option value="<?php echo $room_type['ROOMTYPEID']; ?>">
                                                            <?php echo htmlspecialchars($room_type['TYPENAME']); ?> - 
                                                            Max <?php echo $room_type['MAXOCCUPANCY']; ?> guests, 
                                                            <?php echo $room_type['bed']; ?> bed(s), 
                                                            <?php echo $room_type['toillet']; ?> bathroom(s)
                                                        </option>
                                                        <?php endwhile; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="room_number">Room Number *</label>
                                                    <input type="number" id="room_number" name="room_number" class="form-control" 
                                                           min="1" max="999" required placeholder="e.g., 101">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="price_per_night">Price Per Night ($) *</label>
                                                    <input type="number" id="price_per_night" name="price_per_night" class="form-control" 
                                                           min="50" max="5000" step="0.01" required placeholder="e.g., 150.00">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="text-end mt-4">
                                        <button type="reset" class="btn btn-secondary me-2">Reset Form</button>
                                        <button type="submit" class="btn-submit">
                                            <i class="fas fa-plus-circle me-2"></i>Add Room to Inventory
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- Manage Status Tab -->
                            <div id="manage-status" class="room-tab-content">
                                <h5 class="mb-4">Update Room Status</h5>
                                <p class="text-muted mb-4">Update the status and availability for each room</p>

                                <?php 
                                // Re-fetch rooms for status management
                                $rooms_status_stmt = $connect->prepare("
                                    SELECT 
                                        rm.ROOMID,
                                        rm.ROOM_NUMBER,
                                        rm.STATUS,
                                        rm.PRICE_PER_NIGHT,
                                        rt.TYPENAME
                                    FROM room rm
                                    JOIN room_type rt ON rm.ROOMTYPEID = rt.ROOMTYPEID
                                    ORDER BY rm.ROOM_NUMBER ASC
                                ");
                                $rooms_status_stmt->execute();
                                $rooms_status_result = $rooms_status_stmt->get_result();
                                ?>
                                
                                <?php if($rooms_status_result->num_rows > 0): ?>
                                <form method="POST" action="">
                                    <input type="hidden" name="update_room_status" value="1">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Room Details</th>
                                                    <th>Current Status</th>
                                                    <th>Update Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody id="status-table">
                                                <?php while($room = $rooms_status_result->fetch_assoc()): 
                                                    $status_badge = '';
                                                    switch($room['STATUS']) {
                                                        case 'available':
                                                            $status_badge = 'bg-success';
                                                            break;
                                                        case 'Reserved':
                                                            $status_badge = 'bg-warning';
                                                            break;
                                                        default:
                                                            $status_badge = 'bg-secondary';
                                                    }
                                                ?>
                                                <tr>
                                                    <td>
                                                        <strong><?php echo htmlspecialchars($room['TYPENAME']); ?></strong><br>
                                                        <small class="text-muted">Room <?php echo $room['ROOM_NUMBER']; ?>, $<?php echo number_format($room['PRICE_PER_NIGHT'], 2); ?>/night</small>
                                                    </td>
                                                    <td>
                                                        <span class="badge <?php echo $status_badge; ?>"><?php echo htmlspecialchars($room['STATUS']); ?></span>
                                                    </td>
                                                    <td>
                                                        <select name="room_status[<?php echo $room['ROOMID']; ?>]" class="form-select form-select-sm">
                                                            <option value="available" <?php echo $room['STATUS'] == 'available' ? 'selected' : ''; ?>>Available</option>
                                                            <option value="Reserved" <?php echo $room['STATUS'] == 'Reserved' ? 'selected' : ''; ?>>Occupied</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="hidden" name="room_id" value="<?php echo $room['ROOMID']; ?>">
                                                        <button type="submit" class="btn btn-sm btn-outline-primary">
                                                            Update
                                                        </button>
                                                    </td>
                                                </tr>
                                                <?php endwhile; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </form>
                                <?php else: ?>
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <i class="fas fa-bed"></i>
                                    </div>
                                    <h5>No Rooms Found</h5>
                                    <p>There are no rooms in the inventory.</p>
                                </div>
                                <?php endif; ?>
                                <?php $rooms_status_stmt->close(); ?>
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
                                <a href="?logout=1" class="btn btn-confirm-signout">Sign Out</a>
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

            // Initialize first tab in room management
            switchRoomTab('view-rooms');
            
            // Auto-hide alerts after 5 seconds
            setTimeout(() => {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(alert => {
                    if (alert.classList.contains('show')) {
                        const bsAlert = new bootstrap.Alert(alert);
                        bsAlert.close();
                    }
                });
            }, 5000);
        });

        // Room Management Tabs
        function switchRoomTab(tabId) {
            // Update active tab
            document.querySelectorAll('.room-tab').forEach(tab => {
                tab.classList.remove('active');
                if (tab.getAttribute('data-tab') === tabId) {
                    tab.classList.add('active');
                }
            });

            // Show corresponding content
            document.querySelectorAll('.room-tab-content').forEach(content => {
                content.classList.remove('active');
                if (content.id === tabId) {
                    content.classList.add('active');
                }
            });
        }

        // Booking filtering
        function filterBookings(status) {
            const bookings = document.querySelectorAll('#bookings-container .booking-item');
            const emptyState = document.createElement('div');
            emptyState.className = 'empty-state';
            emptyState.innerHTML = `
                <div class="empty-icon">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <h5>No bookings found</h5>
                <p>There are no bookings matching your current filter.</p>
            `;

            // Remove existing empty state if any
            const existingEmptyState = document.querySelector('#bookings-container .empty-state');
            if (existingEmptyState) {
                existingEmptyState.remove();
            }

            // Update filter button active state
            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.classList.remove('active');
                if ((status === 'all' && btn.textContent.includes('All Bookings')) ||
                    (status === 'Confirmed' && btn.textContent.includes('Pending')) ||
                    (status === 'Completed' && btn.textContent.includes('Confirmed')) ||
                    (status === 'Cancelled' && btn.textContent.includes('Cancelled'))) {
                    btn.classList.add('active');
                }
            });

            let visibleCount = 0;

            bookings.forEach(booking => {
                const bookingStatus = booking.getAttribute('data-status');
                if (status === 'all' || bookingStatus === status) {
                    booking.style.display = 'block';
                    visibleCount++;
                } else {
                    booking.style.display = 'none';
                }
            });

            // Show/hide empty state
            if (visibleCount === 0 && bookings.length > 0) {
                document.getElementById('bookings-container').appendChild(emptyState);
            }
        }

        // Room filtering
        function filterRooms() {
            const filter = document.getElementById('room-filter').value;
            const rooms = document.querySelectorAll('#room-list-container .room-item');
            const emptyState = document.createElement('div');
            emptyState.className = 'col-12 empty-state';
            emptyState.innerHTML = `
                <div class="empty-icon">
                    <i class="fas fa-bed"></i>
                </div>
                <h5>No rooms found</h5>
                <p>There are no rooms matching your current filter.</p>
            `;

            // Remove existing empty state if any
            const existingEmptyState = document.querySelector('#room-list-container .empty-state');
            if (existingEmptyState) {
                existingEmptyState.remove();
            }

            let visibleCount = 0;

            rooms.forEach(room => {
                const status = room.getAttribute('data-status');
                if (filter === 'all' || status === filter) {
                    room.style.display = 'block';
                    visibleCount++;
                } else {
                    room.style.display = 'none';
                }
            });

            // Show/hide empty state
            if (visibleCount === 0 && rooms.length > 0) {
                document.getElementById('room-list-container').innerHTML = '';
                document.getElementById('room-list-container').appendChild(emptyState);
            }
        }

        // Sign out functions
        function cancelSignout() {
            // Go back to dashboard
            document.querySelector('[data-section="dashboard"]').click();
        }

        // Show notification (for future enhancements)
        function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.className = `alert alert-${type} alert-dismissible fade show`;
            notification.innerHTML = `
                <i class="fas fa-${type === 'success' ? 'check' : 'exclamation'}-circle me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            
            const container = document.querySelector('.alert-container') || createAlertContainer();
            container.appendChild(notification);
            
            // Auto-remove after 5 seconds
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.remove();
                }
            }, 5000);
        }

        function createAlertContainer() {
            const container = document.createElement('div');
            container.className = 'alert-container';
            document.body.appendChild(container);
            return container;
        }
    </script>
</body>
</html>
<?php
// Close database connections
if (isset($connect)) {
    $connect->close();
}
?>
