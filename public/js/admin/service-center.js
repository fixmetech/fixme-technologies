document.addEventListener("DOMContentLoaded", () => {
    const statusModal = document.getElementById("status-modal");
    const modalText = document.getElementById("modal-text");
    const confirmButton = document.getElementById("confirm-status-change");
    let serviceCenterIdUpdate = null;
    let newStatus = null;

    // Handle status button click
    document.querySelectorAll(".status-btn").forEach((button) => {
        button.addEventListener("click", (event) => {
            const row = event.target.closest("tr");
            serviceCenterIdUpdate = row.getAttribute("data-service_Centre-id");
            const currentStatus = event.target.getAttribute("data-status");

            // Determine the new status
            newStatus = currentStatus === "Active" ? "Access Denied" : "Active";

            // Update modal text
            modalText.textContent = `Are you sure you want to change this service-center's status to "${newStatus}"?`;

            // Show the modal
            statusModal.classList.remove("hidden");
        });
    });

    // Handle confirm button click
    confirmButton.addEventListener("click", () => {
        if (serviceCenterIdUpdate && newStatus) {
            fetch("/service-center-status", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({ ser_cen_id: serviceCenterIdUpdate, status: newStatus }),
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.status === "success") {
                        // Update the status in the table
                        const row = document.querySelector(`tr[data-service_Centre-id="${serviceCenterIdUpdate}"]`);
                        const statusButton = row.querySelector(".status-btn");
                        statusButton.textContent = newStatus;
                        statusButton.setAttribute("data-status", newStatus);

                        alert(`Service center status changed to "${newStatus}" successfully.`);
                    } else {
                        alert(data.message || "Failed to change service center's status.");
                    }
                    serviceCenterIdUpdate = null;
                    newStatus = null;
                    statusModal.classList.add("hidden"); // Hide the modal
                })
                .catch((error) => {
                    console.error("Error:", error);
                    alert("An error occurred while changing the customer status.");
                    serviceCenterIdUpdate = null;
                    newStatus = null;
                    statusModal.classList.add("hidden"); // Hide the modal
                });
        }
    });

    // Handle cancel button click
    document.getElementById("cancel-status-change").addEventListener("click", () => {
        serviceCenterIdUpdate = null;
        newStatus = null;
        statusModal.classList.add("hidden"); // Hide the modal
    });
});