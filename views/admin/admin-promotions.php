<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Promotions Management</title>
    <!-- <link rel="stylesheet" href="/css/admin/admin-dashboard.css"> -->
    <style>
       /* General Styles */
body {
    font-family: 'Roboto', Arial, sans-serif;
    background-color: #f4f4f9;
    margin: 0;
    padding: 0;
    color: #333;
    top: 60px;
}

.promotions-container {
    max-width: 1200px;
    margin: 60px auto;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    padding: 20px;
    top: 60px;
}

/* Table Styles */
.table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    top: 100px;
}

.table th {
    background: linear-gradient(135deg, #4caf50, #81c784); /* Gradient background */
    color: white;
    font-size: 1rem;
    font-weight: bold;
    text-transform: uppercase;
    padding: 15px;
    text-align: left;
}

.table td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #ddd;
    font-size: 0.95rem;
    color: #333;
}

.table tbody tr:hover {
    background-color: #f1f8e9; /* Light green hover effect */
    transition: background-color 0.3s ease;
}

.table td:last-child {
    display: flex;
    gap: 10px;
}

/* Button Styles */
.button {
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease;
    font-size: 0.9rem;
}

.button.success {
    background-color: #4caf50;
    color: white;
}

.button.success:hover {
    background-color: #388e3c;
    transform: scale(1.05);
}

.button.failure {
    background-color: #e53935;
    color: white;
}

.button.failure:hover {
    background-color: #d32f2f;
    transform: scale(1.05);
}

.button.gray {
    background-color: #6c757d;
    color: white;
}

.button.gray:hover {
    background-color: #5a6268;
    transform: scale(1.05);
}

.button.update {
    background-color: #17a2b8;
    color: white;
}

.button.update:hover {
    background-color: #138496;
    transform: scale(1.05);
}

/* Modal Styles */
.modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
}

.modal.hidden {
    display: none;
}

.modal-content {
    background-color: white;
    padding: 30px;
    border-radius: 8px;
    width: 90%;
    max-width: 500px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}

.modal-content h2,
.modal-content h3 {
    font-size: 1.5rem;
    margin-bottom: 15px;
    color: #333;
    text-align: center;
}

.modal-form {
    display: grid;
    gap: 15px;
}

.modal-form input,
.modal-form textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 1rem;
}

.modal-buttons {
    display: flex;
    justify-content: space-between;
    margin-top: 20px;
}

.modal-buttons button {
    padding: 10px 20px;
    font-size: 1rem;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.modal-buttons .confirm {
    background-color: #4caf50;
    color: white;
}

.modal-buttons .confirm:hover {
    background-color: #388e3c;
    transform: scale(1.05);
}

.modal-buttons .cancel {
    background-color: #e0e0e0;
    color: #333;
}

.modal-buttons .cancel:hover {
    background-color: #bdbdbd;
    transform: scale(1.05);
}

/* Create Button */
.create-button-container {
    text-align: right;
    margin-bottom: 20px;
}

.create-button-container .button {
    font-size: 1rem;
    padding: 12px 20px;
    background-color: #4caf50;
    color: white;
    border-radius: 5px;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.create-button-container .button:hover {
    background-color: #388e3c;
    transform: scale(1.05);
}
    </style>
</head>
<body>
<script src="/js/admin/main.js"></script>

<div class="promotions-container">
    <div id="promotions-table">
        <table class="table">
            <thead>
            <tr>
                <th>Promotion ID</th>
                <th>Description</th>
                <th>Discount</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody id="table-body">
            <!-- Promotions will be dynamically populated by JavaScript -->
            </tbody>
        </table>
    </div>

    <div class="create-button-container">
        <button id="create-promotion-btn" class="button success">Create New Promotion</button>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="delete-modal" class="modal hidden">
        <div class="modal-content">
            <h3>Are you sure you want to delete this promotion?</h3>
            <div class="modal-buttons">
                <button id="confirm-delete" class="button failure">Yes, Delete</button>
                <button id="cancel-delete" class="button gray">No, Cancel</button>
            </div>
        </div>
    </div>

    <!-- Create/Edit Promotion Modal -->
    <div id="form-modal" class="modal hidden">
        <div class="modal-content">
            <h2 id="form-title">Create New Promotion</h2>
            <form id="promotion-form" class="modal-form" method="post" action="/promotion/add">
                <input type="hidden" name="promid" id="promotion-id">
                <!-- <input type="text" id="title" name="desc"placeholder="Promotion Title" required> -->
                <textarea id="description" name="promdesc" placeholder="Promotion Description" required></textarea>
                <input type="number" id="discount" name="price" placeholder="price" min="0" max="100" required>
                <label>Start Date</label>
                <input type="date" name="strdate" id="start-date" required>
                <label>End Date</label>
                <input type="date" name="enddate" id="end-date" required>
                <div class="modal-buttons">
                    <button type="submit" id="save-promotion" class="button update">Save Promotion</button>
                    <button type="button" class="button gray"
                            onclick="document.getElementById('form-modal').classList.add('hidden')">Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>


    <div id="form-modal1" class="modal hidden">
        <div class="modal-content">
            <h2 id="form-title">Update Promotion</h2>
            <form id="promotion-edit-form" class="modal-form" method="post" action="/promotion/update">
                <input type="hidden" name="promid" id="promotion-id2">
                <!-- <input type="text" id="title" name="desc"placeholder="Promotion Title" required> -->
                <textarea id="description1" name="promdesc" placeholder="Promotion Description" required></textarea>
                <input type="number" id="discount1" name="price" placeholder="Discount (%)" min="0" max="100" required>
                <label>End Date</label>
                <input type="date" name="enddate" id="end-date1" required>
                <div class="modal-buttons">
                    <button type="submit" id="save-promotion1" class="button update">Save changes</button>
                    <button type="button" class="button gray"
                            onclick="document.getElementById('form-modal1').classList.add('hidden')">Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Dummy data for initial promotions
    let promotions = <?php echo json_encode($promotions) ?>;

    document.addEventListener('DOMContentLoaded', () => {
        const createPromotionBtn = document.getElementById('create-promotion-btn');
        const deleteModal = document.getElementById('delete-modal');
        const confirmDeleteBtn = document.getElementById('confirm-delete');
        const cancelDeleteBtn = document.getElementById('cancel-delete');
        const tableBody = document.getElementById('table-body');
        const promotionForm = document.getElementById('promotion-form');
        const promotioneditForm = document.getElementById('promotion-edit-form');
        const formModal = document.getElementById('form-modal');
        const formModal1 = document.getElementById('form-modal1');
        const formTitle = document.getElementById('form-title');
        const savePromotionBtn = document.getElementById('save-promotion');

        let currentPromotionId = null;

        // Render promotions
        function renderPromotions() {
            tableBody.innerHTML = '';
            if (promotions.length === 0) {
                tableBody.innerHTML = `
                        <tr>
                            <td colspan="7">No promotions found.</td>
                        </tr>
                    `;
                return;
            }

            promotions.forEach(promotion => {
                const row = document.createElement('tr');
                row.dataset.promotionId = promotion.promotion_id;
                row.innerHTML = `
                        <td>${promotion.promotion_id}</td>
                        <td>${promotion.description}</td>
                        <td>${promotion.price}%</td>
                        <td>${promotion.created_at}</td>
                        <td>${promotion.updated_at}</td>
                        <td> 
                            <button class="button update edit-btn" data-id="${promotion.promotion_id}">Update</button>
                            <form method = "post" action = "/promotion/delete">
                            <input type="hidden"name = "promid" id="promotion-id1" value = ${promotion.promotion_id} >
                            <button type = "submit" class="button failure delete-btn" data-id="${promotion.promotion_id}">Delete</button>
                        </td>
                    `;
                tableBody.appendChild(row);
            });

            // Add event listeners to update and delete buttons
            document.querySelectorAll('.edit-btn').forEach(btn => {
                btn.addEventListener('click', handleUpdate);
            });

            document.querySelectorAll('.delete-btn').forEach(btn => {
                btn.addEventListener('click', handleDelete);
            });
        }

        // Update Promotion
        function handleUpdate(e) {
            const promotionId = e.target.dataset.id;
            const promotion = promotions.find(p => p.promotion_id == promotionId);

            document.getElementById('promotion-id2').value = promotion.promotion_id;
            document.getElementById('description1').value = promotion.description;
            document.getElementById('discount1').value = promotion.price;
            document.getElementById('end-date1').value = promotion.updated_at;

            currentPromotionId = promotionId;
            formModal1.classList.remove('hidden');
        }

        // // Delete Promotion
        // function handleDelete(e) {
        //     currentPromotionId = e.target.dataset.id;
        //     deleteModal.classList.remove('hidden');
        // }

        // Confirm Delete
        confirmDeleteBtn.addEventListener('click', () => {
            promotions = promotions.filter(p => p.promotion_id != currentPromotionId);
            renderPromotions();
            deleteModal.classList.add('hidden');
        });

        // Cancel Delete
        cancelDeleteBtn.addEventListener('click', () => {
            deleteModal.classList.add('hidden');
        });

        // Open Create Modal
        createPromotionBtn.addEventListener('click', () => {
            promotionForm.reset();
            currentPromotionId = null;
            formModal.classList.remove('hidden');
        });

        // Initial render
        renderPromotions();
    });
</script>
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>