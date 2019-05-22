@extends('layouts.app')

@section('template_title')
    Posts Page
@endsection

@section('template_fastload_css')
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-12">

                @include('panels.posts-panel')

            </div>
        </div>
    </div>

@endsection

@section('footer_scripts')
@endsection
