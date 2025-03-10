<!DOCTYPE html>
<html lang="en">

<head>
    <title>Add Driver</title>
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
            top: 75%;
            left: 50%;
            transform: translate(-50%, -50%);
            max-width: 75%;
            width: 100%;
            height: 160%;
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
                    DRIVER</header>

                <img id="imagePreview" src="{{ asset('/Drivers/default.png') }}?v={{ file_exists(public_path('storage/Drivers/default.png')) ? filemtime(public_path('storage/Drivers/default.png')) : now()->timestamp }}" alt="Driver Image"
                    alt="{{ asset('/Drivers/default.png') }}"
                    style="width:200px; height:200px; margin-left: 40%; margin-bottom: 5%;">

                <!-- userName Input -->
                <input type="text" name="firstName" placeholder="Enter the first name of the driver"
                    value="{{ old('firstName') }}" required>
                @error('name')
                    <div class="error">{{ $message }}</div>
                @enderror


                <!-- lastName Input -->
                <input type="text" name="lastName" placeholder="Enter the last name of the driver"
                    value="{{ old('lastName') }}" required>
                @error('lastName')
                    <div class="error">{{ $message }}</div>
                @enderror

                <!-- userName Input -->
                <input type="text" name="userName" placeholder="Enter the user name of the driver" required>
                @error('userName')
                    <div class="error">{{ $message }}</div>
                @enderror

                <!-- number Input -->
                <input type="number" name="number" placeholder="Enter the number of the driver" required>
                @error('number')
                    <div class="error">{{ $message }}</div>
                @enderror

                <!-- email Input -->
                <input type="email" name="email" placeholder="Enter the email of the driver" required>
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror

                <!-- password Input -->
                <input type="password" name="password" placeholder="Enter the password of the driver" required>
                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror

                <!-- logo Input -->
                <input type="file" name="image" placeholder="Enter the image of the driver" accept="image/*"
                    value="{{ old('image') }}" id="imageInput">
                @error('image')
                    <div class="error">{{ $message }}</div>
                @enderror

                <!-- location Input -->
                <input type="text" name="location" placeholder="Enter the location of the driver"
                    value = "{{ old('location') }}">
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
    <script>
        document.getElementById('imageInput').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('imagePreview').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>

</html>
