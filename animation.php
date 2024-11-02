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

// Handle rating submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $movie_id = $_POST['movie_id'];
    $rating = $_POST['rating'];

    // Validate the rating
    if ($rating < 1 || $rating > 5) {
        $error_msg = "Please select a valid rating between 1 and 5.";
    } else {
        // Insert the rating into the database
        $sql = "INSERT INTO movie_ratings (user_id, movie_id, rating) VALUES (:user_id, :movie_id, :rating)";
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":user_id", $_SESSION["id"], PDO::PARAM_INT);
            $stmt->bindParam(":movie_id", $movie_id, PDO::PARAM_INT);
            $stmt->bindParam(":rating", $rating, PDO::PARAM_INT);

            if ($stmt->execute()) {
                header("location: animation.php"); // Refresh the page to show the new rating
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
    <title>Animated Movies</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body { font: 14px sans-serif; }
        .wrapper { width: 800px; padding: 20px; margin: 0 auto; }
        .movie-poster { width: 150px; height: auto; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="dashboard.php">Movie Dashboard</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="profile.php">Profile</a></li>
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
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
