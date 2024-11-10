<?php
session_start();
include('config.php'); // Make sure your database connection is here

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Fetch the hashed password from the database
    $sql = "SELECT EmailId, Password, FullName FROM tblusers WHERE EmailId=:email";
    $query = $dbh->prepare($sql);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_OBJ);

    if ($result && password_verify($password, $result->Password)) {
        // Store session variables if login successful
        $_SESSION['login'] = $_POST['email'];
        $_SESSION['fname'] = $result->FullName;
        
        // Reload the current page
        echo "<script type='text/javascript'> document.location = '" . $_SERVER['REQUEST_URI'] . "'; </script>";
    } else {
        echo "<script>alert('Invalid Details');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="style1.css"></head>
<body>
    <div class="wrapper">
        <form action="index.php" method="POST">
            <h2>Login Form</h2>
            <div class="input-field">
                <input type="text" name="email" required>
                <label>Enter your email</label>
            </div>
            <div class="input-field">
                <input type="password" name="password" required>
                <label>Enter your password</label>
            </div>
            <div class="forget">
                <label for="remember">
                    <input type="checkbox" id="remember">
                    <p>Remember me</p>
                </label>
                <a href="forgotpassword.php">Forget password?</a>
            </div>
            <button type="submit" name="login">Login</button>
            <div class="register"></div>
            <p>Don't have an account? <a href="registration.php">Register</a></p>
        </form></div></body></html>

        