<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News</title>
</head>
<body>
<table border="1">
    <thead>
    <tr>
        <th>Title</th>
        <th>Description</th>
    </tr>
    </thead>
    <tbody id="news-table">
        @foreach($datas as $data)
            <tr>
                <td>{{ $data['title'] }}</td>
                <td>{{ $data['description'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<!-- JavaScript for WebSocket connection -->
<script>
    const websocketUrl = 'ws:192.168.1.4:8091'; // Adjust WebSocket server URL
    const socket = new WebSocket(websocketUrl);

    // WebSocket onopen event listener
    socket.onopen = function() {
        console.log('WebSocket connection established.');
    };

    // WebSocket onmessage event listener
    socket.onmessage = function(event) {
        const newArticle = JSON.parse(event.data);
        console.log('Received new article:', newArticle);

        // Update news table with the new article
        updateNewsTable(newArticle);
    };

    // Function to update the news table
    function updateNewsTable(article) {
        const tableBody = document.getElementById('news-table');

        // Create a new row
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
                <td>${article.title}</td>
                <td>${article.description}</td>
            `;

        // Append the new row to the table
        tableBody.appendChild(newRow);
    }

    // Form submission handling
    const form = document.getElementById('create-news-form');
    form.addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = new FormData(form);
        const title = formData.get('title');
        const description = formData.get('description');

        // Send new news data to WebSocket server
        const newArticle = {
            title: title,
            description: description
        };
        socket.send(JSON.stringify(newArticle));

        // Clear form fields after submission
        form.reset();
    });
</script>
</body>
</html>
