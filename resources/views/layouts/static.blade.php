@extends('layouts.app')

@section('body-class', 'static')

@section('content')
<div id="colorOverlay2"></div>
<main>
    <div class="container">
        <div class="content">
            @yield('pageContent')
        </div>
        <div class="container-shadow"></div>
    </div>
</main>
@endsection