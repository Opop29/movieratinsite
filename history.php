<?php
session_start();

// Check if the user is logged in; if not, redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Include config file
require_once "config.php";

// Define error message variable
$error_msg = "";

// Fetch data using LEFT JOIN
$leftJoinData = [];
$leftJoinSql = "
    SELECT users.username, movies.title, movie_ratings.rating, movie_ratings.rated_at 
    FROM users 
    LEFT JOIN movie_ratings ON users.id = movie_ratings.user_id 
    LEFT JOIN movies ON movie_ratings.movie_id = movies.id";

if ($stmt = $pdo->prepare($leftJoinSql)) {
    if ($stmt->execute()) {
        $leftJoinData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $error_msg = "Could not retrieve LEFT JOIN data.";
    }
    unset($stmt);
}

// Fetch data using RIGHT JOIN
$rightJoinData = [];
$rightJoinSql = "
    SELECT users.username, movies.title, movie_ratings.rating, movie_ratings.rated_at 
    FROM users 
    RIGHT JOIN movie_ratings ON users.id = movie_ratings.user_id 
    RIGHT JOIN movies ON movie_ratings.movie_id = movies.id";

if ($stmt = $pdo->prepare($rightJoinSql)) {
    if ($stmt->execute()) {
        $rightJoinData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $error_msg = "Could not retrieve RIGHT JOIN data.";
    }
    unset($stmt);
}

// Fetch data using UNION
$unionData = [];
$unionSql = "
    SELECT users.username AS user_name, movies.title AS movie_title, movie_ratings.rating, movie_ratings.rated_at 
    FROM users 
    LEFT JOIN movie_ratings ON users.id = movie_ratings.user_id 
    LEFT JOIN movies ON movie_ratings.movie_id = movies.id
    UNION
    SELECT users.username AS user_name, movies.title AS movie_title, movie_ratings.rating, movie_ratings.rated_at 
    FROM users 
    RIGHT JOIN movie_ratings ON users.id = movie_ratings.user_id 
    RIGHT JOIN movies ON movie_ratings.movie_id = movies.id";

if ($stmt = $pdo->prepare($unionSql)) {
    if ($stmt->execute()) {
        $unionData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $error_msg = "Could not retrieve UNION data.";
    }
    unset($stmt);
}

// Close connection
unset($pdo);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>History Log</title>
    <link rel="stylesheet" href="nav.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* General Body Styles */
        body {
            background-color: #121212; /* Dark background */
            color: #e0e0e0; /* Light text color */
            font-family: Arial, sans-serif;
        }

        /* Wrapper Styles */
        .wrapper {
            width: 90%;
            max-width: 1000px;
            padding: 20px;
            margin: 30px auto;
            background-color: #1e1e1e; /* Slightly lighter dark for contrast */
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
        }

        /* Button Styles */
        .btn {
            background-color: #4caf50; /* Green color for buttons */
            color: #ffffff;
            border: none;
            margin: 5px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #45a049; /* Darker green on hover */
        }

        /* Table Styles */
        .table-container {
            margin-bottom: 30px;
            display: none; /* Hide initially */
        }

        .table {
            border-radius: 10px;
            overflow: hidden;
        }

        .table th {
            background-color: #333333; /* Dark header background */
            color: #4caf50; /* Green text color for headers */
            font-weight: bold;
        }

        .table tbody tr:nth-child(even) {
            background-color: #2a2a2a; /* Darker gray for even rows */
        }

        .table tbody tr:hover {
            background-color: #444444; /* Slightly lighter gray on hover */
        }

        .table td, .table th {
            color: #e0e0e0;
        }

        /* Navbar Styles */
        .navbar {
            background-color: #333333;
        }

        .navbar-brand, .nav-link {
            color: #4caf50 !important; /* Green navbar text */
        }

        .nav-link:hover {
            color: #ffffff !important;
        }

        /* Media Queries for Responsiveness */
        @media (max-width: 768px) {
            .navbar {
                text-align: center;
            }

            .nav-link {
                margin: 10px 0;
            }
        }
    </style>
    <script>
        function showTable(tableId) {
            // Hide all table containers
            document.querySelectorAll('.table-container').forEach(table => table.style.display = 'none');
            // Show the selected table container
            document.getElementById(tableId).style.display = 'block';
        }
    </script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark">
    <a class="navbar-brand" href="dashboard.php">MyMovies</a>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
            <li class="nav-item"><a class="nav-link active" href="profile.php">Profile</a></li>
            <li class="nav-item"><a class="nav-link" href="history.php">History Log</a></li>
            <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
        </ul>
    </div>
</nav>

<div class="wrapper">
    <h2>History Log</h2>

    <?php if (!empty($error_msg)) echo '<div class="alert alert-danger">' . $error_msg . '</div>'; ?>

    <!-- Buttons to toggle tables -->
    <button class="btn" onclick="showTable('leftJoinTable')">Show LEFT JOIN</button>
    <button class="btn" onclick="showTable('rightJoinTable')">Show RIGHT JOIN</button>
    <button class="btn" onclick="showTable('unionTable')">Show UNION of LEFT and RIGHT JOIN</button>

    <!-- LEFT JOIN Data -->
    <div id="leftJoinTable" class="table-container">
        <h4>LEFT JOIN</h4>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Movie Title</th>
                    <th>Rating</th>
                    <th>Rated At</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($leftJoinData as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['username']); ?></td>
                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                        <td><?php echo htmlspecialchars($row['rating']); ?></td>
                        <td><?php echo htmlspecialchars($row['rated_at']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- RIGHT JOIN Data -->
    <div id="rightJoinTable" class="table-container">
        <h4>RIGHT JOIN</h4>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Movie Title</th>
                    <th>Rating</th>
                    <th>Rated At</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rightJoinData as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['username']); ?></td>
                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                        <td><?php echo htmlspecialchars($row['rating']); ?></td>
                        <td><?php echo htmlspecialchars($row['rated_at']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- UNION Data -->
    <div id="unionTable" class="table-container">
        <h4>UNION of LEFT and RIGHT JOIN</h4>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Movie Title</th>
                    <th>Rating</th>
                    <th>Rated At</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($unionData as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['user_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['movie_title']); ?></td>
                        <td><?php echo htmlspecialchars($row['rating']); ?></td>
                        <td><?php echo htmlspecialchars($row['rated_at']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
