document.addEventListener("DOMContentLoaded", async function() {
    const lotImage = document.getElementById('lot-image');
    const lotPrice = document.getElementById('lot-price');
    const lotCondition = document.querySelector('.condition-box p');
    const lotDescription = document.querySelector('.description-box p');
    const yourBidInput = document.getElementById('your-bid');
    const totalBidsSpan = document.getElementById('total-bids');
    const goBackButton = document.getElementById('go-back');
    const jwtToken = localStorage.getItem('jwtToken'); // Retrieve JWT from local storage

    const urlParams = new URLSearchParams(window.location.search);
    const itemId = urlParams.get('id');

    if (!itemId) {
        document.querySelector('.lot-details-container').innerHTML = '<p>No item ID specified.</p>';
        return;
    }

    try {
        const response = await fetch(`http://localhost:8000/api/item/get_item.php?id=${itemId}`, {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${jwtToken}` // Include JWT in Authorization header
            }
        });

        if (!response.ok) {
            throw new Error('Network response was not ok.');
        }

        const item = await response.json();

        // Check if item data is available
        if (item) {
            lotImage.src = item.image_url || './images/placeholder.png';
            lotImage.alt = item.title || 'Lot Image';
            lotPrice.textContent = `Rs. ${item.current_price.toLocaleString()}`;
            lotCondition.innerHTML = `<strong>Condition:</strong> ${item.condition || 'Unknown'}`;
            lotDescription.innerHTML = `<strong>Description:</strong> ${item.description || 'No description available.'}`;
            totalBidsSpan.textContent = item.total_bids || '0'; // Display total bids
        } else {
            document.querySelector('.lot-details-container').innerHTML = '<p>Item not found.</p>';
        }
    } catch (error) {
        console.error('Error fetching item details:', error);
        document.querySelector('.lot-details-container').innerHTML = '<p>Failed to load item details. Please try again later.</p>';
    }

    goBackButton.addEventListener('click', () => {
        window.history.back();
    });

    const placeBidButton = document.getElementById('place-bid');
    placeBidButton.addEventListener('click', async () => {
        const yourBid = parseFloat(yourBidInput.value);

        if (isNaN(yourBid) || yourBid <= 0) {
            alert('Please enter a valid bid amount.');
            return;
        }

        try {
            const response = await fetch(`http://localhost:8000/api/item/place_bid.php`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${jwtToken}` // Include JWT in Authorization header
                },
                body: JSON.stringify({
                    itemId: itemId,
                    bidAmount: yourBid,
                }),
            });

            if (!response.ok) {
                throw new Error('Network response was not ok.');
            }

            const result = await response.json();

            if (result.message === "Bid placed successfully.") {
                alert('Bid placed successfully!');
                // Update the total bids display
                totalBidsSpan.textContent = `Total Bids: ${result.total_bids}`;
            } else {
                alert('Failed to place bid: ' + result.message);
            }
        } catch (error) {
            console.error('Error placing bid:', error);
            alert('An error occurred while placing the bid.');
        }
    });
});
