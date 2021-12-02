@extends("layouts.app")

@section("billboard")
    <div class="billboardHead">
        <div class="container">
            <div class="content">
                <div class="text">
                    <h3>Билборд сторона {{$billboard->side}}</h3>
                    <p>{{$billboard->city}}: {{$billboard->address}}</p>
                </div>
                @guest
                <div class="billboardHeadButton">
                    <button id="bookBillboard">Забронировать</button>
                </div>
                @endguest
            </div>
        </div>
    </div>
    <div class="billboardInfoSection">
        <div class="container">
            <div class="content">
                <div class="info">
                    <div class="bookmarks">
                        <div class="bookmark checked" id="bookmarkInfoButton">
                            <h6>ПАРАМЕТРЫ</h6>
                        </div>
                        <div class="bookmark" id="bookmarkCalendarButton">
                            <h6>КАЛЕНДАРЬ</h6>
                        </div>
                    </div>
                    <div class="bookmarkInfo" @if(\Illuminate\Support\Facades\Auth::check()) style="overflow: hidden;overflow-x: scroll;" @endif>
                        @auth
                            <form action="{{route("updateBillboardInfo", $billboard->id)}}" method="POST">
                                @csrf
                                @method("POST")
                        @endauth
                            <table class="stats">
                                <thead>
                                    <tr>
                                        <th>Размер</th>
                                        <th>Монтаж</th>
                                        <th>Печать</th>
                                        <th>Материал</th>
                                        <th>Свет</th>
                                        <th>Налог</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="tableElement" id="billboardSize"> @if(\Illuminate\Support\Facades\Auth::check())
                                                <input type="text" name="size" value="{{$billboard->size}}"> @else{{$billboard->size}} @endif</td>
                                        <td class="tableElement" id="billboardMounting"> @if(\Illuminate\Support\Facades\Auth::check())
                                                <input type="text" name="mounting" value="{{$billboard->mounting}}"> @else{{$billboard->mounting}} ₽ @endif</td>
                                        <td class="tableElement" id="billboardPrinting"> @if(\Illuminate\Support\Facades\Auth::check())
                                                <input type="text" name="printing" value="{{$billboard->printing}} "> @else{{$billboard->printing}} ₽ @endif</td>
                                        <td class="tableElement" id="billboardMaterial"> @if(\Illuminate\Support\Facades\Auth::check())
                                                <input type="text" name="material" value="{{$billboard->material}}"> @else{{$billboard->material}} @endif</td>
                                        <td class="tableElement" id="billboardSpotlight"> @if(\Illuminate\Support\Facades\Auth::check())
                                                <select type="text" name="spotlight" value="{{$billboard->spotlight }}">
                                                    <option @if($billboard->spotlight == 0 ) selected @endif value="0">Нет</option>
                                                    <option @if($billboard->spotlight == 1 ) selected @endif value="1">Есть</option></select>
                                            @else
                                                {{$billboard->spotlight == 0 ? "Есть":"Нет"}}
                                            @endif</td>
                                        <td class="tableElement" id="billboardTax"> @if(\Illuminate\Support\Facades\Auth::check())
                                                <input type="text" name="tax" value="{{$billboard->tax}}"> @else{{$billboard->tax}} @endif</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="statsMob">
                                <p>Размер: {{$billboard->size}}</p>
                                <p>Монтирование: {{$billboard->mounting}}</p>
                                <p>Печать: {{$billboard->printing}} </p>
                                <p>Материал: {{$billboard->material}}</p>
                                <p>Подсветка: {{$billboard->spotlight == 0 ? "Есть":"Нет"}}</p>
                                <p>Налог: {{$billboard->tax}}</p>
                            </div>
                        <div class="showOnMapButton">
                            <div class="wp">
                                <span class="icon address" style="background: url({{asset("media/icons/Pointer.svg")}}) no-repeat center/contain"></span>
                                <button>Показать объект на карте</button>
                            </div>
                            <span class="price">
                                 @if(\Illuminate\Support\Facades\Auth::check())
                                    <input name="price" type="text" value="{{$billboard->price}}"> @else{{$billboard->price}} @endif
                                ₽/месяц
                            </span>
                        </div>
                            @auth
                                    <button class="updateInfoButton" type="submit">Сохранить</button>
                            </form>
                        @endauth
                    </div>
                    <div class="bookmarkCalendar hidden">

                        @foreach(array_keys($years) as $year)
                            <div class="calendar">
                            <p class="title">Календарь {{$year}}</p>
                            <div class="months">
                                @foreach(array_keys($years[$year]) as $month)
                                    @auth
                                        <form action="{{route("updateStatus")}}" class="statusForm" method="post">
                                            @csrf
                                            @method("POST")
                                            <input type="text" name="year" value="{{$year}}" hidden>
                                            <input type="text" name="month" value="{{$month}}" hidden>
                                            <input type="text" name="billboardId" value="{{$billboard->id}}" hidden>
                                            @endauth
                                    @if($years[$year][$month]!=4)
                                        <div class="month">
                                    <span class="title">{{$month}}</span>
                                    @switch($years[$year][$month])
                                        @case(0)
                                        <div class="status red"></div>
                                        <?php $status=0?>
                                        @break
                                        @case(2)
                                        <div class="status yellow"></div>
                                         <?php $status=2?>
                                        @break
                                        @default
                                        <div class="status green"></div>
                                                <?php $status=1?>
                                        @break
                                    @endswitch
                                            @auth
                                            <select name="status" class="monthSelect">
                                                <option @if($status==0) selected @endif  value="0">Занято</option>
                                                <option @if($status==2) selected @endif  value="2">Резерв</option>
                                                <option @if($status==1) selected @endif value="1">Свободно</option>
                                            </select>
                                            @endauth
                                </div>
                                    @endif
                                    @auth
                                        </form>
                                    @endauth
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                        <div class="statusInfo">
                            <p><span class="text_red">Красный</span> - занято</p>
                            <p><span class="text_green">Зеленый</span> - свободно</p>
                            <p><span class="text_yellow">Желтый</span> - зарезервированно</p>
                        </div>
                    </div>

                </div>
                <div class="picture">
                    <div class="imgWrapper">
                        <img src="{{asset("media/pictures/".$billboard->img_src)}}" alt="">
                        @auth
                        <form id="updateImageForm" action="{{route("updateBillboardImage", $billboard->id)}}" enctype="multipart/form-data" method="post">
                            @csrf
                            @method("POST")

                            <input type="file" name="img">
                            <button type="submit">Сохранить</button>
                        </form>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="billboardModal" id="billboardModal">
        <div class="billboardModalWindow">
                <div class="sectionInfo" style="background: url({{asset("media/pictures/shortInfoBackground.png")}}) no-repeat center/cover">
                    <div class="textWrapper">
                        <div class="wp">
                            <h5 class="title">Получите подробную информацию</h5>
                            <p class="text">Оставьте свои контактные данные, мы свяжемся с Вами и предоставим Вам подробную информацию в течение 1 минуты</p>
                        </div>
                    </div>

                    <div class="redLayout"></div>
                </div>
                <div class="sectionForm">
                    <form action="{{route("leaveApplication")}}" method="post">
                        @csrf
                        @method("POST")
                        <input type="hidden" name="billboard_id" value="{{$billboard->id}}">
                        <div class="inputWrapper">
                            <div class="icon" style="background: url({{asset("media/icons/user.svg")}}) no-repeat center/contain"></div>
                            <input type="text" name="name" placeholder="Как вас зовут?" required>
                        </div>
                        <div class="inputWrapper">
                            <div class="icon" style="background: url({{asset("media/icons/business.svg")}}) no-repeat center/contain"></div>
                            <input type="text" name="email" placeholder="Введите ваш e-mail" required>
                        </div>
                        <div class="inputWrapper textareaWrapper">
                            <div class="icon" style="background: url({{asset("media/icons/system.svg")}}) no-repeat center/contain"></div>
                            <textarea name="comment" placeholder="Комментарий"></textarea>
                        </div>
                        <button class="red" type="submit">Отправить</button>
                        <span class="policy">
                            Продолжая, Вы соглашаетесь <br> c <a>политикой конфиденциальности</a>
                        </span>
                    </form>

                </div>
        </div>
    </div>
    @auth
    <script>
        let select = document.querySelectorAll(".monthSelect");
        Array.from(select,(el)=>{
            el.onchange = (ev)=>{
                el.parentElement.parentElement.submit()
            }
        })

    </script>
    @endauth
@endsection
