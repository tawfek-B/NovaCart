<!DOCTYPE html>
<html lang="en">

<head>
    <title>Drivers</title>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .grid-container {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            /* 4 columns */
            gap: 20px;
            /* Space between the grid items */
            max-width: 1200px;
            /* Restrict width */
            margin: 0 auto;
            /* Center the grid */
            padding: 20px;
        }

        .grid-item {
            position: relative;
            /* Make the grid-item a positioned element */
            background-color: white;
            border: 3px solid #ccc;
            border-radius: 5px;
            border-color: #42FCA9;
            text-align: center;
            padding: 20px;
            font-size: 16px;
            font-weight: bold;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }


        .grid-item:hover {
            background-color: #143640;
            /* Green background */
            border: 2px solid #30C198;
            /* Green border initially */
            name-color: #FFFFFF;
            color: #FFFFFF;
           rgb(131, 65, 65)tion: all 0.3s ease;
            box-shadow: 0 8px 16px #42FCA9;
            transform: translateY(-3px);
        }

        .grid-item:hover .highlight-on-hover {
            color: #42FCA9;
            /* Change color for this specific <a> */
            /* text-decoration:none; */
            /* Optional: Remove underline */
        }

        .edit-icon,
        .delete-icon {
            position: absolute;
            /* Position relative to the grid-item */
            font-size: 16px;
            /* Size for the icon */
            color: #555;
            /* Default color */
            cursor: pointer;
            /* Pointer cursor on hover */
            text-decoration: none;
            /* Remove underline */
            padding: 5px;
            border-radius: 50%;
            /* Circular icon background on hover */
            background-color: transparent;
        }

        .edit-icon {
            top: 10px;
            /* Space from the top of the grid-item */
            left: 10px;
            /* Space from the left of the grid-item */
        }

        .delete-icon {
            top: 10px;
            /* Space from the top of the grid-item */
            right: 10px;
            /* Space from the right of the grid-item */
        }

        .edit-icon:hover {
            background-color: #42FCA9;
            /* Hover background */
            color: white;
            /* White icon */
        }

        .delete-icon:hover {
            background-color: #FF0000;
            /* Red hover background */
            color: white;
            /* White icon */
        }

        /* Plus sign container (add-driver
        ) */
        .add-driver {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100px;
            height: 100px;
            background-color: white;
            /* White background */
            color: #42FCA9;
            /* Green plus sign */
            border: 2px solid #42FCA9;
            /* Green border */
            margin: 35%;
            border-radius: 10px;
            cursor: pointer;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-decoration-line: none;
            transition: all 0.3s ease;
            /* Smooth transition for color and border */
        }

        .add-driver:hover {
            background-color: #42FCA9;
            /* Green background */
            color: white;
            /* White plus sign */
            border: 2px solid #42FCA9;
            /* Green border initially */
            box-shadow: 0 8px 16px #42FCA9;
            transform: translateY(-3px);
        }

        /* Plus sign itself */
        .plus-sign {
            font-size: 48px;
            font-weight: bold;
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
            cursor:pointer;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.8);
            transition: 0.5s ease, box-shadow 0.5s ease, font-size 0.5s ease, border 0.5s ease;
        }

        .logout:hover {
            color: #42FCA9;
            border-left: 4.5px solid;
            border-bottom: 4.5px solid;
            background-color:#143640;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            font-size:23px;
            /* Optional: Change color on hover */
        }
    </style>
</head>

<body style="background-color: #FFFFFF">
    <form method="POST" action="/logout" style="display:flex; flex-direction:row-reverse; width:100%; height:50%" onsubmit="return confirmLogout()">
        @csrf
        <button type="submit" class="logout" style="font-family: 'Forte'">
            LOG OUT
        </button>
    </form>
    <a href="/welcome">
        <img src="{{ asset('images/NovaCart.png') }}" alt="" style="width:250px; height:250px; margin-left:41.5%">
    </a>
    <div style="font-family: 'Forte';font-size: 50px; margin-left: 37.5%; margin-bottom: 2.5%; color:#42FCA9;">
        {{-- i want t change this so it uses "forte regular" font --}}
        DRIVERS PAGE
    </div>
    <div class="grid-container">
        @foreach (App\Models\driver::all() as $driver)
            @php
                $user = App\Models\User::where('id', $driver->user_id)->first();
            @endphp
            <div class="grid-item">
                <a href="updatedriver/{{ $driver->id }}" class="edit-icon" title="Edit">
                    <i class="fas fa-edit"></i>
                </a>
                <form action="/deletedriver/{{ $driver->id }}" method="POST" class="delete-form"
                    onsubmit="return confirmDelete('{{ $driver->name }}', '{{ $driver->quantity }}');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="delete-icon" title="Delete" style="border:none">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
                <a href="#" class="highlight-on-hover">
                    <span aria-hidden="true" class="absolute inset-0"></span>
                    {{ $driver->name }}
                </a>
                <p>
                    <img src="{{ asset($driver->image) }}?v={{ \Illuminate\Support\Facades\Storage::lastModified($driver->image) }}" alt="driver
                         Image"
                        style="width: 150px; height: 150px;">
                </p>
                <p><strong>Name:</strong> {{ $driver->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Number:</strong> {{ $user->number }}</p>
                <p><strong>Location:</strong> {{ $driver->location }}</p>
                <p style=" position: absolute; bottom: 10px; left: 50%; transform: translateX(-50%); margin: 0; font-size: 18px;color:#30C198"><strong></strong>
                    @if ($driver->isDelivering)
                        Delivering
                    @else
                        Not Delivering
                    @endif
                </p>
            </div>
        @endforeach
        <a class="add-driver" href="/adddriver">
            <span class="plus-sign">+</span>
        </a>
    </div>

</body>

<script>
    function confirmDelete(driverName) {
        return confirm(`Are you sure you want to delete the driver "${driverName}"?`);
    }
    function confirmLogout() {
        return confirm("Are you sure you want to log out?")
    }
</script>

</html>
