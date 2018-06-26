<?php include("server.php"); 
//echo $_COOKIE['remember_me'];
?>
<!DOCTYPE html>
<html>
<head>
<title>User registration using PHP and MySQL</title>
</head>
<body>
<h1>Home page </h1>
<?php if(isset($_SESSION['username'])): ?>
<p> Welcome  <strong><?php echo $_SESSION['username']; ?></strong></p>

<?php
$tempusername = mysqli_real_escape_string($db,$_SESSION['username']);
//echo $tempusername;
mysqli_query($db,"UPDATE users SET counter = counter+1 WHERE username='$tempusername'");
$sql = "SELECT * FROM users WHERE username='$tempusername'";
$result = mysqli_query($db,$sql); 
if($result)
{
	while($row =mysqli_fetch_array($result))
	{
		echo "You have visited ".$row['counter']." times";
	}
}

?> 
<p><a href="index.php?logout='1'">Logout</a></p>

<?php endif ?>
<?php if(isset($_COOKIE['remember_me'])): ?>
<p> Welcome <strong><?php echo $_COOKIE['remember_me']; ?></strong></p>
<?php
$tempusername = mysqli_real_escape_string($db,$_COOKIE['remember_me']);
//echo $tempusername;
mysqli_query($db,"UPDATE users SET counter = counter+1 WHERE username='$tempusername'");
$sql = "SELECT * FROM users WHERE username='$tempusername'";
$result = mysqli_query($db,$sql); 
if($result)
{
        while($row =mysqli_fetch_array($result))
        {
                echo "You have visited ".$row['counter']." times";
        }
}

?>
<p><a href="index.php?logout='1'">Logout</a></p>
<?php endif ?>

</body>


</html>
