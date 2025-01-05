<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        /* Your existing CSS styles */
        <link rel="stylesheet" href="{{ asset('css/custom.css') }}">* {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            min-height: 100vh;
            width: 100%;
            background: #42FCA9;
        }

        .container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            max-width: 75%;
            width: 100%;
            height: 100%;
            background: #fff;
            border-radius: 7px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.3);
        }

        .form {
            padding: 2rem;
        }

        .form header {
            font-size: 2rem;
            font-weight: 500;
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .form input {
            height: 60px;
            width: 92.5%;
            padding: 0 15px;
            font-size: 17px;
            margin-bottom: 1.3rem;
            border: 1px solid #ddd;
            border-radius: 6px;
            outline: none;
        }

        .form input.button {

            color: #fff;
            background: #30C198;
            font-size: 1.2rem;
            font-weight: 500;
            letter-spacing: 1px;
            margin-top: 1.7rem;
            cursor: pointer;
            transition: 0.2s;
        }

        .form input.button:hover {
            background: #006653;
        }

        .error {
            color: red;
            /* Style for error messages */
            font-size: 14px;
            /* Adjust font size */
            margin-top: -10px;
            /* Adjust spacing */
            margin-bottom: 10px;
            /* Space below error message */
        }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NovaCart</title>
</head>

<body>
    <div class="container">
        <form method="POST" action="/adddriver" enctype="multipart/form-data">
            @csrf
            <div class="form">
                <header style="margin-top: -5%;font-family: 'Forte'; color: #42FCA9; font-size:40px;margin-top:5%;">ADD
                    driver</header>

                <!-- Number Input -->
                <input type="text" name="name" placeholder="Enter the name of the driver"
                    value="{{ old('name') }}" required>
                @error('name')
                    <div class="error">{{ $message }}</div>
                @enderror


                <!-- location Input -->
                <input type="text" name="location" placeholder="Enter the location of the driver" required>
                @error('location')
                    <div class="error">{{ $message }}</div>
                @enderror
                <a href="/drivers">
                    <input type="submit" class="button" value="Submit driver" style="margin-left:4%;">
                    @error('Submit driver')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </a>
            </div>
        </form>
    </div>
</body>

</html>
