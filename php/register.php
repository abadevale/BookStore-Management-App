<?php
session_start();

// Include the database connection file
include_once 'db_conn.php';

// Check if user is already logged in
if (!isset($_SESSION['user_id']) && !isset($_SESSION['user_email'])) {
    // Process form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $username = $_POST['username'];
        $password = $_POST['password']; // Note: This is just for demonstration, you should hash the password before storing it
        $email = $_POST['email'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];

        // Prepare and execute SQL statement to insert data into Users table
        $sql = "INSERT INTO Users (Username, Password, Email, FirstName, LastName) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $username, $password, $email, $firstname, $lastname);

        // Execute SQL statement
        if ($stmt->execute() === TRUE) {
            // Registration successful, redirect to login page
            header("Location: login.php");
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Close statement
        $stmt->close();
    }
} else {
    // Redirect to login page if the user is already logged in
    header("Location: login.php");
    exit;
}
?>

?>
