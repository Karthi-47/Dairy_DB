<?php
include "config.php";
include "includes.php";
session_start();

// Get filter and search values from URL parameters (default to empty)
$filter_fycode = isset($_GET['fycode']) ? trim($_GET['fycode']) : '';
$filter_paidby = isset($_GET['paidby']) ? trim($_GET['paidby']) : '';
$search_edno = isset($_GET['search_edno']) ? trim($_GET['search_edno']) : '';

// Build SQL query with filters and search
$sql = "SELECT * FROM dairy_details WHERE 1=1";

if (!empty($filter_fycode)) {
    $sql .= " AND fycode = '" . $conn->real_escape_string($filter_fycode) . "'";
}
if (!empty($filter_paidby)) {
    $sql .= " AND paidby = '" . $conn->real_escape_string($filter_paidby) . "'";
}
if (!empty($search_edno)) {
    $sql .= " AND edno LIKE '%" . $conn->real_escape_string($search_edno) . "%'";
}

$result = $conn->query($sql);

// Calculate total amount
$total_amount = 0;
$total_society = 0;
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $total_amount += (float) $row['amount'];
    }
}

// Count total unique societies
$sql_count = "SELECT COUNT(DISTINCT edno) AS total_societies FROM dairy_details";
$count_result = $conn->query($sql_count);
$count_row = $count_result->fetch_assoc();
$total_society = $count_row['total_societies'];

// Fetch distinct FY Codes and Paid By values for filter dropdowns
$fycode_query = "SELECT DISTINCT fycode FROM dairy_details";
$fycode_result = $conn->query($fycode_query);

$paidby_query = "SELECT DISTINCT paidby FROM dairy_details";
$paidby_result = $conn->query($paidby_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Database</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>
<body class="bg-gray-200">

<!-- Navigation Bar -->
<nav class="bg-blue-500 shadow-lg py-4 sm:py-0">
        <div class="container flex justify-between items-center">
            <!-- Logo Section -->
            <div class="flex items-center space-x-3">
                <img src="./assets/Logo.png" alt="Company Logo" class="h-12 w-16 sm:h-20 sm:w-24 ml-4">
                <a href="index.php" class="sm:hidden text-white text-xl font-bold">IDIVIPL</a>
                <a href="index.php" class="hidden text-white sm:ml-2 text-xl font-bold sm:block">
                    INTELLIGENT DOTS IT VISION INDIA PRIVATE LIMITED
                </a>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden sm:flex space-x-10 font-bold right-0">
                <a href="index.php" class="text-white text-xl hover:text-gray-300">
                <i class="fa-solid fa-house"></i>
                Home
                </a>
            </div>

            <!-- Mobile Menu Button -->
            <button id="menu-button" class="md:hidden text-white text-2xl mr-6">
                ☰
            </button>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden flex flex-col py-4 space-y-4">
            <a href="index.php" class="text-white py-2 text-lg text-center hover:bg-blue-800">
            <i class="fa-solid fa-house"></i>
            Home
            </a>
        </div>
    </nav>

<!-- Main Content -->
<div class="container mx-auto px-4">
    <h2 class="text-2xl sm:text-3xl font-bold text-center mt-10 mb-6 text-gray-700">Dairy <span class="text-blue-500">Software</span> Registration</h2>

    <!-- Total Amount & Societies -->
    <div class="mb-6 text-left">
        <p class="text-xl font-semibold text-gray-600">Total Amount : <i class="fa-solid fa-indian-rupee-sign"></i>
            <span class="font-bold text-blue-600"><?php echo number_format($total_amount, 2); ?></span>
        </p>
        <p class="text-xl font-semibold text-gray-600">Total Societies : 
            <span class="font-bold text-blue-600"><?php echo $total_society; ?></span>
        </p>
    </div>

    <!-- Filters & Search Form -->
    <form method="GET" class="mb-4 bg-white p-4 rounded-lg shadow">
        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
            <!-- FY Code Filter -->
            <div>
                <label class="text-gray-600 font-semibold">Filter by FY Code:</label>
                <select name="fycode" class="w-full sm:w-1/2 p-2 border border-gray-300 rounded-lg">
                    <option value="">All</option>
                    <?php while ($fycode_row = $fycode_result->fetch_assoc()) { ?>
                        <option value="<?php echo $fycode_row['fycode']; ?>" <?php if ($filter_fycode == $fycode_row['fycode']) echo 'selected'; ?>>
                            <?php echo $fycode_row['fycode']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <!-- Paid By Filter -->
            <div>
                <label class="text-gray-600 font-semibold">Filter by Paid By:</label>
                <select name="paidby" class="w-full sm:w-1/2 p-2 border border-gray-300 rounded-lg">
                    <option value="">All</option>
                    <?php while ($paidby_row = $paidby_result->fetch_assoc()) { ?>
                        <option value="<?php echo $paidby_row['paidby']; ?>" <?php if ($filter_paidby == $paidby_row['paidby']) echo 'selected'; ?>>
                            <?php echo $paidby_row['paidby']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <!-- Search ED Number -->
            <div>
                <label class="text-gray-600 font-semibold">Search By No:</label>
                <input type="text" name="search_edno" value="<?php echo htmlspecialchars($search_edno); ?>" 
                    class="w-full sm:w-1/2 p-2 border border-gray-300 rounded-lg" placeholder="Enter Number">
            </div>

            <!-- Submit & Reset Buttons -->
            <div class="flex items-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-800">Filter</button>
                <a href="view_entries.php" class="ml-4 bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-700">Reset</a>
            </div>
        </div>
    </form>

    <!-- Responsive Table -->
    <div class="overflow-x-auto">
        <table class="w-full table-auto border-collapse shadow-lg rounded-lg overflow-hidden">
            <thead class="bg-blue-400 text-white text-md sm:text-lg">
                <tr>
                    <th class="px-4 py-3 text-center"></th>
                    <th class="px-4 py-3 text-left">S.No</th>
                    <th class="px-4 py-3 text-left">FY Code</th>
                    <th class="px-4 py-3 text-left">ED Number</th>
                    <th class="px-4 py-3 text-left">Paid By</th>
                    <th class="px-4 py-3 text-left">Amount</th>
                    <th class="px-4 py-3 text-left">Paid Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $counter = 1;
                $result->data_seek(0);

                while ($row = $result->fetch_assoc()) {
                    echo "<tr class='border-t hover:bg-gray-300 odd:bg-white even:bg-gray-100'>
                        <td class='px-4 py-3 flex space-x-4'>
                            <a href='edit_entry.php?id=" . $row['id'] . "' class='bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600'><i class='fas fa-pencil-alt'></i></a>
                            <a href='delete_entry.php?id=" . $row['id'] . "' class='bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600' onclick='return confirm(\"Are you sure?\");'><i class='fas fa-trash'></i></a>
                        </td>
                        <td class='px-4 py-3'>" . $counter++ . "</td>
                        <td class='px-4 py-3'>" . $row['fycode'] . "</td>
                        <td class='px-4 py-3'>" . $row['edno'] . "</td>
                        <td class='px-4 py-3'>" . $row['paidby'] . "</td>
                        <td class='px-4 py-3'>" . number_format((float) $row['amount'], 2) . "</td>
                        <td class='px-4 py-3'>" . $row['paid_date'] . "</td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Mobile Navbar -->
<script>
        const menuButton = document.getElementById('menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        menuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    </script>

</body>
</html>
