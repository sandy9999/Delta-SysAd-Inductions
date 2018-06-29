<?php include('server.php'); ?>
<!DOCTYPE html>
<html>
<head>
<title> User Registration System using PHP and MySQL </title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<h2> Register </h2>
<form method="post" action="a.php">
<!--display validation errors here -->
<?php
include('errors.php');
?>
<label>Name</label>
<input type="text" name="name" value="<?php echo $name; ?>" > 
<label> Username </label>
<input type="text" name="username" value="<?php echo $username; ?>" >
<label> Email </label>
<input type="text" name="email" value="<?php echo $email; ?>" >
<label> Password </label>
<input type="password" name="password_1">
<label> Confirm Password </label>
<input type="password" name="password_2">
<button type="submit" name="register" >Register</button> 
<p> Already a member? <a href="login.php">Sign in </a>
</p>
</form>
</body>


</html>
