document.addEventListener("DOMContentLoaded", function () {
    // Replace 'your-api-endpoint' with the actual endpoint of your API
    const apiEndpoint = 'your-api-endpoint';

    // Fetch data from the API
    fetch(apiEndpoint)
        .then(response => response.json())
        .then(data => {
            const streamContainer = document.getElementById('stream-container');

            // Iterate through the data and create a card for each live stream
            data.forEach(stream => {
                const streamCard = document.createElement('div');
                streamCard.classList.add('stream-card');

                const thumbnail = document.createElement('img');
                thumbnail.src = stream.thumbnailUrl;
                streamCard.appendChild(thumbnail);

                const title = document.createElement('div');
                title.classList.add('stream-title');
                title.textContent = stream.title;
                streamCard.appendChild(title);

                const description = document.createElement('div');
                description.classList.add('stream-description');
                description.textContent = stream.description;
                streamCard.appendChild(description);

                streamContainer.appendChild(streamCard);
            });
        })
        .catch(error => console.error('Error fetching data:', error));
});
