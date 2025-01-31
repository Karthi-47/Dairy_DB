<?php
include "config.php";
session_start();

// Default query to fetch all users and count distinct societies
$sql = "SELECT * FROM dairy_details";
$result = $conn->query($sql);

// Count total amount
$total_amount = 0;
$total_society = 0;
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $total_amount += $row['amount'];
    }
}

// Count total unique societies
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
    <title>Company Database</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<!-- Navigation Bar -->
<nav class="bg-blue-600 p-4 shadow-lg">
    <div class="container flex items-center justify-between">
        <!-- Logo -->
        <a href="index.html" class="sm:hidden text-white text-xl font-bold">IDIVIPL</a>
        <a href="index.html" class="hidden sm:block sm:ml-10 text-white text-xl font-bold">INTELLIGENT DOTS IT VISION INDIA PRIVATE LIMITED</a>

        <!-- Desktop Menu -->
        <div class="hidden sm:flex space-x-6">
            <a href="index.html" class="text-white text-lg font-bold hover:text-gray-300">Home</a>

        </div>

        <!-- Mobile Menu Button -->
        <button id="menu-button" class="md:hidden text-white text-2xl focus:outline-none">
            ☰
        </button>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden md:hidden flex flex-col bg-blue-700 py-4 space-y-2">
        <a href="index.html" class="text-white text-center py-1 hover:bg-blue-800">Home</a>

    </div>
</nav>

<!-- Main Content -->
<div class="container mx-auto px-4">
    <h2 class="text-2xl sm:text-3xl font-bold text-center mt-10 mb-6 text-gray-700">Company <span class="text-blue-600">Database</span></h2>

    <!-- Total Amount & Societies -->
    <div class="mb-6 text-left">
        <p class="text-xl font-semibold text-gray-600">Total Amount : 
            <span class="font-bold text-blue-600"><?php echo number_format($total_amount, 2); ?></span>
        </p>
        <p class="text-xl font-semibold text-gray-600">Total Societies : 
            <span class="font-bold text-blue-600"><?php echo $total_society; ?></span>
        </p>
    </div>

    <!-- Responsive Table -->
    <div class="overflow-x-auto">
        <table class="w-full table-auto border-collapse shadow-lg rounded-lg overflow-hidden">
            <thead class="bg-blue-600 text-white text-lg">
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
                // Initialize counter
                $counter = 1;
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
</div>

<!-- Mobile Navbar Toggle Script -->
<script>
    const menuButton = document.getElementById('menu-button');
    const mobileMenu = document.getElementById('mobile-menu');

    menuButton.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });
</script>

</body>
</html>

<?php
// Close connection
$conn->close();
?>
