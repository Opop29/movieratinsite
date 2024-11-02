<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        /* Navbar Styling */
        .navbar {
            background-color: #343a40;
        }
        .navbar a, .navbar a:hover {
            color: #ffffff;
            font-weight: bold;
        }
        /* Dashboard Styling */
        .dashboard-container {
            padding: 20px;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }
        .genre-card {
            width: 250px;
            height: 180px;
            margin: 20px;
            padding: 20px;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            font-size: 24px;
            font-weight: bold;
            transition: transform 0.3s;
        }
        .genre-card:hover {
            transform: scale(1.05);
        }
        /* Genre Colors */
        .animation { background-color: #ff6b6b; }
        .comedy { background-color: #4ecdc4; }
        .action { background-color: #1a535c; }
        .horror { background-color: #ff6347; }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="#">Movie Dashboard</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="profileinfo.php">Profile</a>
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

    <!-- Dashboard Content -->
    <div class="dashboard-container">
        <!-- Genre Cards -->
        <div class="genre-card animation">Animation</div>
        <div class="genre-card comedy">Comedy</div>
        <div class="genre-card action">Action</div>
        <div class="genre-card horror">Horror</div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
