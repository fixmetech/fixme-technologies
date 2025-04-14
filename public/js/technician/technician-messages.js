// Menu Toggle
let toggle = document.querySelector(".toggle");
let navigation = document.querySelector(".navigation");
let main = document.querySelector(".main");
let url = window.location.href;
const chatBox = document.querySelector(".chat-box");
const form = document.querySelector(".typing-area");
const inputField = form.querySelector(".input-field");

toggle.onclick = function () {
    navigation.classList.toggle("active");
    main.classList.toggle("active");
};

// Handle form submission
form.onsubmit = (e) => {
    e.preventDefault(); // Prevent default form submission
};

// Fetch user list
document.addEventListener("DOMContentLoaded", () => {
    const fetchUserList = async () => {
        try {
            // Dynamically get the base URL
            let baseUrl = window.location.origin;

            // Construct the endpoint URL
            let apiUrl = `${baseUrl}/technician-messages/load-user-list`;

            const response = await fetch(apiUrl);
            if (response.ok) {
                const html = await response.text();
                const userListContainer = document.querySelector('.users-list');
                if (userListContainer) {
                    userListContainer.innerHTML = html;
                }
            } else {
                console.error('Failed to fetch user list:', response.statusText);
            }
        } catch (error) {
            console.error('Error fetching user list:', error);
        }
    };

    // Fetch user list every 2 seconds
    setInterval(fetchUserList, 1000);
});

function scrollToBottom() {
    chatBox.scrollTo({top: chatBox.scrollHeight, behavior: "smooth"});
}

async function sendMessage(technicianId, customerId) {
    let baseUrl = window.location.origin;
    const chatUrl = `${baseUrl}/customer-messages/${customerId}`;

    const payload = {
        outgoing_msg_id: technicianId,
        incoming_msg_id: customerId,
        message: inputField.value,
    };

    console.log('Sending message:', payload);

    try {
        const response = await fetch(chatUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(payload)
        });

        if (response.ok) {
            inputField.value = "";
            const result = await response.json();
            console.log('Response: ', result);
            scrollToBottom();
        } else {
            inputField.value = "";
            const error = await response.json();
            console.error('Error: ', error);
        }
    } catch (e) {
        inputField.value = "";
        alert('An error occurred while sending the request');
        console.error('Error: ', e);
    }
}

function viewUser(customerId) {
    /* Redirect to the technician profile page */
    window.location.href = `/customer-messages/${customerId}`;
}