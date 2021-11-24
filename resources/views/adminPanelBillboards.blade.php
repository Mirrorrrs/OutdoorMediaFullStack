@extends("layouts.admin")

@section("billboards")
    <div class="panel">
        <h2 class="panelTitle">Биллборды</h2>
        <form action="{{route("storeDataFromExcel")}}" class="loadExcelForm" method="POST" enctype="multipart/form-data">
            @method("POST")
            @csrf
            <input type="file" name="table" required id="loadExcel">
            <label for="loadExcel">Выбрать файл</label>
            <button type="submit">Загрузить</button>
            <span id="fileName" class="hidden">Выбран файл: </span>
        </form>
        <div class="billboardCards" style="padding-bottom: 20px;">
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

@endsection
