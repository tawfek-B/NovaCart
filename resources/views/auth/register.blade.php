<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova Cart</title>
</head>

<body><!--check app.css-->

    <form method="POST" action="/register" enctype="multipart/form-data">
        @csrf
        <input type="number" id="number" name="number" placeholder="NUMBER">

        <input type=password id="password" name="password" placeholder="PASSWORD">


        {{-- <div>
        <div class="inline-flex items-center gap-x-2">
<span class="w-2 h-2 bg-white inline-block"></span>
<label class="font-bold" for="logo">Employer Logo</label>
</div>

<div class="mt-1">
    <input type="file" id="logo" name="logo" class="rounded-xl bg-white/10 border border-white/10 px-5 py-4 w-full">

        </div>
</div> --}}


        <button class="bg-blue-800 rounded py-2 px-6 font-bold">Log in</button>
    </form>

</body>

</html>
