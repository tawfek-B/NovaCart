<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova Cart</title>
    <style>
        /* General body styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        /* Container for buttons */
        .container {
            display: flex;
            gap: 20px;
        }

        /* General button styling */
        .btn {
            padding: 15px 30px;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        /* Hover effect */
        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        /* Stores button */
        .stores {
            background-color: #143640;
            /* Dark blue */
            color: white;
        }

        /* Products button */
        .products {
            background-color: #30C198;
            /* Turquoise */
            color: white;
        }

        .logout {
            position: absolute;
            top: 0;
            right: 0;
            padding: 20px 30px;
            text-decoration: none;
            color: #000000;
            font-size: 20px;
            border: 3px solid;
            border-bottom-left-radius: 40px;
            border-color: hsl(153, 97%, 62%);
            cursor: pointer;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.8);
            transition: 0.5s ease, box-shadow 0.5s ease, font-size 0.5s ease, border 0.5s ease;
        }

        .logout:hover {
            color: #42FCA9;
            border-left: 4.5px solid;
            border-bottom: 4.5px solid;
            background-color: #143640;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            font-size: 23px;
            /* Optional: Change color on hover */
        }


        /* Light green hover effect */
        .btn:hover {
            background-color: #42FCA9;
            /* Light green */
        }
    </style>
</head>

<body>
    <div
        style="display: flex; flex-direction: column; align-items: center; text-align: center; gap: 20px; margin-top: 20px;">
        <form method="POST" action="/logout" style="display:flex; flex-direction:row-reverse; width:100%; height:50%" onsubmit="return confirmLogout()">
            @csrf
            <button type="submit" class="logout" style="font-family: 'Forte'">
                LOG OUT
            </button>
        </form>
        <div>
            <img src="{{ asset('images/NovaCart.png') }}" alt=""
                style="width:350px; height:350px;margin-left:-10%; margin-bottom:10%;">
        </div>
        <div style="font-family: 'Forte'; font-size: 50px; color: #42FCA9;margin-top:-10%;">
            WHICH ONE WOULD YOU LIKE TO EDIT?
        </div>
        <div class="container">
            <a href="stores">
                <button class="btn stores">Stores</button>
            </a>

            <a href="products">
                <button class="btn products">Products</button>
            </a>

            <a href="drivers">
                <button class="btn drivers">Drivers</button>
            </a>
        </div>
    </div>

    <script>
        function confirmLogout() {
            return confirm(
                `Are you sure you want to log out?`
            );
        }
    </script>

</body>

</html>
