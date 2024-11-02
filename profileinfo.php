<?php
// Initialize the session
session_start();

// Check if the user is logged in; if not, redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Include config file
require_once "config.php";

// Fetch user information
$sql = "SELECT username, nickname, email, phone, address, created_at FROM users WHERE id = :id";
if ($stmt = $pdo->prepare($sql)) {
    $stmt->bindParam(":id", $_SESSION["id"], PDO::PARAM_INT);
    if ($stmt->execute() && $stmt->rowCount() == 1) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $username = $user["username"];
        $nickname = $user["nickname"];
        $email = $user["email"];
        $phone = $user["phone"];
        $address = $user["address"];
        $created_at = $user["created_at"];

        // Check if profile information is complete
        if ($nickname && $email && $phone && $address) {
            header("location: dashboard.php");
            exit;
        }
    } else {
        echo "User information could not be retrieved.";
        exit;
    }
    unset($stmt);
}

// Update profile information if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nickname = trim($_POST["nickname"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $address = trim($_POST["address"]);

    $update_sql = "UPDATE users SET nickname = :nickname, email = :email, phone = :phone, address = :address WHERE id = :id";
    if ($stmt = $pdo->prepare($update_sql)) {
        $stmt->bindParam(":nickname", $nickname, PDO::PARAM_STR);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->bindParam(":phone", $phone, PDO::PARAM_STR);
        $stmt->bindParam(":address", $address, PDO::PARAM_STR);
        $stmt->bindParam(":id", $_SESSION["id"], PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            header("location: dashboard.php");
            exit;
        } else {
            echo "Something went wrong. Please try again later.";
        }
        unset($stmt);
    }
}

// Close the connection
unset($pdo);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body { font: 14px sans-serif; }
        .wrapper { width: 600px; padding: 20px; margin: 0 auto; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>User Profile</h2>
        <p>Please complete your profile information below:</p>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <table class="table table-bordered">
                <tr><th>Username</th><td><?php echo htmlspecialchars($username); ?></td></tr>
                <tr><th>Nickname</th><td><input type="text" name="nickname" class="form-control" value="<?php echo htmlspecialchars($nickname); ?>"></td></tr>
                <tr><th>Email</th><td><input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($email); ?>"></td></tr>
                <tr><th>Phone</th><td><input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars($phone); ?>"></td></tr>
                <tr><th>Address</th><td><input type="text" name="address" class="form-control" value="<?php echo htmlspecialchars($address); ?>"></td></tr>
                <tr><th>Account Created</th><td><?php echo htmlspecialchars($created_at); ?></td></tr>
            </table>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Save Information">
            </div>
        </form>
    </div>
</body>
</html>
