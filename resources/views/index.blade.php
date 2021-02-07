<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Memory Game Card</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
          integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <link rel="stylesheet" href="{{mix('css/app.css')}}">
</head>
<body>
    <header>
        <h1>Memory Game Card</h1>
    </header>

    <div id="app">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <score></score>
                </div>
                <div class="col-md-9">
                    <cards></cards>
                </div>
            </div>
        </div>
        <splash></splash>
    </div>

    <footer>
        Designed and built by 
        <a href="https://map-search-application.herokuapp.com/aumaporn/cv" target="_blank">Aumaporn Tangmanosodsikul</a> | 
        GIT URL 
        <a href="https://github.com/praewfah/memory-game-card.git" target="_blank">https://github.com/praewfah/memory-game-card.git</a> 
    </footer>

    <script async src="{{mix('js/app.js')}}"></script>
</body>
</html>
