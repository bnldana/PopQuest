<div class="js-cookie-consent cookie-consent fixed-bottom bg-warning py-2 z-50">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div class="flex-grow-1">
                <p class="text-dark mb-0 cookie-consent__message">
                    {!! trans('cookie-consent::texts.message') !!}
                </p>
            </div>
            <div class="ml-3">
                <button class="js-cookie-consent-agree cookie-consent__agree btn btn-sm btn-warning text-dark font-weight-bold">
                    {{ trans('cookie-consent::texts.agree') }}
                </button>
            </div>
        </div>
    </div>
</div>