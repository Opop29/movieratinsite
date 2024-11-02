<?php

require_once "config.php";
 
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "Username can only contain letters, numbers, and underscores.";
    } else{
       
        $sql = "SELECT id FROM users WHERE username = :username";
        
        if($stmt = $pdo->prepare($sql)){
           
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
           
            $param_username = trim($_POST["username"]);
          
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            unset($stmt);
        }
    }
    
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
   
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
      
        $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
         
        if($stmt = $pdo->prepare($sql)){
          
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
           
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT);
            if($stmt->execute()){
               
                header("location: index.php");
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
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('./media/4.gif');
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
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-secondary ml-2" value="Reset">
            </div>
            <p>Already have an account? <a href="index.php">Login here</a>.</p>
        </form>
    </div>    
</body>
</html>