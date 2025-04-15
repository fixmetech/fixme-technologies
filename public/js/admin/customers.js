let customerIdToDelete = null; // Store customer ID to delete

// Open modal when the delete button is clicked
document.querySelectorAll(".delete-btn").forEach(button => {
    button.addEventListener("click", (e) => {
        const customerRow = e.target.closest("tr");
        customerIdToDelete = customerRow.getAttribute("data-customer-id"); // Get customer ID
        console.log("Customer ID to delete: ", customerIdToDelete);
        document.getElementById("delete-modal").classList.remove("hidden"); // Show modal
    });
});

// Cancel delete action
document.getElementById("cancel-delete").addEventListener("click", () => {
    document.getElementById("delete-modal").classList.add("hidden"); // Hide modal
    customerIdToDelete = null;
});

// Confirm delete action
document.getElementById("confirm-delete").addEventListener("click", () => {
    if (customerIdToDelete) {
        console.log("Sending request to delete customer ID: ", customerIdToDelete);
        fetch("/admin/delete-customer", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({cus_id: customerIdToDelete}),
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.status === "success") {
                    console.log("Response from server: ", data);
                    // Find and remove the row from the table
                    const row = document.querySelector(`tr[data-customer-id="${customerIdToDelete}"]`);
                    row.remove();
                    document.getElementById("delete-modal").classList.add("hidden"); // Hide modal
                    alert("Customer deleted successfully.");
                } else {
                    alert(data.message || "Failed to delete customer.");
                }
                customerIdToDelete = null; // Reset the customer ID
            })
            .catch((error) => {
                console.error("Error:", error);
                alert("An error occurred while deleting the customer.");
                customerIdToDelete = null; // Reset the customer ID
            });
    }
});

document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('global-search');
    const tableBody = document.getElementById('table-body');
    const originalRows = [...tableBody.querySelectorAll('tr')]; // Store original rows

    // Filter customers based on the search query
    function filterCustomers(query) {
        const lowerCaseQuery = query.toLowerCase();
        tableBody.innerHTML = ''; // Clear the table body

        const filteredRows = originalRows.filter(row => {
            const cells = row.querySelectorAll('td');
            return Array.from(cells).some(cell =>
                cell.textContent.toLowerCase().includes(lowerCaseQuery)
            );
        });

        if (filteredRows.length > 0) {
            filteredRows.forEach(row => tableBody.appendChild(row));
        } else {
            tableBody.innerHTML = `<tr><td colspan="8">No customers found.</td></tr>`;
        }
    }

    // Add event listener to the search input
    searchInput.addEventListener('input', () => {
        const query = searchInput.value.trim();
        filterCustomers(query);
    });
});

