<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "Nimal@123";
$dbname = "fixmedb";

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL query to fetch data from the 'promotions' table
    $stmt = $pdo->prepare("SELECT promotion_id, admin_id, description, price, media, created_at, updated_at FROM promotion");
    $stmt->execute();

    // Fetch all rows as an associative array
    $promotions = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Handle connection errors
    echo "Connection failed: " . $e->getMessage();
    $promotions = []; // Fallback to an empty array
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Promotions</title>
    <link rel="stylesheet" href="/css/admin/admin-dashboard.css">
    <link rel="stylesheet" href="/css/admin/customers.css">
</head>
<body>
    <?php
    include_once 'components/sidebar.php';
    include_once 'components/header.php';
    ?>
    <div id="customers-table">
        <table class="table">
            <thead>
            <tr>
                <th>Promotion ID</th>
                <th>Admin ID</th>
                <th>Description</th>
                <th>Discount</th>
                <th>Media</th>
                <th>Created Date</th>
                <th>Updated Date</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody id="table-body">
            <?php if (!empty($promotions)): ?>
                <?php foreach ($promotions as $promotion): ?>
                    <tr data-promotion-id="<?= htmlspecialchars($promotion['promotion_id']) ?>">
                        <td><?= htmlspecialchars($promotion['promotion_id']) ?></td>
                        <td><?= htmlspecialchars($promotion['admin_id']) ?></td>
                        <td><?= htmlspecialchars($promotion['description']) ?></td>
                        <td><?= htmlspecialchars($promotion['price']) ?></td>
                        <td><?= htmlspecialchars($promotion['media']) ?></td>
                        <td><?= htmlspecialchars($promotion['created_at']) ?></td>
                        <td><?= htmlspecialchars($promotion['updated_at']) ?></td>
                        <td>
                            <button class="delete-btn">Delete</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8">No Promotions found.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>

        <!-- Modal -->
        <div id="delete-modal" class="modal hidden">
            <div class="modal-content">
                <h3>Are you sure you want to delete this Promotion?</h3>
                <div class="modal-buttons">
                    <button id="confirm-delete" class="button failure">Yes</button>
                    <button id="cancel-delete" class="button gray">No, cancel</button>
                </div>
            </div>
        </div>
    </div>
    
    <script src="/js/admin/customers.js"></script>
    <script src="/js/admin/main.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>
