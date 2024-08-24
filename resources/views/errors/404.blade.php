@extends('layouts.app')

@section('body-class', 'static')

@section('content')
<p style="color: white">404 :/</p>
<p><a style="color: white" href="{{ route('home') }}">Retourner à l'accueil</a></p>
@endsection