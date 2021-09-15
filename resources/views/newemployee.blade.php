<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>DAS test</title>

        <script>
            function getCompanies() {
                let dropdown = document.getElementById('company-dropdown');
                dropdown.length = 0;
                dropdown.selectedIndex = 0;

                fetch('http://127.0.0.1:8000/api/companies', {
                    method: "GET"
                }).then(function(response) {
                    response.json().then(function(data) {
                        let option;

                        for (let i = 0; i < data.length; i++) {
                        option = document.createElement('option');
                        option.text = data[i].name;
                        option.value = data[i].id;
                        dropdown.add(option);
                        }
                    });
                });
            }

            function sendJSON() {
                let dropdown = document.getElementById('company-dropdown');

                let fname = document.querySelector('#firstname');
                let lname = document.querySelector('#lastname');
                let dob = document.querySelector('#dob');
                let email = document.querySelector('#email');
                data = {
                    "firstname": fname.value,
                    "lastname": lname.value,
                    "dob": dob.value,
                    "email": email.value,
                    "company_id": dropdown.value
                };

                // Send post request
                fetch('http://127.0.0.1:8000/api/employees', {
                    method: "POST",
                    body: JSON.stringify(data),
                    headers: {
                        "Content-type": "application/json; charset=UTF-8"
                    }
                }).then(res => res.json())
                .then(res => alert(JSON.stringify(res)))
                .catch((error) => {
                    console.error('Error:', error);
                    alert(error.message);
                });
            }

            document.addEventListener("DOMContentLoaded", function(event) {
                getCompanies();
            });

        </script>
    </head>
    <body>
        <h2>Create a new employee</h2>
        <p>
            <select id="company-dropdown" name="company"></select><br>

            <input type="text" id="firstname" placeholder="Employee first name"><br>
            <input type="text" id="lastname" placeholder="Employee last name"><br>
            <input type="text" id="dob" placeholder="Employee date of birth"><br>
            <input type="text" id="email" placeholder="Employee email"><br>

            <!-- Button to send data -->
            <button onclick="sendJSON()">Send JSON</button>

        </p>
    </body>
</html>
