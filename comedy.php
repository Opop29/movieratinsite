<?php
session_start();

// Check if the user is logged in; if not, redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Include config file
require_once "config.php";

// Fetch the list of comedy movies
$sql = "SELECT * FROM movies WHERE genre = 'Comedy'";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$movies = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch the user's ratings for the comedy movies
$userId = $_SESSION["id"];
$ratingsSql = "SELECT movie_id, rating FROM movie_ratings WHERE user_id = :user_id";
$ratingsStmt = $pdo->prepare($ratingsSql);
$ratingsStmt->bindParam(":user_id", $userId, PDO::PARAM_INT);
$ratingsStmt->execute();
$userRatings = $ratingsStmt->fetchAll(PDO::FETCH_ASSOC);

// Create an associative array of ratings for easy lookup
$userRatingsArray = [];
foreach ($userRatings as $rating) {
    $userRatingsArray[$rating['movie_id']] = $rating['rating'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comedy Movies</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .movie-card {
            margin: 20px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #343a40;">
        <a class="navbar-brand" href="#">Movie Dashboard</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="profile.php">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="historylog.php">History Log</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <h2>Comedy Movies</h2>
        <div class="row">
            <?php foreach ($movies as $movie): ?>
                <div class="col-md-4">
                    <div class="movie-card">
                        <h4><?php echo htmlspecialchars($movie['title']); ?></h4>
                        <img src="<?php echo htmlspecialchars($movie['poster_url']); ?>" alt="<?php echo htmlspecialchars($movie['title']); ?>" class="img-fluid">
                        <p><?php echo htmlspecialchars($movie['description']); ?></p>
                        <p><strong>Release Year:</strong> <?php echo htmlspecialchars($movie['release_year']); ?></p>
                        
                        <?php if (isset($userRatingsArray[$movie['id']])): ?>
                            <p><strong>Your Rating:</strong> <?php echo $userRatingsArray[$movie['id']]; ?> (Rated)</p>
                        <?php else: ?>
                            <form action="submit_rating.php" method="POST">
                                <input type="hidden" name="movie_id" value="<?php echo $movie['id']; ?>">
                                <label for="rating">Rate this movie:</label>
                                <select name="rating" id="rating" required>
                                    <option value="">Select Rating</option>
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                    <?php endfor; ?>
                                </select>
                                <button type="submit" class="btn btn-primary">Submit Rating</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
