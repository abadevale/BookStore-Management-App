<?php
#php page that justifies the authentication of the website 

session_start();

if (isset($_POST['email']) &&
    isset($_POST['password']))
{
	#importing the database connection file
	include "../db_conn.php";

	# validation helper function
	include "func-validation.php";
	
	# GET data from the POST request and store them in var
	# variables for connecting to the database

	$email = $_POST['email'];
	$password = $_POST['password'];

	# simple form validation
	# email validation
	$text = "Email";
	$location = "../login.php";
	$ms = "error";
	is_empty($email, $text, $location, $ms, "");

	# simple form validation
	# password validation
	$text = "Password";
	$location = "../login.php";
	$ms = "error";
	is_empty($password, $text, $location, $ms, "");

	#searching for the email
	$sql = "SELECT * FROM admin WHERE email =:email";
	$stmt = $conn->prepare($sql);

	#execute the statement with the provided email
	$stmt -> execute(['email' => $email]);
	 # if the email is exist
    if ($stmt->rowCount() === 1) {
    	$user = $stmt->fetch();

    	$user_id = $user['id'];
    	$user_email = $user['email'];
    	$user_password = $user['password'];
    	if ($email === $user_email) {
    		if (password_verify($password, $user_password)) {
    			$_SESSION['user_id'] = $user_id;
    			$_SESSION['user_email'] = $user_email;
    			header("Location: ../admin.php");
    		}else {
    			# Error message
    	        $em = "Incorrect User name or password";
    	        header("Location: ../login.php?error=$em");
    		}
    	}else {
    		# Error message
    	    $em = "Incorrect User name or password";
    	    header("Location: ../login.php?error=$em");
    	}
    }else{
    	# Error message
    	$em = "Incorrect User name or password";
    	header("Location: ../login.php?error=$em");
    }

}else {
	# Redirect to "../login.php"
	header("Location: ../login.php");
}
