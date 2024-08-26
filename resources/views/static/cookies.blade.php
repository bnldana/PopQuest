@extends('layouts.static')

@section('title', __('messages.Cookies'))

@section('pageContent')
    <h1>{{ __('messages.Cookies') }}</h1>
    <p>{{ __('messages.cookies_intro') }}</p>

    <h2>{{ __('messages.what_is_cookie_title') }}</h2>
    <p>{{ __('messages.what_is_cookie') }}</p>

    <h2>{{ __('messages.how_we_use_cookies_title') }}</h2>
    <p>{{ __('messages.how_we_use_cookies') }}</p>
    <ul>
        <li>{{ __('messages.how_we_use_cookies_list_1') }}</li>
        <li>{{ __('messages.how_we_use_cookies_list_2') }}</li>
    </ul>

    <h2>{{ __('messages.cookie_types_title') }}</h2>
    <ul>
        <li>{{ __('messages.cookie_types_essential') }}</li>
        <li>{{ __('messages.cookie_types_game') }}</li>
    </ul>

    <h2>{{ __('messages.manage_preferences_title') }}</h2>
    <p>{{ __('messages.manage_preferences') }}</p>

    <h2>{{ __('messages.your_rights_title') }}</h2>
    <p>{{ __('messages.your_rights') }}</p>

    <p>{{ __('messages.update_policy') }}</p>
@endsection