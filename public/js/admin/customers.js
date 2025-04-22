document.addEventListener("DOMContentLoaded", () => {
    const statusModal = document.getElementById("status-modal");
    const modalText = document.getElementById("modal-text");
    const confirmButton = document.getElementById("confirm-status-change");
    let customerIdToUpdate = null;
    let newStatus = null;

    // Handle status button click
    document.querySelectorAll(".status-btn").forEach((button) => {
        button.addEventListener("click", (event) => {
            const row = event.target.closest("tr");
            customerIdToUpdate = row.getAttribute("data-customer-id");
            const currentStatus = event.target.getAttribute("data-status");

            // Determine the new status
            newStatus = currentStatus === "Active" ? "Access Denied" : "Active";

            // Update modal text
            modalText.textContent = `Are you sure you want to change this customer's status to "${newStatus}"?`;

            // Show the modal
            statusModal.classList.remove("hidden");
        });
    });

    // Handle confirm button click
    confirmButton.addEventListener("click", () => {
        if (customerIdToUpdate && newStatus) {
            fetch("/customers-status", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({ cus_id: customerIdToUpdate, status: newStatus }),
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.status === "success") {
                        // Update the status in the table
                        const row = document.querySelector(`tr[data-customer-id="${customerIdToUpdate}"]`);
                        const statusButton = row.querySelector(".status-btn");
                        statusButton.textContent = newStatus;
                        statusButton.setAttribute("data-status", newStatus);

                        alert(`Customer status changed to "${newStatus}" successfully.`);
                    } else {
                        alert(data.message || "Failed to change customer status.");
                    }
                    customerIdToUpdate = null;
                    newStatus = null;
                    statusModal.classList.add("hidden"); // Hide the modal
                })
                .catch((error) => {
                    console.error("Error:", error);
                    alert("An error occurred while changing the customer status.");
                    customerIdToUpdate = null;
                    newStatus = null;
                    statusModal.classList.add("hidden"); // Hide the modal
                });
        }
    });

    // Handle cancel button click
    document.getElementById("cancel-status-change").addEventListener("click", () => {
        customerIdToUpdate = null;
        newStatus = null;
        statusModal.classList.add("hidden"); // Hide the modal
    });
});