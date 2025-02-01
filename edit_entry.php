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

// Fetch existing record
$sql = "SELECT * FROM dairy_details WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (!$row) {
    echo "<p class='text-red-500 text-center'>❌ Record not found!</p>";
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fycode = $_POST['fycode'];
    $edno = $_POST['edno'];
    $paidby = $_POST['paidby'];
    $amount = $_POST['amount'];
    
    $update_sql = "UPDATE dairy_details SET fycode = ?, edno = ?, paidby = ?, amount = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ssssi", $fycode, $edno, $paidby, $amount, $id);

    if ($update_stmt->execute()) {
        echo "<script>alert('✅ Record updated successfully!'); window.location='view_entries.php';</script>";
        exit();
    } else {
        echo "<p class='text-red-500 text-center'>❌ Error updating record. Please try again.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Entry</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-200">
    <div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-lg mt-10">
        <h2 class="text-2xl font-bold text-center mb-6">Edit <span class="text-blue-500">Entry</span></h2>

        <form action="" method="POST">
            <div class="mb-4">
                <label class="block text-gray-700 font-medium">FY Code</label>
                <input type="text" name="fycode" value="<?php echo htmlspecialchars($row['fycode']); ?>" 
                class="w-full p-2 border border-gray-300 rounded mt-1 bg-gray-200 cursor-not-allowed" required readonly>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 font-medium">Society Number</label>
                <input type="text" name="edno" value="<?php echo htmlspecialchars($row['edno']); ?>" 
                    class="w-full p-2 border border-gray-300 rounded mt-1" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium">Paid By</label>
                <select name="paidby" class="w-full p-2 border border-gray-300 rounded mt-1" required>
                    <option value="New Register" <?php if ($row['paidby'] == "New Register") echo "selected"; ?>>New</option>
                    <option value="ReNewal" <?php if ($row['paidby'] == "ReNewal") echo "selected"; ?>>ReNewal</option>
                    <option value="Per Call" <?php if ($row['paidby'] == "Per Call") echo "selected"; ?>>Per Call</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium">Amount</label>
                <input type="number" name="amount" value="<?php echo htmlspecialchars($row['amount']); ?>" 
                    class="w-full p-2 border border-gray-300 rounded mt-1" required>
            </div>

            <button type="submit" class="w-full bg-green-500 text-white p-2 rounded-lg hover:bg-green-700">
                Update
            </button>
            <a href="view_entries.php" class="block text-center mt-3 text-blue-500">Cancel</a>
        </form>
    </div>
</body>
</html>

<?php
$conn->close();
?>
