document.getElementById('addItemForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const form = document.getElementById('addItemForm');
    const formData = new FormData(form);

    // Upload image first
    fetch('upload.php', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            // Image uploaded successfully, use the returned URL
            formData.append('itemImageURL', data.url);

            // Now submit the form with the image URL
            fetch('submit_item.php', {
                method: 'POST',
                body: formData,
            })
            .then(response => response.text())
            .then(result => {
                alert(result);
                // Optionally, redirect to another page or reset the form
                form.reset();
            })
            .catch(error => console.error('Error:', error));
        } else {
            alert('Image upload failed.');
        }
    })
    .catch(error => console.error('Error:', error));
});
