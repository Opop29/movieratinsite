<?php
session_start();

// Check if the user is logged in; if not, redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Include config file
require_once "config.php";

// Fetch comedy movies from the database
$sql = "SELECT * FROM movies WHERE genre = 'Comedy'";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$movies = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Close the statement and connection
unset($stmt);
unset($pdo);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Comedy Movies</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body { font: 14px sans-serif; }
        .wrapper { width: 800px; padding: 20px; margin: 0 auto; }
        .movie-poster { width: 150px; height: auto; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Comedy Movies</h2>
        <p>Select a movie to rate:</p>

        <?php foreach ($movies as $movie): ?>
            <div class="card mb-3">
                <div class="row no-gutters">
                    <div class="col-md-4">
                        <img src="<?php echo htmlspecialchars($movie['poster_url']); ?>" alt="<?php echo htmlspecialchars($movie['title']); ?>" class="movie-poster">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($movie['title']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($movie['description']); ?></p>
                            <form action="submit_rating.php" method="post">
                                <input type="hidden" name="movie_id" value="<?php echo htmlspecialchars($movie['id']); ?>">
                                <div class="form-group">
                                    <label for="rating">Rate this movie:</label>
                                    <select name="rating" class="form-control" required>
                                        <option value="" disabled selected>Select rating</option>
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
            </div>
        <?php endforeach; ?>

        <p><a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a></p>
    </div>
</body>
</html>
