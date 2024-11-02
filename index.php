<?php 

session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: profileinfo.php");
    exit;
}

require_once "config.php";

$username = $password = "";
$username_err = $password_err = $login_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    if(empty($username_err) && empty($password_err)){
        $sql = "SELECT id, username, password FROM users WHERE username = :username";
        
        if($stmt = $pdo->prepare($sql)){
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $param_username = trim($_POST["username"]);
            
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    if($row = $stmt->fetch()){
                        $id = $row["id"];
                        $username = $row["username"];
                        $hashed_password = $row["password"];
                        if(password_verify($password, $hashed_password)){
                            session_start();
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            header("location: profileinfo.php");
                        } else{
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else{
                    $login_err = "Invalid username or password.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
            unset($stmt);
        }
    }
    unset($pdo);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('./media/3.gif');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .wrapper {
            width: 360px;
            padding: 30px;
            background-color: #fff; /* White background */
            border-radius: 20px;
            box-shadow: 0px 0px 30px rgba(0, 255, 0, 0.7), 0 0 0 4px black; /* Green shadow and black border */
            background-image: url('./media/5.jpg'); /* Background image */
            background-size: cover;
            background-position: center;
            text-align: center; /* Center text within wrapper */
        }

        .wrapper h2 {
            margin-bottom: 20px;
            color: #28a745; /* Green color for headings */
            font-weight: bold; /* Bold font */
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2); /* Text shadow */
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            color: #28a745; /* Green color for labels */
            font-weight: bold; /* Bold font */
        }

        .form-control {
            border-color: #28a745; /* Green border */
            font-weight: bold; /* Bold font */
        }

        .form-control:focus {
            border-color: #218838; /* Darker green when focused */
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, .25); /* Focus effect */
        }

        .btn-primary {
            background-color: #28a745; /* Green button */
            border-color: #218838; /* Darker green border */
            font-weight: bold; /* Bold font */
        }

        .btn-primary:hover {
            background-color: #218838; /* Darker green on hover */
            border-color: #1e7e34; /* Even darker border on hover */
        }

        .alert {
            margin-top: 20px;
        }
        
        p {
            font-weight: bold;
            color: white;
        }

        a {
            font-weight: bold;
            color: #28a745; /* Green for links */
        } 
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>

        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
        </form>
    </div>
</body>
</html>
