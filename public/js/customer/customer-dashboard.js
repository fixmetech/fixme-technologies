async function cancelReq(cusId, techId) {
    console.log(`${cusId}, ${techId}`);

    payload = {
        cus_id: cusId,
        tech_id: techId,
    };


    try {
        const response = await fetch('http://152.42.255.40/delete-cus-tech-req', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(payload)
        });

        if (response.ok) {
            const result = await response.json();
            console.log('Response: ', result);
            window.location.href = `/customer-dashboard`;
        } else {
            const error = await response.json();
            console.error('Error: ', error);
            window.location.href = `/customer-dashboard`;
        }
    } catch (e) {
        alert('An error occurred while sending the request');
        console.error('Error: ', e);
    }
}

async function getAdvancePayments(cusId) {
    window.location.href = `/customer-advance-payments`;
}

function viewTechProfile(techId) {
    window.location.href = `/technician-profile/${techId}`;
}

