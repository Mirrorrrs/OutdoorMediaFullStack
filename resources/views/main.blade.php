@extends("layouts/app")

@section("main")
    <div class="shortInfo">
        <div class="container">
            <div class="content" style="background:url({{asset("media/pictures/shortInfoBackground.png")}}) no-repeat center/cover">
                <div class="shadow">
                    <img src="{{asset("media/pictures/shortInfoBackgroundShadow.png")}}" alt="Размещение наружной рекламы">
                </div>
                <div class="text">
                    <h1>Размещение <br> наружной рекламы</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="detailedInfo">
        <div class="container">
            <div class="content">
                <div class="card">
                    <h4 class="cardTitle">
                        Городов
                    </h4>
                    <p class="cardInfo">
                        14
                    </p>
                </div>
                <div class="card">
                    <h4 class="cardTitle">
                        Билбордов
                    </h4>
                    <p class="cardInfo">
                        134 объекта
                    </p>
                </div>
                <div class="card">
                    <h4 class="cardTitle">
                        Сумма в месяц
                    </h4>
                    <p class="cardInfo">
                        12000 руб
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="billboardsInfo" id="billboardsInfo">
        <div class="container">
            <div class="content">
                <h2 class="blockTitle">Билборды и рекламные щиты 6х3</h2>
                <div class="maps" style="position:relative;overflow:hidden;">
                    <a href="https://yandex.ru/maps/11123/elabuga/?utm_medium=mapframe&utm_source=maps" style="color:#eee;font-size:12px;position:absolute;top:0px;">Елабуга</a>
                    <a href="https://yandex.ru/maps/11123/elabuga/?l=sat%2Cskl&ll=52.075430%2C55.796343&mode=usermaps&source=constructorLink&um=constructor%3Ad314ca0fcb4e3484bea0508166d481d5aa9e015c2b26d35270a489aeb7395b44&utm_medium=mapframe&utm_source=maps&z=12" style="color:#eee;font-size:12px;position:absolute;top:14px;">Карта Елабуги с улицами и номерами домов онлайн — Яндекс.Карты</a>
                    <iframe src="https://yandex.ru/map-widget/v1/-/CCUANBH9XB" width="100%" height="100%" frameborder="1" allowfullscreen="true" style="position:absolute; border: none"></iframe>
                </div>
                <div class="billboardCards">
                    @foreach($billboards as $billboard)
                        <a class="card" href="{{route("billboard",$billboard->id)}}" style="background: url({{asset("media/pictures/".$billboard->img_src)}}) no-repeat center/cover">
                        <div class="shadow">
                            <img src="{{asset("media/pictures/cardShadow.png")}}" alt="Размещение наружной рекламы">
                        </div>
                        <div class="animationShadow"></div>
                        <div class="cardContent">
                            <span class="price">
                                {{$billboard->price}} ₽ месяц
                            </span>
                            <div class="text">
                                <h5 class="title">
                                    Билборд сторона {{$billboard->side}}
                                </h5>
                                <p class="address">
                                    {{$billboard->city}} {{$billboard->address}}
                                </p>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
