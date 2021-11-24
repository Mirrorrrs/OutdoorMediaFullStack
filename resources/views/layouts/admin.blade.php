<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset("css/admin.css")}}">
    <script defer src="{{asset("js/main.js")}}"></script>
    <title>Outdoor Media Admin</title>
</head>
<body>
<div class="adminPanel">
    <div class="adminNavigation">
        <h3 class="title">Outdoor admin</h3>
        <nav>
            <ul>
                <li class="checked"><a href="">Биллборды</a></li>
                <li><a href="">Клиенты</a></li>
                <li><a href="{{route("logout")}}">Выход</a></li>
            </ul>
        </nav>
    </div>
    <div class="adminContent">
        @yield("billboards")
        @yield("clients")
    </div>
</div>

</body>
</html>
