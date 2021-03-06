@php

    $levelAmount = 'level';

    if (Auth::User()->level() >= 2) {
        $levelAmount = 'levels';

    }

@endphp

<style>

</style>

<script>

    function labelPostSentiment(postId, sentiment) {
        $.ajax({
            url:'/label_post_sentiment',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            },
            data: {
                'sentiment' : sentiment,
                'post' : postId
            },
        }).done(function (data) {
            if(data) {
                location.reload();
            }else {
                alert('Произошла ошибка, перезагрузите страницу!')
            }
        }).fail(data => {
                alert('Произошла ошибка, перезагрузите страницу!')
        })
    }

</script>

<div class="card">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">VIKNU</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="{{ url('/parser') }}">Parser</a></li>
            <li class="breadcrumb-item active" aria-current="page">Posts</li>
        </ol>
    </nav>
    <div class="card-body">
        {{-- <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon3">Поиск</span>
            </div>
            <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3">
        </div>
        <div> --}}
        {{-- <button type="button" class="btn btn-outline-secondary">Неопределена</button>
        <button type="button" class="btn btn-outline-info active">Нейтральная</button>
        <button type="button" class="btn btn-outline-success">Позитивная</button>
        <button type="button" class="btn btn-outline-danger">Негативная</button>
        <button type="button" class="btn btn-outline-light">Ошибка</button> --}}
        </div>
        <div class="jumbotron jumbotron-fluid">
            @foreach($posts as $post)
            <div class="container pb-5">
                <h1 class="display-8">{{$post->title}}</h1>
                <p>{{$post->text}}</p>
                {{-- @if ($post->tonality == 0)
                    <div class="alert alert-secondary col-5" role="alert">
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
                @endif --}}
                {{-- <button onclick="window.location='{{ url('/parser/posts', $post->id) }}'" id="view-data" type="button" class="btn btn-info mr-5">Посмотреть</button> --}}
                
                <button onclick="labelPostSentiment({{$post->id}}, '-1')" id="label-post-neg" type="button" class="btn btn-outline-danger {{ $post->manual_tonality === '-1' ? 'active' : '' }}">Негативная</button>
                <button onclick="labelPostSentiment({{$post->id}}, '0')" id="label-post-net" type="button" class="btn btn-outline-info {{ $post->manual_tonality === '0' ? 'active' : '' }}">Нейтральная</button>
                <button onclick="labelPostSentiment({{$post->id}}, '1')" id="label-post-pos" type="button" class="btn btn-outline-success {{ $post->manual_tonality === '1' ? 'active' : '' }}">Позитивная</button>
            </div>
            @endforeach
                {{ $posts->links() }}
        </div>
    </div>
</div>
