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
        $stmt->bindParam(1, $username);
        $stmt->bindParam(2, $password);
        $stmt->bindParam(3, $email);
        $stmt->bindParam(4, $firstname);
        $stmt->bindParam(5, $lastname);

        // Execute SQL statement
        if ($stmt->execute() === TRUE) {
            // Registration successful, redirect to login page
            header("Location: user-login.php");
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Close statement
        $stmt->close();
    }
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Bootstrap link for CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="css/style.css">

           <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f8f9fa; /* Light gray background */
        }

        form {
            background-color: #fff; /* White background */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Box shadow for a subtle effect */
            max-width: 400px; /* Limit form width */
            width: 100%;
        }

        form label {
            display: block;
            margin-bottom: 5px;
        }

        form input[type="text"],
        form input[type="password"],
        form input[type="email"],
        form select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc; /* Light gray border */
            border-radius: 5px;
            box-sizing: border-box;
        }

        form select {
            appearance: none; /* Remove default dropdown arrow */
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url('data:image/svg+xml;utf8,<svg fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="#000" d="M5.212 8.785L12 15.573l6.787-6.787a1 1 0 011.415 1.414l-7.5 7.5a1 1 0 01-1.415 0l-7.5-7.5a1 1 0 111.415-1.414z"/></svg>'); /* Custom dropdown arrow */
            background-repeat: no-repeat;
            background-position: right 10px center;
            padding-right: 30px;
        }

        form input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff; /* Blue button color */
            color: #fff; /* White text color */
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        form input[type="submit"]:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }
        /* Center the h2 element */
        h2 {
            text-align: center;
        }
    </style>
    </head>
    <body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="registration-form">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="firstname">First Name:</label>
        <input type="text" id="firstname" name="firstname">

        <label for="lastname">Last Name:</label>
        <input type="text" id="lastname" name="lastname">

        <input type="submit" value="Register">
        <br>
        <a href="user-login.php">Login if your a member</a>
    </form>
    </body>
    </html>

<?php
} else {
    // Redirect to login page if the user is already logged in
    header("Location: user-login.php");
    exit;
}
?>
