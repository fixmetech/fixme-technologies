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

// Confirm delete action        
document.getElementById("confirm-delete").addEventListener("click", () => {
    if (serviceCenterIdToDelete) {
        console.log("Sending request to delete service center ID: ", serviceCenterIdToDelete);
        fetch("/admin/delete-service-center", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({ser_cen_id: serviceCenterIdToDelete}),
        })
            .then((response) => response.json())
            .then((data) => {
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
