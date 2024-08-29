@extends('layouts.app')

@section('body-class', 'static')

@section("body-id", "error")

@section('content')
<h1 style="color: white">Cette page n'existe pas</h1>
<p><a style="color: white" href="{{ app()->getLocale() == 'en' ? url('/en') : url('/') }}">Retourner à l'accueil</a></p>
@endsection