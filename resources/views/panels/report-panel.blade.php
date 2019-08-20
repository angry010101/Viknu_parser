@php

    $levelAmount = 'level';

    if (Auth::User()->level() >= 2) {
        $levelAmount = 'levels';

    }

@endphp

<div class="card">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">VIKNU</a></li>
            <li class="breadcrumb-item"><a href="/parser">Сбор новостей</a></li>
            <li class="breadcrumb-item active" aria-current="page">Отчёт</li>
        </ol>
    </nav>
    <div class="card-body">
        <div class="container">
            <div class="card-body">
            </div>
        </div>
        <h1>Test report</h1>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
            cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
            proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
        <button onclick="window.location='{{ route("report.download") }}'" id="view-data" type="button" class="btn btn-info">Скачать</button>
    </div>
</div>