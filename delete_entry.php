<?php
include "config.php";
include "includes.php";
session_start();

// Check if ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: view_entries.php");
    exit();
}

$id = $_GET['id'];

// Delete record query
$sql = "DELETE FROM dairy_details WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "<script>alert('✅ Record deleted successfully!'); window.location='view_entries.php';</script>";
} else {
    echo "<script>alert('❌ Error deleting record!'); window.location='view_entries.php';</script>";
}

$stmt->close();
$conn->close();
?>
