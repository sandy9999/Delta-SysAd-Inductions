<?php include('server.php');
if(loggedin())
{
header("location: index.php");
}
 ?>
<!DOCTYPE html>
<html>
<head>
<title> User Registration System using PHP and MySQL </title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<h2> Login </h2>
<form method="post" action="a.php"> 
<?php include('errors.php'); ?>
<label> Username </label>
<input type="text" name="username" >
<label> Password </label>
<input type="password" name="password" >
<label>Remember me</label>
<input type="checkbox" name="rememberme">
<button type="submit" name="login" >Log in</button> 
<p> Not a member? <a href="register.php">Sign up </a>
</p>
</form>
</body>


</html>
