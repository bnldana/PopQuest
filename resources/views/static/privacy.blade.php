@extends('layouts.static')

@section('title', __('messages.privacy_title'))

@section('pageContent')
    <h1>{{ __('messages.privacy_title') }}</h1>
    <p>{{ __('messages.privacy_intro') }}</p>

    <h2>{{ __('messages.data_controller_title') }}</h2>
    <p>{{ __('messages.data_controller') }}</p>

    <h2>{{ __('messages.data_collection_title') }}</h2>
    <p>{{ __('messages.data_collection') }}</p>

    <h2>{{ __('messages.purpose_of_processing_title') }}</h2>
    <p>{{ __('messages.purpose_of_processing') }}</p>

    <h2>{{ __('messages.legal_basis_title') }}</h2>
    <p>{{ __('messages.legal_basis') }}</p>

    <h2>{{ __('messages.user_rights_title') }}</h2>
    <p>{{ __('messages.user_rights') }}</p>

    <h2>{{ __('messages.data_security_title') }}</h2>
    <p>{{ __('messages.data_security') }}</p>
@endsection
