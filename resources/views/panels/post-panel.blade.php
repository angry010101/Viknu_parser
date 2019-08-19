@php

    $levelAmount = 'level';

    if (Auth::User()->level() >= 2) {
        $levelAmount = 'levels';

    }

@endphp

<script>
    function sentiment() {

        let text = document.getElementById('post_text').innerText;
        console.log(text);

        $.ajax({
            url:'/sentiment',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            },
            data: {
                'text' : text,
                'post' : '{{$post->id}}'
            },

        }).done(function (data) {
            if(data) {
                location.reload();
            }else {
                alert('Произошла ошибка, перезагрузите страницу!')
            }
        });

    }
</script>

<style>

</style>

<div class="card">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">VIKNU</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="{{ url('/parser') }}">Parser</a></li>
            <li class="breadcrumb-item active" aria-current="page">Posts</li>
        </ol>
    </nav>
    <div class="card-body">
        <div class="jumbotron jumbotron-fluid">
            <div class="container">
                <h1 class="display-8">{{$post->title}}</h1>
                <P><code>{{$post->date}} --- {{$post->site}}</code></P>
                <p id="post_text">{{$post->text}}</p>
                @if ($post->tonality == 0)
                    <div style="cursor: pointer;" class="alert alert-secondary col-5" onclick="sentiment()" role="alert">
                        <center>Тональность не определена</center>
                    </div>
                @endif
                @if ($post->tonality == 1)
                    <div class="alert alert-info col-5" role="alert">
                        <center>Тональность нейтральная</center>
                    </div>
                @endif
                @if ($post->tonality == 2)
                    <div class="alert alert-success col-5" role="alert">
                        <center>Тональность позитивная</center>
                    </div>
                @endif
                @if ($post->tonality == 3)
                    <div class="alert alert-danger col-5" role="alert">
                        <center>Тональность негативная</center>
                    </div>
                @endif
                @if ($post->tonality >= 4)
                    <div class="alert alert-light col-5" role="alert">
                        <center>Ошибка определения тональности</center>
                    </div>
                @endif
                <button onclick="window.location='{{ url('/posts', $post->id + 1) }}'" id="view-data" type="button" class="btn btn-info">Следующая новость</button>
            </div>
        </div>
    </div>
</div>
