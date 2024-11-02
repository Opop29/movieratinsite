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
$movie_id = $rating = "";
$error_msg = "";

// Process rating submission
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
                header("location: animation.php"); // Redirect to animation page after successful submission
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
