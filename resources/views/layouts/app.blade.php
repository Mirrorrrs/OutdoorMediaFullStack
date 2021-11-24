<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset("css/style.css")}}">
    <script defer src="{{asset("js/main.js")}}"></script>
    <title>Outdoor Media</title>
</head>
<body>
<header>
    <div class="container">
        <div class="content">
            <div class="logo" style="background: url({{asset("media/icons/logo.png")}}) no-repeat center/contain"></div>
            <nav>
                <ul>
                    <li><a href="{{route("home")}}">Главная</a></li>
                    <li><a href="{{route("home")}}#billboardsInfo">Билборды</a></li>
                    @auth
                        <li><a href="{{route("adminPanelBillboards")}}">Администрирование</a></li>
                    @endauth
                    <li><a href="{{route("home")}}#footer">О нас</a></li>
                </ul>
            </nav>
        </div>
    </div>
</header>
<main>
    @yield("main")
    @yield("billboard")
    @yield("login")
</main >
<footer id="footer">
    <div class="container">
        <div class="content">
            <div class="leftsideWrapper">
                <div class="logo" style="background: url({{asset("media/icons/logo.png")}}) no-repeat center/contain"></div>
                <p class="companyReg">ОАО «Cетевая компания»</p>
            </div>


            <div class="rightsideWrapper">
                <div class="contacts">
                    <div class="contact">
                        <span class="icon phone" style="background: url({{asset("media/icons/Phone.svg")}}) no-repeat center/contain"></span>
                        <p class="address">+7(800)444-60-86</p>
                    </div>
                    <div class="contact">
                        <span class="icon pointer" style="background: url({{asset("media/icons/Pointer.svg")}}) no-repeat center/contain"></span>
                        <p class="address">г. Елабуга, пр. нефтяников, дом70а</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</footer>
</body>
</html>
