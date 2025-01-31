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

// Default query to fetch all users and count distinct societies
$sql = "SELECT * FROM dairy_details";

// Execute query
$result = $conn->query($sql);

// Count total amount and total number of societies
$total_amount = 0;
$total_society = 0;

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $total_amount += $row['amount'];
    }
}

// Query to count the total number of unique societies
$sql_count = "SELECT COUNT(DISTINCT edno) AS total_societies FROM dairy_details";
$count_result = $conn->query($sql_count);
$count_row = $count_result->fetch_assoc();
$total_society = $count_row['total_societies'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Entries</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<nav class="bg-blue-600 p-4 shadow-lg">
        <div class="container mx-auto flex justify-between items-center">
            <a href="index.html" class="text-white text-xl font-bold">IDIVIPL</a>
            
            <!-- Desktop Menu -->
            <div class="hidden md:flex space-x-6">
                <a href="index.html" class="text-white hover:text-gray-300">Home</a>


            </div>
            
            <!-- Mobile Menu Button -->
            <button id="menu-button" class="md:hidden text-white">
                ☰
            </button>
        </div>
        
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden flex flex-col py-4 space-y-4">
            <a href="index.html" class="text-white text-center py-2 hover:bg-blue-800">Home</a>


        </div>
    </nav>

    <div class="container mx-auto">
        <h2 class="text-3xl font-bold text-center mb-6 text-gray-700 mt-10">Entries Stored in Database</h2>

        <!-- Display Total Amount and Total Societies -->
        <div class="mb-6 text-left">
            <p class="text-xl font-semibold text-gray-600">Total Amount: <span class="font-bold text-blue-600"><?php echo number_format($total_amount, 2); ?></span></p>
            <p class="text-xl font-semibold text-gray-600">Total Societies: <span class="font-bold text-blue-600"><?php echo $total_society; ?></span></p>
        </div>

        <!-- Table of Entries -->
        <table class="min-w-full table-auto border-collapse shadow-lg rounded-lg overflow-hidden">
            <thead class="bg-blue-600 text-white">
                <tr>
                    <th class="px-4 py-3 text-left">S.No</th>
                    <th class="px-4 py-3 text-left">FY Code</th>
                    <th class="px-4 py-3 text-left">ED Number</th>
                    <th class="px-4 py-3 text-left">Paid By</th>
                    <th class="px-4 py-3 text-left">Amount</th>
                    <th class="px-4 py-3 text-left">Paid Date</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                <?php
                // Initialize counter for auto-incrementing S.No
                $counter = 1;

                // Reset result pointer and fetch rows again for table display
                $result->data_seek(0);
                while ($row = $result->fetch_assoc()) {
                    echo "<tr class='border-t hover:bg-gray-100'>
                        <td class='px-4 py-3'>" . $counter++ . "</td>
                        <td class='px-4 py-3'>" . $row['fycode'] . "</td>
                        <td class='px-4 py-3'>" . $row['edno'] . "</td>
                        <td class='px-4 py-3'>" . $row['paidby'] . "</td>
                        <td class='px-4 py-3'>" . number_format($row['amount'], 2) . "</td>
                        <td class='px-4 py-3'>" . $row['paid_date'] . "</td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
// Close connection
$conn->close();
?>
