<?php
session_start();

// Check if the user is logged in; if not, redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Include config file
require_once "config.php";

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_SESSION["id"];
    $movieId = $_POST["movie_id"];
    $rating = $_POST["rating"];
    
    // Check if the user has already rated this movie
    $sql = "SELECT * FROM movie_ratings WHERE user_id = :user_id AND movie_id = :movie_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":user_id", $userId, PDO::PARAM_INT);
    $stmt->bindParam(":movie_id", $movieId, PDO::PARAM_INT);
    $stmt->execute();
    
    // If user has already rated the movie, show a message
    if ($stmt->rowCount() > 0) {
        echo "<script>alert('You have already rated this movie.'); window.location.href='comedy.php';</script>";
    } else {
        // Insert the rating into the database
        $sql = "INSERT INTO movie_ratings (user_id, movie_id, rating) VALUES (:user_id, :movie_id, :rating)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":user_id", $userId, PDO::PARAM_INT);
        $stmt->bindParam(":movie_id", $movieId, PDO::PARAM_INT);
        $stmt->bindParam(":rating", $rating, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            echo "<script>alert('Thank you for your rating!'); window.location.href='comedy.php';</script>";
        } else {
            echo "<script>alert('There was an error saving your rating. Please try again.'); window.location.href='comedy.php';</script>";
        }
    }
}
?>
