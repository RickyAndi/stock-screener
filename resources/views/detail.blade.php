<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <title>Document</title>
</head>
<body>
    <div id="app" class="mt-5 mx-5"></div>
    <script>
        window.jancok = JSON.parse('@json($transformed)');
        console.log(window.jancok[0].x);
    </script>
    <script src="{{ asset('js/detail.js') }}"></script>
</body>
</html>