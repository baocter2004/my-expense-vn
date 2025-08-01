<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'MyExpenseVn')</title>
    @include('client.layouts.partials.css')
</head>

<body class="wrapper">
    <header>
        @include('client.layouts.partials.header')
    </header>
    <div class="w-full px-5 md:px-20 mx-auto mt-20 overflow-x-hidden">
        @include('client.components.elements.breadcrumb', ['items' => $breadcrumb ?? []])
        @yield('content')
        <div id="preloader"
            class="fixed inset-0 z-50 bg-white flex items-center justify-center transition-opacity duration-300">
            <div class="w-12 h-12 border-4 border-dashed border-teal-500 rounded-full animate-spin"></div>
        </div>
    </div>
    @include('client.components.elements.modal-ai')
    <footer>
        @include('client.layouts.partials.footer')
    </footer>
    <script>
        $(window).on('load', function() {
            $('#preloader').fadeOut(200);
        });
    </script>
    @include('client.layouts.partials.script')
</body>

</html>
