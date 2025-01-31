<?php
include "config.php";
session_start();

// Get form data
$fycode = $_POST['fycode'];
$edno = $_POST['edno'];
$paidby = $_POST['paidby'];
$amount = $_POST['amount'];
$paid_date = $_POST['paid_date'];

// Insert data into database
$sql = "INSERT INTO dairy_details (fycode, edno, paidby, amount, paid_date) VALUES ('$fycode', '$edno', '$paidby', '$amount', '$paid_date')";
if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Record added successfully!');</script>";
    echo "<script>window.location.href = 'index.html';</script>";

} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close connection
$conn->close();
?>
