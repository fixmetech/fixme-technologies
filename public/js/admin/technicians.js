document.addEventListener("DOMContentLoaded", () => {
    const statusModal = document.getElementById("status-modal");
    const modalText = document.getElementById("modal-text");
    const confirmButton = document.getElementById("confirm-status-change");
    let technicianIdToUpdate = null;
    let newStatus = null;

    // Handle status button click
    document.querySelectorAll(".status-btn").forEach((button) => {
        button.addEventListener("click", (event) => {
            const row = event.target.closest("tr");
            technicianIdToUpdate = row.getAttribute("data-technician-id");
            const currentStatus = event.target.getAttribute("data-status");

            // Determine the new status
            newStatus = currentStatus === "Active" ? "Access Denied" : "Active";

            // Update modal text
            modalText.textContent = `Are you sure you want to change this technician's status to "${newStatus}"?`;

            // Show the modal
            statusModal.classList.remove("hidden");
        });
    });

    // Handle confirm button click
    confirmButton.addEventListener("click", () => {
        if (technicianIdToUpdate && newStatus) {
            fetch("/technician-status", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({ tech_id: technicianIdToUpdate, status: newStatus }),
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.status === "success") {
                        // Update the status in the table
                        const row = document.querySelector(`tr[data-Technician-id="${technicianIdToUpdate}"]`);
                        const statusButton = row.querySelector(".status-btn");
                        statusButton.textContent = newStatus;
                        statusButton.setAttribute("data-status", newStatus);

                        alert(`Technician status changed to "${newStatus}" successfully.`);
                    } else {
                        alert(data.message || "Failed to change Technician status.");
                    }
                    technicianIdToUpdate = null;
                    newStatus = null;
                    statusModal.classList.add("hidden"); // Hide the modal
                })
                .catch((error) => {
                    console.error("Error:", error);
                    alert("An error occurred while changing the Technician status.");
                    technicianIdToUpdate = null;
                    newStatus = null;
                    statusModal.classList.add("hidden"); // Hide the modal
                });
        }
    });

    // Handle cancel button click
    document.getElementById("cancel-status-change").addEventListener("click", () => {
        technicianIdToUpdate = null;
        newStatus = null;
        statusModal.classList.add("hidden"); // Hide the modal
    });
});