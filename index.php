<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Stock Management</title>
    <link rel="stylesheet" href="./assets/style/style.css">
</head>
<body>

    <!-- Header Section -->
    <header>
        <div class="logo">Library Stock Management</div>
        <nav>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">Books Inventory</a></li>
                <li><a href="#">Add New Book</a></li>
                <li><a href="#">Search</a></li>
                <li><a href="#">Reports</a></li>
                <li><a href="#">Settings</a></li>
                <li><a href="#">Logout</a></li>
            </ul>
        </nav>
    </header>

    <!-- Main Content -->
    <main>
        <div class="dashboard">
            <div class="dashboard-item">
                <h3>Total Books in Stock</h3>
                <p>3,250</p>
            </div>
            <div class="dashboard-item">
                <h3>Books Available for Checkout</h3>
                <p>2,100</p>
            </div>
            <div class="dashboard-item">
                <h3>Books Currently Checked Out</h3>
                <p>850</p>
            </div>
            <div class="dashboard-item">
                <h3>Books Needing Restocking</h3>
                <p>150</p>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions">
            <button class="btn">Add New Book</button>
            <button class="btn">Search Inventory</button>
            <button class="btn">Generate Report</button>
            <button class="btn">Restock Books</button>
        </div>

        <!-- Recent Activities -->
        <div class="recent-activities">
            <h2>Recent Activities</h2>
            <ul>
                <li>"The Great Gatsby" added to inventory</li>
                <li>"1984" added to inventory</li>
                <li>Checkout: "Moby Dick" - Due 28th Jan</li>
                <li>Restocking Alert: "To Kill a Mockingbird"</li>
            </ul>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Library Stock Management System | <a href="#">Privacy Policy</a> | <a href="#">Terms of Service</a></p>
    </footer>

    <script src="scripts.js"></script>
</body>
</html>
