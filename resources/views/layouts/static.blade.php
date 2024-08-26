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

<script>
    const progressBar = document.querySelector('.progressBar');

function fillprogressBar (){
  const windowHeight = window.innerHeight;
  const fullHeight = document.body.clientHeight;
  const scrolled = window.scrollY;
  const percentScrolled = (scrolled / (fullHeight - windowHeight)) * 100;

  progressBar.style.width = percentScrolled + '%';
};

window.addEventListener('scroll', fillprogressBar);
</script>
@endsection