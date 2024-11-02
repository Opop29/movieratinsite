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
/* Body Styles */
body {
    background-color: #f8f9fa; /* Light background for contrast */
    color: #343a40; /* Dark text color for readability */
    font-family: Arial, sans-serif; /* Font family */
}

/* Wrapper Styles */
.wrapper {
    width: 90%; /* Responsive width */
    max-width: 1000px; /* Maximum width */
    padding: 20px; /* Padding for content */
    margin: 30px auto; /* Centering with margin */
    background-color: #ffffff; /* White background for the content area */
    border-radius: 10px; /* Rounded corners */
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Soft shadow for depth */
}

/* Table Styles */
.table-container {
    margin-bottom: 30px; /* Space between tables */
}

.table {
    border-radius: 10px; /* Rounded corners for tables */
    overflow: hidden; /* To ensure border radius is respected */
}

.table th {
    background-color: #343a40; /* Dark background for table header */
    color: #ffffff; /* White text for headers */
}

.table tbody tr:nth-child(even) {
    background-color: #f2f2f2; /* Light gray for even rows */
}

.table tbody tr:hover {
    background-color: #e2e2e2; /* Light hover effect for rows */
}

/* Media Queries for Responsiveness */
@media (max-width: 768px) {
    .navbar {
        text-align: center; /* Center text for mobile */
    }

    .nav-link {
        margin: 10px 0; /* Stack links vertically */
    }
}
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
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

        <!-- LEFT JOIN Data -->
        <div class="table-container">
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
        <div class="table-container">
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
        <div class="table-container">
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
