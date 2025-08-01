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
    <div class="w-full flex justify-center mt-20 items-center m-auto">
        @yield('content')
    </div>
    <footer>
        @include('client.layouts.partials.footer')
    </footer>
    @include('client.components.elements.modal-ai')
    @include('client.layouts.partials.script')
</body>

</html>
