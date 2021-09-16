<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Exercise</title>

        <script>
            function sendJSON() {
                let name = document.querySelector('#name');
                data1 = {"name": name.value};

                // Send post requests
                fetch('http://127.0.0.1:8000/api/companies', {
                method: "POST",
                body: JSON.stringify(data1),
                headers: {
                    "Content-type": "application/json; charset=UTF-8"
                }
                }).then(res => res.json())
                .then(res => alert(JSON.stringify(res)));
            }
        </script>
    </head>
    <body>
        <h2>Create a new company</h2>
        <p>
            <input type="text" id="name" placeholder="Company name">

            <button onclick="sendJSON()">Send JSON</button>

        </p>
    </body>
</html>
