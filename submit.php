<?php
// Database connection settings
$servername = "localhost";
$username = "root";  // Default XAMPP username
$password = "";      // Default XAMPP password (empty)
$database = "dairy_db"; // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$fycode = $_POST['fycode'];
$edno = $_POST['edno'];
$paidby = $_POST['paidby'];
$amount = $_POST['amount'];
$paid_date = $_POST['paid_date'];

// Insert data into database
$sql = "INSERT INTO dairy_details (fycode, edno, paidby, amount, paid_date) VALUES ('$fycode', '$edno', '$paidby', '$amount', '$paid_date')";
if ($conn->query($sql) === TRUE) {
    echo "Record added successfully!";
    // Redirect to success page after successful form submission
    header("Location: success.html");
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close connection
$conn->close();
?>
