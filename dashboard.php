<!DOCTYPE html>  
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Dashboard</title>
    <style>
        /* Body Styles */
        body {
            background-image: url('./media/3.webp'); /* Replace with your image path */
            background-size: cover; /* Cover the entire viewport */
            background-repeat: no-repeat; /* Prevent the image from repeating */
            background-position: center; /* Center the background image */
            height: 100vh; /* Full height of the viewport */
            width: 100vw; /* Full width of the viewport */
            color: #fff;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Navigation Bar Styles */
        .navbar {
            background-color: rgba(52, 58, 64, 0.9); /* Dark background with transparency */
            padding: 15px; /* Add padding for a better look */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.5); /* Shadow for depth */
            display: flex; /* Flexbox for alignment */
            justify-content: space-between; /* Space between brand and nav items */
            align-items: center; /* Center items vertically */
        }

        .navbar-brand {
            color: #00ff00; /* Bright green for the brand */
            font-size: 1.75em; /* Increase font size for visibility */
            transition: color 0.3s ease; /* Smooth transition for hover effect */
        }

        .navbar-brand:hover {
            color: #ffffff; /* Change to white on hover */
        }

        .navbar-nav {
            list-style: none; /* Remove default list styles */
            display: flex; /* Use flexbox for nav items */
            gap: 20px; /* Space between items */
        }

        .nav-link {
            color: #ffffff; /* White text for links */
            text-decoration: none; /* Remove underline */
            padding: 10px 15px; /* Padding for clickable area */
            border-radius: 5px; /* Rounded corners */
            transition: background-color 0.3s ease, transform 0.3s ease; /* Smooth transition */
        }

        .nav-link:hover {
            background-color: #005500; /* Dark green background on hover */
            transform: scale(1.05); /* Slightly enlarge link on hover */
        }

        .nav-link.active {
            font-weight: bold; /* Bold style for active link */
            background-color: #00ff00; /* Bright green for active link */
            color: #000; /* Change text color for better contrast */
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .navbar {
                flex-direction: column; /* Stack items vertically */
                align-items: center; /* Center items */
            }

            .navbar-nav {
                flex-direction: column; /* Stack nav items vertically */
                gap: 10px; /* Smaller gap on mobile */
            }
        }

        /* Container and Genre Picker Styles */
        .container {
            text-align: center;
            margin-top: 50px;
        }

        h2 {
            color: #00ff00; /* Bright green for heading */
        }

        .genre-picker {
            display: flex;
            justify-content: center;
            gap: 50px;
            margin-top: 20px;
        }

        .genre {
            background-color: rgba(26, 26, 26, 0.8); /* Dark card background with transparency */
            border: 2px solid #005500;
            border-radius: 10px;
            padding: 20px;
            transition: transform 0.3s, box-shadow 0.3s;
            width: 200px;
            text-align: center;
            position: relative; /* For position context */
        }

        .genre:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 255, 0, 0.5); /* Green glow effect */
        }

        button {
            background-color: #005500;
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
        }

        button:hover {
            background-color: #00cc00;
            transform: scale(1.05); /* Slightly enlarge button on hover */
        }

        .selected-genre {
            margin-top: 30px;
            font-size: 24px;
            color: #00cc00;
        }
    </style>
</head>
<body>
<nav class="navbar">
    <a class="navbar-brand" href="dashboard.php">MyMovies</a>
    <ul class="navbar-nav">
        <li><a class="nav-link" href="dashboard.php">Dashboard</a></li>
        <li><a class="nav-link active" href="profile.php">Profile</a></li>
        <li><a class="nav-link" href="history.php">History Log</a></li>
        <li><a class="nav-link" href="logout.php">Logout</a></li>
    </ul>
</nav>
    <div class="container">
        <h2>Choose Your Genre</h2>
        <div class="genre-picker">
            <div class="genre" id="comedy">
                <h3>Comedy</h3>
                <p>Laugh Out Loud!</p>
                <button onclick="selectGenre('Comedy', 'comedy.php')">Pick Comedy</button>
            </div>
            <div class="genre" id="animation">
                <h3>Animation</h3>
                <p>Fun for All Ages!</p>
                <button onclick="selectGenre('Animation', 'animation.php')">Pick Animation</button>
            </div>
        </div>
        <div id="selectedGenre" class="selected-genre"></div>
    </div>
    <script>
        function selectGenre(genre, link) {
            const selectedGenreDiv = document.getElementById('selectedGenre');
            selectedGenreDiv.innerHTML = `You have selected: <strong>${genre}</strong>`;
            setTimeout(() => {
                window.location.href = link; // Redirect to the selected genre page after a short delay
            }, 1000); // Delay for 1 second
        }
    </script>
</body>
</html>
