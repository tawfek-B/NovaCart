<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Styled Buttons</title>
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
            background-color: #143640; /* Dark blue */
            color: white;
        }

        /* Products button */
        .products {
            background-color: #30C198; /* Turquoise */
            color: white;
        }

        /* Light green hover effect */
        .btn:hover {
            background-color: #42FCA9; /* Light green */
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="stores">
            <button class="btn stores">Stores</button>
        </a>

        <a href="products">
            <button class="btn products">Products</button>
        </a>
    </div>
</body>
</html>
