<?php 
// Connect to the database
session_start();
$name = "";
$username = "";
$email = "";
$errors = array();

$db = mysqli_connect('localhost','phpmyadmin','','registration');

if (mysqli_connect_errno()) {
echo "Failed to connect to MySQL: ".mysqli_connect_errno();
}

/*if(isset($_POST['register']))
{
echo "Registered";
else
{
echo "Not registered";
}
/*if(isset($_SESSION['username']))
{
	header("location: index.php");
	exit;
}
else if(isset($_COOKIE['remember_me']))
{	
	//echo $_COOKIE['rememberme'];
	//$username = decryptCookie($_COOKIE['remember_me']);
	//echo $username;
	$username = $_COOKIE['remember_me'];
	$_SESSION['username'] = $username;
	$_SESSION['success'] = "You are now logged in";
s	header("location: index.php");
	//unset($_COOKIE['rememberme']);
}*/

function loggedin()
{
	$login = false;
	if(isset($_SESSION['username']) || isset($_COOKIE['remember_me']))
	{
		$login = true;
	}
	return $login;
}

function encryptCookie($strings)
{
	$encrypt_method = "AES-256-CBC";
	$secret_key = 'This is my secret key';
	$secret_iv = 'This is my secret iv';
	$key = hash('sha256',$secret_key);
	$iv = substr(hash('sha256',$secret_iv),0,16);
	$output = openssl_encrypt($strings,$encrypt_method,$key,0,$iv);
	$output = base64_encode($output);
	//echo $output;
	return $output;
}

function decryptCookie($strings)
{
        $encrypt_method = "AES-256-CBC";
        $secret_key = 'This is my secret key';
        $secret_iv = 'This is my secret iv';
        $key = hash('sha256',$secret_key);
        $iv = substr(hash('sha256',$secret_iv),0,16);
	$output = openssl_decrypt(base64_decode($strings),$encrypt_method,$key,0,$iv);
	return $output;

}
//if register button is clicked
if(isset($_POST['register']))
{
	$username = mysqli_real_escape_string($db,$_POST['username']);
	$email = mysqli_real_escape_string($db,$_POST['email']);
	$password_1 = mysqli_real_escape_string($db,$_POST['password_1']);
	$password_2 = mysqli_real_escape_string($db,$_POST['password_2']);
	$name = mysqli_real_escape_string($db,$_POST['name']);
//ensure form fields are filled properly
	if(empty($username))
	{
		array_push($errors,"Username is required"); //add error to errors array
	}
	else
	{
		if(strlen($username)<=5 || strlen($username)>=10)
		{
			array_push($errors,"Username is between 5 and 10 characters");
		}
		else
		{
                	$query = "SELECT * FROM users WHERE username='$username'";
                	$result = mysqli_query($db,$query);
                	if(mysqli_num_rows($result) ==1)
                	{
	                       array_push($errors,"Username already exists"); 
               		 }

		}
	}
	if(empty($email))
	{
		array_push($errors,"Email is required");

	}
	else
	{
		if(!filter_var($email,FILTER_VALIDATE_EMAIL))
		{
			array_push($errors,"Invalid email address");
		}
		else
		{
			$query = "SELECT * FROM users WHERE email='$email'";
			$result = mysqli_query($db,$query);
			if(mysqli_num_rows($result) ==1)
			{
				array_push($errors,"This email is already registered");
			}
		}
	}
	if(empty($password_1))
	{
		array_push($errors,"Password is required");
	}
	else
	{
		if(strlen($password_1)<=5)
		{
			array_push($errors,"Password to be greater than 5 characters");
		}
		else
		{
			if(!(preg_match('/[a-zA-z]/',$password_1) && preg_match('/\d/',$password_1) && preg_match('/[^a-zA-z\d]/',$password_1)))
			{
				array_push($errors,"Password to have atleast one alphabet, digit and special character");
			}
		}
	}
	if($password_1 != $password_2)
	{
		array_push($errors,"The two passwords do not match");
	}
	//If no errors, create database
	if(count($errors) ==0)
	{
		$password = sha1($password_1);//To encrypt password before storing
		$sql = "INSERT INTO users (name, username, email, password) VALUES ('$name','$username','$email','$password')";
		mysqli_query($db, $sql);
		$_SESSION['username'] = $username;
		header('location: index.php'); //redirect to home page
	}

}
//Log user in from login page
if(isset($_POST['login']))
{
	$username = mysqli_real_escape_string($db,$_POST['username']);
	$password = mysqli_real_escape_string($db,$_POST['password']);
	
	if(empty($username))
	{
		array_push($errors,"Username is required");
	}
	if(empty($password))
	{
		array_push($errors,"Password is required");
	}
	if(count($errors) ==0)
	{
		$password = sha1($password);
		$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
		$result = mysqli_query($db,$query);
		if(mysqli_num_rows($result) ==1)
		{
			if(isset($_POST['rememberme']))
			{
				$days = 30;
				$value = encryptCookie($username);
				setcookie("remember_me",$value,time()+($days*24*60*60*1000));
			}
			else
			{
				$_SESSION['username']  = $username;
				setcookie("remember_me","",time() + (30*24*60*60*1000));
			}
			header("location: index.php");
			exit();
		}else
		{
			array_push($errors,"Wrong username/password combination");
			//header("location: login.php");
		}
	}
}


//logout
if(isset($_GET['logout']))
{
	session_destroy();
	unset ($_SESSION['username']);
	setcookie("remember_me","");
	header('location: a.php');
}

?>
