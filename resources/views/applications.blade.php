@extends("layouts.admin")

@section("applications")
<div class="panel">
    <h2 class="panelTitle">Клиенты</h2>
    <div class="applications">
        <table class="applicationTable">
            <thead>
                <tr>
                    <th>Имя</th>
                    <th>Email</th>
                    <th>Комментарий</th>
                    <th>Ссылка на билборд</th>
                    <th>Дата</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @foreach($applications as $application)
                    <tr>
                        <td>{{$application->name}}</td>
                        <td>{{$application->email}}</td>
                        <td>{{$application->comment}}</td>
                        <td><a href="{{route("billboard",$application->billboard_id)}}">Билборд №{{$application->billboard_id}} (нажмите на ссылку)</a></td>
                        <td>{{$application->created_at}}</td>
                        <td>
                            <a href="">Просмотрено</a>
                            <br>
                            <a href="">Удалить</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>

@endsection
