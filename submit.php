<?php
include "config.php";
include "includes.php";
session_start();

// Get form data

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fycode = $_POST['fycode'];
    $edno = $_POST['edno'];
    $paidby = $_POST['paidby'];
    $amount = $_POST['amount'];
    $paid_date = $_POST['paid_date'];

    // Check if Society Number already exists
    $check_sql = "SELECT * FROM dairy_details WHERE edno = ?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("s", $edno);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // If the society number already exists, show message
        $message = "<div class='bg-red-500 text-white p-3 rounded-lg text-center'>⚠️ Warning: Society Number already exists! Duplicate entries are not allowed.</div>";
    } else {
        // If society number is unique, insert the data
        $insert_sql = "INSERT INTO dairy_details (fycode, edno, paidby, amount, paid_date) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_sql);
        $stmt->bind_param("sssss", $fycode, $edno, $paidby, $amount, $paid_date);

        if ($stmt->execute()) {
            $message = "<div class='bg-green-500 text-white p-3 rounded-lg text-center'>✅ Successfully saved the entry!</div>";
        } else {
            $message = "<div class='bg-red-500 text-white p-3 rounded-lg text-center'>❌ Error while saving data. Please try again.</div>";
        }
    }
    // Include the message when reloading the form
    include "index.php";  // This includes the HTML form code (from below)
    exit();
}


// Close connection
$conn->close();
?>
