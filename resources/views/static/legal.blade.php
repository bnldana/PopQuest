@extends('layouts.static')

@section('title', __('messages.legal_title'))

@section('pageContent')
    <h1>{{ __('messages.legal_title') }}</h1>

    <p>{{ __('messages.legal_intro') }}</p>

    <h2>{{ __('messages.site_editor_title') }}</h2>
    <p>{!! __('messages.site_editor') !!}</p>

    <h2>{{ __('messages.hosting_title') }}</h2>
    <p>{!! __('messages.hosting') !!}</p>

    <h2>{{ __('messages.site_purpose_title') }}</h2>
    <p>{{ __('messages.site_purpose') }}</p>

    <h2>{{ __('messages.intellectual_property_title') }}</h2>
    <p>{{ __('messages.intellectual_property') }}</p>

    <h2>{{ __('messages.privacy_respect_title') }}</h2>
    <p>{{ __('messages.privacy_respect') }}</p>

    <h2>{{ __('messages.legal_modification_title') }}</h2>
    <p>{{ __('messages.legal_modification') }}</p>

    <h2>{{ __('messages.applicable_law_title') }}</h2>
    <p>{{ __('messages.applicable_law') }}</p>
@endsection
