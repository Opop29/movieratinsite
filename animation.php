<?php
session_start();

// Check if the user is logged in; if not, redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Include config file
require_once "config.php";

// Define variables
$movies = [];
$error_msg = "";

// Fetch movies from the database
$sql = "SELECT * FROM movies WHERE genre = 'Animation'";
if ($stmt = $pdo->prepare($sql)) {
    if ($stmt->execute()) {
        $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $error_msg = "Could not retrieve movies.";
    }
    unset($stmt);
}

// Get user ID
$userId = $_SESSION["id"];

// Fetch user's ratings for animation movies
$userRatings = [];
$ratingsSql = "SELECT movie_id, rating FROM movie_ratings WHERE user_id = :user_id";
if ($ratingsStmt = $pdo->prepare($ratingsSql)) {
    $ratingsStmt->bindParam(":user_id", $userId, PDO::PARAM_INT);
    if ($ratingsStmt->execute()) {
        $userRatings = $ratingsStmt->fetchAll(PDO::FETCH_ASSOC);
    }
    unset($ratingsStmt);
}

// Store ratings in an associative array for easy lookup
$userRatingsArray = [];
foreach ($userRatings as $rating) {
    $userRatingsArray[$rating['movie_id']] = $rating['rating'];
}

// Handle rating submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $movie_id = $_POST['movie_id'];
    $rating = $_POST['rating'];

    // Check if the user has already rated this movie
    if (isset($userRatingsArray[$movie_id])) {
        $error_msg = "You have already rated this movie.";
    } elseif ($rating < 1 || $rating > 5) {
        $error_msg = "Please select a valid rating between 1 and 5.";
    } else {
        // Insert the rating into the database
        $sql = "INSERT INTO movie_ratings (user_id, movie_id, rating) VALUES (:user_id, :movie_id, :rating)";
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":user_id", $_SESSION["id"], PDO::PARAM_INT);
            $stmt->bindParam(":movie_id", $movie_id, PDO::PARAM_INT);
            $stmt->bindParam(":rating", $rating, PDO::PARAM_INT);

            if ($stmt->execute()) {
                header("location: animation.php"); // Refresh to show the new rating status
                exit;
            } else {
                $error_msg = "Failed to submit rating. Please try again.";
            }
            unset($stmt);
        }
    }
}

// Close the connection
unset($pdo);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Animation Movies</title>
    <link rel="stylesheet" href="nav.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #1b1b1b;
            color: white;
            font-family: Arial, sans-serif;
        }
        .wrapper {
            width: 800px;
            padding: 20px;
            margin: 0 auto;
        }
        .alert {
            background-color: #c62828; /* Red for error messages */
        }
        .movie-poster {
            width: 100%;
            border-radius: 5px;
        }
        .card {
            background-color: #333; /* Dark background for cards */
            border: none;
            border-radius: 10px;
        }
        .card-title {
            color: #76ff03; /* Green for titles */
        }
        .btn-primary {
            background-color: #76ff03; /* Green button */
            border: none;
        }
        .btn-primary:hover {
            background-color: #66bb6a; /* Darker green on hover */
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
        <h2>Animation Movies</h2>
        <?php 
        if (!empty($error_msg)) {
            echo '<div class="alert alert-danger">' . $error_msg . '</div>';
        }
        ?>

        <div class="row">
            <?php foreach ($movies as $movie): ?>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="<?php echo htmlspecialchars($movie['poster_url']); ?>" class="card-img-top movie-poster" alt="<?php echo htmlspecialchars($movie['title']); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($movie['title']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($movie['description']); ?></p>
                            
                            <?php if (isset($userRatingsArray[$movie['id']])): ?>
                                <p><strong>Your Rating:</strong> <?php echo $userRatingsArray[$movie['id']]; ?></p>
                            <?php else: ?>
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                    <input type="hidden" name="movie_id" value="<?php echo $movie['id']; ?>">
                                    <div class="form-group">
                                        <label for="rating">Rate this movie:</label>
                                        <select name="rating" class="form-control" required>
                                            <option value="">Select Rating</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Submit Rating</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
