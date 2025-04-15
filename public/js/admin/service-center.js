let serviceCenterIdToDelete = null; // Store service center ID to delete

// Open modal when the delete button is clicked                         
document.querySelectorAll(".delete-btn").forEach(button => {
    button.addEventListener("click", (e) => {
        const serviceCenterRow = e.target.closest("tr");
        serviceCenterIdToDelete = serviceCenterRow.getAttribute("data-service-center-id"); // Get service center ID
        console.log("Service Center ID to delete: ", serviceCenterIdToDelete);
        document.getElementById("delete-modal").classList.remove("hidden"); // Show modal
    });
});

// Cancel delete action
document.getElementById("cancel-delete").addEventListener("click", () => {
    document.getElementById("delete-modal").classList.add("hidden"); // Hide modal
    serviceCenterIdToDelete = null;
});

document.getElementById("confirm-delete").addEventListener("click", () => {
    if (serviceCenterIdToDelete) {
        console.log("Sending request to delete service center ID: ", serviceCenterIdToDelete);
        fetch("/admin/delete-service-center", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({ser_cen_id: serviceCenterIdToDelete }),
        })
            .then((response) => response.json())
            .then((data) => {
                console.log("Parsed response data:", data);
                if (data.status === "success") {
                    console.log("Response from server: ", data);
                    // Find and remove the row from the table
                    const row = document.querySelector(`tr[data-service-center-id="${serviceCenterIdToDelete}"]`);
                    row.remove();
                    document.getElementById("delete-modal").classList.add("hidden"); // Hide modal
                    alert("Service Center deleted successfully.");
                } else {
                    alert(data.message || "Failed to delete Service Center.");
                }
                serviceCenterIdToDelete = null; // Reset the service center ID
            })
            .catch((error) => {
                console.error("Error:", error);
                alert("An error occurred while deleting the Service Center.");
                serviceCenterIdToDelete = null; // Reset the service center ID
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