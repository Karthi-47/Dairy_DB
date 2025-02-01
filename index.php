<?php
include "includes.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IDIVIPL</title>
</head>
<body class="bg-gray-200">
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
                <a href="view_entries.php" class="text-white text-xl hover:text-gray-300">
                    <i class="fa-solid fa-database"></i> Database
                </a>
            </div>

            <!-- Mobile Menu Button -->
            <button id="menu-button" class="md:hidden text-white text-2xl mr-6">
                ☰
            </button>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden flex flex-col py-4 space-y-4">
            <a href="view_entries.php" class="text-white py-2 text-lg text-center hover:bg-blue-800">
                <i class="fa-solid fa-database"></i> Database
            </a>
        </div>
    </nav>


    <!-- Form -->
    <div class="bg-white p-4 rounded-lg shadow-lg w-full max-w-lg mx-auto mt-4">
        <h2 class="text-2xl font-bold text-center mb-4">Dairy <span class="text-blue-500">Software</span> Registration</h2>

        <!-- Display Result Message if Any -->
        <?php if (isset($message)) echo $message; ?>

        <form action="submit.php" method="POST">
            <div class="mb-4">
                <label for="fycode" class="block text-gray-700 font-medium">FY Code</label>
                <input title="fycode" placeholder="Enter Code" type="text" id="fycode" name="fycode" class="w-full p-2 border border-gray-300 rounded mt-1 bg-gray-200 cursor-not-allowed"
                       maxlength="4" readonly>
            </div>
            <div class="mb-4">
                <label for="edno" class="block text-gray-700 font-medium">Society Number</label>
                <input title="edno" placeholder="Enter Code Number" type="text" name="edno" maxlength="" class="w-full p-2 border border-gray-300 rounded mt-1 focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div class="mb-4">
                <label for="paidby" class="block text-gray-700 font-medium">Paid By</label>
                <select title="paidby" name="paidby" class="w-full p-2 border border-gray-300 rounded mt-1 focus:ring-2 focus:ring-blue-500" required>
                    <option value="0">Select</option>
                    <option value="New Register">New</option>
                    <option value="ReNewal">ReNewal</option>
                    <option value="Per Call">Per Call</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="amount" class="block text-gray-700 font-medium">Amount</label>
                <input title="amount" placeholder="Enter Amount" type="number" name="amount" class="w-full p-2 border border-gray-300 rounded mt-1 focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div class="mb-4">
                <label for="paid_date" class="block text-gray-700 font-medium">Paid Date</label>
                <input type="text" name="paid_date" id="paid_date" class="w-full p-2 border border-gray-300 rounded mt-1 bg-gray-200 cursor-not-allowed" readonly>
            </div>
            
            <button type="submit" class="w-1/2 block mx-auto bg-green-400 text-white p-2 rounded hover:bg-blue-700">Save</button>
        </form>
    </div>

    <!-- Mobile Navbar -->
    <script>
        const menuButton = document.getElementById('menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        menuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    </script>

    <!-- For Paid Date & Time Fetching -->
    <script>
        document.getElementById('paid_date').value = new Date().toLocaleString();
    </script>

    <!-- For Getting Year -->
    <script>
        document.getElementById('fycode').value = new Date().getFullYear();
    </script>

</body>
</html>
