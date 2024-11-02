<?php
session_start();

// Check if the user is logged in; if not, redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Include config file
require_once "config.php";

// Fetch user data from the database
$sql = "SELECT nickname, email, phone, address FROM users WHERE id = :id";

if ($stmt = $pdo->prepare($sql)) {
    $stmt->bindParam(":id", $_SESSION["id"], PDO::PARAM_INT);

    if ($stmt->execute()) {
        if ($stmt->rowCount() == 1) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $nickname = $user["nickname"];
            $email = $user["email"];
            $phone = $user["phone"];
            $address = $user["address"];
        }
    }
    unset($stmt);
}

unset($pdo);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body { font: 14px sans-serif; }
        .wrapper { width: 400px; padding: 20px; margin: 0 auto; }
        .editable { cursor: pointer; }
        .form-control-inline {
            display: inline-block;
            width: auto;
            vertical-align: middle;
        }
        .save-icon { color: green; cursor: pointer; }
        .edit-icon { color: blue; cursor: pointer; }
    </style>
</head>
<body>
    <!-- Navbar -->
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

    <div class="wrapper mt-4">
        <h2>Profile</h2>
        <p>Click the edit icon to change your information.</p>

        <table class="table table-bordered">
            <tr>
                <th>Nickname</th>
                <td>
                    <span class="editable" id="nickname"><?php echo htmlspecialchars($nickname); ?></span>
                    <i class="fas fa-edit edit-icon" onclick="enableEdit('nickname')"></i>
                </td>
            </tr>
            <tr>
                <th>Email</th>
                <td>
                    <span class="editable" id="email"><?php echo htmlspecialchars($email); ?></span>
                    <i class="fas fa-edit edit-icon" onclick="enableEdit('email')"></i>
                </td>
            </tr>
            <tr>
                <th>Phone</th>
                <td>
                    <span class="editable" id="phone"><?php echo htmlspecialchars($phone); ?></span>
                    <i class="fas fa-edit edit-icon" onclick="enableEdit('phone')"></i>
                </td>
            </tr>
            <tr>
                <th>Address</th>
                <td>
                    <span class="editable" id="address"><?php echo htmlspecialchars($address); ?></span>
                    <i class="fas fa-edit edit-icon" onclick="enableEdit('address')"></i>
                </td>
            </tr>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        function enableEdit(field) {
            const span = document.getElementById(field);
            const value = span.innerText;
            span.innerHTML = `<input type="text" class="form-control form-control-inline" id="${field}_input" value="${value}"> 
                <i class="fas fa-save save-icon" onclick="saveChange('${field}')"></i>`;
        }

        function saveChange(field) {
            const newValue = document.getElementById(field + '_input').value;
            $.ajax({
                url: 'update_profile.php',
                type: 'POST',
                data: {
                    field: field,
                    value: newValue
                },
                success: function(response) {
                    document.getElementById(field).innerText = newValue;
                },
                error: function() {
                    alert('An error occurred while saving. Please try again.');
                }
            });
        }
    </script>
</body>
</html>
