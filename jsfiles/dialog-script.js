document.addEventListener("DOMContentLoaded", () => {
    const urlParams = new URLSearchParams(window.location.search);
    const lotId = urlParams.get('id');

    if (lotId) {
        fetch(`http://localhost:3000/lots/${String(lotId)}`)
            .then(response => response.json())
            .then(lotData => {
                document.getElementById("lot-title").textContent = lotData.title;
                document.getElementById("lot-image").src = lotData.image;
                document.getElementById("lot-condition").textContent = lotData.condition;
                document.getElementById("lot-description").textContent = lotData.description;
                document.getElementById("lot-bids").textContent = lotData.bids;
                document.getElementById("lot-price").textContent = lotData.price;
                document.getElementById("lot-min-increase").textContent = lotData.minIncrease;
                document.getElementById("lot-max-increase").textContent = lotData.maxIncrease;
            })
            .catch(error => {
                console.error('Error fetching lot details:', error);
            });
    }
});
