<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pixel Positions</title>
</head>
<body><!--check app.css-->

    <div method="POST" action="/register" enctype="multipart/form-data">
        <input type="text" placeholder="NoName" name="name" ></input>
        <input type="text" placeholder="NoEmail" name="email" type="email"></input>
        <input type="text" placeholder="NoNumber" name="number" type="number"></input>
        <input type="text" placeholder="NoPassword" name="password" type="password"></input>
        <button method="POST" action="/register" enctype="multipart/form-data">PRESS ME</button>
    </div>

</body>
</html>
