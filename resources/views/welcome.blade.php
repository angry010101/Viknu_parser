<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>VIKNU Parsing</title>

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .title small {
                font-size: 60px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @if (Auth::check())
                        <a href="{{ url('/parser') }}">Сбор новостей</a>
                        <a class="dropdown-item {{ Request::is('profile/'.Auth::user()->name, 'profile/'.Auth::user()->name . '/edit') ? 'active' : null }}" href="{{ url('/profile/'.Auth::user()->name) }}">
                            {!! trans('titles.profile') !!}
                        </a>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @else
                        <a href="{{ url('/login') }}">Вход</a>
                        <a href="{{ url('/register') }}">Регистрация пользователя</a>
                    @endif
                </div>
            @endif
            <div class="content">
                <div class="title m-b-md">
                    <div class="text-center">
                        <img src="/images/viknu_logo.png" class="rounded" alt="...">
                    </div>
                    {!! trans('titles.app') !!}<br />
                    <small>
                        {{ trans('titles.app2', ['version' => config('settings.app_project_version')]) }}
                    </small>

                </div>
                <div class="links">
                    @if (Route::has('login'))
                        @if (Auth::check())
                    <a href="{{ url('/parser') }}">Сбор новостей</a>
                    <a href="{{ url('/posts') }}">Новости</a>
                    @else
                    <a href="{{ url('/login') }}">Вход</a>
                    <a href="{{ url('/register') }}">Регистрация пользователя</a>
                    @endif
                    @endif
                </div>
            </div>
        </div>
    </body>
</html>
