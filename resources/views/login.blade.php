@extends("layouts.app")

@section("login")
    <div class="loginWrapper" style="background:url({{asset("media/pictures/shortInfoBackground.png")}}) no-repeat center/cover">
        <div class="redLayout"></div>
        <form method="POST" class="loginForm" action="{{route("loginPOST")}}">
            @method("POST")
            @csrf
            <h4>Войти</h4>
            <input type="text"  name="login" placeholder="Логин" autocomplete="off">
            <br>
            <input type="password" required name="password" placeholder="Пароль" autocomplete="off">
            <br>
            <button type="submit">Войти</button>
            <br>
            <br>
            @error("loginError")
                <span class="text_red">{{$message}}</span>
            @enderror
        </form>
    </div>


    <style>
        header{
            display: none;
        }

        footer {
            display: none   ;
        }

        main {
            margin-top: 0;
        }
    </style>

@endsection
