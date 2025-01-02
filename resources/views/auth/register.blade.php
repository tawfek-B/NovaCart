<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        /* Your existing CSS styles */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            min-height: 100vh;
            width: 100%;
            background: #009579;
        }

        .container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            max-width: 430px;
            width: 100%;
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
            width: 100%;
            padding: 0 15px;
            font-size: 17px;
            margin-bottom: 1.3rem;
            border: 1px solid #ddd;
            border-radius: 6px;
            outline: none;
        }

        .form input.button {
            color: #fff;
            background: #009579;
            font-size: 1.2rem;
            font-weight: 500;
            letter-spacing: 1px;
            margin-top: 1.7rem;
            cursor: pointer;
            transition: 0.4s;
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
        <form method="POST" action="/reg">
            @csrf
            <div class="form">
                <header>Login</header>

                <!-- Number Input (Mandatory) -->
                <input type="text" name="number" placeholder="Enter your phone number" value="{{ old('number') }}"
                    required>
                @error('number')
                    <div class="error">{{ $message }}</div>
                @enderror

                <!-- Email Input (Optional) -->
                <input type="text" name="email" placeholder="Enter your email (optional)"
                    value="{{ old('email') }}">
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror

                <!-- Password Input -->
                <input type="password" name="password" placeholder="Enter your password" required>
                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror

                <a href="/toobad">Forgot password?</a>
                <input type="submit" class="button" value="Login">

                @error('login')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
        </form>
    </div>
</body>

</html>
