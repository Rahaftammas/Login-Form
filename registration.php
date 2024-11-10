<?php
session_start();
include('config.php'); // Database configuration file

if (isset($_POST['signup'])) {
    $fname = htmlspecialchars($_POST['fullname']);
    $email = htmlspecialchars($_POST['emailid']);
    $mobile = htmlspecialchars($_POST['mobileno']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    try {
        $sql = "INSERT INTO tblusers (FullName, EmailId, ContactNo, Password) VALUES (:fname, :email, :mobile, :password)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':fname', $fname, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':mobile', $mobile, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->execute();

        if ($dbh->lastInsertId()) {
            echo "<script>alert('Registration successful. Now you can log in.');</script>";
        } else {
            echo "<script>alert('Something went wrong. Please try again.');</script>";
        }
    } catch (PDOException $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="style1.css"></head>
<body>
<div class="wrapper">
    <form method="post" name="signup" onsubmit="return valid();" action="registration.php">
        <div class="input-field">
            <input type="text" name="fullname" required>
            <label>Full Name</label>
        </div>
        <div class="input-field">
            <input type="text" name="mobileno" maxlength="10" required>
            <label>Mobile Number</label>
        </div>
        <div class="input-field">
            <input type="email" name="emailid" id="emailid" onblur="checkAvailability()" required>
            <label>Email Address</label>
            <span id="user-availability-status" style="font-size:12px;"></span>
        </div>
        <div class="input-field">
            <input type="password" name="password" required>
            <label>Password</label>
        </div>
        <div class="input-field">
            <input type="password" name="confirmpassword" required>
            <label>Confirm Password</label>
        </div>
        <button type="submit" name="signup">Sign Up</button>
        <div class="register"></div>
        <p>Already got an account? <a href="login.php">Login Here</a></p>
    </form>
</div>

<script>

function valid() {
    if (document.signup.password.value !== document.signup.confirmpassword.value) {
        alert("Password and Confirm Password do not match!");
        document.signup.confirmpassword.focus();
        return false;
    }
    return true;
}
</script>
</body>
</html>





