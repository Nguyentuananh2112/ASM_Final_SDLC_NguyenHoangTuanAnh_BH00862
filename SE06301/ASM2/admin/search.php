<?php
// Database connection
require('../db/conn.php');

// Search handling
$searchTerm = "";
$displayTerm = ""; // This variable is used to display the correct search value

if (isset($_GET['search_term'])) {
    $searchTerm = $_GET['search_term'];
    $displayTerm = htmlspecialchars($searchTerm); // Store the search value to display it
}

// Search query
$sql = "SELECT * FROM products WHERE name LIKE ?";
$searchTerm = "%$searchTerm%"; // Add percent signs before and after the search term
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Search</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to CSS file -->
</head>

<body>
    <div class="container">
        <h1>Product Search</h1>

        <!-- Search form -->
        <form class="form-search" action="search.php" method="GET">
            <input type="text" name="search_term" placeholder="Enter product name..."
                value="<?php echo $displayTerm; ?>" required>
            <button type="submit">Search</button>
        </form>

        <!-- Display search results -->
        <?php if ($result->num_rows > 0): ?>
            <table class="product-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Product Name</th>
                        <th>Description</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['description']; ?></td>
                            <td><?php echo number_format($row['price'], 0, ',', '.'); ?> VND</td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No products found</p>
        <?php endif; ?>
        <!-- Nút quay về trang chủ -->
        <div class="back-button">
            <a href="index.php">
                <button type="button" class="btn-back">Back to home page</button>
            </a>
        </div>
    </div>
</body>

</html>