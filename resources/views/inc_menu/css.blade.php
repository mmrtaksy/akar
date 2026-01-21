@if(env('IS_LOCAL'))
    <link rel="stylesheet" href="{{ Request::root() . mix('css/app.css') }}">
@else
    <link rel="stylesheet" href="{{ Request::root() . '/public' . mix('css/app.css') }}">
@endif



<style>
    .wrapper_content * {
        margin: revert;
        font-family: revert;
        font-size: revert;
        list-style: revert;
        padding: revert;
        word-break: initial;
        word-spacing: normal;
        word-wrap: break-word;
    }

    .menu-content {
        max-height: 0;
        opacity: 0;
        overflow: hidden;
        transition: all 0.4s ease;
    }

    .menu-content.active {
        max-height: 10000px;
        opacity: 1;
    }

    @keyframes fade-in {
        from {
            opacity: 0;
            transform: scale(0.95);
        }

        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    .animate-fade-in {
        animation: fade-in 0.3s ease-out forwards;
    }
</style>

@stack('styles')