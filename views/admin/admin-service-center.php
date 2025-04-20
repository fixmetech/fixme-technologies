<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/admin/customers.css">
    <link rel="stylesheet" href="/css/admin/admin-dashboard.css">
    <title>Admin service center management</title>
</head>
<body>
<script src="/js/admin/main.js"></script>

<div class="customers-container">

    <div id="customers-table">
        <table class="table">
            <thead>
            <tr>
                <th>Service Center  ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Address</th>
                <th>Registered Date</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody id="table-body">
            <?php if (!empty($serviceCenters)): ?>
                <?php foreach ($serviceCenters as $serviceCenters): ?>
                    <tr data-service_Centre-id="<?= htmlspecialchars($serviceCenters['ser_cen_id']) ?>">
                        <td><?= htmlspecialchars($serviceCenters['ser_cen_id']) ?></td>
                        <td><?= htmlspecialchars($serviceCenters['name']) ?></td>
                        <td><?= htmlspecialchars($serviceCenters['email']) ?></td>
                        <td><?= htmlspecialchars($serviceCenters['phone_no']) ?></td>
                        <td><?= htmlspecialchars($serviceCenters['address']) ?></td>
                        <td><?= htmlspecialchars($serviceCenters['reg_date']) ?></td>
                        <td>
                            <button class="delete-btn">Delete</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">No Service Centers  found.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
        <p id="no-packages-message" style="display: none;">You have no packages yet!</p>
    </div>

    <!-- Modal -->
    <div id="delete-modal" class="modal hidden">
        <div class="modal-content">
            <h3>Are you sure you want to delete this service centre?</h3>
            <div class="modal-buttons">
                <button id="confirm-delete" class="button failure">Yes</button>
                <button id="cancel-delete" class="button gray">No, cancel</button>
            </div>
        </div>
    </div>
</div>

<script src="/js/admin/service-center.js"></script>
<!--    Icons-->
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>
