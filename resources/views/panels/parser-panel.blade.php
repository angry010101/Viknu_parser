@php

    $levelAmount = 'level';

    if (Auth::User()->level() >= 2) {
        $levelAmount = 'levels';

    }

@endphp

<script>
    function parse() {

        $('#progress-parsing-bar').width('50%');

        var selected = [];
        $('#sites input:checked').each(function() {
            selected.push($(this).attr('name'));
        });


        $.ajax({
            url:'/parse',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            },
            data: JSON.stringify(selected),
        }).done(function (data) {
            if(data == 'success') {
                $('#progress-parsing-bar').width('100%');
                $('#view-data').removeAttr("hidden");
                $('#view-data').removeAttr("disabled");
            }else {
                alert('Произошла ошибка, перезагрузите страницу!')
            }
        });

    }

    function sentiment() {

        $.ajax({
            url:'/sentiment',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            },
        }).done(function (data) {
            if(data) {
                alert(data);
            }else {
                alert('Произошла ошибка, перезагрузите страницу!')
            }
        });

    }

    function save() {
                $('#view-data').attr("disabled", true);
                $('#parsing-data').attr("disabled", false);
    }
</script>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Добавление нового источника для сбора данных</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="padding:1rem 2rem;">
                <form action="/savesite" method="POST">
                    @csrf

                    <div class="form-group has-feedback row {{ $errors->has('sitename') ? ' has-error ' : '' }}">
                        <label for="sitename">Site name</label>
                        <input id="sitename" name="sitename" class="form-control pg-5" placeholder="Enter site Name">
                        <small id="emailHelp" class="form-text text-muted">Укажите название которое будет отображаться в списке.</small>
                        @if ($errors->has('sitename'))
                            <span class="help-block">
                                            <strong>{{ $errors->first('sitename') }}</strong>
                                        </span>
                        @endif
                    </div>
                    <div class="form-group has-feedback row {{ $errors->has('siteurl') ? ' has-error ' : '' }}">
                        <label for="siteurl">Site URL</label>
                        <input id="siteurl" name="siteurl" class="form-control pg-5" placeholder="Enter site URL">
                        <small id="emailHelp" class="form-text text-muted">Укажите полный адрес ресурса (https://telegram.org/)</small>
                        @if ($errors->has('siteurl'))
                            <span class="help-block">
                                            <strong>{{ $errors->first('siteurl') }}</strong>
                                        </span>
                        @endif
                    </div>
                    <div class="form-group has-feedback row {{ $errors->has('sitelang') ? ' has-error ' : '' }}">
                        <label for="sitelang">Site lang</label>
                        <input id="sitelang" name="sitelang" class="form-control pg-5" placeholder="Enter site language">
                        <small id="emailHelp" class="form-text text-muted">Укажите язык (RU/UA/EU)</small>
                        @if ($errors->has('sitelang'))
                            <span class="help-block">
                                            <strong>{{ $errors->first('sitelang') }}</strong>
                                        </span>
                        @endif
                    </div>
                    <div class="form-group has-feedback row {{ $errors->has('linkelement') ? ' has-error ' : '' }}">
                        <label for="link">Link Element</label>
                        <input id="link" name="link" class="form-control pg-5" placeholder="Enter Link element">
                        <small id="emailHelp" class="form-text text-muted">Укажите элемент, содержащий ссылку на новость (div > a .news_title)</small>
                        @if ($errors->has('linkelement'))
                            <span class="help-block">
                                            <strong>{{ $errors->first('linkelement') }}</strong>
                                        </span>
                        @endif
                    </div>
                    <div class="form-group has-feedback row {{ $errors->has('titleelement') ? ' has-error ' : '' }}">
                        <label for="title">Title element</label>
                        <input id="title" name="title" class="form-control pg-5" placeholder="Enter Title Element">
                        <small id="emailHelp" class="form-text text-muted">Укажите элемент, содержащий заголовок новости (h1 .title)</small>
                        @if ($errors->has('titleelement'))
                            <span class="help-block">
                                            <strong>{{ $errors->first('titleelement') }}</strong>
                                        </span>
                        @endif
                    </div>
                    <div class="form-group has-feedback row {{ $errors->has('textelement') ? ' has-error ' : '' }}">
                        <label for="text">Text element</label>
                        <input id="text" name="text" class="form-control pg-5" placeholder="Enter Text element">                        <small id="emailHelp" class="form-text text-muted">Укажите элемент, содержащий текст новости (div > p .fulltext)</small>
                        @if ($errors->has('textelement'))
                            <span class="help-block">
                                            <strong>{{ $errors->first('textelement') }}</strong>
                                        </span>
                        @endif
                    </div>

                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Данные введены правильно</label>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                        <button type="submit" class="btn btn-primary">Submitt</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">VIKNU</a></li>
            <li class="breadcrumb-item active" aria-current="page">Сбор новостей</li>
        </ol>
    </nav>
    <div class="card-body">
        <div class="container">
            <div class="card-body">

                {!! $chart1->container() !!}
            </div>
        </div>
        <h2 class="lead">
            Select site:
        </h2>
        <div id="sites">
            @foreach ($sites as $site)
            <div class="custom-control custom-checkbox">
                <input type="checkbox" name="{{$site->id}}" class="custom-control-input" id="defaultUnchecked{{$site->id}}" checked>
                <label class="custom-control-label" for="defaultUnchecked{{$site->id}}">{{$site->name}} <code>{{$site->lang}}</code></label>
            </div>
            @endforeach
        </div>
        <p>
            <small>
                Data has already been parsed.
            </small>
        </p>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" onclick="save()">
                Добавить новый источник
            </button>
        <hr>

        <p>
            You have
                <strong>
                    @role('admin')
                       Admin
                    @endrole
                    @role('user')
                       User
                    @endrole
                </strong>
            Access
        </p>

        <hr>

        <p>
            Parsing Data (<code>last parsing 13.03.2019 09:23</code>):
        <div class="progress">
            <div id="progress-parsing-bar" class="progress-bar progress-bar-striped" role="progressbar" style="width: 0%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        </p>


            <hr>

            <p>
                <button type="button" class="btn btn-outline-primary" onclick="save()">Сохранить изменения</button>
                <button id="parsing-data" type="button" class="btn btn-success" onclick="parse()">Сбор данных</button>
                <button id="parsing-data" type="button" class="btn btn-info" onclick="sentiment()">Анализ данных (test)</button>
                <button onclick="window.location='{{ route("posts") }}'" id="view-data" type="button" class="btn btn-info" hidden>Просмотр данных</button>
            </p>

            {!! $chart1->script() !!}

    </div>
</div>