@php

    $levelAmount = 'level';

    if (Auth::User()->level() >= 2) {
        $levelAmount = 'levels';

    }

@endphp

<script>
    function move() {
        $('#parsing-data').attr("disabled", true);
        var elem = document.getElementById("progress-parsing-bar");
        var width = 10;
        var id = setInterval(frame, 10);
        function frame() {
            if (width >= 100) {
                $('#view-data').removeAttr("hidden");
                $('#view-data').removeAttr("disabled");
                clearInterval(id);
                width = 10;
            } else {
                width++;
                $('#progress-parsing-bar').width(width * 1 + '%').attr('aria-valuenow', width);
            }
        }
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
            <div class="modal-body">
                <form>
                {!! Form::open(array('route' => 'parser.store', 'method' => 'POST', 'role' => 'form')) !!}
                    {!! csrf_field() !!}

                    <div class="form-group has-feedback row {{ $errors->has('sitename') ? ' has-error ' : '' }}">
                        <label for="exampleInputEmail1">Site name</label>
                        {!! Form::text('sitename', NULL, array('id' => 'sitename', 'class' => 'form-control pg-5', 'placeholder' => "Enter site Name")) !!}
                        <small id="emailHelp" class="form-text text-muted">Укажите название которое будет отображаться в списке.</small>
                        @if ($errors->has('sitename'))
                            <span class="help-block">
                                            <strong>{{ $errors->first('sitename') }}</strong>
                                        </span>
                        @endif
                    </div>
                    <div class="form-group has-feedback row {{ $errors->has('siteurl') ? ' has-error ' : '' }}">
                        <label for="exampleInputEmail1">Site URL</label>
                        {!! Form::text('siteurl', NULL, array('id' => 'siteurl', 'class' => 'form-control', 'placeholder' => "Enter site URL")) !!}
                        <small id="emailHelp" class="form-text text-muted">Укажите полный адрес ресурса (https://telegram.org/)</small>
                        @if ($errors->has('siteurl'))
                            <span class="help-block">
                                            <strong>{{ $errors->first('siteurl') }}</strong>
                                        </span>
                        @endif
                    </div>
                    <div class="form-group has-feedback row {{ $errors->has('sitelang') ? ' has-error ' : '' }}">
                        <label for="exampleInputEmail1">Site lang</label>
                        {!! Form::text('sitelang', NULL, array('id' => 'sitelang', 'class' => 'form-control', 'placeholder' => "Enter sitelang")) !!}
                        <small id="emailHelp" class="form-text text-muted">Укажите язык (RU/UA/EU)</small>
                        @if ($errors->has('sitelang'))
                            <span class="help-block">
                                            <strong>{{ $errors->first('sitelang') }}</strong>
                                        </span>
                        @endif
                    </div>
                    <div class="form-group has-feedback row {{ $errors->has('titleelement') ? ' has-error ' : '' }}">
                        <label for="exampleInputEmail1">Title Element</label>
                        {!! Form::text('titleelement', NULL, array('id' => 'titleelement', 'class' => 'form-control', 'placeholder' => "Enter title element")) !!}
                        <small id="emailHelp" class="form-text text-muted">Укажите элемент, содержащий Title</small>
                        @if ($errors->has('titleelement'))
                            <span class="help-block">
                                            <strong>{{ $errors->first('titleelement') }}</strong>
                                        </span>
                        @endif
                    </div>
                    <div class="form-group has-feedback row {{ $errors->has('dataelement') ? ' has-error ' : '' }}">
                        <label for="exampleInputEmail1">Data element</label>
                        {!! Form::text('dataelement', NULL, array('id' => 'dataelement', 'class' => 'form-control', 'placeholder' => "Enter data element")) !!}
                        <small id="emailHelp" class="form-text text-muted">Укажите элемент, содержащий Data</small>
                        @if ($errors->has('dataelement'))
                            <span class="help-block">
                                            <strong>{{ $errors->first('dataelement') }}</strong>
                                        </span>
                        @endif
                    </div>
                    <div class="form-group has-feedback row {{ $errors->has('textelement') ? ' has-error ' : '' }}">
                        <label for="exampleInputEmail1">Text element</label>
                        {!! Form::text('textelement', NULL, array('id' => 'textelement', 'class' => 'form-control', 'placeholder' => "Enter text element")) !!}
                        <small id="emailHelp" class="form-text text-muted">Укажите элемент, содержащий Text</small>
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
                        {!! Form::button('Добавить', array('class' => 'btn btn-primary','type' => 'submit' )) !!}
                        {!! Form::close() !!}
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
        <h2 class="lead">
            Select site:
        </h2>
        <p>
            @foreach ($sites as $site)
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="defaultUnchecked{{$site->id}}" checked>
                <label class="custom-control-label" for="defaultUnchecked{{$site->id}}">{{$site->name}} <code>{{$site->lang}}</code></label>
            </div>
            @endforeach
        </p>
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

        @role('admin')

            <hr>

            <p>
                <button type="button" class="btn btn-outline-primary" onclick="save()">Сохранить изменения</button>
                <button id="parsing-data" type="button" class="btn btn-success" onclick="move()">Сбор данных</button>
                <button onclick="window.location='{{ route("posts") }}'" id="view-data" type="button" class="btn btn-info" hidden>Просмотр данных</button>
            </p>

        @endrole

    </div>
</div>