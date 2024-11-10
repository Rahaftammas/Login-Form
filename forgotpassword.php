<?php
session_start();
include('config.php'); // Include database configuration file

if (isset($_POST['update'])) {
    $email = htmlspecialchars($_POST['email']);
    $mobile = htmlspecialchars($_POST['mobile']);
    $newpassword = password_hash($_POST['newpassword'], PASSWORD_DEFAULT);

    try {
        $sql = "SELECT EmailId FROM tblusers WHERE EmailId=:email AND ContactNo=:mobile";
        $query = $dbh->prepare($sql);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':mobile', $mobile, PDO::PARAM_STR);
        $query->execute();

        if ($query->rowCount() > 0) {
            $updateSql = "UPDATE tblusers SET Password=:newpassword WHERE EmailId=:email AND ContactNo=:mobile";
            $updatePassword = $dbh->prepare($updateSql);
            $updatePassword->bindParam(':email', $email, PDO::PARAM_STR);
            $updatePassword->bindParam(':mobile', $mobile, PDO::PARAM_STR);
            $updatePassword->bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
            $updatePassword->execute();

            echo "<script>alert('Your password was successfully changed.');</script>";
        } else {
            echo "<script>alert('Email or mobile number is invalid.');</script>";
        }
    } catch (PDOException $e) {
        echo "<script>alert('An error occurred. Please try again later.');</script>";
    }
} ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Recovery</title>
    <link rel="stylesheet" href="style1.css"></head>
<body>
<div class="wrapper">
    <h2>Password Recovery</h2>
    <form name="chngpwd" method="post" onsubmit="return valid();" >
        <div class="input-field">
            <input type="email" name="email" required>
            <label>Your Email Address</label>
        </div>
        <div class="input-field">
            <input type="text" name="mobile" required>
            <label>Your Registered Mobile</label>
        </div>
        <div class="input-field">
            <input type="password" name="newpassword" required>
            <label>New Password</label>
        </div>
        <div class="input-field">
            <input type="password" name="confirmpassword" required>
            <label>Confirm Password</label>
        </div>
        <button type="submit" name="update">Reset My Password</button><br>
        <p><a href="login.php">Back to Login</a></p>
    </form>
</div>

<script type="text/javascript">
function valid() {
    if (document.chngpwd.newpassword.value !== document.chngpwd.confirmpassword.value) {
        alert("New Password and Confirm Password do not match!");
        document.chngpwd.confirmpassword.focus();
        return false;
    }
    return true;
}
</script>
</body>
</html>
