<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        /* Your existing CSS styles */
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

        * {
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
            height:150%;
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
            width: 72.5%;
            padding: 0 15px;
            font-size: 17px;
            margin-left:13%;
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
    {{-- <p>store_id: {{ session('store_id') }}</p> --}}
    <div class="container">
        <form method="POST" action="/updatestore/{{session('store_id')}}" enctype="multipart/form-data">
            @csrf
            <div class="form">
                <header style="margin-top: -5%;font-family: 'Forte'; color: #42FCA9; font-size:40px;margin-top:15%;">UPDATE STORE</header>

            <!-- Image Preview -->
            <img id="imagePreview" src="{{ asset(App\Models\Store::where('id', session('store_id'))->first()->image) }}" alt="Selected Image" style="width:200px; height:200px; margin-left: 40%; margin-top: ;">


            <div style="margin-top:5%;">
                <!-- Name Input -->
                {{-- {{ 'store_id' }} --}}
                <input type="text" name="name" placeholder="Enter the name of the store" value="{{ App\Models\Store::where('id', session('store_id'))->first()->name }}" required>
                <h style="font-size:20px">
                    Name
                </h>
                @error('name')
                    <div class="error">{{ $message }}</div>
                @enderror

                <input type="file" name="image" id="image" placeholder="Enter the image of the product" accept="image/*">


                <!-- Location Input -->
                <input type="text" name="location" placeholder="Enter the location of the store" value="{{ App\Models\Store::where('id', session('store_id'))->first()->location}}">
                @error('location')
                    <div class="error">{{ $message }}</div>
                @enderror

                <!-- Description Input -->
                <input type="text" name="description" placeholder="Enter the description of the store"  value="{{ App\Models\Store::where('id', session('store_id'))->first()->description}}"required>
                @error('description')
                    <div class="error">{{ $message }}</div>
                @enderror

                <input type="time" name="openingTime"  value="{{ App\Models\Store::where('id', session('store_id'))->first()->openingTime}}">
                <h style="font-size:20px">
                    Opening Time
                </h>
            </input>
                @error('openingTime')
                    <div class="error">{{ $message }}</div>
                @enderror

                <!-- quantity Input -->
                <input type="time" name="closingTime" placeholder="The opening time of the store" value="{{ App\Models\Store::where('id', session('store_id'))->first()->closingTime}}">
                <h style="font-size:20px">
                    Closing Time
                </h>
            </input>
                @error('closingTime')
                    <div class="error">{{ $message }}</div>
                @enderror

                <input type="submit" class="button" value="Submit Store" style="margin-left:14%;">

                @error('Submit Store')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            </div>
        </form>
    </div>
    <script>
        const imageInput = document.getElementById('image');
        const imagePreview = document.getElementById('imagePreview');

        imageInput.addEventListener('change', function(event) {
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result; // Update preview with selected image
                };
                reader.readAsDataURL(file);
            } else {
                // Reset to the original image if no file is selected
                imagePreview.src = "{{ asset(App\Models\Store::where('id', session('store_id'))->first()->image) }}";
            }
        });
    </script>
</body>

</html>