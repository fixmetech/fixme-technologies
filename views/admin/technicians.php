<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/admin/customers.css">
    <link rel="stylesheet" href="/css/admin/admin-dashboard.css">
    <title>Admin Dashboard</title>
</head>
<body>
<script src="/js/admin/main.js"></script>
<div class="customers-container">

    <div id="customers-table">
        <table class="table">
            <thead>
            <tr>
                <th>Technician ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Address</th>
                <th>Registered Date</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody id="table-body">
            <?php if (!empty($technicians)): ?>
                <?php foreach ($technicians as $technician): ?>
                    <tr data-technician-id="<?= htmlspecialchars($technician['tech_id']) ?>">
                        <td><?= htmlspecialchars($technician['tech_id']) ?></td>
                        <td><?= htmlspecialchars($technician['fname']) ?></td>
                        <td><?= htmlspecialchars($technician['lname']) ?></td>
                        <td><?= htmlspecialchars($technician['email']) ?></td>
                        <td><?= htmlspecialchars($technician['phone_no']) ?></td>
                        <td><?= htmlspecialchars($technician['address']) ?></td>
                        <td><?= htmlspecialchars($technician['reg_date']) ?></td>
                        <td>
                        <button class="status-btn" data-status="<?= htmlspecialchars($technician['status']) ?>">
                                <?= htmlspecialchars($technician['status']) ?>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">No technicians found.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
        <p id="no-packages-message" style="display: none;">You have no packages yet!</p>
    </div>

    <!-- Modal -->
    <div id="status-modal" class="modal hidden">
        <div class="modal-content">
            <h3 id="modal-text">Are you sure you want to change this technician's status?</h3>
            <div class="modal-buttons">
                <button id="confirm-status-change" class="button failure">Yes</button>
                <button id="cancel-status-change" class="button gray">No, cancel</button>
            </div>
        </div>
    </div>
</div>

<script src="/js/admin/technicians.js"></script>
<!--    Icons-->
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>
