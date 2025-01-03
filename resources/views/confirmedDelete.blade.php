<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Confirmation</title>
    <script>
        // Redirect after 3 seconds
        setTimeout(() => {
            window.location.href = "/welcome";
            }, 3000);
    </script>
</head>
<body>
    <div style="text-align: center; margin-top: 20%;">
        @if (session('delete_info'))
            @php
                    $info = session('delete_info');
            @endphp
            <h1>
                 {{ $info['name'] }} deleted successfully!
            </h1>
        @else
            <h1>Nothing to confirm!</h1>
        @endif
        <p>You will be redirected shortly...</p>
    </div>
</body>
</html>
