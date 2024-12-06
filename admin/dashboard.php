<?php
include '../serverdb/connectAdmin.php';

session_start();

// Check if admin is logged in
if (!isset($_SESSION['adminid'])) {
    header('Location: login.php');
    exit();
}

$adminid = $_SESSION['adminid'];

// Fetch admin details (optional, for a personalized greeting)
$stmt = $db->prepare("SELECT firstname, lastname FROM ADMIN WHERE AdminID = ?");
$stmt->execute([$adminid]);
$admin = $stmt->fetch(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(45deg, #A87676, #A87676, #CA8787, #E1ACAC, #A87676, #E1ACAC, #CA8787, #A87676, #A87676);
            background-size: 400% 400%;
            animation: gradientAnimation 8s ease infinite;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            height: 100vh;
            margin: 0;
            padding-top: 50px;
        }

        @keyframes gradientAnimation {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .header .logo {
            font-size: 24px;
            font-weight: bold;
            color: white;
            display: flex; 
            align-items: center; 
        }

        .header .logo .logo-image {
            width: 30px; 
            height: 30px; 
            margin-right: 10px; 
            animation: pumpAnimation 1.5s infinite ease-in-out;
        }

        @keyframes pumpAnimation {
            0% {
                transform: scale(1); 
            }
            50% {
                transform: scale(1.2); 
            }
            100% {
                transform: scale(1); 
            }
        }

        .header {
            width: 100%;
            background-color: #A87676;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
            position: absolute;
            top: 0;
            left: 0;
        }

        .header .logo {
            font-size: 24px;
            font-weight: bold;
            color: white;
        }

        .header nav {
            display: flex;
            justify-content: flex-start; 
            gap: 10px; 
            padding-right: 45px; 
        }


        .header a {
            text-decoration: none;
            color: white;
            font-weight: bold;
            font-size: 16px;
            padding: 10px 10px;
            border-radius: 4px;
        }

        .header a:hover {
            background-color: #CA8787;
        }

        .dashboard-container {
            width: 90%;
            margin-top: 30px;
        }
        
        .welcome-banner {
            background-color: #A87676;
            color: white;
            text-align: center;
            padding: 20px 15px;
            border: 2px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .welcome-banner h1 {
            font-family: 'Arial', sans-serif;
            font-size: 2rem;
            margin-bottom: 10px;
            color: #E5E1DA;
        }

    </style>
</head>
<body>
        <!-- Navigation Bar -->
        <header class="header">
        <div class="logo">
        <img src="../images/logo.png" class="logo-image">
        FitFusion
    </div>

    <!--navbar--->
        <nav>
            <a href="dashboard.php">Dashboard</a>
            <a href="login.php"><b>Logout</b></a>
            </nav>
    </header>

    <!-- Dashboard Content -->
    <div class="dashboard-container">
        <!-- Welcome Banner -->
        <div class="welcome-banner">
            <h1>Welcome, <?php echo htmlspecialchars($admin['firstname'] . ' ' . $admin['lastname']); ?>!</h1>
        </div>

        <!-- Example Content: Logs Section -->
        <div class="logs-section">
            <h2>Recent Logs</h2>
            <?php
            // Fetch recent logs (example query)
            $logsStmt = $db->query("SELECT * FROM LOGS ORDER BY ActionDate DESC LIMIT 5");
            $logs = $logsStmt->fetchAll(PDO::FETCH_ASSOC);

            if ($logs):
                foreach ($logs as $log): ?>
                    <div class="log-entry">
                        <p><strong>Action:</strong> <?php echo htmlspecialchars($log['Action']); ?></p>
                        <p><strong>Table:</strong> <?php echo htmlspecialchars($log['ChangeTable']); ?></p>
                        <p><strong>Date:</strong> <?php echo htmlspecialchars($log['ActionDate']); ?></p>
                    </div>
                <?php endforeach;
            else: ?>
                <p>No recent logs available.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
