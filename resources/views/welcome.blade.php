<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>DAS test</title>
    </head>
    <body>
        <script>
            const data1 = {"name": "Joes Widgets"};

            // Send post requests
            fetch('http://127.0.0.1:8000/api/companies', {
            method: "POST",
            body: JSON.stringify(data1),
            headers: {
                "Content-type": "application/json; charset=UTF-8"
            }
            }).then(res => res.json())
            .then(res => {
                console.log(res)
                data2 = {
                    "firstname": "Jebediah",
                    "lastname": "Crenshaw",
                    "dob": "foo",
                    // todo: email is clashing, load from user input
                    "email": "foo@bar2.com",
                    "company_id": res.id
                };
                fetch('http://127.0.0.1:8000/api/employees', {
                    method: "POST",
                    body: JSON.stringify(data2),
                    headers: {
                        "Content-type": "application/json; charset=UTF-8"
                    }
                })
            });
        </script>
    </body>
</html>
