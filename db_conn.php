<?php

#php file to allow database connection to the site

#this the name of the server
$sName = "localhost";
#username of the database
$uName = "root";
#the password linked to the database
$pass = "";
#name of the database phpmyadmin
$db_name = "online_book_store_db";

#creating the database connection using php data objects(PDO)

try {
	#creating a new PDO instance with the specified connection parameters
	$conn = new PDO("mysql:host=$sName;dbname=$db_name",$uName, $pass);
	#Set the PDO attribute to enable error reporting and exceptions
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION
	);
    
} catch (PDOException $e){
	#block to catch any exceptions(errors) that may occur during the conncetion attempt.
	echo "Connection failed: ". $e->getMessage();
}